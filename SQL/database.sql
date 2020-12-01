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
('Nguyen Van','Huy','2000/11/18','henrypoter22@gmail.com','admin','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user2.jpg'),
('Nguyen Van','Hoa','2000/11/18','yeuthatxa136@gmail.com','admin1','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.png'),
('Nguyen Van','Chuong','2000/11/18','henrypoter2222@gmail.com','admin2','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user3.png'),
('Nguyen Van','Teo','2000/11/18','henrypoter2233@gmail.com','admin3','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user4.jpg'),
('Nguyen Van','Hot vit lon','2000/11/18','henrypoter2244@gmail.com','admin4','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','123456','Public/img/user5.jpg'),
('Nguyen Van','Long','2000/11/18','henrypoter2255@gmail.com','admin5','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.jfif'),
('Nguyen Van','Hóa','2000/11/18','henrypoter2266@gmail.com','admin6','$2y$10$4kHhPKNZNR7ch0B/MWT4cuqG2BO/Ra9jV6Q9PzaXaLZm.SUtUZUqa',b'1','admin','Public/img/user.jfif'),
('Lê Văn','Quý','2000/11/18','abcd@gmail.com','usertest1','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user5.jpg'),
('Lê Thị','Mai','2000/11/18','abcde@gmail.com','usertest2','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif'),
('Trần Trọng','Tín','2000/11/18','abcdef@gmail.com','usertest3','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user4.jpg'),
('Hoàng Thị','Xuyến','2000/11/18','abcdefgh@gmail.com','usertest4','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif'),
('Trần Ngọc','Đào','2000/11/18','abcde123@gmail.com','usertest5','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user3.png'),
('Đào Văn','Mạnh','2000/11/18','abcde456@gmail.com','usertest6','$2y$10$lZ9o3DjAgprEGvgQcmpdzu0HX8IjStMzZKlOSlqgvXH2uthmpkvky',b'1','noname123456','Public/img/user.jfif');



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
('admin1','1ab','Lop hoc tinh yeu',N'Đạo đức','B102','Public/backgroundIMG/background.jpg',b'1'),
('admin','2ab','Lop hoc tinh ban',N'Đạo đức','B103','Public/backgroundIMG/background2.jpg',b'1'),
('admin2','3ab','Lop hoc tinh thuong',N'Đạo đức','B104','Public/backgroundIMG/background3.png',b'1'),
('admin1','4ab','Lop hoc tinh doi',N'Đạo đức','B105','Public/backgroundIMG/background4.jpg',b'1'),
('admin2','5ab','Lop hoc tinh ngay tho',N'Đạo đức','B106','Public/backgroundIMG/background5.jpg',b'1'),
('admin2','6ab','Lop hoc tinh gia dinh',N'Đạo đức','B107','Public/backgroundIMG/background6.jpg',b'1');


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
('14','1ab','usertest1',3,b'1'),
('15','1ab','usertest2',3,b'1'),
('16','1ab','usertest3',3,b'1'),
('17','1ab','usertest4',3,b'1'),
('18','1ab','usertest5',3,b'1'),
('19','1ab','usertest6',3,b'1'),
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
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL references account(username),
  MaLopHoc varchar(64) COLLATE utf8_unicode_ci NOT NULL references LopHoc(MaLopHoc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
