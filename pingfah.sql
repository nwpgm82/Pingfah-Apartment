-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 07:07 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pingfah`
--

-- --------------------------------------------------------

--
-- Table structure for table `appeal`
--

CREATE TABLE `appeal` (
  `appeal_id` int(11) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `appeal_topic` varchar(200) NOT NULL,
  `appeal_detail` varchar(200) NOT NULL,
  `appeal_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appeal`
--

INSERT INTO `appeal` (`appeal_id`, `room_id`, `appeal_topic`, `appeal_detail`, `appeal_date`) VALUES
(2, '201', 'ข้างห้องเสียงดัง', 'ห้อง 202 เสียงดังมากหลังเที่ยงคืนครับ', '2020-11-30'),
(5, '202', 'ข้างห้องเสียงดัง', 'ห้อง 203 เปิดเพลงเสียงดังมากนอนไม่หลับเลยครับ', '2020-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

CREATE TABLE `cost` (
  `cost_id` int(11) NOT NULL,
  `room_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `cost_status` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `room_cost` float(100,2) DEFAULT NULL,
  `water_bill` float(100,2) DEFAULT NULL,
  `elec_bill` float(100,2) DEFAULT NULL,
  `cable_charge` float(100,2) DEFAULT NULL,
  `fines` float(100,2) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cost`
--

INSERT INTO `cost` (`cost_id`, `room_id`, `type`, `cost_status`, `date`, `room_cost`, `water_bill`, `elec_bill`, `cable_charge`, `fines`, `total`) VALUES
(3, '202', '', 'ชำระเงินแล้ว', '2020-11', 2700.00, 80.00, 750.00, 105.00, 0.00, '3635');

-- --------------------------------------------------------

--
-- Table structure for table `daily`
--

CREATE TABLE `daily` (
  `daily_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `id_card` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `check_in` varchar(200) DEFAULT NULL,
  `check_out` varchar(200) DEFAULT NULL,
  `people` varchar(2) DEFAULT NULL,
  `air_room` int(2) DEFAULT NULL,
  `fan_room` int(2) DEFAULT NULL,
  `daily_status` varchar(200) DEFAULT NULL,
  `payment_datebefore` varchar(200) NOT NULL,
  `payment_img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily`
--

INSERT INTO `daily` (`daily_id`, `firstname`, `lastname`, `id_card`, `email`, `tel`, `code`, `check_in`, `check_out`, `people`, `air_room`, `fan_room`, `daily_status`, `payment_datebefore`, `payment_img`) VALUES
(13, 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', 'nw68y0ftqpx', '2020-11-25', '2020-11-26', '', NULL, NULL, 'เข้าพักแล้ว', '', NULL),
(14, 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', 'nrogk56n2rj', '2020-11-24', '2020-11-26', '', NULL, NULL, 'เข้าพักแล้ว', '', NULL),
(15, 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', 'f25omtxwa4z', '2020-12-04', '2020-12-05', '', NULL, NULL, NULL, '', NULL),
(17, 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', 'k0kp6jtpnnx', '2020-12-09', '2020-12-16', '3', 3, 0, NULL, '', NULL),
(18, 'สุภิศรา', 'เตชนันท์', '5556667778889', 'supisra45.30@gmail.com', '0620477145', '6vmygc8qxym', '2020-12-09', '2020-12-16', '5', 3, 2, NULL, '', NULL),
(21, 'พงศธร', 'สร้อยอินต๊ะ', '1509966011521', 'blackfrostier@gmail.com', '0956722914', '7xgn0rotoid', '2020-12-07', '2020-12-08', '5', 3, 2, NULL, '2020-12-08', NULL),
(25, 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', 'mmkycurx0fm', '2020-12-07', '2020-12-08', '2', 2, 0, NULL, '2020-12-07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dailycost`
--

CREATE TABLE `dailycost` (
  `dailycost_id` int(11) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `id_card` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `check_in` varchar(200) NOT NULL,
  `check_out` varchar(200) NOT NULL,
  `price_total` float(11,2) NOT NULL,
  `daily_status` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dailycost`
--

INSERT INTO `dailycost` (`dailycost_id`, `room_id`, `firstname`, `lastname`, `id_card`, `email`, `tel`, `check_in`, `check_out`, `price_total`, `daily_status`, `code`) VALUES
(12, '201, 203, 204', 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', '2020-11-25', '2020-11-26', 1050.00, 'ชำระเงินแล้ว', 'nw68y0ftqpx'),
(13, '206, 207, 306', 'นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '0956722914', '2020-11-24', '2020-11-26', 750.00, 'ชำระเงินแล้ว', 'nrogk56n2rj');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `title_name` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `position` varchar(200) NOT NULL,
  `id_card` varchar(200) DEFAULT NULL,
  `tel` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `id_line` varchar(200) NOT NULL,
  `birthday` varchar(200) NOT NULL,
  `age` varchar(200) NOT NULL,
  `race` varchar(200) NOT NULL,
  `nationality` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pic_idcard` varchar(200) DEFAULT NULL,
  `pic_home` varchar(200) DEFAULT NULL,
  `profile_img` varchar(200) DEFAULT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `title_name`, `firstname`, `lastname`, `nickname`, `position`, `id_card`, `tel`, `email`, `id_line`, `birthday`, `age`, `race`, `nationality`, `address`, `pic_idcard`, `pic_home`, `profile_img`, `username`, `password`) VALUES
(23, 'นาย', 'นวพล', 'นรเดชานันท์', 'เกม', 'พนักงาน', '1509966011521', '0956722914', 'blackfrostier@gmail.com', 'blackfrostier', '1998-12-21', '21', 'ไทย', 'ไทย', '140/40 หมู่ 2 ต. หนองป่าครั่ง อ.เมือง จ.เชียงใหม่ 50000', '404365.jpg', 'ข้อเสนอแนะบ้านพักพิงฟ้า.jpg', '115774657_3345395698845713_2446905765721859802_o.jpg', 'nwpgm82', 'ef16b5fe40a49934ad40c0b059090b14');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `gallery_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `gallery_name`) VALUES
(27, 'sub1.jpg'),
(28, 'sub6.jpg'),
(29, '13136571443830.jpg'),
(30, '13136571044859.jpg'),
(31, '13136571097113.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `name`, `password`, `level`) VALUES
('202', '', '475e1c39acbf5b4aff05495b8c1d18f5', 'guest'),
('205', '', '1cbf2e9cd7eba3b7dd32cf2565d57908', 'guest'),
('admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
('nwpgm82', 'นวพล', 'ef16b5fe40a49934ad40c0b059090b14', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(11) NOT NULL,
  `package_num` varchar(200) NOT NULL,
  `package_company` varchar(200) NOT NULL,
  `package_arrived` varchar(200) NOT NULL,
  `package_status` varchar(200) NOT NULL,
  `package_name` varchar(200) NOT NULL,
  `package_room` varchar(200) NOT NULL,
  `package_received` varchar(200) NOT NULL,
  `repair_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_num`, `package_company`, `package_arrived`, `package_status`, `package_name`, `package_room`, `package_received`, `repair_id`) VALUES
(1, 'SHP5042811237', 'Kerry', '2020-12-02', 'ยังไม่ได้รับพัสดุ', 'นวพล', '205', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair` (
  `repair_id` int(11) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `repair_appliance` varchar(200) NOT NULL,
  `repair_category` varchar(200) NOT NULL,
  `repair_detail` varchar(200) NOT NULL,
  `repair_date` varchar(200) NOT NULL,
  `repair_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `repair`
--

INSERT INTO `repair` (`repair_id`, `room_id`, `repair_appliance`, `repair_category`, `repair_detail`, `repair_date`, `repair_status`) VALUES
(1, '205', 'หลอดไฟ', 'เครื่องใช้ไฟฟ้า', 'หลอดขาด', '2020-12-02', 'รอดำเนินการ'),
(2, '205', 'ตู้เสื้อผ้า', 'เฟอร์นิเจอร์', 'ประตูตู้เสื้อผ้าแตกหัก', '2020-12-02', 'กำลังดำเนินการ'),
(3, '205', 'เตียงนอน', 'เฟอร์นิเจอร์', 'ผ้าปูที่นอนขาด', '2020-12-02', 'รอดำเนินการ'),
(4, '202', 'ตู้เสื้อผ้า', 'เฟอร์นิเจอร์', 'ราวแขวนผ้าหัก', '2020-12-03', 'ดำเนินการเสร็จสิ้น');

-- --------------------------------------------------------

--
-- Table structure for table `roomdetail`
--

CREATE TABLE `roomdetail` (
  `type` varchar(255) NOT NULL,
  `water_bill` float(255,2) DEFAULT NULL,
  `elec_bill` float(255,2) DEFAULT NULL,
  `cable_charge` float(255,2) DEFAULT NULL,
  `fines` float(255,2) DEFAULT NULL,
  `price` float(255,2) DEFAULT NULL,
  `pic1` varchar(255) DEFAULT NULL,
  `pic2` varchar(255) DEFAULT NULL,
  `pic3` varchar(255) DEFAULT NULL,
  `pic4` varchar(255) DEFAULT NULL,
  `pic5` varchar(255) DEFAULT NULL,
  `pic6` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `daily_price` float(255,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomdetail`
--

INSERT INTO `roomdetail` (`type`, `water_bill`, `elec_bill`, `cable_charge`, `fines`, `price`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `pic6`, `detail`, `daily_price`) VALUES
('พัดลม', 80.00, 7.50, 105.00, 150.00, 2300.00, 'sub8.jpg', 'sub2.jpg', 'sub4.jpg', 'sub7.jpg', 'sub1.jpg', 'sub6.jpg', 'ห้องพัดลม 2300', 250.00),
('แอร์', 80.00, 7.50, 105.00, 150.00, 2700.00, 'sub2.jpg', 'sub5.jpg', 'sub6.jpg', NULL, NULL, NULL, 'ห้องแอร์ 2700 บาท', 350.00);

-- --------------------------------------------------------

--
-- Table structure for table `roomlist`
--

CREATE TABLE `roomlist` (
  `room_id` varchar(200) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `room_status` varchar(200) NOT NULL,
  `come` varchar(200) NOT NULL,
  `check_in` varchar(200) NOT NULL,
  `check_out` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomlist`
--

INSERT INTO `roomlist` (`room_id`, `room_type`, `room_status`, `come`, `check_in`, `check_out`) VALUES
('201', 'แอร์', 'เช่ารายวัน', '', '2020-11-25', '2020-11-26'),
('202', 'แอร์', 'ไม่ว่าง', '2020/11/30', '', ''),
('203', 'แอร์', 'เช่ารายวัน', '', '2020-11-25', '2020-11-26'),
('204', 'แอร์', 'เช่ารายวัน', '', '2020-11-25', '2020-11-26'),
('205', 'แอร์', 'ไม่ว่าง', '2020/11/30', '', ''),
('206', 'พัดลม', 'เช่ารายวัน', '', '2020-11-24', '2020-11-26'),
('207', 'พัดลม', 'เช่ารายวัน', '', '2020-11-24', '2020-11-26'),
('208', 'แอร์', 'ว่าง', '', '', ''),
('301', 'แอร์', 'ว่าง', '', '', ''),
('302', 'แอร์', 'ว่าง', '', '', ''),
('303', 'แอร์', 'ว่าง', '', '', ''),
('304', 'แอร์', 'ว่าง', '', '', ''),
('305', 'แอร์', 'ว่าง', '', '', ''),
('306', 'พัดลม', 'เช่ารายวัน', '', '2020-11-24', '2020-11-26'),
('307', 'แอร์', 'ว่าง', '', '', ''),
('308', 'แอร์', 'ว่าง', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `roommember`
--

CREATE TABLE `roommember` (
  `room_member` varchar(10) NOT NULL,
  `name_title` varchar(10) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `id_card` varchar(13) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `birthday` varchar(200) NOT NULL,
  `age` int(11) NOT NULL,
  `race` varchar(200) NOT NULL,
  `nationality` varchar(200) NOT NULL,
  `job` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pic_idcard` text DEFAULT NULL,
  `pic_home` text DEFAULT NULL,
  `id_line` varchar(200) NOT NULL,
  `name_title2` varchar(10) NOT NULL,
  `firstname2` varchar(200) NOT NULL,
  `lastname2` varchar(200) NOT NULL,
  `nickname2` varchar(200) NOT NULL,
  `id_card2` varchar(13) NOT NULL,
  `phone2` varchar(10) NOT NULL,
  `email2` varchar(200) NOT NULL,
  `birthday2` varchar(200) NOT NULL,
  `age2` int(11) NOT NULL,
  `race2` varchar(200) NOT NULL,
  `nationality2` varchar(200) NOT NULL,
  `job2` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `pic_idcard2` text DEFAULT NULL,
  `pic_home2` text DEFAULT NULL,
  `id_line2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roommember`
--

INSERT INTO `roommember` (`room_member`, `name_title`, `firstname`, `lastname`, `nickname`, `id_card`, `phone`, `email`, `birthday`, `age`, `race`, `nationality`, `job`, `address`, `pic_idcard`, `pic_home`, `id_line`, `name_title2`, `firstname2`, `lastname2`, `nickname2`, `id_card2`, `phone2`, `email2`, `birthday2`, `age2`, `race2`, `nationality2`, `job2`, `address2`, `pic_idcard2`, `pic_home2`, `id_line2`) VALUES
('201', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', '404365.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('202', 'นาย', 'นวพล', 'นรเดชานันท์', 'เกม', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '1998-12-21', 21, 'ไทย', 'ไทย', 'นักศึกษา', '140/40 หมู่ 2 ต. หนองป่าครั่ง อ.เมือง จ.เชียงใหม่ 50000', '404365.jpg', 'ข้อเสนอแนะบ้านพักพิงฟ้า.jpg', 'blackfrostier', 'นางสาว', 'สุภิศรา', 'เตชนันท์', 'แยม', '5556669998888', '0956766976', 'supisra45.30@gmail.com', '1999-04-22', 21, 'ไทย', 'ไทย', 'นักศึกษา', 'หหหหกกกกฟฟฟฟ                        ', '117094314_3466888280022757_1501037714692968577_o.jpg', '115829682_3345399482178668_7710700474312287945_o.jpg', 'Yammy'),
('203', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('204', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('205', 'นางสาว', 'สุภิศรา', 'เตชนันท์', 'แยม', '5556667778889', '0956766976', 'supisra45.30@gmail.com', '2020-11-30', 21, 'ไทย', 'ไทย', 'นักศึกษา', 'เลขที่ 288 หมู่ที่ 5 ตำบล ริมกก อำเภอ เมืองเชียงราย จังหวัด เชียงราย 57100                        ', '115829682_3345399482178668_7710700474312287945_o.jpg', 'ข้อเสนอแนะบ้านพักพิงฟ้า.jpg', 'Yammy', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('206', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('207', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('306', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '0956722914', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `rule`
--

CREATE TABLE `rule` (
  `rule_detail` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rule`
--

INSERT INTO `rule` (`rule_detail`) VALUES
('1. ผู้เช่าจะต้องอยู่ครบ 6 เดือน พร้อมด้วยการแจ้งล่วงหน้าอย่างน้อย 1 เดือน ทางผู้ให้เช่าจึงจะคืนเงินประกันให้\r\n2. ผู้เช่าจะต้องชำระเงินค่าห้อง ค่าน้ำ และค่าไฟ ก่อนวันที่ 5 ของทุกเดือนหากจ่ายช้ากว่ากำหนดทางผู้เช่าจะเก็บวันละ 150 บาท หากผู้เช่าค้างชำระเกิน 15 วัน ทางผู้ให้เช่ามีสิทธิ์ให้ผู้เช่าออกโดยไม่คืนเงินประกัน\r\n3. ห้ามนำของผิดกฏหมายเข้ามาในห้องพักโดยเด็ดขาด และทางผู้ให้เช่าจะไม่รับผิดชอบใด ๆ ทั้งสิ้น\r\n4. ห้ามเปิด ทีวี เครื่องเสียง วิทยุ ส่งเสียงดัง หรือทำกิจกรรมใด ๆ ที่ทำให้เกิดเสียงดังรบกวนผู้อื่น\r\n5. ห้ามนำสัตว์เลี้ยงทุกชนิดเข้ามาเลี้ยงในห้องพักอย่างเด็ดขาด\r\n6.ห้ามก่อการทะเลาะวิวาท ภายในบริเวณหอพัก\r\n7. ห้ามดื่มสุรา สูบบุหรี่ และสิ่งเสพติดทุกชนิดภายในบริเวณหอพัก\r\n8. ห้ามเล่นการพนันทุกชนิดภายในห้องพัก\r\n9. ห้ามตอกตะปู ติดรูป สติ๊กเกอร์ ภายในห้องพัก และทรัพย์สินของทางหอพัก หายพบจะต้องเสียค่าปรับจุดละ 50 บาท\r\n10. กรณีที่ทำลูกกุญแจหาย ปรับ 100 บาท / ลูก และบัตรคีย์การ์ดหาย ปรับ 200 บาท / ใบ\r\n11. ห้ามประกอบอาหาร โดยใช้แก๊สหุงต้มโดยเด็ดขาด\r\n12. ปิดน้ำประปา และไฟฟ้าให้เรียบร้อยก่อนออกจากห้องพักทุกครั้ง\r\n13. ทางหอพักจะไม่รับผิดชอบทรัพย์สินมีค่าใด ๆ ในกรณีที่เกิดการสูญหาย\r\n14. ทางหอพักได้จัดเตรียม ตู้เสื้อผ้า เตียงนอน ที่นอนสปริง ผ้ารองกันเปื้อน ผ้าปูที่นอน โต๊ะทำงาน พัดลม เครื่องทำน้ำอุ่น และผ้าม่านให้ผู้เช่าไว้พร้อมในห้องพัก แต่ถ้าอุปกรณ์เครื่องใช้เกิดการชำรุด หรือเสียหาย ทางผู้ให้เช่าจะยึดเงินค่าประกัน และเรียกเก็บเพิ่มตามแต่เห็นสมควรของมูลค่าทรัพย์สิน-อุปกรณ์ ที่ชำรุดเสียหายนั้น\r\n15. ทางหอพักสามารถเข้าได้ตลอด 24 ชั่วโมง หากผู้เช่าเข้าหอพักหลังเวลา 20.00 น. ให้ล็อคกุญแจประตูใหญ่ด้านหน้าทุกครั้ง\r\n16. เพื่อความปลอดภัยของผู้เช่าห้องพัก ทางผู้ดูแลหอพักได้บันทึกภาพกล้องวงจรปิดไว้ตลอด 24 ชั่วโมง ห้ามกระทำการใด ๆ ที่ผิดกฎระเบียบฯ หรือผิดกฎหมายอย่างเด็ดขาด\r\n17. ขยะก่อนนำมาทิ้งให้ใส่ถุงขยะที่มีตราของเทศบาลตำบลหนองป่าครั่งเท่านั้น\r\n18. ห้องพักสามารถพักได้ไม่เกิน 2 คน และต้องแจ้งให้ผู้เช่าทราบก่อนทุกครั่ง หากฝ่าฝืนปรับ 200 บาท / วัน หรือให้ออกจากห้องพักทันที\r\n** หากผู้เช่าทำผิดกฎระเบียบข้างต้น ผู้ให้เช่ามีสิทธิ์ให้ออกโดยไม่คืนค่าประกันไม่ว่ากรณีใด ๆ **');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeal`
--
ALTER TABLE `appeal`
  ADD PRIMARY KEY (`appeal_id`);

--
-- Indexes for table `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`cost_id`);

--
-- Indexes for table `daily`
--
ALTER TABLE `daily`
  ADD PRIMARY KEY (`daily_id`);

--
-- Indexes for table `dailycost`
--
ALTER TABLE `dailycost`
  ADD PRIMARY KEY (`dailycost_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
  ADD PRIMARY KEY (`repair_id`);

--
-- Indexes for table `roomdetail`
--
ALTER TABLE `roomdetail`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `roomlist`
--
ALTER TABLE `roomlist`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `roommember`
--
ALTER TABLE `roommember`
  ADD PRIMARY KEY (`room_member`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appeal`
--
ALTER TABLE `appeal`
  MODIFY `appeal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cost`
--
ALTER TABLE `cost`
  MODIFY `cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `daily`
--
ALTER TABLE `daily`
  MODIFY `daily_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `dailycost`
--
ALTER TABLE `dailycost`
  MODIFY `dailycost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repair`
--
ALTER TABLE `repair`
  MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
