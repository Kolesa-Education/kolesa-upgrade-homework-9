drop database if exists ShopDB;
create database ShopDB;
use ShopDB;

create table  Adverts ( 	
	id int unsigned  not null  primary key auto_increment,
	title varchar(255) not null,
	description text,
	price int not null default(0),
    category enum('Электроника','Мебель','Транспорт', 'Недвижимость')
);
