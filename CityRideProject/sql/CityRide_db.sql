-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2025 at 08:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CityRide_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bookings`
--

CREATE TABLE `Bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `car_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Bookings`
--

INSERT INTO `Bookings` (`booking_id`, `user_id`, `vehicle_type`, `pickup_date`, `return_date`, `notes`, `pickup_location`, `status`, `created_at`, `car_id`) VALUES
(1, 1, 'SUV', '2025-11-08', '2025-12-07', NULL, 'Taylors College', 'Pending', '2025-11-25 21:07:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Cars`
--

CREATE TABLE `Cars` (
  `car_id` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `license_plate` varchar(50) DEFAULT NULL,
  `seats` int(11) DEFAULT 4,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `car_name` varchar(100) NOT NULL,
  `car_image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Cars`
--

INSERT INTO `Cars` (`car_id`, `vehicle_type`, `model`, `license_plate`, `seats`, `available`, `created_at`, `car_name`, `car_image`, `description`, `price_per_day`) VALUES
(1, 'SUV', 'Toyota RAV4', 'ABC1234', 5, 1, '2025-11-26 01:08:59', 'RAV4 Adventure', 'images/rav4.png', 'A comfortable SUV perfect for family trips.', 120.00),
(2, 'Sedan', 'Honda Accord', 'XYZ5678', 5, 1, '2025-11-26 01:08:59', 'Accord Deluxe', 'images/accorddeluxe.png\r\n', 'Sleek and fuel-efficient sedan for city drives.', 90.00),
(3, 'Hatchback', 'Volkswagen Golf', 'GHI9101', 4, 1, '2025-11-26 01:08:59', 'Golf Compact', 'images/golfcompact.png', 'Compact hatchback ideal for daily commutes.', 70.00),
(4, 'SUV', 'Ford Explorer', 'JKL1122', 7, 1, '2025-11-26 01:08:59', 'Explorer Max', 'images/explorermax.png', 'Spacious SUV for long journeys.', 150.00),
(5, 'Convertible', 'Mazda MX-5', 'MNO3344', 2, 1, '2025-11-26 01:08:59', 'MX-5 Sport', 'images/mx5.png', 'Fun convertible for weekend drives.', 130.00),
(6, 'Sedan', 'Toyota Camry', 'PQR5566', 5, 1, '2025-11-26 01:08:59', 'Camry Comfort', 'images/camrycomfort.png', 'Reliable sedan with great mileage.', 95.00);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'Fatima', 'www.fatimatuzehra@gmail.com', '$2y$10$5vZBr52K.dvRo8qDLiHcIeOd/wyAw2jzd96/9LTpbESLQhITCBT82', '565656', '2025-11-25 13:41:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bookings`
--
ALTER TABLE `Bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_car` (`car_id`);

--
-- Indexes for table `Cars`
--
ALTER TABLE `Cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bookings`
--
ALTER TABLE `Bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Cars`
--
ALTER TABLE `Cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Bookings`
--
ALTER TABLE `Bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `fk_car` FOREIGN KEY (`car_id`) REFERENCES `Cars` (`car_id`) ON DELETE SET NULL;

--
-- Constraints for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
