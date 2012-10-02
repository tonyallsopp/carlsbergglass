-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 02, 2012 at 07:59 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `carlsberg_glass`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `town` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `country` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `section` varchar(10) NOT NULL,
  `slug` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `created`, `updated`, `name`, `section`, `slug`) VALUES
(1, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Carlsberg', 'branded', 'carlsberg'),
(2, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Tumblers', 'unbranded', 'tumblers'),
(3, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Kronenbourg 1664', 'branded', 'kronenbourg_1664'),
(4, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Stem Glasses', 'unbranded', 'stem_glasses'),
(5, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Tall Glasses', 'unbranded', 'tall_glasses'),
(6, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Tankards', 'unbranded', 'tankards'),
(8, '2012-07-30 13:11:38', '2012-07-30 13:11:38', 'Pitchers', 'unbranded', 'pitchers');

-- --------------------------------------------------------

--
-- Table structure for table `cms_elements`
--

CREATE TABLE IF NOT EXISTS `cms_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(5) NOT NULL DEFAULT 'block',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `section` varchar(3) NOT NULL DEFAULT 'cms',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `cms_elements`
--

INSERT INTO `cms_elements` (`id`, `created`, `updated`, `name`, `description`, `content`, `type`, `display_order`, `section`, `parent_id`) VALUES
(1, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'welcome_to_intro', 'Home page intro text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel est nisi. In blandit lacus vitae neque mattis imperdiet. Curabitur vestibulum, nisl nec faucibus egestas, diam turpis tristique turpis, eu bibendum odio nunc id quam. Pellentesque dapibus libero tellus. Vivamus id mi vitae diam dignissim placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In tristique venenatis tristique.', 'block', 1, 'cms', 0),
(2, '2012-08-09 00:00:00', '2012-08-09 12:11:03', 'welcome_to_title', 'Home page title', 'Welcome to POS Glassware', 'line', 0, 'cms', 0),
(3, '2012-08-09 00:00:00', '2012-08-09 12:11:03', 'faq_gr_1', 'FAQ Section 1 Title', 'Custom Glassware FAQs', 'line', 0, 'faq', 0),
(4, '2012-08-09 00:00:00', '2012-08-16 10:22:38', 'ssss', 'FAQ Question', 'How do I order custom glassware?', 'q', 0, 'faq', 3),
(5, '2012-08-09 00:00:00', '2012-08-09 12:11:03', 'eeee', 'FAQ Answer', 'ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor nisl eget arcu convallis vel tempus enim dictum. Ut mi elit, condimentum ac consequat at, commodo et dui. Donec vel diam sem, vel sagittis massa. Nullam mattis magna ut sem ultrices non consequat turpis lobortis. Vestibulum id felis vel ipsum semper gravida. Sed bibendum neque lectus, ut venenatis justo. Maecenas eu mi ut sem dapibus eleifend sed in sapien. Mauris sit amet libero ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus mattis orci a erat consequat iaculis. Proin tortor orci, tempor in aliquam ac, fringilla quis turpis. Praesent et magna tellus. Nullam sit amet neque nibh. Curabitur dolor risus, faucibus vitae mollis ac, semper ornare lorem. ', 'a', 0, 'faq', 4),
(6, '2012-08-09 00:00:00', '2012-08-09 12:11:03', 'faq_gr_2', 'FAQ Section 2 Title', 'Branded Glassware FAQs', 'line', 1, 'faq', 0),
(7, '2012-08-09 00:00:00', '2012-08-09 12:11:03', 'faq_gr_3', 'FAQ Section 3 Title', 'Carlsberg Group FAQs', 'line', 2, 'faq', 0),
(12, '2012-08-16 10:55:33', '2012-08-16 10:55:33', 'some_question', 'FAQ Question', 'Some question?', 'q', 1, 'faq', 7),
(13, '2012-08-16 10:55:33', '2012-08-16 10:55:33', 'some_answer', 'FAQ Answer', 'Some answer', 'a', 0, 'faq', 12),
(14, '2012-08-16 10:58:20', '2012-08-16 10:58:20', 'blabla_bla', 'FAQ Question', 'Blabla bla?', 'q', 1, 'faq', 6),
(15, '2012-08-16 10:58:20', '2012-08-16 10:58:20', 'bla_bla_bla', 'FAQ Answer', 'Bla bla bla', 'a', 0, 'faq', 14),
(16, '2012-08-16 11:08:47', '2012-08-16 11:08:47', 'next_question', 'FAQ Question', 'Next question?', 'q', 1, 'faq', 3),
(17, '2012-08-16 11:08:47', '2012-08-16 11:08:47', 'next_answer', 'FAQ Answer', 'Next answer', 'a', 0, 'faq', 16),
(18, '2012-08-16 15:04:05', '2012-08-16 15:04:05', 'this_is_a_question', 'FAQ Question', 'This is a question?', 'q', 2, 'faq', 6),
(19, '2012-08-16 15:04:05', '2012-08-16 15:04:05', 'this_is_an_answer', 'FAQ Answer', 'This is an answer', 'a', 0, 'faq', 18),
(21, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'checkout_quote_text', 'Order summary quote text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel est nisi. In blandit lacus vitae neque mattis imperdiet. Curabitur vestibulum, nisl nec faucibus egestas, diam turpis tristique turpis, eu bibendum odio nunc id quam. Pellentesque dapibus libero tellus. Vivamus id mi vitae diam dignissim placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In tristique venenatis tristique.', 'block', 3, 'cms', 0),
(22, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'checkout_sample_text', 'Order summary sample text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel est nisi. In blandit lacus vitae neque mattis imperdiet. Curabitur vestibulum, nisl nec faucibus egestas, diam turpis tristique turpis, eu bibendum odio nunc id quam. Pellentesque dapibus libero tellus. Vivamus id mi vitae diam dignissim placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In tristique venenatis tristique.', 'block', 4, 'cms', 0),
(23, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'support_desk_title', 'Support sidebar title 1', 'Support Desk', 'line', 5, 'cms', 0),
(24, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'support_desk_text', 'Support sidebar text', 'Product description maecenas faucibus mollis interdum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.', 'block', 6, 'cms', 0),
(25, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'support_phone_title', 'Support phone title', 'Telephone Support', 'line', 7, 'cms', 0),
(26, '2012-08-09 00:00:00', '2012-08-09 00:00:00', 'support_phone_number', 'Support phone number', '+44 0123456 6522', 'line', 8, 'cms', 0),
(27, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'config_support_email', 'Support email address(es)', 'paulcrouch@gmail.com', 'line', 0, 'cfg', 0),
(28, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'config_order_email', 'Order email address(es)', 'paulcrouch@gmail.com', 'line', 1, 'cfg', 0),
(29, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'prod_price_title', 'Product detail price title', 'Estimated price', 'line', 9, 'cms', 0),
(30, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'prod_price_text', 'Product detail price text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'block', 10, 'cms', 0),
(31, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'manual_title', 'Manual download title', 'POS Glassware Manual', 'line', 11, 'cms', 0),
(32, '2012-08-09 00:00:00', '2012-09-20 11:13:47', 'manual_text', 'Manual download text', 'Please download and read Carlsberg Group POS Glassware Manual before getting started. POSG Manual has been created to help you ensuring the choice of right POS Glassware for Carlsberg Group products, both in the On- and Off-trade.', 'block', 11, 'cms', 0);

-- --------------------------------------------------------

--
-- Table structure for table `colour_prices`
--

CREATE TABLE IF NOT EXISTS `colour_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `qty_from` int(11) NOT NULL DEFAULT '0',
  `qty_to` int(11) NOT NULL DEFAULT '0',
  `small_1_2` decimal(8,3) NOT NULL DEFAULT '0.000',
  `small_3_4` decimal(8,3) NOT NULL DEFAULT '0.000',
  `small_5_6` decimal(8,3) NOT NULL DEFAULT '0.000',
  `large_1_2` decimal(8,3) NOT NULL DEFAULT '0.000',
  `large_3_4` decimal(8,3) NOT NULL DEFAULT '0.000',
  `large_5_6` decimal(8,3) NOT NULL DEFAULT '0.000',
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `product_group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `colour_prices`
--

INSERT INTO `colour_prices` (`id`, `created`, `updated`, `qty_from`, `qty_to`, `small_1_2`, `small_3_4`, `small_5_6`, `large_1_2`, `large_3_4`, `large_5_6`, `supplier_id`, `product_group_id`) VALUES
(41, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 1, 3000, '0.150', '0.200', '0.250', '0.180', '0.240', '0.300', 1, 2),
(42, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 3001, 4999, '0.140', '0.190', '0.240', '0.170', '0.230', '0.290', 1, 2),
(43, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 5000, 99999, '0.120', '0.150', '0.180', '0.150', '0.180', '0.210', 1, 2),
(44, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 100000, 199999, '0.100', '0.120', '0.140', '0.130', '0.150', '0.170', 1, 2),
(45, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 200000, 2147483647, '0.080', '0.090', '0.100', '0.110', '0.120', '0.130', 1, 2),
(46, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 1, 3000, '0.150', '0.200', '0.250', '0.180', '0.240', '0.300', 2, 2),
(47, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 3001, 4999, '0.140', '0.190', '0.240', '0.170', '0.230', '0.290', 2, 2),
(48, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 5000, 99999, '0.120', '0.150', '0.180', '0.150', '0.180', '0.210', 2, 2),
(49, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 100000, 199999, '0.100', '0.120', '0.140', '0.130', '0.150', '0.170', 2, 2),
(50, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 200000, 2147483647, '0.080', '0.090', '0.100', '0.110', '0.120', '0.130', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `custom_options`
--

CREATE TABLE IF NOT EXISTS `custom_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  `is_colour` tinyint(1) NOT NULL DEFAULT '0',
  `small_price` decimal(8,3) NOT NULL DEFAULT '0.000',
  `large_price` decimal(8,3) NOT NULL DEFAULT '0.000',
  `info` varchar(200) NOT NULL,
  `multiplier` varchar(10) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `product_group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `custom_options`
--

INSERT INTO `custom_options` (`id`, `created`, `updated`, `name`, `is_colour`, `small_price`, `large_price`, `info`, `multiplier`, `supplier_id`, `product_group_id`) VALUES
(1, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Gold Rim', 0, '0.080', '0.100', '', '', 1, 2),
(2, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Laser / Sparkling Point', 0, '0.020', '0.020', '', '', 1, 2),
(3, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Real gold logo', 0, '0.020', '0.020', '', 'cm2', 1, 2),
(4, '2012-08-18 08:48:53', '2012-08-18 08:48:53', '1 color print (on/under plate)', 0, '0.150', '0.150', '', '', 1, 2),
(5, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Lining', 1, '0.000', '0.000', 'MID certified', '', 1, 2),
(6, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Gold Rim', 0, '0.080', '0.090', '', '', 2, 2),
(7, '2012-08-18 08:48:53', '2012-08-18 08:48:53', 'Laser / Sparkling Point', 0, '0.020', '0.020', '', '', 2, 2),
(8, '2012-08-18 08:48:54', '2012-08-18 08:48:54', 'Real gold logo', 0, '0.020', '0.020', '', 'cm2', 2, 2),
(9, '2012-08-18 08:48:54', '2012-08-18 08:48:54', '1 color print (on/under plate)', 0, '0.150', '0.150', '', '', 2, 2),
(10, '2012-08-18 08:48:54', '2012-08-18 08:48:54', 'Lining', 1, '0.000', '0.000', 'MID certified', '', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `filename` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE IF NOT EXISTS `imports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `import_date` datetime NOT NULL,
  `report` text NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `created`, `updated`, `name`, `filename`, `type`) VALUES
(1, '2012-08-20 00:00:00', '2012-08-20 11:52:14', 'POS Glassware Manual', 'pos_glassware_manual.pdf', 'manual'),
(28, '2012-09-27 10:14:04', '2012-09-27 10:14:04', 'berna 0,2.JPG', 'berna_2.jpg', 'prod_img'),
(42, '2012-09-27 12:13:20', '2012-09-27 12:13:20', 'IsarSeidel.jpg', 'isarseidel.jpg', 'prod_img'),
(43, '2012-09-27 12:16:04', '2012-09-27 12:16:04', 'Vetro Due_Praga_0,2.JPG', 'vetro_due_praga_2.jpg', 'prod_img'),
(44, '2012-09-27 12:17:21', '2012-09-27 12:17:21', 'Vetro Due_Praga_0,3_0,33.JPG', 'vetro_due_praga_3_33.jpg', 'prod_img'),
(48, '2012-09-27 12:24:31', '2012-09-27 12:24:31', 'Vetro Due_Praga_0,5.JPG', 'vetro_due_praga_5.jpg', 'prod_img'),
(49, '2012-09-27 12:25:37', '2012-09-27 12:25:37', 'Vetro Due_Weizen_0,3.jpg', 'vetro_due_weizen_3.jpg', 'prod_img'),
(50, '2012-09-27 14:56:54', '2012-09-27 14:56:54', 'amsterdam_0,3.jpg', 'amsterdam_3.jpg', 'prod_img');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `quote_requested` tinyint(1) NOT NULL DEFAULT '0',
  `sample_requested` tinyint(1) NOT NULL DEFAULT '0',
  `status` smallint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `created`, `updated`, `user_id`, `quote_requested`, `sample_requested`, `status`) VALUES
(2, '2012-09-04 08:33:35', '2012-09-04 08:33:35', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `product_unit_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `qty` int(9) NOT NULL DEFAULT '0',
  `colours` smallint(2) NOT NULL DEFAULT '0',
  `unit_price` decimal(8,3) NOT NULL DEFAULT '0.000',
  `name` varchar(200) NOT NULL,
  `capacity` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `created`, `updated`, `product_unit_id`, `order_id`, `qty`, `colours`, `unit_price`, `name`, `capacity`) VALUES
(10, '2012-09-04 09:16:05', '2012-09-04 09:16:05', 4, 2, 1000, 1, '0.606', 'Frankonia Tumbler', '0.2L / 28 cl');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_options`
--

CREATE TABLE IF NOT EXISTS `order_item_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `order_item_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL,
  `value` decimal(8,3) NOT NULL DEFAULT '0.000',
  `price` decimal(8,3) NOT NULL DEFAULT '0.000',
  `multiplier` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `order_item_options`
--

INSERT INTO `order_item_options` (`id`, `created`, `updated`, `order_item_id`, `name`, `value`, `price`, `multiplier`) VALUES
(200, '2012-09-28 11:33:56', '2012-09-28 11:33:56', 10, 'Gold Rim', '1.000', '0.080', ''),
(201, '2012-09-28 11:33:56', '2012-09-28 11:33:56', 10, 'Laser / Sparkling Point', '1.000', '0.020', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_groups`
--

CREATE TABLE IF NOT EXISTS `product_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `guide` varchar(200) NOT NULL,
  `drawing` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE IF NOT EXISTS `product_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  `capacity` varchar(20) NOT NULL,
  `capacity_group` varchar(5) NOT NULL,
  `variant` varchar(100) DEFAULT NULL,
  `origin` varchar(100) NOT NULL,
  `hs_code` varchar(100) NOT NULL,
  `fca_location` varchar(200) NOT NULL,
  `price` decimal(8,3) NOT NULL DEFAULT '0.000',
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `product_group_id` int(11) NOT NULL DEFAULT '0',
  `packaging` varchar(100) NOT NULL,
  `pallet_unit` int(11) NOT NULL DEFAULT '0',
  `trailer_load` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `image_file` varchar(255) NOT NULL,
  `product_group_slug` varchar(200) NOT NULL,
  `cutter_guide_file` varchar(255) NOT NULL,
  `drawing_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_group_slug` (`product_group_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `created`, `updated`, `name`) VALUES
(1, '2012-07-30 13:42:50', '2012-07-30 13:42:50', 'Rastal GmbH & Co.KG'),
(2, '2012-07-30 13:42:50', '2012-07-30 13:42:50', 'ARC International');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `size`) VALUES
(1, 'TEST.pdf', 10042);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` smallint(2) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `country` varchar(10) NOT NULL,
  `company` varchar(100) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `updated`, `email`, `password`, `role`, `enabled`, `first_name`, `last_name`, `country`, `company`, `telephone`, `job_title`, `approved`, `last_login`) VALUES
(1, '2012-07-26 00:00:00', '2012-10-01 16:42:17', 'admin', 'ea74d29b5c229a035e8c8ee90257a82dd685e90b', 1, 1, 'John', 'Smith', 'UK', 'JSmith Ltd', '0123654321', '', 1, '2012-10-01 16:42:17'),
(2, '2012-08-09 09:27:59', '2012-08-15 16:28:17', 'jb@jb.com', '6c147e4592c19a20b174d452956292c20b715272', 0, 1, 'Jason', 'Bourne', 'Germany', 'JC Inc', '0123456789', 'MD', 0, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
