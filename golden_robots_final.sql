-- MySQL dump 10.17  Distrib 10.3.17-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: golden_robot
-- ------------------------------------------------------
-- Server version	10.3.17-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `login_sessions`
--

DROP TABLE IF EXISTS `login_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_sessions` (
  `id` int(11) NOT NULL,
  `login_time` date NOT NULL DEFAULT current_timestamp(),
  `user_email` varchar(100) NOT NULL,
  `internal_token` varchar(64) NOT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `sent_token` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_mail_idx` (`user_email`),
  CONSTRAINT `fk_user_mail` FOREIGN KEY (`user_email`) REFERENCES `users` (`user_email`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(65) NOT NULL,
  `key` varchar(65) NOT NULL,
  `password` varchar(65) NOT NULL,
  `order_id` int(11) NOT NULL,
  `account_freed` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`),
  UNIQUE KEY `token` (`token`,`key`,`password`),
  CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `robot_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platforms` (
  `platform_id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_name` varchar(45) DEFAULT NULL,
  `platform_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`platform_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robot_auth`
--

DROP TABLE IF EXISTS `robot_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robot_auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `robot_order_id` int(11) NOT NULL,
  `auth_token` varchar(65) NOT NULL,
  `auth_key` varchar(65) NOT NULL,
  `from_ip` varchar(45) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`auth_id`),
  KEY `fk_robot_order_id_idx` (`robot_order_id`),
  CONSTRAINT `fk_robot_order_id` FOREIGN KEY (`robot_order_id`) REFERENCES `robot_orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robot_orders`
--

DROP TABLE IF EXISTS `robot_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robot_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `robot_number` int(11) NOT NULL,
  `robot_platform` int(11) NOT NULL,
  `order_expires_at` date NOT NULL,
  `order_renew_expires_at` date DEFAULT NULL,
  `order_comment` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_id`),
  KEY `fk_robot_id_idx` (`robot_number`),
  KEY `fk_owner_id_idx` (`owner_id`),
  KEY `fk_platform_id_idx` (`robot_platform`),
  CONSTRAINT `fk_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `robot_owners` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_platform_id` FOREIGN KEY (`robot_platform`) REFERENCES `platforms` (`platform_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_robot_id` FOREIGN KEY (`robot_number`) REFERENCES `robots` (`robot_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robot_owners`
--

DROP TABLE IF EXISTS `robot_owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robot_owners` (
  `owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_name` varchar(100) NOT NULL,
  `owner_token` varchar(65) NOT NULL,
  `owner_key` varchar(65) NOT NULL,
  `owner_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`owner_id`),
  UNIQUE KEY `owner_token_UNIQUE` (`owner_token`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robots`
--

DROP TABLE IF EXISTS `robots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robots` (
  `robot_id` int(11) NOT NULL AUTO_INCREMENT,
  `robot_number` int(11) NOT NULL,
  `robot_price` double(10,2) DEFAULT NULL,
  `robot_description` text DEFAULT NULL,
  `robot_sold_counter` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`robot_id`),
  UNIQUE KEY `robot_number_UNIQUE` (`robot_number`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `show_orders_list`
--

DROP TABLE IF EXISTS `show_orders_list`;
/*!50001 DROP VIEW IF EXISTS `show_orders_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_orders_list` (
  `order_id` tinyint NOT NULL,
  `robot_number` tinyint NOT NULL,
  `expires_at` tinyint NOT NULL,
  `renew_expires_at` tinyint NOT NULL,
  `comment` tinyint NOT NULL,
  `token` tinyint NOT NULL,
  `key` tinyint NOT NULL,
  `password` tinyint NOT NULL,
  `account_freed` tinyint NOT NULL,
  `robot_price` tinyint NOT NULL,
  `robot_description` tinyint NOT NULL,
  `owner_name` tinyint NOT NULL,
  `owner_id` tinyint NOT NULL,
  `platform_name` tinyint NOT NULL,
  `platform_code` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_pass` varchar(65) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'golden_robot'
--
/*!50003 DROP FUNCTION IF EXISTS `fn_bind_tokens` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_bind_tokens`(_token varchar(64), _key varchar(64), _pwd varchar(64), _oid int(11)) RETURNS int(11)
begin
	return (SELECT count(1) from order_detail where token = _token AND `key` = _key AND password = _pwd AND order_id = _oid);
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_create_platform` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_create_platform`(_code varchar(45)) RETURNS int(11)
begin

    if (SELECT fn_select_platform(_code)) = 0 then
		INSERT INTO platforms (
            platform_code
        ) VALUES (
			_code
        );
	end if;
    
	return (SELECT fn_select_platform(_code));
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_create_robot` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_create_robot`(_number INT) RETURNS int(11)
begin

	if (select fn_select_robot(_number)) = 0 then

		INSERT INTO robots (
			robot_number
		) 
		VALUES
		(	
			_number
		);
	end if;
    return (SELECT fn_select_robot(_number));
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_create_robot_owner` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_create_robot_owner`(_name VARCHAR(100), _key VARCHAR(65), _token VARCHAR(65)) RETURNS int(11)
BEGIN
	
    if (SELECT fn_select_robot_owner(_key)) = 0 then
		insert into robot_owners (
			owner_name,
			owner_token,
			owner_key
		) VALUES (
			_name, 
			_token,
			_key
		);
        
	end if;
    
    return (SELECT fn_select_robot_owner(_key));
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_robot_validate_auth` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_robot_validate_auth`(_token varchar(65), _key varchar(65), _from_ip varchar(45), _account_number VARCHAR(45)) RETURNS int(11)
begin
	
    declare _order_id int;
    
    set _order_id = (
		SELECT order_id from show_orders_list WHERE
			_token = token 
		AND  `key` = _key
        AND _account_number = account_freed
		AND (
				NOW() <= expires_at
				OR NOW() <= renew_expires_at
            )
    );
    
    if _order_id is not null then
		call sp_log_auth(_token, _key, _from_ip, _account_number, _order_id);
        return 1;
	end if;
    return 0;
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_select_platform` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_select_platform`(_code varchar(45)) RETURNS int(11)
begin
	
    declare _id int;
    
    set _id = (
		SELECT platform_id from platforms where platform_code = _code
    );
    
    if _id is not null then
		return _id;
	end if;
    
	return 0;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_select_robot` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_select_robot`(_number int(11)) RETURNS int(11)
begin
	
	declare _robot_id int;
    
    set _robot_id = (
		SELECT robot_id from robots where robot_number = _number
    );
    
    if _robot_id is not null then
		return _robot_id;
	end if;
	return 0;
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_select_robot_owner` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_select_robot_owner`(_key VARCHAR(100)) RETURNS int(11)
BEGIN
	declare _user int(11);
    
    SET _user = (
		SELECT owner_id FROM robot_owners WHERE owner_key = _key
    );
    
    IF _user is not null then
		return _user;
	END IF;
    
	return 0;
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_create_order` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_order`(
    _owner_name varchar(100),
	_robot_number int(11),
	_platform_code VARCHAR(100),
    _account_freed VARCHAR(45),
	_expires_at DATE,
	_renew_expires_at DATE,
	_token varchar(65),
	_key varchar(65),
	_pwd varchar(65),
    _order_comment text,
    _order_id int(11)
)
begin
	
    declare _platform_id int;
    declare _owner_id int;
	declare _robot_id int;
    declare __K varchar (65);
    
    set _platform_id = (
		SELECT fn_create_platform(_platform_code)
    );
    
    set _owner_id = (
		SELECT fn_create_robot_owner(_owner_name, _key, _token)
    );
    
    set _robot_id = (
		SELECT fn_create_robot(_robot_number)
    );
    
    
    if _order_id = 0 then
		INSERT INTO robot_orders (
			owner_id,
			robot_number,
			robot_platform,
			order_expires_at,
			order_comment
		) VALUES (
			_owner_id,
			_robot_number,
			_platform_id,
            _expires_at,
            _order_comment
		);
        
        set _order_id = (
			SELECT order_id FROM robot_orders ORDER BY order_id DESC LIMIT 1
		);
		
		call sp_create_order_detail (
			_order_id, _token, _key, _pwd, _account_freed
		);
	else 
		set __K = (SELECT fn_bind_tokens(_token, _key, _pwd, _order_id));
		if _order_id > 0 and __K = 1 then
			UPDATE robot_orders 
			SET
				robot_number = _robot_number,
				robot_platform = robot_platform,
                order_expires_at = _expires_at,
				order_renew_expires_at = _renew_expires_at,
				order_comment = _order_comment
			WHERE order_id = _order_id;

		else
			signal sqlstate '45900' set message_text = 'Error binding tokens.';
		end if;
    end if;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_create_order_detail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_order_detail`(_order_id INT(11), _token varchar(65), _key varchar(65), _password varchar(65), _account_freed varchar(45))
begin
	
    insert into order_detail (
		`token`, `key`, `password`, `order_id`, account_freed
    ) VALUES (
		_token, _key, _password, _order_id, _account_freed
    );
    
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_delete_item` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_item`(_item_id int)
begin
	update robot_orders set status = 0 where order_id = _item_id;
 end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_log_auth` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_log_auth`(_token varchar(65), _key varchar(65), _from_ip varchar(45), _account_number VARCHAR(45), _order_id int(11))
begin 
INSERT INTO robot_auth
        (
			robot_order_id,
            auth_token,
            auth_key,
            from_ip,
            `time`,
            expired
        ) VALUES (
			_order_id,
            _token,
            _key,
            _from_ip,
            NOW(),
            0
        );
	end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `show_orders_list`
--

/*!50001 DROP TABLE IF EXISTS `show_orders_list`*/;
/*!50001 DROP VIEW IF EXISTS `show_orders_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_orders_list` AS select `o`.`order_id` AS `order_id`,`o`.`robot_number` AS `robot_number`,`o`.`order_expires_at` AS `expires_at`,`o`.`order_renew_expires_at` AS `renew_expires_at`,`o`.`order_comment` AS `comment`,`od`.`token` AS `token`,`od`.`key` AS `key`,`od`.`password` AS `password`,`od`.`account_freed` AS `account_freed`,`r`.`robot_price` AS `robot_price`,`r`.`robot_description` AS `robot_description`,`ro`.`owner_name` AS `owner_name`,`ro`.`owner_id` AS `owner_id`,`p`.`platform_name` AS `platform_name`,`p`.`platform_code` AS `platform_code` from ((((`robot_orders` `o` join `order_detail` `od` on(`o`.`order_id` = `od`.`order_id`)) join `robot_owners` `ro` on(`o`.`owner_id` = `ro`.`owner_id`)) join `platforms` `p` on(`o`.`robot_platform` = `p`.`platform_id`)) join `robots` `r` on(`o`.`robot_number` = `r`.`robot_number`)) where `o`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-16 13:25:20
