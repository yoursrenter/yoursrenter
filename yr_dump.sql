-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.43-log - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных your_renter
CREATE DATABASE IF NOT EXISTS `your_renter` /*!40100 DEFAULT CHARACTER SET cp1251 */;
USE `your_renter`;

-- Дамп структуры для таблица your_renter.communications
CREATE TABLE IF NOT EXISTS `communications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) unsigned DEFAULT NULL,
  `communicationtypes` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.communications: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `communications` DISABLE KEYS */;
/*!40000 ALTER TABLE `communications` ENABLE KEYS */;

-- Дамп структуры для таблица your_renter.contracts
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `tenant_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('подписан') DEFAULT NULL,
  `area` float DEFAULT NULL,
  `acceptact_at` datetime DEFAULT NULL,
  `renterobject_id` bigint(20) unsigned DEFAULT NULL,
  `term` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expiration_at` datetime DEFAULT NULL,
  `rate` float unsigned DEFAULT NULL,
  `rent` float unsigned DEFAULT NULL,
  `rentYear` float unsigned DEFAULT NULL,
  `deposit` float unsigned DEFAULT NULL,
  `prepare` float unsigned DEFAULT NULL,
  `gettingcontract_at` datetime DEFAULT NULL,
  `transfercontracttenant_at` datetime DEFAULT NULL,
  `signtenant_at` datetime DEFAULT NULL,
  `transfercopytenant_at` datetime DEFAULT NULL,
  `gettingfromssb_at` datetime DEFAULT NULL,
  `passescount` int(20) unsigned DEFAULT NULL,
  `info` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `renterobject_id` (`renterobject_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`renterobject_id`) REFERENCES `renterobjects` (`id`),
  CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.contracts: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
REPLACE INTO `contracts` (`id`, `name`, `tenant_id`, `status`, `area`, `acceptact_at`, `renterobject_id`, `term`, `created_at`, `expiration_at`, `rate`, `rent`, `rentYear`, `deposit`, `prepare`, `gettingcontract_at`, `transfercontracttenant_at`, `signtenant_at`, `transfercopytenant_at`, `gettingfromssb_at`, `passescount`, `info`) VALUES
	(1, 'СП-182СП-18', 1, 'подписан', 65.11, NULL, 1, 11, '2018-02-15 00:00:00', '2019-01-15 00:00:00', 431.58, 28100, 5178.93, 28100, NULL, NULL, NULL, NULL, NULL, NULL, 2, ''),
	(2, 'СП-118СП-17', 2, 'подписан', 11.1, NULL, 2, 11, '2017-07-15 00:00:00', '2018-06-15 00:00:00', 233.93, 2596.97, 2807.21, 2596.97, NULL, '2017-07-19 00:00:00', '2017-07-19 00:00:00', '2017-07-19 00:00:00', NULL, '2017-07-24 00:00:00', 3, 'по ценам капо. навес'),
	(3, 'СП-118СП-17', 2, 'подписан', 16, NULL, 1, 11, '2017-07-15 00:00:00', '2018-06-15 00:00:00', 419.38, 6710, 5032.5, 6710, NULL, '2017-07-19 00:00:00', '2017-07-19 00:00:00', '2017-07-19 00:00:00', NULL, '2017-07-24 00:00:00', NULL, ''),
	(4, 'СП-7СП-17', 3, 'подписан', 70, NULL, 3, 11, '2017-07-15 00:00:00', '2018-06-15 00:00:00', 380.51, 26635.9, 4566.15, 26635.9, NULL, '2017-07-17 00:00:00', '2017-07-17 00:00:00', '2017-07-24 00:00:00', NULL, '2017-07-24 00:00:00', 2, ''),
	(5, 'СП-181СП-18', 4, 'подписан', 446.58, NULL, 4, 11, '2018-02-01 00:00:00', '2018-12-31 00:00:00', 382, 170594, 4584.01, 170594, NULL, '2017-07-17 00:00:00', '2017-07-25 00:00:00', '2017-07-27 00:00:00', NULL, '2017-08-09 00:00:00', 5, 'новый контрагент'),
	(6, 'СП-180СП-18', 5, 'подписан', 350, NULL, 4, 11, '2018-02-01 00:00:00', '2018-12-31 00:00:00', 382, 133700, 4584.01, 133700, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;

-- Дамп структуры для функция your_renter.getNextPaymentDate
DELIMITER //
CREATE DEFINER=`root`@`%` FUNCTION `getNextPaymentDate`(payment_at DATETIME) RETURNS varchar(20) CHARSET cp1251
BEGIN
	DECLARE res VARCHAR(20) DEFAULT '';
	DECLARE payment_day INT(10);
	DECLARE now_day INT(10);
	DECLARE now_month INT(10);
	DECLARE now_year INT(10);
	SET payment_day = DAY(payment_at);
	SET now_day = DAY(NOW());
	SET now_month = MONTH(NOW());
	SET now_year = YEAR(NOW());
	IF payment_day < now_day AND NOT now_month = 12 THEN
		SET now_month = now_month + 1;
		ELSEIF payment_day < now_day AND now_month = 12 THEN
		SET now_month = 1;
		SET now_year = now_year + 1;
	END IF;
	SET res = CONCAT(payment_day, '.', now_month, '.', now_year);
	RETURN res;
END//
DELIMITER ;

-- Дамп структуры для функция your_renter.getPaymentDate
DELIMITER //
CREATE DEFINER=`root`@`%` FUNCTION `getPaymentDate`() RETURNS varchar(20) CHARSET cp1251
BEGIN
	DECLARE res VARCHAR(20) DEFAULT '';
	SET res = DATE_FORMAT(NOW(),'5.%m.%Y');
	RETURN res;
END//
DELIMITER ;

-- Дамп структуры для таблица your_renter.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) unsigned DEFAULT NULL,
  `payment` float unsigned DEFAULT NULL,
  `payment_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `contract_id` (`contract_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.payments: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

-- Дамп структуры для таблица your_renter.renterobjects
CREATE TABLE IF NOT EXISTS `renterobjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.renterobjects: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `renterobjects` DISABLE KEYS */;
REPLACE INTO `renterobjects` (`id`, `name`) VALUES
	(3, 'ПТ № 16'),
	(1, 'Пт № 17'),
	(4, 'ПТ № 18'),
	(2, 'Сооружение склад неф');
/*!40000 ALTER TABLE `renterobjects` ENABLE KEYS */;

-- Дамп структуры для процедура your_renter.sp_addcontract
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_addcontract`(
	contract_name VARCHAR(50), 
	tenant_id BIGINT(20),
	accept_act_at DATETIME,
	contract_created_at DATETIME,
	getting_act_at DATETIME,
	area FLOAT,
	rent FLOAT,
	deposit FLOAT
)
BEGIN
	INSERT INTO contracts (
	name, 
	tenant_id, 	
	acceptact_at, 
	created_at,
	gettingcontract_at,
	AREA,
	rent,
	deposit
	) VALUES (
	contract_name, 
	tenant_id, 	
	accept_act_at, 
	contract_created_at,
	getting_act_at,
	area,
	rent,
	deposit
	);
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_addtenant
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_addtenant`(
	tenant_name VARCHAR(50), 
	contact_fio VARCHAR(50),
	tenant_phone VARCHAR(20),
	tenant_email VARCHAR(50)
)
BEGIN
	INSERT INTO tenants 
	(`name`, `contact_fio`, `phone`, `email`) 
	VALUES 
	(tenant_name, contact_fio, tenant_phone, tenant_email);
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_savecontract
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_savecontract`(
	contract_name VARCHAR(20), 
	tenant_id BIGINT(20), 
	accept_act_at DATETIME, 
	contract_created_at DATETIME, 
	getting_act_at DATETIME, 
	area FLOAT, 
	rent FLOAT, 
	deposit FLOAT,
	OUT id BIGINT(20)
)
BEGIN
	DECLARE contract_id BIGINT(20);
	SET contract_id = (SELECT id FROM contracts AS c WHERE c.name = contract_name);
	IF contract_id IS NULL THEN
		CALL sp_addcontract(contract_name, tenant_id, accept_act_at, contract_created_at, getting_act_at, area, rent, deposit);
	ELSE
		CALL sp_updatecontract(contract_id, contract_name, tenant_id, accept_act_at, contract_created_at, getting_act_at, area, rent, deposit);
	END IF;
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_savetenant
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_savetenant`(
	tenant_name VARCHAR(50), 
	contact_fio VARCHAR(50),
	tenant_phone VARCHAR(20),
	tenant_email VARCHAR(50),
	OUT out_id BIGINT(20)
)
BEGIN
	DECLARE tenant_id BIGINT(20);
	SET tenant_id = (SELECT id FROM tenants AS t WHERE t.NAME = tenant_name);
	IF tenant_id IS NULL THEN
		CALL sp_addtenant(tenant_name, contact_fio, tenant_phone, tenant_email);
		SET out_id = LAST_INSERT_ID();
	ELSE
		CALL sp_updatetenant(tenant_id,tenant_name, contact_fio, tenant_phone, tenant_email);
		SET out_id = tenant_id;
	END IF;
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_savetenantinfo
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_savetenantinfo`(
	tenant_name VARCHAR(20), 
	contact_fio VARCHAR(50), 
	tenant_phone VARCHAR(20), 
	tenant_email VARCHAR(50), 
	contract_name VARCHAR(20), 
	accept_act_at DATETIME, 
	contract_created_at DATETIME, 
	getting_act_at DATETIME, 
	area FLOAT, 
	rent FLOAT, 
	deposit FLOAT
)
BEGIN
	CALL sp_savetenant(tenant_name,contact_fio, tenant_phone,tenant_email, @t_id);
	CALL sp_savecontract(contract_name, @t_id, accept_act_at, contract_created_at, getting_act_at, area, rent, deposit, @c_id);
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_updatecontract
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_updatecontract`(
	contract_id BIGINT(20),
	contract_name VARCHAR(50), 
	tenant_id BIGINT(20),
	accept_act_at DATETIME,
	contract_created_at DATETIME,
	getting_act_at DATETIME,
	area FLOAT,
	rent FLOAT,
	deposit FLOAT
)
BEGIN
	UPDATE contracts SET 
	`name` = contract_name, 
	`tenant_id` = tenant_id,
	`acceptact_at` = accept_act_at,
	`created_at` = contract_created_at,
	`gettingcontract_at` = getting_act_at,
	`area` = area,
	`rent` = rent, 
	`deposit` = deposit
	WHERE id = contract_id;
END//
DELIMITER ;

-- Дамп структуры для процедура your_renter.sp_updatetenant
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_updatetenant`(
	tenant_id BIGINT(20),
	tenant_name VARCHAR(50), 
	contact_fio VARCHAR(50),
	tenant_phone VARCHAR(20),
	tenant_email VARCHAR(50)
)
BEGIN
	UPDATE tenants SET 
		`name` = tenant_name,
		`contact_fio` = contact_fio,
		`phone` = tenant_phone,
		`email` = tenant_email
	WHERE id = tenant_id;
END//
DELIMITER ;

-- Дамп структуры для таблица your_renter.tenantactivities
CREATE TABLE IF NOT EXISTS `tenantactivities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.tenantactivities: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `tenantactivities` DISABLE KEYS */;
REPLACE INTO `tenantactivities` (`id`, `name`) VALUES
	(3, 'cкладирование ТМЦ'),
	(1, 'мастерская'),
	(2, 'хранение ТНП');
/*!40000 ALTER TABLE `tenantactivities` ENABLE KEYS */;

-- Дамп структуры для таблица your_renter.tenants
CREATE TABLE IF NOT EXISTS `tenants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `contact_fio` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `service_info` varchar(20) DEFAULT NULL,
  `tenantactivity_id` bigint(20) unsigned DEFAULT NULL,
  `legaladdress` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  KEY `tenantactivity_id` (`tenantactivity_id`),
  CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`tenantactivity_id`) REFERENCES `tenantactivities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.tenants: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
REPLACE INTO `tenants` (`id`, `name`, `contact_fio`, `phone`, `email`, `service_info`, `tenantactivity_id`, `legaladdress`) VALUES
	(1, 'Аксентович Н.Ю. ГРФ', NULL, '98009880122', 'aksentovich@yandex.ru', NULL, 1, NULL),
	(2, 'Альтернатива ООО', NULL, '95743443423', 'alternativa@g.com', NULL, 2, NULL),
	(3, 'Альянс ООО', NULL, '98008008898', 'aliains@ttt.com', NULL, 3, NULL),
	(4, 'АМСИ электроникс ООО', NULL, '94003330989', 'amsi@amsi.ru', NULL, 2, NULL),
	(5, 'АНЬДЭЛИ ЭЛЕКТРИК РУС ООО', NULL, '90000125434', 'electric@tr.tr', NULL, 2, NULL);
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;

-- Дамп структуры для таблица your_renter.useravailabilities
CREATE TABLE IF NOT EXISTS `useravailabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `contract_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `contract_id` (`contract_id`),
  KEY `user_id` (`user_id`,`contract_id`),
  CONSTRAINT `useravailabilities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `useravailabilities_ibfk_2` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.useravailabilities: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `useravailabilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `useravailabilities` ENABLE KEYS */;

-- Дамп структуры для таблица your_renter.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

-- Дамп данных таблицы your_renter.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `login`, `pass`) VALUES
	(1, 'admin@renter.com', '111'),
	(2, 'user@renter.com', '123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
