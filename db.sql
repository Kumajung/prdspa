CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสลูกค้า',
  `first_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(150) DEFAULT NULL COMMENT 'นามสกุล',
  `email` varchar(50) DEFAULT NULL COMMENT 'อีเมล',
  `phone_number` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `address` text COMMENT 'ที่อยู่',
  `is_member` int(11) DEFAULT NULL COMMENT 'สถานะสมาชิก',
  `member_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่เป็นสมาชิก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสแพ็คเกจ',
  `package_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อแพ็คเกจ',
  `price` double(11,2) DEFAULT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสพนักงาน',
  `first_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(150) DEFAULT NULL COMMENT 'นามสกุล',
  `telephone` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `salary` double(11,2) DEFAULT NULL COMMENT 'เงินเดือน',
  `position_id` int(11) DEFAULT NULL COMMENT 'รหัสประเภทพนักงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสประเภทพนักงาน',
  `position_name` varchar(150) DEFAULT NULL COMMENT 'ชื่อตำแหน่งพนักงาน',
  `commission_rate` int(11) DEFAULT NULL COMMENT 'อัตราค่าคอมมิชชั่น'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสออเดอร์',
  `orders_type_id` int(11) NOT NULL COMMENT 'รหัสประเภทออเดอร์',
  `customer_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `employee_id` int(11) DEFAULT NULL COMMENT 'รหัสพนักงาน',
  `total_price` double(11,2) NOT NULL COMMENT 'ยอดรวม',
  `discount_price` double(11,2) NOT NULL COMMENT 'ส่วนลด',
  `sale_date` timestamp NULL DEFAULT COMMENT 'วันที่ทำรายการ',
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders_detail` (
  `orders_detail_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสการรายละเอียดการขาย',
  `orders_id` int(11) NOT NULL COMMENT 'รหัสออเดอร์',
  `package_id` int(11) NOT NULL COMMENT 'รหัสแพ็คเกจ',
  `service_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ใช้จะเข้ามาใช้บริการ',
  `price` double(11,2) NOT NULL COMMENT 'ราคา ณ วันที่ซื้อ',
  `package_qty` int(11) DEFAULT NULL COMMENT 'จำนวนแพ็กเกจ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders_type` (
  `orders_type_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'รหัสประเภทออเดอร์',
  `orders_type_name` varchar(150) NOT NULL COMMENT 'ชื่อประเภทออเดอร์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


