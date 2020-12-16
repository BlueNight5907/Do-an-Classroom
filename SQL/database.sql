-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2020 at 11:54 PM
-- Server version: 8.0.20
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MobileDatabase`
-- drop database classroom
--
CREATE DATABASE IF NOT EXISTS `ClassRoom` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `ClassRoom`;


-- Tao bang account nguoi dung


CREATE TABLE `account` (
  `Ho` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Ten` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  NgaySinh date not null,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` bit(1) DEFAULT  b'0',
  `activate_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  userIMG varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '\\Public\\img\\user.png',
  primary key(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Do du lieu
insert into `account` values
(N'Nguyen Van',N'Huy','2000/11/18','henrypoter222@gmail.com','admin','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user2.jpg'),
(N'Nguyen Van',N'Hoa','2000/11/18','yeuthatxa136@gmail.com','admin1','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.png'),
(N'Nguyen Van',N'Chuong','2000/11/18','henrypoter2222@gmail.com','admin2','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user3.png'),
(N'Nguyen Van',N'Teo','2000/11/18','henrypoter2233@gmail.com','admin3','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user4.jpg'),
(N'Trần Thị',N'Hà','2000/11/18','henrypoter2244@gmail.com','admin4','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','123456','Public/img/user5.jpg'),
(N'Nguyen Van',N'Long','2000/11/18','henrypoter2255@gmail.com','admin5','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.jfif'),
(N'Nguyen Van',N'Hóa','2000/11/18','henrypoter2266@gmail.com','admin6','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.jfif'),
(N'Lê Văn','Quý',N'2000/11/18','abcd@gmail.com','usertest1','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user5.jpg'),
(N'Lê Thị','Mai',N'2000/11/18','abcde@gmail.com','usertest2','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif'),
(N'Trần Trọng',N'Tín','2000/11/18','abcdef@gmail.com','usertest3','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user4.jpg'),
(N'Hoàng Thị',N'Xuyến','2000/11/18','abcdefgh@gmail.com','usertest4','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif'),
(N'Trần Ngọc',N'Đào','2000/11/18','abcde123@gmail.com','usertest5','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user3.png'),
(N'Đào Văn',N'Mạnh','2000/11/18','abcde456@gmail.com','usertest6','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif');



-- --------------------------------
-- Tao bang phan quyen nguoi dung

CREATE TABLE `PhanQuyen` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL references account(username),
  `vaitro` int, -- 1 la admin 2 la giao vien 3 la hoc sinh
  primary key(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Do du lieu

insert into phanquyen values
('admin',1),
('admin1',2),
('admin2',1),
('admin3',2),
('admin4',2),
('admin5',2),
('usertest1',3),
('usertest2',3),
('usertest3',3),
('usertest4',3),
('usertest5',3),
('usertest6',3);
-- -----------------------------------------------------
-- Tao bang reset token

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Do du lieu



-- --------------------------------------------------------

-- Tao bang lop hoc

CREATE TABLE LopHoc (
  NguoiTao varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  MaLopHoc varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  TenLopHoc varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  MonHoc varchar(255) COLLATE utf8_unicode_ci default NULL,
  PhongHoc varchar(255) COLLATE utf8_unicode_ci default NULL,
  AnhDaiDien varchar(255) COLLATE utf8_unicode_ci default NULL,
  activated bit(1) DEFAULT  b'1',
  primary key(Malophoc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Do du lieu
insert into LopHoc values
('admin1','1ab',N'LAP_TRINH_WEB_VA_UD_HK1_2020',N'Lập trình web','B102','Public/backgroundIMG/background.jpg',b'1'),
('admin','2ab',N'Kỹ năng viết và trình bày',N'Kỹ năng','B103','Public/backgroundIMG/background2.jpg',b'1'),
('admin2','3ab',N'Cấu trúc dữ liệu và giải thuật',N'CTDL1','B104','Public/backgroundIMG/background3.png',b'1'),
('admin1','4ab',N'VOVINAM',N'Thể chất',N'Nhà thi đấu','Public/backgroundIMG/background4.jpg',b'1'),
('admin2','5ab',N'Bơi lội',N'Thể chất','B106','Public/backgroundIMG/background5.jpg',b'1'),
('admin2','6ab',N'Xác suất thống kê',N'Toán','B107','Public/backgroundIMG/background6.jpg',b'1');


-- -----------------------------------------------------


-- Tao bang phan quyen nguoi dung

CREATE TABLE ThamGiaLopHoc(
    JoinClassID varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    MaLopHoc varchar(255) COLLATE utf8_unicode_ci NOT NULL references LopHoc(MaLopHoc),
    username varchar(64) COLLATE utf8_unicode_ci NOT NULL,
    vaitro int check(vaitro >0 and vaitro <4), --  1 la giao vien tham gia, 2 la hoc vien
    activated bit(1) DEFAULT  b'1',
    primary key(malophoc,username,vaitro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Do du lieu
insert into ThamGiaLopHoc values
('1','1ab','admin1',1,b'1'),
('2','2ab','admin1',2,b'1'),
('3','2ab','admin',1,b'1'),
('4','2ab','admin2',2,b'1'),
('5','3ab','admin3',2,b'1'),
('6','3ab','admin2',1,b'1'),
('7','4ab','admin1',1,b'1'),
('8','5ab','admin2',1,b'1'),
('9','6ab','admin2',1,b'1'),
('10','1ab','admin2',2,b'1'),
('11','1ab','admin3',2,b'1'),
('12','1ab','admin4',3,b'1'),
('13','1ab','admin5',3,b'1'),
('20','2ab','usertest1',3,b'1'),
('21','2ab','usertest2',3,b'1'),
('22','2ab','usertest3',3,b'1'),
('23','2ab','usertest4',3,b'1'),
('24','2ab','usertest5',3,b'1'),
('25','2ab','usertest6',3,b'1'),
('26','3ab','usertest1',3,b'1'),
('27','3ab','usertest2',3,b'1'),
('28','3ab','usertest3',3,b'1'),
('29','3ab','usertest4',3,b'1'),
('30','3ab','usertest5',3,b'1'),
('31','3ab','usertest6',3,b'1'),
('32','4ab','usertest1',3,b'1'),
('33','4ab','usertest2',3,b'1'),
('34','4ab','usertest3',3,b'1'),
('35','4ab','usertest4',3,b'1'),
('36','4ab','usertest5',3,b'1'),
('37','4ab','usertest6',3,b'1'),
('38','5ab','usertest1',3,b'1'),
('39','5ab','usertest2',3,b'1'),
('40','5ab','usertest3',3,b'1'),
('41','5ab','usertest4',3,b'1'),
('42','5ab','usertest5',3,b'1'),
('43','5ab','usertest6',3,b'1'),
('44','6ab','usertest1',3,b'1'),
('45','6ab','usertest2',3,b'1'),
('46','6ab','usertest3',3,b'1'),
('47','6ab','usertest4',3,b'1'),
('48','6ab','usertest5',3,b'1'),
('49','6ab','usertest6',3,b'1');

-- ------------------------------------------

-- tao bang tham gia lop hoc cho giao vien bang email

CREATE TABLE `attend_class_token` (
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL references account(username),
  MaLopHoc varchar(64) COLLATE utf8_unicode_ci NOT NULL references LopHoc(MaLopHoc),
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




-- -----------------------------------------------------

-- Xet tham gia lop hoc

CREATE TABLE XetSVThamGiaLopHoc (
  ID varchar(255) COLLATE utf8_unicode_ci primary key,
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL references account(username),
  MaLopHoc varchar(64) COLLATE utf8_unicode_ci NOT NULL references LopHoc(MaLopHoc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Đổ dữ liệu

insert into XetSVThamGiaLopHoc values
('jfjgdshfjgdsjfgjs','usertest2','1ab'),
('jdshfksfkgdsjfgjs','usertest3','1ab'),
('iryirhwrhwjkhrwww','usertest4','1ab'),
('DKFSFjkdhffhfgrrr','usertest5','1ab'),
('WLUROWNVKHSFHIRUG','usertest6','1ab');

-- -----------------------------------------------------

-- Bang dang bai

CREATE TABLE DangBai (
  PostID varchar(255) COLLATE utf8_unicode_ci primary key,
  MaLopHoc varchar(64) COLLATE utf8_unicode_ci NOT NULL references LopHoc(MaLopHoc),
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL references account(username),
  NoiDung varchar(500) COLLATE utf8_unicode_ci ,
  ThoiGian int,
  DinhKem bit(1) DEFAULT  b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;