CREATE DATABASE kolesa;
USE kolesa;
CREATE TABLE adverts(
    id int primary key auto_increment,
    title varchar(100) not null ,
    description text not null ,
    price int not null
);