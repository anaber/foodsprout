UPDATE restaurant_chain_supplier
SET status = 'live';

UPDATE distributor_supplier
SET status = 'live';

UPDATE farmers_market_supplier
SET status = 'live';

UPDATE manufacture_supplier
SET status = 'live';

UPDATE restaurant_supplier
SET status = 'live';

UPDATE farm_supplier
SET status = 'live';

--
-- 8/30/2010
--

UPDATE farm
SET status = 'live';

UPDATE farmers_market
SET status = 'live';

UPDATE manufacture
SET status = 'live';

UPDATE restaurant
SET status = 'live';

UPDATE distributor
SET status = 'live';

UPDATE restaurant_chain
SET status = 'live';

UPDATE farm
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farmers_market
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE manufacture
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE distributor
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant_chain
SET user_id = '1', 
track_ip = '174.143.112.149';


--
-- 9/10/2010
--
UPDATE restaurant_chain_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE distributor_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farmers_market_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE manufacture_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farm_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE product
SET track_ip = '174.143.112.149';


--
-- 9/19/2010
--
ALTER TABLE address ADD COLUMN claims_sustainable INT(1) NULL DEFAULT NULL  AFTER geocoded ;

UPDATE address SET claims_sustainable = 0;

--
-- 9/24/2010
-- UPDATE CITY
--
UPDATE `city` SET `city` = 'McComb' WHERE `city`.`city_id` =1271;
UPDATE `city` SET `city` = 'McAlester' WHERE `city`.`city_id` =1873;
UPDATE `city` SET `city` = 'McAllen' WHERE `city`.`city_id` =463;
UPDATE `city` SET `city` = 'McDonough' WHERE `city`.`city_id` =438;
UPDATE `city` SET `city` = 'Riverview' WHERE `city`.`city_id` =7851;
UPDATE `city` SET `city` = 'MacClenny' WHERE `city`.`city_id` =8676;
UPDATE `city` SET `city` = 'McHenry' WHERE `city`.`city_id` =635;
UPDATE `city` SET `city` = 'Somers' WHERE `city`.`city_id` =7068;
UPDATE `city` SET `city` = 'McCall' WHERE `city`.`city_id` =1443;
UPDATE `city` SET `city` = 'DeMotte' WHERE `city`.`city_id` =8858;
UPDATE `city` SET `city` = 'DeFuniak Springs' WHERE `city`.`city_id` =5224;
UPDATE `city` SET `city` = 'McKinney' WHERE `city`.`city_id` =6308;
UPDATE `city` SET `city` = 'McLean' WHERE `city`.`city_id` =1605;
UPDATE `city` SET `city` = 'McMinnville' WHERE `city`.`city_id` =448;
UPDATE `city` SET `city` = 'LaGrange' WHERE `city`.`city_id` =1982;
UPDATE `city` SET `city` = 'LaPorte' WHERE `city`.`city_id` =1403;
UPDATE `city` SET `city` = 'LaMoure' WHERE `city`.`city_id` =6746;
UPDATE `city` SET `city` = 'McKinleyville' WHERE `city`.`city_id` =13901;
UPDATE `city` SET `city` = 'DeWitt' WHERE `city`.`city_id` =4607;
UPDATE `city` SET `city` = 'McPherson' WHERE `city`.`city_id` =289;


--
-- ALTER SCRIPT
--
ALTER TABLE `address` 
ADD INDEX `latitude` (`latitude` ASC) 
, ADD INDEX `longitude` (`longitude` ASC) ;

ALTER TABLE `farmers_market` ADD COLUMN `facebook` VARCHAR(255) NULL DEFAULT NULL  AFTER `custom_url` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` , ADD COLUMN `twitter` VARCHAR(255) NULL DEFAULT NULL  AFTER `facebook` , 
  ADD CONSTRAINT `fk_farmers_market_user1`
  FOREIGN KEY (`user_id` )
  REFERENCES `user` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_farmers_market_user1` (`user_id` ASC) ;

ALTER TABLE `manufacture_supplier` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` ;

ALTER TABLE `manufacture` DROP COLUMN `is_active` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `twitter` , 
  ADD CONSTRAINT `fk_manufacture_user1`
  FOREIGN KEY (`user_id` )
  REFERENCES `user` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_manufacture_user1` (`user_id` ASC) ;

ALTER TABLE `product` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `modify_date` ;

ALTER TABLE `restaurant_chain_supplier` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` ;

ALTER TABLE `restaurant_chain` ADD COLUMN `status` ENUM('live','queue','hide') NULL DEFAULT NULL  AFTER `twitter` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `twitter` , ADD COLUMN `user_id` INT(11) NULL DEFAULT NULL  AFTER `twitter` , 
  ADD CONSTRAINT `fk_restaurant_chain_user`
  FOREIGN KEY (`user_id` )
  REFERENCES `user` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_restaurant_chain_user` (`user_id` ASC) ;

ALTER TABLE `restaurant_supplier` CHANGE COLUMN `track_ip` `track_ip` VARCHAR(20) NULL DEFAULT NULL  ;

ALTER TABLE `restaurant` DROP COLUMN `is_active` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `twitter` ;

ALTER TABLE `distributor` DROP COLUMN `is_active` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` , 
  ADD CONSTRAINT `fk_distributor_user1`
  FOREIGN KEY (`user_id` )
  REFERENCES `user` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_distributor_user1` (`user_id` ASC) ;

ALTER TABLE `farm` DROP COLUMN `is_active` , ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `twitter` , 
  ADD CONSTRAINT `fk_farm_user1`
  FOREIGN KEY (`user_id` )
  REFERENCES `user` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_farm_user1` (`user_id` ASC) ;

ALTER TABLE `distributor_supplier` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` ;

ALTER TABLE `farm_supplier` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` ;


ALTER TABLE `farmers_market_supplier` ADD COLUMN `track_ip` VARCHAR(20) NULL DEFAULT NULL  AFTER `status` ;

