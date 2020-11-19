-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 08:47 PM
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
-- Table structure for table `cost`
--

CREATE TABLE `cost` (
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

INSERT INTO `cost` (`room_id`, `type`, `cost_status`, `date`, `room_cost`, `water_bill`, `elec_bill`, `cable_charge`, `fines`, `total`) VALUES
('201', '', 'ชำระเงินแล้ว', '2020-09', 2700.00, 80.00, 600.00, 105.00, 150.00, '3635'),
('202', '', 'ชำระเงินแล้ว', '2020-09', 2700.00, 80.00, 375.00, 105.00, 150.00, '3410'),
('201', '', 'ชำระเงินแล้ว', '2020-10', 2700.00, 160.00, 750.00, 105.00, 150.00, '3715');

-- --------------------------------------------------------

--
-- Table structure for table `daily`
--

CREATE TABLE `daily` (
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `id_card` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `check_in` varchar(255) DEFAULT NULL,
  `check_out` varchar(255) DEFAULT NULL,
  `daily_status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily`
--

INSERT INTO `daily` (`firstname`, `lastname`, `id_card`, `email`, `tel`, `room_type`, `code`, `check_in`, `check_out`, `daily_status`) VALUES
('พงศธร', 'สร้อยอินต๊ะ', '1509966666667', 'sss@gmail.com', '098-8884444', 'แอร์', 'ABCDEFGHIJ', '2020-11-12', '2020-11-14', 'เข้าพักแล้ว'),
('นวพล', 'นรเดชานันท์', '1509966011521', 'blackfrostier@gmail.com', '095-6722914', 'พัดลม', 'KLMNOPQRST', '2020-11-12', '2020-11-13', 'เข้าพักแล้ว'),
('เกม', 'เกม2', '1509966011522', 'fdfd@gmail.com', '098-5556666', 'แอร์', 'ABCDEF', '2020-11-15', '2020-11-18', 'เข้าพักแล้ว');

-- --------------------------------------------------------

--
-- Table structure for table `dailycost`
--

CREATE TABLE `dailycost` (
  `room_id` varchar(200) NOT NULL,
  `check_in` varchar(200) NOT NULL,
  `check_out` varchar(200) NOT NULL,
  `price_total` float(11,2) NOT NULL,
  `daily_status` varchar(200) NOT NULL,
  `code` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dailycost`
--

INSERT INTO `dailycost` (`room_id`, `check_in`, `check_out`, `price_total`, `daily_status`, `code`) VALUES
('207', '2020-11-12', '2020-11-13', 250.00, 'ชำระเงินแล้ว', 'KLMNOPQRST');

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
(3, 'นาย', 'นวพล', 'นรเดชานันท์', 'เกม', 'พนักงาน', '1509966011521', '0956722914', 'blackfrostier@gmail.com', 'blackfrostier', '1998-12-21', '21', 'ไทย', 'ไทย', '140/40 หมู่ 2 ต. หนองป่าครั่ง อ.เมือง จ.เชียงใหม่ 50000', '404365.jpg', '115742121_3369166353135314_4310419490959465258_o.jpg', '115774657_3345395698845713_2446905765721859802_o.jpg', 'nwpgm82', 'ef16b5fe40a49934ad40c0b059090b14'),
(10, 'นางสาว', 'สุภิศรา', 'เตชนันท์', 'แยม', 'พนักงาน', '5556667778889', '0620477145', 'supisra45.30@gmail.com', 'Yammy', '1999-04-22', '21', 'ไทย', 'ไทย', 'เลขที่ 288 หมู่ที่ 5 ตำบล ริมกก อำเภอ เมืองเชียงราย จังหวัด เชียงราย 57100', 'Rabbit-01.jpg', 'rabbit.jpg', '117094314_3466888280022757_1501037714692968577_o.jpg', 'Yammy', 'c0af69b0f68cf6a0560f8c51e26b82bb'),
(14, 'นาย', 'คอตต้อน', 'กระต่ายป่า', 'คอตต้อน', 'พนักงาน', '1112223334444', '095-5555555', 'cotton@gmail.com', 'cotton', '2018-10-01', '3', 'ไทย', 'ไทย', 'ห้อง B421 หอพักมุกไพลินแม่โจ้', 'Rabbit-01.jpg', 'rabbit.jpg', '115829682_3345399482178668_7710700474312287945_o.jpg', 'cotton', 'a452dd6aa39265d21240ca1718cd96f8');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `level`) VALUES
('admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
('nwpgm82', 'ef16b5fe40a49934ad40c0b059090b14', 'employee'),
('Yammy', 'c0af69b0f68cf6a0560f8c51e26b82bb', 'employee'),
('cotton', 'a452dd6aa39265d21240ca1718cd96f8', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_num` varchar(200) NOT NULL,
  `package_company` varchar(200) NOT NULL,
  `package_arrived` varchar(200) NOT NULL,
  `package_status` varchar(200) NOT NULL,
  `package_name` varchar(200) NOT NULL,
  `package_room` varchar(200) NOT NULL,
  `package_received` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_num`, `package_company`, `package_arrived`, `package_status`, `package_name`, `package_room`, `package_received`) VALUES
('AAASSSSDDD', 'Kerry', '2020-10-04', 'ยังไม่ได้รับพัสดุ', 'สุภิศรา', '202', ''),
('DDDDSSSAA', 'Kerry', '2020-10-04', 'ยังไม่ได้รับพัสดุ', 'phongtorn', '201', ''),
('BBBBBBBBBB', 'shopee', '2020-10-03', 'ยังไม่ได้รับพัสดุ', 'phongtorn', '201', ''),
('TTTTT1213123123123123123123123112312312', 'Kerry', '2020-11-06', 'รับพัสดุแล้ว', 'นวพล', '201', 'นวพล');

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair` (
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

INSERT INTO `repair` (`room_id`, `repair_appliance`, `repair_category`, `repair_detail`, `repair_date`, `repair_status`) VALUES
('201', 'พัดลม', 'เครื่องใช้ไฟฟ้า', 'ใบพัดเสีย', '2020-09-29', 'ดำเนินการเสร็จสิ้น'),
('201', 'เครื่องทำน้ำอุ่น', 'เครื่องใช้ไฟฟ้า', 'น้ำไม่ร้อน', '2020-09-30', 'กำลังดำเนินการ'),
('202', 'ตู้เสื้อผ้า', 'เฟอร์นิเจอร์', 'ราวแขวนผ้าชำรุด', '2020-10-01', 'รอดำเนินการ'),
('201', 'โต๊ะ', 'เฟอร์นิเจอร์', 'ขาโต๊ะหัก', '2020-10-04', 'รอดำเนินการ'),
('201', 'หลอดไฟ', 'เครื่องใช้ไฟฟ้า', 'ไฟเปิดไม่ติด', '2020-10-05', 'รอดำเนินการ'),
('202', 'ประตู', 'เฟอร์นิเจอร์', 'ลูกบิดประตูเสีย', '2020-10-05', 'รอดำเนินการ'),
('202', 'ชักโครก', 'สุขภัณฑ์', 'ฝาชักโครกแตก', '2020-10-05', 'รอดำเนินการ'),
('201', 'อ่างล้างหน้า', 'สุขภัณฑ์', 'อ่างล้างหน้าแตก', '2020-10-05', 'ดำเนินการเสร็จสิ้น');

-- --------------------------------------------------------

--
-- Table structure for table `roomdailylist`
--

CREATE TABLE `roomdailylist` (
  `room_id` varchar(200) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `check_in` varchar(200) DEFAULT NULL,
  `check_out` varchar(200) DEFAULT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomdailylist`
--

INSERT INTO `roomdailylist` (`room_id`, `room_type`, `check_in`, `check_out`, `status`) VALUES
('2101', 'แอร์', '2020-11-11', '2020-11-12', 'ไม่ว่าง'),
('2102', 'แอร์', NULL, NULL, 'ว่าง'),
('2103', 'แอร์', NULL, NULL, 'ว่าง'),
('2104', 'พัดลม', NULL, NULL, 'ว่าง'),
('2105', 'พัดลม', NULL, NULL, 'ว่าง'),
('2106', 'พัดลม', NULL, NULL, 'ว่าง');

-- --------------------------------------------------------

--
-- Table structure for table `roomdetail`
--

CREATE TABLE `roomdetail` (
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `water_bill` float(255,2) DEFAULT NULL,
  `elec_bill` float(255,2) DEFAULT NULL,
  `cable_charge` float(255,2) DEFAULT NULL,
  `fines` float(255,2) DEFAULT NULL,
  `price` float(255,2) DEFAULT NULL,
  `pic1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic6` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `daily_price` float(255,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roomdetail`
--

INSERT INTO `roomdetail` (`type`, `water_bill`, `elec_bill`, `cable_charge`, `fines`, `price`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `pic6`, `detail`, `daily_price`) VALUES
('พัดลม', 80.00, 7.50, 105.00, 150.00, 2300.00, 'sub8.jpg', NULL, NULL, NULL, NULL, NULL, 'ห้องพัดลม 2300', 250.00),
('แอร์', 80.00, 7.50, 105.00, 150.00, 2700.00, 'sub2.jpg', NULL, NULL, NULL, NULL, NULL, 'ห้องแอร์ 2700 บาท', 350.00);

-- --------------------------------------------------------

--
-- Table structure for table `roomlist`
--

CREATE TABLE `roomlist` (
  `room_id` varchar(3) NOT NULL,
  `room_type` varchar(10) NOT NULL,
  `room_status` varchar(10) NOT NULL,
  `come` varchar(255) DEFAULT NULL,
  `check_in` varchar(255) DEFAULT NULL,
  `check_out` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomlist`
--

INSERT INTO `roomlist` (`room_id`, `room_type`, `room_status`, `come`, `check_in`, `check_out`) VALUES
('202', 'แอร์', 'ว่าง', '', NULL, NULL),
('203', 'แอร์', 'เช่ารายวัน', NULL, '2020-11-12', '2020-11-14'),
('204', 'แอร์', 'ว่าง', '', NULL, NULL),
('205', 'แอร์', 'เช่ารายวัน', NULL, '2020-11-15', '2020-11-18'),
('206', 'พัดลม', 'ว่าง', '', NULL, NULL),
('207', 'พัดลม', 'เช่ารายวัน', '', '2020-11-12', '2020-11-13'),
('208', 'แอร์', 'ว่าง', '', NULL, NULL),
('301', 'แอร์', 'เช่ารายวัน', '', '2020-11-12', '2020-11-14'),
('302', 'แอร์', 'ว่าง', '', NULL, NULL),
('303', 'แอร์', 'ว่าง', '', NULL, NULL),
('304', 'แอร์', 'ว่าง', '', NULL, NULL),
('305', 'แอร์', 'ว่าง', '', NULL, NULL),
('306', 'พัดลม', 'ว่าง', '', NULL, NULL),
('307', 'แอร์', 'ว่าง', '', NULL, NULL),
('308', 'แอร์', 'ว่าง', '', NULL, NULL),
('201', 'แอร์', 'ไม่ว่าง', '2020/11/16', NULL, NULL);

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
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('301', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', 'Rabbit-01.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('203', '', 'พงศธร', 'สร้อยอินต๊ะ', '', '1509966666667', '098-888444', 'sss@gmail.com', '', 0, '', '', '', '', '404365.jpg', NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('205', '', 'เกม', 'เกม2', '', '1509966011522', '098-555666', 'fdfd@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('207', '', 'นวพล', 'นรเดชานันท์', '', '1509966011521', '095-672291', 'blackfrostier@gmail.com', '', 0, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', 0, '', '', '', '', NULL, NULL, ''),
('201', 'นางสาว', 'สุภิศรา', 'เตชนันท์', 'แยม', '4445556667778', '0620477145', 'supisra45.30@gmail.com', '1999-04-22', 21, 'ไทย', 'ไทย', 'นักศึกษา', 'เลขที่ 288 หมู่ที่ 5 ตำบล ริมกก อำเภอ เมืองเชียงราย จังหวัด เชียงราย 57100                        ', '117094314_3466888280022757_1501037714692968577_o.jpg', 'rabbit.jpg', 'Yammy', 'นาย', 'นวพล', 'นรเดชานันท์', 'เกม', '6665558889999', '0956722914', 'blackfrostier@gmail.com', '1998-12-21', 21, 'ไทย', 'ไทย', 'นักศึกษา', '140/40 หมู่2 ต.หนองป่าครั่ง อ.เมือง จ.เชียงใหม่ 50000                                                                                                                        ', '115774657_3345395698845713_2446905765721859802_o.jpg', '115742121_3369166353135314_4310419490959465258_o.jpg', 'blackfrostier');

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
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomdailylist`
--
ALTER TABLE `roomdailylist`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `roomdetail`
--
ALTER TABLE `roomdetail`
  ADD PRIMARY KEY (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
