-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 03:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `tasks` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `memorable_word` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`, `role`, `tasks`, `email`, `memorable_word`) VALUES
(1, 'admin', 'admin', 1, '', '', ''),
(2, 'Supervisor', '1234', 3, '', '', ''),
(3, 'Muzzamil', '1234', 2, '', 'muzzamilahmed7865@gmail.com', ''),
(18, 'hassan', '1234', 2, '', 'muzzamil.ahmed7865@gmail.com', ''),
(19, 'adil', '1234', 2, '', 'muzzamilahmed.7865@gmail.com', ''),
(20, 'farva', '1234', 2, '', 'muzzamilahmed7865@gmail.com', ''),
(21, 'Fahim', 'Fahim1234!', 2, '', 'muzzamilahmed7865@gmail.com', ''),
(22, 'John', 'John1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(23, 'Ibby', 'Ibby1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(24, 'ismail', 'Ismail1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(25, 'adam', 'Adam1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(26, 'Sleepy', 'Sleepy1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(27, 'bostan', 'Bostan1234!', 2, '', 'johnnygreenhold@gmail.com', ''),
(28, 'josh', 'Josh1234!', 2, '', 'joshgreener@gmail.com', 'josh');

-- --------------------------------------------------------

--
-- Table structure for table `progress_notes`
--

CREATE TABLE `progress_notes` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_notes`
--

INSERT INTO `progress_notes` (`id`, `task_id`, `note`, `timestamp`) VALUES
(1, 44, 'I am completing this right now ', '2024-04-13 04:16:36'),
(4, 57, 'UNITEDDDDDD!!!', '2024-04-14 00:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `Progress` varchar(20) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'In Progress',
  `time_issued` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `description`, `Progress`, `status`, `time_issued`, `due_date`) VALUES
(44, 3, 'Lets go for a walk', NULL, 'In Progress', '2024-04-13 03:57:19', NULL),
(46, 3, 'do work', NULL, 'In Progress', '2024-04-13 03:59:00', NULL),
(47, 3, 'anything', NULL, 'In Progress', '2024-04-13 04:00:58', NULL),
(48, 21, 'Can you Please do the Second part of the assignment', NULL, 'In Progress', '2024-04-13 23:11:53', NULL),
(49, 19, 'can you do the third part?', NULL, 'In Progress', '2024-04-13 23:12:20', NULL),
(50, 22, 'Finish with the accounting and the my-learning ', NULL, 'In Progress', '2024-04-13 23:28:04', NULL),
(51, 22, '2- make a text document with rolling logs ', NULL, 'In Progress', '2024-04-13 23:31:39', NULL),
(57, 25, 'Should get a better team to support lad', NULL, 'Complete', '2024-04-14 00:12:37', NULL),
(58, 3, 'Have all the reports ready', NULL, 'In Progress', '2024-04-18 23:20:55', '2024-04-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress_notes`
--
ALTER TABLE `progress_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `progress_notes`
--
ALTER TABLE `progress_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `progress_notes`
--
ALTER TABLE `progress_notes`
  ADD CONSTRAINT `progress_notes_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
