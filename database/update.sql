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
-- 2011/11/03
-- Released
--
ALTER TABLE `address` CHANGE COLUMN `zipcode` `zipcode` VARCHAR(6) NOT NULL  ;
UPDATE `address` SET zipcode = CONCAT('0', zipcode) AND geocoded = 0 WHERE CHAR_LENGTH( `zipcode` ) = 4;

ALTER TABLE `photo` ADD COLUMN `restaurant_chain_id` INT(11) NULL DEFAULT NULL  AFTER `manufacture_id` ;
ALTER TABLE `restaurant` ADD COLUMN `claims_sustainable` INT(1) NULL DEFAULT 0 AFTER `track_ip` ;

--
-- 2011/11/15
-- Lottery Release
--
ALTER TABLE `lottery_entry` ADD COLUMN `enrolled_on` DATETIME NOT NULL  AFTER `lottery_id` ;
ALTER TABLE `lottery_prize` DROP COLUMN `place` , ADD COLUMN `prize` VARCHAR(45) NULL DEFAULT NULL  AFTER `winner` ;
ALTER TABLE `lottery` ADD COLUMN `draw_date` DATETIME NOT NULL  AFTER `end_date` , ADD COLUMN `result_date` DATETIME NOT NULL  AFTER `draw_date` ;
ALTER TABLE `lottery` ADD COLUMN `info` TEXT NULL DEFAULT NULL  AFTER `restaurant_id` ;

CREATE  TABLE IF NOT EXISTS `lottery_photo` (
  `photo_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `lottery_id` INT(11) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `thumb_photo_name` VARCHAR(255) NULL DEFAULT NULL ,
  `photo_name` VARCHAR(255) NULL DEFAULT NULL ,
  `original_photo_name` VARCHAR(255) NULL DEFAULT NULL ,
  `extension` VARCHAR(45) NULL DEFAULT NULL ,
  `mime_type` VARCHAR(45) NULL DEFAULT NULL ,
  `thumb_height` INT(11) NULL DEFAULT NULL ,
  `thumb_width` INT(11) NULL DEFAULT NULL ,
  `height` INT(11) NULL DEFAULT NULL ,
  `width` INT(11) NULL DEFAULT NULL ,
  `added_on` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`photo_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitedAddress` varchar(255) DEFAULT NULL,
  `visitorIp` varchar(16) DEFAULT NULL,
  `visitDate` datetime DEFAULT NULL,
  `visitorId` varchar(15) DEFAULT NULL,
  `visitorAgent` varchar(255) DEFAULT NULL,
  `visitorOs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1

-- 
-- City
-- 
ALTER TABLE `city` ADD `custom_url` VARCHAR( 125 ) NULL DEFAULT NULL;

-- 17789##St. Clairsville##OH##st-clairsville-oh## Correct Slug : Duplicate of : 14197 : St Clairsville : 3(17789)
-- Keep 17789
UPDATE address SET city_id = 17789 WHERE city_id = 14197;
DELETE FROM city WHERE city_id = 14197;

-- 7696##Croton On Hudson##NY##croton-on-hudson-ny## Correct Slug : Duplicate of : 4025 : Croton-on-hudson : 7(7696)
-- Keep 7696
UPDATE address SET city_id = 7696 WHERE city_id = 4025;
DELETE FROM city WHERE city_id = 4025;

-- 18128##Chandler,##AZ##chandler-az## Correct Slug : Duplicate of : 1033 : Chandler : 1(18128)
-- Keep 1033
UPDATE address SET city_id = 1033 WHERE city_id = 18128;
DELETE FROM city WHERE city_id = 18128;

-- 18211##St. Augustine##FL##st-augustine-fl## Correct Slug : Duplicate of : 11424 : St Augustine : 3(18211)
-- Keep 18211
UPDATE address SET city_id = 18211 WHERE city_id = 11424;
DELETE FROM city WHERE city_id = 11424;

-- 18213##St. Petersburg##FL##st-petersburg-fl## Correct Slug : Duplicate of : 7400 : St Petersburg : 1(18213)
-- Keep 18213
UPDATE address SET city_id = 18213 WHERE city_id = 7400;
DELETE FROM city WHERE city_id = 7400;

-- 18264##Kailua-Kona##HI##kailua-kona-hi## Correct Slug : Duplicate of : 358 : Kailua Kona : 1(18264)
-- Keep 358
UPDATE address SET city_id = 358 WHERE city_id = 18264;
DELETE FROM city WHERE city_id = 18264;

-- 17993##Spring Lake,##MI##spring-lake-mi## Correct Slug : Duplicate of : 1595 : Spring Lake : 1(17993)
-- Keep 1595
UPDATE address SET city_id = 1595 WHERE city_id = 17993;
DELETE FROM city WHERE city_id = 17993;

-- 18476##East Tawas,##MI##east-tawas-mi## Correct Slug : Duplicate of : 6391 : East Tawas : 1(18476)
-- Keep 6391
UPDATE address SET city_id = 6391 WHERE city_id = 18476;
DELETE FROM city WHERE city_id = 18476;

-- 18482##Mt. Pleasant##MI##mt-pleasant-mi## Correct Slug : Duplicate of : 8109 : Mt Pleasant : 1(18482)
-- Keep 18482
UPDATE address SET city_id = 18482 WHERE city_id = 8109;
DELETE FROM city WHERE city_id = 8109;

-- 18485##Rockford,##MI##rockford-mi## Correct Slug : Duplicate of : 11461 : Rockford : 1(18485)
-- Keep 11461
UPDATE address SET city_id = 11461 WHERE city_id = 18485;
DELETE FROM city WHERE city_id = 18485;

-- 16578##St. Louis Park##MN##st-louis-park-mn## Correct Slug : Duplicate of : 16366 : St Louis Park : 2(16578)
-- Keep 16578
UPDATE address SET city_id = 16578 WHERE city_id = 16366;
DELETE FROM city WHERE city_id = 16366;

-- 18470##St. Cloud##MN##st-cloud-mn## Correct Slug : Duplicate of : 5885 : St Cloud : 1(18470)
-- Keep 18470
UPDATE address SET city_id = 18470 WHERE city_id = 5885;
DELETE FROM city WHERE city_id = 5885;

-- 18471##St. James##MN##st-james-mn## Correct Slug : Duplicate of : 8588 : St James : 1(18471)
-- Keep 18471
UPDATE address SET city_id = 18471 WHERE city_id = 8588;
DELETE FROM city WHERE city_id = 8588;

-- 18472##St. Joseph##MN##st-joseph-mn## Correct Slug : Duplicate of : 9270 : St Joseph : 1(18472)
-- Keep 18472
UPDATE address SET city_id = 18472 WHERE city_id = 9270;
DELETE FROM city WHERE city_id = 9270;

-- 18473##St. Paul##MN##st-paul-mn## Correct Slug : Duplicate of : 7870 : St Paul : 3(18473)
-- Keep 18473
UPDATE address SET city_id = 18473 WHERE city_id = 7870;
DELETE FROM city WHERE city_id = 7870;

-- 18461##D'Iberville##MS##diberville-ms## Correct Slug : Duplicate of : 5771 : Diberville : 1(18461)
-- Keep 18461
UPDATE address SET city_id = 18461 WHERE city_id = 5771;
DELETE FROM city WHERE city_id = 5771;

-- 12298##St. Louis##MO##st-louis-mo## Correct Slug : Duplicate of : 4021 : St Louis : 6(12298)
-- Keep 12298
UPDATE address SET city_id = 12298 WHERE city_id = 4021;
DELETE FROM city WHERE city_id = 4021;

-- 18452##Lee's Summit##MO##lees-summit-mo## Correct Slug : Duplicate of : 2107 : Lees Summit : 1(18452)
-- Keep 18452
UPDATE address SET city_id = 18452 WHERE city_id = 2107;
DELETE FROM city WHERE city_id = 2107;

-- 18458##St. Joseph##MO##st-joseph-mo## Correct Slug : Duplicate of : 16898 : St Joseph : 3(18458)
-- Keep 18458
UPDATE address SET city_id = 18458 WHERE city_id = 16898;
DELETE FROM city WHERE city_id = 16898;

-- 18376##Winston-Salem##NC##winston-salem-nc## Correct Slug : Duplicate of : 383 : Winston Salem : 2(18376)
-- Keep 383
UPDATE address SET city_id = 383 WHERE city_id = 18376;
DELETE FROM city WHERE city_id = 18376;

-- 18325##Lincoln City,##OR##lincoln-city-or## Correct Slug : Duplicate of : 3716 : Lincoln City : 1(18325)
-- Keep 3716
UPDATE address SET city_id = 3716 WHERE city_id = 18325;
DELETE FROM city WHERE city_id = 18325;

-- 18300##Bird-in-Hand##PA##bird-in-hand-pa## Correct Slug : Duplicate of : 11988 : Bird In Hand : 1(18300)
-- Keep 11988
UPDATE address SET city_id = 11988 WHERE city_id = 18300;
DELETE FROM city WHERE city_id = 18300;

-- 18205##Manakin-Sabot##VA##manakin-sabot-va## Correct Slug : Duplicate of : 1189 : Manakin Sabot : 1(18205)
-- Keep 1189
UPDATE address SET city_id = 1189 WHERE city_id = 18205;
DELETE FROM city WHERE city_id = 18205;

