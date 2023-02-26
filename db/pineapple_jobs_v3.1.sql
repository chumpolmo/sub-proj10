-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2023 at 04:07 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pineapple_jobs`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs_resume`
--

CREATE TABLE `jobs_resume` (
  `Job_ID` int NOT NULL,
  `Res_ID` int NOT NULL,
  `JobRes_Status` int NOT NULL,
  `JobRes_Note` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs_resume`
--

INSERT INTO `jobs_resume` (`Job_ID`, `Res_ID`, `JobRes_Status`, `JobRes_Note`) VALUES
(1, 2, 10, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs_resume`
--
ALTER TABLE `jobs_resume`
  ADD UNIQUE KEY `PK_JR_ID` (`Job_ID`,`Res_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
