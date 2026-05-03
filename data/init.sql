CREATE DATABASE IF NOT EXISTS bookshop;

    USE bookshop;

    CREATE TABLE IF NOT EXISTS users (
        id        INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30)  NOT NULL,
        lastname  VARCHAR(30)  NOT NULL,
        password  VARCHAR(30)  NOT NULL,
        email     VARCHAR(50)  NOT NULL,
        role       VARCHAR(10) NOT NULL DEFAULT 'user',
        date      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS products (
        id          INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title       VARCHAR(100)  NOT NULL,
        author      VARCHAR(100)  NOT NULL,
        price       DECIMAL(6,2)  NOT NULL,
        description TEXT,
        image       VARCHAR(255)  DEFAULT NULL,
        date        TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
    );

    INSERT INTO products (title, author, price, description) VALUES
    ('Atomic Habits',       'James Clear', 29.99,
        'Small Habits, Big Wins - Transform your live'),
    ('The let them theory',  'Mel Robbins',          15.99,
        'A simple mindset shift with real impact.'),
    ('Manifest',                   'Roxie Nafousi',        21.99,
        '7 steps tp living your best life.'),
    ('The Gruffalo',    'Julia Donaldosn',          9.99,
        'A little mouse story...'),
    ('Harry Potter: the complete collection box',             'J.K. Rowling',      80.99,
        'Special edition of all seven books in one set');
