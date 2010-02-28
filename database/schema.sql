SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `468258_foodtest` ;
CREATE SCHEMA IF NOT EXISTS `468258_foodtest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;

-- -----------------------------------------------------
-- Table `468258_foodtest`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`country` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`country` (
  `country_id` INT NOT NULL AUTO_INCREMENT ,
  `country_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`country_id`) )
ENGINE = InnoDB
COMMENT = 'Lists of Countries in the world';


-- -----------------------------------------------------
-- Table `468258_foodtest`.`state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`state` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`state` (
  `state_id` INT NOT NULL AUTO_INCREMENT ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`state_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`company` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`company` (
  `company_id` INT NOT NULL AUTO_INCREMENT ,
  `company_name` VARCHAR(45) NULL ,
  `country_id` INT NOT NULL ,
  `state_id` INT NOT NULL ,
  `city` VARCHAR(45) NULL ,
  `street_address` VARCHAR(60) NULL ,
  `zipcode` INT NULL ,
  `creation_date` DATE NULL ,
  PRIMARY KEY (`company_id`) ,
  CONSTRAINT `fk_company_country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `468258_foodtest`.`country` (`country_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_company_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `468258_foodtest`.`state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_company_country1` ON `468258_foodtest`.`company` (`country_id` ASC) ;

CREATE INDEX `fk_company_state1` ON `468258_foodtest`.`company` (`state_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`restaurant_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`restaurant_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`restaurant_type` (
  `restaurant_type_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`restaurant_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`cuisine`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`cuisine` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`cuisine` (
  `cuisine_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cuisine` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`cuisine_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 11;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`restaurant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`restaurant` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`restaurant` (
  `restaurant_id` INT NOT NULL AUTO_INCREMENT ,
  `restaurant_type_id` INT NOT NULL ,
  `restaurant_name` VARCHAR(45) NULL ,
  `cuisine_id` INT NULL ,
  `country_id` INT NOT NULL ,
  `state_id` INT NULL ,
  `city` VARCHAR(45) NULL ,
  `zipcode` INT NULL ,
  `street_address` VARCHAR(60) NULL ,
  `street_number` INT NULL ,
  `street_name` VARCHAR(60) NULL ,
  `creation_date` DATE NULL ,
  PRIMARY KEY (`restaurant_id`) ,
  CONSTRAINT `fk_restaurant_restaurant_type1`
    FOREIGN KEY (`restaurant_type_id` )
    REFERENCES `468258_foodtest`.`restaurant_type` (`restaurant_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `468258_foodtest`.`state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_cuisine1`
    FOREIGN KEY (`cuisine_id` )
    REFERENCES `468258_foodtest`.`cuisine` (`cuisine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_restaurant_restaurant_type1` ON `468258_foodtest`.`restaurant` (`restaurant_type_id` ASC) ;

CREATE INDEX `fk_restaurant_state1` ON `468258_foodtest`.`restaurant` (`state_id` ASC) ;

CREATE INDEX `fk_restaurant_cuisine1` ON `468258_foodtest`.`restaurant` (`cuisine_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`product_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`product_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`product_type` (
  `product_type_id` INT NOT NULL AUTO_INCREMENT ,
  `product_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`product_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`user` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(45) NULL ,
  `zipcode` INT NULL ,
  `first_name` VARCHAR(45) NULL ,
  `screen_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
COMMENT = 'Users of the website';


-- -----------------------------------------------------
-- Table `468258_foodtest`.`final_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`final_product` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`final_product` (
  `final_product_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `restaurant_id` INT NULL ,
  `product_type_id` INT NULL ,
  `final_product_name` VARCHAR(90) NOT NULL ,
  `brand` VARCHAR(90) NULL ,
  `upc` INT NULL ,
  `status` ENUM('live','queue') NOT NULL ,
  `user_id` INT NULL ,
  `creation_date` DATE NOT NULL ,
  `modify_date` DATE NULL ,
  PRIMARY KEY (`final_product_id`) ,
  CONSTRAINT `fk_final_product_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `468258_foodtest`.`company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_final_product_restaurant1`
    FOREIGN KEY (`restaurant_id` )
    REFERENCES `468258_foodtest`.`restaurant` (`restaurant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_final_product_product_type1`
    FOREIGN KEY (`product_type_id` )
    REFERENCES `468258_foodtest`.`product_type` (`product_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_final_product_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `468258_foodtest`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_final_product_company1` ON `468258_foodtest`.`final_product` (`company_id` ASC) ;

CREATE INDEX `fk_final_product_restaurant1` ON `468258_foodtest`.`final_product` (`restaurant_id` ASC) ;

CREATE INDEX `fk_final_product_product_type1` ON `468258_foodtest`.`final_product` (`product_type_id` ASC) ;

CREATE INDEX `fk_final_product_user1` ON `468258_foodtest`.`final_product` (`user_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`item` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`item` (
  `item_id` INT NOT NULL AUTO_INCREMENT COMMENT '	' ,
  `item_name` VARCHAR(45) NOT NULL ,
  `item_ingredient_labeling` TEXT NULL ,
  PRIMARY KEY (`item_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`product_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`product_items` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`product_items` (
  `product_item_id` INT NOT NULL AUTO_INCREMENT ,
  `final_product_id` INT NOT NULL ,
  `item_id` INT NOT NULL ,
  PRIMARY KEY (`product_item_id`) ,
  CONSTRAINT `fk_product_items_final_product1`
    FOREIGN KEY (`final_product_id` )
    REFERENCES `468258_foodtest`.`final_product` (`final_product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_items_item1`
    FOREIGN KEY (`item_id` )
    REFERENCES `468258_foodtest`.`item` (`item_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_product_items_final_product1` ON `468258_foodtest`.`product_items` (`final_product_id` ASC) ;

CREATE INDEX `fk_product_items_item1` ON `468258_foodtest`.`product_items` (`item_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`processing_facility_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`processing_facility_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`processing_facility_type` (
  `processing_facility_type_id` INT NOT NULL AUTO_INCREMENT ,
  `processing_facility_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`processing_facility_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`processing_facility`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`processing_facility` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`processing_facility` (
  `processing_facility_id` INT NOT NULL AUTO_INCREMENT COMMENT '	' ,
  `processing_facility_name` VARCHAR(45) NULL ,
  `processing_facility_type_id` INT NULL ,
  `country_id` INT NULL ,
  `state_id` INT NULL ,
  `zipcode` INT NULL ,
  `city` VARCHAR(45) NULL ,
  `street_address` VARCHAR(45) NULL ,
  PRIMARY KEY (`processing_facility_id`) ,
  CONSTRAINT `fk_processing_facility_processing_facility_type1`
    FOREIGN KEY (`processing_facility_type_id` )
    REFERENCES `468258_foodtest`.`processing_facility_type` (`processing_facility_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_processing_facility_processing_facility_type1` ON `468258_foodtest`.`processing_facility` (`processing_facility_type_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`item_processing_facility`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`item_processing_facility` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`item_processing_facility` (
  `item_processing_facility_id` INT NOT NULL AUTO_INCREMENT ,
  `item_id` INT NOT NULL ,
  `processing_facility_id` INT NOT NULL ,
  PRIMARY KEY (`item_processing_facility_id`, `item_id`, `processing_facility_id`) ,
  CONSTRAINT `fk_item_processing_facility_item1`
    FOREIGN KEY (`item_id` )
    REFERENCES `468258_foodtest`.`item` (`item_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_processing_facility_processing_facility1`
    FOREIGN KEY (`processing_facility_id` )
    REFERENCES `468258_foodtest`.`processing_facility` (`processing_facility_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_item_processing_facility_item1` ON `468258_foodtest`.`item_processing_facility` (`item_id` ASC) ;

CREATE INDEX `fk_item_processing_facility_processing_facility1` ON `468258_foodtest`.`item_processing_facility` (`processing_facility_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`ingredient_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`ingredient_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`ingredient_type` (
  `ingredient_type_id` INT NOT NULL AUTO_INCREMENT ,
  `ingredient_type` VARCHAR(60) NULL ,
  PRIMARY KEY (`ingredient_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`vegetable_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`vegetable_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`vegetable_type` (
  `vegetable_type_id` INT NOT NULL AUTO_INCREMENT ,
  `vegetable_type` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`vegetable_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`animal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`animal` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`animal` (
  `animal_id` INT NOT NULL AUTO_INCREMENT ,
  `animal_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`animal_id`) )
ENGINE = InnoDB
COMMENT = 'Listing of all the animals in the food chain';


-- -----------------------------------------------------
-- Table `468258_foodtest`.`meat_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`meat_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`meat_type` (
  `meat_type_id` INT NOT NULL AUTO_INCREMENT ,
  `meat_type` VARCHAR(45) NOT NULL ,
  `animal_id` INT NULL ,
  PRIMARY KEY (`meat_type_id`) ,
  CONSTRAINT `fk_meat_type_animal1`
    FOREIGN KEY (`animal_id` )
    REFERENCES `468258_foodtest`.`animal` (`animal_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_meat_type_animal1` ON `468258_foodtest`.`meat_type` (`animal_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`fruit_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`fruit_type` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`fruit_type` (
  `fruit_type_id` INT NOT NULL AUTO_INCREMENT ,
  `fruit_type` VARCHAR(45) NULL ,
  PRIMARY KEY (`fruit_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`plant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`plant` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`plant` (
  `plant_id` INT NOT NULL AUTO_INCREMENT ,
  `plant_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`plant_id`) )
ENGINE = InnoDB
COMMENT = 'Listing of all plants in the food chain';


-- -----------------------------------------------------
-- Table `468258_foodtest`.`ingredient`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`ingredient` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`ingredient` (
  `ingredient_id` INT NOT NULL AUTO_INCREMENT ,
  `ingredient_name` VARCHAR(45) NOT NULL ,
  `ingredient_type_id` INT NOT NULL ,
  `natural` VARCHAR(45) NULL ,
  `organic` VARCHAR(45) NULL ,
  `non-natural` VARCHAR(45) NULL ,
  `vegetable_type_Id` INT NULL ,
  `meat_type_id` INT NULL ,
  `fruit_type_id` INT NULL ,
  `plant_id` INT NULL ,
  PRIMARY KEY (`ingredient_id`) ,
  CONSTRAINT `fk_item_ingredient_ingredient_type1`
    FOREIGN KEY (`ingredient_type_id` )
    REFERENCES `468258_foodtest`.`ingredient_type` (`ingredient_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_vegetable_type1`
    FOREIGN KEY (`vegetable_type_Id` )
    REFERENCES `468258_foodtest`.`vegetable_type` (`vegetable_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_meat_type1`
    FOREIGN KEY (`meat_type_id` )
    REFERENCES `468258_foodtest`.`meat_type` (`meat_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_fruit_type1`
    FOREIGN KEY (`fruit_type_id` )
    REFERENCES `468258_foodtest`.`fruit_type` (`fruit_type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingredient_plant1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `468258_foodtest`.`plant` (`plant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_item_ingredient_ingredient_type1` ON `468258_foodtest`.`ingredient` (`ingredient_type_id` ASC) ;

CREATE INDEX `fk_ingredient_vegetable_type1` ON `468258_foodtest`.`ingredient` (`vegetable_type_Id` ASC) ;

CREATE INDEX `fk_ingredient_meat_type1` ON `468258_foodtest`.`ingredient` (`meat_type_id` ASC) ;

CREATE INDEX `fk_ingredient_fruit_type1` ON `468258_foodtest`.`ingredient` (`fruit_type_id` ASC) ;

CREATE INDEX `fk_ingredient_plant1` ON `468258_foodtest`.`ingredient` (`plant_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`distribution_center`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`distribution_center` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`distribution_center` (
  `distribution_center_id` INT NOT NULL AUTO_INCREMENT ,
  `distribution_center` VARCHAR(45) NOT NULL ,
  `country_id` INT NULL ,
  `state_id` INT NULL ,
  `city` VARCHAR(45) NULL ,
  `street_address` VARCHAR(60) NULL ,
  `zipcode` INT NULL ,
  `creation_date` DATE NULL ,
  PRIMARY KEY (`distribution_center_id`) ,
  CONSTRAINT `fk_distribution_center_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `468258_foodtest`.`state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_distribution_center_state1` ON `468258_foodtest`.`distribution_center` (`state_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`farm`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`farm` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`farm` (
  `farm_id` INT NOT NULL AUTO_INCREMENT ,
  `farm_name` VARCHAR(45) NOT NULL ,
  `country_id` INT NULL ,
  `state_id` INT NOT NULL ,
  `zipcode` INT NULL ,
  `street_address` VARCHAR(60) NULL ,
  `creation_date` DATE NULL ,
  PRIMARY KEY (`farm_id`) ,
  CONSTRAINT `fk_farm_state1`
    FOREIGN KEY (`state_id` )
    REFERENCES `468258_foodtest`.`state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_farm_country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `468258_foodtest`.`country` (`country_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_farm_state1` ON `468258_foodtest`.`farm` (`state_id` ASC) ;

CREATE INDEX `fk_farm_country1` ON `468258_foodtest`.`farm` (`country_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`item_ingredients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`item_ingredients` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`item_ingredients` (
  `item_ingredients_id` INT NOT NULL AUTO_INCREMENT ,
  `item_ingredient_id` INT NOT NULL ,
  `item_id` INT NOT NULL ,
  PRIMARY KEY (`item_ingredients_id`) ,
  CONSTRAINT `fk_item_ingredients_item_ingredient1`
    FOREIGN KEY (`item_ingredient_id` )
    REFERENCES `468258_foodtest`.`ingredient` (`ingredient_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_ingredients_item1`
    FOREIGN KEY (`item_id` )
    REFERENCES `468258_foodtest`.`item` (`item_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_item_ingredients_item_ingredient1` ON `468258_foodtest`.`item_ingredients` (`item_ingredient_id` ASC) ;

CREATE INDEX `fk_item_ingredients_item1` ON `468258_foodtest`.`item_ingredients` (`item_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`final_product_impact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`final_product_impact` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`final_product_impact` (
  `final_product_impact_id` INT NOT NULL AUTO_INCREMENT ,
  `final_product_id` INT NULL ,
  PRIMARY KEY (`final_product_impact_id`) ,
  CONSTRAINT `fk_final_product_impact_final_product1`
    FOREIGN KEY (`final_product_id` )
    REFERENCES `468258_foodtest`.`final_product` (`final_product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_final_product_impact_final_product1` ON `468258_foodtest`.`final_product_impact` (`final_product_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`photo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`photo` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`photo` (
  `photo_id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`photo_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`fish`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`fish` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`fish` (
  `fish_id` INT NOT NULL AUTO_INCREMENT ,
  `fish_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`fish_id`) )
ENGINE = InnoDB
COMMENT = 'Listing of all the fish in the food chain';


-- -----------------------------------------------------
-- Table `468258_foodtest`.`insect`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`insect` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`insect` (
  `insect_Id` INT NOT NULL AUTO_INCREMENT ,
  `insect_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`insect_Id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`rating`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`rating` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`rating` (
  `rating_id` INT NOT NULL AUTO_INCREMENT ,
  `final_product_id` INT NULL ,
  `rating` INT NULL ,
  `rating_date` DATE NULL ,
  PRIMARY KEY (`rating_id`) ,
  CONSTRAINT `fk_rating_final_product1`
    FOREIGN KEY (`final_product_id` )
    REFERENCES `468258_foodtest`.`final_product` (`final_product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_rating_final_product1` ON `468258_foodtest`.`rating` (`final_product_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`user_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`user_settings` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`user_settings` (
  `user_settings_id` INT NOT NULL ,
  PRIMARY KEY (`user_settings_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`user_group` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`user_group` (
  `user_group_id` INT NOT NULL AUTO_INCREMENT ,
  `user_group` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`animal_food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`animal_food` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`animal_food` (
  `animal_food_id` INT NOT NULL AUTO_INCREMENT ,
  `animal_id` INT NOT NULL ,
  `insect_id` INT NULL ,
  `fish_id` INT NULL ,
  `plant_id` INT NULL ,
  PRIMARY KEY (`animal_food_id`) ,
  CONSTRAINT `fk_animal_food_animal1`
    FOREIGN KEY (`animal_id` )
    REFERENCES `468258_foodtest`.`animal` (`animal_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_insect1`
    FOREIGN KEY (`insect_id` )
    REFERENCES `468258_foodtest`.`insect` (`insect_Id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_fish1`
    FOREIGN KEY (`fish_id` )
    REFERENCES `468258_foodtest`.`fish` (`fish_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_food_plant1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `468258_foodtest`.`plant` (`plant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'All the different things an animal may eat';

CREATE INDEX `fk_animal_food_animal1` ON `468258_foodtest`.`animal_food` (`animal_id` ASC) ;

CREATE INDEX `fk_animal_food_insect1` ON `468258_foodtest`.`animal_food` (`insect_id` ASC) ;

CREATE INDEX `fk_animal_food_fish1` ON `468258_foodtest`.`animal_food` (`fish_id` ASC) ;

CREATE INDEX `fk_animal_food_plant1` ON `468258_foodtest`.`animal_food` (`plant_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`plant_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`plant_group` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`plant_group` (
  `plant_group_id` INT NOT NULL AUTO_INCREMENT ,
  `plant_group_name` VARCHAR(60) NULL ,
  `plant_group_sci_name` VARCHAR(100) NULL ,
  PRIMARY KEY (`plant_group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`nutrition`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`nutrition` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`nutrition` (
  `nutrition_id` INT NOT NULL AUTO_INCREMENT ,
  `final_product_id` INT NOT NULL ,
  `total_calories` INT NULL ,
  `fat_calories` INT NULL ,
  PRIMARY KEY (`nutrition_id`) ,
  CONSTRAINT `fk_nutrition_final_product1`
    FOREIGN KEY (`final_product_id` )
    REFERENCES `468258_foodtest`.`final_product` (`final_product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_nutrition_final_product1` ON `468258_foodtest`.`nutrition` (`final_product_id` ASC) ;


-- -----------------------------------------------------
-- Table `468258_foodtest`.`user_group_member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `468258_foodtest`.`user_group_member` ;

CREATE  TABLE IF NOT EXISTS `468258_foodtest`.`user_group_member` (
  `user_group_member_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `user_group_id` INT NOT NULL ,
  PRIMARY KEY (`user_group_member_id`) ,
  CONSTRAINT `fk_user_group_member_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `468258_foodtest`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_member_user_group1`
    FOREIGN KEY (`user_group_id` )
    REFERENCES `468258_foodtest`.`user_group` (`user_group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_user_group_member_user1` ON `468258_foodtest`.`user_group_member` (`user_id` ASC) ;

CREATE INDEX `fk_user_group_member_user_group1` ON `468258_foodtest`.`user_group_member` (`user_group_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
