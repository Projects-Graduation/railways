-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2020 at 07:59 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railways`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `image` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'سنار', 'سنار انا والتاريخ بدء من هنا', 'city-20110702493426.jpg', '2020-11-07 14:49:34', '2020-11-07 14:49:34'),
(3, 'الجزيرة', 'الجيزة مدني', 'city-20111101494819.jpg', '2020-11-07 16:45:51', '2020-11-11 13:49:48'),
(4, 'الخرطوم', 'العاصمة المثلثة', NULL, '2020-11-07 16:46:03', '2020-11-07 16:46:03'),
(5, 'الابيض', 'عروس الرمال', 'city-20111007433255.jpg', '2020-11-10 19:43:32', '2020-11-10 19:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'الاقتصادية', '2020-11-07 21:31:40', '2020-11-07 21:31:40'),
(2, 'رجال الاعمال', '2020-11-07 21:31:54', '2020-11-07 21:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `level_train`
--

CREATE TABLE `level_train` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `ticket_price` float DEFAULT '0',
  `seats` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level_train`
--

INSERT INTO `level_train` (`id`, `level_id`, `train_id`, `ticket_price`, `seats`, `created_at`, `updated_at`) VALUES
(14, 2, 7, 500, 45, '2020-11-07 23:44:31', '2020-11-07 23:52:32'),
(15, 1, 7, 300, 20, '2020-11-07 23:53:04', '2020-11-07 23:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `address` text,
  `phone` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `name`, `address`, `phone`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'محمد عبدالله', 'سنار المدينة', '0912300000', 'ذكر', '2020-11-08 16:56:49', '2020-11-08 16:56:49'),
(2, 'علوية حسين', 'مدني', '0923098080', 'انثى', '2020-11-08 17:35:43', '2020-11-08 17:35:43'),
(3, 'علي نورين', 'الخرطوم', '09340950687', 'ذكر', '2020-11-08 17:36:12', '2020-11-08 17:36:12'),
(4, 'علي نورين', 'سنار المدينة', '0923098080', 'ذكر', '2020-11-09 12:21:55', '2020-11-09 12:21:55'),
(5, '', '', '', 'ذكر', '2020-11-09 12:24:20', '2020-11-09 12:24:20'),
(6, 'حسنة النور', 'سنار المدينة', '0923456789', 'انثى', '2020-11-09 12:25:33', '2020-11-09 12:25:33'),
(7, 'محمد عبدالله', 'سنار المدينة', '09340950687', 'ذكر', '2020-11-09 12:49:34', '2020-11-09 12:49:34'),
(8, 'علي نورين', 'مدني', '09340950687', 'ذكر', '2020-11-09 13:56:43', '2020-11-09 13:56:43'),
(9, 'علي نورين', 'مدني', '0923098080', 'ذكر', '2020-11-10 00:22:27', '2020-11-10 00:22:27'),
(10, 'حسنة النور', 'hg hgfkb', '0912300000', 'انثى', '2020-11-11 13:04:06', '2020-11-11 13:04:06'),
(11, 'حليمة سعد', 'مكة المكرمة', '0991234567', 'انثى', '2020-11-11 19:11:25', '2020-11-11 19:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--

CREATE TABLE `roads` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'شريان النيل', '2020-11-07 17:34:15', '2020-11-07 18:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `number` int(3) NOT NULL DEFAULT '1',
  `name` varchar(45) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `description` text,
  `city_id` int(11) NOT NULL,
  `road_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `number`, `name`, `image`, `description`, `city_id`, `road_id`, `created_at`, `updated_at`) VALUES
(10, 2, 'المناقل', 'station-20111004065624.jpg', 'المناقل', 3, 2, '2020-11-07 18:48:04', '2020-11-10 19:28:26'),
(11, 3, 'بحري', 'station-20111004065671.jpg', 'بحري', 4, 2, '2020-11-07 18:48:05', '2020-11-10 19:28:30'),
(12, 1, 'الدندر', 'station-20111004065698.jpg', 'الدندر', 1, 2, '2020-11-07 18:48:05', '2020-11-10 19:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `seat` int(11) DEFAULT '0',
  `price` float DEFAULT NULL,
  `passenger_id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `level_train_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `seat`, `price`, `passenger_id`, `travel_id`, `train_id`, `level_train_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 10, 500, 1, 2, 7, 14, 1, '2020-11-08 17:35:05', '2020-11-08 17:35:05'),
(4, 1, 300, 2, 2, 7, 15, 1, '2020-11-08 17:35:43', '2020-11-08 17:35:43'),
(5, 10, 300, 3, 2, 7, 15, 4, '2020-11-08 17:36:12', '2020-11-10 00:24:33'),
(6, 1, 500, 1, 2, 7, 14, 1, '2020-11-09 12:16:43', '2020-11-09 12:16:43'),
(7, 10, 500, 4, 2, 7, 14, 1, '2020-11-09 12:21:55', '2020-11-09 12:21:55'),
(8, 2, 500, 5, 2, 7, 14, 1, '2020-11-09 12:24:20', '2020-11-09 12:24:20'),
(9, 3, 500, 6, 2, 7, 14, 1, '2020-11-09 12:25:33', '2020-11-09 12:25:33'),
(11, 10, 500, 8, 1, 7, 14, 1, '2020-11-09 13:56:43', '2020-11-09 13:56:43'),
(12, 1, 500, 9, 1, 7, 14, 1, '2020-11-10 00:22:27', '2020-11-10 00:22:27'),
(13, 1, 500, 5, 2, 7, 14, 1, '2020-11-11 10:10:20', '2020-11-11 10:10:20'),
(14, 1, 500, 5, 2, 7, 14, 1, '2020-11-11 10:10:40', '2020-11-11 10:10:40'),
(15, 2, 300, 5, 2, 7, 15, 1, '2020-11-11 10:44:01', '2020-11-11 10:44:01'),
(16, 3, 300, 5, 2, 7, 15, 1, '2020-11-11 11:02:15', '2020-11-11 11:02:15'),
(17, 4, 300, 10, 2, 7, 15, 1, '2020-11-11 13:04:06', '2020-11-11 13:04:06'),
(18, 12, 500, 11, 2, 7, 14, 1, '2020-11-11 19:11:25', '2020-11-11 19:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `id` int(11) NOT NULL,
  `number` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`id`, `number`, `name`, `image`, `created_at`, `updated_at`) VALUES
(7, '0088', 'قطار المحبة', 'train-20110711013394.jpg', '2020-11-07 23:01:33', '2020-11-07 23:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `travels`
--

CREATE TABLE `travels` (
  `id` int(11) NOT NULL,
  `departure_time` varchar(45) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_mode` varchar(10) NOT NULL DEFAULT 'am',
  `arrival_time` varchar(45) DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_mode` varchar(10) NOT NULL DEFAULT 'am',
  `status` int(11) NOT NULL DEFAULT '1',
  `road_id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `travels`
--

INSERT INTO `travels` (`id`, `departure_time`, `departure_date`, `departure_mode`, `arrival_time`, `arrival_date`, `arrival_mode`, `status`, `road_id`, `train_id`, `created_at`, `updated_at`) VALUES
(1, '12:10', '2020-11-11', 'am', '8:10', '2020-11-11', 'pm', 1, 2, 7, '2020-11-08 00:37:34', '2020-11-10 01:32:00'),
(2, '01:30', '2020-11-12', 'pm', '12:30', '2020-11-12', 'pm', 1, 2, 7, '2020-11-08 11:15:21', '2020-11-10 00:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2020-11-07 11:33:02', '2020-11-07 12:55:45'),
(2, 'super', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2020-11-07 13:40:41', '2020-11-07 13:40:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_train`
--
ALTER TABLE `level_train`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_classes_has_trains_trains1_idx` (`train_id`),
  ADD KEY `fk_classes_has_trains_classes1_idx` (`level_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roads`
--
ALTER TABLE `roads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stations_cities_idx` (`city_id`),
  ADD KEY `fk_stations_roads1_idx` (`road_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tickets_passengers1_idx` (`passenger_id`),
  ADD KEY `fk_tickets_travels1_idx` (`travel_id`),
  ADD KEY `fk_tickets_trains1_idx` (`train_id`),
  ADD KEY `fk_tickets_class_train1_idx` (`level_train_id`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_travels_roads1_idx` (`road_id`),
  ADD KEY `fk_travels_trains1_idx` (`train_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level_train`
--
ALTER TABLE `level_train`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roads`
--
ALTER TABLE `roads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `trains`
--
ALTER TABLE `trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `level_train`
--
ALTER TABLE `level_train`
  ADD CONSTRAINT `fk_classes_has_trains_classes1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classes_has_trains_trains1` FOREIGN KEY (`train_id`) REFERENCES `trains` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `fk_stations_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stations_roads1` FOREIGN KEY (`road_id`) REFERENCES `roads` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_class_train1` FOREIGN KEY (`level_train_id`) REFERENCES `level_train` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_passengers1` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_trains1` FOREIGN KEY (`train_id`) REFERENCES `trains` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_travels1` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `travels`
--
ALTER TABLE `travels`
  ADD CONSTRAINT `fk_travels_roads1` FOREIGN KEY (`road_id`) REFERENCES `roads` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_travels_trains1` FOREIGN KEY (`train_id`) REFERENCES `trains` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
