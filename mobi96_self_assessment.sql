-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2017 at 12:05 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `property_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `free_trial`
--

CREATE TABLE `free_trial` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `free_trial`
--

INSERT INTO `free_trial` (`id`, `name`, `email`, `mobile`, `message`, `datetime`) VALUES
(10, 'rwe', 'werwerwer@gmail.com', '9859988889', 'rtyrty', '2017-09-15 06:19:27'),
(11, 'rwe', 'werwerwer@gmail.com', '9859988889', 'rtyrty', '2017-09-15 06:19:33'),
(12, 'rtyrtyr', 'werwerwer@gmail.com', '9859988889', 'rtyrtyrty', '2017-09-15 06:20:24'),
(13, 'rtyrtyr', 'werwerwer@gmail.com', '9859988889', 'rtyrtyrty', '2017-09-15 06:20:35'),
(14, 'rwe', 'werwerwer@gmail.com', '9859988889', 'werwer', '2017-09-15 06:21:06'),
(15, 'rtyrty', 'rtyrty@gmail.com', '9859988889', 'sdfsdfsdf', '2017-09-15 06:21:55'),
(16, 'rtyrty', 'werwerwer@gmail.com', '9859988889', 'werwer', '2017-09-15 06:22:29'),
(17, 'dfgdfdfg', 'dfgdfgdfgdfgdfgdfg@gmail.com', '9856936365', 'dfgdfgdfgdfgdfg', '2017-09-15 06:24:32'),
(18, 'erert', 'ertertert@gmail.com', '9858888888', 'sdffsdfsdfsdf', '2017-09-15 06:25:54'),
(19, 'ertert', 'ertertert@gmail.com', '9856999999', '9asdfsdf', '2017-09-15 06:27:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `free_trial`
--
ALTER TABLE `free_trial`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `free_trial`
--
ALTER TABLE `free_trial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;