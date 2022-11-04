CREATE DATABASE adverts;
USE adverts;
CREATE TABLE advert(
                       id int primary key auto_increment,
                       title varchar(100) not null ,
                       description text not null ,
                       price int not null
);