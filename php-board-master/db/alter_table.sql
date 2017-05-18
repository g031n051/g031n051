alter table `board`.`threads`  add `uuid` char(18) not null after `id`;
alter table `board`.`messages` add `uuid` char(18) not null after `id`;
