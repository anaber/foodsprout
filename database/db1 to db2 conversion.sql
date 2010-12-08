-- -----------------------------------------------------
-- Table `supplier`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `supplier` (
  `supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `supplier` INT NOT NULL ,
  `suppliee` INT NULL ,
  `user_id` INT NULL DEFAULT NULL ,
  `status` ENUM('live','queue','hide') NULL DEFAULT NULL ,
  `record_ip` VARCHAR(18) NULL ,
  PRIMARY KEY (`supplier_id`) )
ENGINE = InnoDB;

CREATE INDEX `supplier` ON `supplier` (`supplier` ASC) ;

CREATE INDEX `suppliee` ON `supplier` (`suppliee` ASC) ;


-- -----------------------------------------------------
-- Table `producer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `producer` (
  `producer_id` INT NOT NULL AUTO_INCREMENT ,
  `producer` VARCHAR(100) NOT NULL ,
  `creation_date` DATE NOT NULL ,
  `custom_url` VARCHAR(75) NULL ,
  `city_area_id` INT NULL ,
  `user_id` INT NULL ,
  `phone` VARCHAR(20) NULL ,
  `fax` VARCHAR(20) NULL ,
  `email` VARCHAR(100) NULL ,
  `url` VARCHAR(255) NULL ,
  `status` ENUM('live','queue','hide') NOT NULL DEFAULT queue ,
  `facebook` VARCHAR(255) NULL DEFAULT NULL ,
  `twitter` VARCHAR(255) NULL DEFAULT NULL ,
  `description` TEXT NULL ,
  `track_ip` VARCHAR(18) NULL ,
  `claims_sustainable` INT NULL ,
  `is_chain_restaurant` TINYINT NULL ,
  PRIMARY KEY (`producer_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `location_supplier`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `location_supplier` (
  `location_supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `to_address_id` INT NOT NULL ,
  `from_address_id` INT NOT NULL ,
  `user_id` INT NULL ,
  `record_ip` VARCHAR(18) NULL ,
  `est_distance_miles` INT NULL ,
  `est_distance_km` INT NULL ,
  PRIMARY KEY (`location_supplier_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `category_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `category_group` (
  `category_group_id` INT NOT NULL AUTO_INCREMENT ,
  `category_group` VARCHAR(45) NULL ,
  PRIMARY KEY (`category_group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producer_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `producer_category` (
  `producer_category_id` INT NOT NULL AUTO_INCREMENT ,
  `producer_category` VARCHAR(200) NOT NULL ,
  `category_group1` INT NULL ,
  `category_group2` INT NULL ,
  PRIMARY KEY (`producer_category_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producer_category_member`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `producer_category_member` (
  `producer_id` int(11) default NULL,
  `producer_category_id` int(11) NOT NULL,
  `address_id` int(11) default NULL,
  `producer_category_member_id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`producer_category_member_id`),
  KEY `address_id` (`address_id`),
  KEY `producer_category_id` (`producer_category_id`),
  KEY `producer_id` (`producer_id`)
) ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `producer_conglomerate`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `producer_conglomerate` (
  `producer_conglomerate_id` INT NOT NULL AUTO_INCREMENT ,
  `conglomerate_name` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`producer_conglomerate_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producer_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `producer_group` (
  `producer_conglomerate_id` INT NOT NULL ,
  `producer_id` INT NULL ,
  `address_id` INT NULL ,
  PRIMARY KEY (`producer_conglomerate_id`) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `producer_attribute`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `producer_attribute` (
  `producer_attribute_id` INT NOT NULL ,
  `producer_id` INT NOT NULL ,
  `attribute` VARCHAR(95) NULL ,
  `attribute_value` VARCHAR(95) NULL ,
  PRIMARY KEY (`producer_attribute_id`) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Update the address table and product table
-- -----------------------------------------------------

ALTER TABLE `address` ADD COLUMN `producer_id` INT NOT NULL  AFTER `address_id` , ADD COLUMN `track_ip` VARCHAR(18) NULL  AFTER `claims_sustainable` , ADD COLUMN `user_id` INT NULL  AFTER `claims_sustainable` ;
ALTER TABLE `product` ADD COLUMN `producer_Id` INT NOT NULL  AFTER `product_id` ;

-- -----------------------------------------------------
-- Update the producer and product table to index for faster update below
-- -----------------------------------------------------
ALTER TABLE `producer` ADD INDEX `chain_id` (`restaurant_chain_id` ASC);
ALTER TABLE `product` ADD INDEX `fk_product_chain1` (`restaurant_chain_id` ASC);
ALTER TABLE `producer` ADD INDEX `restaurant_id` (`restaurant_id` ASC) ;
ALTER TABLE `producer` ADD INDEX `farm_id` (`farm_id` ASC) ;
ALTER TABLE `producer` ADD INDEX `manufacture_id` (`manufacture_id` ASC) ;

-- -----------------------------------------------------
-- These are temp columns to maintain data integrity and will be removed once all IDs are fixed in new db structure
-- -----------------------------------------------------
ALTER TABLE `producer_category` ADD COLUMN `cuisine_id` INT NULL  AFTER `category_group2` , ADD COLUMN `farm_type_id` INT NULL  AFTER `cuisine_id` , ADD COLUMN `manufacture_type_id` INT NULL  AFTER `farm_type_id` , ADD COLUMN `restaurant_type_id` INT NULL  AFTER `cuisine_id` ;

-- -----------------------------------------------------
-- Insert all the old types into the new producer_category table
-- -----------------------------------------------------

INSERT INTO producer_category (producer_category,cuisine_id) SELECT cuisine_name,cuisine_id FROM cuisine;
INSERT INTO producer_category (producer_category,restaurant_type_id) SELECT restaurant_type,restaurant_type_id FROM restaurant_type;
INSERT INTO producer_category (producer_category,farm_type_id) SELECT farm_type,farm_type_id FROM farm_type;
INSERT INTO producer_category (producer_category,manufacture_type_id) SELECT manufacture_type,manufacture_type_id FROM manufacture_type;

-- -----------------------------------------------------
-- Temp add IDs to the producer table for data integrity, we will later delete these
-- -----------------------------------------------------

ALTER TABLE `producer` ADD COLUMN `farm_id` INT NULL  AFTER `description` , ADD COLUMN `manufacture_id` INT NULL  AFTER `description` , ADD COLUMN `restaurant_id` INT NULL  AFTER `description` , ADD COLUMN `restaurant_chain_id` INT NULL  AFTER `description`;

-- -----------------------------------------------------
-- Insert all the restaurants/farms/manufactures/distributors into the producer table
-- -----------------------------------------------------

INSERT INTO `producer`
(`producer`,
`creation_date`,
`custom_url`,
`city_area_id`,
`user_id`,
`phone`,
`fax`,
`email`,
`url`,
`status`,
`facebook`,
`twitter`,
`restaurant_id`,
`track_ip`,
`claims_sustainable`)
SELECT restaurant_name,creation_date,custom_url,city_area_id,user_id,phone,fax,email,url,status,facebook,twitter,restaurant_id,track_ip,claims_sustainable FROM restaurant;


INSERT INTO `producer`
(`producer`,
`creation_date`,
`custom_url`,
`user_id`,
`url`,
`status`,
`facebook`,
`twitter`,
`farm_id`,
`track_ip`)
SELECT farm_name,
creation_date,
custom_url,
user_id,
url,
status,
facebook,
twitter,
farm_id,
track_ip FROM farm;


INSERT INTO `producer`
(`producer`,
`creation_date`,
`custom_url`,
`user_id`,
`url`,
`status`,
`facebook`,
`twitter`,
`manufacture_id`,
`track_ip`)
SELECT manufacture_name,
creation_date,
custom_url,
user_id,
url,
status,
facebook,
twitter,
manufacture_id,
track_ip FROM manufacture;

INSERT INTO `producer`
(`producer`,
`creation_date`,
`custom_url`,
`user_id`,
`url`,
`status`,
`facebook`,
`twitter`,
`distributor_id`,
`track_ip`)
SELECT distributor_name,
creation_date,
custom_url,
user_id,
url,
status,
facebook,
twitter,
distributor_id,
track_ip FROM distributor;

INSERT INTO `producer`
(`producer`,
`user_id`,
`status`,
`facebook`,
`twitter`,
`restaurant_chain_id`,
`track_ip`
)
SELECT restaurant_chain,
user_id,
status,
facebook,
twitter,
restaurant_chain_id,
track_ip FROM restaurant_chain;

-- -----------------------------------------------------
-- Update the address table and poplulate the producer_id field in the address table to link the new producer table
-- -----------------------------------------------------

UPDATE address, producer set address.producer_id = producer.producer_id WHERE address.restaurant_id = producer.restaurant_id;
UPDATE address, producer set address.producer_id = producer.producer_id WHERE address.farm_id = producer.farm_id;
UPDATE address, producer set address.producer_id = producer.producer_id WHERE address.manufacture_id = producer.manufacture_id;
UPDATE address, producer set address.producer_id = producer.producer_id WHERE address.distributor_id = producer.distributor_id;

-- -----------------------------------------------------
-- Update the product table to include the new producer id
-- -----------------------------------------------------
UPDATE product, producer set product.producer_id = producer.producer_id WHERE product.restaurant_id = producer.restaurant_id;
UPDATE product, producer set product.producer_id = producer.producer_id WHERE product.manufacture_id = producer.manufacture_id;
UPDATE product, producer set product.producer_id = producer.producer_id WHERE product.restaurant_chain_id = producer.restaurant_chain_id;

-- -----------------------------------------------------
-- Populate the producer_category_member table to include all the categories
-- -----------------------------------------------------

-- Cuisine data first
INSERT INTO `producer_category_member` (`producer_id`,`producer_category_id`) SELECT ab.producer_id, xy.producer_category_id FROM restaurant_cuisine LEFT JOIN producer ab ON restaurant_cuisine.restaurant_id = ab.restaurant_id LEFT JOIN cuisine ac ON restaurant_cuisine.cuisine_id = ac.cuisine_id LEFT JOIN producer_category xy ON ac.cuisine_id = xy.cuisine_id;

-- saving for reference
-- SELECT ab.producer_id, xy.producer_category_id, ac.cuisine_id, ac.cuisine_name, ab.producer, xy.producer_category FROM restaurant_cuisine LEFT JOIN producer ab ON restaurant_cuisine.restaurant_id = ab.restaurant_id LEFT JOIN cuisine ac ON restaurant_cuisine.cuisine_id = ac.cuisine_id LEFT JOIN producer_category xy ON ac.cuisine_id = xy.cuisine_id;
-- -------

-- Cuisine data for address

INSERT INTO `producer_category_member` (`address_id`,`producer_category_id`) SELECT xz.address_id, xy.producer_category_id FROM restaurant_cuisine LEFT JOIN producer ab ON restaurant_cuisine.restaurant_id = ab.restaurant_id LEFT JOIN cuisine ac ON restaurant_cuisine.cuisine_id = ac.cuisine_id LEFT JOIN producer_category xy ON ac.cuisine_id = xy.cuisine_id LEFT JOIN address xz ON ab.producer_id = xz.producer_id;

-- for reference
-- SELECT xz.address_id, xy.producer_category_id, ac.cuisine_id, ac.cuisine_name, ab.producer, xy.producer_category, ab.producer_id FROM restaurant_cuisine LEFT JOIN producer ab ON restaurant_cuisine.restaurant_id = ab.restaurant_id LEFT JOIN cuisine ac ON restaurant_cuisine.cuisine_id = ac.cuisine_id LEFT JOIN producer_category xy ON ac.cuisine_id = xy.cuisine_id LEFT JOIN address xz ON ab.producer_id = xz.producer_id;
-- -------

-- Restaurant Type for producer

INSERT INTO `producer_category_member` (`producer_id`,`producer_category_id`) SELECT ab.producer_id, yz.producer_category_id FROM restaurant LEFT JOIN producer ab ON restaurant.restaurant_id = ab.restaurant_id LEFT JOIN restaurant_type xy ON restaurant.restaurant_type_id = xy.restaurant_type_id LEFT JOIN producer_category yz ON xy.restaurant_type_id = yz.restaurant_type_id;

-- Restaurant type for addresses

INSERT INTO `producer_category_member` (`address_id`,`producer_category_id`) SELECT xz.address_id, yz.producer_category_id FROM restaurant LEFT JOIN producer ab ON restaurant.restaurant_id = ab.restaurant_id LEFT JOIN restaurant_type xy ON restaurant.restaurant_type_id = xy.restaurant_type_id LEFT JOIN producer_category yz ON xy.restaurant_type_id = yz.restaurant_type_id LEFT JOIN address xz ON ab.producer_id = xz.producer_id;

-- Farm Type for producer

INSERT INTO `producer_category_member` (`producer_id`,`producer_category_id`) SELECT ab.producer_id, yz.producer_category_id FROM farm LEFT JOIN producer ab ON farm.farm_id = ab.farm_id LEFT JOIN farm_type xy ON farm.farm_type_id = xy.farm_type_id LEFT JOIN producer_category yz ON xy.farm_type_id = yz.farm_type_id;

-- Farm type for addresses

INSERT INTO `producer_category_member` (`address_id`,`producer_category_id`) SELECT xz.address_id, yz.producer_category_id FROM farm LEFT JOIN producer ab ON farm.farm_id = ab.farm_id LEFT JOIN farm_type xy ON farm.farm_type_id = xy.farm_type_id LEFT JOIN producer_category yz ON xy.farm_type_id = yz.farm_type_id LEFT JOIN address xz ON ab.producer_id = xz.producer_id;

-- Manufacture Type for producer

INSERT INTO `producer_category_member` (`producer_id`,`producer_category_id`) SELECT ab.producer_id, yz.producer_category_id FROM manufacture LEFT JOIN producer ab ON manufacture.manufacture_id = ab.manufacture_id LEFT JOIN manufacture_type xy ON manufacture.manufacture_type_id = xy.manufacture_type_id LEFT JOIN producer_category yz ON xy.manufacture_type_id = yz.manufacture_type_id;

-- Manufacture type for addresses

INSERT INTO `producer_category_member` (`address_id`,`producer_category_id`) SELECT xz.address_id, yz.producer_category_id FROM manufacture LEFT JOIN producer ab ON manufacture.manufacture_id = ab.manufacture_id LEFT JOIN manufacture_type xy ON manufacture.manufacture_type_id = xy.manufacture_type_id LEFT JOIN producer_category yz ON xy.manufacture_type_id = yz.manufacture_type_id LEFT JOIN address xz ON ab.producer_id = xz.producer_id;


-- -----------------------------------------------------
-- Populate the supplier table
-- -----------------------------------------------------

-- Need to figure out how to alter this select query to double join the producer table twice to get the producer_id for the columns supplier_manufacture_id and supplier_distributor_id

SELECT a_b.producer_id AS supplier, a_a.producer_id AS suppliee, restaurant_chain_supplier.user_id, restaurant_chain_supplier.status, restaurant_chain_supplier.track_ip, restaurant_chain_supplier.* FROM restaurant_chain_supplier LEFT JOIN producer a_a ON restaurant_chain_supplier.restaurant_chain_id = a_a.restaurant_chain_id LEFT JOIN producer a_b ON restaurant_chain_supplier.supplier_manufacture_id = a_b.manufacture_id UNION SELECT a_b.producer_id AS supplier, a_c.producer_id AS suppliee, restaurant_chain_supplier.user_id, restaurant_chain_supplier.status, restaurant_chain_supplier.track_ip, restaurant_chain_supplier.* FROM restaurant_chain_supplier LEFT JOIN producer a_b ON restaurant_chain_supplier.restaurant_chain_id = a_b.restaurant_chain_id LEFT JOIN producer a_c ON restaurant_chain_supplier.supplier_distributor_id = a_c.distributor_id;

-- Alternative query?

SELECT a_b.producer_id AS supplier, a_a.producer_id AS suppliee, a_c.producer_id AS supplier, restaurant_chain_supplier.user_id, restaurant_chain_supplier.status, restaurant_chain_supplier.track_ip, restaurant_chain_supplier.* FROM restaurant_chain_supplier LEFT JOIN producer a_a ON restaurant_chain_supplier.restaurant_chain_id = a_a.restaurant_chain_id LEFT JOIN producer a_b ON restaurant_chain_supplier.supplier_manufacture_id = a_b.manufacture_id LEFT JOIN producer a_c ON restaurant_chain_supplier.supplier_distributor_id = a_c.distributor_id;


-- Repeat above query for each supplier table

-- -----------------------------------------------------
-- Delate all the old columns and data
-- -----------------------------------------------------

-- Manually do this after backups and testing.