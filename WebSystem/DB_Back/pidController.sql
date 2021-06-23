-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2021 年 06 月 22 日 16:52
-- 伺服器版本: 5.5.57-MariaDB
-- PHP 版本： 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `nukiot`
--

-- --------------------------------------------------------

--
-- 資料表結構 `pidController`
--

CREATE TABLE `pidController` (
  `id` int(11) NOT NULL COMMENT '主鍵',
  `MAC` char(12) CHARACTER SET ascii NOT NULL COMMENT '裝置MAC值',
  `did` int(11) NOT NULL COMMENT 'Modbus線號',
  `crtdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '資料輸入時間',
  `systime` char(14) CHARACTER SET armscii8 NOT NULL COMMENT '使用者更新時間',
  `PV` float DEFAULT NULL COMMENT '溫度',
  `SV` float DEFAULT NULL COMMENT '設定值',
  `AL1L` float DEFAULT NULL COMMENT 'Alarm 設定值(下界)',
  `AL1Flag` tinyint(1) DEFAULT NULL COMMENT 'Alarm 設定開關',
  `ALT1H` float DEFAULT NULL COMMENT 'Alarm 設定值(上界)',
  `Relay1` float DEFAULT NULL COMMENT '第一組繼電器設定值',
  `Relay1Flag` tinyint(1) DEFAULT NULL COMMENT '第一組繼電器設定開關',
  `Relay2` float DEFAULT NULL COMMENT '第二組繼電器設定值',
  `Relay2Flag` tinyint(1) DEFAULT NULL COMMENT '第二組繼電器設定開關'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `pidController`
--

INSERT INTO `pidController` (`id`, `MAC`, `did`, `crtdatetime`, `systime`, `PV`, `SV`, `AL1L`, `AL1Flag`, `ALT1H`, `Relay1`, `Relay1Flag`, `Relay2`, `Relay2Flag`) VALUES
(4, 'CC50E3B6B808', 1, '2020-11-02 09:11:44', '20200701012328', 26.9, 80, 80, 1, 100, NULL, NULL, NULL, NULL);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `pidController`
--
ALTER TABLE `pidController`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `MAC` (`MAC`,`did`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `pidController`
--
ALTER TABLE `pidController`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主鍵', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
