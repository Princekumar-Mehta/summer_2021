-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2021 at 01:19 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_name` varchar(240) NOT NULL,
  `admin_password` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_name`, `admin_password`) VALUES
('Admin_Prince', '2001Admin');

-- --------------------------------------------------------

--
-- Table structure for table `annoucements`
--

CREATE TABLE `annoucements` (
  `details` varchar(240) NOT NULL,
  `date_time` varchar(240) NOT NULL,
  `leader` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annoucements`
--

INSERT INTO `annoucements` (`details`, `date_time`, `leader`, `group_id`) VALUES
('Mention you completed tasks', '09-07-2021 03:21:47', 14, 13);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `sender` int(11) NOT NULL,
  `message` varchar(240) NOT NULL,
  `receiver` int(11) NOT NULL,
  `date_time` varchar(240) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sender`, `message`, `receiver`, `date_time`, `status`) VALUES
(17, 'Could you please mail the work of GUI 1 ', 15, '09-07-2021 03:45:35', 1),
(14, 'Ok, I\'ll do it by tomorroe', 15, '09-07-2021 04:27:53', 1),
(15, 'Complete your task 3 in this week', 16, '09-07-2021 04:34:14', 0),
(16, 'Ok', 15, '09-07-2021 04:35:39', 1),
(15, 'Ok, I have mailed you.', 17, '09-07-2021 04:44:26', 0),
(15, 'OK', 15, '12-07-2021 13:34:47', 1),
(14, 'hi', 15, '12-07-2021 13:35:52', 1),
(15, 'Send me the updated design', 16, '19-07-2021 18:23:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(240) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` varchar(140) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `user_id`, `date_time`, `group_id`) VALUES
(25, 'GUI task 1', 15, '09-07-2021 03:24:18', 13),
(26, 'PHP function(view)', 16, '09-07-2021 03:25:58', 13),
(28, 'Check Username Validation', 15, '12-07-2021 13:34:19', 13),
(29, 'hi', 14, '12-07-2021 13:37:18', 13);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Username` varchar(120) NOT NULL,
  `Password` varchar(120) NOT NULL,
  `Security_Question` varchar(120) NOT NULL,
  `Answer` varchar(120) NOT NULL,
  `group_id` int(11) NOT NULL,
  `Role` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Username`, `Password`, `Security_Question`, `Answer`, `group_id`, `Role`) VALUES
(14, 'Raj', 'R123', 'Surename', 'BB', 13, 'Team_leader'),
(15, 'Sachin', '333', 'Friend', 'me', 13, 'Team_member'),
(16, 'Geeta', 'GGG', 'Dog Name', 'tommy', 13, 'Team_leader'),
(17, 'Jay', '123J', 'Home No', '1', 13, 'Team_member'),
(18, 'Rita', 'R111', 'Surname', 'KK', 13, 'Team_member'),
(19, 'Smriti', 'S001', 'Fav Teacher', 'society', 7, 'Team_leader'),
(20, 'Amit', 'A007', 'Surname', 'Mehta', 7, 'Team_leader'),
(21, 'Rohan', 'KR1', 'Hometown', 'Rajkot', 7, 'Team_member'),
(22, 'Sushma', '123', 'Fav word', 'Hope', 7, 'Team_leader'),
(23, 'Mohan', 'M22', 'Nickname', 'monu', 7, 'Team_member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annoucements`
--
ALTER TABLE `annoucements`
  ADD KEY `leader_c` (`leader`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD KEY `receiver_c` (`receiver`),
  ADD KEY `sender_c` (`sender`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id_c` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annoucements`
--
ALTER TABLE `annoucements`
  ADD CONSTRAINT `leader_c` FOREIGN KEY (`Leader`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `receiver_c` FOREIGN KEY (`receiver`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender_c` FOREIGN KEY (`sender`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `user_id_c` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
