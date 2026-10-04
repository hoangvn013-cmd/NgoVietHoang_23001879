CREATE DATABASE cinema_management;

USE cinema_management;

CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Inception', 105000, 100, 75),
('Interstellar', 130000, 90, 60),
('Joker', 95000, 120, 110),
('Iron Man', 115000, 80, 35),
('The Batman', 100000, 70, 25);


SELECT * FROM movies;


SELECT *
FROM movies
WHERE price > 100000;


SELECT *
FROM movies
WHERE available_seats > 50;


SELECT *
FROM movies
ORDER BY price DESC;


UPDATE movies
SET available_seats = 70
WHERE title = 'Inception';

SELECT * FROM movies;

DELETE FROM movies
WHERE title = 'Joker';

SELECT * FROM movies;


SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_seats
FROM movies;


SELECT
    title,
    price,
    total_seats - available_seats AS sold_seats,
    (total_seats - available_seats) * price AS revenue
FROM movies;


SELECT
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;


SELECT
    id,
    title,
    price,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_seats
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);