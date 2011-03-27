SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `company` ;

CREATE  TABLE IF NOT EXISTS `company` (
  `company_id` INT NOT NULL AUTO_INCREMENT ,
  `company_name` VARCHAR(100) NOT NULL ,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`company_id`) ,
  INDEX `company_name` (`company_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_type` ;

CREATE  TABLE IF NOT EXISTS `restaurant_type` (
  `restaurant_type_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`restaurant_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `state` ;

CREATE  TABLE IF NOT EXISTS `state` (
  `state_id` INT NOT NULL AUTO_INCREMENT ,
  `state_name` VARCHAR(45) NOT NULL ,
  `state_code` CHAR(2) NOT NULL ,
  PRIMARY KEY (`state_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `city`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `city` ;

CREATE  TABLE IF NOT EXISTS `city` (
  `city_id` INT NOT NULL AUTO_INCREMENT ,
  `state_id` INT NOT NULL ,
  `city` VARCHAR(95) NULL ,
  PRIMARY KEY (`city_id`) ,
  INDEX `fk_city_state1` (`state_id` ASC) ,
  CONSTRAINT `fk_city_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `city_area`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `city_area` ;

CREATE  TABLE IF NOT EXISTS `city_area` (
  `city_area_id` INT NOT NULL AUTO_INCREMENT ,
  `city_id` INT NOT NULL ,
  `area` VARCHAR(95) NOT NULL ,
  PRIMARY KEY (`city_area_id`) ,
  INDEX `fk_city_area_city1` (`city_id` ASC) ,
  CONSTRAINT `fk_city_area_city1`
    FOREIGN KEY (`city_id` )
    REFERENCES `city` (`city_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE  TABLE IF NOT EXISTS `user` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(45) NOT NULL ,
  `zipcode` INT NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(32) NOT NULL ,
  `register_ipaddress` VARCHAR(18) NOT NULL ,
  `isActive` INT(2) NOT NULL ,
  `custom_url` VARCHAR(75) NOT NULL ,
  `join_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `latitude` VARCHAR(45) NULL ,
  `longitude` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
PACK_KEYS = Default;


-- -----------------------------------------------------
-- Table `restaurant_chain`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_chain` ;

CREATE  TABLE IF NOT EXISTS `restaurant_chain` (
  `restaurant_chain_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_chain` VARCHAR(100) NOT NULL ,
  `match_string` VARCHAR(45) NULL ,
  `restaurant_type_id` INT NOT NULL ,
  PRIMARY KEY (`restaurant_chain_id`) ,
  INDEX `fk_restaurant_chain_restaurant_type1` (`restaurant_type_id` ASC) ,
  CONSTRAINT `fk_restaurant_chain_restaurant_type1`
    FOREIGN KEY (`restaurant_type_id` )
    REFERENCES `restaurant_type` (`restaurant_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant` ;

CREATE  TABLE IF NOT EXISTS `restaurant` (
  `restaurant_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `restaurant_chain_id` INT NULL ,
  `restaurant_type_id` INT NOT NULL ,
  `creation_date` DATE NOT NULL ,
  `restaurant_name` VARCHAR(100) NOT NULL ,
  `custom_url` VARCHAR(75) NULL ,
  `city_area_id` INT NULL ,
  `user_id` INT NULL ,
  `phone` VARCHAR(20) NULL ,
  `fax` VARCHAR(20) NULL ,
  `email` VARCHAR(100) NULL ,
  `url` VARCHAR(255) NULL ,
  `is_active` INT NOT NULL ,
  PRIMARY KEY (`restaurant_id`) ,
  INDEX `fk_restaurant_restaurant_type1` (`restaurant_type_id` ASC) ,
  INDEX `fk_restaurant_city_area1` (`city_area_id` ASC) ,
  INDEX `fk_restaurant_company1` (`company_id` ASC) ,
  INDEX `fk_restaurant_user1` (`user_id` ASC) ,
  INDEX `fk_restaurant_restaurant_chain1` (`restaurant_chain_id` ASC) ,
  INDEX `restaurant_name` (`restaurant_name` ASC) ,
  CONSTRAINT `fk_restaurant_restaurant_type1`
    FOREIGN KEY (`restaurant_type_id` )
    REFERENCES `restaurant_type` (`restaurant_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_city_area1`
    FOREIGN KEY (`city_area_id` )
    REFERENCES `city_area` (`city_area_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_restaurant_chain1`
    FOREIGN KEY (`restaurant_chain_id` )
    REFERENCES `restaurant_chain` (`restaurant_chain_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_type` ;

CREATE  TABLE IF NOT EXISTS `product_type` (
  `product_type_id` INT NOT NULL AUTO_INCREMENT ,
  `product_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`product_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `manufacture_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `manufacture_type` ;

CREATE  TABLE IF NOT EXISTS `manufacture_type` (
  `manufacture_type_id` INT NOT NULL AUTO_INCREMENT ,
  `manufacture_type` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`manufacture_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `manufacture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `manufacture` ;

CREATE  TABLE IF NOT EXISTS `manufacture` (
  `manufacture_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `manufacture_type_id` INT NULL ,
  `creation_date` DATE NOT NULL ,
  `manufacture_name` VARCHAR(75) NULL ,
  `custom_url` VARCHAR(75) NULL ,
  `url` VARCHAR(255) NULL ,
  `is_active` TINYINT NOT NULL ,
  PRIMARY KEY (`manufacture_id`) ,
  INDEX `fk_manufacture_manufacture_type1` (`manufacture_type_id` ASC) ,
  INDEX `fk_manufacture_company1` (`company_id` ASC) ,
  CONSTRAINT `fk_manufacture_manufacture_type1`
    FOREIGN KEY (`manufacture_type_id` )
    REFERENCES `manufacture_type` (`manufacture_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacture_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product` ;

CREATE  TABLE IF NOT EXISTS `product` (
  `product_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `restaurant_id` INT NULL ,
  `restaurant_chain_id` INT NULL ,
  `manufacture_id` INT NULL ,
  `product_type_id` INT NULL ,
  `product_name` VARCHAR(90) NOT NULL ,
  `ingredient_text` TEXT NULL ,
  `brand` VARCHAR(90) NULL ,
  `upc` INT NULL ,
  `status` ENUM('live','queue') NOT NULL ,
  `user_id` INT NULL ,
  `creation_date` DATE NOT NULL ,
  `modify_date` DATE NULL ,
  PRIMARY KEY (`product_id`) ,
  INDEX `fk_product_company1` (`company_id` ASC) ,
  INDEX `fk_product_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_product_product_type1` (`product_type_id` ASC) ,
  INDEX `fk_product_user1` (`user_id` ASC) ,
  INDEX `fk_product_manufacture1` (`manufacture_id` ASC) ,
  CONSTRAINT `fk_product_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_product_type1`
    FOREIGN KEY (`product_type_id` )
    REFERENCES `product_type` (`product_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_manufacture1`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `country` ;

CREATE  TABLE IF NOT EXISTS `country` (
  `country_id` INT NOT NULL AUTO_INCREMENT ,
  `country_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`country_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ingredient_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ingredient_type` ;

CREATE  TABLE IF NOT EXISTS `ingredient_type` (
  `ingredient_type_id` INT NOT NULL AUTO_INCREMENT ,
  `ingredient_type` VARCHAR(60) NULL ,
  PRIMARY KEY (`ingredient_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vegetable_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vegetable_type` ;

CREATE  TABLE IF NOT EXISTS `vegetable_type` (
  `vegetable_type_id` INT NOT NULL AUTO_INCREMENT ,
  `vegetable_type` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`vegetable_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `animal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `animal` ;

CREATE  TABLE IF NOT EXISTS `animal` (
  `animal_id` INT NOT NULL AUTO_INCREMENT ,
  `animal_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`animal_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meat_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `meat_type` ;

CREATE  TABLE IF NOT EXISTS `meat_type` (
  `meat_type_id` INT NOT NULL AUTO_INCREMENT ,
  `meat_type` VARCHAR(45) NOT NULL ,
  `animal_id` INT NULL ,
  PRIMARY KEY (`meat_type_id`) ,
  INDEX `fk_meat_type_animal1` (`animal_id` ASC) ,
  CONSTRAINT `fk_meat_type_animal1`
    FOREIGN KEY (`animal_id` )
    REFERENCES `animal` (`animal_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fruit_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fruit_type` ;

CREATE  TABLE IF NOT EXISTS `fruit_type` (
  `fruit_type_id` INT NOT NULL AUTO_INCREMENT ,
  `fruit_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`fruit_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `plant_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `plant_group` ;

CREATE  TABLE IF NOT EXISTS `plant_group` (
  `plant_group_id` INT NOT NULL AUTO_INCREMENT ,
  `plant_group_name` VARCHAR(60) NULL ,
  `plant_group_sci_name` VARCHAR(100) NULL ,
  PRIMARY KEY (`plant_group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `plant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `plant` ;

CREATE  TABLE IF NOT EXISTS `plant` (
  `plant_id` INT NOT NULL AUTO_INCREMENT ,
  `plant_name` VARCHAR(45) NOT NULL ,
  `plant_group_id` INT NULL ,
  PRIMARY KEY (`plant_id`) ,
  INDEX `fk_plant_plant_group1` (`plant_group_id` ASC) ,
  CONSTRAINT `fk_plant_plant_group1`
    FOREIGN KEY (`plant_group_id` )
    REFERENCES `plant_group` (`plant_group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ingredient`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ingredient` ;

CREATE  TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` INT NOT NULL AUTO_INCREMENT ,
  `ingredient_name` VARCHAR(45) NOT NULL ,
  `ingredient_description` TEXT NULL ,
  `ingredient_type_id` INT NOT NULL ,
  `vegetable_type_id` INT NULL ,
  `meat_type_id` INT NULL ,
  `fruit_type_id` INT NULL ,
  `plant_id` INT NULL ,
  PRIMARY KEY (`ingredient_id`) ,
  INDEX `fk_item_ingredient_ingredient_type1` (`ingredient_type_id` ASC) ,
  INDEX `fk_ingredient_vegetable_type1` (`vegetable_type_id` ASC) ,
  INDEX `fk_ingredient_meat_type1` (`meat_type_id` ASC) ,
  INDEX `fk_ingredient_fruit_type1` (`fruit_type_id` ASC) ,
  INDEX `fk_ingredient_plant1` (`plant_id` ASC) ,
  CONSTRAINT `fk_item_ingredient_ingredient_type1`
    FOREIGN KEY (`ingredient_type_id` )
    REFERENCES `ingredient_type` (`ingredient_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_vegetable_type1`
    FOREIGN KEY (`vegetable_type_id` )
    REFERENCES `vegetable_type` (`vegetable_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_meat_type1`
    FOREIGN KEY (`meat_type_id` )
    REFERENCES `meat_type` (`meat_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_fruit_type1`
    FOREIGN KEY (`fruit_type_id` )
    REFERENCES `fruit_type` (`fruit_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_plant1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `plant` (`plant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `distributor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `distributor` ;

CREATE  TABLE IF NOT EXISTS `distributor` (
  `distributor_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `creation_date` DATE NOT NULL ,
  `distributor_name` VARCHAR(75) NOT NULL ,
  `custom_url` VARCHAR(75) NULL ,
  `url` VARCHAR(255) NULL ,
  `is_active` TINYINT NOT NULL ,
  PRIMARY KEY (`distributor_id`) ,
  INDEX `fk_distributor_company1` (`company_id` ASC) ,
  CONSTRAINT `fk_distributor_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `farm_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `farm_type` ;

CREATE  TABLE IF NOT EXISTS `farm_type` (
  `farm_type_id` INT NOT NULL AUTO_INCREMENT ,
  `farm_type` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`farm_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `farm`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `farm` ;

CREATE  TABLE IF NOT EXISTS `farm` (
  `farm_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `farm_type_id` INT NULL ,
  `creation_date` DATE NOT NULL ,
  `farm_name` VARCHAR(75) NOT NULL ,
  `custom_url` VARCHAR(75) NULL ,
  `url` VARCHAR(255) NULL ,
  `is_active` TINYINT NOT NULL ,
  PRIMARY KEY (`farm_id`) ,
  INDEX `fk_farm_farm_type1` (`farm_type_id` ASC) ,
  INDEX `fk_farm_company1` (`company_id` ASC) ,
  CONSTRAINT `fk_farm_farm_type1`
    FOREIGN KEY (`farm_type_id` )
    REFERENCES `farm_type` (`farm_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product_impact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_impact` ;

CREATE  TABLE IF NOT EXISTS `product_impact` (
  `product_impact_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NULL ,
  PRIMARY KEY (`product_impact_id`) ,
  INDEX `fk_product_impact_product1` (`product_id` ASC) ,
  CONSTRAINT `fk_product_impact_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cuisine`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cuisine` ;

CREATE  TABLE IF NOT EXISTS `cuisine` (
  `cuisine_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cuisine_name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`cuisine_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 11;


-- -----------------------------------------------------
-- Table `fish`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fish` ;

CREATE  TABLE IF NOT EXISTS `fish` (
  `fish_id` INT NOT NULL AUTO_INCREMENT ,
  `fish_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`fish_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `insect`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `insect` ;

CREATE  TABLE IF NOT EXISTS `insect` (
  `insect_id` INT NOT NULL AUTO_INCREMENT ,
  `insect_name` VARCHAR(45) NOT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`insect_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rating`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rating` ;

CREATE  TABLE IF NOT EXISTS `rating` (
  `rating_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NULL ,
  `rating` INT NULL ,
  `rating_date` DATE NULL ,
  PRIMARY KEY (`rating_id`) ,
  INDEX `fk_rating_product1` (`product_id` ASC) ,
  CONSTRAINT `fk_rating_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_settings` ;

CREATE  TABLE IF NOT EXISTS `user_settings` (
  `user_settings_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`user_settings_id`) ,
  INDEX `fk_user_settings_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_user_settings_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_group` ;

CREATE  TABLE IF NOT EXISTS `user_group` (
  `user_group_id` INT NOT NULL AUTO_INCREMENT ,
  `user_group` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `animal_food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `animal_food` ;

CREATE  TABLE IF NOT EXISTS `animal_food` (
  `animal_food_id` INT NOT NULL AUTO_INCREMENT ,
  `animal_id` INT NOT NULL ,
  `insect_id` INT NULL ,
  `fish_id` INT NULL ,
  `plant_id` INT NULL ,
  PRIMARY KEY (`animal_food_id`) ,
  INDEX `fk_animal_food_animal1` (`animal_id` ASC) ,
  INDEX `fk_animal_food_insect1` (`insect_id` ASC) ,
  INDEX `fk_animal_food_fish1` (`fish_id` ASC) ,
  INDEX `fk_animal_food_plant1` (`plant_id` ASC) ,
  CONSTRAINT `fk_animal_food_animal1`
    FOREIGN KEY (`animal_id` )
    REFERENCES `animal` (`animal_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_insect1`
    FOREIGN KEY (`insect_id` )
    REFERENCES `insect` (`insect_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_fish1`
    FOREIGN KEY (`fish_id` )
    REFERENCES `fish` (`fish_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_plant1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `plant` (`plant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutrition`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutrition` ;

CREATE  TABLE IF NOT EXISTS `nutrition` (
  `nutrition_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NOT NULL ,
  `total_calories` INT NULL ,
  `fat_calories` INT NULL ,
  PRIMARY KEY (`nutrition_id`) ,
  INDEX `fk_nutrition_product1` (`product_id` ASC) ,
  CONSTRAINT `fk_nutrition_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_group_member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_group_member` ;

CREATE  TABLE IF NOT EXISTS `user_group_member` (
  `user_group_member_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `user_group_id` INT NOT NULL ,
  PRIMARY KEY (`user_group_member_id`) ,
  INDEX `fk_user_group_member_user1` (`user_id` ASC) ,
  INDEX `fk_user_group_member_user_group1` (`user_group_id` ASC) ,
  CONSTRAINT `fk_user_group_member_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_member_user_group1`
    FOREIGN KEY (`user_group_id` )
    REFERENCES `user_group` (`user_group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `custom_url`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `custom_url` ;

CREATE  TABLE IF NOT EXISTS `custom_url` (
  `custom_url_id` INT NOT NULL AUTO_INCREMENT ,
  `custom_url` VARCHAR(75) NOT NULL ,
  `company_id` INT NULL ,
  `farm_id` INT NULL ,
  `manufacture_id` INT NULL ,
  `distributor_id` INT NULL ,
  `restaurant_id` INT NULL ,
  `product_id` INT NULL ,
  `user_id` INT NULL ,
  PRIMARY KEY (`custom_url_id`) ,
  INDEX `fk_custom_url_user1` (`user_id` ASC) ,
  INDEX `fk_custom_url_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_custom_url_farm1` (`farm_id` ASC) ,
  INDEX `fk_custom_url_product1` (`product_id` ASC) ,
  INDEX `fk_custom_url_company1` (`company_id` ASC) ,
  INDEX `fk_custom_url_distributor1` (`distributor_id` ASC) ,
  INDEX `fk_custom_url_manufacture1` (`manufacture_id` ASC) ,
  CONSTRAINT `fk_custom_url_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_farm1`
    FOREIGN KEY (`farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_distributor1`
    FOREIGN KEY (`distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_custom_url_manufacture1`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `address` ;

CREATE  TABLE IF NOT EXISTS `address` (
  `address_id` INT NOT NULL AUTO_INCREMENT ,
  `address` VARCHAR(255) NOT NULL ,
  `city` VARCHAR(95) NOT NULL ,
  `city_id` INT NULL ,
  `state_id` INT NOT NULL ,
  `county_id` INT NULL ,
  `zipcode` INT NOT NULL ,
  `country_id` INT NOT NULL ,
  `latitude` VARCHAR(45) NOT NULL ,
  `longitude` VARCHAR(45) NOT NULL ,
  `company_id` INT NULL ,
  `farm_id` INT NULL ,
  `manufacture_id` INT NULL ,
  `distributor_id` INT NULL ,
  `restaurant_id` INT NULL ,
  `msa_id` INT NULL ,
  `pmsa_id` INT NULL ,
  `import_biz_id` INT NULL ,
  `geocoded` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`address_id`) ,
  INDEX `fk_address_city_area1` (`city_id` ASC) ,
  INDEX `fk_address_state1` (`state_id` ASC) ,
  INDEX `fk_address_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_address_farm1` (`farm_id` ASC) ,
  INDEX `fk_address_manufacture1` (`manufacture_id` ASC) ,
  INDEX `fk_address_company1` (`company_id` ASC) ,
  INDEX `fk_address_country1` (`country_id` ASC) ,
  INDEX `fk_address_distributor1` (`distributor_id` ASC) ,
  INDEX `zipcode` (`zipcode` ASC) ,
  CONSTRAINT `fk_address_city_area1`
    FOREIGN KEY (`city_id` )
    REFERENCES `city` (`city_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_farm1`
    FOREIGN KEY (`farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_manufacture1`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `country` (`country_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address_distributor1`
    FOREIGN KEY (`distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product_ingredients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_ingredients` ;

CREATE  TABLE IF NOT EXISTS `product_ingredients` (
  `product_ingredients_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NOT NULL ,
  `ingredient_id` INT NOT NULL ,
  PRIMARY KEY (`product_ingredients_id`) ,
  INDEX `fk_product_ingredients_product1` (`product_id` ASC) ,
  INDEX `fk_product_ingredients_ingredient1` (`ingredient_id` ASC) ,
  CONSTRAINT `fk_product_ingredients_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_ingredients_ingredient1`
    FOREIGN KEY (`ingredient_id` )
    REFERENCES `ingredient` (`ingredient_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant_supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_supplier` ;

CREATE  TABLE IF NOT EXISTS `restaurant_supplier` (
  `restaurant_supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_id` INT NOT NULL ,
  `supplier_farm_id` INT NULL ,
  `supplier_manufacture_id` INT NULL ,
  `supplier_distributor_id` INT NULL ,
  `supplier_restaurant_id` INT NULL ,
  PRIMARY KEY (`restaurant_supplier_id`) ,
  INDEX `fk_restaurant_suppliers_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_restaurant_supplier_farm1` (`supplier_farm_id` ASC) ,
  INDEX `fk_restaurant_supplier_restaurant1` (`supplier_restaurant_id` ASC) ,
  INDEX `fk_restaurant_supplier_distributor1` (`supplier_distributor_id` ASC) ,
  INDEX `fk_restaurant_supplier_manufacture1` (`supplier_manufacture_id` ASC) ,
  CONSTRAINT `fk_restaurant_suppliers_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_supplier_farm1`
    FOREIGN KEY (`supplier_farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_supplier_restaurant1`
    FOREIGN KEY (`supplier_restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_supplier_distributor1`
    FOREIGN KEY (`supplier_distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_supplier_manufacture1`
    FOREIGN KEY (`supplier_manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `manufacture_supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `manufacture_supplier` ;

CREATE  TABLE IF NOT EXISTS `manufacture_supplier` (
  `manufacture_supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `manufacture_id` INT NOT NULL ,
  `supplier_farm_id` INT NULL ,
  `supplier_manufacture_id` INT NULL ,
  `supplier_distributor_id` INT NULL ,
  `supplier_restaurant_id` INT NULL ,
  PRIMARY KEY (`manufacture_supplier_id`) ,
  INDEX `fk_manufacture_supplier_farm1` (`supplier_farm_id` ASC) ,
  INDEX `fk_manufacture_supplier_manufacture1` (`supplier_manufacture_id` ASC) ,
  INDEX `fk_manufacture_supplier_distributor1` (`supplier_distributor_id` ASC) ,
  INDEX `fk_manufacture_supplier_restaurant1` (`supplier_restaurant_id` ASC) ,
  INDEX `fk_manufacture_supplier_manufacture2` (`manufacture_id` ASC) ,
  CONSTRAINT `fk_manufacture_supplier_farm1`
    FOREIGN KEY (`supplier_farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacture_supplier_manufacture1`
    FOREIGN KEY (`supplier_manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacture_supplier_distributor1`
    FOREIGN KEY (`supplier_distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacture_supplier_restaurant1`
    FOREIGN KEY (`supplier_restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacture_supplier_manufacture2`
    FOREIGN KEY (`manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `distributor_supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `distributor_supplier` ;

CREATE  TABLE IF NOT EXISTS `distributor_supplier` (
  `distributor_supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `distributor_id` INT NOT NULL ,
  `supplier_farm_id` INT NULL ,
  `supplier_manufacture_id` INT NULL ,
  `supplier_distributor_id` INT NULL ,
  `supplier_restaurant_id` INT NULL ,
  PRIMARY KEY (`distributor_supplier_id`) ,
  INDEX `fk_distributor_supplier_distributor1` (`distributor_id` ASC) ,
  INDEX `fk_distributor_supplier_farm1` (`supplier_farm_id` ASC) ,
  INDEX `fk_distributor_supplier_manufacture1` (`supplier_manufacture_id` ASC) ,
  INDEX `fk_distributor_supplier_distributor2` (`supplier_distributor_id` ASC) ,
  INDEX `fk_distributor_supplier_restaurant1` (`supplier_restaurant_id` ASC) ,
  CONSTRAINT `fk_distributor_supplier_distributor1`
    FOREIGN KEY (`distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_distributor_supplier_farm1`
    FOREIGN KEY (`supplier_farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_distributor_supplier_manufacture1`
    FOREIGN KEY (`supplier_manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_distributor_supplier_distributor2`
    FOREIGN KEY (`supplier_distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_distributor_supplier_restaurant1`
    FOREIGN KEY (`supplier_restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `farm_supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `farm_supplier` ;

CREATE  TABLE IF NOT EXISTS `farm_supplier` (
  `farm_supplier_id` INT NOT NULL AUTO_INCREMENT ,
  `farm_id` INT NOT NULL ,
  `supplier_farm_id` INT NULL ,
  `supplier_manufacture_id` INT NULL ,
  `supplier_distributor_id` INT NULL ,
  `supplier_restaurant_id` INT NULL ,
  PRIMARY KEY (`farm_supplier_id`) ,
  INDEX `fk_farm_supplier_farm1` (`farm_id` ASC) ,
  INDEX `fk_farm_supplier_farm2` (`supplier_farm_id` ASC) ,
  INDEX `fk_farm_supplier_manufacture1` (`supplier_manufacture_id` ASC) ,
  INDEX `fk_farm_supplier_distributor1` (`supplier_distributor_id` ASC) ,
  INDEX `fk_farm_supplier_restaurant1` (`supplier_restaurant_id` ASC) ,
  CONSTRAINT `fk_farm_supplier_farm1`
    FOREIGN KEY (`farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_supplier_farm2`
    FOREIGN KEY (`supplier_farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_supplier_manufacture1`
    FOREIGN KEY (`supplier_manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_supplier_distributor1`
    FOREIGN KEY (`supplier_distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_supplier_restaurant1`
    FOREIGN KEY (`supplier_restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pmsa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pmsa` ;

CREATE  TABLE IF NOT EXISTS `pmsa` (
  `pmsa_id` INT NOT NULL AUTO_INCREMENT ,
  `pmsa_code` INT NOT NULL ,
  `pmsa` VARCHAR(75) NULL ,
  PRIMARY KEY (`pmsa_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msa` ;

CREATE  TABLE IF NOT EXISTS `msa` (
  `msa_id` INT NOT NULL AUTO_INCREMENT ,
  `msa_code` INT NOT NULL ,
  `msa` VARCHAR(75) NULL ,
  PRIMARY KEY (`msa_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `county`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `county` ;

CREATE  TABLE IF NOT EXISTS `county` (
  `county_id` INT NOT NULL AUTO_INCREMENT ,
  `county` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`county_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant_cuisine`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_cuisine` ;

CREATE  TABLE IF NOT EXISTS `restaurant_cuisine` (
  `restaurant_cuisine_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_id` INT NOT NULL ,
  `cuisine_id` INT NOT NULL ,
  PRIMARY KEY (`restaurant_cuisine_id`) ,
  INDEX `fk_restaurant_cuisine_restaurant1` (`restaurant_id` ASC) ,
  INDEX `fk_restaurant_cuisine_cuisine1` (`cuisine_id` ASC) ,
  CONSTRAINT `fk_restaurant_cuisine_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_cuisine_cuisine1`
    FOREIGN KEY (`cuisine_id` )
    REFERENCES `cuisine` (`cuisine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant_photo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_photo` ;

CREATE  TABLE IF NOT EXISTS `restaurant_photo` (
  `restaurant_photo_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_id` INT NOT NULL ,
  `photo_name` VARCHAR(100) NOT NULL ,
  `org_photo_name` VARCHAR(100) NOT NULL ,
  `path` VARCHAR(255) NOT NULL ,
  `extension` VARCHAR(6) NULL ,
  `mime_type` VARCHAR(45) NULL ,
  `height` INT NULL ,
  `width` INT NULL ,
  PRIMARY KEY (`restaurant_photo_id`) ,
  INDEX `fk_restaurant_photo_restaurant1` (`restaurant_id` ASC) ,
  CONSTRAINT `fk_restaurant_photo_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `seo_page`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `seo_page` ;

CREATE  TABLE IF NOT EXISTS `seo_page` (
  `seo_page_id` INT(4) NOT NULL AUTO_INCREMENT ,
  `page` VARCHAR(45) NULL ,
  `title_tag` TEXT NULL ,
  `meta_description` TEXT NULL ,
  `meta_keywords` TEXT NULL ,
  `h1` VARCHAR(255) NULL ,
  `url` VARCHAR(300) NULL ,
  PRIMARY KEY (`seo_page_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restaurant_chain_supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurant_chain_supplier` ;

CREATE  TABLE IF NOT EXISTS `restaurant_chain_supplier` (
  `restaurant_chain_supplier_id` INT NOT NULL AUTO_INCREMENT COMMENT '	' ,
  `restaurant_chain_id` INT NOT NULL ,
  `supplier_farm_id` INT NULL COMMENT '	' ,
  `supplier_manufacture_id` INT NULL ,
  `supplier_distributor_id` INT NULL ,
  PRIMARY KEY (`restaurant_chain_supplier_id`) ,
  INDEX `fk_restaurant_chain_supplier_restaurant_chain1` (`restaurant_chain_id` ASC) ,
  INDEX `fk_restaurant_chain_supplier_farm1` (`supplier_farm_id` ASC) ,
  INDEX `fk_restaurant_chain_supplier_manufacture1` (`supplier_manufacture_id` ASC) ,
  INDEX `fk_restaurant_chain_supplier_distributor1` (`supplier_distributor_id` ASC) ,
  CONSTRAINT `fk_restaurant_chain_supplier_restaurant_chain1`
    FOREIGN KEY (`restaurant_chain_id` )
    REFERENCES `restaurant_chain` (`restaurant_chain_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_chain_supplier_farm1`
    FOREIGN KEY (`supplier_farm_id` )
    REFERENCES `farm` (`farm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_chain_supplier_manufacture1`
    FOREIGN KEY (`supplier_manufacture_id` )
    REFERENCES `manufacture` (`manufacture_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_chain_supplier_distributor1`
    FOREIGN KEY (`supplier_distributor_id` )
    REFERENCES `distributor` (`distributor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sub_ingredient`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sub_ingredient` ;

CREATE  TABLE IF NOT EXISTS `sub_ingredient` (
  `ingredient_id` INT NOT NULL ,
  `sub_ingredient_id` INT NOT NULL ,
  INDEX `fk_sub_ingredient_ingredient1` (`ingredient_id` ASC) ,
  INDEX `fk_sub_ingredient_ingredient2` (`sub_ingredient_id` ASC) ,
  CONSTRAINT `fk_sub_ingredient_ingredient1`
    FOREIGN KEY (`ingredient_id` )
    REFERENCES `ingredient` (`ingredient_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sub_ingredient_ingredient2`
    FOREIGN KEY (`sub_ingredient_id` )
    REFERENCES `ingredient` (`ingredient_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;