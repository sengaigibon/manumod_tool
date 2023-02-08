create table AuditLog
(
    id int auto_increment,
    entityType varchar(255) null,
    entityId int null,
    createdAt DATETIME null,
    userId int null,
    action varchar(255) null,
    requestRoute varchar(255) null,
    eventData json null,
    ipAddress varchar(200) null
);

create unique index AuditLog_id_uindex
    on AuditLog (id);

alter table AuditLog
    add constraint AuditLog_pk
        primary key (id);

alter table AuditLog
    drop column requestRoute;

