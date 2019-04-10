-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-04-10 00:49:48
-- 服务器版本： 8.0.13
-- PHP 版本： 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `project1`
--

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cinfo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`cid`, `pid`, `uid`, `cinfo`) VALUES
(1, 1, 2, 'Person 2 comment something to pid 1');

-- --------------------------------------------------------

--
-- 表的结构 `currentstate`
--

CREATE TABLE `currentstate` (
  `uid` int(11) NOT NULL,
  `currentstatenname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `currentstate`
--

INSERT INTO `currentstate` (`uid`, `currentstatenname`) VALUES
(1, 'At lunch'),
(1, 'None'),
(2, 'At dinner'),
(2, 'None'),
(3, 'None'),
(4, 'None'),
(5, 'At work'),
(5, 'None');

-- --------------------------------------------------------

--
-- 表的结构 `filter`
--

CREATE TABLE `filter` (
  `fid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `ftag1` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ftag2` varchar(45) NOT NULL,
  `ftag3` varchar(45) NOT NULL,
  `fradius` int(11) NOT NULL,
  `positionid` int(11) NOT NULL,
  `fvisible` varchar(45) NOT NULL,
  `currentstatename` varchar(45) NOT NULL,
  `fkeyword` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `filter`
--

INSERT INTO `filter` (`fid`, `uid`, `sid`, `ftag1`, `ftag2`, `ftag3`, `fradius`, `positionid`, `fvisible`, `currentstatename`, `fkeyword`) VALUES
(1, 1, 1, '#food', 'None', 'None', 300, 1, 'Everyone', 'At lunch/None', 'None'),
(2, 2, 2, '#shopping', 'None', 'None', 300, 1, 'Everyone', 'At dinner/None', 'Special'),
(3, 2, 3, '#me', 'None', 'None', 300, 2, 'Friend', 'At dinner/None', 'Special'),
(4, 2, 4, '#food', 'None', 'None', 300, 3, 'Everyone', 'At dinner/None', 'Special'),
(5, 3, 3, 'None', 'None', 'None', 300, 1, 'Everyone', 'None', 'None'),
(6, 4, 4, 'None', 'None', 'None', 300, 1, 'Everyone', 'None', 'None'),
(7, 5, 5, '#food', 'None', 'None', 300, 2, 'Friend', 'At work/None', 'None'),
(8, 2, 1, '#food', '#shopping', 'None', 300, 1, 'Me', 'At dinner/None', 'Special'),
(9, 2, 1, 'None', 'None', 'None', 300, 1, 'Me', 'At dinner/None', 'None'),
(10, 2, 3, '#me', '#food', '#shopping', 300, 1, 'Friend', 'At dinner/None', 'Special'),
(11, 2, 3, '#food', '#shopping', '#me', 300, 2, 'Me', 'At dinner/None', 'None'),
(12, 2, 2, 'None', 'None', 'None', 300, 2, 'Everyone', 'At dinner/None', 'Special'),
(13, 2, 2, 'None', 'None', 'None', 300, 1, 'Friend', 'At dinner/None', 'Special'),
(14, 2, 6, '#food', '#shopping', 'None', 300, 3, 'Everyone', 'At dinner/None', 'Special'),
(15, 2, 7, '#food', 'None', 'None', 300, 3, 'Friend', 'At dinner/None', 'Special'),
(16, 2, 8, 'None', 'None', 'None', 300, 3, 'Me', 'None', 'None');

-- --------------------------------------------------------

--
-- 表的结构 `friend`
--

CREATE TABLE `friend` (
  `uid` int(11) NOT NULL,
  `friendid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `friend`
--

INSERT INTO `friend` (`uid`, `friendid`) VALUES
(1, 2),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(3, 2),
(3, 4),
(3, 5),
(4, 2),
(4, 3),
(4, 5),
(5, 2),
(5, 3),
(5, 4);

-- --------------------------------------------------------

--
-- 表的结构 `lasttracking`
--

CREATE TABLE `lasttracking` (
  `uid` int(11) NOT NULL,
  `ttime` time NOT NULL,
  `ttweeknum` varchar(45) NOT NULL,
  `ttdate` date NOT NULL,
  `ttxcord` int(11) NOT NULL,
  `ttycord` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `lasttracking`
--

INSERT INTO `lasttracking` (`uid`, `ttime`, `ttweeknum`, `ttdate`, `ttxcord`, `ttycord`) VALUES
(1, '15:05:00', 'Mon', '2018-11-12', 1200, 1400),
(2, '12:00:00', 'Mon', '2018-11-15', 340, 450),
(3, '15:05:00', 'Mon', '2018-11-12', 305, 405),
(4, '15:05:00', 'Mon', '2018-11-12', 10, 15),
(5, '15:05:00', 'Mon', '2018-11-12', 3000, 4000);

-- --------------------------------------------------------

--
-- 表的结构 `position`
--

CREATE TABLE `position` (
  `positionid` int(11) NOT NULL,
  `posname` varchar(45) NOT NULL,
  `posxcord` int(11) NOT NULL,
  `posycord` int(11) NOT NULL,
  `posradius` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `position`
--

INSERT INTO `position` (`positionid`, `posname`, `posxcord`, `posycord`, `posradius`) VALUES
(1, 'Current', 0, 0, 0),
(2, 'Brooklyn', 400, 450, 300),
(3, 'Las Vegas ', 3000, 4000, 300);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE `post` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pinfo` varchar(45) NOT NULL,
  `ptag` varchar(45) NOT NULL,
  `pradius` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pcommentYN` varchar(45) NOT NULL,
  `pvisible` varchar(45) NOT NULL,
  `pxcord` int(11) NOT NULL,
  `pycord` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`pid`, `uid`, `pinfo`, `ptag`, `pradius`, `sid`, `pcommentYN`, `pvisible`, `pxcord`, `pycord`) VALUES
(1, 1, 'Person 1 post something None', '#food #shopping None', 300, 1, 'Y', 'Everyone', 305, 405),
(2, 2, 'Person 2 post something None', '#food #shopping None', 300, 2, 'Y', 'Everyone', 300, 400),
(3, 3, 'Person 3 post something None', '#food #shopping None', 300, 3, 'Y', 'Everyone', 310, 420),
(4, 4, 'Person 4 post something None', '#food #shopping None', 300, 4, 'Y', 'Everyone', 325, 425),
(5, 5, 'Person 5 post something None', '#food #shopping #me None', 300, 5, 'Y', 'Friend', 425, 425),
(6, 2, 'Person 2 post something again None', 'None', 300, 3, 'Y', 'Friend', 330, 440),
(7, 2, 'Person 2 post something again again None', '#food #shopping None', 300, 4, 'Y', 'Everyone', 300, 400),
(8, 2, 'Person 2 post something again again~ None', '#food #shopping None', 300, 1, 'Y', 'Me', 300, 400),
(9, 2, 'Person 2 post something special None', 'None', 300, 1, 'Y', 'Me', 300, 400),
(10, 2, 'Person 2 post something special~ None', '#food #shopping None', 300, 6, 'Y', 'Friend', 425, 425),
(11, 2, 'Person 2 post something special! None', 'None', 300, 7, 'Y', 'Everyone', 425, 425),
(12, 5, ' Person 5 post something again None', '#food #shopping None', 300, 5, 'Y', 'Everyone', 3005, 4100),
(13, 4, ' Person 4 post something again None', 'None', 300, 4, 'Y', 'Me', 300, 400),
(14, 3, ' Person 3 post something again None', '#food #shopping None', 300, 8, 'Y', 'Everyone', 3100, 4005),
(15, 3, ' Person 3 post something again again None', '#food #shopping None', 300, 5, 'N', 'Friend', 3105, 4100),
(16, 3, ' Person 3 post something special~ None', '#food #shopping None', 300, 4, 'Y', 'Everyone', 3105, 4100),
(17, 5, 'Person 5 post something~ None', '#food None', 300, 1, 'Y', 'Friend', 350, 400);

-- --------------------------------------------------------

--
-- 表的结构 `schedule`
--

CREATE TABLE `schedule` (
  `sid` int(11) NOT NULL,
  `severydayYN` varchar(45) NOT NULL,
  `severyweeknumN` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sdate` date NOT NULL,
  `sstarttime` time NOT NULL,
  `sendtime` time NOT NULL,
  `sfromdate` date NOT NULL,
  `senddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `schedule`
--

INSERT INTO `schedule` (`sid`, `severydayYN`, `severyweeknumN`, `sdate`, `sstarttime`, `sendtime`, `sfromdate`, `senddate`) VALUES
(1, 'Y', 'N', '1999-01-01', '08:00:00', '20:00:00', '2018-11-01', '2018-11-30'),
(2, 'N', 'Mon Tue Fri', '1999-01-01', '09:00:00', '21:00:00', '2018-11-01', '2018-11-30'),
(3, 'N', 'N', '2018-11-12', '08:00:00', '19:00:00', '1999-01-01', '2099-12-31'),
(4, 'Y', 'N', '1999-01-01', '08:00:00', '20:00:00', '2018-11-02', '2018-11-29'),
(5, 'N', 'Mon', '1999-01-01', '09:00:00', '21:00:00', '2018-11-01', '2018-11-30'),
(6, 'N', 'N', '2018-11-15', '09:00:00', '22:00:00', '2018-11-01', '2018-11-30'),
(7, 'Y', 'N', '1999-01-01', '09:00:00', '22:00:00', '2017-11-01', '2017-11-30'),
(8, 'N', 'Sun', '1999-01-01', '09:00:00', '22:00:00', '2018-11-01', '2018-11-30');

-- --------------------------------------------------------

--
-- 表的结构 `temp`
--

CREATE TABLE `temp` (
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `temp1`
--

CREATE TABLE `temp1` (
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `temp2`
--

CREATE TABLE `temp2` (
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `ufirstname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ulastname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uemail` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uusername` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upassword` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ugender` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `currentstate` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`uid`, `ufirstname`, `ulastname`, `uemail`, `uusername`, `upassword`, `ugender`, `currentstate`) VALUES
(1, 'Jeff', 'Li', '123456@gmail.com', 'JeffLi123456', '123456', 'Female', 'At lunch'),
(2, 'Wu', 'Ku', '12345@gmail.com', 'WuKu12345', '12345', 'Female', 'At dinner'),
(3, 'An', 'Na', '1234@gmail.com', 'AnNa1234', '1234', 'Female', 'None'),
(4, 'Si', 'Li', '123@gmail.com', 'SiLi123', '123', 'Female', 'None'),
(5, 'Ke', 'Qing', '12@gmail.com', 'KeQing12', '12', 'Female', 'At work');

--
-- 转储表的索引
--

--
-- 表的索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `currentstate`
--
ALTER TABLE `currentstate`
  ADD PRIMARY KEY (`uid`,`currentstatenname`);

--
-- 表的索引 `filter`
--
ALTER TABLE `filter`
  ADD PRIMARY KEY (`fid`);

--
-- 表的索引 `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`uid`,`friendid`);

--
-- 表的索引 `lasttracking`
--
ALTER TABLE `lasttracking`
  ADD PRIMARY KEY (`uid`,`ttime`);

--
-- 表的索引 `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`positionid`);

--
-- 表的索引 `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`pid`);

--
-- 表的索引 `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sid`);

--
-- 表的索引 `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`sid`);

--
-- 表的索引 `temp1`
--
ALTER TABLE `temp1`
  ADD PRIMARY KEY (`pid`);

--
-- 表的索引 `temp2`
--
ALTER TABLE `temp2`
  ADD PRIMARY KEY (`pid`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `filter`
--
ALTER TABLE `filter`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `position`
--
ALTER TABLE `position`
  MODIFY `positionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
