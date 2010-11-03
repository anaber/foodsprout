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

--
-- 2010/10/05
-- PHOTOS and COMMENTS
--

CREATE  TABLE IF NOT EXISTS `comment` (
  `comment_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `address_id` INT(11) NULL DEFAULT NULL ,
  `restaurant_id` INT(11) NULL DEFAULT NULL ,
  `farm_id` INT(11) NULL DEFAULT NULL ,
  `farmers_market_id` INT(11) NULL DEFAULT NULL ,
  `manufacture_id` INT(11) NULL DEFAULT NULL ,
  `restaurant_chain_id` INT(11) NULL DEFAULT NULL ,
  `comment` TEXT NULL DEFAULT NULL ,
  `user_id` INT(11) NULL DEFAULT NULL ,
  `status` ENUM('live','queue','hide') NULL DEFAULT NULL ,
  `track_ip` VARCHAR(20) NULL DEFAULT NULL ,
  `added_on` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`comment_id`) ,
  INDEX `fk_comment_address1` (`address_id` ASC) ,
  INDEX `fk_comment_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_comment_farm1` (`farm_id` ASC) ,
  INDEX `fk_comment_farmers_market1` (`farmers_market_id` ASC) ,
  INDEX `fk_comment_manufacture1` (`manufacture_id` ASC) ,
  INDEX `fk_comment_restaurant_chain1` (`restaurant_chain_id` ASC) ,
  INDEX `fk_comment_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_comment_address1`
    FOREIGN KEY (`address_id` )
    REFERENCES `address` (`address_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_farm1`
    FOREIGN KEY (`farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_farmers_market1`
    FOREIGN KEY (`farmers_market_id` )
    REFERENCES `farmers_market` (`farmers_market_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_manufacture1`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_restaurant_chain1`
    FOREIGN KEY (`restaurant_chain_id` )
    REFERENCES `restaurant_chain` (`restaurant_chain_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `photo` (
  `photo_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `address_id` INT(11) NULL DEFAULT NULL ,
  `restaurant_id` INT(11) NULL DEFAULT NULL ,
  `farm_id` INT(11) NULL DEFAULT NULL ,
  `farmers_market_id` INT(11) NULL DEFAULT NULL ,
  `manufacture_id` INT(11) NULL DEFAULT NULL ,
  `product_id` INT(11) NULL DEFAULT NULL ,
  `title` VARCHAR(45) NULL DEFAULT NULL ,
  `description` VARCHAR(255) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `thumb_photo_name` VARCHAR(255) NOT NULL ,
  `photo_name` VARCHAR(255) NOT NULL ,
  `original_photo_name` VARCHAR(255) NOT NULL ,
  `extension` VARCHAR(10) NOT NULL ,
  `mime_type` VARCHAR(45) NOT NULL ,
  `thumb_height` INT(5) NOT NULL ,
  `thumb_width` INT(5) NOT NULL ,
  `height` INT(5) NOT NULL ,
  `width` INT(5) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  `status` ENUM('live','queue','hide') NOT NULL ,
  `track_ip` VARCHAR(20) NOT NULL ,
  `added_on` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`photo_id`) ,
  INDEX `fk_photos_address1` (`address_id` ASC) ,
  INDEX `fk_photos_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_photos_farm1` (`farm_id` ASC) ,
  INDEX `fk_photos_farmers_market1` (`farmers_market_id` ASC) ,
  INDEX `fk_photos_manufacture1` (`manufacture_id` ASC) ,
  INDEX `fk_photos_product1` (`product_id` ASC) ,
  INDEX `fk_photos_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_photos_address1`
    FOREIGN KEY (`address_id` )
    REFERENCES `address` (`address_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_farm1`
    FOREIGN KEY (`farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_farmers_market1`
    FOREIGN KEY (`farmers_market_id` )
    REFERENCES `farmers_market` (`farmers_market_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_manufacture1`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


--
-- Latest SQL here
-- 2011/11/03
--
ALTER TABLE `address` CHANGE COLUMN `zipcode` `zipcode` VARCHAR(6) NOT NULL  ;
UPDATE `address` SET zipcode = CONCAT('0', zipcode) AND geocoded = 0 WHERE CHAR_LENGTH( `zipcode` ) = 4;





