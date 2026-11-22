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

try {
    require_once __DIR__ . '/../config/db.php';
} catch (Throwable $e) {
    fail('Không kết nối được cơ sở dữ liệu.', 500);
}

function readJson(): array
{
    $d = json_decode(file_get_contents('php://input'), true);
    return is_array($d) ? $d : [];
}

// Kiểm tra dữ liệu sản phẩm, trả về [name, price, quantity]
function validateProduct(array $in): array
{
    $name = trim((string)($in['name'] ?? ''));
    if ($name === '' || mb_strlen($name) > 255) {
        fail('Tên sản phẩm không được trống và tối đa 255 ký tự.');
    }
    $price = $in['price'] ?? null;
    if (!is_numeric($price) || $price < 0) {
        fail('Giá phải là số không âm.');
    }
    $qty = $in['quantity'] ?? null;
    if (filter_var($qty, FILTER_VALIDATE_INT) === false || (int)$qty < 0) {
        fail('Số lượng phải là số nguyên không âm.');
    }
    return [$name, (float)$price, (int)$qty];
}

function deleteImageFile(?string $path): void
{
    if ($path && strpos($path, 'uploads/') === 0) {
        $file = __DIR__ . '/../uploads/' . basename($path);
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    // ---------- GET: danh sách có phân trang ----------
    if ($method === 'GET') {
        $pageRaw = $_GET['page'] ?? '1';
        $limitRaw = $_GET['limit'] ?? '5';

        if (!is_string($pageRaw) || !ctype_digit($pageRaw) || (int)$pageRaw < 1) {
            fail('Tham số page phải là số nguyên dương.');
        }
        if (!is_string($limitRaw) || !ctype_digit($limitRaw) || (int)$limitRaw !== 5) {
            fail('Tham số limit phải bằng 5.');
        }
        $page = (int)$pageRaw;
        $limit = 5;

        $total = (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
        $totalPages = max(1, (int)ceil($total / $limit));
        if ($page > $totalPages) {
            $page = $totalPages;           // vượt trang cuối -> trả trang cuối
        }
        $offset = ($page - 1) * $limit;

        $stmt = $pdo->prepare('SELECT id, name, price, quantity, image FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        respond([
            'success' => true,
            'data' => $stmt->fetchAll(),
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $totalPages,
            ],
        ]);
    }

    // ---------- POST: thêm sản phẩm (JSON) ----------
    if ($method === 'POST') {
        [$name, $price, $qty] = validateProduct(readJson());
        $stmt = $pdo->prepare('INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$name, $price, $qty]);
        respond([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công.',
            'id' => (int)$pdo->lastInsertId(),   // Vue dùng id này để upload ảnh
        ], 201);
    }

    // ---------- PUT: sửa sản phẩm (JSON) - không đụng tới cột image ----------
    if ($method === 'PUT') {
        $in = readJson();
        $id = filter_var($in['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            fail('Mã sản phẩm không hợp lệ.');
        }
        [$name, $price, $qty] = validateProduct($in);
        $chk = $pdo->prepare('SELECT id FROM products WHERE id = ?');
        $chk->execute([$id]);
        if (!$chk->fetch()) {
            fail('Sản phẩm không tồn tại.', 404);
        }
        $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?');
        $stmt->execute([$name, $price, $qty, $id]);
        respond(['success' => true, 'message' => 'Cập nhật sản phẩm thành công.', 'id' => $id]);
    }

    // ---------- DELETE: xóa sản phẩm ----------
    if ($method === 'DELETE') {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            fail('Mã sản phẩm không hợp lệ.');
        }
        $stmt = $pdo->prepare('SELECT image FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            fail('Sản phẩm không tồn tại.', 404);
        }
        $pdo->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
        deleteImageFile($row['image']);
        respond(['success' => true, 'message' => 'Xóa sản phẩm thành công.']);
    }

    fail('Phương thức không được hỗ trợ.', 405);
} catch (PDOException $e) {
    fail('Lỗi cơ sở dữ liệu.', 500);
}
