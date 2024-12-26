-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 08:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ciphernest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `UserID` varchar(50) NOT NULL,
  `PassWD` varchar(50) NOT NULL,
  `AName` varchar(30) NOT NULL,
  `RememberToken` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`UserID`, `PassWD`, `AName`, `RememberToken`) VALUES
('poojabarafwala09@gmail.com', 'Pooja@9114', 'Pooja', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblencrypt_decrypt`
--

CREATE TABLE `tblencrypt_decrypt` (
  `KID` int(11) NOT NULL,
  `UID` varchar(50) NOT NULL,
  `KeyValue` varchar(50) NOT NULL,
  `KeyMode` varchar(10) NOT NULL,
  `CreationDateTime` datetime NOT NULL,
  `KeySize` int(11) NOT NULL,
  `OutputFormat` varchar(20) NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblencrypt_decrypt`
--

INSERT INTO `tblencrypt_decrypt` (`KID`, `UID`, `KeyValue`, `KeyMode`, `CreationDateTime`, `KeySize`, `OutputFormat`, `Action`) VALUES
(1, 'poojabara1223@gmail.com', '1111111111111111', 'cbc', '2024-10-19 23:36:26', 128, 'Base64', 'encrypt'),
(2, 'poojabara1223@gmail.com', '1000000000000000', 'cbc', '2024-10-19 23:40:00', 128, 'Base64', 'encrypt'),
(3, 'poojabara1223@gmail.com', '1000000000000000', 'cbc', '2024-10-19 23:40:04', 128, 'PlainText', 'decrypt'),
(4, 'poojabara1223@gmail.com', '1000000000000000', 'cbc', '2024-10-19 23:40:21', 128, 'Base64', 'decrypt'),
(5, 'poojabara1223@gmail.com', '1000000000000000', 'cbc', '2024-10-19 23:40:24', 128, 'PlainText', 'decrypt'),
(6, 'poojabara1223@gmail.com', '1000000000000000', 'cbc', '2024-10-19 23:40:26', 128, 'Base64', 'encrypt'),
(17, 'poojabarafwala09@gmail.com', '1234567891234567', 'cbc', '2024-10-19 23:56:55', 128, 'Base64', 'encrypt'),
(18, 'poojabarafwala09@gmail.com', '1234567891234567', 'cbc', '2024-10-19 23:56:58', 128, 'PlainText', 'decrypt');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `FID` int(11) NOT NULL,
  `UID` varchar(50) NOT NULL,
  `UName` varchar(30) NOT NULL,
  `Feedback` longtext NOT NULL,
  `FDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`FID`, `UID`, `UName`, `Feedback`, `FDateTime`) VALUES
(1, 'poojabara1223@gmail.com', 'pooja', 'good', '2024-10-19 23:34:57'),
(2, 'poojabara1223@gmail.com', 'pooja barafwala', 'great', '2024-10-19 23:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `tblhistory`
--

CREATE TABLE `tblhistory` (
  `HID` int(11) DEFAULT NULL,
  `UID` varchar(50) NOT NULL,
  `OrgText` longtext NOT NULL,
  `EncText` longtext NOT NULL,
  `DecrptText` longtext NOT NULL,
  `CreationDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblhistory`
--

INSERT INTO `tblhistory` (`HID`, `UID`, `OrgText`, `EncText`, `DecrptText`, `CreationDateTime`) VALUES
(NULL, 'poojabara1223@gmail.com', 'pooja', 'N57jf8u2kDwx6RlrJfoYL3lxb20veVpkTEVXdXhiZTZTeXM0Nmc9PQ==', '', '2024-10-19 23:40:00'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:04'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'cG9vamE=', '2024-10-19 23:40:21'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:24'),
(NULL, 'poojabara1223@gmail.com', 'pooja', 'DOmrP2ZfX4/ucqPgOmEvLlVnSjM2ajg3VStUWjEwbzJOVEdUelE9PQ==', '', '2024-10-19 23:40:26'),
(NULL, 'poojabara1223@gmail.com', 'pooja', 'WWB1ZFpweMbIdny3iI3m9WVONjlRRCtaVk5JM3JvOGl3WEFrVmc9PQ==', '', '2024-10-19 23:40:29'),
(NULL, 'poojabara1223@gmail.com', 'pooja', 'QrmiNdCLU2Vii8rQXFJWL3k5aDdsaDBqM1pjVi8wV045SlRUbkE9PQ==', '', '2024-10-19 23:40:30'),
(NULL, 'poojabara1223@gmail.com', 'pooja', 'tQCwqv/gppDpysbL9BIhLjFoczFPNFZzVEY3aGE4dVQrRC9VcFE9PQ==', '', '2024-10-19 23:40:30'),
(NULL, 'poojabara1223@gmail.com', 'pooja', 'hQngZb87ThL21hzeg+sA1nB6UmhmYWNUUFUzeVBydmZQVkVFeEE9PQ==', '', '2024-10-19 23:40:31'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '5E2GNcLx7NuB7XuLtcSUo0hnNFJ2ZjhBS1ZKYzRUbDF3OXNTdUE9PQ==', '', '2024-10-19 23:40:32'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:33'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:34'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:35'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:35'),
(NULL, 'poojabara1223@gmail.com', 'pooja', '', 'pooja', '2024-10-19 23:40:35'),
(NULL, 'poojabarafwala09@gmail.com', 'now your turn', 'zIHF4Zwdnu1Fi5Vga7af4VJ4N0h6TnZtaUNOTUdxbEwzVVNZZGc9PQ==', '', '2024-10-19 23:56:55'),
(NULL, 'poojabarafwala09@gmail.com', 'now your turn', '', 'now your turn', '2024-10-19 23:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `UNo` int(11) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `UName` varchar(30) NOT NULL,
  `PassWD` varchar(30) NOT NULL,
  `CPassWD` varchar(30) NOT NULL,
  `CreationDateTime` datetime NOT NULL,
  `RememberToken` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`UNo`, `UserID`, `UName`, `PassWD`, `CPassWD`, `CreationDateTime`, `RememberToken`) VALUES
(1, 'poojabara1223@gmail.com', 'pooja barafwala', 'Puja@2020', 'Puja@2020', '2024-10-19 23:36:02', 'b708c4ce712162ec5f7b438de200ba');

-- --------------------------------------------------------

--
-- Table structure for table `tbluseractivity`
--

CREATE TABLE `tbluseractivity` (
  `SID` int(11) NOT NULL,
  `UID` varchar(50) NOT NULL,
  `LastLoginDateTime` datetime NOT NULL,
  `LastLogoutDateTime` datetime NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Duration` varchar(50) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseractivity`
--

INSERT INTO `tbluseractivity` (`SID`, `UID`, `LastLoginDateTime`, `LastLogoutDateTime`, `Status`, `Duration`, `RoleID`) VALUES
(1, 'poojabara1223@gmail.com', '2024-10-19 23:36:13', '2024-10-19 23:44:35', 'InActive', '0 hours 8 minutes 22 seconds', 2),
(3, 'poojabarafwala09@gmail.com', '2024-10-19 23:51:51', '2024-10-19 23:58:18', 'InActive', '0 hours 6 minutes 27 seconds', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbluserrole`
--

CREATE TABLE `tbluserrole` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(30) NOT NULL,
  `Permission` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `tblencrypt_decrypt`
--
ALTER TABLE `tblencrypt_decrypt`
  ADD PRIMARY KEY (`KID`);

--
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`FID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`UNo`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `tbluseractivity`
--
ALTER TABLE `tbluseractivity`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `tbluserrole`
--
ALTER TABLE `tbluserrole`
  ADD PRIMARY KEY (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblencrypt_decrypt`
--
ALTER TABLE `tblencrypt_decrypt`
  MODIFY `KID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `UNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluseractivity`
--
ALTER TABLE `tbluseractivity`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
