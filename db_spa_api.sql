-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 14, 2024 at 05:42 PM
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
  `customer_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `first_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(150) DEFAULT NULL COMMENT 'นามสกุล',
  `email` varchar(50) DEFAULT NULL COMMENT 'อีเมล',
  `phone_number` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `address` text COMMENT 'ที่อยู่',
  `is_member` int(11) DEFAULT NULL COMMENT 'สถานะสมาชิก',
  `member_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่เป็นสมาชิก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `is_member`, `member_date`) VALUES
(1, 'Eric', 'Vazquez', 'bahyzot@gmail.com', '0836195514', 'ถนน 6 พิษณุโลก \r\nตำบลสุเทพ อำเภอเมืองเชียงใหม่ \r\nเชียงใหม่ 50200', 1, '2024-10-13 19:17:01'),
(2, 'Dorothy', 'Nichols', 'johuludef@gmail.com', '0863798088', '35, 1 ถนน บุญเรืองฤทธิ์ ซอย 2 \r\nตำบลสุเทพ เมือง เชียงใหม่ 50200', 1, '2024-10-13 19:17:15'),
(3, 'Rooney', 'Burris', 'kuhyv@gmail.com', '0849182201', 'Fuga Et maxime mole', 1, '2024-10-14 05:46:35');

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

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `telephone`, `salary`, `position_id`) VALUES
(1, 'วรรณภา', 'ขาวเจริญ', '0931243355', 23000.00, 1),
(2, 'Aurelia', 'Evans', '0829172954', 14000.00, 2),
(6, 'Edan', 'Carver', '0873465697', 9800.00, 1),
(7, 'Naida', 'Castaneda', '0896835337', 71.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `orders_type_id` int(11) NOT NULL COMMENT 'รหัสประเภทออเดอร์',
  `customer_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `employee_id` int(11) DEFAULT NULL COMMENT 'รหัสพนักงาน',
  `total_price` double(11,2) NOT NULL COMMENT 'ยอดรวม',
  `discount_price` double(11,2) NOT NULL COMMENT 'ส่วนลด',
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ทำรายการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_type_id`, `customer_id`, `employee_id`, `total_price`, `discount_price`, `sale_date`) VALUES
(1, 1, 1, 1, 1500.00, 0.00, '2024-10-14 11:37:18'),
(2, 2, 3, 2, 7800.00, 700.00, '2024-10-14 11:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `orders_detail_id` int(11) NOT NULL COMMENT 'รหัสการรายละเอียดการขาย',
  `orders_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `package_id` int(11) NOT NULL COMMENT 'รหัสแพ็คเกจ',
  `service_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ใช้จะเข้ามาใช้บริการ',
  `price` double(11,2) NOT NULL COMMENT 'ราคา ณ วันที่ซื้อ',
  `package_qty` int(11) DEFAULT NULL COMMENT 'จำนวนแพ็คเกจ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`orders_detail_id`, `orders_id`, `package_id`, `service_date`, `price`, `package_qty`) VALUES
(1, 1, 1, '2024-10-14 11:37:18', 1500.00, 1),
(2, 2, 1, '2024-10-14 11:52:18', 1300.00, 3),
(3, 2, 5, '2024-10-14 11:52:18', 780.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders_type`
--

CREATE TABLE `orders_type` (
  `orders_type_id` int(11) NOT NULL COMMENT 'รหัสประเภทออเดอร์',
  `orders_type_name` varchar(150) NOT NULL COMMENT 'ชื่อประเภทออเดอร์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_type`
--

INSERT INTO `orders_type` (`orders_type_id`, `orders_type_name`) VALUES
(1, 'หน้าร้าน'),
(2, 'ออนไลน์');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL COMMENT 'รหัสแพ็คเกจ',
  `package_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อแพ็คเกจ',
  `price` double(11,2) DEFAULT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `price`) VALUES
(1, 'สปาไทยโบราณ', 1500.00),
(5, 'สปาสไตล์ล้านนา', 800.00),
(6, 'Giselle Armstrong', 997.00);

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
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position_name`, `commission_rate`) VALUES
(1, 'พนักงานสปา', 30),
(2, 'พนักงานขาย', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสพนักงาน', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสออเดอร์', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `orders_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการรายละเอียดการขาย', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders_type`
--
ALTER TABLE `orders_type`
  MODIFY `orders_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทออเดอร์', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสแพ็คเกจ', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทพนักงาน', AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
