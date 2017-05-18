drop   database board;
create database board;
use board;

create table threads (
  `id` int unsigned primary key auto_increment,
  `name` varchar(128) not null,
  `created_at` timestamp default current_timestamp,
  `updated_at` timestamp default current_timestamp on update current_timestamp
);

create table messages (
  `id` int unsigned primary key auto_increment,
  `name` varchar(32) not null default 'NO NAME',
  `body` varchar(256) not null,
  `thread_id` int unsigned,
  `created_at` timestamp default current_timestamp,
  `updated_at` timestamp default current_timestamp on update current_timestamp,

  foreign key(`thread_id`) references `threads`(`id`)
);
