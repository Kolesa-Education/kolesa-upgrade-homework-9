create homework-9;

use homework-9;

create table Adverts (
    id int NOT NULL PRIMARY KEY auto_increment(),
    title varchar(80) NOT NULL ,
    description text NOT NULL ,
    price int NOT NULL
);