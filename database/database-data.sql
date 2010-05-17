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

INSERT INTO `restaurant_chain` VALUES (235, 'A&W Restaurants', 'A&W', 10);
INSERT INTO `restaurant_chain` VALUES (236, 'Applebee''s', 'Applebee['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (237, 'Arby''s', 'Arby['']s', 10);
INSERT INTO `restaurant_chain` VALUES (238, 'Atlanta Bread Company', 'Atlanta Bread', 10);
INSERT INTO `restaurant_chain` VALUES (239, 'Au Bon Pain', 'Au Bon Pain', 10);
INSERT INTO `restaurant_chain` VALUES (240, 'Auntie Anne''s', 'Auntie Anne', 10);
INSERT INTO `restaurant_chain` VALUES (241, 'Back Yard Burgers', 'Back Yard', 10);
INSERT INTO `restaurant_chain` VALUES (242, 'Bahama Breeze', 'Bahama Breeze', 10);
INSERT INTO `restaurant_chain` VALUES (243, 'Baja Fresh', 'Baja Fresh', 10);
INSERT INTO `restaurant_chain` VALUES (244, 'Bakers Square', 'Bakers Square', 10);
INSERT INTO `restaurant_chain` VALUES (245, 'Benihana', 'Benihana', 10);
INSERT INTO `restaurant_chain` VALUES (246, 'Bennigan''s', 'Bennigan', 10);
INSERT INTO `restaurant_chain` VALUES (247, 'Bertucci''s', 'Bertucci', 10);
INSERT INTO `restaurant_chain` VALUES (248, 'Big Boy', 'Big Boy', 10);
INSERT INTO `restaurant_chain` VALUES (249, 'Bill Knapp''s Restaurant', 'Bill Knapp', 10);
INSERT INTO `restaurant_chain` VALUES (250, 'Black Angus Steakhouse', 'Black Angus Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (251, 'Blimpie', 'Blimpie', 10);
INSERT INTO `restaurant_chain` VALUES (252, 'Bob Evans', 'Bob Evans', 10);
INSERT INTO `restaurant_chain` VALUES (253, 'Bojangles', 'Bojangles', 10);
INSERT INTO `restaurant_chain` VALUES (254, 'Bonefish Grill', 'Bonefish Grill', 10);
INSERT INTO `restaurant_chain` VALUES (255, 'Boston Market', 'Boston Market', 10);
INSERT INTO `restaurant_chain` VALUES (256, 'Braum''s', 'Braum', 10);
INSERT INTO `restaurant_chain` VALUES (257, 'Bruegger''s', 'Bruegger', 10);
INSERT INTO `restaurant_chain` VALUES (258, 'Bubba Gump Shrimp Company', 'Bubba Gump Shrimp', 10);
INSERT INTO `restaurant_chain` VALUES (259, 'Buca di Beppo', 'Buca di Beppo', 10);
INSERT INTO `restaurant_chain` VALUES (260, 'Buffalo Wild Wings', 'Buffalo Wild Wings', 10);
INSERT INTO `restaurant_chain` VALUES (261, 'Bugaboo Creek Steak House', 'Bugaboo Creek Steak House', 10);
INSERT INTO `restaurant_chain` VALUES (262, 'Burger King', 'Burger King', 10);
INSERT INTO `restaurant_chain` VALUES (263, 'Burger Street', 'Burger Street', 10);
INSERT INTO `restaurant_chain` VALUES (264, 'Burgerville, USA', 'Burgerville', 10);
INSERT INTO `restaurant_chain` VALUES (265, 'California Pizza Kitchen', 'California Pizza Kitchen', 10);
INSERT INTO `restaurant_chain` VALUES (266, 'California Tortilla', 'California Tortilla', 10);
INSERT INTO `restaurant_chain` VALUES (267, 'Camille''s Sidewalk Cafe', 'Camille', 10);
INSERT INTO `restaurant_chain` VALUES (268, 'Captain D''s', 'Captain D', 10);
INSERT INTO `restaurant_chain` VALUES (269, 'Carino''s Italian Grill', 'Carino', 10);
INSERT INTO `restaurant_chain` VALUES (270, 'Carl''s Jr.', 'Carl['']*s Jr', 10);
INSERT INTO `restaurant_chain` VALUES (271, 'Carrabba''s Italian Grill', 'Carrabba', 10);
INSERT INTO `restaurant_chain` VALUES (272, 'Carrows', 'Carrows', 10);
INSERT INTO `restaurant_chain` VALUES (273, 'Charley''s Grilled Subs', 'Charley', 10);
INSERT INTO `restaurant_chain` VALUES (274, 'Checkers', 'Checkers', 10);
INSERT INTO `restaurant_chain` VALUES (275, 'Cheeburger Cheeburger', 'Cheeburger Cheeburger', 10);
INSERT INTO `restaurant_chain` VALUES (276, 'Cheeseburger in Paradise', 'Cheeseburger in Paradise', 10);
INSERT INTO `restaurant_chain` VALUES (277, 'Cheesecake Factory', 'Cheesecake Factory', 10);
INSERT INTO `restaurant_chain` VALUES (278, 'Chevy''s Fresh Mex Restaurants', 'Chevy''s Fresh Mex Restaurants', 10);
INSERT INTO `restaurant_chain` VALUES (279, 'Chi-Chi''s', 'Chi-Chi', 10);
INSERT INTO `restaurant_chain` VALUES (280, 'Chicken Express', 'Chicken Express', 10);
INSERT INTO `restaurant_chain` VALUES (281, 'Chicken Out Rotisserie', 'Chicken Out Rotisserie', 10);
INSERT INTO `restaurant_chain` VALUES (282, 'Chick-Fil-A', 'Chick-Fil-A', 10);
INSERT INTO `restaurant_chain` VALUES (283, 'Chili''s', 'Chili['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (284, 'Chipotle Mexican Grill', 'Chipotle', 10);
INSERT INTO `restaurant_chain` VALUES (285, 'Chuck E. Cheese''s', 'Chuck E. Cheese''s', 10);
INSERT INTO `restaurant_chain` VALUES (286, 'Chuck-A-Rama', 'Chuck-A-Rama', 10);
INSERT INTO `restaurant_chain` VALUES (287, 'Church''s', 'Church['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (288, 'CiCi''s Pizza', 'CiCi', 10);
INSERT INTO `restaurant_chain` VALUES (289, 'Cinnabon', 'Cinnabon', 10);
INSERT INTO `restaurant_chain` VALUES (290, 'Claim Jumper', 'Claim Jumper', 10);
INSERT INTO `restaurant_chain` VALUES (291, 'Coco''s Bakery', 'Coco['']*s Bakery', 10);
INSERT INTO `restaurant_chain` VALUES (292, 'Cold Stone Creamery', 'Cold Stone Creamery', 10);
INSERT INTO `restaurant_chain` VALUES (293, 'Copeland''s', 'Copeland', 10);
INSERT INTO `restaurant_chain` VALUES (294, 'Corner Bakery Cafe', 'Corner Bakery Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (295, 'Cosi', 'Cosi', 10);
INSERT INTO `restaurant_chain` VALUES (296, 'Country Buffet', 'Country Buffet', 10);
INSERT INTO `restaurant_chain` VALUES (297, 'Cracker Barrel', 'Cracker Barrel', 10);
INSERT INTO `restaurant_chain` VALUES (298, 'Culver''s', 'Culver', 10);
INSERT INTO `restaurant_chain` VALUES (299, 'Dairy Queen', 'Dairy Queen', 10);
INSERT INTO `restaurant_chain` VALUES (300, 'Damon''s Grill', 'Damon['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (301, 'Daphne''s Greek Cafe', 'Daphne''s Greek Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (302, 'Dave & Buster''s', 'Dave & Buster', 10);
INSERT INTO `restaurant_chain` VALUES (303, 'Del Taco', 'Del Taco', 10);
INSERT INTO `restaurant_chain` VALUES (304, 'Denny''s', 'Denny['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (305, 'Dickey''s Barbecue Pit', 'Dickey''s Barbecue Pit', 10);
INSERT INTO `restaurant_chain` VALUES (306, 'Dixie Chili', 'Dixie Chili', 10);
INSERT INTO `restaurant_chain` VALUES (307, 'Domino''s Pizza', 'Domino['']*s Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (308, 'Don Pablo''s', 'Don Pablo''s', 10);
INSERT INTO `restaurant_chain` VALUES (309, 'Donatos Pizza', 'Donatos Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (310, 'East of Chicago Pizza', 'East of Chicago Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (311, 'Eat ''n Park', 'Eat ['']*n Park', 10);
INSERT INTO `restaurant_chain` VALUES (312, 'EatZi''s', 'EatZi', 10);
INSERT INTO `restaurant_chain` VALUES (313, 'Ed Debevic''s', 'Ed Debevic', 10);
INSERT INTO `restaurant_chain` VALUES (314, 'El Chico', 'El Chico', 10);
INSERT INTO `restaurant_chain` VALUES (315, 'El Guapo', 'El Guapo', 10);
INSERT INTO `restaurant_chain` VALUES (316, 'El Pollo Loco', 'El Pollo Loco', 10);
INSERT INTO `restaurant_chain` VALUES (317, 'Elephant Bar', 'Elephant Bar', 10);
INSERT INTO `restaurant_chain` VALUES (318, 'Famous Dave''s', 'Famous Dave['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (319, 'Fatburger', 'Fatburger', 10);
INSERT INTO `restaurant_chain` VALUES (320, 'Fatz Cafe', 'Fatz Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (321, 'Fazoli''s', 'Fazoli''s', 10);
INSERT INTO `restaurant_chain` VALUES (322, 'Firehouse Subs', 'Firehouse Subs', 10);
INSERT INTO `restaurant_chain` VALUES (323, 'Five Guys Burgers & Fries', 'Five Guys Burgers & Fries', 10);
INSERT INTO `restaurant_chain` VALUES (324, 'Freebirds World Burrito', 'Freebirds World Burrito', 10);
INSERT INTO `restaurant_chain` VALUES (325, 'Fresh Choice', 'Fresh Choice', 10);
INSERT INTO `restaurant_chain` VALUES (326, 'Friendly''s', 'Friendly['']s', 10);
INSERT INTO `restaurant_chain` VALUES (327, 'Fuddruckers', 'Fuddruckers', 10);
INSERT INTO `restaurant_chain` VALUES (328, 'Godfather''s Pizza', 'Godfather', 10);
INSERT INTO `restaurant_chain` VALUES (329, 'Golden Corral', 'Golden Corral', 10);
INSERT INTO `restaurant_chain` VALUES (330, 'Green Burrito', 'Green Burrito', 10);
INSERT INTO `restaurant_chain` VALUES (331, 'Ground Round', 'Ground Round', 10);
INSERT INTO `restaurant_chain` VALUES (332, 'Hard Rock Cafe', 'Hard Rock Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (333, 'Hardee''s', 'Hardee['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (334, 'Hobee''s Restaurant', 'Hobee['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (335, 'Hooters', 'Hooters', 10);
INSERT INTO `restaurant_chain` VALUES (336, 'Houlihan''s', 'Houlihan['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (337, 'Howard Johnson''s', 'Howard Johnson', 10);
INSERT INTO `restaurant_chain` VALUES (338, 'Huddle House', 'Huddle House', 10);
INSERT INTO `restaurant_chain` VALUES (339, 'Hungry Howie''s Pizza', 'Hungry Howie''s Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (340, 'IHOP', 'IHOP', 10);
INSERT INTO `restaurant_chain` VALUES (341, 'In-N-Out Burger', 'In-N-Out Burger', 10);
INSERT INTO `restaurant_chain` VALUES (342, 'Jack In The Box', 'Jack In The Box', 10);
INSERT INTO `restaurant_chain` VALUES (343, 'Jack''s Hamburgers', 'Jack['']*s Hamburgers', 10);
INSERT INTO `restaurant_chain` VALUES (344, 'Jamba Juice', 'Jamba Juice', 10);
INSERT INTO `restaurant_chain` VALUES (345, 'Jason''s Deli', 'Jason['']*s Deli', 10);
INSERT INTO `restaurant_chain` VALUES (346, 'Jerry''s Subs & Pizza', 'Jerry['']*s Subs & Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (347, 'Jersey Mike''s', 'Jersey Mike', 10);
INSERT INTO `restaurant_chain` VALUES (348, 'Jimmy John''s', 'Jimmy John', 10);
INSERT INTO `restaurant_chain` VALUES (349, 'Jim''s Restaurants', 'Jim['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (350, 'Joe''s Crab Shack', 'Joe['']*s Crab Shack', 10);
INSERT INTO `restaurant_chain` VALUES (351, 'Johnny Rockets', 'Johnny Rockets', 10);
INSERT INTO `restaurant_chain` VALUES (352, 'KFC', 'KFC', 10);
INSERT INTO `restaurant_chain` VALUES (353, 'Kryatal', 'Kryatal', 10);
INSERT INTO `restaurant_chain` VALUES (354, 'Landry''s Restaurants', 'Landry['']*s Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (355, 'Ledo Pizza', 'Ledo Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (356, 'Lee Roy Selmon''s', 'Lee Roy Selmon', 10);
INSERT INTO `restaurant_chain` VALUES (357, 'Little Caesars Pizza', 'Little Caesars Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (358, 'Logan''s Roadhouse', 'Logan''s Roadhouse', 10);
INSERT INTO `restaurant_chain` VALUES (359, 'Lone Star Steakhouse', 'Lone Star Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (360, 'Long John Silver''s', 'Long John Silver''s', 10);
INSERT INTO `restaurant_chain` VALUES (361, 'Longhorn Steakhouse', 'Longhorn Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (362, 'Luby''s', 'Luby['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (363, 'Lyon''s', 'Lyon['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (364, 'Maggiano''s Little Italy', 'Maggiano', 10);
INSERT INTO `restaurant_chain` VALUES (365, 'Max & Erma''s', 'Max & Erma', 10);
INSERT INTO `restaurant_chain` VALUES (366, 'McAlister''s Deli', 'McAlister['']*s Deli', 10);
INSERT INTO `restaurant_chain` VALUES (367, 'McDonald''s', 'McDonald', 10);
INSERT INTO `restaurant_chain` VALUES (368, 'Miller''s Ale House', 'Miller['']*s Ale House', 10);
INSERT INTO `restaurant_chain` VALUES (369, 'Milo''s Hamburgers', 'Milo['']*s Hamburger', 10);
INSERT INTO `restaurant_chain` VALUES (370, 'Moe''s Southwest Grill', 'Moe['']*s Southwest Grill', 10);
INSERT INTO `restaurant_chain` VALUES (371, 'Montana Mike''s', 'Montana Mike['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (372, 'Naugles', 'Naugles', 10);
INSERT INTO `restaurant_chain` VALUES (373, 'Ninety-Nine Restaurant and Pub', 'Ninety-Nine Restaurant and Pub', 10);
INSERT INTO `restaurant_chain` VALUES (374, 'Noodles & Company', 'Noodles & Company', 10);
INSERT INTO `restaurant_chain` VALUES (375, 'O''Charley''s', 'O''Charley', 10);
INSERT INTO `restaurant_chain` VALUES (376, 'Old Country Buffet', 'Old Country Buffet', 10);
INSERT INTO `restaurant_chain` VALUES (377, 'Olive Garden', 'Olive Garden', 10);
INSERT INTO `restaurant_chain` VALUES (378, 'On The Border Mexican Grill & Cantina', 'On The Border Mexican Grill & Cantina', 10);
INSERT INTO `restaurant_chain` VALUES (379, 'Outback Steakhouse', 'Outback Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (380, 'P. F. Chang''s China Bistro', 'P. F. Chang['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (381, 'Panda Express', 'Panda Express', 10);
INSERT INTO `restaurant_chain` VALUES (382, 'Panera Bread', 'Panera Bread', 10);
INSERT INTO `restaurant_chain` VALUES (383, 'Papa Gino''s', 'Papa Gino', 10);
INSERT INTO `restaurant_chain` VALUES (384, 'Papa John''s', 'Papa John', 10);
INSERT INTO `restaurant_chain` VALUES (385, 'Papa Murphy''s Take N Bake Pizza', 'Papa Murphy''s Take N Bake Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (386, 'Pei Wei Asian Diner', 'Pei Wei Asian Diner', 10);
INSERT INTO `restaurant_chain` VALUES (387, 'Penn Station', 'Penn Station', 10);
INSERT INTO `restaurant_chain` VALUES (388, 'Perkins Restaurant and Bakery', 'Perkins Restaurant and Bakery', 10);
INSERT INTO `restaurant_chain` VALUES (389, 'Pick Up Stix', 'Pick Up Stix', 10);
INSERT INTO `restaurant_chain` VALUES (390, 'Pizza Hut', 'Pizza Hut', 10);
INSERT INTO `restaurant_chain` VALUES (391, 'Pizza Inn', 'Pizza Inn', 10);
INSERT INTO `restaurant_chain` VALUES (392, 'Pizza Ranch', 'Pizza Ranch', 10);
INSERT INTO `restaurant_chain` VALUES (393, 'Pollo Campero', 'Pollo Campero', 10);
INSERT INTO `restaurant_chain` VALUES (394, 'Ponderosa/Bonanza Steakhouse', 'Ponderosa/Bonanza Steakhouse', 10);
INSERT INTO `restaurant_chain` VALUES (395, 'Popeye''s', 'Popeye', 10);
INSERT INTO `restaurant_chain` VALUES (396, 'Port of Subs', 'Port of Subs', 10);
INSERT INTO `restaurant_chain` VALUES (397, 'Portillo''s', 'Portillo', 10);
INSERT INTO `restaurant_chain` VALUES (398, 'Potbelly Sandwich Works', 'Potbelly Sandwich Works', 10);
INSERT INTO `restaurant_chain` VALUES (399, 'Qdoba Mexican Grill', 'Qdoba', 10);
INSERT INTO `restaurant_chain` VALUES (400, 'Quaker Steak and Lube', 'Quaker Steak and Lube', 10);
INSERT INTO `restaurant_chain` VALUES (401, 'Quiznos Sub', 'Quizno['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (402, 'RA Sushi', 'RA Sushi', 10);
INSERT INTO `restaurant_chain` VALUES (403, 'Rainforest Cafe', 'Rainforest Cafe', 10);
INSERT INTO `restaurant_chain` VALUES (404, 'Rally''s', 'Rally', 10);
INSERT INTO `restaurant_chain` VALUES (405, 'Rax Restaurant', 'Rax Restaurant', 10);
INSERT INTO `restaurant_chain` VALUES (406, 'Red Lobster', 'Red Lobster', 10);
INSERT INTO `restaurant_chain` VALUES (407, 'Red Robin', 'Red Robin', 10);
INSERT INTO `restaurant_chain` VALUES (408, 'Robeks', 'Robeks', 10);
INSERT INTO `restaurant_chain` VALUES (409, 'Rock Bottom', 'Rock Bottom', 10);
INSERT INTO `restaurant_chain` VALUES (410, 'Romano''s Macaroni Grill', 'Romano', 10);
INSERT INTO `restaurant_chain` VALUES (411, 'Round Table Pizza', 'Round Table Pizza', 10);
INSERT INTO `restaurant_chain` VALUES (412, 'Roy Rogers Family Restaurants', 'Roy Rogers', 10);
INSERT INTO `restaurant_chain` VALUES (413, 'Rubio''s Fresh Mexican Grill', 'Rubio', 10);
INSERT INTO `restaurant_chain` VALUES (414, 'Ruby Tuesday', 'Ruby Tuesday', 10);
INSERT INTO `restaurant_chain` VALUES (415, 'Rumbi Island Grill', 'Rumbi Island', 10);
INSERT INTO `restaurant_chain` VALUES (416, 'Runza', 'Runza', 10);
INSERT INTO `restaurant_chain` VALUES (417, 'Ruth''s Chris Steakhouse', 'Ruth['']*s Chris', 10);
INSERT INTO `restaurant_chain` VALUES (418, 'Saladworks', 'Saladworks', 10);
INSERT INTO `restaurant_chain` VALUES (419, 'Schlotzsky''s', 'Schlotzsky', 10);
INSERT INTO `restaurant_chain` VALUES (420, 'Shane''s Rib Shack', 'Shane['']*s Rib', 10);
INSERT INTO `restaurant_chain` VALUES (421, 'Shoney''s', 'Shoney['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (422, 'Sizzler', 'Sizzler', 10);
INSERT INTO `restaurant_chain` VALUES (423, 'Skyline Chili', 'Skyline Chili', 10);
INSERT INTO `restaurant_chain` VALUES (424, 'Smokey Bones', 'Smokey Bones', 10);
INSERT INTO `restaurant_chain` VALUES (425, 'Sneaky Pete''s Hot Dogs', 'Sneaky Pete', 10);
INSERT INTO `restaurant_chain` VALUES (426, 'Sonic Drive-In', 'Sonic', 10);
INSERT INTO `restaurant_chain` VALUES (427, 'Souplantation and Sweet Tomatoes', 'Souplantation and Sweet Tomatoes', 10);
INSERT INTO `restaurant_chain` VALUES (428, 'Spangles', 'Spangles', 10);
INSERT INTO `restaurant_chain` VALUES (429, 'Spicy Pickle', 'Spicy Pickle', 10);
INSERT INTO `restaurant_chain` VALUES (430, 'Starbucks', 'Starbucks', 10);
INSERT INTO `restaurant_chain` VALUES (431, 'Steak ''n Ale', 'Steak ''n Ale', 10);
INSERT INTO `restaurant_chain` VALUES (432, 'Steak ''n Shake', 'Steak ''n Shake', 10);
INSERT INTO `restaurant_chain` VALUES (433, 'Stewart''s Drive-In', 'Stewart['']*s Drive-In', 10);
INSERT INTO `restaurant_chain` VALUES (434, 'Sticky Fingers', 'Sticky Fingers', 10);
INSERT INTO `restaurant_chain` VALUES (435, 'Stir Crazy', 'Stir Crazy', 10);
INSERT INTO `restaurant_chain` VALUES (436, 'Sub Station II', 'Sub Station II', 10);
INSERT INTO `restaurant_chain` VALUES (437, 'Subway', 'Subway', 10);
INSERT INTO `restaurant_chain` VALUES (438, 'Sweet Tomatoes', 'Sweet Tomatoes', 10);
INSERT INTO `restaurant_chain` VALUES (439, 'Swensen''s', 'Swensen', 10);
INSERT INTO `restaurant_chain` VALUES (440, 'Taco Bell', 'Taco Bell', 10);
INSERT INTO `restaurant_chain` VALUES (441, 'Taco Bueno', 'Taco Bueno', 10);
INSERT INTO `restaurant_chain` VALUES (442, 'Taco Cabana', 'Taco Cabana', 10);
INSERT INTO `restaurant_chain` VALUES (443, 'Taco John''s', 'Taco John', 10);
INSERT INTO `restaurant_chain` VALUES (444, 'Texas Roadhouse', 'Texas Roadhouse', 10);
INSERT INTO `restaurant_chain` VALUES (445, 'TGI Friday''s', 'TGI Friday', 10);
INSERT INTO `restaurant_chain` VALUES (446, 'The Melting Pot', 'The Melting Pot', 10);
INSERT INTO `restaurant_chain` VALUES (447, 'The Old Spaghetti Factory', 'The Old Spaghetti Factory', 10);
INSERT INTO `restaurant_chain` VALUES (448, 'The Original Italian Pie', 'The Original Italian Pie', 10);
INSERT INTO `restaurant_chain` VALUES (449, 'The Original Pancake House', 'The Original Pancake House', 10);
INSERT INTO `restaurant_chain` VALUES (450, 'Tijuana Flats', 'Tijuana Flats', 10);
INSERT INTO `restaurant_chain` VALUES (451, 'Tim Hortons', 'Tim Hortons', 10);
INSERT INTO `restaurant_chain` VALUES (452, 'Tony Roma''s', 'Tony Roma', 10);
INSERT INTO `restaurant_chain` VALUES (453, 'Trader Vic''s', 'Trader Vic', 10);
INSERT INTO `restaurant_chain` VALUES (454, 'Uno Chicago Grill', 'Uno Chicago Grill', 10);
INSERT INTO `restaurant_chain` VALUES (455, 'Valentino''s', 'Valentino', 10);
INSERT INTO `restaurant_chain` VALUES (456, 'Vapiano', 'Vapiano', 10);
INSERT INTO `restaurant_chain` VALUES (457, 'Village Inn', 'Village Inn', 10);
INSERT INTO `restaurant_chain` VALUES (458, 'Waffle House', 'Waffle House', 10);
INSERT INTO `restaurant_chain` VALUES (459, 'Wendy''s', 'Wendy['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (460, 'Whataburger', 'Whataburger', 10);
INSERT INTO `restaurant_chain` VALUES (461, 'Which Wich?', 'Which Wich', 10);
INSERT INTO `restaurant_chain` VALUES (462, 'White Castle', 'White Castle', 10);
INSERT INTO `restaurant_chain` VALUES (463, 'Wings To Go', 'Wings To Go', 10);
INSERT INTO `restaurant_chain` VALUES (464, 'Wingstop', 'Wingstop', 10);
INSERT INTO `restaurant_chain` VALUES (465, 'York Steak House', 'York Steak House', 10);
INSERT INTO `restaurant_chain` VALUES (466, 'Zankou Chicken', 'Zankou Chicken', 10);
INSERT INTO `restaurant_chain` VALUES (467, 'Zaxby''s', 'Zaxby['']*s', 10);
INSERT INTO `restaurant_chain` VALUES (468, 'Zoes Kitchen', 'Zoes Kitchen', 10);


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