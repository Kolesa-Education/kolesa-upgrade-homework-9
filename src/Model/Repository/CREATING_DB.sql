CREATE DATABASE adverts_db;
USE adverts_db;

CREATE TABLE adverts(
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(25) NOT NULL,
        description VARCHAR(50) NOT NULL,
        price INT NOT NULL
);