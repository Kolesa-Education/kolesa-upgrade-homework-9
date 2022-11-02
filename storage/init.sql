DROP TABLE IF EXISTS adverts_api;

CREATE DATABASE adverts_api;

USE adverts_api;

DROP TABLE IF EXISTS adverts;

CREATE TABLE category
(
	id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ctry_name VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE adverts
(
	id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(80) NOT NULL,
	description VARCHAR(150) NOT NULL,
	price INT UNSIGNED NOT NULL,
	category_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (category_id) REFERENCES category(id)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);

INSERT INTO category(ctry_name)
VALUES ("Электроника и электротехника"), ("Бытовая техника"), ("Продукты питания"), ("Одежда и обувь"),
	   ("Мебель"), ("Досуг, книги"), ("Жилые дома и помещения"), ("Украшения"), ("Другие");

INSERT INTO adverts(title, description, price, category_id)
VALUES
	("Продам iPhone 8", "Батарейка 100%", 80000, 
	(SELECT id FROM category WHERE ctry_name = "Электроника и электротехника")),
	("Квартира ЖК", "2 комнатная", 50000, 
	(SELECT id FROM category WHERE ctry_name = "Жилые дома и помещения"));