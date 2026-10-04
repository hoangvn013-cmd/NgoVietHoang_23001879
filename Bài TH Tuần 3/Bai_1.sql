CREATE DATABASE shopping_cart;

USE shopping_cart;

CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO cart_items (name, price, quantity) VALUES
('Laptop', 18000000, 1),
('Mouse', 250000, 7),
('Keyboard', 650000, 4),
('Headphone', 900000, 6),
('USB', 120000, 10);


SELECT * FROM cart_items;


SELECT *
FROM cart_items
WHERE price > 100000;


SELECT *
FROM cart_items
WHERE quantity > 5;


SELECT *
FROM cart_items
ORDER BY price DESC;


UPDATE cart_items
SET price = 280000
WHERE name = 'Mouse';


UPDATE cart_items
SET quantity = 5
WHERE name = 'Keyboard';


DELETE FROM cart_items
WHERE name = 'USB';


SELECT
    name,
    price,
    quantity,
    price * quantity AS thanh_tien
FROM cart_items;


SELECT
    SUM(price * quantity) AS tong_tien
FROM cart_items;