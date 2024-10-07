-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 07:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fypproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `admin_password` varchar(100) DEFAULT NULL,
  `admin_email` varchar(100) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_password`, `admin_email`, `date_time_create`) VALUES
(1, 'admin', '$2y$10$NBOyYApjr04DpAf7fmwNEeJu/KjCGT8rrpSOrD347vHuim1JtxsNi', 'admin@gmail.com', '2024-04-03 21:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `booking_id` int(11) NOT NULL,
  `sport_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL,
  `booking_slot` datetime DEFAULT NULL,
  `booking_duration` int(11) DEFAULT NULL,
  `booking_status` enum('pending','confirm','cancel','reject') NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`booking_id`, `sport_id`, `student_id`, `date_time_create`, `booking_slot`, `booking_duration`, `booking_status`, `category_id`) VALUES
(17, 9, 7, '2024-04-01 02:32:05', '2024-04-01 10:00:00', 120, 'confirm', 7),
(27, 9, 7, '2024-04-02 19:49:55', '2024-04-03 11:00:00', 120, 'cancel', 7),
(31, 9, 7, '2024-04-02 20:01:22', '2024-04-04 09:00:00', 60, 'confirm', 7),
(32, 9, 7, '2024-04-02 20:01:29', '2024-04-05 13:00:00', 60, 'cancel', 7),
(33, 9, 7, '2024-04-02 22:27:18', '2024-04-03 07:00:00', 120, 'pending', NULL),
(34, 9, 7, '2024-04-02 22:58:55', '2024-04-07 07:00:00', 60, 'reject', 7),
(35, 9, 7, '2024-04-02 22:59:36', '2024-04-03 16:00:00', 60, 'confirm', 7),
(36, 13, 7, '2024-04-03 19:11:17', '2024-04-04 07:00:00', 120, 'reject', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_title`, `date_time_create`) VALUES
(7, 'Event', '2024-04-01 18:27:10'),
(10, 'Training', '2024-04-03 19:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_message`
--

INSERT INTO `tbl_message` (`message_id`, `name`, `email`, `message`, `date_time_create`) VALUES
(6, 'paan', 'paan@gmail.com', 'test', '2024-04-02 23:01:17'),
(7, 'Muhamad Ajwad', 'muhamadajwad16@gmail.com', 'testestsetest', '2024-04-02 23:02:27'),
(8, 'Muhamad Ajwad', 'muhamadajwad16@gmail.com', 'eagfdsadsfasdfasdfasdf', '2024-04-03 19:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sports`
--

CREATE TABLE `tbl_sports` (
  `sport_id` int(11) NOT NULL,
  `sport_name` varchar(100) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_sports`
--

INSERT INTO `tbl_sports` (`sport_id`, `sport_name`, `date_time_create`) VALUES
(9, 'Futsal 1', '2024-04-01 18:09:45'),
(13, 'VolleyBall', '2024-04-03 19:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_email` varchar(100) DEFAULT NULL,
  `student_password` varchar(100) DEFAULT NULL,
  `date_time_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `student_name`, `student_email`, `student_password`, `date_time_create`) VALUES
(7, 'Muhamad Farhan', 'paan@gmail.com', '$2y$10$z/oF7Zyu35eTDu8ctZz9Iec3Z8YpBMzmn84JS9ZQBrcPJFmKD0duS', '2024-03-30 14:21:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `tbl_sports`
--
ALTER TABLE `tbl_sports`
  ADD PRIMARY KEY (`sport_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_sports`
--
ALTER TABLE `tbl_sports`
  MODIFY `sport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
