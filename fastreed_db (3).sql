-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2022 at 08:52 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastreed_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminCredentials`
--

CREATE TABLE `adminCredentials` (
  `adminID` varchar(18) NOT NULL,
  `fullName` text NOT NULL,
  `emailAddress` varchar(60) NOT NULL,
  `adminPic` text NOT NULL,
  `adminType` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `s.no` int(11) NOT NULL,
  `adminID` varchar(18) NOT NULL,
  `adminUName` varchar(20) NOT NULL,
  `adminGET` varchar(60) NOT NULL,
  `adminPassword` varchar(100) NOT NULL,
  `adminType` text NOT NULL COMMENT 'S =  1st Level Admin\r\nP = 2nd Level Admin\r\nD = 3rd Level Admins'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`s.no`, `adminID`, `adminUName`, `adminGET`, `adminPassword`, `adminType`) VALUES
(1, 'AID202211280000001', 'MOHDSHAFIQ', 'HelloIAmAdmin', '$2y$10$YCTFynCLxn7vQdoGuASHsOarIy.5.N6.s6KxyXfHs4niv5ORamnQ6', 'S');

-- --------------------------------------------------------

--
-- Table structure for table `admins_sessions`
--

CREATE TABLE `admins_sessions` (
  `s.no` int(11) NOT NULL,
  `sessionID` varchar(18) NOT NULL,
  `adminID` varchar(18) NOT NULL,
  `tdate` date NOT NULL,
  `adminIP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deviceManager`
--

CREATE TABLE `deviceManager` (
  `s.no` int(12) NOT NULL,
  `deviceID` varchar(18) NOT NULL,
  `userOrAdminID` varchar(18) NOT NULL,
  `loggedDateTime` datetime NOT NULL,
  `logoutDateTime` datetime NOT NULL,
  `loggedStatus` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deviceManager`
--

INSERT INTO `deviceManager` (`s.no`, `deviceID`, `userOrAdminID`, `loggedDateTime`, `logoutDateTime`, `loggedStatus`) VALUES
(1, 'DID202211280000001', 'UID202211280000001', '2022-11-28 13:36:34', '0000-00-00 00:00:00', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `s.no` int(11) NOT NULL,
  `tdate` date NOT NULL,
  `nickname` text DEFAULT NULL,
  `guestID` varchar(18) NOT NULL,
  `guestDevice` text NOT NULL,
  `guestBrowser` text NOT NULL,
  `guestPlatform` text NOT NULL,
  `browserInfo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`s.no`, `tdate`, `nickname`, `guestID`, `guestDevice`, `guestBrowser`, `guestPlatform`, `browserInfo`) VALUES
(30, '2022-11-29', NULL, 'GID202211290000000', 'Desktop', 'Chrome', 'Linux', 'a:15:{s:18:\"browser_name_regex\";s:96:\"~^mozilla/5.0 (.*linux.*) applewebkit.* (.*khtml.*like.*gecko.*) chrome/107.0.*safari/.*$~\";s:20:\"browser_name_pattern\";s:77:\"Mozilla/5.0 (*Linux*) applewebkit* (*khtml*like*gecko*) Chrome/107.0*Safari/*\";s:6:\"parent\";s:12:\"Chrome 107.0\";s:8:\"platform\";s:5:\"Linux\";s:7:\"comment\";s:12:\"Chrome 107.0\";s:7:\"browser\";s:6:\"Chrome\";s:13:\"browser_maker\";s:10:\"Google Inc\";s:7:\"version\";s:5:\"107.0\";s:8:\"majorver\";s:3:\"107\";s:11:\"device_type\";s:7:\"Desktop\";s:22:\"device_pointing_method\";s:5:\"mouse\";s:8:\"minorver\";s:1:\"0\";s:14:\"ismobiledevice\";s:0:\"\";s:8:\"istablet\";s:0:\"\";s:7:\"crawler\";s:0:\"\";}');

-- --------------------------------------------------------

--
-- Table structure for table `guests_sessions`
--

CREATE TABLE `guests_sessions` (
  `s.no` int(12) NOT NULL,
  `sessionID` varchar(18) NOT NULL,
  `guestID` varchar(18) NOT NULL,
  `tdate` date NOT NULL,
  `guestIP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guests_sessions`
--

INSERT INTO `guests_sessions` (`s.no`, `sessionID`, `guestID`, `tdate`, `guestIP`) VALUES
(4, 'GSI202211290000000', 'GID202211290000000', '2022-11-29', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `sessionVisits`
--

CREATE TABLE `sessionVisits` (
  `s.no` int(20) NOT NULL,
  `sessionID` varchar(18) NOT NULL,
  `visitTime` text NOT NULL,
  `visitedPage` text NOT NULL,
  `referedByPerson` text NOT NULL,
  `referedByPage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessionVisits`
--

INSERT INTO `sessionVisits` (`s.no`, `sessionID`, `visitTime`, `visitedPage`, `referedByPerson`, `referedByPage`) VALUES
(158, 'GSI202211290000000', '1669737360', '/admin/login/?adminQoute=3480', 'N', 'N'),
(159, 'GSI202211290000000', '1669737360', '/admin/login/unauthorized.php', 'N', 'N'),
(160, 'GSI202211290000000', '1669737362', '/admin/login/unauthorized.php', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `s.no` int(11) NOT NULL,
  `userID` varchar(18) NOT NULL,
  `deviceID` varchar(18) NOT NULL,
  `tdate` date NOT NULL,
  `userName` text NOT NULL,
  `browserInfo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `s.no` int(11) NOT NULL,
  `sessionID` varchar(18) NOT NULL,
  `userID` varchar(18) NOT NULL,
  `tdate` date NOT NULL,
  `userIP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminCredentials`
--
ALTER TABLE `adminCredentials`
  ADD UNIQUE KEY `loginID_2` (`adminID`),
  ADD KEY `loginID` (`adminID`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`s.no`),
  ADD UNIQUE KEY `adminUName` (`adminUName`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `admins_sessions`
--
ALTER TABLE `admins_sessions`
  ADD PRIMARY KEY (`s.no`);

--
-- Indexes for table `deviceManager`
--
ALTER TABLE `deviceManager`
  ADD PRIMARY KEY (`s.no`),
  ADD UNIQUE KEY `loggedDateTime` (`loggedDateTime`),
  ADD UNIQUE KEY `deviceID` (`deviceID`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`s.no`),
  ADD UNIQUE KEY `visitorId` (`guestID`);

--
-- Indexes for table `guests_sessions`
--
ALTER TABLE `guests_sessions`
  ADD PRIMARY KEY (`s.no`),
  ADD UNIQUE KEY `sessionID` (`sessionID`);

--
-- Indexes for table `sessionVisits`
--
ALTER TABLE `sessionVisits`
  ADD UNIQUE KEY `s.no` (`s.no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`s.no`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`s.no`),
  ADD UNIQUE KEY `sessionID_2` (`sessionID`),
  ADD KEY `sessionID` (`sessionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins_sessions`
--
ALTER TABLE `admins_sessions`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deviceManager`
--
ALTER TABLE `deviceManager`
  MODIFY `s.no` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `guests_sessions`
--
ALTER TABLE `guests_sessions`
  MODIFY `s.no` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sessionVisits`
--
ALTER TABLE `sessionVisits`
  MODIFY `s.no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
