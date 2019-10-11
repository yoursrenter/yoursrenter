-- база your_renter

drop database if exists your_renter;
create database your_renter;
use your_renter;

drop table if exists users;
create table users(
	id serial primary key, 
	firstname VARCHAR(100) comment 'Имя',
	lastname VARCHAR(100)  comment 'Фамилия',
	email VARCHAR(120) unique comment 'эл.почта',
	password_hash VARCHAR(100) comment 'хэш пароля',
	phone bigint comment 'телефон',
	index (phone),
	index (firstname, lastname)
);

drop table if exists objects;
create table objects(
	id serial primary key,
	name VARCHAR(20),
	address VARCHAR(20),
	legal_address VARCHAR(20),	
	owner BIGINT unsigned not null,
	type 
	created_at DATETIME default now(),
	index(id),
	index(name),
	index(owner),
	
	foreign key (owner) references users(id)
);

drop table if exists services;
create table services(
	id serial primary key,
	name ENUM('production', 'stock', 'office', 'land')
);

drop table if exists objects_services;
create table objects_services(
	object_id BIGINT unsigned not null,
	service_id BIGINT unsigned not null,
	index(object_id, service_id),
	foreign key (object_id) references objects(id),
	foreign key (service_id) references services(id)
);

drop table if exists contracts;
create table contracts(
	id serial primary key,
	
	object_id BIGINT unsigned not null,
	tenant_id BIGINT unsigned not null,
	landlord_id BIGINT unsigned not null,
	
	status ENUM('active', 'unsigned', 'rejective'),

 	created_at DATETIME default now(),
 	terminated_at DATETIME,
 	summ double unsigned not null,
 	payment_date DATETIME,
 	
	index (id),
	index (object_id),
	index (landlord_id),
	index (tenant_id),
	
	foreign key (landlord_id) references users(id),
	foreign key (tenant_id) references users(id),
	foreign key (object_id) references objects(id)
);

drop table if exists finance_tables;
create table finance_tables(
	id serial primary key,
	name VARCHAR(15),
	contract_id BIGINT unsigned not null,
	rent double unsigned not null,
	status ENUM('paid', 'not paid'),
	debt double unsigned not null,
	
	created_at DATETIME default now(),
	
	foreign key (contract_id) references contracts(id)
);