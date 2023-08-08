-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2023 at 05:51 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20889210_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`id20889210_db_conn`@`%` PROCEDURE `CheckProxyVoting` (IN `ip_address` VARCHAR(255), OUT `is_proxy` VARCHAR(5))   BEGIN
    DECLARE proxy_count INT;

    -- Check if the IP address exists in the voter_pub_ip table
    SELECT COUNT(*) INTO proxy_count
    FROM voter_pub_ip
    WHERE public_ip_address = ip_address;

    -- Set the value of is_proxy based on the count
    IF proxy_count > 0 THEN
        SET is_proxy = 'true';
    ELSE
        SET is_proxy = 'false';
    END IF;
END$$

CREATE DEFINER=`id20889210_db_conn`@`%` PROCEDURE `insert_admin_log` (IN `p_username` VARCHAR(255), IN `p_action` VARCHAR(255), IN `p_log_action_date` DATETIME)   BEGIN
INSERT INTO tb_admin_action_logs (admin_id, action, log_action_date)
SELECT tbadmin.admin_id, p_action, p_log_action_date
FROM tbadmin
WHERE tbadmin.username = p_username;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `college_program`
--

CREATE TABLE `college_program` (
  `program_id` int(25) NOT NULL,
  `college_program_name` varchar(150) NOT NULL,
  `college_id` int(25) NOT NULL,
  `campus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_program`
--

INSERT INTO `college_program` (`program_id`, `college_program_name`, `college_id`, `campus`) VALUES
(123, 'Bachelor of Science in Information Technology', 144, 'Tagum'),
(146, 'Bachelor of Science in Agricultural and Biosystems Engineering', 145, 'Mabini'),
(156, 'Bachelor of Science in Information Technology', 145, 'Mabini');

-- --------------------------------------------------------

--
-- Table structure for table `college_tbl`
--

CREATE TABLE `college_tbl` (
  `college_id` int(25) NOT NULL,
  `college_name` varchar(100) NOT NULL,
  `campus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_tbl`
--

INSERT INTO `college_tbl` (`college_id`, `college_name`, `campus`) VALUES
(144, 'College of Teacher Education and Technology', 'Tagum'),
(145, 'College of Agriculture and Related Sciences', 'Mabini'),
(147, 'College of Teacher Education and Technology', 'Mabini');

-- --------------------------------------------------------

--
-- Table structure for table `tbadmin`
--

CREATE TABLE `tbadmin` (
  `admin_id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbadmin`
--

INSERT INTO `tbadmin` (`admin_id`, `firstName`, `lastName`, `username`, `password`, `role`) VALUES
(12, 'marvin', 'estolloso', 'chairperson', '5f4dcc3b5aa765d61d8327deb882cf99', 'Central-Chairperson'),
(15, 'michael', 'labastida', 'mabiniwatcher', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mabini-Watcher'),
(16, 'nelmar', 'luna', 'tagumwatcher', '5f4dcc3b5aa765d61d8327deb882cf99', 'Tagum-Watcher'),
(23, 'cassandra', 'bonsubre', 'mabiniadmin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mabini'),
(24, 'Mister', 'Vin', 'tagumadmin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Tagum'),
(25, 'ako', 'lng', 'monitoring', '5f4dcc3b5aa765d61d8327deb882cf99', 'Monitoring'),
(26, 'si', 'basila', 'tech', '5f4dcc3b5aa765d61d8327deb882cf99', 'Technical-Officer');

-- --------------------------------------------------------

--
-- Table structure for table `tbcouncil`
--

CREATE TABLE `tbcouncil` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `position_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbcouncil`
--

INSERT INTO `tbcouncil` (`id`, `code`, `campus`, `position_name`) VALUES
(17, '89558701', 'Mabini', 'President'),
(18, '96864427', 'Mabini', 'Internal Vice President'),
(20, '94646496', 'Mabini', 'External Vice President'),
(21, '81725627', 'Mabini', 'Corresponding Secretary'),
(22, '79822422', 'Mabini', 'Recording Secretary'),
(23, '93248863', 'Mabini', 'General Treasurer'),
(24, '95231020', 'Mabini', 'General PIO'),
(25, '12140498', 'Mabini', 'General Business Manager'),
(26, '85939218', 'Mabini', 'Representative'),
(43, '08424411', 'Mabini', 'Auditor'),
(53, '90857278', 'Tagum', 'President'),
(54, '46796423', 'Tagum', 'Vice President for Internal Affairs'),
(55, '04438835', 'Tagum', 'Vice President for External Affairs'),
(56, '54677938', 'Tagum', 'General Secretary'),
(57, '26367541', 'Tagum', 'General Treasurer'),
(58, '58979000', 'Tagum', 'General Auditor'),
(59, '95974184', 'Tagum', 'Public Information Officer');

-- --------------------------------------------------------

--
-- Table structure for table `tbelectiondate`
--

CREATE TABLE `tbelectiondate` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbelectiondate`
--

INSERT INTO `tbelectiondate` (`id`, `start_date`, `end_date`, `start_time`, `end_time`) VALUES
(2, '09 June 2023', '21 June 2023', '04:12 AM', '06:12 AM');

-- --------------------------------------------------------

--
-- Table structure for table `tbloginlogs`
--

CREATE TABLE `tbloginlogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `public_Ip` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbnominees`
--

CREATE TABLE `tbnominees` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `program` varchar(150) NOT NULL,
  `year` varchar(50) NOT NULL,
  `party` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `image` varchar(150) NOT NULL,
  `indicator` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tborgtype`
--

CREATE TABLE `tborgtype` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tborgtype`
--

INSERT INTO `tborgtype` (`id`, `type`) VALUES
(1, 'Student Council'),
(2, 'Local Council');

-- --------------------------------------------------------

--
-- Table structure for table `tbparty`
--

CREATE TABLE `tbparty` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `party_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbparty`
--

INSERT INTO `tbparty` (`id`, `code`, `campus`, `party_name`) VALUES
(5, '16016429', 'Mabini', 'Agila lng to'),
(7, '33679282', 'Mabini', 'Independent'),
(8, '48593357', 'Obrero', 'Paragon'),
(9, '28831449', 'Obrero', 'Agila'),
(10, '70073890', 'Obrero', 'Yano'),
(11, '97845216', 'Mintal', 'Agila'),
(12, '62352994', 'Mintal', 'Independent'),
(17, '46333425', 'Tagum', 'MAKABAGONG AGILA'),
(18, '87304478', 'Tagum', 'TALA'),
(19, '18655876', 'Tagum', 'YANONG-AGILA lng to'),
(20, '76179104', 'Mabini', 'IT Riders'),
(21, '64952223', 'Mabini', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `tbposition`
--

CREATE TABLE `tbposition` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `position_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbposition`
--

INSERT INTO `tbposition` (`id`, `code`, `campus`, `position_name`) VALUES
(1, '84470101', 'Obrero', 'Governor'),
(2, '01300145', 'Obrero', 'Vice Governor'),
(3, '98837322', 'Obrero', 'Local Secretary'),
(4, '64102138', 'Obrero', 'Local Treasurer'),
(5, '38837488', 'Obrero', 'Local Auditor'),
(10, '99918833', 'Obrero', 'Representive'),
(19, '65918341', 'Mabini', 'Internal Vice Governor'),
(20, '27338971', 'Mabini', 'External Vice Governor'),
(21, '38672719', 'Mabini', 'Recording Secretary'),
(22, '91442257', 'Mabini', 'Corresponding Secretary'),
(23, '52263844', 'Mabini', 'Treasurer'),
(24, '70029223', 'Mabini', 'Auditor'),
(25, '14725748', 'Mabini', 'Information Officer'),
(26, '12556286', 'Mabini', 'Business Manager'),
(27, '12429732', 'Mintal', 'Governor'),
(28, '10658422', 'Mintal', 'Vice Governnor'),
(29, '80814851', 'Mintal', 'Local Secretary'),
(30, '22319036', 'Mintal', 'Local Treasurer'),
(31, '04555483', 'Mintal', 'Local Auditor'),
(32, '63761976', 'Mintal', 'Legislators'),
(64, '60191638', 'Tagum', 'Governor'),
(65, '48877677', 'Tagum', 'Vice Governor'),
(66, '76235334', 'Tagum', 'Secretary'),
(67, '14013479', 'Tagum', 'Auditor'),
(68, '78070521', 'Tagum', 'Treasurer'),
(71, '88996939', 'Tagum', 'Senator'),
(72, '83862302', 'Tagum', 'Sampung katao'),
(73, '31758816', 'Mabini', 'Governor');

-- --------------------------------------------------------

--
-- Table structure for table `tb_access_code`
--

CREATE TABLE `tb_access_code` (
  `id` int(10) UNSIGNED NOT NULL,
  `access_code` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_access_code`
--

INSERT INTO `tb_access_code` (`id`, `access_code`, `type`) VALUES
(1, 'Stud@123', 'student'),
(2, 'Admin@123', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin_action_logs`
--

CREATE TABLE `tb_admin_action_logs` (
  `admin_log_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) NOT NULL,
  `action` varchar(150) NOT NULL,
  `log_action_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin_action_logs`
--

INSERT INTO `tb_admin_action_logs` (`admin_log_id`, `admin_id`, `action`, `log_action_date`) VALUES
(2, 12, 'Logged in', '2023-06-09 18:51:25'),
(3, 12, 'Logged in', '2023-06-09 18:51:43'),
(4, 12, 'Logged in', '2023-06-09 18:52:16'),
(5, 12, 'Logged in', '2023-06-09 18:53:22'),
(6, 12, 'Logged in', '2023-06-09 18:53:32'),
(7, 12, 'Logged in', '2023-06-09 18:53:39'),
(8, 12, 'Logged in', '2023-06-09 18:53:47'),
(9, 12, 'Logged in', '2023-06-09 18:53:56'),
(10, 12, 'Logged in', '2023-06-09 18:54:29'),
(11, 12, 'Logged in', '2023-06-09 18:54:43'),
(12, 12, 'Logged in', '2023-06-09 18:57:25'),
(17, 15, 'Logged in', '2023-06-09 19:38:14'),
(20, 12, 'Logged in', '2023-06-09 19:50:23'),
(21, 15, 'Logged in', '2023-06-09 19:54:34'),
(24, 12, 'Logged in', '2023-06-10 06:18:52'),
(25, 12, 'Logged in', '2023-06-10 06:30:01'),
(26, 12, 'Logged in', '2023-06-10 10:48:14'),
(28, 12, 'Logged in', '2023-06-10 11:34:24'),
(29, 12, 'Logged in', '2023-06-10 11:54:18'),
(30, 12, 'Logged in', '2023-06-10 11:57:08'),
(33, 12, 'Logged in', '2023-06-10 12:47:40'),
(34, 23, 'Logged in', '2023-06-10 12:52:20'),
(35, 23, 'Logged in', '2023-06-10 12:53:02'),
(36, 12, 'Logged in', '2023-06-10 13:08:14'),
(37, 12, 'Logged in', '2023-06-10 13:08:22'),
(38, 12, 'Logged in', '2023-06-10 13:25:17'),
(39, 23, 'Logged in', '2023-06-10 13:29:01'),
(40, 23, 'Logged in', '2023-06-10 13:50:15'),
(41, 12, 'Logged in', '2023-06-10 13:51:58'),
(42, 23, 'Logged in', '2023-06-10 13:52:38'),
(43, 12, 'Logged in', '2023-06-10 13:55:24'),
(44, 23, 'Logged in', '2023-06-10 13:56:43'),
(45, 15, 'Logged in', '2023-06-10 14:00:24'),
(46, 12, 'Logged in', '2023-06-10 14:02:06'),
(47, 25, 'Logged in', '2023-06-10 14:02:43'),
(48, 12, 'Logged in', '2023-06-10 14:05:15'),
(49, 26, 'Logged in', '2023-06-10 14:05:54'),
(50, 16, 'Logged in', '2023-07-04 13:54:50'),
(51, 16, 'Logged in', '2023-07-04 13:55:02'),
(52, 16, 'Logged in', '2023-07-04 13:56:20'),
(53, 24, 'Logged in', '2023-07-04 13:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_voter`
--

CREATE TABLE `tb_voter` (
  `id` int(10) NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `program_id` int(25) NOT NULL,
  `college_id` int(25) NOT NULL,
  `year` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_voter`
--

INSERT INTO `tb_voter` (`id`, `stud_id`, `fname`, `lname`, `program_id`, `college_id`, `year`, `password`, `email`, `campus`) VALUES
(113, '2021-00027', 'John', 'Estrada', 146, 145, '2', '11-10-2002', 'lorjohn143@gmail.com', 'Mabini'),
(115, '2011-00592', 'Cool', 'Gitt', 146, 145, '2', '02-18-2003', 'lorjohn143@gmail.com', 'Mabini'),
(131, '2021-00012', 'Mish', 'Cempron', 123, 145, '3', '11-11-2021', 'mishcempron@gmail.com', 'Mabini'),
(133, '2021-121213', 'Lorjohn', 'Rana', 123, 144, '3', '11-10-2002', 'lorjhon143@gmail.com', 'Tagum');

-- --------------------------------------------------------

--
-- Table structure for table `tb_votes`
--

CREATE TABLE `tb_votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `studID` varchar(50) NOT NULL,
  `nameCand` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `voter_college` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `program` varchar(150) NOT NULL,
  `position` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `indicator` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_votes`
--

INSERT INTO `tb_votes` (`id`, `studID`, `nameCand`, `campus`, `voter_college`, `college`, `program`, `position`, `image`, `indicator`) VALUES
(29, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'President', 'Abstain.jpg', 'Student Council'),
(30, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Internal Vice President', 'Abstain.jpg', 'Student Council'),
(31, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'External Vice President', 'Abstain.jpg', 'Student Council'),
(32, '2021-00027', 'wel welloi', 'Mabini', 'College of Agriculture and Related Sciences', 'College of Agriculture and Related Sciences', 'Bachelor of Science in Information Technology', 'Corresponding Secretary', '_174111497851f29ef38bc6c63575700a6e9839b8a2.jpg', 'Student Council'),
(33, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Recording Secretary', 'Abstain.jpg', 'Student Council'),
(34, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'General Treasurer', 'Abstain.jpg', 'Student Council'),
(35, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'General PIO', 'Abstain.jpg', 'Student Council'),
(36, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'General Business Manager', 'Abstain.jpg', 'Student Council'),
(37, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Representative', 'Abstain.jpg', 'Student Council'),
(38, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Auditor', 'Abstain.jpg', 'Student Council'),
(39, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Internal Vice Governor', 'Abstain.jpg', 'Local Council'),
(40, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'External Vice Governor', 'Abstain.jpg', 'Local Council'),
(41, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Recording Secretary', 'Abstain.jpg', 'Local Council'),
(42, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Corresponding Secretary', 'Abstain.jpg', 'Local Council'),
(43, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Treasurer', 'Abstain.jpg', 'Local Council'),
(44, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Auditor', 'Abstain.jpg', 'Local Council'),
(45, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Information Officer', 'Abstain.jpg', 'Local Council'),
(46, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Business Manager', 'Abstain.jpg', 'Local Council'),
(47, '2021-00027', 'Abstain', 'Mabini', 'College of Agriculture and Related Sciences', 'Abstain', 'Abstain', 'Governor', 'Abstain.jpg', 'Local Council');

-- --------------------------------------------------------

--
-- Table structure for table `voter_pub_ip`
--

CREATE TABLE `voter_pub_ip` (
  `id` int(10) UNSIGNED NOT NULL,
  `public_ip_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voter_pub_ip`
--

INSERT INTO `voter_pub_ip` (`id`, `public_ip_address`) VALUES
(346, '103.171.89.112'),
(190, '103.171.89.46'),
(58, '103.171.89.86'),
(354, '110.54.169.250'),
(282, '110.54.169.37'),
(66, '110.54.201.58'),
(253, '119.111.139.20'),
(363, '119.111.150.159'),
(229, '119.111.155.131'),
(89, '119.92.95.70'),
(331, '119.93.52.246'),
(109, '122.52.188.7'),
(318, '122.54.91.94'),
(234, '124.105.88.164'),
(196, '124.107.144.88'),
(280, '131.226.64.141'),
(393, '154.18.152.6'),
(168, '158.62.80.84'),
(23, '175.176.88.200'),
(49, '175.176.90.54'),
(32, '175.176.92.252'),
(103, '175.176.93.128'),
(350, '175.176.95.1'),
(87, '180.195.226.156'),
(352, '2001:4455:1fc:1c00:2cc1:b6f1:f0e:ebe9'),
(61, '2001:4455:1ff:f000:39a3:1897:185f:6dd5'),
(286, '2001:4455:210:7900:f0cd:d057:2da0:b3a6'),
(183, '2001:4455:559:eb00:78e5:4309:94fe:c8ca'),
(121, '2001:4455:5a6:a400:ac1a:495a:b7ec:bab5'),
(42, '2001:fd8:643:afe8:bc9c:1841:ac25:3692'),
(328, '2405:8d40:cf1:836c:16fb:2756:a878:6357'),
(26, '49.149.178.118'),
(140, '49.149.36.49'),
(205, '49.149.69.196'),
(106, '58.69.112.219'),
(47, '58.69.112.243');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_program`
-- (See below for the actual view)
--
CREATE TABLE `vw_program` (
`id` int(25)
,`college_program_name` varchar(150)
,`campus` varchar(50)
,`college_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_voter`
-- (See below for the actual view)
--
CREATE TABLE `vw_voter` (
`stud_id` varchar(50)
,`fname` varchar(50)
,`lname` varchar(50)
,`year` varchar(50)
,`password` varchar(50)
,`email` varchar(50)
,`campus` varchar(50)
,`college_name` varchar(100)
,`college_program_name` varchar(150)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_program`
--
DROP TABLE IF EXISTS `vw_program`;

CREATE ALGORITHM=UNDEFINED DEFINER=`id20889210_db_conn`@`%` SQL SECURITY DEFINER VIEW `vw_program`  AS SELECT `college_program`.`program_id` AS `id`, `college_program`.`college_program_name` AS `college_program_name`, `college_program`.`campus` AS `campus`, `college_tbl`.`college_name` AS `college_name` FROM (`college_program` left join `college_tbl` on(`college_program`.`college_id` = `college_tbl`.`college_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_voter`
--
DROP TABLE IF EXISTS `vw_voter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`id20889210_db_conn`@`%` SQL SECURITY DEFINER VIEW `vw_voter`  AS SELECT `tb_voter`.`stud_id` AS `stud_id`, `tb_voter`.`fname` AS `fname`, `tb_voter`.`lname` AS `lname`, `tb_voter`.`year` AS `year`, `tb_voter`.`password` AS `password`, `tb_voter`.`email` AS `email`, `tb_voter`.`campus` AS `campus`, `college_tbl`.`college_name` AS `college_name`, `college_program`.`college_program_name` AS `college_program_name` FROM ((`tb_voter` left join `college_tbl` on(`college_tbl`.`college_id` = `tb_voter`.`college_id`)) left join `college_program` on(`college_program`.`program_id` = `tb_voter`.`program_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `college_program`
--
ALTER TABLE `college_program`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `college_id_fk` (`college_id`),
  ADD KEY `campus_fk` (`campus`);

--
-- Indexes for table `college_tbl`
--
ALTER TABLE `college_tbl`
  ADD PRIMARY KEY (`college_id`),
  ADD KEY `campus` (`campus`);

--
-- Indexes for table `tbadmin`
--
ALTER TABLE `tbadmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbcouncil`
--
ALTER TABLE `tbcouncil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbelectiondate`
--
ALTER TABLE `tbelectiondate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbloginlogs`
--
ALTER TABLE `tbloginlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbnominees`
--
ALTER TABLE `tbnominees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tborgtype`
--
ALTER TABLE `tborgtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbparty`
--
ALTER TABLE `tbparty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbposition`
--
ALTER TABLE `tbposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_access_code`
--
ALTER TABLE `tb_access_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin_action_logs`
--
ALTER TABLE `tb_admin_action_logs`
  ADD PRIMARY KEY (`admin_log_id`),
  ADD KEY `admin_log_FK` (`admin_id`);

--
-- Indexes for table `tb_voter`
--
ALTER TABLE `tb_voter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `stud_id_2` (`stud_id`),
  ADD KEY `stud_id` (`stud_id`),
  ADD KEY `program_id_voter_FK` (`program_id`),
  ADD KEY `college_id_voter_FK` (`college_id`);

--
-- Indexes for table `tb_votes`
--
ALTER TABLE `tb_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `voter_pub_ip`
--
ALTER TABLE `voter_pub_ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `public_ip_address` (`public_ip_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbadmin`
--
ALTER TABLE `tbadmin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbcouncil`
--
ALTER TABLE `tbcouncil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbelectiondate`
--
ALTER TABLE `tbelectiondate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbloginlogs`
--
ALTER TABLE `tbloginlogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `tbnominees`
--
ALTER TABLE `tbnominees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tborgtype`
--
ALTER TABLE `tborgtype`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbparty`
--
ALTER TABLE `tbparty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbposition`
--
ALTER TABLE `tbposition`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tb_access_code`
--
ALTER TABLE `tb_access_code`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_admin_action_logs`
--
ALTER TABLE `tb_admin_action_logs`
  MODIFY `admin_log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tb_voter`
--
ALTER TABLE `tb_voter`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tb_votes`
--
ALTER TABLE `tb_votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `voter_pub_ip`
--
ALTER TABLE `voter_pub_ip`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `college_program`
--
ALTER TABLE `college_program`
  ADD CONSTRAINT `campus_fk` FOREIGN KEY (`campus`) REFERENCES `college_tbl` (`campus`),
  ADD CONSTRAINT `college_id_fk` FOREIGN KEY (`college_id`) REFERENCES `college_tbl` (`college_id`);

--
-- Constraints for table `tb_admin_action_logs`
--
ALTER TABLE `tb_admin_action_logs`
  ADD CONSTRAINT `admin_log_FK` FOREIGN KEY (`admin_id`) REFERENCES `tbadmin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_voter`
--
ALTER TABLE `tb_voter`
  ADD CONSTRAINT `college_id_voter_FK` FOREIGN KEY (`college_id`) REFERENCES `college_tbl` (`college_id`),
  ADD CONSTRAINT `program_id_voter_FK` FOREIGN KEY (`program_id`) REFERENCES `college_program` (`program_id`);

--
-- Constraints for table `tb_votes`
--
ALTER TABLE `tb_votes`
  ADD CONSTRAINT `tb_votes_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `tb_voter` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
