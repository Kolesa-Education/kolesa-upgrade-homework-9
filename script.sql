CREATE DATABASE advertsdb;

USE advertsdb;

CREATE TABLE 
	adverts (
	    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
		`title` VARCHAR(150) NOT NULL,
		`description` text,
	    `price` INT DEFAULT(0)
	);

INSERT INTO
    adverts (
        title,
        description,
        price
    )
VALUES (
        'Игровой системный блок Lenovo Legion Y5',
        'Мощный системный блок из современного железа для любителей горячих новинок, насладитесь геймингом с плавной картинкой на УЛЬТРА настройках.',
        1690000
    ), (
        'Офисный системный блок AVALON E500',
        'Идеальная сборка для тех, кто любит когда сложные задачи выполняются без тормозов со стороны железа.',
        480000
    ), (
        'Смартфон Samsung A51 3/32',
        'Обычновенный смартфон, не флагман и не бюджетная версия, золотая середина.',
        89000
    );