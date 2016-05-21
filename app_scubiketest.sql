-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2015 年 12 月 24 日 23:32
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_scubiketest`
--

-- --------------------------------------------------------

--
-- 表的结构 `bike_admin`
--

CREATE TABLE IF NOT EXISTS `bike_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '管理员用户名',
  `password` char(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `bike_admin`
--

INSERT INTO `bike_admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- 表的结构 `bike_lend`
--

CREATE TABLE IF NOT EXISTS `bike_lend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL COMMENT '借车人的user_id',
  `lendCreateAt` int(10) DEFAULT NULL COMMENT '借车时间,采用标准时间戳保存',
  `lendStationId` int(10) DEFAULT NULL COMMENT '借车站点id',
  `returnStationId` int(10) DEFAULT NULL COMMENT '还车站点id',
  `returnCreateAt` int(10) DEFAULT NULL COMMENT '还车时间',
  `status` tinyint(2) DEFAULT NULL COMMENT '订单状态,0为借出未还,1为已还',
  `updateCreateAt` int(10) DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `index` (`userId`,`lendCreateAt`,`lendStationId`,`returnStationId`,`returnCreateAt`,`status`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='自行车借还详情表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `bike_lend`
--

INSERT INTO `bike_lend` (`id`, `userId`, `lendCreateAt`, `lendStationId`, `returnStationId`, `returnCreateAt`, `status`, `updateCreateAt`) VALUES
(1, 4, 1450969037, 1, 2, 1450969294, 1, 1450969294),
(2, 4, 1450970183, 1, 1, 1450970210, 1, 1450970210);

-- --------------------------------------------------------

--
-- 表的结构 `bike_scan`
--

CREATE TABLE IF NOT EXISTS `bike_scan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wechatId` char(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户微信唯一id',
  `createAt` int(10) DEFAULT NULL COMMENT '扫描时间',
  `stationId` int(10) DEFAULT NULL COMMENT '站点id',
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `bike_scan`
--

INSERT INTO `bike_scan` (`id`, `wechatId`, `createAt`, `stationId`, `status`) VALUES
(1, 'ol6OBt-AaiMp7CrNHHfXgrypodbM', 1450969034, 1, 1),
(2, 'ol6OBt-AaiMp7CrNHHfXgrypodbM', 1450969291, 2, 1),
(3, 'ol6OBt-AaiMp7CrNHHfXgrypodbM', 1450970171, 1, 1),
(4, 'ol6OBt-AaiMp7CrNHHfXgrypodbM', 1450970203, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `bike_station`
--

CREATE TABLE IF NOT EXISTS `bike_station` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL COMMENT '站台可借自行车数量',
  `name` char(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '站台名',
  `x` char(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '站点x坐标',
  `y` char(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '站点y坐标',
  `initNumber` int(11) DEFAULT NULL COMMENT '站点初始车辆',
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='自行车站点信息表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `bike_station`
--

INSERT INTO `bike_station` (`id`, `number`, `name`, `x`, `y`, `initNumber`) VALUES
(1, 4, '校车站', '30.560068', '103.999699', 5),
(2, 26, '二基楼', '30.564219', '104.009346', 25);

-- --------------------------------------------------------

--
-- 表的结构 `bike_user`
--

CREATE TABLE IF NOT EXISTS `bike_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `wechatName` char(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信名',
  `wechatId` char(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信唯一id',
  `createAt` int(10) DEFAULT NULL COMMENT '注册时间，采用标准时间戳保存',
  `gender` tinyint(4) DEFAULT NULL COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `headImgUrl` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index` (`wechatId`) USING BTREE,
  KEY `time` (`createAt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户信息表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `bike_user`
--

INSERT INTO `bike_user` (`id`, `wechatName`, `wechatId`, `createAt`, `gender`, `headImgUrl`) VALUES
(3, '小明', 'oMF6BjiHDIB5C0fgxsKBOGXC5wH8', 1417278343, 1, 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7h6RJJBdkXMP7UN5nicB1zlAwibZ3UwnnXqiccx9icMTTO5JzItAGs5nZibQuYvHME4bgyqEknyzluQow/0'),
(4, 'TobyHan', 'ol6OBt-AaiMp7CrNHHfXgrypodbM', 1450943830, 1, 'http://wx.qlogo.cn/mmopen/3uLVic8oVrNQa0RssL9pOergJu0cicI59qFSWPsBqNj3ZVAdnbTCRyWdOMQvktEIDcfia4BpibKr3Fn0C57AV6qUia4khibkUsibgMK/0');
