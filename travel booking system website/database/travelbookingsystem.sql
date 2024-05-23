-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 09:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelbookingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `amenity_id` int(11) NOT NULL,
  `amenity_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hotel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`amenity_id`, `amenity_name`, `category`, `description`, `hotel_id`) VALUES
(1, 'pool', 'high class', 'pool for swimming', 1),
(2, 'restaurant', 'meal of attendant', 'for meal', 2),
(3, 'casino', 'play', 'game', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `booking_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `flight_id`, `hotel_id`, `booking_date`) VALUES
(1, 2, 2, '2024-05-13 00:00:00'),
(3, 2, 12, '2024-05-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `flight_id` int(11) NOT NULL,
  `departure_city` varchar(255) NOT NULL,
  `arrival_city` varchar(255) NOT NULL,
  `departure_date` datetime NOT NULL,
  `arrival_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`flight_id`, `departure_city`, `arrival_city`, `departure_date`, `arrival_date`) VALUES
(1, 'bujumbura', 'kinshasa', '2024-05-10 00:00:00', '2024-05-02 00:00:00'),
(2, 'miami', 'newyork', '2024-05-01 00:00:00', '2024-05-22 00:00:00'),
(4, 'bujumbura', 'kinshasa', '2024-05-22 00:00:00', '2024-05-22 00:00:00'),
(5, 'miami', 'wangton DC', '2024-02-01 00:00:00', '2024-07-27 00:00:00'),
(6, 'kigali', 'dar salam', '2024-05-04 00:00:00', '2024-05-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `flight_bookings`
--

CREATE TABLE `flight_bookings` (
  `flight_booking_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `booking_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight_bookings`
--

INSERT INTO `flight_bookings` (`flight_booking_id`, `booking_id`, `flight_id`, `seat_number`, `booking_status`) VALUES
(1, 1, 2, '122', '12'),
(2, 1, 2, '600', '1'),
(3, 1, 2, '122', '0');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `hotel_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price_per_night` varchar(100) NOT NULL,
  `rating` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `hotel_name`, `location`, `price_per_night`, `rating`) VALUES
(1, 'Radisson Blu Hotel', 'Rwanda', '200', '1'),
(2, 'Four Seasons Hotel', 'Egypt/Cairo', '1000', '3'),
(4, '>La Mamounia', 'Morocco/ Marrakech', '30', '1'),
(5, 'mariot hotel', 'Rwanda/ Kigali', '150', '6'),
(8, 'One&Only Cape Town', 'South Africa/Cape Town', '2000', '12'),
(9, 'Hilton Nairobi', 'Kenya/Nairobi ', '800', '80'),
(11, 'The Langham', 'USA/Chicago', '300', '10'),
(12, 'The Ritz-Carlton', 'USA/Los Angeles', '200', '21'),
(13, 'The Ritz-Carlton New York', 'USA/New York City', '200', '50'),
(14, 'The Venetian Resort', 'USA/Las Vegas, Nevada', '654', '122'),
(15, 'Villa Rosa Kempinski', 'Kenya: Nairobi', '389', '41'),
(16, 'park Inn hotel', 'Rwanda: Kigali', '200', '13'),
(17, 'InterContinental Nairobi', 'Kenya: Nairobi', '500', '12'),
(18, 'Four Seasons Hotel Miami', 'USA: Miami, Florida', '2000', '3'),
(19, 'The Peninsula', 'USA/Chicago', '100', '40');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_bookings`
--

CREATE TABLE `hotel_bookings` (
  `hotel_booking_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `booking_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_bookings`
--

INSERT INTO `hotel_bookings` (`hotel_booking_id`, `booking_id`, `hotel_id`, `room_type`, `booking_status`) VALUES
(2, 1, 2, 'classic', 'accepted'),
(3, 1, 2, 'classic', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `country`, `latitude`, `longitude`) VALUES
(1, 'kigali', 'Rwanda', 20.000000, 40.000000),
(2, 'ASIA', 'china', 30.000000, 12.000000);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `user_id`, `booking_id`, `amount`, `payment_date`) VALUES
(4, 3, 1, 2000.00, '2023-04-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `review_text` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `hotel_id`, `flight_id`, `review_text`) VALUES
(3, 1, 1, 'good morning'),
(4, 12, 2, 'thank you too'),
(6, 14, 2, 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone_number`) VALUES
(2, 'moise katumbi', 'katumbi203@gmail.com', '$2y$10$dYZhz6E7E1X63PublFZpAegv0e35yW.6M4wyPFXjlVCSLxN/lm9Ly', '1234567890'),
(3, 'fabrice niyonkuru', 'fabrice100@gmail.com', '$2y$10$zZCiDllFTIbfU2pMd9Q8V.lxSyguvQG6PdaKARaNWDuAM1YUPxTd6', '720000000'),
(5, 'noble man', 'noble20@gmail.com', '$2y$10$BNMBFUk7aU0wB4HOpLGbiukhW3aZ2.4bQs8qMwP2yjTOMaSNmoDlC', '720000000'),
(6, 'kanyemera jean', 'jean100@gmail.com', '$2y$10$s998DgHfDuC3keV0bc2tfunQ//Dfv5L0aHzQCkiQBj7CUZmSAU3U2', '0786769687'),
(8, 'moise katumbi', 'moise100@gmail.com', '$2y$10$oI8xlkvGVwbEXjHGm4W0EusUqsXuZmu6s7VkKOU3vw4NaIVBagbzm', '0788888880'),
(11, 'niyonkuru Theoneste', 'niyoth25@gmail.com', '$2y$10$P5hmp4xfQP1IRN7K5ChXJ.powZJ8b3jYO8l8sP8MTxG3iXYBlFxMG', '0786762195'),
(12, 'noble man', 'noble250@gmail.com', '$2y$10$JaZU.Epj8CcY4XuyAgLDq.tCJPXh2bAHFWSEgsFB7DPZPHBHtO1UC', '0786762195'),
(13, 'urhuye butare', 'butare31@gmail.com', '$2y$10$oNRYiGR.1yKMmuG40vOjeuUAZ7/CTouyLlxhslZAHZnN78bok/lde', '287879897'),
(14, 'niyonkuru theoneste', 'noble10@gmail.com', '$2y$10$vuaWwXrbt2BnPXY57hB/..M61zXHdfeFYnk22d3Y5PdlSkOMf43oa', '0981234567'),
(15, 'kamali erneste', 'kamali@gmail.com', '$2y$10$mmzQ32D11jzeErzZbMYusO0eGQe2ahH4/XoOR9EoAeYn6vDtdhS2e', '0786767576');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`amenity_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`flight_id`);

--
-- Indexes for table `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD PRIMARY KEY (`flight_booking_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD PRIMARY KEY (`hotel_booking_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `amenity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `flight_bookings`
--
ALTER TABLE `flight_bookings`
  MODIFY `flight_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  MODIFY `hotel_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `amenities_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`flight_id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD CONSTRAINT `flight_bookings_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `flight_bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`flight_id`);

--
-- Constraints for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD CONSTRAINT `hotel_bookings_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `hotel_bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`flight_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
