-- phpMyAdmin SQL Dump
-- version 2.11.8.1
-- http://www.phpmyadmin.net
--
-- Host: mysql50-63.wc1:3306
-- Generation Time: May 05, 2010 at 02:56 PM
-- Server version: 5.0.77
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `468258_foodtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) NOT NULL auto_increment,
  `street_number` varchar(45) NOT NULL,
  `street` varchar(85) NOT NULL,
  `city` varchar(95) NOT NULL,
  `city_id` int(11) default NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `latitude` varchar(45) NOT NULL,
  `longitude` varchar(45) NOT NULL,
  `restaurant_id` int(11) default NULL,
  `company_id` int(11) default NULL,
  `farm_id` int(11) default NULL,
  `manufacture_id` int(11) default NULL,
  `distributor_id` int(11) default NULL,
  PRIMARY KEY  (`address_id`),
  KEY `fk_address_city_area1` (`city_id`),
  KEY `fk_address_state1` (`state_id`),
  KEY `fk_address_restaurant1` (`restaurant_id`),
  KEY `fk_address_farm1` (`farm_id`),
  KEY `fk_address_company1` (`company_id`),
  KEY `fk_address_country1` (`country_id`),
  KEY `fk_address_processing_facility1` (`manufacture_id`),
  KEY `fk_address_distribution_center1` (`distributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `address`
--


-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE IF NOT EXISTS `animal` (
  `animal_id` int(11) NOT NULL auto_increment,
  `animal_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`animal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animal_id`, `animal_name`) VALUES
(1, 'Chicken'),
(2, 'Pig'),
(3, 'Turkey'),
(4, 'Cow'),
(5, 'Donkey'),
(6, 'Goat');

-- --------------------------------------------------------

--
-- Table structure for table `animal_food`
--

CREATE TABLE IF NOT EXISTS `animal_food` (
  `animal_food_id` int(11) NOT NULL auto_increment,
  `animal_id` int(11) NOT NULL,
  `insect_id` int(11) default NULL,
  `fish_id` int(11) default NULL,
  `plant_id` int(11) default NULL,
  PRIMARY KEY  (`animal_food_id`),
  KEY `fk_animal_food_animal1` (`animal_id`),
  KEY `fk_animal_food_insect1` (`insect_id`),
  KEY `fk_animal_food_fish1` (`fish_id`),
  KEY `fk_animal_food_plant1` (`plant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `animal_food`
--


-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL auto_increment,
  `state_id` int(11) NOT NULL,
  `city` varchar(95) default NULL,
  PRIMARY KEY  (`city_id`),
  KEY `fk_city_state1` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `city`
--


-- --------------------------------------------------------

--
-- Table structure for table `city_area`
--

CREATE TABLE IF NOT EXISTS `city_area` (
  `city_area_id` int(11) NOT NULL auto_increment,
  `city_id` int(11) NOT NULL,
  `area` varchar(95) NOT NULL,
  PRIMARY KEY  (`city_area_id`),
  KEY `fk_city_area_city1` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `city_area`
--


-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL auto_increment,
  `company_name` varchar(45) NOT NULL,
  `creation_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `company`
--


-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL auto_increment,
  `country_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`) VALUES
(1, 'United States'),
(2, 'Canada'),
(3, 'Germany'),
(4, 'Spain'),
(5, 'France'),
(6, 'Japan'),
(7, 'China'),
(8, 'South Korea'),
(9, 'United Kingdom'),
(10, 'Mexico'),
(11, 'Italy'),
(12, 'Belgium'),
(13, 'Greece'),
(14, 'Norway'),
(15, 'Sweden'),
(16, 'Finland'),
(17, 'Chile'),
(18, 'Denmark'),
(19, 'Poland'),
(20, 'Portugal'),
(21, 'Ireland'),
(22, 'Russia'),
(23, 'Thailand'),
(24, 'Austraila'),
(25, 'New Zealand'),
(26, 'Switzerland'),
(27, 'The Netherlands'),
(28, 'Turkey'),
(29, 'Holland'),
(30, 'Luxembourg'),
(31, 'Austria'),
(32, 'Monte Carlo');

-- --------------------------------------------------------

--
-- Table structure for table `cuisine`
--

CREATE TABLE IF NOT EXISTS `cuisine` (
  `cuisine_id` int(11) NOT NULL auto_increment,
  `cuisine_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`cuisine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `cuisine`
--

INSERT INTO `cuisine` (`cuisine_id`, `cuisine_name`) VALUES
(1, 'Mexican'),
(2, 'Italian'),
(3, 'French'),
(4, 'American'),
(5, 'Asian'),
(6, 'Indian'),
(7, 'Japanese'),
(8, 'Chinese'),
(9, 'Thai'),
(10, 'Spanish'),
(12, 'Swahili'),
(13, 'Korean');

-- --------------------------------------------------------

--
-- Table structure for table `custom_url`
--

CREATE TABLE IF NOT EXISTS `custom_url` (
  `custom_url_id` int(11) NOT NULL auto_increment,
  `custom_url` varchar(75) NOT NULL,
  `user_id` int(11) default NULL,
  `restaurant_id` int(11) default NULL,
  `farm_Id` int(11) default NULL,
  `manufacture_id` int(11) default NULL,
  `distributor_id` int(11) default NULL,
  `product_id` int(11) default NULL,
  `company_id` int(11) default NULL,
  PRIMARY KEY  (`custom_url_id`),
  KEY `fk_custom_url_user1` (`user_id`),
  KEY `fk_custom_url_restaurant1` (`restaurant_id`),
  KEY `fk_custom_url_product1` (`product_id`),
  KEY `fk_custom_url_company1` (`company_id`),
  KEY `fk_custom_url_distributor1` (`distributor_id`),
  KEY `fk_custom_url_manufacture1` (`manufacture_id`),
  KEY `fk_custom_url_farm1` (`farm_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `custom_url`
--


-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE IF NOT EXISTS `distributor` (
  `distributor_id` int(11) NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `distributor_name` varchar(75) NOT NULL,
  `custom_url` varchar(75) default NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY  (`distributor_id`),
  KEY `fk_distributor_company1` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `distributor`
--


-- --------------------------------------------------------

--
-- Table structure for table `distributor_supplier`
--

CREATE TABLE IF NOT EXISTS `distributor_supplier` (
  `distributor_supplier_id` int(11) NOT NULL auto_increment,
  `distributor_id` int(11) NOT NULL,
  `supplier_farm_id` int(11) default NULL,
  `supplier_manufacture_id` int(11) default NULL,
  `supplier_distributor_id` int(11) default NULL,
  `supplier_restaurant_id` int(11) default NULL,
  PRIMARY KEY  (`distributor_supplier_id`),
  KEY `fk_distributor_supplier_distributor1` (`distributor_id`),
  KEY `fk_distributor_supplier_farm1` (`supplier_farm_id`),
  KEY `fk_distributor_supplier_manufacture1` (`supplier_manufacture_id`),
  KEY `fk_distributor_supplier_distributor2` (`supplier_distributor_id`),
  KEY `fk_distributor_supplier_restaurant1` (`supplier_restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `distributor_supplier`
--


-- --------------------------------------------------------

--
-- Table structure for table `farm`
--

CREATE TABLE IF NOT EXISTS `farm` (
  `farm_id` int(11) NOT NULL auto_increment,
  `creation_date` date NOT NULL,
  `farm_name` varchar(75) NOT NULL,
  `custom_url` varchar(75) default NULL,
  `is_active` tinyint(4) NOT NULL,
  `company_id` int(11) NOT NULL,
  `farm_type_id` int(11) default NULL,
  PRIMARY KEY  (`farm_id`),
  KEY `fk_farm_company1` (`company_id`),
  KEY `fk_farm_farm_type1` (`farm_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farm`
--


-- --------------------------------------------------------

--
-- Table structure for table `farm_supplier`
--

CREATE TABLE IF NOT EXISTS `farm_supplier` (
  `farm_supplier_id` int(11) NOT NULL auto_increment,
  `farm_id` int(11) NOT NULL,
  `supplier_farm_id` int(11) default NULL,
  `supplier_manufacture_id` int(11) default NULL,
  `supplier_distributor_id` int(11) default NULL,
  `supplier_restaurant_id` int(11) default NULL,
  PRIMARY KEY  (`farm_supplier_id`),
  KEY `fk_farm_supplier_farm1` (`farm_id`),
  KEY `fk_farm_supplier_farm2` (`supplier_farm_id`),
  KEY `fk_farm_supplier_manufacture1` (`supplier_manufacture_id`),
  KEY `fk_farm_supplier_distributor1` (`supplier_distributor_id`),
  KEY `fk_farm_supplier_restaurant1` (`supplier_restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farm_supplier`
--


-- --------------------------------------------------------

--
-- Table structure for table `farm_type`
--

CREATE TABLE IF NOT EXISTS `farm_type` (
  `farm_type_id` int(11) NOT NULL auto_increment,
  `farm_type` varchar(75) NOT NULL,
  PRIMARY KEY  (`farm_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `farm_type`
--

INSERT INTO `farm_type` (`farm_type_id`, `farm_type`) VALUES
(1, 'Dairy'),
(2, 'Poultry'),
(3, 'Cattle'),
(4, 'Agri-business');

-- --------------------------------------------------------

--
-- Table structure for table `fish`
--

CREATE TABLE IF NOT EXISTS `fish` (
  `fish_id` int(11) NOT NULL auto_increment,
  `fish_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`fish_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `fish`
--

INSERT INTO `fish` (`fish_id`, `fish_name`) VALUES
(1, 'Salmon'),
(2, 'Shark'),
(3, 'Tuna'),
(4, 'Catfish'),
(5, 'Snapper'),
(6, 'Bass');

-- --------------------------------------------------------

--
-- Table structure for table `fruit_type`
--

CREATE TABLE IF NOT EXISTS `fruit_type` (
  `fruit_type_id` int(11) NOT NULL auto_increment,
  `fruit_type` varchar(45) default NULL,
  PRIMARY KEY  (`fruit_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fruit_type`
--

INSERT INTO `fruit_type` (`fruit_type_id`, `fruit_type`) VALUES
(1, 'Pome'),
(2, 'Berry'),
(3, 'Hesperidium'),
(4, 'Aggregate fruit');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int(11) NOT NULL auto_increment,
  `ingredient_name` varchar(45) NOT NULL,
  `ingredient_type_id` int(11) NOT NULL,
  `vegetable_type_id` int(11) default NULL,
  `meat_type_id` int(11) default NULL,
  `fruit_type_id` int(11) default NULL,
  `plant_id` int(11) default NULL,
  PRIMARY KEY  (`ingredient_id`),
  KEY `fk_item_ingredient_ingredient_type1` (`ingredient_type_id`),
  KEY `fk_ingredient_vegetable_type1` (`vegetable_type_id`),
  KEY `fk_ingredient_meat_type1` (`meat_type_id`),
  KEY `fk_ingredient_fruit_type1` (`fruit_type_id`),
  KEY `fk_ingredient_plant1` (`plant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ingredient`
--


-- --------------------------------------------------------

--
-- Table structure for table `ingredient_type`
--

CREATE TABLE IF NOT EXISTS `ingredient_type` (
  `ingredient_type_id` int(11) NOT NULL auto_increment,
  `ingredient_type` varchar(60) default NULL,
  PRIMARY KEY  (`ingredient_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `ingredient_type`
--

INSERT INTO `ingredient_type` (`ingredient_type_id`, `ingredient_type`) VALUES
(1, 'Not Applicable'),
(2, 'Preservatives'),
(3, 'Sweeteners'),
(4, 'Color Additives'),
(5, 'Flavors and Spices'),
(6, 'Flavor Enhancers'),
(7, 'Fat Replacers'),
(8, 'Nutrients'),
(9, 'Emulsifiers'),
(10, 'Stabilizers and Thickeners, Binders, Texturizers'),
(11, 'pH Control Agents and acidulants'),
(12, 'Leavening Agents'),
(13, 'Anti-caking agents'),
(14, 'Humectants'),
(15, 'Yeast Nutrients'),
(16, 'Dough Strengtheners and Conditioners'),
(17, 'Firming Agents'),
(18, 'Enzyme Preparations'),
(19, 'Gases'),
(20, 'Raw Ingredient'),
(21, 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `insect`
--

CREATE TABLE IF NOT EXISTS `insect` (
  `insect_id` int(11) NOT NULL auto_increment,
  `insect_name` varchar(45) NOT NULL,
  `description` text,
  PRIMARY KEY  (`insect_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `insect`
--

INSERT INTO `insect` (`insect_id`, `insect_name`, `description`) VALUES
(2, 'Fly', NULL),
(3, 'Lady Bug', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL auto_increment,
  `item_name` varchar(45) NOT NULL,
  `item_ingredient_labeling` text,
  PRIMARY KEY  (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `item`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_ingredients`
--

CREATE TABLE IF NOT EXISTS `item_ingredients` (
  `item_ingredients_id` int(11) NOT NULL auto_increment,
  `item_ingredient_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`item_ingredients_id`),
  KEY `fk_item_ingredients_item_ingredient1` (`item_ingredient_id`),
  KEY `fk_item_ingredients_item1` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `item_ingredients`
--


-- --------------------------------------------------------

--
-- Table structure for table `manufacture`
--

CREATE TABLE IF NOT EXISTS `manufacture` (
  `manufacture_id` int(11) NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `manufacture_type_id` int(11) default NULL,
  `creation_date` date NOT NULL,
  `manufacture_name` varchar(75) default NULL,
  `custom_url` varchar(75) default NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY  (`manufacture_id`),
  KEY `fk_manufacture_company1` (`company_id`),
  KEY `fk_manufacture_manufacture_type1` (`manufacture_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `manufacture`
--


-- --------------------------------------------------------

--
-- Table structure for table `manufacture_supplier`
--

CREATE TABLE IF NOT EXISTS `manufacture_supplier` (
  `manufacture_supplier_id` int(11) NOT NULL auto_increment,
  `manufacture_id` int(11) NOT NULL,
  `supplier_farm_id` int(11) default NULL,
  `supplier_manufacture_id` int(11) default NULL,
  `supplier_distributor_id` int(11) default NULL,
  `supplier_restaurant_id` int(11) default NULL,
  PRIMARY KEY  (`manufacture_supplier_id`),
  KEY `fk_manufacture_supplier_farm1` (`supplier_farm_id`),
  KEY `fk_manufacture_supplier_manufacture1` (`supplier_manufacture_id`),
  KEY `fk_manufacture_supplier_distributor1` (`supplier_distributor_id`),
  KEY `fk_manufacture_supplier_restaurant1` (`supplier_restaurant_id`),
  KEY `fk_manufacture_supplier_manufacture2` (`manufacture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `manufacture_supplier`
--


-- --------------------------------------------------------

--
-- Table structure for table `manufacture_type`
--

CREATE TABLE IF NOT EXISTS `manufacture_type` (
  `manufacture_type_id` int(11) NOT NULL auto_increment,
  `manufacture_type` varchar(75) NOT NULL,
  PRIMARY KEY  (`manufacture_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `manufacture_type`
--

INSERT INTO `manufacture_type` (`manufacture_type_id`, `manufacture_type`) VALUES
(1, 'Meat'),
(2, 'Poultry'),
(3, 'Seafood'),
(4, 'Dairy'),
(5, 'End Product'),
(6, 'Refining'),
(7, 'Beverage'),
(8, 'Brewery');

-- --------------------------------------------------------

--
-- Table structure for table `meat_type`
--

CREATE TABLE IF NOT EXISTS `meat_type` (
  `meat_type_id` int(11) NOT NULL auto_increment,
  `meat_type` varchar(45) NOT NULL,
  `animal_id` int(11) default NULL,
  PRIMARY KEY  (`meat_type_id`),
  KEY `fk_meat_type_animal1` (`animal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `meat_type`
--

INSERT INTO `meat_type` (`meat_type_id`, `meat_type`, `animal_id`) VALUES
(1, 'Chicken', NULL),
(2, 'Beef', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_item_id` int(11) NOT NULL auto_increment,
  `menu_item_name` varchar(95) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  PRIMARY KEY  (`menu_item_id`),
  KEY `fk_menu_item_restaurant1` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `menu_item`
--


-- --------------------------------------------------------

--
-- Table structure for table `menu_item_ingredients`
--

CREATE TABLE IF NOT EXISTS `menu_item_ingredients` (
  `menu_item_ingredients_id` int(11) NOT NULL auto_increment,
  `menu_item_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY  (`menu_item_ingredients_id`),
  KEY `fk_menu_item_ingredients_ingredient1` (`ingredient_id`),
  KEY `fk_menu_item_ingredients_menu_item1` (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `menu_item_ingredients`
--


-- --------------------------------------------------------

--
-- Table structure for table `nutrition`
--

CREATE TABLE IF NOT EXISTS `nutrition` (
  `nutrition_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `total_calories` int(11) default NULL,
  `fat_calories` int(11) default NULL,
  PRIMARY KEY  (`nutrition_id`),
  KEY `fk_nutrition_product1` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `nutrition`
--


-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `photo_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) default NULL,
  `restaurant_id` int(11) default NULL,
  `menu_item_id` int(11) default NULL,
  `photo_data` blob NOT NULL,
  PRIMARY KEY  (`photo_id`),
  KEY `fk_photo_final_product1` (`product_id`),
  KEY `fk_photo_restaurant1` (`restaurant_id`),
  KEY `fk_photo_menu_item1` (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `photo`
--


-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE IF NOT EXISTS `plant` (
  `plant_id` int(11) NOT NULL auto_increment,
  `plant_name` varchar(45) NOT NULL,
  `plant_group_id` int(11) default NULL,
  PRIMARY KEY  (`plant_id`),
  KEY `fk_plant_plant_group1` (`plant_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `plant`
--


-- --------------------------------------------------------

--
-- Table structure for table `plant_group`
--

CREATE TABLE IF NOT EXISTS `plant_group` (
  `plant_group_id` int(11) NOT NULL auto_increment,
  `plant_group_name` varchar(60) default NULL,
  `plant_group_sci_name` varchar(100) default NULL,
  PRIMARY KEY  (`plant_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `plant_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `restaurant_id` int(11) default NULL,
  `product_type_id` int(11) default NULL,
  `product_name` varchar(90) NOT NULL,
  `brand` varchar(90) default NULL,
  `upc` int(11) default NULL,
  `status` enum('live','queue') NOT NULL,
  `user_id` int(11) default NULL,
  `creation_date` date NOT NULL,
  `modify_date` date default NULL,
  PRIMARY KEY  (`product_id`),
  KEY `fk_product_company1` (`company_id`),
  KEY `fk_product_restaurant1` (`restaurant_id`),
  KEY `fk_product_product_type1` (`product_type_id`),
  KEY `fk_product_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_impact`
--

CREATE TABLE IF NOT EXISTS `product_impact` (
  `product_impact_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) default NULL,
  PRIMARY KEY  (`product_impact_id`),
  KEY `fk_product_impact_product1` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_impact`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE IF NOT EXISTS `product_ingredients` (
  `product_ingredients_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY  (`product_ingredients_id`),
  KEY `fk_product_ingredients_product1` (`product_id`),
  KEY `fk_product_ingredients_ingredient1` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_ingredients`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

CREATE TABLE IF NOT EXISTS `product_items` (
  `product_item_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`product_item_id`),
  KEY `fk_product_items_product1` (`product_id`),
  KEY `fk_product_items_item1` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `product_type_id` int(11) NOT NULL auto_increment,
  `product_type` varchar(45) default NULL,
  PRIMARY KEY  (`product_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type`) VALUES
(1, 'Restaurant Menu Item'),
(2, 'Canned Good'),
(3, 'Frozen');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `rating_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) default NULL,
  `rating` int(11) default NULL,
  `rating_date` date default NULL,
  PRIMARY KEY  (`rating_id`),
  KEY `fk_rating_product1` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rating`
--


-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
  `restaurant_id` int(11) NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `restaurant_type_id` int(11) NOT NULL,
  `restaurant_name` varchar(45) NOT NULL,
  `cuisine_id` int(11) default NULL,
  `creation_date` date NOT NULL,
  `custom_url` varchar(75) default NULL,
  `city_area_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY  (`restaurant_id`),
  KEY `fk_restaurant_restaurant_type1` (`restaurant_type_id`),
  KEY `fk_restaurant_cuisine1` (`cuisine_id`),
  KEY `fk_restaurant_city_area1` (`city_area_id`),
  KEY `fk_restaurant_company1` (`company_id`),
  KEY `fk_restaurant_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `restaurant`
--


-- --------------------------------------------------------

--
-- Table structure for table `restaurant_supplier`
--

CREATE TABLE IF NOT EXISTS `restaurant_supplier` (
  `restaurant_supplier_id` int(11) NOT NULL auto_increment,
  `restaurant_id` int(11) NOT NULL,
  `supplier_farm_id` int(11) default NULL,
  `supplier_manufacture_id` int(11) default NULL,
  `supplier_distributor_id` int(11) default NULL,
  `supplier_restaurant_id` int(11) default NULL,
  PRIMARY KEY  (`restaurant_supplier_id`),
  KEY `fk_restaurant_suppliers_restaurant1` (`restaurant_id`),
  KEY `fk_restaurant_supplier_distributor1` (`supplier_distributor_id`),
  KEY `fk_restaurant_supplier_farm1` (`supplier_farm_id`),
  KEY `fk_restaurant_supplier_manufacture1` (`supplier_manufacture_id`),
  KEY `fk_restaurant_supplier_restaurant1` (`supplier_restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `restaurant_supplier`
--


-- --------------------------------------------------------

--
-- Table structure for table `restaurant_type`
--

CREATE TABLE IF NOT EXISTS `restaurant_type` (
  `restaurant_type_id` int(11) NOT NULL auto_increment,
  `restaurant_type` varchar(45) default NULL,
  PRIMARY KEY  (`restaurant_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `restaurant_type`
--

INSERT INTO `restaurant_type` (`restaurant_type_id`, `restaurant_type`) VALUES
(1, 'Fast Food'),
(2, 'Casual Dining'),
(3, 'Find Dining'),
(4, 'Fast Casual'),
(5, 'Casual Chain');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL auto_increment,
  `state_name` varchar(45) NOT NULL,
  `state_code` char(2) NOT NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`, `state_code`) VALUES
(1, 'Kentucky', 'KY'),
(2, 'Indiana', 'IN'),
(3, 'Ohio', 'OH'),
(4, 'Illinois', 'IL'),
(6, 'New York', 'NY'),
(7, 'Alabama', 'AL'),
(8, 'California', ''),
(9, 'Nevada', ''),
(10, 'Arizona', ''),
(11, 'Texas', ''),
(12, 'Florida', ''),
(13, 'Washington', ''),
(14, 'Alaska', ''),
(15, 'Arkansas', ''),
(16, 'Colorado', ''),
(17, 'Connecticut', ''),
(18, 'Delaware', ''),
(19, 'Georgia', ''),
(20, 'Hawaii', ''),
(21, 'Idaho', ''),
(22, 'D.C.', ''),
(23, 'Iowa', ''),
(24, 'Kansas', ''),
(25, 'Louisiana', ''),
(26, 'Maine', ''),
(27, 'Maryland', ''),
(28, 'Massachusetts', ''),
(29, 'Michigan', ''),
(30, 'Minnesota', ''),
(31, 'Mississippi', ''),
(32, 'Missouri', ''),
(33, 'Montana', ''),
(34, 'Nebraska', ''),
(35, 'New Hampshire', ''),
(36, 'New Jersey', ''),
(37, 'New Mexico', ''),
(38, 'North Carolina', ''),
(39, 'North Dakota', ''),
(40, 'Oklahoma', ''),
(41, 'Oregon', ''),
(42, 'Pennsylvania', ''),
(43, 'Rhode Island', ''),
(44, 'South Carolina', ''),
(45, 'South Dakota', ''),
(46, 'Tennessee', ''),
(47, 'Utah', ''),
(48, 'Vermont', ''),
(49, 'Virginia', ''),
(50, 'West Virginia', ''),
(51, 'Wisconsin', ''),
(52, 'Wyoming', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `email` varchar(45) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `screen_name` varchar(45) default NULL,
  `password` varchar(32) NOT NULL,
  `register_ipaddress` varchar(18) NOT NULL,
  `isActive` int(2) NOT NULL,
  `custom_url` varchar(75) NOT NULL,
  `join_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `latitude` varchar(45) default NULL,
  `longitude` varchar(45) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `zipcode`, `first_name`, `screen_name`, `password`, `register_ipaddress`, `isActive`, `custom_url`, `join_date`, `latitude`, `longitude`) VALUES
(1, 'anaber@gmail.com', 94607, 'Andrew', 'foodSprout', 'c2e604edf5d8ae63056497497a23ed8e', 'localhost', 1, 'anaber', '2010-03-22 00:52:08', NULL, NULL),
(2, 'anaber@ferrarilife.com', 94107, 'Andrew', NULL, 'c2e604edf5d8ae63056497497a23ed8e', '12.130.155.245', 1, '', '2010-04-15 13:24:07', NULL, NULL),
(3, 'oliviamahn@gmail.com', 94131, 'Olivia', NULL, '5bf652cf201ee86533196f345e788d91', '76.14.74.178', 1, '', '2010-05-03 23:53:52', NULL, NULL),
(4, 'deepak.kumar@xcelvations.com', 98004, 'Deepak', NULL, '498b5924adc469aa7b660f457e0fc7e5', '122.177.213.191', 1, '', '2010-05-05 14:13:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_group_id` int(11) NOT NULL auto_increment,
  `user_group` varchar(45) default NULL,
  PRIMARY KEY  (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `user_group`) VALUES
(1, 'admin'),
(2, 'Restaurant - Free'),
(3, 'Restaurant Owner - Paid 1'),
(4, 'Restaurant Owner - Paid 2'),
(5, 'Distributor'),
(6, 'Distributor - Paid');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_member`
--

CREATE TABLE IF NOT EXISTS `user_group_member` (
  `user_group_member_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_group_member_id`),
  KEY `fk_user_group_member_user1` (`user_id`),
  KEY `fk_user_group_member_user_group1` (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_group_member`
--

INSERT INTO `user_group_member` (`user_group_member_id`, `user_id`, `user_group_id`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE IF NOT EXISTS `user_settings` (
  `user_settings_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_settings_id`),
  KEY `fk_user_settings_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `vegetable_type`
--

CREATE TABLE IF NOT EXISTS `vegetable_type` (
  `vegetable_type_id` int(11) NOT NULL auto_increment,
  `vegetable_type` varchar(45) NOT NULL,
  PRIMARY KEY  (`vegetable_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `vegetable_type`
--

INSERT INTO `vegetable_type` (`vegetable_type_id`, `vegetable_type`) VALUES
(1, 'Bulb'),
(2, 'Fruit'),
(3, 'Inflorescent'),
(4, 'Leaf'),
(5, 'Root'),
(6, 'Stalk'),
(7, 'Tuber');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_city_area1` FOREIGN KEY (`city_id`) REFERENCES `city_area` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_country1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_distribution_center1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_farm1` FOREIGN KEY (`farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_processing_facility1` FOREIGN KEY (`manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_address_state1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `animal_food`
--
ALTER TABLE `animal_food`
  ADD CONSTRAINT `fk_animal_food_animal1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_animal_food_fish1` FOREIGN KEY (`fish_id`) REFERENCES `fish` (`fish_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_animal_food_insect1` FOREIGN KEY (`insect_id`) REFERENCES `insect` (`insect_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_animal_food_plant1` FOREIGN KEY (`plant_id`) REFERENCES `plant` (`plant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_city_state1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `city_area`
--
ALTER TABLE `city_area`
  ADD CONSTRAINT `fk_city_area_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `custom_url`
--
ALTER TABLE `custom_url`
  ADD CONSTRAINT `fk_custom_url_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_distributor1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_farm1` FOREIGN KEY (`farm_Id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_manufacture1` FOREIGN KEY (`manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_custom_url_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `distributor`
--
ALTER TABLE `distributor`
  ADD CONSTRAINT `fk_distributor_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `distributor_supplier`
--
ALTER TABLE `distributor_supplier`
  ADD CONSTRAINT `fk_distributor_supplier_distributor1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_distributor_supplier_distributor2` FOREIGN KEY (`supplier_distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_distributor_supplier_farm1` FOREIGN KEY (`supplier_farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_distributor_supplier_manufacture1` FOREIGN KEY (`supplier_manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_distributor_supplier_restaurant1` FOREIGN KEY (`supplier_restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `farm`
--
ALTER TABLE `farm`
  ADD CONSTRAINT `fk_farm_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_farm_farm_type1` FOREIGN KEY (`farm_type_id`) REFERENCES `farm_type` (`farm_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `farm_supplier`
--
ALTER TABLE `farm_supplier`
  ADD CONSTRAINT `fk_farm_supplier_distributor1` FOREIGN KEY (`supplier_distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_farm_supplier_farm1` FOREIGN KEY (`farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_farm_supplier_farm2` FOREIGN KEY (`supplier_farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_farm_supplier_manufacture1` FOREIGN KEY (`supplier_manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_farm_supplier_restaurant1` FOREIGN KEY (`supplier_restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `fk_ingredient_fruit_type1` FOREIGN KEY (`fruit_type_id`) REFERENCES `fruit_type` (`fruit_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingredient_meat_type1` FOREIGN KEY (`meat_type_id`) REFERENCES `meat_type` (`meat_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingredient_plant1` FOREIGN KEY (`plant_id`) REFERENCES `plant` (`plant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingredient_vegetable_type1` FOREIGN KEY (`vegetable_type_id`) REFERENCES `vegetable_type` (`vegetable_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_ingredient_ingredient_type1` FOREIGN KEY (`ingredient_type_id`) REFERENCES `ingredient_type` (`ingredient_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item_ingredients`
--
ALTER TABLE `item_ingredients`
  ADD CONSTRAINT `fk_item_ingredients_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_ingredients_item_ingredient1` FOREIGN KEY (`item_ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `manufacture`
--
ALTER TABLE `manufacture`
  ADD CONSTRAINT `fk_manufacture_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_manufacture_manufacture_type1` FOREIGN KEY (`manufacture_type_id`) REFERENCES `manufacture_type` (`manufacture_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `manufacture_supplier`
--
ALTER TABLE `manufacture_supplier`
  ADD CONSTRAINT `fk_manufacture_supplier_distributor1` FOREIGN KEY (`supplier_distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_manufacture_supplier_farm1` FOREIGN KEY (`supplier_farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_manufacture_supplier_manufacture1` FOREIGN KEY (`supplier_manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_manufacture_supplier_manufacture2` FOREIGN KEY (`manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_manufacture_supplier_restaurant1` FOREIGN KEY (`supplier_restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `meat_type`
--
ALTER TABLE `meat_type`
  ADD CONSTRAINT `fk_meat_type_animal1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `fk_menu_item_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menu_item_ingredients`
--
ALTER TABLE `menu_item_ingredients`
  ADD CONSTRAINT `fk_menu_item_ingredients_ingredient1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_menu_item_ingredients_menu_item1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`menu_item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD CONSTRAINT `fk_nutrition_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `fk_photo_final_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_photo_menu_item1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`menu_item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_photo_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `plant`
--
ALTER TABLE `plant`
  ADD CONSTRAINT `fk_plant_plant_group1` FOREIGN KEY (`plant_group_id`) REFERENCES `plant_group` (`plant_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_product_type1` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_impact`
--
ALTER TABLE `product_impact`
  ADD CONSTRAINT `fk_product_impact_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD CONSTRAINT `fk_product_ingredients_ingredient1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_ingredients_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_items`
--
ALTER TABLE `product_items`
  ADD CONSTRAINT `fk_product_items_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_items_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `fk_restaurant_city_area1` FOREIGN KEY (`city_area_id`) REFERENCES `city_area` (`city_area_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_cuisine1` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisine` (`cuisine_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_restaurant_type1` FOREIGN KEY (`restaurant_type_id`) REFERENCES `restaurant_type` (`restaurant_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `restaurant_supplier`
--
ALTER TABLE `restaurant_supplier`
  ADD CONSTRAINT `fk_restaurant_suppliers_restaurant1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_supplier_distributor1` FOREIGN KEY (`supplier_distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_supplier_farm1` FOREIGN KEY (`supplier_farm_id`) REFERENCES `farm` (`farm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_supplier_manufacture1` FOREIGN KEY (`supplier_manufacture_id`) REFERENCES `manufacture` (`manufacture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_restaurant_supplier_restaurant1` FOREIGN KEY (`supplier_restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_group_member`
--
ALTER TABLE `user_group_member`
  ADD CONSTRAINT `fk_user_group_member_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_group_member_user_group1` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`user_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `fk_user_settings_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
