-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 20, 2010 at 11:54 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `468258_foodtest`
--

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` VALUES(1, 'Chicken');
INSERT INTO `animal` VALUES(2, 'Pig');
INSERT INTO `animal` VALUES(3, 'Turkey');

--
-- Dumping data for table `animal_food`
--


--
-- Dumping data for table `company`
--

INSERT INTO `company` VALUES(1, 'McDonald''s Corporation', NULL, 1, 8, NULL, NULL, NULL);

--
-- Dumping data for table `country`
--

INSERT INTO `country` VALUES(1, 'United States');
INSERT INTO `country` VALUES(2, 'Canada');
INSERT INTO `country` VALUES(3, 'Germany');
INSERT INTO `country` VALUES(4, 'Spain');
INSERT INTO `country` VALUES(5, 'France');
INSERT INTO `country` VALUES(6, 'Japan');
INSERT INTO `country` VALUES(7, 'China');
INSERT INTO `country` VALUES(8, 'South Korea');
INSERT INTO `country` VALUES(9, 'United Kingdom');
INSERT INTO `country` VALUES(10, 'Mexico');
INSERT INTO `country` VALUES(11, 'Italy');
INSERT INTO `country` VALUES(12, 'Belgium');
INSERT INTO `country` VALUES(13, 'Greece');
INSERT INTO `country` VALUES(14, 'Norway');
INSERT INTO `country` VALUES(15, 'Sweden');
INSERT INTO `country` VALUES(16, 'Finland');
INSERT INTO `country` VALUES(17, 'Chile');
INSERT INTO `country` VALUES(18, 'Denmark');
INSERT INTO `country` VALUES(19, 'Poland');
INSERT INTO `country` VALUES(20, 'Portugal');
INSERT INTO `country` VALUES(21, 'Ireland');
INSERT INTO `country` VALUES(22, 'Russia');
INSERT INTO `country` VALUES(23, 'Thailand');
INSERT INTO `country` VALUES(24, 'Austraila');
INSERT INTO `country` VALUES(25, 'New Zealand');
INSERT INTO `country` VALUES(26, 'Switzerland');
INSERT INTO `country` VALUES(27, 'The Netherlands');
INSERT INTO `country` VALUES(28, 'Turkey');
INSERT INTO `country` VALUES(29, 'Holland');
INSERT INTO `country` VALUES(30, 'Luxembourg');
INSERT INTO `country` VALUES(31, 'Austria');
INSERT INTO `country` VALUES(32, 'Monte Carlo');

--
-- Dumping data for table `cuisine`
--

INSERT INTO `cuisine` VALUES(1, 'Mexican');
INSERT INTO `cuisine` VALUES(2, 'Italian');
INSERT INTO `cuisine` VALUES(3, 'French');
INSERT INTO `cuisine` VALUES(4, 'American');
INSERT INTO `cuisine` VALUES(5, 'Asian');
INSERT INTO `cuisine` VALUES(6, 'Indian');
INSERT INTO `cuisine` VALUES(7, 'Japanese');
INSERT INTO `cuisine` VALUES(8, 'Chinese');
INSERT INTO `cuisine` VALUES(9, 'Thai');
INSERT INTO `cuisine` VALUES(10, 'Spanish');

--
-- Dumping data for table `distribution_center`
--


--
-- Dumping data for table `farm`
--


--
-- Dumping data for table `final_product`
--

INSERT INTO `final_product` VALUES(1, 1, NULL, NULL, 'Big Mac', 'McDonald''s', NULL, 'live', NULL, '2010-02-20', NULL);

--
-- Dumping data for table `final_product_impact`
--


--
-- Dumping data for table `fish`
--

INSERT INTO `fish` VALUES(1, 'Salmon');
INSERT INTO `fish` VALUES(2, 'Shark');
INSERT INTO `fish` VALUES(3, 'Tuna');
INSERT INTO `fish` VALUES(4, 'Catfish');
INSERT INTO `fish` VALUES(5, 'Snapper');

--
-- Dumping data for table `fruit_type`
--


--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` VALUES(2, 'broccoli', 20, NULL, NULL, NULL, 6, NULL, NULL, NULL);

--
-- Dumping data for table `ingredient_type`
--

INSERT INTO `ingredient_type` VALUES(1, 'Not Applicable');
INSERT INTO `ingredient_type` VALUES(2, 'Preservatives');
INSERT INTO `ingredient_type` VALUES(3, 'Sweeteners');
INSERT INTO `ingredient_type` VALUES(4, 'Color Additives');
INSERT INTO `ingredient_type` VALUES(5, 'Flavors and Spices');
INSERT INTO `ingredient_type` VALUES(6, 'Flavor Enhancers');
INSERT INTO `ingredient_type` VALUES(7, 'Fat Replacers');
INSERT INTO `ingredient_type` VALUES(8, 'Nutrients');
INSERT INTO `ingredient_type` VALUES(9, 'Emulsifiers');
INSERT INTO `ingredient_type` VALUES(10, 'Stabilizers and Thickeners, Binders, Texturizers');
INSERT INTO `ingredient_type` VALUES(11, 'pH Control Agents and acidulants');
INSERT INTO `ingredient_type` VALUES(12, 'Leavening Agents');
INSERT INTO `ingredient_type` VALUES(13, 'Anti-caking agents');
INSERT INTO `ingredient_type` VALUES(14, 'Humectants');
INSERT INTO `ingredient_type` VALUES(15, 'Yeast Nutrients');
INSERT INTO `ingredient_type` VALUES(16, 'Dough Strengtheners and Conditioners');
INSERT INTO `ingredient_type` VALUES(17, 'Firming Agents');
INSERT INTO `ingredient_type` VALUES(18, 'Enzyme Preparations');
INSERT INTO `ingredient_type` VALUES(19, 'Gases');
INSERT INTO `ingredient_type` VALUES(20, 'Raw Ingredient');
INSERT INTO `ingredient_type` VALUES(21, 'Unknown');

--
-- Dumping data for table `insect`
--


--
-- Dumping data for table `item`
--

INSERT INTO `item` VALUES(1, 'Beef Patty', NULL);
INSERT INTO `item` VALUES(2, 'Big Mac Bun', 'Enriched flour (bleached wheat flour, malted barley flour, niacin, reduced iron, thiamin mononitrate, riboflavin, folic acid, enzymes), water, high fructose corn syrup, sugar, soybean oil and/or partially hydrogenated soybean oil, contains 2% or less of the following: salt, calcium sulfate, calcium carbonate, wheat gluten, ammonium sulfate, ammonium chloride, dough conditioners (sodium stearoyl lactylate, datem, ascorbic acid, azodicarbonamide, mono- and diglycerides, ethoxylated monoglycerides, monocalcium phosphate, enzymes, guar gum, calcium peroxide, soy flour), calcium propionate and sodium propionate (preservatives), soy lecithin, sesame seed.');
INSERT INTO `item` VALUES(3, 'Pasteurized Process American Cheese', 'Milk, water, milkfat, cheese culture, sodium citrate, salt, citric acid, sorbic acid (preservative), sodium phosphate, artificial color, lactic acid, acetic acid, enzymes, soy lecithin (added for slice separation).');
INSERT INTO `item` VALUES(4, 'Big Mac Sauce', 'Soybean oil, pickle relish [diced pickles, high fructose corn syrup, sugar, vinegar, corn syrup, salt, calcium chloride, xanthan gum, potassium sorbate (preservative), spice extractives, polysorbate 80], distilled vinegar, water, egg yolks, high fructose corn syrup, onion powder, mustard seed, salt, spices, propylene glycol alginate, sodium benzoate (preservative), mustard bran, sugar, garlic powder, vegetable protein (hydrolyzed corn, soy and wheat), caramel color, extractives of paprika, soy lecithin, turmeric (color), calcium disodium EDTA (protect flavor).');
INSERT INTO `item` VALUES(5, 'Lettuce', NULL);
INSERT INTO `item` VALUES(6, 'Pickle Slices', 'Cucumbers, water, distilled vinegar, salt, calcium chloride, alum, potassium sorbate (preservative), natural flavors (plant source), polysorbate 80, extractives of turmeric (color)');
INSERT INTO `item` VALUES(7, 'Slivered Onions', NULL);

--
-- Dumping data for table `item_ingredients`
--


--
-- Dumping data for table `item_processing_facility`
--


--
-- Dumping data for table `meat_type`
--


--
-- Dumping data for table `nutrition`
--


--
-- Dumping data for table `photo`
--


--
-- Dumping data for table `plant`
--


--
-- Dumping data for table `plant_group`
--


--
-- Dumping data for table `processing_facility`
--


--
-- Dumping data for table `processing_facility_type`
--


--
-- Dumping data for table `product_items`
--

INSERT INTO `product_items` VALUES(1, 1, 6);
INSERT INTO `product_items` VALUES(2, 1, 7);
INSERT INTO `product_items` VALUES(3, 1, 5);
INSERT INTO `product_items` VALUES(4, 1, 4);
INSERT INTO `product_items` VALUES(5, 1, 2);
INSERT INTO `product_items` VALUES(6, 1, 3);
INSERT INTO `product_items` VALUES(7, 1, 1);

--
-- Dumping data for table `product_type`
--


--
-- Dumping data for table `rating`
--


--
-- Dumping data for table `restaurant`
--


--
-- Dumping data for table `restaurant_type`
--

INSERT INTO `restaurant_type` VALUES(1, 'Fast Food');
INSERT INTO `restaurant_type` VALUES(2, 'Casual Dining');
INSERT INTO `restaurant_type` VALUES(3, 'Find Dining');

--
-- Dumping data for table `state`
--

INSERT INTO `state` VALUES(1, 'Kentucky');
INSERT INTO `state` VALUES(2, 'Indiana');
INSERT INTO `state` VALUES(3, 'Ohio');
INSERT INTO `state` VALUES(4, 'Illinois');
INSERT INTO `state` VALUES(6, 'New York');
INSERT INTO `state` VALUES(7, 'Alabama');
INSERT INTO `state` VALUES(8, 'California');
INSERT INTO `state` VALUES(9, 'Nevada');
INSERT INTO `state` VALUES(10, 'Arizona');
INSERT INTO `state` VALUES(11, 'Texas');
INSERT INTO `state` VALUES(12, 'Florida');
INSERT INTO `state` VALUES(13, 'Washington');
INSERT INTO `state` VALUES(14, 'Alaska');
INSERT INTO `state` VALUES(15, 'Arkansas');
INSERT INTO `state` VALUES(16, 'Colorado');
INSERT INTO `state` VALUES(17, 'Connecticut');
INSERT INTO `state` VALUES(18, 'Delaware');
INSERT INTO `state` VALUES(19, 'Georgia');
INSERT INTO `state` VALUES(20, 'Hawaii');
INSERT INTO `state` VALUES(21, 'Idaho');
INSERT INTO `state` VALUES(22, 'D.C.');
INSERT INTO `state` VALUES(23, 'Iowa');
INSERT INTO `state` VALUES(24, 'Kansas');
INSERT INTO `state` VALUES(25, 'Louisiana');
INSERT INTO `state` VALUES(26, 'Maine');
INSERT INTO `state` VALUES(27, 'Maryland');
INSERT INTO `state` VALUES(28, 'Massachusetts');
INSERT INTO `state` VALUES(29, 'Michigan');
INSERT INTO `state` VALUES(30, 'Minnesota');
INSERT INTO `state` VALUES(31, 'Mississippi');
INSERT INTO `state` VALUES(32, 'Missouri');
INSERT INTO `state` VALUES(33, 'Montana');
INSERT INTO `state` VALUES(34, 'Nebraska');
INSERT INTO `state` VALUES(35, 'New Hampshire');
INSERT INTO `state` VALUES(36, 'New Jersey');
INSERT INTO `state` VALUES(37, 'New Mexico');
INSERT INTO `state` VALUES(38, 'North Carolina');
INSERT INTO `state` VALUES(39, 'North Dakota');
INSERT INTO `state` VALUES(40, 'Oklahoma');
INSERT INTO `state` VALUES(41, 'Oregon');
INSERT INTO `state` VALUES(42, 'Pennsylvania');
INSERT INTO `state` VALUES(43, 'Rhode Island');
INSERT INTO `state` VALUES(44, 'South Carolina');
INSERT INTO `state` VALUES(45, 'South Dakota');
INSERT INTO `state` VALUES(46, 'Tennessee');
INSERT INTO `state` VALUES(47, 'Utah');
INSERT INTO `state` VALUES(48, 'Vermont');
INSERT INTO `state` VALUES(49, 'Virginia');
INSERT INTO `state` VALUES(50, 'West Virginia');
INSERT INTO `state` VALUES(51, 'Wisconsin');
INSERT INTO `state` VALUES(52, 'Wyoming');

--
-- Dumping data for table `user`
--


--
-- Dumping data for table `user_group`
--


--
-- Dumping data for table `user_group_member`
--


--
-- Dumping data for table `user_settings`
--


--
-- Dumping data for table `vegetable_type`
--

INSERT INTO `vegetable_type` VALUES(1, 'Bulb');
INSERT INTO `vegetable_type` VALUES(2, 'Fruit');
INSERT INTO `vegetable_type` VALUES(3, 'Inflorescent');
INSERT INTO `vegetable_type` VALUES(4, 'Leaf');
INSERT INTO `vegetable_type` VALUES(5, 'Root');
INSERT INTO `vegetable_type` VALUES(6, 'Stalk');
INSERT INTO `vegetable_type` VALUES(7, 'Tuber');
