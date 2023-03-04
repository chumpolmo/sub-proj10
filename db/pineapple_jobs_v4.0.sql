-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 05:30 PM
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
-- Table structure for table `farm`
--

CREATE TABLE `farm` (
  `Farm_ID` int NOT NULL,
  `Farm_Name` varchar(100) NOT NULL,
  `Farm_Description` text NOT NULL,
  `Farm_Type` int NOT NULL,
  `Farm_Note` text NOT NULL,
  `Farm_Email` varchar(100) NOT NULL,
  `Farm_Phone` varchar(20) NOT NULL,
  `Farm_Address` text NOT NULL,
  `Farm_Location` varchar(50) NOT NULL,
  `Farm_Added` timestamp NOT NULL,
  `Farm_Updated` timestamp NOT NULL,
  `User_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `farm`
--

INSERT INTO `farm` (`Farm_ID`, `Farm_Name`, `Farm_Description`, `Farm_Type`, `Farm_Note`, `Farm_Email`, `Farm_Phone`, `Farm_Address`, `Farm_Location`, `Farm_Added`, `Farm_Updated`, `User_ID`) VALUES
(1, 'ฟาร์มถิ่นเมืองไทย', 'ฟาร์มถิ่นเมืองไทย ศรีราชา จ.ชลบุรี', 10, '', 'thmth.farm@gmail.com', '0361111111', 'ตำบลเขาคันทรง อำเภอศรีราชา จังหวัดชลบุรี 20110', '13.0688962,101.1644211', '2023-02-15 08:34:33', '2023-02-15 08:34:33', 2),
(2, 'ฟาร์มทดสอบ', 'รายละเอียดฟาร์มทดสอบ', 20, 'หมายเหตุฟาร์มทดสอบ', 'test.farm@mail.com', '0999999999', 'ที่อยู่ฟาร์มทดสอบ', '13.781339662707444,100.56005135178566', '2023-03-01 07:48:34', '2023-03-01 07:57:04', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `Job_ID` int NOT NULL,
  `Job_Title` varchar(100) NOT NULL,
  `Job_Description` text NOT NULL,
  `Job_Salary` double NOT NULL,
  `Job_Phone` varchar(20) NOT NULL,
  `Job_Note` text NOT NULL,
  `Job_Status` int NOT NULL,
  `Job_Added` timestamp NOT NULL,
  `Job_Updated` timestamp NOT NULL,
  `Farm_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`Job_ID`, `Job_Title`, `Job_Description`, `Job_Salary`, `Job_Phone`, `Job_Note`, `Job_Status`, `Job_Added`, `Job_Updated`, `Farm_ID`) VALUES
(1, 'เจ้าหน้าที่ข้อมูล', '- ประสานงาน ติดตาม รวบรวมข้อมูลต่าง ๆ จากหน่วยงานภายในที่เกี่ยวข้อง\r\n- จัดทำไฟล์ข้อมูล เพื่อใช้ในการนำเสนอประชุม หรือ วิเคราะห์ปัญหา\r\n- งานอื่นๆ ที่ได้รับมอบหมาย', 12000, '0356767676', 'ประกันสังคม, โบนัส, ค่าอาหาร และ ค่าเดินทาง', 10, '2023-02-15 09:53:36', '2023-02-15 09:53:36', 1),
(2, 'เจ้าหน้าที่ส่งเสริมการเกษตร', '- วางแผนการปลูกพืชไร่ ให้ได้ผลผลิตตามบริษัทฯ กำหนด\r\n- ควบคุมดูแลพืชไร่ ตามที่บริษัทฯ กำหนด\r\n- ควบคุม และติดตามการปลูกพืชไร่/ให้คำปรึกษาแก่เกษตรกร', 14000, '0356767699', 'ประกันสังคม, โบนัส, ค่าล่วงเวลา และบ้านพักพนักงาน', 10, '2023-02-16 04:55:11', '2023-02-16 04:55:11', 1),
(3, 'เจ้าหน้าที่ควบคุมคุณภาพ (QA)', '- ตรวจสอบการทำงานแปลงสวนยางของบริษัทฯ ให้ปฏิบัติงานตาม WI\r\n- วิเคราะห์สาเหตุของโรคพืชที่เกิดในแปลงต่างๆ', 15000, '0356767688', 'ประกันสังคม, โบนัส, ค่าอาหาร, ประกันอุบัติเหตุ และกองทุนสำรองเลี้ยงชีพ\r\n\r\n*** สามารถเดินทางไปฏิบัติงานต่างจังหวัดได้ ***', 10, '2023-02-16 05:19:26', '2023-02-16 05:19:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_occupation`
--

CREATE TABLE `jobs_occupation` (
  `Job_ID` int NOT NULL,
  `Occ_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs_occupation`
--

INSERT INTO `jobs_occupation` (`Job_ID`, `Occ_ID`) VALUES
(1, 1),
(2, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_resume`
--

CREATE TABLE `jobs_resume` (
  `Job_ID` int NOT NULL,
  `Res_ID` int NOT NULL,
  `JobRes_Status` int NOT NULL,
  `Apply_Date` timestamp NOT NULL,
  `Accept_Date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs_resume`
--

INSERT INTO `jobs_resume` (`Job_ID`, `Res_ID`, `JobRes_Status`, `Apply_Date`, `Accept_Date`) VALUES
(3, 2, 20, '2023-03-03 17:05:20', '2023-03-03 17:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `logs_jobs_resume`
--

CREATE TABLE `logs_jobs_resume` (
  `Job_ID` int NOT NULL,
  `Res_ID` int NOT NULL,
  `JobRes_Status` int NOT NULL,
  `JobRes_Note` varchar(200) NOT NULL,
  `JobRes_Date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `logs_jobs_resume`
--

INSERT INTO `logs_jobs_resume` (`Job_ID`, `Res_ID`, `JobRes_Status`, `JobRes_Note`, `JobRes_Date`) VALUES
(1, 2, 30, 'ยกเลิกการสมัครงาน', '2023-02-28 15:11:05'),
(2, 2, 40, 'ยกเลิกการจ้างงาน', '2023-03-03 16:51:02'),
(2, 2, 40, 'ยกเลิกการจ้างงาน', '2023-03-03 16:56:00'),
(3, 2, 40, 'ยกเลิกการจ้างงาน', '2023-03-03 17:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `News_ID` int NOT NULL,
  `News_Title` varchar(100) NOT NULL,
  `News_Description` text NOT NULL,
  `News_Photo` varchar(200) NOT NULL,
  `News_Added` timestamp NOT NULL,
  `News_Updated` timestamp NOT NULL,
  `User_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`News_ID`, `News_Title`, `News_Description`, `News_Photo`, `News_Added`, `News_Updated`, `User_ID`) VALUES
(1, 'Smart Farm', 'Smart Farm @ Monitoring System', '../figs/news_figs/news_1.jpg', '2023-02-28 15:48:03', '2023-02-28 15:48:03', 1),
(4, 'ทดสอบอัปโหลด', 'รายละเอียดการทดสอบอัปโหลด', '../figs/news_figs/news_20230301032356.jpg', '2023-03-01 02:23:56', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `occupation`
--

CREATE TABLE `occupation` (
  `Occ_ID` int NOT NULL,
  `Occ_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `occupation`
--

INSERT INTO `occupation` (`Occ_ID`, `Occ_Name`) VALUES
(1, 'เจ้าหน้าที่ข้อมูล'),
(2, 'พนักงานในไร่'),
(3, 'เจ้าหน้าที่ด้านการเกษตร'),
(4, 'เจ้าหน้าที่ควบคุมคุณภาพ');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Pro_ID` int NOT NULL,
  `Pro_Title` varchar(50) NOT NULL,
  `Pro_Description` text NOT NULL,
  `Pro_Photo` varchar(200) NOT NULL,
  `Pro_Quantity` int NOT NULL,
  `Pro_PricePU` double NOT NULL,
  `Pro_Month` int NOT NULL,
  `Pro_Year` int NOT NULL,
  `Pro_Unit` varchar(10) NOT NULL,
  `Pro_Contact` text NOT NULL,
  `Pro_Added` timestamp NOT NULL,
  `Pro_Updated` timestamp NOT NULL,
  `Farm_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Pro_ID`, `Pro_Title`, `Pro_Description`, `Pro_Photo`, `Pro_Quantity`, `Pro_PricePU`, `Pro_Month`, `Pro_Year`, `Pro_Unit`, `Pro_Contact`, `Pro_Added`, `Pro_Updated`, `Farm_ID`) VALUES
(1, 'สับปะรดอบแห้ง', 'สับปะรดอบแห้ง ไม่มีน้ำตาล กินเจทานได้ คลีน ๆ เนื้อล้วน หวานธรรมชาติ', 'prod_figs/prod_1.jpg', 100, 80, 1, 2023, 'แพ็ค', 'กลุ่มวิสาหกิจชุมชนสับปะรดศรีราชา จังหวัดชลบุรี โทร. 0358898898', '2023-02-15 01:35:01', '2023-03-01 15:38:08', 1),
(2, 'น้ำสับปะรดไซเดอร์', 'น้ำสับปะรดไซเดอร์ จากสับปะรดศรีราชา จ.ชลบุรี ช่วย ปรับกรดในกระเพาะให้ย่อยอาหารได้ดีเหมือนเดิมและมีจุลินทรีย์ดี ช่วยกำจัดลมในท้องและลำไส้', 'prod_figs/prod_2.jpg', 60, 120, 2, 2023, 'ขวด', 'กลุ่มวิสาหกิจชุมชนสับปะรดศรีราชา จังหวัดชลบุรี โทร. 0358898898', '2023-02-17 04:53:59', '2023-02-17 04:53:59', 1),
(4, 'สับปะรดผลสด', 'สับปะรดผลสดใหม่ ๆ จากฟาร์ม', '../figs/prod_figs/prod_20230301165245.jpg', 2, 10000, 4, 2023, 'ตัน', '0777777777', '2023-03-01 15:48:08', '2023-03-01 15:54:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `Res_ID` int NOT NULL,
  `Res_Prefix` int NOT NULL,
  `Res_Name` varchar(50) NOT NULL,
  `Res_Surname` varchar(50) NOT NULL,
  `Res_Age` int NOT NULL,
  `Res_Sex` int NOT NULL,
  `Res_Phone` varchar(20) NOT NULL,
  `Res_Email` varchar(100) NOT NULL,
  `Res_Address` text NOT NULL,
  `Res_Note` text NOT NULL,
  `Res_Added` timestamp NOT NULL,
  `Res_Updated` timestamp NOT NULL,
  `Occ_ID` int NOT NULL,
  `User_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`Res_ID`, `Res_Prefix`, `Res_Name`, `Res_Surname`, `Res_Age`, `Res_Sex`, `Res_Phone`, `Res_Email`, `Res_Address`, `Res_Note`, `Res_Added`, `Res_Updated`, `Occ_ID`, `User_ID`) VALUES
(1, 1, 'ทดสอบ', 'งานใหม่', 22, 1, '0351111111', 'mrjob1@mail.com', 'ต.บางพระ อ.ศรีราชา จ.ชลบุรี', 'เงินเดือนที่ต้องการ 12,000 บาท', '2023-03-03 16:36:28', '2023-03-03 16:36:28', 3, 5),
(2, 1, 'หางาน', 'อยากได้งาน', 27, 1, '0352222222', 'mrjob2@mail.com', 'ต.บางพระ อ.ศรีราชา จ.ชลบุรี', 'เงินเดือนที่ต้องการ 10000 บาท', '2023-02-25 14:48:55', '2023-02-27 14:55:46', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int NOT NULL,
  `User_Email` varchar(100) NOT NULL,
  `User_Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `User_Fullname` varchar(100) NOT NULL,
  `User_Type` tinyint(1) NOT NULL,
  `User_Active` tinyint(1) NOT NULL,
  `User_Added` timestamp NOT NULL,
  `User_Updated` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_Email`, `User_Password`, `User_Fullname`, `User_Type`, `User_Active`, `User_Added`, `User_Updated`) VALUES
(1, 'admin@mail.com', 'Admin@1234', 'Administrator', 1, 1, '2023-02-03 10:44:57', '2023-02-03 10:44:57'),
(2, 'ajkhaeg@mail.com', 'Ajkhaeg@1234', 'Aj.Khaeg Chumpol', 2, 1, '2023-02-03 10:45:47', '2023-02-03 10:45:47'),
(3, 'mrjob@mail.com', 'Mrjob@1234', 'Mr.Job Pine', 3, 1, '2023-02-03 10:46:27', '2023-02-03 10:46:27'),
(4, 'chumpol@mail.com', 'Chumpol@1234', 'Mr.Khaeg Chumpol', 2, 1, '2023-02-28 04:48:56', '2023-02-28 05:29:56'),
(5, 'mrjob1@mail.com', 'Mrjob1@1234', 'Mr.Job Pine', 3, 1, '2023-03-03 16:36:00', '2023-03-03 16:36:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `farm`
--
ALTER TABLE `farm`
  ADD PRIMARY KEY (`Farm_ID`),
  ADD KEY `FK_USER_ID` (`User_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`Job_ID`),
  ADD KEY `FK_JOBS_FARM_ID` (`Farm_ID`);

--
-- Indexes for table `jobs_occupation`
--
ALTER TABLE `jobs_occupation`
  ADD PRIMARY KEY (`Job_ID`,`Occ_ID`),
  ADD KEY `FK_JO_OCC_ID` (`Occ_ID`);

--
-- Indexes for table `jobs_resume`
--
ALTER TABLE `jobs_resume`
  ADD UNIQUE KEY `PK_JR_ID` (`Job_ID`,`Res_ID`);

--
-- Indexes for table `logs_jobs_resume`
--
ALTER TABLE `logs_jobs_resume`
  ADD PRIMARY KEY (`Job_ID`,`Res_ID`,`JobRes_Date`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`News_ID`),
  ADD KEY `FK_NEWS_USER_ID` (`User_ID`);

--
-- Indexes for table `occupation`
--
ALTER TABLE `occupation`
  ADD PRIMARY KEY (`Occ_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Pro_ID`);

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`Res_ID`),
  ADD KEY `FK_OCC_ID` (`Occ_ID`),
  ADD KEY `FK_RES_USER_ID` (`User_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `farm`
--
ALTER TABLE `farm`
  MODIFY `Farm_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `Job_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `News_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `occupation`
--
ALTER TABLE `occupation`
  MODIFY `Occ_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Pro_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `resume`
--
ALTER TABLE `resume`
  MODIFY `Res_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farm`
--
ALTER TABLE `farm`
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `FK_JOBS_FARM_ID` FOREIGN KEY (`Farm_ID`) REFERENCES `farm` (`Farm_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `jobs_occupation`
--
ALTER TABLE `jobs_occupation`
  ADD CONSTRAINT `FK_JO_OCC_ID` FOREIGN KEY (`Occ_ID`) REFERENCES `occupation` (`Occ_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_JOB_ID` FOREIGN KEY (`Job_ID`) REFERENCES `jobs` (`Job_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `FK_NEWS_USER_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `resume`
--
ALTER TABLE `resume`
  ADD CONSTRAINT `FK_OCC_ID` FOREIGN KEY (`Occ_ID`) REFERENCES `occupation` (`Occ_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_RES_USER_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
