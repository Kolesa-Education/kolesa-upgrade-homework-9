CREATE DATABASE adverts;

USE adverts;

CREATE TABLE adverts (
	id int UNSIGNED PRIMARY KEY auto_increment,
	title varchar(150) NOT NULL,
	description text NOT NULL,
	price int NOT NULL
);
