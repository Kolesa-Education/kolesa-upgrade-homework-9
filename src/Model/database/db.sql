create database hw;
use hw;

create table dbtable(
    id int not null auto_increment primary key ,
    title varchar(255) not null ,
    description text not null ,
    price int not null default (0)
);

insert into dbtable( title, description, price)
values ('10 Phone', 'nice', 456);

insert into dbtable( title, description, price)
values ('Samsung 78', 'good', 111);

select *  from dbtable;


drop table dbtable;