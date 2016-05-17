create database if not exists unicorn character set utf8 collate utf8_unicode_ci;

use unicorn;


grant all privileges on unicorn.* to 'unicorn_user'@'localhost' identified by 'secret';