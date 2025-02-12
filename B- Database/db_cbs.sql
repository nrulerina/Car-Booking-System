-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 09:12 AM
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

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`password_reset_id`, `password_reset_user_id`, `password_reset_token`, `password_reset_status`, `password_reset_created_at`) VALUES
(1, '031111110272', 'b6b309c22567c30da699199782c2be05', 1, '2024-01-24 08:27:19'),
(2, '031112110272', '062b7d170b0f73e3227d43fd8695b406', 1, '2024-01-25 05:26:00'),
(3, '031112110272', '7a29f4740e40c209d6afd294f3aada92', 1, '2024-01-25 05:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_name`) VALUES
(1, 'Johor'),
(2, 'Kedah'),
(3, 'Kelantan'),
(4, 'Melaka'),
(5, 'Negeri Sembilan'),
(6, 'Pahang'),
(7, 'Perak'),
(8, 'Perlis'),
(9, 'Pulau Pinang'),
(10, 'Sabah'),
(11, 'Sarawak'),
(12, 'Selangor'),
(13, 'Terengganu'),
(14, 'Wilayah Persekutuan Kuala Lumpur'),
(15, 'Wilayah Persekutuan Labuan'),
(16, 'Wilayah Persekutuan Putrajaya');

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
  `b_status` int(2) NOT NULL,
  `b_cond` varchar(10) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`b_id`, `b_ic`, `b_req`, `b_pdate`, `b_rdate`, `b_total`, `b_status`, `b_cond`) VALUES
(3, '031112110272', 'JVV3333', '2024-01-24', '2024-02-02', 6930, 1, 'deleted'),
(4, '031112110272', 'JVV3333', '2024-01-24', '2024-02-03', 7700, 3, 'active'),
(5, '031112110272', 'SMT2000', '2024-01-29', '2024-02-09', 8800, 3, 'active'),
(6, '031112110272', 'JDB0222', '2024-01-27', '2024-02-06', 7000, 1, 'active'),
(7, '123412341234', 'JDB0222', '2024-01-16', '2024-01-25', 6300, 1, 'active'),
(8, '031112110272', 'JDB0222', '2024-01-24', '2024-01-26', 1400, 1, 'active'),
(9, '031112110272', 'MLK2333', '2024-01-25', '2024-01-27', 1300, 1, 'active'),
(10, '031112110272', 'QWE0900', '2024-01-25', '2024-01-27', 1564, 1, 'active'),
(11, '031112110272', 'QWE0900', '2024-01-25', '2024-02-10', 12512, 1, 'active'),
(12, '031112110272', 'JDB0222', '2024-01-25', '2024-01-27', 1402, 1, 'active');

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
  `u_pwd` varchar(255) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_phone` varchar(20) NOT NULL,
  `u_email` varchar(50) DEFAULT NULL,
  `u_add` varchar(200) NOT NULL,
  `u_lic` varchar(20) NOT NULL,
  `u_type` int(2) NOT NULL,
  `u_state` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_ic`, `u_pwd`, `u_name`, `u_phone`, `u_email`, `u_add`, `u_lic`, `u_type`, `u_state`) VALUES
('031111110272', '$2y$10$ZqO8eT5mNIy/DWDsLIDM2uE.Xvu3qOI6PsEeme2N/HPhkAddG6uvW', 'kimjisoo', '0139204698', 'nurulerina@graduate.utm.my', 'utm', 'erina1234', 1, 1),
('031112110272', '$2y$10$nxsjdMvnBTHsm70r09DGMuK.pmf5PW7eZsBS9he4PNLYvrD.caVoC', 'Lim Xiaohua', '0132998330', 'nrulerina@gmail.com', 'Jalan Iman, 81310 Skudai', '12436524', 2, 1),
('031211110272', '$2y$10$q5GSEuM/5FWN/kiOFCKviuhEUNG8gEXgPLa38xfCgMyq643bQERvy', 'Zhou Yu', '0148225052', 'zhouyu@gmail.com', 'No. 32, Jalan Dato Yusof Shahbudin 19, Taman Sentosa, 41200', '34327812', 2, 12),
('123412341234', '$2y$10$AOfNkC/P/kZc5oF7EoucKO0kimbmRbLZ2l65McZ7j4t/V82aTo26O', 'Customer Bob', '1234', '1234@gmail.com', 'Taman 1234', 'ABC1234', 2, 6),
('567856785678', '$2y$10$.PQWZbjJcO7vL7cAR1y5eO6OBaZIBLG7dLqXhy9XngtPIk6LBRTlS', 'Staff Alex', '5678', '5678@gmail.com', '5678', '5678', 1, 10);

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
('JDB0222', 'Lexus LX', 'SUV', 'Grey', 701, 'active'),
('JVV3333', 'Jaguar F-PACE', 'SUV', 'Blue', 770, 'active'),
('MLK2333', 'Jaguar XE', 'Sedan', 'Black', 650, 'active'),
('QWE0900', 'Audi A8', 'Sedan', 'Red', 782, 'active'),
('SMT2000', 'Volvo V40', 'Hatchback', 'Silver', 800, 'inactive'),
('SWE0997', 'Cadillac CT6', 'sedan', 'BLUE', 889, 'active');

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
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

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
  ADD KEY `u_type` (`u_type`),
  ADD KEY `fk_user_state` (`u_state`);

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
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `fk_user_state` FOREIGN KEY (`u_state`) REFERENCES `states` (`state_id`),
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_type` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
