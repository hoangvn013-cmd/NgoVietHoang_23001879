CREATE DATABASE IF NOT EXISTS product_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE product_db;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL
);

-- Nếu bảng products ĐÃ CÓ từ buổi trước, chỉ cần chạy dòng này (bỏ phần CREATE TABLE):
-- ALTER TABLE products ADD COLUMN image VARCHAR(255) NULL;

-- Dữ liệu mẫu: 12 sản phẩm (chỉ chạy khi bảng đang trống)
INSERT INTO products (name, price, quantity) VALUES
('Laptop Dell Inspiron', 15990000, 10),
('Chuột Logitech M331', 250000, 50),
('Bàn phím cơ Keychron K2', 1890000, 20),
('Màn hình LG 24 inch', 3490000, 15),
('Tai nghe Sony WH-1000XM4', 6290000, 8),
('Webcam Logitech C920', 1590000, 25),
('Ổ cứng SSD Samsung 500GB', 1390000, 30),
('USB Kingston 64GB', 150000, 100),
('Loa JBL Flip 5', 2490000, 12),
('Router TP-Link AX1800', 1190000, 18),
('Balo laptop Xiaomi', 450000, 40),
('Sạc dự phòng Anker 10000mAh', 650000, 35);
