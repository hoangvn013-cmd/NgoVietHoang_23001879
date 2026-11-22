<?php
header('Content-Type: application/json; charset=utf-8');

function respond(array $data, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function fail(string $msg, int $code = 400): void
{
    respond(['success' => false, 'message' => $msg], $code);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Chỉ chấp nhận phương thức POST.', 405);
}

const MAX_SIZE = 2 * 1024 * 1024;               // 2 MB
const ALLOWED = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

// Body vượt post_max_size -> PHP bỏ trống $_POST và $_FILES
if (empty($_FILES) && empty($_POST) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    fail('File quá lớn, tối đa 2 MB.', 413);
}

$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
if (!$productId || $productId < 1) {
    fail('Mã sản phẩm không hợp lệ.');
}

if (!isset($_FILES['image']) || !is_array($_FILES['image']) || is_array($_FILES['image']['error'])) {
    fail('Chưa chọn file ảnh.');
}
$file = $_FILES['image'];

switch ($file['error']) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        fail('File quá lớn, tối đa 2 MB.', 413);
    case UPLOAD_ERR_NO_FILE:
        fail('Chưa chọn file ảnh.');
    default:
        fail('Upload thất bại, vui lòng thử lại.', 500);
}

if (!is_uploaded_file($file['tmp_name'])) {
    fail('File upload không hợp lệ.');
}
if ($file['size'] > MAX_SIZE || $file['size'] <= 0) {
    fail('File quá lớn, tối đa 2 MB.', 413);
}

// Kiểm tra loại ảnh THỰC TẾ (nội dung file), không tin đuôi file hay type do client gửi
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
if (!isset(ALLOWED[$mime]) || @getimagesize($file['tmp_name']) === false) {
    fail('Chỉ chấp nhận ảnh JPG, JPEG hoặc PNG.', 415);
}

try {
    require_once __DIR__ . '/../config/db.php';

    // Kiểm tra sản phẩm tồn tại
    $stmt = $pdo->prepare('SELECT image FROM products WHERE id = ?');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
    if (!$product) {
        fail('Sản phẩm không tồn tại.', 404);
    }

    // Tạo tên file duy nhất và lưu vào thư mục uploads
    $dir = __DIR__ . '/../uploads';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        fail('Không tạo được thư mục uploads.', 500);
    }
    $filename = 'product_' . $productId . '_' . bin2hex(random_bytes(8)) . '.' . ALLOWED[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
        fail('Không lưu được file ảnh.', 500);
    }

    // Chỉ cập nhật đường dẫn khi đã lưu file thành công
    $path = 'uploads/' . $filename;
    try {
        $pdo->prepare('UPDATE products SET image = ? WHERE id = ?')->execute([$path, $productId]);
    } catch (PDOException $e) {
        @unlink($dir . '/' . $filename);      // rollback file, giữ nguyên ảnh cũ
        fail('Không cập nhật được đường dẫn ảnh.', 500);
    }

    // Xóa ảnh cũ sau khi mọi thứ thành công
    if (!empty($product['image']) && strpos($product['image'], 'uploads/') === 0) {
        $old = $dir . '/' . basename($product['image']);
        if (is_file($old)) {
            @unlink($old);
        }
    }

    respond(['success' => true, 'message' => 'Upload ảnh thành công.', 'image' => $path]);
} catch (PDOException $e) {
    fail('Lỗi cơ sở dữ liệu.', 500);
}
