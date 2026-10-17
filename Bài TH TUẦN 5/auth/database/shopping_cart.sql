CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- Reset sample data so importing this script produces exactly five sample products.
DELETE FROM products;
ALTER TABLE products AUTO_INCREMENT = 1;

INSERT INTO products (name, price, quantity) VALUES
('Laptop Dell Inspiron', 15990000.00, 10),
('Chuột không dây Logitech', 450000.00, 35),
('Bàn phím cơ Keychron', 1890000.00, 12),
('Màn hình LG 24 inch', 3290000.00, 8),
('Tai nghe Sony WH-CH520', 1290000.00, 20);


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Tài khoản mẫu: admin / admin123 (mật khẩu đã băm bằng password_hash)
INSERT IGNORE INTO users (username, password) VALUES
('admin', '$2y$10$abcdefghijklmnopqrstuuEZ4tpXm4W5SeJkDbuNdfJ.CF0.Wc2V2');
