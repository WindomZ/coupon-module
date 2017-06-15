DROP SCHEMA IF EXISTS coupondb;

CREATE SCHEMA coupondb CHARACTER SET utf8 COLLATE utf8_general_ci;

create table coupondb.cp_coupon
(
	id char(36) not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(32) default '' not null,
	active tinyint(1) default '1' not null,
	level int default '0' not null,
	`desc` varchar(256) default '' not null,
	owner_id char(36) not null,
	activity_id char(36) not null,
	template_id char(36) not null,
	pack_id char(36) not null,
	batch_id char(36) not null,
	class int default '0' not null,
	kind int default '0' not null,
	product_id varchar(36) default '' not null,
	min_amount decimal(10,2) default '0.00' not null,
	offer_amount decimal(10,2) default '0.00' not null,
	used_count int default '0' not null,
	used_time datetime default CURRENT_TIMESTAMP not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint cp_coupon_id_uindex
		unique (id)
)
;

create table coupondb.cp_coupon_activity
(
	id char(36) not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(32) default '' not null,
	active tinyint(1) default '1' not null,
	level int default '0' not null,
	`desc` varchar(256) default '' not null,
	url varchar(256) default '' not null,
	class int default '0' not null,
	kind int default '0' not null,
	coupon_size int default '0' not null,
	coupon_used int default '0' not null,
	coupon_limit int default '0' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint cp_coupon_activity_id_uindex
		unique (id)
)
;

create table coupondb.cp_coupon_batch
(
	id char(36) not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	owner_id char(36) not null,
	activity_id char(36) not null,
	template_id char(36) not null,
	pack_id char(36) not null,
	constraint cp_coupon_batch_id_uindex
		unique (id)
)
;

create table coupondb.cp_coupon_pack
(
	id char(36) not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(32) default '' not null,
	active tinyint(1) default '1' not null,
	level int default '0' not null,
	`desc` varchar(256) default '' not null,
	activity_id char(36) not null,
	template_id char(36) not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint cp_coupon_pack_id_uindex
		unique (id)
)
;

create table coupondb.cp_coupon_template
(
	id char(36) not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(32) default '' not null,
	active tinyint(1) default '1' not null,
	level int default '0' not null,
	`desc` varchar(256) default '' not null,
	class int default '0' not null,
	kind int default '0' not null,
	product_id varchar(36) default '' not null,
	min_amount decimal(10,2) default '0.00' not null,
	offer_amount decimal(10,2) default '0.00' not null,
	constraint cp_coupon_template_id_uindex
		unique (id)
)
;

