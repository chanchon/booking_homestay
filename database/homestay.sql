-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2022 at 11:45 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homestay`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `a_id` int(10) NOT NULL COMMENT 'ไอดีผู้ใช้',
  `a_username` varchar(100) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `a_password` varchar(50) NOT NULL COMMENT 'รหัสผ่าน',
  `a_name` varchar(60) NOT NULL COMMENT 'ชื่อ',
  `a_surname` varchar(60) NOT NULL COMMENT 'นามสกุล',
  `a_sex` enum('ชาย','หญิง') NOT NULL COMMENT 'เพศ',
  `a_phone` varchar(11) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `a_home` varchar(30) NOT NULL COMMENT 'ที่พัก',
  `image` varchar(300) NOT NULL COMMENT 'qr code',
  `line_token` varchar(100) NOT NULL COMMENT 'line token notifly\r\n',
  `a_level` enum('member','admin','system') NOT NULL DEFAULT 'member' COMMENT 'ระดับผู้ใช้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`a_id`, `a_username`, `a_password`, `a_name`, `a_surname`, `a_sex`, `a_phone`, `a_home`, `image`, `line_token`, `a_level`) VALUES
(1, 'system', '202cb962ac59075b964b07152d234b70', 'system', 'system', 'ชาย', '062-1319253', '-', '', '', 'system'),
(2, 'admin_khaokhiangkhong', '202cb962ac59075b964b07152d234b70', 'อภิสิทธิ์ ', 'อดิศักดิ์', 'ชาย', '056-5656555', 'เขาเคียงโขงโฮมสเตย์', 'images/2.png', 'cvpSTJyzbY2AhleNw5SqyysaBZknbWPRLh1hzPKgpaA', 'admin'),
(3, 'member_khaokhiangkhong', '202cb962ac59075b964b07152d234b70', 'ดาหวัน', 'สวรรค์บันดาร', 'หญิง', '065-5656565', 'เขาเคียงโขงโฮมสเตย์', '', '', 'member'),
(5, 'admin_chanpha', '202cb962ac59075b964b07152d234b70', 'บริวัตร ', 'ลายศรี', 'ชาย', '555-5555555', 'จันทร์ผาโฮมสเตย์', 'images/5.png', '', 'admin'),
(7, 'admin_nongkhai', '202cb962ac59075b964b07152d234b70', 'สุรศักดิ์', 'มนตรี', 'ชาย', '062-3494944', 'หนองคายโฮมสเตย์', 'images/7.png', '9999', 'admin'),
(14, 'member_nongkhai', '202cb962ac59075b964b07152d234b70', 'จิราวัตร', 'พิบูลสา', 'ชาย', '062-5896656', 'หนองคายโฮมสเตย์', '', '', 'member'),
(20, 'member_chanpha', '202cb962ac59075b964b07152d234b70', 'ยุวดี', 'สีราดหา', 'ชาย', '066-5524250', 'จันทร์ผาโฮมสเตย์', '', '', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking`
--

CREATE TABLE `tb_booking` (
  `b_id` int(10) NOT NULL COMMENT 'ไอดีผู้จอง',
  `status` enum('ชำระแล้ว','ยังไม่ชำระ','ยกเลิก') NOT NULL DEFAULT 'ยังไม่ชำระ' COMMENT 'สถานะ',
  `note` varchar(200) NOT NULL COMMENT 'หมายเหตุ',
  `name` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `phone` text NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `guest` int(30) NOT NULL COMMENT 'จำนวนคนที่เข้าพัก',
  `home` varchar(50) NOT NULL COMMENT 'ที่พัก',
  `checkin` date NOT NULL COMMENT 'เช็คอิน',
  `checkout` date NOT NULL COMMENT 'เช็คเอาท์',
  `package` varchar(50) DEFAULT NULL COMMENT 'แพ็กเกจ',
  `room` varchar(10) NOT NULL COMMENT 'ห้อง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`b_id`, `status`, `note`, `name`, `phone`, `guest`, `home`, `checkin`, `checkout`, `package`, `room`) VALUES
(1, 'ชำระแล้ว', '', 'ชาญชล บุบปับพา', '062-1319253', 1, 'จันทร์ผาโฮมสเตย์', '2022-06-01', '2022-06-03', 'นำเที่ยว', '2'),
(2, 'ยังไม่ชำระ', '', 'ชาญชล บุบปับพา', '062-1319253', 1, 'จันทร์ผาโฮมสเตย์', '2022-06-01', '2022-06-03', 'ทำกิจกรรม', ''),
(3, 'ยกเลิก', 'เมียจับได้ว่ามีชู้', 'Amy', '025-3068864', 1, 'จันทร์ผาโฮมสเตย์', '2022-06-01', '2022-06-03', '', ''),
(4, 'ยังไม่ชำระ', '', 'Amelia', '062-1319253', 1, 'เขาเคียงโขงโฮมสเตย์', '2022-06-01', '2022-06-03', 'อาหาร 3 มื้อ,นำเที่ยว', ''),
(5, 'ยกเลิก', 'ไม่มีตังค์', 'Amy', '025-3068864', 1, 'จันทร์ผาโฮมสเตย์', '2022-06-01', '2022-06-03', 'ยกเลิกแพ็กเกจ', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`b_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `a_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีผู้ใช้', AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีผู้จอง', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
