-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 13, 2024 at 01:45 PM
-- Server version: 5.7.44
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spa_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customers` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `first_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(150) DEFAULT NULL COMMENT 'นามสกุล',
  `email` varchar(50) DEFAULT NULL COMMENT 'อีเมล',
  `phone_number` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `address` text COMMENT 'ที่อยู่',
  `is_member` int(11) DEFAULT NULL COMMENT 'สถานะสมาชิก',
  `member_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่เป็นสมาชิก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL COMMENT 'รหัสพนักงาน',
  `first_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(150) DEFAULT NULL COMMENT 'นามสกุล',
  `telephone` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `salary` double(11,2) DEFAULT NULL COMMENT 'เงินเดือน',
  `position_id` int(11) DEFAULT NULL COMMENT 'รหัสประเภทพนักงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `customer_id` varchar(50) NOT NULL COMMENT 'รหัสลูกค้า',
  `employee_id` varchar(50) DEFAULT NULL COMMENT 'รหัสพนักงาน',
  `total_price` double(11,2) NOT NULL COMMENT 'ยอดรวม',
  `discount_price` double(11,2) NOT NULL COMMENT 'ส่วนลด',
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ทำรายการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `orders_detail_id` int(11) NOT NULL COMMENT 'รหัสการรายละเอียดการขาย',
  `orders_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `package_id` int(11) NOT NULL COMMENT 'รหัสแพ็คเกจ',
  `service_date` int(11) NOT NULL COMMENT 'วันที่ใช้จะเข้ามาใช้บริการ',
  `price` double(11,2) NOT NULL COMMENT 'รหัสลูกค้า',
  `package_qty` int(11) DEFAULT NULL COMMENT 'รหัสลูกค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_type`
--

CREATE TABLE `orders_type` (
  `orders_type_id` int(11) NOT NULL COMMENT 'รหัสประเภทออเดอร์',
  `orders_type_name` varchar(150) NOT NULL COMMENT 'ชื่อประเภทออเดอร์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL COMMENT 'รหัสแพ็คเกจ',
  `package_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อแพ็คเกจ',
  `price` double(11,2) DEFAULT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL COMMENT 'รหัสประเภทพนักงาน',
  `position_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อตำแหน่งพนักงาน',
  `commission_rate` int(11) DEFAULT NULL COMMENT 'อัตราค่าคอมมิชชั่น'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customers`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`orders_detail_id`);

--
-- Indexes for table `orders_type`
--
ALTER TABLE `orders_type`
  ADD PRIMARY KEY (`orders_type_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customers` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า';

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสพนักงาน';

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสออเดอร์';

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `orders_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการรายละเอียดการขาย';

--
-- AUTO_INCREMENT for table `orders_type`
--
ALTER TABLE `orders_type`
  MODIFY `orders_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทออเดอร์';

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสแพ็คเกจ';

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทพนักงาน';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
