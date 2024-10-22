-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 06:30 PM
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
-- Database: `fcom`
--

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meeting_id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `meeting_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `ScheduleID` int(11) NOT NULL,
  `CellNo` int(11) DEFAULT NULL,
  `Day` varchar(50) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Week` int(11) DEFAULT NULL,
  `Availability` varchar(50) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`ScheduleID`, `CellNo`, `Day`, `Time`, `Week`, `Availability`, `User_id`) VALUES
(1, 17, 'Tuesday', 1, 3, 'free', 1),
(2, 5, 'Monday', 12, 1, 'free', 1),
(3, 15, 'Tuesday', 11, 3, 'classes', 1),
(4, 27, 'Wednesday', 12, 3, 'notfree', 1),
(5, 2, 'Monday', 9, 1, 'free', 2),
(6, 55, 'Friday', 6, 1, 'notfree', 2),
(7, 55, 'Friday', 6, 1, 'classes', 2),
(8, 55, 'Friday', 6, 1, 'free', 2),
(9, 17, 'Tuesday', 1, 1, 'classes', 2),
(10, 5, 'Monday', 12, 1, 'free', 2),
(11, 7, 'Monday', 2, 1, 'classes', 2),
(12, 40, 'Thursday', 2, 1, 'notfree', 2),
(13, 4, 'Monday', 11, 1, 'free', 2),
(14, 45, 'Friday', 8, 1, 'meeting', 2),
(15, 45, 'Friday', 8, 1, 'notfree', 2);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`) VALUES
(1, 'Syaz', 'syaz@gmail.com', 'syaz123', 'lecturer'),
(2, 'Nizam', 'nizam@gmail.com', 'nizam123', 'dean'),
(3, 'MUHAMMAD SYAZNIZAM BIN JAMAL', 'muhdsyaz04@gmail.com', 'muhdsyaz04', 'dean'),
(4, 'MUHAMMAD AKMAL BIN MARZUKI', 'muhdakmal@gmail.com', 'muhdakmal', 'lecturer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `User_id` (`User_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `userinfo` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
