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
-- Dumping data for table `animal`
--

INSERT INTO `animal` VALUES(1, 'Chicken');
INSERT INTO `animal` VALUES(2, 'Pig');
INSERT INTO `animal` VALUES(3, 'Turkey');

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

INSERT INTO `cuisine` VALUES(1, 'American');
INSERT INTO `cuisine` VALUES(2, 'Armenian');
INSERT INTO `cuisine` VALUES(3, 'Asian');
INSERT INTO `cuisine` VALUES(4, 'Barbecue');
INSERT INTO `cuisine` VALUES(5, 'Basque');
INSERT INTO `cuisine` VALUES(6, 'Breakfast & Brunch');
INSERT INTO `cuisine` VALUES(7, 'Buffets');
INSERT INTO `cuisine` VALUES(8, 'Cajun & Creole');
INSERT INTO `cuisine` VALUES(9, 'Chinese');
INSERT INTO `cuisine` VALUES(10, 'Continental');
INSERT INTO `cuisine` VALUES(11, 'Desserts');
INSERT INTO `cuisine` VALUES(12, 'Dim Sum');
INSERT INTO `cuisine` VALUES(13, 'Fast Food');
INSERT INTO `cuisine` VALUES(14, 'Fish & Chips');
INSERT INTO `cuisine` VALUES(15, 'French');
INSERT INTO `cuisine` VALUES(16, 'German');
INSERT INTO `cuisine` VALUES(17, 'Gourmet');
INSERT INTO `cuisine` VALUES(18, 'Greek');
INSERT INTO `cuisine` VALUES(19, 'Health Food');
INSERT INTO `cuisine` VALUES(20, 'Home Style');
INSERT INTO `cuisine` VALUES(21, 'Ice Cream & Desserts');
INSERT INTO `cuisine` VALUES(22, 'Indian');
INSERT INTO `cuisine` VALUES(23, 'Italian');
INSERT INTO `cuisine` VALUES(24, 'Jamaican');
INSERT INTO `cuisine` VALUES(25, 'Japanese');
INSERT INTO `cuisine` VALUES(26, 'Korean');
INSERT INTO `cuisine` VALUES(27, 'Kosher');
INSERT INTO `cuisine` VALUES(28, 'Latin American');
INSERT INTO `cuisine` VALUES(29, 'Mediterranean');
INSERT INTO `cuisine` VALUES(30, 'Mexican');
INSERT INTO `cuisine` VALUES(31, 'New American');
INSERT INTO `cuisine` VALUES(32, 'Oriental');
INSERT INTO `cuisine` VALUES(33, 'Pasta');
INSERT INTO `cuisine` VALUES(34, 'Pizza');
INSERT INTO `cuisine` VALUES(35, 'Raw Bar');
INSERT INTO `cuisine` VALUES(36, 'Sandwiches');
INSERT INTO `cuisine` VALUES(37, 'Seafood');
INSERT INTO `cuisine` VALUES(38, 'Soul Food');
INSERT INTO `cuisine` VALUES(39, 'Southern Style');
INSERT INTO `cuisine` VALUES(40, 'Southwestern');
INSERT INTO `cuisine` VALUES(41, 'Spanish');
INSERT INTO `cuisine` VALUES(42, 'Steak & Barbecue');
INSERT INTO `cuisine` VALUES(43, 'Steak & Seafood');
INSERT INTO `cuisine` VALUES(44, 'Sushi');
INSERT INTO `cuisine` VALUES(45, 'Thai');
INSERT INTO `cuisine` VALUES(46, 'Vegetarian');
INSERT INTO `cuisine` VALUES(47, 'Vietnamese');
INSERT INTO `cuisine` VALUES(48, 'Unknown');

--
-- Dumping data for table `farm_type`
--

INSERT INTO `farm_type` VALUES(1, 'Dairy');
INSERT INTO `farm_type` VALUES(2, 'Poultry');
INSERT INTO `farm_type` VALUES(3, 'Cattle');
INSERT INTO `farm_type` VALUES(4, 'Agri-business');

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

INSERT INTO `fruit_type` VALUES(1, 'Pome');
INSERT INTO `fruit_type` VALUES(2, 'Berry');
INSERT INTO `fruit_type` VALUES(3, 'Hesperidium');
INSERT INTO `fruit_type` VALUES(4, 'Aggregate fruit');

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
-- Dumping data for table `manufacture_type`
--

INSERT INTO `manufacture_type` VALUES(1, 'Meat');
INSERT INTO `manufacture_type` VALUES(2, 'Poultry');
INSERT INTO `manufacture_type` VALUES(3, 'Seafood');
INSERT INTO `manufacture_type` VALUES(4, 'Dairy');
INSERT INTO `manufacture_type` VALUES(5, 'End Product');
INSERT INTO `manufacture_type` VALUES(6, 'Refining');
INSERT INTO `manufacture_type` VALUES(7, 'Beverage');
INSERT INTO `manufacture_type` VALUES(8, 'Brewery');

--
-- Dumping data for table `meat_type`
--

INSERT INTO `meat_type` VALUES(1, 'Chicken', NULL);
INSERT INTO `meat_type` VALUES(2, 'Beef', NULL);

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` VALUES(1, 'Restaurant Menu Item');
INSERT INTO `product_type` VALUES(2, 'Canned Good');
INSERT INTO `product_type` VALUES(3, 'Frozen');

--
-- Dumping data for table `restaurant_type`
--

INSERT INTO `restaurant_type` VALUES(1, 'Bar & Grill');
INSERT INTO `restaurant_type` VALUES(2, 'Bistro');
INSERT INTO `restaurant_type` VALUES(3, 'Caf');
INSERT INTO `restaurant_type` VALUES(4, 'Cafeterias');
INSERT INTO `restaurant_type` VALUES(5, 'Conveinent Store');
INSERT INTO `restaurant_type` VALUES(6, 'Creamery');
INSERT INTO `restaurant_type` VALUES(7, 'Deli');
INSERT INTO `restaurant_type` VALUES(8, 'Diner');
INSERT INTO `restaurant_type` VALUES(9, 'Dinner Theater');
INSERT INTO `restaurant_type` VALUES(10, 'Fast Food');
INSERT INTO `restaurant_type` VALUES(11, 'Fine Dining');
INSERT INTO `restaurant_type` VALUES(12, 'Karaoke');
INSERT INTO `restaurant_type` VALUES(13, 'Late Night Dining');
INSERT INTO `restaurant_type` VALUES(14, 'Pizzeria');
INSERT INTO `restaurant_type` VALUES(15, 'Restaurant');
INSERT INTO `restaurant_type` VALUES(16, 'Restaurant Services');
INSERT INTO `restaurant_type` VALUES(17, 'Wine Bar');
INSERT INTO `restaurant_type` VALUES(18, 'Fast Casual');

-- We have to dump this data AFTER restaurant_type as it requires a foreign key from restaurant_type
-- Dumping data for table `restaurant_chain`
--

INSERT INTO `restaurant_chain` VALUES (1, 'A&W Restaurants', 'A&W', 10);
INSERT INTO `restaurant_chain` VALUES (2, 'Applebee''s', 'Applebee['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (3, 'Arby''s', 'Arby['']s', 10);
INSERT INTO `restaurant_chain` VALUES (4, 'Atlanta Bread Company', 'Atlanta Bread', 10);
INSERT INTO `restaurant_chain` VALUES (5, 'Au Bon Pain', 'Au Bon Pain', 10);
INSERT INTO `restaurant_chain` VALUES (6, 'Auntie Anne''s', 'Auntie Anne', 10);
INSERT INTO `restaurant_chain` VALUES (7, 'Back Yard Burgers', 'Back Yard', 10);
INSERT INTO `restaurant_chain` VALUES (8, 'Bahama Breeze', 'Bahama Breeze', 10);
INSERT INTO `restaurant_chain` VALUES (9, 'Baja Fresh', 'Baja Fresh', 10);
INSERT INTO `restaurant_chain` VALUES (10, 'Bakers Square', 'Bakers Square', 10);
INSERT INTO `restaurant_chain` VALUES (11, 'Benihana', 'Benihana', 10);
INSERT INTO `restaurant_chain` VALUES (12, 'Bennigan''s', 'Bennigan', 10);
INSERT INTO `restaurant_chain` VALUES (13, 'Bertucci''s', 'Bertucci', 10);
INSERT INTO `restaurant_chain` VALUES (14, 'Big Boy', 'Big Boy', 10);
INSERT INTO `restaurant_chain` VALUES (15, 'Bill Knapp''s Restaurant', 'Bill Knapp', 10);
INSERT INTO `restaurant_chain` VALUES (16, 'Black Angus Steakhouse', 'Black Angus Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (17, 'Blimpie', 'Blimpie', 10);
INSERT INTO `restaurant_chain` VALUES (18, 'Bob Evans', 'Bob Evans', 10);
INSERT INTO `restaurant_chain` VALUES (19, 'Bojangles', 'Bojangles', 10);
INSERT INTO `restaurant_chain` VALUES (20, 'Bonefish Grill', 'Bonefish Grill', 10);
INSERT INTO `restaurant_chain` VALUES (21, 'Boston Market', 'Boston Market', 10);
INSERT INTO `restaurant_chain` VALUES (22, 'Braum''s', 'Braum', 10);
INSERT INTO `restaurant_chain` VALUES (23, 'Bruegger''s', 'Bruegger', 10);
INSERT INTO `restaurant_chain` VALUES (24, 'Bubba Gump Shrimp Company', 'Bubba Gump Shrimp', 10);
INSERT INTO `restaurant_chain` VALUES (25, 'Buca di Beppo', 'Buca di Beppo', 10);
INSERT INTO `restaurant_chain` VALUES (26, 'Buffalo Wild Wings', 'Buffalo Wild Wings', 10);
INSERT INTO `restaurant_chain` VALUES (27, 'Bugaboo Creek Steak House', 'Bugaboo Creek Steak House', 10);
INSERT INTO `restaurant_chain` VALUES (28, 'Burger King', 'Burger King', 10);
INSERT INTO `restaurant_chain` VALUES (29, 'Burger Street', 'Burger Street', 10);
INSERT INTO `restaurant_chain` VALUES (30, 'Burgerville, USA', 'Burgerville', 10);
INSERT INTO `restaurant_chain` VALUES (31, 'California Pizza Kitchen', 'California Pizza Kitchen', 10);
INSERT INTO `restaurant_chain` VALUES (32, 'California Tortilla', 'California Tortilla', 10);
INSERT INTO `restaurant_chain` VALUES (33, 'Camille''s Sidewalk Cafe', 'Camille', 10);
INSERT INTO `restaurant_chain` VALUES (34, 'Captain D''s', 'Captain D', 10);
INSERT INTO `restaurant_chain` VALUES (35, 'Carino''s Italian Grill', 'Carino', 10);
INSERT INTO `restaurant_chain` VALUES (36, 'Carl''s Jr.', 'Carl['']*s Jr', 10);
INSERT INTO `restaurant_chain` VALUES (37, 'Carrabba''s Italian Grill', 'Carrabba', 10);
INSERT INTO `restaurant_chain` VALUES (38, 'Carrows', 'Carrows', 10);
INSERT INTO `restaurant_chain` VALUES (39, 'Charley''s Grilled Subs', 'Charley', 10);
INSERT INTO `restaurant_chain` VALUES (40, 'Checkers', 'Checkers', 10);
INSERT INTO `restaurant_chain` VALUES (41, 'Cheeburger Cheeburger', 'Cheeburger Cheeburger', 10);
INSERT INTO `restaurant_chain` VALUES (42, 'Cheeseburger in Paradise', 'Cheeseburger in Paradise', 10);
INSERT INTO `restaurant_chain` VALUES (43, 'Cheesecake Factory', 'Cheesecake Factory', 10);
INSERT INTO `restaurant_chain` VALUES (44, 'Chevy''s Fresh Mex Restaurants', 'Chevy''s Fresh Mex Restaurants', 10);
INSERT INTO `restaurant_chain` VALUES (45, 'Chi-Chi''s', 'Chi-Chi', 10);
INSERT INTO `restaurant_chain` VALUES (46, 'Chicken Express', 'Chicken Express', 10);
INSERT INTO `restaurant_chain` VALUES (47, 'Chicken Out Rotisserie', 'Chicken Out Rotisserie', 10);
INSERT INTO `restaurant_chain` VALUES (48, 'Chick-Fil-A', 'Chick-Fil-A', 10);
INSERT INTO `restaurant_chain` VALUES (49, 'Chili''s', 'Chili['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (50, 'Chipotle Mexican Grill', 'Chipotle', 10);
INSERT INTO `restaurant_chain` VALUES (51, 'Chuck E. Cheese''s', 'Chuck E. Cheese''s', 10);
INSERT INTO `restaurant_chain` VALUES (52, 'Chuck-A-Rama', 'Chuck-A-Rama', 10);
INSERT INTO `restaurant_chain` VALUES (53, 'Church''s', 'Church['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (54, 'CiCi''s Pizza', 'CiCi', 10);
INSERT INTO `restaurant_chain` VALUES (55, 'Cinnabon', 'Cinnabon', 10);
INSERT INTO `restaurant_chain` VALUES (56, 'Claim Jumper', 'Claim Jumper', 10);
INSERT INTO `restaurant_chain` VALUES (57, 'Coco''s Bakery', 'Coco['']*s Bakery', 10);
INSERT INTO `restaurant_chain` VALUES (58, 'Cold Stone Creamery', 'Cold Stone Creamery', 10);
INSERT INTO `restaurant_chain` VALUES (59, 'Copeland''s', 'Copeland', 10);
INSERT INTO `restaurant_chain` VALUES (60, 'Corner Bakery Cafe', 'Corner Bakery Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (61, 'Cosi', 'Cosi', 10);
INSERT INTO `restaurant_chain` VALUES (62, 'Country Buffet', 'Country Buffet', 10);
INSERT INTO `restaurant_chain` VALUES (63, 'Cracker Barrel', 'Cracker Barrel', 10);
INSERT INTO `restaurant_chain` VALUES (64, 'Culver''s', 'Culver', 10);
INSERT INTO `restaurant_chain` VALUES (65, 'Dairy Queen', 'Dairy Queen', 10);
INSERT INTO `restaurant_chain` VALUES (66, 'Damon''s Grill', 'Damon['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (67, 'Daphne''s Greek Cafe', 'Daphne''s Greek Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (68, 'Dave & Buster''s', 'Dave & Buster', 10);
INSERT INTO `restaurant_chain` VALUES (69, 'Del Taco', 'Del Taco', 10);
INSERT INTO `restaurant_chain` VALUES (70, 'Denny''s', 'Denny['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (71, 'Dickey''s Barbecue Pit', 'Dickey''s Barbecue Pit', 10);
INSERT INTO `restaurant_chain` VALUES (72, 'Dixie Chili', 'Dixie Chili', 10);
INSERT INTO `restaurant_chain` VALUES (73, 'Domino''s Pizza', 'Domino['']*s Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (74, 'Don Pablo''s', 'Don Pablo''s', 10);
INSERT INTO `restaurant_chain` VALUES (75, 'Donatos Pizza', 'Donatos Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (76, 'East of Chicago Pizza', 'East of Chicago Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (77, 'Eat ''n Park', 'Eat ['']*n Park', 10);
INSERT INTO `restaurant_chain` VALUES (78, 'EatZi''s', 'EatZi', 10);
INSERT INTO `restaurant_chain` VALUES (79, 'Ed Debevic''s', 'Ed Debevic', 10);
INSERT INTO `restaurant_chain` VALUES (80, 'El Chico', 'El Chico', 10);
INSERT INTO `restaurant_chain` VALUES (81, 'El Guapo', 'El Guapo', 10);
INSERT INTO `restaurant_chain` VALUES (82, 'El Pollo Loco', 'El Pollo Loco', 10);
INSERT INTO `restaurant_chain` VALUES (83, 'Elephant Bar', 'Elephant Bar', 10);
INSERT INTO `restaurant_chain` VALUES (84, 'Famous Dave''s', 'Famous Dave['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (85, 'Fatburger', 'Fatburger', 10);
INSERT INTO `restaurant_chain` VALUES (86, 'Fatz Cafe', 'Fatz Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (87, 'Fazoli''s', 'Fazoli''s', 10);
INSERT INTO `restaurant_chain` VALUES (88, 'Firehouse Subs', 'Firehouse Subs', 10);
INSERT INTO `restaurant_chain` VALUES (89, 'Five Guys Burgers & Fries', 'Five Guys Burgers & Fries', 10);
INSERT INTO `restaurant_chain` VALUES (90, 'Freebirds World Burrito', 'Freebirds World Burrito', 10);
INSERT INTO `restaurant_chain` VALUES (91, 'Fresh Choice', 'Fresh Choice', 10);
INSERT INTO `restaurant_chain` VALUES (92, 'Friendly''s', 'Friendly['']s', 10);
INSERT INTO `restaurant_chain` VALUES (93, 'Fuddruckers', 'Fuddruckers', 10);
INSERT INTO `restaurant_chain` VALUES (94, 'Godfather''s Pizza', 'Godfather', 10);
INSERT INTO `restaurant_chain` VALUES (95, 'Golden Corral', 'Golden Corral', 10);
INSERT INTO `restaurant_chain` VALUES (96, 'Green Burrito', 'Green Burrito', 10);
INSERT INTO `restaurant_chain` VALUES (97, 'Ground Round', 'Ground Round', 10);
INSERT INTO `restaurant_chain` VALUES (98, 'Hard Rock Cafe', 'Hard Rock Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (99, 'Hardee''s', 'Hardee['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (100, 'Hobee''s Restaurant', 'Hobee['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (101, 'Hooters', 'Hooters', 10);
INSERT INTO `restaurant_chain` VALUES (102, 'Houlihan''s', 'Houlihan['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (103, 'Howard Johnson''s', 'Howard Johnson', 10);
INSERT INTO `restaurant_chain` VALUES (104, 'Huddle House', 'Huddle House', 10);
INSERT INTO `restaurant_chain` VALUES (105, 'Hungry Howie''s Pizza', 'Hungry Howie''s Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (106, 'IHOP', 'IHOP', 10);
INSERT INTO `restaurant_chain` VALUES (107, 'In-N-Out Burger', 'In-N-Out Burger', 10);
INSERT INTO `restaurant_chain` VALUES (108, 'Jack In The Box', 'Jack In The Box', 10);
INSERT INTO `restaurant_chain` VALUES (109, 'Jack''s Hamburgers', 'Jack['']*s Hamburgers', 10);
INSERT INTO `restaurant_chain` VALUES (110, 'Jamba Juice', 'Jamba Juice', 10);
INSERT INTO `restaurant_chain` VALUES (111, 'Jason''s Deli', 'Jason['']*s Deli', 10);
INSERT INTO `restaurant_chain` VALUES (112, 'Jerry''s Subs & Pizza', 'Jerry['']*s Subs & Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (113, 'Jersey Mike''s', 'Jersey Mike', 10);
INSERT INTO `restaurant_chain` VALUES (114, 'Jimmy John''s', 'Jimmy John', 10);
INSERT INTO `restaurant_chain` VALUES (115, 'Jim''s Restaurants', 'Jim['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (116, 'Joe''s Crab Shack', 'Joe['']*s Crab Shack', 10);
INSERT INTO `restaurant_chain` VALUES (117, 'Johnny Rockets', 'Johnny Rockets', 10);
INSERT INTO `restaurant_chain` VALUES (118, 'KFC', 'KFC', 10);
INSERT INTO `restaurant_chain` VALUES (119, 'Kryatal', 'Kryatal', 10);
INSERT INTO `restaurant_chain` VALUES (120, 'Landry''s Restaurants', 'Landry['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (121, 'Ledo Pizza', 'Ledo Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (122, 'Lee Roy Selmon''s', 'Lee Roy Selmon', 10);
INSERT INTO `restaurant_chain` VALUES (123, 'Little Caesars Pizza', 'Little Caesars Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (124, 'Logan''s Roadhouse', 'Logan''s Roadhouse', 10);
INSERT INTO `restaurant_chain` VALUES (125, 'Lone Star Steakhouse', 'Lone Star Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (126, 'Long John Silver''s', 'Long John Silver''s', 10);
INSERT INTO `restaurant_chain` VALUES (127, 'Longhorn Steakhouse', 'Longhorn Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (128, 'Luby''s', 'Luby['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (129, 'Lyon''s', 'Lyon['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (130, 'Maggiano''s Little Italy', 'Maggiano', 10);
INSERT INTO `restaurant_chain` VALUES (131, 'Max & Erma''s', 'Max & Erma', 10);
INSERT INTO `restaurant_chain` VALUES (132, 'McAlister''s Deli', 'McAlister['']*s Deli', 10);
INSERT INTO `restaurant_chain` VALUES (133, 'McDonald''s', 'McDonald', 10);
INSERT INTO `restaurant_chain` VALUES (134, 'Miller''s Ale House', 'Miller['']*s Ale House', 10);
INSERT INTO `restaurant_chain` VALUES (135, 'Milo''s Hamburgers', 'Milo['']*s Hamburger', 10);
INSERT INTO `restaurant_chain` VALUES (136, 'Moe''s Southwest Grill', 'Moe['']*s Southwest Grill', 10);
INSERT INTO `restaurant_chain` VALUES (137, 'Montana Mike''s', 'Montana Mike['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (138, 'Naugles', 'Naugles', 10);
INSERT INTO `restaurant_chain` VALUES (139, 'Ninety-Nine Restaurant and Pub', 'Ninety-Nine Restaurant and Pub', 10);
INSERT INTO `restaurant_chain` VALUES (140, 'Noodles & Company', 'Noodles & Company', 10);
INSERT INTO `restaurant_chain` VALUES (141, 'O''Charley''s', 'O''Charley', 10);
INSERT INTO `restaurant_chain` VALUES (142, 'Old Country Buffet', 'Old Country Buffet', 10);
INSERT INTO `restaurant_chain` VALUES (143, 'Olive Garden', 'Olive Garden', 10);
INSERT INTO `restaurant_chain` VALUES (144, 'On The Border Mexican Grill & Cantina', 'On The Border Mexican Grill & Cantina', 10);
INSERT INTO `restaurant_chain` VALUES (145, 'Outback Steakhouse', 'Outback Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (146, 'P. F. Chang''s China Bistro', 'P. F. Chang['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (147, 'Panda Express', 'Panda Express', 10);
INSERT INTO `restaurant_chain` VALUES (148, 'Panera Bread', 'Panera Bread', 10);
INSERT INTO `restaurant_chain` VALUES (149, 'Papa Gino''s', 'Papa Gino', 10);
INSERT INTO `restaurant_chain` VALUES (150, 'Papa John''s', 'Papa John', 10);
INSERT INTO `restaurant_chain` VALUES (151, 'Papa Murphy''s Take N Bake Pizza', 'Papa Murphy''s Take N Bake Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (152, 'Pei Wei Asian Diner', 'Pei Wei Asian Diner', 10);
INSERT INTO `restaurant_chain` VALUES (153, 'Penn Station', 'Penn Station', 10);
INSERT INTO `restaurant_chain` VALUES (154, 'Perkins Restaurant and Bakery', 'Perkins Restaurant and Bakery', 10);
INSERT INTO `restaurant_chain` VALUES (155, 'Pick Up Stix', 'Pick Up Stix', 10);
INSERT INTO `restaurant_chain` VALUES (156, 'Pizza Hut', 'Pizza Hut', 10);
INSERT INTO `restaurant_chain` VALUES (157, 'Pizza Inn', 'Pizza Inn', 10);
INSERT INTO `restaurant_chain` VALUES (158, 'Pizza Ranch', 'Pizza Ranch', 10);
INSERT INTO `restaurant_chain` VALUES (159, 'Pollo Campero', 'Pollo Campero', 10);
INSERT INTO `restaurant_chain` VALUES (160, 'Ponderosa/Bonanza Steakhouse', 'Ponderosa/Bonanza Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (161, 'Popeye''s', 'Popeye', 10);
INSERT INTO `restaurant_chain` VALUES (162, 'Port of Subs', 'Port of Subs', 10);
INSERT INTO `restaurant_chain` VALUES (163, 'Portillo''s', 'Portillo', 10);
INSERT INTO `restaurant_chain` VALUES (164, 'Potbelly Sandwich Works', 'Potbelly Sandwich Works', 10);
INSERT INTO `restaurant_chain` VALUES (165, 'Qdoba Mexican Grill', 'Qdoba', 10);
INSERT INTO `restaurant_chain` VALUES (166, 'Quaker Steak and Lube', 'Quaker Steak and Lube', 10);
INSERT INTO `restaurant_chain` VALUES (167, 'Quiznos Sub', 'Quizno['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (168, 'RA Sushi', 'RA Sushi', 10);
INSERT INTO `restaurant_chain` VALUES (169, 'Rainforest Cafe', 'Rainforest Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (170, 'Rally''s', 'Rally', 10);
INSERT INTO `restaurant_chain` VALUES (171, 'Rax Restaurant', 'Rax Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (172, 'Red Lobster', 'Red Lobster', 10);
INSERT INTO `restaurant_chain` VALUES (173, 'Red Robin', 'Red Robin', 10);
INSERT INTO `restaurant_chain` VALUES (174, 'Robeks', 'Robeks', 10);
INSERT INTO `restaurant_chain` VALUES (175, 'Rock Bottom', 'Rock Bottom', 10);
INSERT INTO `restaurant_chain` VALUES (176, 'Romano''s Macaroni Grill', 'Romano', 10);
INSERT INTO `restaurant_chain` VALUES (177, 'Round Table Pizza', 'Round Table Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (178, 'Roy Rogers Family Restaurants', 'Roy Rogers', 10);
INSERT INTO `restaurant_chain` VALUES (179, 'Rubio''s Fresh Mexican Grill', 'Rubio', 10);
INSERT INTO `restaurant_chain` VALUES (180, 'Ruby Tuesday', 'Ruby Tuesday', 10);
INSERT INTO `restaurant_chain` VALUES (181, 'Rumbi Island Grill', 'Rumbi Island', 10);
INSERT INTO `restaurant_chain` VALUES (182, 'Runza', 'Runza', 10);
INSERT INTO `restaurant_chain` VALUES (183, 'Ruth''s Chris Steakhouse', 'Ruth['']*s Chris', 10);
INSERT INTO `restaurant_chain` VALUES (184, 'Saladworks', 'Saladworks', 10);
INSERT INTO `restaurant_chain` VALUES (185, 'Schlotzsky''s', 'Schlotzsky', 10);
INSERT INTO `restaurant_chain` VALUES (186, 'Shane''s Rib Shack', 'Shane['']*s Rib', 10);
INSERT INTO `restaurant_chain` VALUES (187, 'Shoney''s', 'Shoney['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (188, 'Sizzler', 'Sizzler', 10);
INSERT INTO `restaurant_chain` VALUES (189, 'Skyline Chili', 'Skyline Chili', 10);
INSERT INTO `restaurant_chain` VALUES (190, 'Smokey Bones', 'Smokey Bones', 10);
INSERT INTO `restaurant_chain` VALUES (191, 'Sneaky Pete''s Hot Dogs', 'Sneaky Pete', 10);
INSERT INTO `restaurant_chain` VALUES (192, 'Sonic Drive-In', 'Sonic', 10);
INSERT INTO `restaurant_chain` VALUES (193, 'Souplantation and Sweet Tomatoes', 'Souplantation and Sweet Tomatoes', 10);
INSERT INTO `restaurant_chain` VALUES (194, 'Spangles', 'Spangles', 10);
INSERT INTO `restaurant_chain` VALUES (195, 'Spicy Pickle', 'Spicy Pickle', 10);
INSERT INTO `restaurant_chain` VALUES (196, 'Starbucks', 'Starbucks', 10);
INSERT INTO `restaurant_chain` VALUES (197, 'Steak ''n Ale', 'Steak ''n Ale', 10);
INSERT INTO `restaurant_chain` VALUES (198, 'Steak ''n Shake', 'Steak ''n Shake', 10);
INSERT INTO `restaurant_chain` VALUES (199, 'Stewart''s Drive-In', 'Stewart['']*s Drive-In', 10);
INSERT INTO `restaurant_chain` VALUES (200, 'Sticky Fingers', 'Sticky Fingers', 10);
INSERT INTO `restaurant_chain` VALUES (201, 'Stir Crazy', 'Stir Crazy', 10);
INSERT INTO `restaurant_chain` VALUES (202, 'Sub Station II', 'Sub Station II', 10);
INSERT INTO `restaurant_chain` VALUES (203, 'Subway', 'Subway', 10);
INSERT INTO `restaurant_chain` VALUES (204, 'Sweet Tomatoes', 'Sweet Tomatoes', 10);
INSERT INTO `restaurant_chain` VALUES (205, 'Swensen''s', 'Swensen', 10);
INSERT INTO `restaurant_chain` VALUES (206, 'Taco Bell', 'Taco Bell', 10);
INSERT INTO `restaurant_chain` VALUES (207, 'Taco Bueno', 'Taco Bueno', 10);
INSERT INTO `restaurant_chain` VALUES (208, 'Taco Cabana', 'Taco Cabana', 10);
INSERT INTO `restaurant_chain` VALUES (209, 'Taco John''s', 'Taco John', 10);
INSERT INTO `restaurant_chain` VALUES (210, 'Texas Roadhouse', 'Texas Roadhouse', 10);
INSERT INTO `restaurant_chain` VALUES (211, 'TGI Friday''s', 'TGI Friday', 10);
INSERT INTO `restaurant_chain` VALUES (212, 'The Melting Pot', 'The Melting Pot', 10);
INSERT INTO `restaurant_chain` VALUES (213, 'The Old Spaghetti Factory', 'The Old Spaghetti Factory', 10);
INSERT INTO `restaurant_chain` VALUES (214, 'The Original Italian Pie', 'The Original Italian Pie', 10);
INSERT INTO `restaurant_chain` VALUES (215, 'The Original Pancake House', 'The Original Pancake House', 10);
INSERT INTO `restaurant_chain` VALUES (216, 'Tijuana Flats', 'Tijuana Flats', 10);
INSERT INTO `restaurant_chain` VALUES (217, 'Tim Hortons', 'Tim Hortons', 10);
INSERT INTO `restaurant_chain` VALUES (218, 'Tony Roma''s', 'Tony Roma', 10);
INSERT INTO `restaurant_chain` VALUES (219, 'Trader Vic''s', 'Trader Vic', 10);
INSERT INTO `restaurant_chain` VALUES (220, 'Uno Chicago Grill', 'Uno Chicago Grill', 10);
INSERT INTO `restaurant_chain` VALUES (221, 'Valentino''s', 'Valentino', 10);
INSERT INTO `restaurant_chain` VALUES (222, 'Vapiano', 'Vapiano', 10);
INSERT INTO `restaurant_chain` VALUES (223, 'Village Inn', 'Village Inn', 10);
INSERT INTO `restaurant_chain` VALUES (224, 'Waffle House', 'Waffle House', 10);
INSERT INTO `restaurant_chain` VALUES (225, 'Wendy''s', 'Wendy['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (226, 'Whataburger', 'Whataburger', 10);
INSERT INTO `restaurant_chain` VALUES (227, 'Which Wich?', 'Which Wich', 10);
INSERT INTO `restaurant_chain` VALUES (228, 'White Castle', 'White Castle', 10);
INSERT INTO `restaurant_chain` VALUES (229, 'Wings To Go', 'Wings To Go', 10);
INSERT INTO `restaurant_chain` VALUES (230, 'Wingstop', 'Wingstop', 10);
INSERT INTO `restaurant_chain` VALUES (231, 'York Steak House', 'York Steak House', 10);
INSERT INTO `restaurant_chain` VALUES (232, 'Zankou Chicken', 'Zankou Chicken', 10);
INSERT INTO `restaurant_chain` VALUES (233, 'Zaxby''s', 'Zaxby['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (234, 'Zoes Kitchen', 'Zoes Kitchen', 10);


--
-- Dumping data for table `state`
--

INSERT INTO `state` VALUES(1, 'Kentucky', 'KY');
INSERT INTO `state` VALUES(2, 'Indiana', 'IN');
INSERT INTO `state` VALUES(3, 'Ohio', 'OH');
INSERT INTO `state` VALUES(4, 'Illinois', 'IL');
INSERT INTO `state` VALUES(6, 'New York', 'NY');
INSERT INTO `state` VALUES(7, 'Alabama', 'AL');
INSERT INTO `state` VALUES(8, 'California', 'CA');
INSERT INTO `state` VALUES(9, 'Nevada', 'NV');
INSERT INTO `state` VALUES(10, 'Arizona', 'AZ');
INSERT INTO `state` VALUES(11, 'Texas', 'TX');
INSERT INTO `state` VALUES(12, 'Florida', 'FL');
INSERT INTO `state` VALUES(13, 'Washington', 'WA');
INSERT INTO `state` VALUES(14, 'Alaska', 'AK');
INSERT INTO `state` VALUES(15, 'Arkansas', 'AR');
INSERT INTO `state` VALUES(16, 'Colorado', 'CO');
INSERT INTO `state` VALUES(17, 'Connecticut', 'CT');
INSERT INTO `state` VALUES(18, 'Delaware', 'DE');
INSERT INTO `state` VALUES(19, 'Georgia', 'GA');
INSERT INTO `state` VALUES(20, 'Hawaii', 'HI');
INSERT INTO `state` VALUES(21, 'Idaho', 'ID');
INSERT INTO `state` VALUES(22, 'D.C.', 'DC');
INSERT INTO `state` VALUES(23, 'Iowa', 'IA');
INSERT INTO `state` VALUES(24, 'Kansas', 'KS');
INSERT INTO `state` VALUES(25, 'Louisiana', 'LA');
INSERT INTO `state` VALUES(26, 'Maine', 'ME');
INSERT INTO `state` VALUES(27, 'Maryland', 'MD');
INSERT INTO `state` VALUES(28, 'Massachusetts', 'MA');
INSERT INTO `state` VALUES(29, 'Michigan', 'MI');
INSERT INTO `state` VALUES(30, 'Minnesota', 'MN');
INSERT INTO `state` VALUES(31, 'Mississippi', 'MS');
INSERT INTO `state` VALUES(32, 'Missouri', 'MO');
INSERT INTO `state` VALUES(33, 'Montana', 'MT');
INSERT INTO `state` VALUES(34, 'Nebraska', 'NE');
INSERT INTO `state` VALUES(35, 'New Hampshire', 'NH');
INSERT INTO `state` VALUES(36, 'New Jersey', 'NJ');
INSERT INTO `state` VALUES(37, 'New Mexico', 'NM');
INSERT INTO `state` VALUES(38, 'North Carolina', 'NC');
INSERT INTO `state` VALUES(39, 'North Dakota', 'ND');
INSERT INTO `state` VALUES(40, 'Oklahoma', 'OK');
INSERT INTO `state` VALUES(41, 'Oregon', 'OR');
INSERT INTO `state` VALUES(42, 'Pennsylvania', 'PA');
INSERT INTO `state` VALUES(43, 'Rhode Island', 'RI');
INSERT INTO `state` VALUES(44, 'South Carolina', 'SC');
INSERT INTO `state` VALUES(45, 'South Dakota', 'SD');
INSERT INTO `state` VALUES(46, 'Tennessee', 'TN');
INSERT INTO `state` VALUES(47, 'Utah', 'UT');
INSERT INTO `state` VALUES(48, 'Vermont', 'VT');
INSERT INTO `state` VALUES(49, 'Virginia', 'VA');
INSERT INTO `state` VALUES(50, 'West Virginia', 'WV');
INSERT INTO `state` VALUES(51, 'Wisconsin', 'WI');
INSERT INTO `state` VALUES(52, 'Wyoming', 'WY');


--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` VALUES(1, 'admin');
INSERT INTO `user_group` VALUES(2, 'Restaurant - Free');
INSERT INTO `user_group` VALUES(3, 'Restaurant Owner - Paid 1');
INSERT INTO `user_group` VALUES(4, 'Restaurant Owner - Paid 2');
INSERT INTO `user_group` VALUES(5, 'Distributor');
INSERT INTO `user_group` VALUES(6, 'Distributor - Paid');

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