create database kolesaUpgrade;

use kolesaUpgrade;
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
create table adverts (
	id int unsigned primary key auto_increment,
	header varchar(50) not null,
	description text not null,
	price int not null default(0) 
);

show tables;

insert into adverts (header, description, price)
	values ("Продам iPhone 8", "Батарейка 100%", 80000)
	
select * from adverts;
delete from adverts where id = 3; 
	





