-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2022 at 04:38 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

CREATE Database ct275_project;
USE ct275_project;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ct275_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `hd_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `kh_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `id` int(11) NOT NULL,
  `ngaylap` date NOT NULL,
  `trangthai` char(1) NOT NULL,
  `kh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `info_giohang`
-- (See below for the actual view)
--
CREATE TABLE `info_giohang` (
`id` int(11)
,`tensanpham` varchar(40)
,`so_luong` int(11)
,`gia` int(11) unsigned
,`hinh_anh` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `matkhau` varchar(100) NOT NULL,
  `hoten` varchar(40) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` char(10) NOT NULL,
  `sdt` char(10) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `vai_tro` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id`, `email`, `matkhau`, `hoten`, `ngaysinh`, `gioitinh`, `sdt`, `diachi`, `vai_tro`) VALUES
(1, 'dohuyrw@gmail.com', '12345678', 'Đỗ Thái Gia Huy', '2001-12-18', 'Nam', '0932988029', '32/17,......', 0),
(2, 'student@cit.ctu.edu.vn', '12345678', 'Nguyễn Văn A', '2022-10-30', 'Nam', '0971726621', '12', 0),
(4, 'giahuydo18@gmail.com', '123er23', 'huy do', '2022-11-11', 'Nam', '0982772661', '32', 0),
(7, 'b1892@cit.ctu.edu.vn', '12345678', 'Nguyễn Văn A', '2000-11-01', 'Nam', '0932988567', '12', 0),
(9, 'mia@gmail.com', '123456789', 'Nguyễn Thị Xuân Mai', '2001-11-03', 'Nam', '0928192881', '12/867', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `id` int(11) NOT NULL,
  `tenloai` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaisanpham`
--

INSERT INTO `loaisanpham` (`id`, `tenloai`) VALUES
(1, 'Kính mát'),
(2, 'Kính thường'),
(3, 'Kính cận');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(11) NOT NULL,
  `tensanpham` varchar(40) NOT NULL,
  `gia` int(11) UNSIGNED NOT NULL,
  `kich_thuoc` varchar(50) NOT NULL,
  `mo_ta` text NOT NULL,
  `nhan_hieu` varchar(50) NOT NULL,
  `hinh_anh` varchar(100) DEFAULT 'no-image-available.png',
  `gioi_tinh` varchar(100) NOT NULL,
  `loai_id` int(11) NOT NULL,
  `giam_gia` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `tensanpham`, `gia`, `kich_thuoc`, `mo_ta`, `nhan_hieu`, `hinh_anh`, `gioi_tinh`, `loai_id`, `giam_gia`) VALUES
(1, 'Mắt kính nam thời trang', 1000000, '20x30', 'Chất liệu titanium cao cấp nay có thêm kiểu dáng club master cho các anh em thoải mái với mọi lựa chọn.', 'Ray-band', 'no-image-available.png', 'Nam', 1, 10),
(8, 'Kính mát nữ thời trang', 2000000, '12x15', 'Chất liệu cao cấp', 'Channel', 'no-image-available.png', 'Nữ', 1, 0),
(25, 'fsdfsd', 112, '23x32', 'ádfasdfasfasdf', 'Ray-band', 'no-image-available.png', 'Nam', 2, 0);

-- --------------------------------------------------------

--
-- Structure for view `info_giohang`
--
DROP TABLE IF EXISTS `info_giohang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `info_giohang`  AS SELECT `g`.`id` AS `id`, `s`.`tensanpham` AS `tensanpham`, `g`.`so_luong` AS `so_luong`, `s`.`gia` AS `gia`, `s`.`hinh_anh` AS `hinh_anh` FROM ((`giohang` `g` join `khachhang` `k` on(`g`.`kh_id` = `k`.`id`)) join `sanpham` `s` on(`g`.`sp_id` = `s`.`id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`),
  ADD KEY `hd_id` (`hd_id`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`),
  ADD KEY `kh_id` (`kh_id`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kh_id` (`kh_id`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `sdt` (`sdt`);

--
-- Indexes for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loai_id` (`loai_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `FK_chitiethoadon_hoadon` FOREIGN KEY (`hd_id`) REFERENCES `hoadon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_chitiethoadon_sanpham` FOREIGN KEY (`sp_id`) REFERENCES `sanpham` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `FK__khachhang` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__sanpham` FOREIGN KEY (`sp_id`) REFERENCES `sanpham` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`id`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`loai_id`) REFERENCES `loaisanpham` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
