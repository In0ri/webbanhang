-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 06, 2019 lúc 04:07 AM
-- Phiên bản máy phục vụ: 10.1.37-MariaDB
-- Phiên bản PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `level` tinyint(4) DEFAULT '1',
  `avatar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `address`, `email`, `password`, `phone`, `status`, `level`, `avatar`, `created_at`, `updated_at`) VALUES
(9, 'Hoàng Trung Nguyên', 'Đồng Hưu Yên Thế Bắc Giang', 'htnguyenbg@gmail.com', '202cb962ac59075b964b07152d234b70', '359686959', 1, 1, NULL, '2019-02-01 17:58:49', '2019-02-01 17:58:49'),
(10, 'Hoàng Minh Ngọc', 'Đồng Hưu Yên Thế Bắc Giang', 'htnguyenbg98@gmail.com', '4297f44b13955235245b2497399d7a93', '359686959', 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `images` varchar(100) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `home` tinyint(4) DEFAULT '0',
  `status` tinyint(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `images`, `banner`, `home`, `status`, `created_at`, `update_at`) VALUES
(36, 'Dell', 'dell', NULL, NULL, 0, 1, '2019-02-04 05:16:52', '2019-02-04 05:16:52'),
(37, 'Apple', 'apple', NULL, NULL, 1, 1, '2019-02-04 05:20:40', '2019-02-04 05:20:40'),
(48, 'SAMSUNG', 'samsung', NULL, NULL, 1, 1, '2019-02-03 18:58:21', '2019-02-03 18:58:21'),
(49, 'OPPO', 'oppo', NULL, NULL, 1, 1, '2019-02-04 05:23:05', '2019-02-04 05:23:05'),
(50, 'HP', 'hp', NULL, NULL, 1, 1, '2019-02-04 05:23:06', '2019-02-04 05:23:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `transaction_id`, `product_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(10, 36, 65, 1, 5000000, NULL, NULL),
(11, 37, 63, 1, 16150000, NULL, NULL),
(12, 38, 64, 1, 25000000, NULL, NULL),
(13, 38, 61, 1, 15200000, NULL, NULL),
(14, 39, 63, 1, 16150000, NULL, NULL),
(15, 39, 0, 3, 0, NULL, NULL),
(16, 40, 65, 1, 5000000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `sale` tinyint(4) DEFAULT '0',
  `thunbar` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` text,
  `head` tinyint(4) DEFAULT '0',
  `view` int(11) DEFAULT '0',
  `hot` int(11) DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `number` int(11) DEFAULT '0',
  `pay` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `slug`, `price`, `sale`, `thunbar`, `category_id`, `content`, `head`, `view`, `hot`, `updated_at`, `created_at`, `number`, `pay`) VALUES
(61, 'Iphone 7 Red', 'iphone-7-red', 16000000, 5, 'iphone 7 red.jpg', 37, 'Hàng chính hãng', 0, 0, 0, '2019-02-11 17:44:48', '2019-02-11 17:44:48', 12, NULL),
(62, 'Dell132658', 'dell132658', 16000000, 10, 'dell-vostro-5568.png', 36, 'Hàng chính hãng', 0, 0, 0, '2019-02-11 17:24:15', '2019-02-11 17:24:15', 20, NULL),
(63, 'S8+', 's8', 19000000, 15, 's8.jpg', 48, 'Hàng chính hãng', 0, 0, 0, '2019-02-11 17:54:49', '2019-02-11 17:54:49', 11, 1),
(64, 'Iphone X', 'iphone-x', 25000000, 0, 'iphone-x-256gb.jpg', 37, 'Hàng chính hãng', 0, 0, 0, '2019-02-11 17:44:48', '2019-02-11 17:44:48', 4, NULL),
(65, 'Galaxy A7', 'galaxy-a7', 5000000, 0, 'samsung-galaxy-a7.jpg', 48, 'Hàng chính hãng', 0, 0, 0, NULL, NULL, 12, NULL),
(66, 'OPPO Find X', 'oppo-find-x', 9000000, 0, 'oppo-find-x-1.jpg', 49, 'Hàng xách tay', 0, 0, 0, '2019-02-11 17:24:33', '2019-02-11 17:24:33', 21, NULL),
(67, 'Pavilon 15-au96', 'pavilon-15-au96', 18000000, 0, 'u_10180942.jpg', 50, 'Hàng xách tay', 0, 0, 0, NULL, NULL, 5, NULL),
(69, 'Pavilon 15-au96 puple', 'pavilon-15-au96-puple', 18500000, 0, 'u_10180958.jpg', 50, 'Hàng xách tay', 0, 0, 0, NULL, NULL, 5, NULL),
(70, 'Iphone XS', 'iphone-xs', 20000000, 10, 'iphone-xs-gold-600x860.jpg', 37, 'Hàng chính hãng', 0, 0, 0, '2019-02-03 19:26:02', '2019-02-03 19:26:02', 5, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text,
  `price` int(50) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`id`, `amount`, `users_id`, `status`, `created_at`, `updated_at`, `note`, `price`, `transaction_id`, `product_id`, `qty`) VALUES
(37, 17765000, 34, 1, '2019-02-11 17:30:43', '2019-02-11 17:41:03', '', NULL, NULL, NULL, NULL),
(38, 44220000, 34, 1, '2019-02-11 17:44:41', '2019-02-11 17:44:48', '', NULL, NULL, NULL, NULL),
(39, 17765000, 34, 1, '2019-02-11 17:51:48', '2019-02-11 17:54:49', '', NULL, NULL, NULL, NULL),
(40, 5500000, 34, 0, '2019-02-12 08:13:44', '2019-02-12 08:13:44', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `token` varchar(50) DEFAULT NULL,
  `vip` tinyint(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `account` int(50) DEFAULT '0',
  `hanvip` date DEFAULT NULL,
  `ngaytaovip` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `avatar`, `status`, `token`, `vip`, `created_at`, `updated_at`, `account`, `hanvip`, `ngaytaovip`) VALUES
(24, 'Hoàng Minh Ngọc', 'ngocbaigianh@gmail.com', '359686959', 'Đồng Hưu Yên Thế Bắc Giang', '4297f44b13955235245b2497399d7a93', NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(25, 'Hoàng Đức Nguyễn', 'ducnguyen@gmail.com', '359686959', 'Đồng Hưu Yên Thế Bắc Giang', '4297f44b13955235245b2497399d7a93', NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(26, 'Nguyễn Thị Lan Hương', 'lanhuong@gmail.com', '359686959', 'Đồng Hưu - Yên Thế - Bắc Giang', '4297f44b13955235245b2497399d7a93', NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(34, 'Hoàng Trung Nguyên', 'htnguyenbg98@gmail.com', '0359686959', 'Đồng Hưu - Yên Thế - Bắc Giang', '4297f44b13955235245b2497399d7a93', NULL, 1, NULL, 1, '2019-02-21 07:55:05', '2019-02-21 07:55:05', 988489508, '2020-02-21', '2019-02-21'),
(35, 'Hoàng Trung Hòa', 'trunghoa@gmail.com', '359686959', 'Đồng Hưu Yên Thế Bắc Giang', '4297f44b13955235245b2497399d7a93', NULL, 1, NULL, 0, '2019-02-13 02:47:12', '2019-02-13 02:47:12', 20492, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
