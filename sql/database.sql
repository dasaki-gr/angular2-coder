create table if not exists `[prefix]settings` (
  `key` varchar(50) not null,
  `value` text not null,
  primary key(`key`)
);
-- create table if not exists `[prefix]pages` (
--   `page` varchar(50) not null,
--   `selector` text not null,
--   primary key(`page`)
-- );
