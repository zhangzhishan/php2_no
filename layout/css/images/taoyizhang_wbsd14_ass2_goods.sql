-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-01-03 22:29:50
-- 服务器版本： 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `baby`
--

-- --------------------------------------------------------

--
--  table的结构 `taoyizhang_wbsd1415_resit_goods`
--

CREATE TABLE IF NOT EXISTS `taoyizhang_wbsd1415_resit_goods` (
`id` int(11) NOT NULL,
  `goods_sn` varchar(50) NOT NULL COMMENT 'goods  number',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT 'goods name',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '场价市',
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'weight',
  `brand_id` smallint(3) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '类别：比如春装，冬装',
  `storage` varchar(11) NOT NULL DEFAULT '0' COMMENT '容量',
  `warn_stock_num` int(11) NOT NULL DEFAULT '0' COMMENT '紧急 stock 量',
  `img_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'picturesurl',
  `describle` varchar(100) NOT NULL DEFAULT '' COMMENT 'goods description'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='goods ' AUTO_INCREMENT=19 ;

--
-- 转存 table中的 data  `taoyizhang_wbsd1415_resit_goods`
--

INSERT INTO `taoyizhang_wbsd1415_resit_goods` (`id`, `goods_sn`, `goods_name`, `price`, `weight`, `brand_id`, `category_id`, `storage`, `warn_stock_num`, `img_url`, `describle`) VALUES
(1, 'Sdfafdaf', 'iPhone5s', '500.00', '300.00', 1, 1, '32', 430, 'iphone5s.jpg', 'buybuybuy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taoyizhang_wbsd1415_resit_goods`
--
ALTER TABLE `taoyizhang_wbsd1415_resit_goods`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `goods_sn` (`goods_sn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taoyizhang_wbsd1415_resit_goods`
--
ALTER TABLE `taoyizhang_wbsd1415_resit_goods`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
