-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 03:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `password_reset_id` int(11) NOT NULL,
  `password_reset_user_id` varchar(25) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `password_reset_status` int(11) NOT NULL DEFAULT 1,
  `password_reset_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking`
--

CREATE TABLE `tb_booking` (
  `b_id` int(10) NOT NULL,
  `b_ic` varchar(15) NOT NULL,
  `b_req` varchar(10) NOT NULL,
  `b_pdate` date NOT NULL,
  `b_rdate` date NOT NULL,
  `b_total` float NOT NULL,
  `b_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`b_id`, `b_ic`, `b_req`, `b_pdate`, `b_rdate`, `b_total`, `b_status`) VALUES
(3028, '041212110272', 'JVV3333', '2023-10-12', '2023-10-13', 250, 2),
(30272, '020101110272', 'JVV3333', '2023-10-10', '2023-10-11', 200, 2),
(30293, '22', 'JDB0222', '2023-11-16', '2023-11-30', 2800, 2),
(30294, '22', 'JDB0222', '2023-12-22', '2023-12-20', 400, 3),
(30295, '22', 'JDB0222', '2023-12-22', '2023-12-30', 1600, 3),
(30296, '22', 'JVV3333', '2023-12-22', '2023-12-30', 2000, 3),
(30302, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 3),
(30303, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 3),
(30304, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30305, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30306, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30307, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30308, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30309, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30310, '0139204698', 'JVV3333', '2024-01-10', '2024-01-17', 1750, 1),
(30311, '0139204698', 'JVV3333', '2024-01-11', '2024-01-30', 4750, 1),
(30312, '001818180272', 'MLK2333', '2024-01-12', '2024-01-19', 840, 1),
(30314, '0311110298', 'JDB0222', '2024-01-26', '2024-01-30', 800, 1),
(30315, '031111110272', 'MLK2333', '2024-01-12', '2024-01-26', 1680, 1),
(30316, '031111110272', 'JDB0222', '2024-01-19', '2024-01-26', 1400, 1),
(30317, '031111110272', 'MLK2333', '2024-01-18', '2024-01-26', 960, 1),
(30318, '22', 'JDB0222', '2024-01-16', '2024-01-17', 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `s_id` int(2) NOT NULL,
  `s_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`s_id`, `s_desc`) VALUES
(1, 'Received'),
(2, 'Approved'),
(3, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `tb_type`
--

CREATE TABLE `tb_type` (
  `t_id` int(2) NOT NULL,
  `t_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_type`
--

INSERT INTO `tb_type` (`t_id`, `t_desc`) VALUES
(1, 'Staff'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_ic` varchar(15) NOT NULL,
  `u_pwd` varchar(30) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_phone` varchar(20) NOT NULL,
  `u_email` varchar(50) DEFAULT NULL,
  `u_add` varchar(200) NOT NULL,
  `u_lic` varchar(20) NOT NULL,
  `u_type` int(2) NOT NULL,
  `u_cpwd` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_ic`, `u_pwd`, `u_name`, `u_phone`, `u_email`, `u_add`, `u_lic`, `u_type`, `u_cpwd`) VALUES
('', '', '', '', '', '', '', 2, NULL),
('001111120373', '$2y$10$rBNPwzF8Nu12gUjPREnJROd', 'Nurul Erina', '4324325', 'nrulerina11@gmail.com', 'utm skudai', '4215153', 2, '$2y$10$txSX5cTuoTg8cxWDQ86wwe4'),
('001818180272', '030272', 'Jennie Kim', '0139204698', 'Jennie@gmail.com', 'utmskudai@gmail.com', '1234567', 2, NULL),
('001919190272', '', 'Jennie Kim', '', '', '', '', 2, NULL),
('0139204698', '121212', 'Nurul Erina', '0139204698', '22@gmail.com', '-', '1212', 2, NULL),
('01465656556', '12343221', 'betty', '0148225667', '11@gmail.com', '-', '125678', 2, NULL),
('014656789', 'bett1234', 'Arini', '012879045', '03@gmail.com', '-', '7878787', 2, NULL),
('0146567899', '1245677', 'Jihoon', '018986745', '103@gmail.com', '-', '9090909', 2, NULL),
('020101110272', '1234567', 'Syaza WAni', '0133994674', 'syaza@gmail.com', 'Kuantan, Pahang', '1234567', 2, NULL),
('0311110298', 'jennie1234', 'jenniekim', '0139804698', 'jenniekim@gmail.com', 'utm skudai', '123234253', 2, NULL),
('031111110272', '1234567', 'Nurul Erina binti Zainuddin', '0129223674', 'nrulerina@gmail.com', 'Kemaman, Terengganu', '1234567', 1, NULL),
('031111230272', '$2y$10$FO/AUXP35FNritGigrcRUuC', 'jisoo', '0139204698', 'nrulerina@gmail.com', 'utm skudai', '2142432545', 2, '@admin1234'),
('031212121', '123456', 'Nurul Erina', '0139204698', '22@gmail.com', '-', '11', 2, NULL),
('031414140272', '$2y$10$AQ85PyRcpcHMEPdEc3miYec', 'jisookim', '0132998330', 'jisoo@gmail.com', 'utm skudai', '0156793', 2, NULL),
('039999990272', 'jake', 'kim sunoo', '12', 'kimsunoo@gmail.com', 'utm skudai', '1313', 2, 'jake'),
('041212110272', '1234567', 'Aiman Tinoo', '0148225052', 'aiman@gmail.com', 'Parit, Perak', '1234567', 2, NULL),
('22', '22', '22', '22', '22@gmail.com', '22', '22', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_vehicle`
--

CREATE TABLE `tb_vehicle` (
  `v_req` varchar(10) NOT NULL,
  `v_model` varchar(50) NOT NULL,
  `v_type` varchar(20) NOT NULL,
  `v_color` varchar(20) DEFAULT NULL,
  `v_price` float NOT NULL,
  `v_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_vehicle`
--

INSERT INTO `tb_vehicle` (`v_req`, `v_model`, `v_type`, `v_color`, `v_price`, `v_status`) VALUES
('09090', 'VOLVO', 'SUVV', 'AKUA', 120, 'inactive'),
('090902', '', 'SANA', 'PINK', 100, 'inactive'),
('143', '', '421', '421', 421, 'active'),
('JDB0222', 'Toyata Vios', 'SUV', 'Red', 200, 'active'),
('JVV3333', 'Proton X90', 'SUV', 'Blue', 250, 'active'),
('MLK2333', 'Honda Civic', 'Sedan', 'BLack', 120, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `password_reset_user_id` (`password_reset_user_id`);

--
-- Indexes for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `b_ic` (`b_ic`),
  ADD KEY `b_req` (`b_req`),
  ADD KEY `b_status` (`b_status`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_ic`),
  ADD KEY `u_type` (`u_type`);

--
-- Indexes for table `tb_vehicle`
--
ALTER TABLE `tb_vehicle`
  ADD PRIMARY KEY (`v_req`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30319;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`password_reset_user_id`) REFERENCES `tb_user` (`u_ic`);

--
-- Constraints for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD CONSTRAINT `tb_booking_ibfk_1` FOREIGN KEY (`b_ic`) REFERENCES `tb_user` (`u_ic`),
  ADD CONSTRAINT `tb_booking_ibfk_2` FOREIGN KEY (`b_status`) REFERENCES `tb_status` (`s_id`),
  ADD CONSTRAINT `tb_booking_ibfk_3` FOREIGN KEY (`b_req`) REFERENCES `tb_vehicle` (`v_req`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_type` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
