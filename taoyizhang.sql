SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_acl_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT 'cote,group,url',
  `action_name` varchar(100) NOT NULL DEFAULT '',
  `action_code` varchar(100) NOT NULL DEFAULT '',
  `sort_by` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_code` (`action_code`,`type`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=' table' AUTO_INCREMENT=55 ;

INSERT INTO `taoyizhang_wbsd1415_resit_acl_action` (`id`, `parent_id`, `type`, `action_name`, `action_code`, `sort_by`) VALUES
(1, 0, 'cote', 'Main', 'shop/main', 0),
(2, 0, 'cote', 'Design', 'privilege/modif', 0),
(8, 0, 'group', 'goods management', 'goods_manage', 0),
(10, 0, 'group', 'order manage', 'order_manage', 0),
(38, 8, 'url', 'goods list', 'goods/getList', 1),
(39, 10, 'url', 'order list', 'order/getList', 2),
(45, 8, 'url', 'add goods', 'goods/add', 2);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_admin_user` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `nick_name` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `qq` varchar(50) DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `last_login` int(11) NOT NULL DEFAULT '0' COMMENT 'last time sign in time',
  `last_ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'last time sign in ip',
  `sd_id` int(11) NOT NULL DEFAULT '0' COMMENT ' ',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 means admin，0 mens not admin',
  `wangwang` varchar(50) NOT NULL DEFAULT '',
  `is_allow_login` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT 'sign in ,',
  `active` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '，，',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=' in  table' AUTO_INCREMENT=2 ;

INSERT INTO `taoyizhang_wbsd1415_resit_admin_user` (`id`, `user_name`, `nick_name`, `password`, `sex`, `qq`, `email`, `last_login`, `last_ip`, `sd_id`, `is_admin`, `wangwang`, `is_allow_login`, `active`) VALUES
(1, 'admin', 'admin', 'cf79ae6addba60ad018347359bd144d2', 1, '2324252324', 'jackccsss@noaa.com', 1439805946, '::1', 0, 1, '', 1, 1);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_brand` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `is_show` char(1) NOT NULL DEFAULT '1' COMMENT '，',
  `desc` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `taoyizhang_wbsd1415_resit_brand` (`id`, `name`, `is_show`, `desc`) VALUES
(1, 'Apple', '1', 'hello'),
(2, 'Smartsian', '1', 'hello'),
(3, 'Sony', '1', 'hello'),
(4, 'Samsung', '1', 'hello'),
(5, 'Dell', '1', 'hello'),
(6, 'Huawei', '1', 'hello'),
(7, 'Meizu', '1', 'hello'),
(8, 'Acer', '1', 'hello'),
(9, 'Lenovo', '1', 'hello'),
(10, 'Xiaomi', '1', 'hello'),
(11, 'others', '1', 'others');

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_category` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `taoyizhang_wbsd1415_resit_category` (`id`, `name`, `desc`) VALUES
(1, 'Cell Phones', NULL),
(2, 'Laptop Computers', NULL),
(3, 'Tablets', NULL),
(4, 'Keyboards', NULL),
(5, 'TV', NULL),
(6, 'Mice', NULL);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_categoryaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT 'cote,group,url',
  `action_name` varchar(100) NOT NULL DEFAULT '',
  `action_code` varchar(11) NOT NULL DEFAULT '',
  `sort_by` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_code` (`action_code`,`type`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=' table' AUTO_INCREMENT=7 ;

INSERT INTO `taoyizhang_wbsd1415_resit_categoryaction` (`id`, `parent_id`, `type`, `action_name`, `action_code`, `sort_by`) VALUES
(1, 0, 'cote', 'Cell Phones', 'category/ph', 0),
(2, 0, 'cote', 'Laptop Computers', 'category/la', 0),
(3, 0, 'cote', 'Tablets', 'category/ta', 0),
(4, 0, 'cote', 'Keyboards', 'category/ke', 0),
(5, 0, 'cote', 'TV', 'category/tv', 0),
(6, 0, 'cote', 'Mice', 'category/mi', 0);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `color_code` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `taoyizhang_wbsd1415_resit_color` (`id`, `code`, `name`) VALUES
(1, '0001', 'white'),
(2, '0002', 'black'),
(3, '0003', 'grey'),
(4, '0004', 'red');

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_sn` varchar(50) NOT NULL,
  `goods_name` varchar(100) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `brand_id` smallint(3) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `size_id` varchar(11) NOT NULL DEFAULT '0',
  `warn_stock_num` int(11) NOT NULL DEFAULT '0' COMMENT ' stock ',
  `img_url` varchar(255) NOT NULL DEFAULT '',
  `describle` varchar(100) NOT NULL DEFAULT '',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

INSERT INTO `taoyizhang_wbsd1415_resit_goods` (`id`, `goods_sn`, `goods_name`, `price`, `weight`, `brand_id`, `category_id`, `size_id`, `warn_stock_num`, `img_url`, `describle`, `shop_id`) VALUES
(1, 'iphone5ssssssss', 'iPhone5s', 500.00, 300.00, 1, 1, '32', 430, 'iphone5s1.jpg', 'buybuybuy', 1),
(2, 'Sddfafff', 'iPhone6', 500.00, 300.00, 1, 1, '32', 430, '6.jpg', 'buybuybuy', 1),
(3, 'Sdfaddaf', 'iPhone6 plus', 500.00, 300.00, 1, 1, '32', 430, '6plus1.jpg', 'buybuybuy', 1),
(22, '12345532', 'asus', 500.00, 300.00, 0, 2, '0', 0, '', 'buybuybuy', 0),
(5, 'Sdewfdaf', 'Xiaomi', 500.00, 300.00, 10, 1, '32', 430, 'hongmi.jpg', 'buybuybuy', 1),
(6, 'Sdfsfgtraf', 'Smartsian T1', 500.00, 300.00, 2, 1, '32', 430, 'TB2hiRpaFXXXXXCXpXXXXXXXXXX_!!2115680417.jpg_430x430q90.jpg', 'buybuybuy', 1),
(7, 'Sdxliutvdaf', 'Lumia 535', 500.00, 300.00, 11, 1, '32', 430, 'lumia535.jpg', 'buybuybuy', 1),
(8, 'Sdbfjkudaf', 'Huawei honor', 500.00, 300.00, 6, 1, '32', 430, 'honor.jpg', 'buybuybuy', 1),
(9, 'Sdfaf2435af', 'acer', 500.00, 300.00, 8, 2, '500', 430, 'acer.jpg', 'buybuybuy', 1),
(10, 'Sdf67afgaf', 'asus', 500.00, 300.00, 11, 2, '500', 430, 'asus.jpg', 'buybuybuy', 1),
(11, 'Sdfa79fgaf', 'lenveo', 500.00, 300.00, 9, 2, '500', 430, 'lenveo.jpg', 'buybuybuy', 1),
(12, 'Sdfaf656gaf', 'rmbp', 500.00, 300.00, 1, 2, '500', 430, 'rmbp.jpg', 'buybuybuy', 1),
(13, 'Sdfaf24gaf', 'mba', 500.00, 300.00, 1, 2, '500', 430, 'mba.jpg', 'buybuybuy', 1),
(14, 'Sdfaf4532gaf', 'firehd', 500.00, 300.00, 0, 3, '128', 430, 'firehd.jpg', 'buybuybuy', 1),
(15, 'Sdfa234fgaf', 'surface', 500.00, 300.00, 1, 3, '128', 430, 'surface.jpg', 'buybuybuy', 1),
(16, 'Sdfa4fgaf', 'voyage', 500.00, 300.00, 11, 3, '4', 430, 'voyage.jpg', 'buybuybuy', 1),
(19, 'daffdg', 'hhkb pro2', 0.00, 0.00, 11, 4, '0', 0, 'Happy_Hacking_Keyboard_Professional_2.jpg', '', 0),
(20, '237', 'LCD 27', 0.00, 1000.00, 4, 5, '0', 0, '7010_G_1399517114186.jpg', 'hello', 1),
(23, '12345678', 'Xiaomi', 500.00, 300.00, 0, 1, '0', 0, '', 'buybuybuy', 0),
(24, 'avadfas', 'iPhone5s', 100.00, 300.00, 0, 1, '0', 0, '', 'buybuybuy', 0),
(25, 'mice123', 'mice 123', 12.00, 23.00, 0, 6, '0', 0, '', 'giid nuce', 0);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_goods_color` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(50) DEFAULT NULL,
  `color_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `color_code` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `goods_color` (`goods_id`,`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

INSERT INTO `taoyizhang_wbsd1415_resit_goods_color` (`id`, `goods_id`, `goods_sn`, `color_id`, `color_code`) VALUES
(22, 8, 'Sdbfjkudaf', 1, '0001'),
(23, 8, 'Sdbfjkudaf', 2, '0002'),
(24, 8, 'Sdbfjkudaf', 3, '0003'),
(25, 8, 'Sdbfjkudaf', 4, '0004'),
(26, 9, 'Sdfaf2435af', 2, '0002'),
(27, 9, 'Sdfaf2435af', 4, '0004'),
(28, 10, 'Sdf67afgaf', 4, '0004');


CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_goods_size` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `size_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `size_code` varchar(50) NOT NULL DEFAULT '',
  `goods_sn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `goods_size` (`goods_id`,`size_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `taoyizhang_wbsd1415_resit_goods_size` (`id`, `goods_id`, `size_id`, `size_code`, `goods_sn`) VALUES
(6, 1, 1, '16', 'Sdfafdaf'),
(7, 1, 2, '32', 'Sdfafdaf');

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_goods_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `warehouse_id` smallint(5) NOT NULL,
  `actual_quantity` int(11) NOT NULL DEFAULT '0' COMMENT ' actual ',
  `lock_quantity` int(11) NOT NULL DEFAULT '0' COMMENT ' lock   stock ',
  `warn_quantity` int(11) NOT NULL DEFAULT '0' COMMENT ' stock ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_color_size_ware` (`goods_id`,`color_id`,`size_id`,`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=' stock  table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `warehouse_id` int(5) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `goods_sn` varchar(50) NOT NULL,
  `color_code` varchar(15) NOT NULL,
  `size_code` varchar(15) NOT NULL,
  `goods_number` smallint(3) NOT NULL DEFAULT '0',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT ',',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT ' l',
  `is_separate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_goods_key` (`order_id`,`goods_id`,`color_id`,`size_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

INSERT INTO `taoyizhang_wbsd1415_resit_order_goods` (`id`, `order_sn`, `order_id`, `warehouse_id`, `goods_id`, `color_id`, `size_id`, `goods_sn`, `color_code`, `size_code`, `goods_number`, `goods_amount`, `card_fee`, `pay_fee`, `is_separate`) VALUES
(1, '20', 0, 0, 0, 0, 0, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(5, '', 166199296, 0, 0, 0, 0, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(6, '', 1420491060, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(7, '', 1420059060, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(8, '', 27, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(9, '', 28, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(10, '', 29, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(11, '', 30, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(12, '', 31, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(13, '', 32, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(14, '', 33, 0, 2, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(15, '', 34, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(16, '', 35, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(17, '', 36, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(18, '', 37, 0, 15, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(19, '', 38, 0, 3, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(20, '', 39, 0, 1, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(21, '', 41, 0, 3, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0),
(22, '', 43, 0, 3, 2, 1, '', '', '', 0, 0.00, 0.00, 0.00, 0);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_order_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(50) NOT NULL,
  `deal_code` varchar(50) NOT NULL,
  `invoice` varchar(30) NOT NULL DEFAULT '',
  `add_time` int(11) NOT NULL,
  `shipping_id` smallint(3) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT ' usersID',
  `consignee` varchar(25) NOT NULL DEFAULT '' COMMENT 'Receiver ',
  `email` varchar(25) NOT NULL DEFAULT '',
  `country` varchar(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `zipcode` varchar(10) NOT NULL DEFAULT '',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_money` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `bz` varchar(50) NOT NULL DEFAULT '',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `pay_time` int(11) NOT NULL DEFAULT '0',
  `confirm_time` int(11) NOT NULL DEFAULT '0',
  `shipping_time` int(11) NOT NULL DEFAULT '0',
  `peihuo_time` int(11) NOT NULL DEFAULT '0',
  `is_guaqi` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' ',
  `is_separate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  UNIQUE KEY `deal_code` (`deal_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

INSERT INTO `taoyizhang_wbsd1415_resit_order_info` (`id`, `order_sn`, `deal_code`, `invoice`, `add_time`, `shipping_id`, `user_id`, `consignee`, `email`, `country`, `province`, `city`, `address`, `tel`, `zipcode`, `total_amount`, `pay_money`, `status`, `bz`, `pay_status`, `pay_time`, `confirm_time`, `shipping_time`, `peihuo_time`, `is_guaqi`, `is_separate`) VALUES
(1, 'dfadf', 'dfadf', '', 1420485960, 0, 1, 'dafdadsd', '', '', '', '', 'fafda', 'dsfds', 'vcxvz', 0.00, '0.00', 0, '', 0, 0, 0, 0, 0, 0, 0),
(3, 'werewrwt', 'werewrwt', '', 1420486680, 0, 3, 'df', 'dfadfa', '', '', '', 'sdasfas', 'dfa', 'fda', 0.00, '0.00', 2, 'dfa', 0, 0, 0, 0, 0, 0, 0),
(19, '166199296', '166199296', '', 1420490220, 0, 9, 'dafdadsd', '', '', '', '', 'londonboy', '', '', 0.00, '233424.00', 0, '', 0, 0, 0, 0, 0, 0, 0),
(23, '1420491060', '1420491060', '', 1420491060, 0, 4, 'fdafas', 'earer', '', '', '', 'zxvzds', '1adsf', '71d', 0.00, '4325436.00', 4, '', 0, 0, 0, 0, 0, 0, 0),
(25, '1420059060', '1420059060', '', 1420059060, 0, 4, 'someone', 'someone@gmail.com', '', '', '', 'the earth', '123456788', '710129', 0.00, '4325436.00', 0, '', 0, 0, 0, 0, 0, 0, 0),
(27, '1421182260', '1421182260', '', 1421182260, 0, 4, 'someone', 'someone@gmail.com', '', '', '', 'the earth', '123456788', '710129', 0.00, '4325436.00', 0, '', 0, 0, 0, 0, 0, 0, 0),
(28, '1422305460', '1422305460', '', 1422305460, 0, 4, 'someone', 'someone@gmail.com', '', '', '', 'the earth', '123456788', '710129', 0.00, '4325436.00', 1, '', 0, 0, 1420492035, 0, 0, 0, 0),
(29, '1421355060', '1421355060', '', 1421355060, 0, 4, 'someone', 'someone@gmail.com', '', '', '', 'the earth', '123456788', '710129', 0.00, '4325436.00', 0, '', 0, 0, 0, 0, 0, 0, 0),
(30, '1295124660', '1295124660', '', 1295124660, 0, 4, 'someone', 'someone@gmail.com', '', '', '', 'the earth', '123456788', '710129', 0.00, '4325436.00', 1, '', 0, 0, 1420493294, 0, 0, 0, 0),
(31, '1420494060', '1420494060', '', 1420494060, 0, 4, 'someone', '', '', 'england', 'london', 'the earth', '123456788', '710129', 0.00, '4325436.00', 1, '', 0, 0, 1420494179, 0, 0, 0, 0),
(32, '1420495860', '1420495860', '', 1420495860, 0, 1, '', '', '', '', '', '', '', '', 0.00, '0.00', 1, '', 0, 0, 1420495892, 0, 0, 0, 0),
(33, '1420970460', '1420970460', '', 1420970460, 0, 10, 'Jack', 'jack@gmail.com', '', 'hh', 'dd', 'ee', '23940528', '34855', 0.00, '1234567.00', 1, 'hello', 0, 0, 1420970607, 0, 0, 0, 0),
(34, '1439736840', '1439736840', '', 1439736840, 0, 11, 'liming', 'fdkfj@jfkd.com', '', 'london', 'london', 'londondkfja  dfjkak', '23891', '23214', 0.00, '99999999.99', 1, 'dfsadfadf', 0, 0, 1439782038, 0, 0, 0, 0),
(35, '1439739540', '1439739540', '', 1439739540, 0, 1, '', '', '', '', '', '', '', '', 0.00, '', 1, '', 0, 0, 1439739580, 0, 0, 0, 0),
(36, '1439772540', '1439772540', '', 1439772540, 0, 1, 'dwewq', 'daffdsa', '', 'london', '', '', '', '', 0.00, 'ewer232424', 1, 'afdsdfagd"', 0, 0, 1439774494, 0, 0, 0, 0),
(37, '1439804340', '1439804340', '', 1439804340, 0, 12, 'John', '12@test.com', '', 'london', 'london', 'london', '0238198', '1234', 500.00, '18294127897', 1, 'hi, guy!', 0, 0, 1439808929, 0, 0, 0, 0),
(38, '1439805240', '1439805240', '', 1439805240, 0, 1, '', '', '', '', '', '', '', '', 0.00, '', 0, '', 0, 0, 0, 0, 0, 0, 0),
(39, '1439805420', '1439805420', '', 1439805420, 0, 1, '', '', '', '', '', '', '', '', 0.00, '', 0, '', 0, 0, 0, 0, 0, 0, 0),
(41, '1439805720', '1439805720', '', 1439805720, 0, 13, 'adfa', 'adfa', '', 'adfadf', 'acdsf', 'adfadsf', 'adfad', 'adfads', 0.00, 'adsga', 1, 'adfadf', 0, 0, 1439805758, 0, 0, 0, 0),
(43, '1439805780', '1439805780', '', 1439805780, 0, 15, 'cadg', 'vasva', '', 'dsafewr', 'wet', 'qwetq', 'adavadva', 'etqw', 0.00, 'adcc', 1, 'qetqwqer', 0, 0, 1439805814, 0, 0, 0, 0),
(44, 'sdfadf', 'sdfadf', '', 1439807280, 0, 0, 'afdaca', 'dfafa', '', 'adsdg', 'adfa', 'adfad', '', 'adfad', 0.00, '', 0, 'adfadf', 0, 0, 0, 0, 0, 0, 0),
(46, 'adfaf', 'adfaf', '', 1439808420, 0, 0, 'adfad', 'adsfadf', '', 'adsfa', 'acdaf', 'adfa', 'sdfasf', 'adsfa', 0.00, 'dsfa', 0, 'dfsasdfa', 0, 0, 0, 0, 0, 0, 0);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_payments` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' ',
  `is_cod` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_psend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `djbh` varchar(25) NOT NULL,
  `warehouse_id` smallint(5) NOT NULL,
  `ship_id` smallint(5) NOT NULL,
  `maker_id` int(3) NOT NULL,
  `maker` varchar(20) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_psendlk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL COMMENT 'psend ID',
  `djbh` varchar(25) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_sn` varchar(25) NOT NULL,
  `deal_code` varchar(25) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `goods_number` int(11) NOT NULL DEFAULT '0',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_region` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(120) NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT ' ',
  `code` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=44 COMMENT=' table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_ships` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `support_cod` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `taoyizhang_wbsd1415_resit_ships` (`id`, `code`, `name`, `desc`, `support_cod`, `enabled`) VALUES
(1, '121213', 'ems', 'ems', 1, 1);

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `class_id` tinyint(2) NOT NULL COMMENT '  .id',
  `class_code` varchar(15) NOT NULL COMMENT '  .code',
  `api_params` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `taoyizhang_wbsd1415_resit_shops` (`id`, `code`, `name`, `class_id`, `class_code`, `api_params`) VALUES
(1, 'asd', 'hel', 1, 'asd', 'fafafee');

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_shop_class` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `size_code` (`code`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `taoyizhang_wbsd1415_resit_size` (`id`, `code`, `name`) VALUES
(1, '16', '16GB'),
(2, '32', '32GB');



CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT ' ',
  `nick_name` varchar(30) DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `shop_id` smallint(10) DEFAULT NULL,
  `sex` char(1) NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(60) NOT NULL DEFAULT '',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'last time sign in time',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'last time sign in ip',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pay_points` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `rank_points` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `paid_count` int(10) NOT NULL DEFAULT '0',
  `paid_money` decimal(10,0) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 AUTO_INCREMENT=16 ;

INSERT INTO `taoyizhang_wbsd1415_resit_users` (`id`, `user_name`, `nick_name`, `password`, `shop_id`, `sex`, `birthday`, `email`, `reg_time`, `last_login`, `last_ip`, `visit_count`, `pay_points`, `rank_points`, `paid_count`, `paid_money`, `status`) VALUES
(1, '', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', '', 0, 1420486021, '::1', 0, 0.00, 0.00, 0, 0, 0),
(3, 'as', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'someone@gmail.com', 0, 1420487200, '::1', 0, 0.00, 0.00, 0, 0, 0),
(4, 'londonboy', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'someone@gmail.com', 0, 1420487450, '::1', 0, 0.00, 0.00, 0, 0, 0),
(9, 'ua', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', '', 0, 1420490963, '::1', 0, 0.00, 0.00, 0, 0, 0),
(10, 'Jack', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'jack@gmail.com', 0, 1420970591, '::1', 0, 0.00, 0.00, 0, 0, 0),
(11, 'johg', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'fdkfj@jfkd.com', 0, 1439737105, '::1', 0, 0.00, 0.00, 0, 0, 0),
(12, 'Lee', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', '12@test.com', 0, 1439804409, '::1', 0, 0.00, 0.00, 0, 0, 0),
(13, 'af', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'adfa', 0, 1439805755, '::1', 0, 0.00, 0.00, 0, 0, 0),
(15, 'dfadfa', '', 'cf79ae6addba60ad018347359bd144d2', NULL, '1', '0000-00-00', 'vasva', 0, 1439805811, '::1', 0, 0.00, 0.00, 0, 0, 0);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
