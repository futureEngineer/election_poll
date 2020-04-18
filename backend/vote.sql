-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2020 at 06:06 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vote`
--

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` bigint(20) NOT NULL,
  `party_id` int(5) NOT NULL,
  `name` varchar(500) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `age` int(20) NOT NULL,
  `mobile` bigint(13) NOT NULL,
  `qualification` varchar(500) DEFAULT NULL,
  `created_date` date NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `political_parties`
--

CREATE TABLE `political_parties` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `short_name` varchar(200) NOT NULL,
  `logo` text NOT NULL,
  `created_date` date NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `political_parties`
--

INSERT INTO `political_parties` (`id`, `name`, `short_name`, `logo`, `created_date`, `status`) VALUES
(1, 'All India Anna Dravida Munnetra Kazhagam', 'ADMK', 'uploads/logo/admk.png', '2020-04-18', 1),
(2, 'Bharatiya Janata Party', 'BJP', 'uploads/logo/bjp.jpeg', '2020-04-18', 1),
(3, 'Dravida Munnetra Kazhagam', 'DMK', 'uploads/logo/dmk.png', '2020-04-18', 1),
(4, 'Desiya Murpokku Dravida Kazhagam', 'DMDK', 'uploads/logo/dmdk.png', '2020-04-18', 1),
(5, 'Marumalarchi Dravida Munnetra Kazhagam', 'MDMK', 'uploads/logo/mdmk.png', '2020-04-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(2) NOT NULL COMMENT '1 - admin, 2 - user',
  `name` varchar(250) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` int(10) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created_date` date NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `mobile`, `gender`, `age`, `password`, `created_date`, `status`) VALUES
(1, 1, 'Admin', 2222222222, 'male', 30, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1),
(2, 2, 'user_one', 3333333333, 'female', 20, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1),
(3, 2, 'user_two', 4444444444, 'female', 18, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1),
(4, 2, 'user_three', 5555555555, 'male', 25, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1),
(5, 2, 'user_four', 6666666666, 'male', 30, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1),
(6, 2, 'user_five', 7777777777, 'female', 24, 'e10adc3949ba59abbe56e057f20f883e', '2020-04-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_votes`
--

CREATE TABLE `user_votes` (
  `id` bigint(20) NOT NULL,
  `participant_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `political_parties`
--
ALTER TABLE `political_parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `political_parties`
--
ALTER TABLE `political_parties`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_votes`
--
ALTER TABLE `user_votes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
