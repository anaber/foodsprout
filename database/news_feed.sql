-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2011 at 10:44 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `news_feed`
--

CREATE TABLE IF NOT EXISTS `news_feed` (
  `news_feed_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_feed_url` varchar(200) NOT NULL,
  `news_feed_text` text NOT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`news_feed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news_feed`
--

INSERT INTO `news_feed` (`news_feed_id`, `news_feed_url`, `news_feed_text`, `producer_id`, `product_id`, `date`, `user_id`) VALUES
(1, 'test', 'test', NULL, NULL, '2011-04-26 16:48:53', 8);
