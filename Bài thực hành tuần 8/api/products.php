<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/db.php';

function respond(int $code, array $body): void
{
    http_response_code($code);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

// Kiểm tra và chuẩn hóa dữ liệu; trả về [dữ liệu, lỗi]
function validate($in): array
{
    if (!is_array($in)) {
        return [null, 'Dữ liệu gửi lên phải là JSON hợp lệ.'];
    }
    $name = isset($in['name']) && is_string($in['name']) ? trim($in['name']) : '';
    $len = mb_strlen($name, 'UTF-8');
    if ($len < 1 || $len > 100) {
        return [null, 'Tên sản phẩm phải từ 1 đến 100 ký tự.'];
    }

    $price = filter_var($in['price'] ?? null, FILTER_VALIDATE_INT);
    if ($price === false || $price <= 0) {
        return [null, 'Đơn giá phải là số nguyên lớn hơn 0.'];
    }

    $stock = filter_var($in['stock'] ?? null, FILTER_VALIDATE_INT);
    if ($stock === false || $stock < 0) {
        return [null, 'Số lượng tồn phải là số nguyên không âm.'];
    }
    return [['name' => $name, 'price' => $price, 'stock' => $stock], null];
}

function getId(): ?int
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    return ($id === false || $id === null || $id <= 0) ? null : $id;
}

function exists(PDO $pdo, int $id): bool
{
    $st = $pdo->prepare('SELECT 1 FROM products WHERE id = ?');
    $st->execute([$id]);
    return (bool) $st->fetchColumn();
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($method) {
        case 'GET':
            $rows = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id')->fetchAll();
            respond(200, ['success' => true, 'data' => $rows, 'message' => 'OK']);

        case 'POST':
            [$d, $err] = validate($input);
            if ($err) {
                respond(400, ['success' => false, 'message' => $err]);
            }
            $st = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
            $st->execute([$d['name'], $d['price'], $d['stock']]);
            respond(201, [
                'success' => true,
                'data' => ['id' => (int) $pdo->lastInsertId()] + $d,
                'message' => 'Thêm sản phẩm thành công.',
            ]);

        case 'PUT':
            $id = getId();
            if ($id === null) {
                respond(400, ['success' => false, 'message' => 'Thiếu hoặc sai id sản phẩm.']);
            }
            [$d, $err] = validate($input);
            if ($err) {
                respond(400, ['success' => false, 'message' => $err]);
            }
            if (!exists($pdo, $id)) {
                respond(404, ['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            }
            $st = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?');
            $st->execute([$d['name'], $d['price'], $d['stock'], $id]);
            respond(200, ['success' => true, 'data' => ['id' => $id] + $d, 'message' => 'Cập nhật sản phẩm thành công.']);

        case 'DELETE':
            $id = getId();
            if ($id === null) {
                respond(400, ['success' => false, 'message' => 'Thiếu hoặc sai id sản phẩm.']);
            }
            $st = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $st->execute([$id]);
            if ($st->rowCount() === 0) {
                respond(404, ['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            }
            respond(200, ['success' => true, 'message' => 'Xóa sản phẩm thành công.']);

        default:
            respond(405, ['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
    }
} catch (PDOException $e) {
    respond(500, ['success' => false, 'message' => 'Lỗi cơ sở dữ liệu.']);
}
