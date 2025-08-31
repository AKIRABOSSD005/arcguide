-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 11:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arcguide_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `hours` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_approved` enum('admin') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_date`, `end_date`, `location`, `image`, `category_id`, `is_approved`, `created_by`, `created_at`) VALUES
(1, 'Test Event Agust', 'sample', '2025-08-14', '2025-08-17', 'Poblacion, San Miguel, Bulacan', 'assets/events/689c76c66c687_Screenshot (4).png', 4, 'admin', 1, '2025-08-13 19:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_categories`
--

INSERT INTO `event_categories` (`id`, `name`) VALUES
(1, 'Festival'),
(2, 'Cultural Show'),
(3, 'Parade'),
(4, 'Community Fair'),
(5, 'Historical Exhibit');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_gallery`
--

CREATE TABLE `media_gallery` (
  `id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `spot_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_gallery`
--

INSERT INTO `media_gallery` (`id`, `file_path`, `caption`, `category`, `spot_id`, `event_id`, `uploaded_by`, `created_at`) VALUES
(1, '/assets/picutures/monumentArc.svg', 'San Miguel Welcome Arch Monument', 'Landmark', 1, NULL, 1, '2025-07-19 12:55:35'),
(2, '/assets/picutures/parishSMB.svg', 'Diocesan Shrine and Parish of San Miguel Archangel', 'Religious', 2, NULL, 1, '2025-07-19 12:55:35'),
(3, '/assets/picutures/tecsonHouse.svg', 'Tecson Ancestral House', 'Heritage House', 3, NULL, 1, '2025-07-19 12:55:35'),
(4, '/assets/picutures/tecsonShrine.svg', 'Simon Tecson Historical Marker', 'Historical', 4, NULL, 1, '2025-07-19 12:55:35'),
(5, '/assets/picutures/villasenor.svg', 'Villacorte-Villaseñor Ancestral House', 'Heritage House', 5, NULL, 1, '2025-07-19 12:55:35'),
(6, '/assets/picutures/sevilla.svg', 'Sevilla Ancestral House', 'Heritage House', 6, NULL, 1, '2025-07-19 12:55:35'),
(7, '/assets/picutures/camp-tecson.svg', 'First Scout Ranger Regiment: Camp Tecson', 'Historical', 7, NULL, 1, '2025-07-19 12:55:35'),
(8, '/assets/picutures/sibul-spring.svg', 'Sibul Spring Resort', 'Resort', 8, NULL, 1, '2025-07-19 12:55:35'),
(9, '/assets/picutures/malapad-na-parang.svg', 'Malapad na Parang', 'Natural', 9, NULL, 1, '2025-07-19 12:55:35'),
(10, '/assets/picutures/mt-manalmon.svg', 'Mount Manalmon', 'Mountain', 10, NULL, 1, '2025-07-19 12:55:35'),
(11, '/assets/picutures/madlum-cave.svg', 'Madlum Cave (Manalmon Cave)', 'Cave', 11, NULL, 1, '2025-07-19 12:55:35'),
(12, '/assets/picutures/bayukbok-caves.svg', 'Bayukbok Caves', 'Cave', 12, NULL, 1, '2025-07-19 12:55:35'),
(13, '/assets/picutures/madlum-falls.svg', 'Madlum Falls', 'Falls', 13, NULL, 1, '2025-07-19 12:55:35'),
(14, '/assets/picutures/madlum-river.svg', 'Madlum River', 'River', 14, NULL, 1, '2025-07-19 12:55:35'),
(15, '/assets/picutures/mt-gola.svg', 'Mount Gola', 'Mountain', 15, NULL, 1, '2025-07-19 12:55:35'),
(16, '/assets/picutures/cabin-resorts.svg', 'The Cabin Resorts', 'Resort', 16, NULL, 1, '2025-07-19 12:55:35'),
(17, '/assets/picutures/kamote-resort.svg', 'Kamote Resort', 'Resort', 17, NULL, 1, '2025-07-19 12:55:35'),
(18, '/assets/picutures/banal-na-bundok.svg', 'Banal na Bundok', 'Religious', 18, NULL, 1, '2025-07-19 12:55:35'),
(19, '/assets/picutures/biak-na-bato-park.svg', 'Biak-na-Bato National Park', 'Natural', 19, NULL, 1, '2025-07-19 12:55:35'),
(20, '/assets/picutures/bahay-paniki.svg', 'Bahay Paniki Cave', 'Cave', 20, NULL, 1, '2025-07-19 12:55:35'),
(21, '/assets/picutures/aguinaldo-cave.svg', 'Aguinaldo Cave', 'Cave', 21, NULL, 1, '2025-07-19 12:55:35'),
(22, '/assets/picutures/cuarto-cuarto-cave.svg', 'Cuarto-Cuarto Cave', 'Cave', 22, NULL, 1, '2025-07-19 12:55:35'),
(23, '/assets/picutures/tilandong-falls.svg', 'Tilandong Falls', 'Falls', 23, NULL, 1, '2025-07-19 12:55:35'),
(24, '/assets/picutures/tanggapan-cave.svg', 'Tanggapan Cave', 'Cave', 24, NULL, 1, '2025-07-19 12:55:35'),
(25, '/assets/picutures/hospital-cave.svg', 'Hospital Cave', 'Cave', 25, NULL, 1, '2025-07-19 12:55:35'),
(26, '/assets/picutures/imbakan-cave.svg', 'Imbakan Cave', 'Cave', 26, NULL, 1, '2025-07-19 12:55:35'),
(27, '/assets/picutures/ambush-cave.svg', 'Ambush Cave', 'Cave', 27, NULL, 1, '2025-07-19 12:55:35'),
(28, '/assets/picutures/pahingahan-cave.svg', 'Pahingahan Cave', 'Cave', 28, NULL, 1, '2025-07-19 12:55:35'),
(29, '/assets/picutures/maningning-cave.svg', 'Maningning Cave', 'Cave', 29, NULL, 1, '2025-07-19 12:55:35'),
(30, '/assets/picutures/mt-mabio.svg', 'Mount Mabio (Mount Silid)', 'Mountain', 30, NULL, 1, '2025-07-19 12:55:35'),
(31, '/assets/picutures/balaong-river.svg', 'Balaong River', 'River', 31, NULL, NULL, '2025-07-19 12:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `specialties` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spot_categories`
--

CREATE TABLE `spot_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spot_categories`
--

INSERT INTO `spot_categories` (`id`, `name`) VALUES
(1, 'Historical'),
(2, 'Religious'),
(3, 'Natural'),
(4, 'Resort'),
(5, 'Cave'),
(6, 'Mountain'),
(7, 'River'),
(8, 'Falls'),
(9, 'Landmark'),
(10, 'Heritage House');

-- --------------------------------------------------------

--
-- Table structure for table `spot_reviews`
--

CREATE TABLE `spot_reviews` (
  `id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tourist_spots`
--

CREATE TABLE `tourist_spots` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `google_maps_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourist_spots`
--

INSERT INTO `tourist_spots` (`id`, `name`, `description`, `image`, `category_id`, `address`, `latitude`, `longitude`, `google_maps_url`, `created_at`, `updated_at`) VALUES
(1, 'San Miguel Welcome Arch Monument', 'Selfie, Stopover', '/assets/picutures/monumentArc.svg', 9, 'Boundary of San Ildefonso and San Miguel National road', 15.1187399, 120.9481741, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(2, 'Diocesan Shrine and Parish of San Miguel Archangel', 'Pray, Sightseeing, Search for Maximo Viola’s tombstone', '/assets/picutures/parishSMB.svg', 2, 'Poblacion, San Miguel', 15.1406807, 120.9767822, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(3, 'Tecson Ancestral House', 'Sightseeing, Selfie, Historical Tour', '/assets/picutures/tecsonHouse.svg', 10, 'Rizal St., San Miguel', 15.1388023, 120.9710330, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(4, 'Simon Tecson Historical Marker', 'Sightseeing, Selfie, Historical Tour', '/assets/picutures/tecsonShrine.svg', 1, 'Rizal St., San Miguel', 15.1387505, 120.9710974, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(5, 'Villacorte-Villaseñor Ancestral House', 'Sightseeing, Selfie', '/assets/picutures/villasenor.svg', 10, NULL, 15.1402555, 120.9693867, NULL, '2025-07-19 12:46:39', '2025-07-19 12:46:39'),
(6, 'Sevilla Ancestral House', 'Sightseeing, Selfie', '/assets/picutures/sevilla.svg', 10, 'Tecson St., San Miguel', 15.1394413, 120.9732480, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(7, 'First Scout Ranger Regiment: Camp Tecson', 'Sightseeing, Selfie', '/assets/picutures/camp-tecson.svg', 1, 'Brgy. Sibul, San Miguel', 15.1758626, 121.0472662, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(8, 'Sibul Spring Resort', 'A resort built in 1910 but now forgotten and no longer maintained. Place, Sightseeing, Selfie…', '/assets/picutures/sibul-spring.svg', 4, 'Brgy. Sibul, San Miguel', 15.1674870, 121.0606271, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(9, 'Malapad na Parang', 'Sightseeing, Selfie, Hiking', '/assets/picutures/malapad-na-parang.svg', 3, 'Sitio Brown, Brgy. Sibul, San Miguel', 15.1837785, 121.0765999, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(10, 'Mount Manalmon', 'Hiking, Camping', '/assets/picutures/mt-manalmon.svg', 6, 'Major jump-off: Sitio Madlum, Brgy. Sibul, San Miguel', 15.1629227, 121.0912303, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(11, 'Madlum Cave (Manalmon Cave)', 'Hiking, Spelunking, Sightseeing, Swimming', '/assets/picutures/madlum-cave.svg', 5, 'Sitio Madlum, Brgy. Sibul, San Miguel', 15.1707386, 121.0837627, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(12, 'Bayukbok Caves', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/bayukbok-caves.svg', 5, NULL, 15.1703005, 21.0826684, NULL, '2025-07-19 12:46:39', '2025-07-19 12:46:39'),
(13, 'Madlum Falls', 'Hiking, Sightseeing, Swimming', '/assets/picutures/madlum-falls.svg', 8, 'Sitio Madlum, Brgy. Sibul, San Miguel', 15.1702165, 121.0827115, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(14, 'Madlum River', 'Sightseeing, Swimming', '/assets/picutures/madlum-river.svg', 7, 'Sitio Madlum, Brgy. Sibul, San Miguel', 15.1702165, 121.0827115, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(15, 'Mount Gola', 'Hiking, Hiking, Camping', '/assets/picutures/mt-gola.svg', 6, 'Major jump-off: Sitio Madlum, Brgy. Sibul, San Miguel', 15.1637581, 121.0939325, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(16, 'The Cabin Resorts', 'Swimming, Archery, Kayaking, Bike, Badminton, Hotel, Fishing', '/assets/picutures/cabin-resorts.svg', 4, 'San Miguel', 15.1537398, 120.9500617, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(17, 'Kamote Resort', 'Swimming, Picnic, Hiking, Fishing', '/assets/picutures/kamote-resort.svg', 4, 'Sitio Balingkupang, Biak-na-Bato, San Miguel', 15.1174963, 121.0588584, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(18, 'Banal na Bundok', 'Sightseeing, Picnic, Selfie', '/assets/picutures/banal-na-bundok.svg', 2, 'Sitio Balingkupang, Biak-na-Bato, San Miguel', 15.1251805, 121.0586114, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(19, 'Biak-na-Bato National Park', 'Sightseeing, Hiking, Swimming, Picnic', '/assets/picutures/biak-na-bato-park.svg', 3, 'Biak-na-Bato, San Miguel', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(20, 'Bahay Paniki Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/bahay-paniki.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(21, 'Aguinaldo Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/aguinaldo-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(22, 'Cuarto-Cuarto Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/cuarto-cuarto-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(23, 'Tilandong Falls', 'Sightseeing, Hiking, Swimming, Picnic', '/assets/picutures/tilandong-falls.svg', 8, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(24, 'Tanggapan Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/tanggapan-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(25, 'Hospital Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/hospital-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:44'),
(26, 'Imbakan Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/imbakan-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:45'),
(27, 'Ambush Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/ambush-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:45'),
(28, 'Pahingahan Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/pahingahan-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:45'),
(29, 'Maningning Cave', 'Hiking, Spelunking, Sightseeing', '/assets/picutures/maningning-cave.svg', 5, 'Inside Biak-na-Bato National Park', 15.1108232, 121.0702821, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:45'),
(30, 'Mount Mabio (Mount Silid)', 'Hiking, Sightseeing', '/assets/picutures/mt-mabio.svg', 6, 'Biak-na-Bato, San Miguel', 15.1139441, 121.0968197, NULL, '2025-07-19 12:46:39', '2025-07-19 13:14:45'),
(31, 'Balaong River', 'Swimming, Rafting, Picnic, Fishing', '/assets/picutures/balaong-river.svg', 7, NULL, 15.1329923, 121.0401187, NULL, '2025-07-19 12:46:39', '2025-07-19 12:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `loggedTime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `loggedTime`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'domingo.earlgerald005@gmail.com', 'Password', 'admin', '2025-08-31 09:33:28', '2025-07-19 12:48:43', '2025-08-31 15:33:28'),
(2, 'User', 'earlgerald.domingo005@gmail.com', 'userpassword', 'user', '2025-08-13 14:28:40', '2025-07-19 12:48:43', '2025-08-13 20:28:40'),
(3, 'Domingo, Earl Gerald', 'earlgeralddomingo.basc@gmail.com', '', 'user', NULL, '2025-07-28 18:00:09', '2025-07-28 18:00:09'),
(4, 'Area Coop', 'areacoop005@gmail.com', '', 'user', '2025-08-04 15:30:49', '2025-07-28 18:06:54', '2025-08-04 21:30:49'),
(5, 'Nicole Alyssa Lopez', 'nicolealyssa30lopez@gmail.com', '', 'user', NULL, '2025-07-28 18:25:45', '2025-07-28 18:25:45'),
(6, 'Lopez, Nicole Alyssa', 'nicolealyssalopez.basc@gmail.com', '', 'user', '2025-08-04 13:21:03', '2025-07-28 18:26:57', '2025-08-04 19:21:03'),
(7, 'Lopez, Nicole Alyssa', 'lopez.nicolealyssa.business@gmail.com', '', 'user', NULL, '2025-07-28 18:33:45', '2025-07-28 18:33:45'),
(8, 'Lopez, Nicole Alyssa', 'nicolealyssafranciscolopez@gmail.com', '', 'user', NULL, '2025-08-04 11:04:51', '2025-08-04 11:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `visit_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `user_agent`, `visit_date`, `created_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-08-31', '2025-08-31 09:29:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_gallery`
--
ALTER TABLE `media_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spot_categories`
--
ALTER TABLE `spot_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spot_reviews`
--
ALTER TABLE `spot_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_visit` (`ip_address`,`visit_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_gallery`
--
ALTER TABLE `media_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spot_categories`
--
ALTER TABLE `spot_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `spot_reviews`
--
ALTER TABLE `spot_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `media_gallery`
--
ALTER TABLE `media_gallery`
  ADD CONSTRAINT `media_gallery_ibfk_1` FOREIGN KEY (`spot_id`) REFERENCES `tourist_spots` (`id`),
  ADD CONSTRAINT `media_gallery_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `media_gallery_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `spot_reviews`
--
ALTER TABLE `spot_reviews`
  ADD CONSTRAINT `spot_reviews_ibfk_1` FOREIGN KEY (`spot_id`) REFERENCES `tourist_spots` (`id`),
  ADD CONSTRAINT `spot_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  ADD CONSTRAINT `tourist_spots_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `spot_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
