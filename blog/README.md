# TASK FOR ENCOMAGE

You need to create a page where any visitor will be able to leave a post, rate the post and leave a comment to the post.

## Installation DB

```
app\Config.php  - Enter your DB credentials
```

## Sql script for MySql

````
create table if not exists posts
(
    id         bigint auto_increment
        primary key,
    name       varchar(255)                       not null,
    text       text                               not null,
    created_at datetime default CURRENT_TIMESTAMP null,
    rating     int                                null
);

create table if not exists comments
(
    id         bigint auto_increment
        primary key,
    name       varchar(255)                       not null,
    text       text                               not null,
    post_id    bigint                             not null,
    created_at datetime default CURRENT_TIMESTAMP null,
    constraint POSTS_FK
        foreign key (post_id) references posts (id)
);

````

## Usage

cd blog/public

````
php -S localhost:8888
````

