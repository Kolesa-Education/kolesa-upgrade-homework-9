create table adverts
(
    id          int    not null,
    title       text   not null,
    description text   not null,
    price       float8 not null,
    constraint adverts_pk
        primary key (id)
);

alter table adverts
    modify id int auto_increment;

create table categories
(
    id            int auto_increment
        primary key,
    category_name text not null
);

alter table adverts
    add constraint adverts_categories_null_fk
        foreign key (category_id) references categories (id);