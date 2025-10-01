create database digital_web;

use digital_web;

create table user(
    user_id varchar(9) not null primary key,
    email varchar(60) not null unique,
    username varchar(100),
    password varchar(255) not null,
    role enum('ADMIN','SUPER_ADMIN','USER')
)Engine=innodb;


create table article(
    article_id varchar(15) not null primary key,
    title varchar(255) not null,
    slug varchar(125) not null,
    publish_status boolean,
    date_publish date,
    date_updated date,
    description text,
    file_content text,
    file_thumbnail text,
    user_id varchar(9) null,
    foreign key (user_id) references user(user_id) on delete set null
)Engine=innodb;






