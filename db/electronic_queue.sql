-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Sep 20, 2020 at 12:15 AM
-- Server version: 10.5.4-MariaDB-1:10.5.4+maria~focal
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electronic_queue`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `status` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `pause_time` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept_name`, `status`, `pause_time`) VALUES
(01, 'แผนกงานทะเบียนนักศึกษา', 01, 10),
(02, 'แผนกงานตรวจสอบและรับรองผลการศึกษา', 01, NULL),
(03, 'แผนกงานสำเร็จการศึกษา', 01, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rloe` varchar(50) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `department` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `officer`
--

INSERT INTO `officer` (`id`, `fname`, `lname`, `position`, `username`, `password`, `rloe`, `profile`, `department`) VALUES
(001, 'เกตุกาญจน์', 'ไชยขันธู์', 'รองผอ.งานทะเบียนและประมวลผล', 'admin', 'UTEHNVM6CW0BPQ==', 'admin', 'cb3e5f375cfc362b3a5412d75680dc75.jpg', NULL),
(002, 'ธนอนศรี', 'สุทธิจันทร์', 'หัวหน้างานทะเบียนและประมวลผล', 'admin2', 'A2NSYANqDGgDPw==', 'admin', '5b1c13a615fe23a6e177dacbebc0b738.jpg', NULL),
(003, 'ฐาณิญา', 'ทองประสาร', 'นักวิชาการศึกษา', 'thaniya', 'ADBWMlBnXWQ=', 'staff', 'b4d96a9804cbe7753fcc75e22b28c63c.jpg', 01),
(004, 'ณัฐฏนันท์', 'ไชยรัตน์', 'นักวิชาการศึกษา', 'nhattanan', 'DDxVMQYxX2Y=', 'staff', '737bbd7efbf2573819fa4455bbbfbc71.jpg', 01),
(005, 'พนิดา', 'กาจกระโทก', 'นักวิชาการศึกษา', 'panida', 'DDxWMlRjCTA=', 'staff', 'b95f3fe4a64514a26f48a1926537cc30.jpg', 01),
(006, 'จิราพร', 'วรทองหลาง', 'นักวิชาการศึกษา', 'jirapon', 'DT1VMQQzCDE=', 'staff', '211a731101f8a2cdff16c4809a03af05.jpg', 01),
(007, 'วรรณ์มณี', 'บุญฟู', 'นักวิชาการศึกษา', 'wanmanee', 'AjJTNwYxCDE=', 'staff', '7cc42c03610ecb480e71b4e9ed0ff2fe.jpg', 02),
(009, 'อรจริน', 'สุทธิวิไล', 'นักวิชาการศึกษา', 'orajarin', 'VWVXM1RjATg=', 'staff', '3043cdfcc089ec2ece9c0d94920e1b0a.jpg', 02),
(010, 'น้ำผึ่ง', 'ขอเชิญกลาง', 'นักวิชาการศึกษา', 'nampeung', 'V2ddOVNkW2I=', 'staff', '05a29f6dc2bcb574aa18cc8b34cd4094.jpg', 02),
(011, 'ระวิสุดา', 'นารี', 'นักวิชาการศึกษา', 'rawisuda', 'BDRVMQcwXGU=', 'staff', '7926b2e892e5a67a8cf7fb893dab1351.jpg', 03),
(012, 'เอมอัจฉริยา', 'พีรทัตสุวรรณ', 'นักวิชาการศึกษา', 'aemoujchariya', 'AzNcOAYxW2I=', 'staff', '36c28ebcf0fb4bec3a894b7bd0f1ef6e.jpg', 03),
(013, 'จักรพงษ์', 'คงดี', 'นักวิชาการศึกษา', 'jakkapong', 'UGAGYg45CzI=', 'staff', 'cb377fee0c2b9afa39b5694aca6d4c1a.jpg', 03),
(014, 'สุจิตรา', 'ประพฤติเป็น', 'นักวิชาการศึกษา', 'sujitta', 'UGBQNAYxX2Y=', 'staff', 'c21d3d10726fa1b27b1a6e35606987cb.jpg', 03);

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `queue_no` varchar(4) NOT NULL,
  `user_type` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `phone_number` varchar(10) NOT NULL,
  `service` tinyint(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `department` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `status` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `waiting_time` tinyint(3) NOT NULL,
  `process_time` tinyint(2) DEFAULT NULL,
  `service_time` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `queue_no`, `user_type`, `phone_number`, `service`, `department`, `status`, `time_stamp`, `waiting_time`, `process_time`, `service_time`) VALUES
(000026, 'A001', 01, '0836669998', 002, 01, 05, '2020-09-03 02:42:30', 0, NULL, 5),
(000027, 'A002', 01, '0855555555', 002, 01, 05, '2020-09-03 02:42:35', 5, NULL, 5),
(000028, 'A003', 01, '0864513711', 004, 01, 05, '2020-09-03 03:42:39', 10, NULL, 5),
(000029, 'A004', 01, '0864643369', 003, 01, 05, '2020-09-03 03:42:43', 15, NULL, 5),
(000030, 'B001', 01, '0965852588', 005, 02, 05, '2020-09-03 02:42:47', 0, NULL, 5),
(000031, 'B002', 01, '0888776655', 006, 02, 05, '2020-09-03 02:42:51', 5, NULL, 5),
(000032, 'C001', 03, '0699988555', 008, 03, 05, '2020-09-03 06:42:55', 0, NULL, 5),
(000033, 'C002', 02, '0987788990', 008, 03, 05, '2020-09-03 06:42:58', 5, NULL, 5),
(000034, 'A001', 01, '0836669998', 002, 01, 05, '2020-09-04 01:42:30', 0, NULL, 5),
(000035, 'A002', 01, '0855555555', 002, 01, 05, '2020-09-04 01:42:35', 5, NULL, 5),
(000036, 'A003', 01, '0864513711', 004, 01, 05, '2020-09-04 05:42:39', 10, NULL, 5),
(000037, 'A004', 01, '0864643369', 003, 01, 05, '2020-09-04 06:42:43', 15, NULL, 5),
(000038, 'B001', 01, '0965852588', 005, 02, 05, '2020-09-04 08:42:47', 0, NULL, 5),
(000039, 'B002', 01, '0888776655', 006, 02, 05, '2020-09-04 08:42:51', 5, NULL, 5),
(000040, 'C001', 03, '0699988555', 008, 03, 05, '2020-09-04 02:42:55', 0, NULL, 5),
(000041, 'C002', 02, '0987788990', 008, 03, 05, '2020-09-04 07:42:58', 5, NULL, 5),
(000042, 'A001', 01, '0836669998', 002, 01, 05, '2020-09-05 03:42:30', 0, NULL, 5),
(000043, 'A002', 01, '0855555555', 002, 01, 05, '2020-09-05 03:42:35', 5, NULL, 5),
(000044, 'A003', 01, '0864513711', 004, 01, 05, '2020-09-05 07:42:39', 10, NULL, 5),
(000045, 'A004', 01, '0864643369', 003, 01, 05, '2020-09-05 08:42:43', 15, NULL, 5),
(000046, 'B001', 01, '0965852588', 005, 02, 05, '2020-09-05 02:42:47', 0, NULL, 5),
(000047, 'B002', 01, '0888776655', 006, 02, 05, '2020-09-05 04:42:51', 5, NULL, 5),
(000048, 'C001', 03, '0699988555', 008, 03, 05, '2020-09-05 05:42:55', 0, NULL, 5),
(000049, 'C002', 02, '0987788990', 008, 03, 05, '2020-09-05 06:42:58', 5, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `queue_status`
--

CREATE TABLE `queue_status` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue_status`
--

INSERT INTO `queue_status` (`id`, `status`) VALUES
(01, 'รอ'),
(02, 'กำลังใช้งาน'),
(03, 'ยกเลิกโดยผู้ใช้'),
(04, 'ยกเลิกโดยเจ้าหน้าที่'),
(05, 'เสร็จสิ้น');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL,
  `service_name` varchar(300) NOT NULL,
  `time` tinyint(2) NOT NULL,
  `department` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `time`, `department`) VALUES
(001, 'สอบถามด้านการลงทะเบียนเรียน', 5, 01),
(002, 'ยื่นใบคำร้องด้านการลงทะเบียน', 5, 01),
(003, 'สอบถามผลการศึกษา (เกรด)', 5, 01),
(004, 'อื่นๆ', 5, 01),
(005, 'ใบรับรองประเภทต่างๆ', 5, 02),
(006, 'เอกสารตรวจสอบคุณวุฒิ', 5, 02),
(007, 'อื่นๆ', 5, 02),
(008, 'การยื่นสำเร็จการศึกษา', 5, 03),
(009, 'ติดต่อขอรับใบแสดงผลการศึกษา', 5, 03),
(010, 'ขอเอกสารหลังสำเร็จการศึกษา', 5, 03),
(011, 'อื่นๆ', 5, 03);

-- --------------------------------------------------------

--
-- Table structure for table `system_status`
--

CREATE TABLE `system_status` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_status`
--

INSERT INTO `system_status` (`id`, `status`) VALUES
(01, 'เปิด'),
(02, 'ปิด'),
(03, 'พัก');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type_name`) VALUES
(01, 'นักศึกษา'),
(02, 'อาจารย์'),
(03, 'บุคคลภายนอก');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_systemstatus` (`status`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departmentoff_department` (`department`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_queue_status` (`status`),
  ADD KEY `department_department` (`department`),
  ADD KEY `servicequ_service` (`service`),
  ADD KEY `usertype_usertype` (`user_type`);

--
-- Indexes for table `queue_status`
--
ALTER TABLE `queue_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departmentser_department` (`department`);

--
-- Indexes for table `system_status`
--
ALTER TABLE `system_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `queue_status`
--
ALTER TABLE `queue_status`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `system_status`
--
ALTER TABLE `system_status`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `status_systemstatus` FOREIGN KEY (`status`) REFERENCES `system_status` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `officer`
--
ALTER TABLE `officer`
  ADD CONSTRAINT `departmentoff_department` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `department_department` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `servicequ_service` FOREIGN KEY (`service`) REFERENCES `service` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `status_queue_status` FOREIGN KEY (`status`) REFERENCES `queue_status` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `usertype_usertype` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `departmentser_department` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
