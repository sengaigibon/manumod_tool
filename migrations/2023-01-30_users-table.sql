create table Users
(
    id int auto_increment,
    name varchar(255) not null,
    email varchar(190) not null,
    token text null,
    lastLogin datetime null,
    constraint Users_pk
        primary key (id)
)
    comment 'Users for the ManuMod Tool';

create unique index Users_email_uindex
    on Users (email);