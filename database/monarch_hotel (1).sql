-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2026 at 03:49 PM
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
-- Database: `monarch_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `properties` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `properties`, `created_at`, `updated_at`) VALUES
(1, 1, 'confirmed', 'App\\Models\\Booking', 31, 'Confirmed booking: SUB-2026-000031', '127.0.0.1', NULL, '2026-07-16 12:44:59', '2026-07-16 12:44:59'),
(2, 1, 'confirmed', 'App\\Models\\Booking', 21, 'Confirmed booking: SUB-2026-000021', '127.0.0.1', NULL, '2026-07-16 12:48:52', '2026-07-16 12:48:52'),
(3, 1, 'confirmed', 'App\\Models\\Booking', 14, 'Confirmed booking: SUB-2026-000014', '127.0.0.1', NULL, '2026-07-16 12:49:10', '2026-07-16 12:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'room',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Free WiFi', 'bi-wifi', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(2, 'Air Conditioning', 'bi-thermometer-snow', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(3, 'Flat-screen TV', 'bi-tv', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(4, 'Mini Bar', 'bi-cup-straw', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(5, 'Breakfast Included', 'bi-egg-fried', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(6, 'Room Service', 'bi-bell', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(7, 'Private Bathroom', 'bi-droplet', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(8, 'Safe Box', 'bi-lock', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(9, 'Bathtub', 'bi-water', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(10, 'Balcony', 'bi-house-door', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(11, 'Work Desk', 'bi-laptop', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(12, 'King Bed', 'bi-moon', 'room', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(13, 'Swimming Pool', 'bi-water', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(14, 'Fitness Center', 'bi-heart-pulse', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(15, 'Spa & Wellness', 'bi-flower1', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(16, 'Restaurant', 'bi-cup-hot', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(17, 'Free Parking', 'bi-p-circle', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(18, 'Airport Shuttle', 'bi-bus-front', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(19, 'Conference Hall', 'bi-building', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(20, 'Wedding Venue', 'bi-heart', 'hotel', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `amenity_room`
--

CREATE TABLE `amenity_room` (
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenity_room`
--

INSERT INTO `amenity_room` (`room_id`, `amenity_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 6),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(17, 7),
(17, 8),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 7),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 6),
(21, 7),
(21, 8),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(22, 8),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(23, 6),
(23, 7),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 6),
(24, 7),
(24, 8),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(25, 5),
(26, 1),
(26, 2),
(26, 3),
(26, 4),
(26, 5),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(27, 5),
(27, 6),
(27, 7),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 6),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(29, 6),
(29, 7),
(29, 8),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(30, 5),
(30, 6),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(31, 5),
(31, 6),
(31, 7),
(31, 8),
(32, 1),
(32, 2),
(32, 3),
(32, 4),
(32, 5),
(32, 6),
(32, 7),
(33, 1),
(33, 2),
(33, 3),
(33, 4),
(33, 5),
(33, 6),
(33, 7),
(34, 1),
(34, 2),
(34, 3),
(34, 4),
(34, 5),
(34, 6),
(35, 1),
(35, 2),
(35, 3),
(35, 4),
(35, 5),
(35, 6),
(36, 1),
(36, 2),
(36, 3),
(36, 4),
(36, 5),
(36, 6),
(36, 7),
(36, 8),
(37, 1),
(37, 2),
(37, 3),
(37, 4),
(37, 5),
(38, 1),
(38, 2),
(38, 3),
(38, 4),
(38, 5),
(39, 1),
(39, 2),
(39, 3),
(39, 4),
(39, 5),
(39, 6),
(39, 7),
(39, 8),
(40, 1),
(40, 2),
(40, 3),
(40, 4),
(40, 5),
(40, 6),
(40, 7),
(41, 1),
(41, 2),
(41, 3),
(41, 4),
(41, 5),
(41, 6),
(41, 7),
(41, 8),
(42, 1),
(42, 2),
(42, 3),
(42, 4),
(42, 5),
(42, 6),
(43, 1),
(43, 2),
(43, 3),
(43, 4),
(43, 5),
(43, 6),
(43, 7),
(43, 8),
(44, 1),
(44, 2),
(44, 3),
(44, 4),
(44, 5),
(44, 6),
(44, 7),
(44, 8),
(45, 1),
(45, 2),
(45, 3),
(45, 4),
(45, 5),
(45, 6),
(45, 7),
(46, 1),
(46, 2),
(46, 3),
(46, 4),
(46, 5),
(46, 6),
(47, 1),
(47, 2),
(47, 3),
(47, 4),
(47, 5),
(48, 1),
(48, 2),
(48, 3),
(48, 4),
(48, 5),
(48, 6),
(48, 7),
(49, 1),
(49, 2),
(49, 3),
(49, 4),
(49, 5),
(49, 6),
(49, 7),
(49, 8),
(50, 1),
(50, 2),
(50, 3),
(50, 4),
(50, 5),
(50, 6),
(50, 7),
(51, 1),
(51, 2),
(51, 3),
(51, 4),
(51, 5),
(51, 6),
(51, 7),
(52, 1),
(52, 2),
(52, 3),
(52, 4),
(52, 5),
(53, 1),
(53, 2),
(53, 3),
(53, 4),
(53, 5),
(53, 6),
(53, 7),
(54, 1),
(54, 2),
(54, 3),
(54, 4),
(54, 5),
(54, 6),
(55, 1),
(55, 2),
(55, 3),
(55, 4),
(55, 5),
(55, 6),
(56, 1),
(56, 2),
(56, 3),
(56, 4),
(56, 5),
(56, 6),
(57, 1),
(57, 2),
(57, 3),
(57, 4),
(57, 5),
(57, 6),
(57, 7),
(57, 8),
(58, 1),
(58, 2),
(58, 3),
(58, 4),
(58, 5),
(59, 1),
(59, 2),
(59, 3),
(59, 4),
(59, 5),
(59, 6),
(59, 7),
(59, 8),
(60, 1),
(60, 2),
(60, 3),
(60, 4),
(60, 5),
(60, 6),
(61, 1),
(61, 2),
(61, 3),
(61, 4),
(61, 5),
(61, 6),
(62, 1),
(62, 2),
(62, 3),
(62, 4),
(62, 5),
(62, 6),
(63, 1),
(63, 2),
(63, 3),
(63, 4),
(63, 5),
(63, 6),
(63, 7),
(63, 8),
(64, 1),
(64, 2),
(64, 3),
(64, 4),
(64, 5),
(64, 6),
(65, 1),
(65, 2),
(65, 3),
(65, 4),
(65, 5),
(65, 6),
(65, 7),
(66, 1),
(66, 2),
(66, 3),
(66, 4),
(66, 5),
(66, 6),
(66, 7),
(66, 8),
(67, 1),
(67, 2),
(67, 3),
(67, 4),
(67, 5),
(68, 1),
(68, 2),
(68, 3),
(68, 4),
(68, 5),
(68, 6),
(68, 7),
(69, 1),
(69, 2),
(69, 3),
(69, 4),
(69, 5),
(69, 6),
(70, 1),
(70, 2),
(70, 3),
(70, 4),
(70, 5),
(70, 6),
(70, 7),
(70, 8),
(71, 1),
(71, 2),
(71, 3),
(71, 4),
(71, 5),
(71, 6),
(71, 7),
(72, 1),
(72, 2),
(72, 3),
(72, 4),
(72, 5),
(72, 6),
(72, 7),
(72, 8),
(73, 1),
(73, 2),
(73, 3),
(73, 4),
(73, 5),
(73, 6),
(73, 7),
(73, 8),
(74, 1),
(74, 2),
(74, 3),
(74, 4),
(74, 5),
(75, 1),
(75, 2),
(75, 3),
(75, 4),
(75, 5),
(76, 1),
(76, 2),
(76, 3),
(76, 4),
(76, 5),
(76, 6),
(77, 1),
(77, 2),
(77, 3),
(77, 4),
(77, 5),
(77, 6),
(78, 1),
(78, 2),
(78, 3),
(78, 4),
(78, 5),
(78, 6),
(78, 7),
(79, 1),
(79, 2),
(79, 3),
(79, 4),
(79, 5),
(79, 6),
(79, 7),
(80, 1),
(80, 2),
(80, 3),
(80, 4),
(80, 5),
(80, 6),
(81, 1),
(81, 2),
(81, 3),
(81, 4),
(81, 5),
(82, 1),
(82, 2),
(82, 3),
(82, 4),
(82, 5),
(83, 1),
(83, 2),
(83, 3),
(83, 4),
(83, 5),
(83, 6),
(83, 7),
(84, 1),
(84, 2),
(84, 3),
(84, 4),
(84, 5),
(85, 1),
(85, 2),
(85, 3),
(85, 4),
(85, 5),
(85, 6),
(86, 1),
(86, 2),
(86, 3),
(86, 4),
(86, 5),
(86, 6),
(86, 7),
(86, 8),
(87, 1),
(87, 2),
(87, 3),
(87, 4),
(87, 5),
(87, 6),
(88, 1),
(88, 2),
(88, 3),
(88, 4),
(88, 5),
(88, 6),
(88, 7),
(88, 8),
(89, 1),
(89, 2),
(89, 3),
(89, 4),
(89, 5),
(90, 1),
(90, 2),
(90, 3),
(90, 4),
(90, 5),
(90, 6),
(90, 7),
(90, 8),
(91, 1),
(91, 2),
(91, 3),
(91, 4),
(91, 5),
(91, 6),
(91, 7),
(92, 1),
(92, 2),
(92, 3),
(92, 4),
(92, 5),
(92, 6),
(92, 7),
(92, 8),
(93, 1),
(93, 2),
(93, 3),
(93, 4),
(93, 5),
(93, 6),
(93, 7),
(94, 1),
(94, 2),
(94, 3),
(94, 4),
(94, 5),
(94, 6),
(95, 1),
(95, 2),
(95, 3),
(95, 4),
(95, 5),
(96, 1),
(96, 2),
(96, 3),
(96, 4),
(96, 5),
(96, 6),
(97, 1),
(97, 2),
(97, 3),
(97, 4),
(97, 5),
(98, 1),
(98, 2),
(98, 3),
(98, 4),
(98, 5),
(98, 6),
(98, 7),
(99, 1),
(99, 2),
(99, 3),
(99, 4),
(99, 5),
(99, 6),
(99, 7),
(100, 1),
(100, 2),
(100, 3),
(100, 4),
(100, 5),
(100, 6),
(100, 7),
(101, 1),
(101, 2),
(101, 3),
(101, 4),
(101, 5),
(101, 6),
(102, 1),
(102, 2),
(102, 3),
(102, 4),
(102, 5),
(102, 6),
(103, 1),
(103, 2),
(103, 3),
(103, 4),
(103, 5),
(103, 6),
(103, 7),
(103, 8),
(104, 1),
(104, 2),
(104, 3),
(104, 4),
(104, 5),
(104, 6),
(104, 7),
(105, 1),
(105, 2),
(105, 3),
(105, 4),
(105, 5),
(105, 6),
(105, 7),
(105, 8),
(106, 1),
(106, 2),
(106, 3),
(106, 4),
(106, 5),
(106, 6),
(106, 7),
(107, 1),
(107, 2),
(107, 3),
(107, 4),
(107, 5),
(107, 6),
(108, 1),
(108, 2),
(108, 3),
(108, 4),
(108, 5),
(108, 6),
(108, 7),
(109, 1),
(109, 2),
(109, 3),
(109, 4),
(109, 5),
(109, 6),
(109, 7),
(109, 8),
(110, 1),
(110, 2),
(110, 3),
(110, 4),
(110, 5),
(110, 6),
(110, 7),
(110, 8),
(111, 1),
(111, 2),
(111, 3),
(111, 4),
(111, 5),
(111, 6),
(111, 7),
(112, 1),
(112, 2),
(112, 3),
(112, 4),
(112, 5),
(112, 6),
(112, 7),
(112, 8),
(113, 1),
(113, 2),
(113, 3),
(113, 4),
(113, 5),
(113, 6),
(113, 7),
(113, 8),
(114, 1),
(114, 2),
(114, 3),
(114, 4),
(114, 5),
(114, 6),
(114, 7),
(114, 8),
(115, 1),
(115, 2),
(115, 3),
(115, 4),
(115, 5),
(115, 6),
(115, 7),
(116, 1),
(116, 2),
(116, 3),
(116, 4),
(116, 5),
(116, 6),
(116, 7),
(116, 8),
(117, 1),
(117, 2),
(117, 3),
(117, 4),
(117, 5),
(118, 1),
(118, 2),
(118, 3),
(118, 4),
(118, 5),
(118, 6),
(119, 1),
(119, 2),
(119, 3),
(119, 4),
(119, 5),
(119, 6),
(120, 1),
(120, 2),
(120, 3),
(120, 4),
(120, 5),
(120, 6),
(120, 7),
(121, 1),
(121, 2),
(121, 3),
(121, 4),
(121, 5),
(121, 6),
(122, 1),
(122, 2),
(122, 3),
(122, 4),
(122, 5),
(122, 6),
(122, 7),
(122, 8),
(123, 1),
(123, 2),
(123, 3),
(123, 4),
(123, 5),
(124, 1),
(124, 2),
(124, 3),
(124, 4),
(124, 5),
(124, 6),
(125, 1),
(125, 2),
(125, 3),
(125, 4),
(125, 5),
(126, 1),
(126, 2),
(126, 3),
(126, 4),
(126, 5),
(126, 6),
(126, 7),
(126, 8),
(127, 1),
(127, 2),
(127, 3),
(127, 4),
(127, 5),
(127, 6),
(127, 7),
(128, 1),
(128, 2),
(128, 3),
(128, 4),
(128, 5),
(128, 6),
(129, 1),
(129, 2),
(129, 3),
(129, 4),
(129, 5),
(129, 6),
(130, 1),
(130, 2),
(130, 3),
(130, 4),
(130, 5),
(130, 6),
(131, 1),
(131, 2),
(131, 3),
(131, 4),
(131, 5),
(131, 6),
(131, 7),
(131, 8),
(132, 1),
(132, 2),
(132, 3),
(132, 4),
(132, 5),
(132, 6),
(133, 1),
(133, 2),
(133, 3),
(133, 4),
(133, 5),
(134, 1),
(134, 2),
(134, 3),
(134, 4),
(134, 5),
(134, 6),
(134, 7),
(134, 8),
(135, 1),
(135, 2),
(135, 3),
(135, 4),
(135, 5),
(135, 6),
(135, 7),
(135, 8),
(136, 1),
(136, 2),
(136, 3),
(136, 4),
(136, 5),
(136, 6),
(136, 7),
(136, 8),
(137, 1),
(137, 2),
(137, 3),
(137, 4),
(137, 5),
(137, 6),
(137, 7),
(138, 1),
(138, 2),
(138, 3),
(138, 4),
(138, 5),
(139, 1),
(139, 2),
(139, 3),
(139, 4),
(139, 5),
(140, 1),
(140, 2),
(140, 3),
(140, 4),
(140, 5),
(140, 6),
(141, 1),
(141, 2),
(141, 3),
(141, 4),
(141, 5),
(141, 6),
(141, 7),
(141, 8),
(142, 1),
(142, 2),
(142, 3),
(142, 4),
(142, 5),
(142, 6),
(143, 1),
(143, 2),
(143, 3),
(143, 4),
(143, 5),
(143, 6),
(144, 1),
(144, 2),
(144, 3),
(144, 4),
(144, 5),
(144, 6),
(144, 7),
(144, 8),
(145, 1),
(145, 2),
(145, 3),
(145, 4),
(145, 5),
(146, 1),
(146, 2),
(146, 3),
(146, 4),
(146, 5),
(146, 6),
(146, 7),
(147, 1),
(147, 2),
(147, 3),
(147, 4),
(147, 5),
(147, 6),
(147, 7),
(147, 8),
(148, 1),
(148, 2),
(148, 3),
(148, 4),
(148, 5),
(148, 6),
(148, 7),
(149, 1),
(149, 2),
(149, 3),
(149, 4),
(149, 5),
(150, 1),
(150, 2),
(150, 3),
(150, 4),
(150, 5);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_email` varchar(255) NOT NULL,
  `guest_phone` varchar(255) NOT NULL,
  `guest_address` text DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `special_requests` text DEFAULT NULL,
  `nights` int(11) NOT NULL,
  `room_price_per_night` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `promotion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled','completed') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash','gcash','maya','bank_transfer') DEFAULT NULL,
  `payment_status` enum('unpaid','partially_paid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  `payment_proof` varchar(255) DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_number`, `user_id`, `room_id`, `guest_name`, `guest_email`, `guest_phone`, `guest_address`, `check_in`, `check_out`, `adults`, `children`, `special_requests`, `nights`, `room_price_per_night`, `subtotal`, `discount_amount`, `tax_amount`, `total_amount`, `promotion_id`, `status`, `payment_method`, `payment_status`, `payment_proof`, `cancellation_reason`, `cancelled_at`, `confirmed_at`, `checked_in_at`, `checked_out_at`, `confirmed_by`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'SUB-2026-000001', 7, 119, 'Grace Villanueva', 'grace@example.com', '+63 967 698 6119', NULL, '2026-06-12', '2026-06-19', 1, 0, NULL, 7, 20000.00, 140000.00, 0.00, 16800.00, 156800.00, NULL, 'checked_in', 'cash', 'paid', NULL, NULL, NULL, '2026-06-17 05:36:13', '2026-07-14 05:36:13', NULL, NULL, NULL, '2026-05-06 05:36:13', '2026-07-10 05:36:13'),
(2, 'SUB-2026-000002', 3, 117, 'Maria Santos', 'maria@example.com', '+63 949 602 3137', NULL, '2026-05-25', '2026-05-27', 2, 0, NULL, 2, 20000.00, 40000.00, 0.00, 4800.00, 44800.00, NULL, 'confirmed', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-07-02 05:36:13', NULL, NULL, NULL, NULL, '2026-06-21 05:36:13', '2026-07-16 05:36:13'),
(3, 'SUB-2026-000003', 11, 20, 'Jennifer Bautista', 'jennifer@example.com', '+63 975 413 9051', NULL, '2026-05-15', '2026-05-18', 1, 0, NULL, 3, 3700.00, 11100.00, 0.00, 1332.00, 12432.00, NULL, 'pending', 'gcash', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-12 05:36:13', '2026-06-29 05:36:13'),
(4, 'SUB-2026-000004', 9, 89, 'Patricia Cruz', 'patricia@example.com', '+63 934 672 2854', NULL, '2026-04-28', '2026-04-30', 1, 0, NULL, 2, 10500.00, 21000.00, 0.00, 2520.00, 23520.00, NULL, 'pending', 'gcash', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-22 05:36:13', '2026-07-08 05:36:13'),
(5, 'SUB-2026-000005', 12, 15, 'David Ramos', 'david@example.com', '+63 952 119 2899', NULL, '2026-05-10', '2026-05-14', 2, 1, NULL, 4, 3600.00, 14400.00, 0.00, 1728.00, 16128.00, NULL, 'completed', 'cash', 'paid', NULL, NULL, NULL, '2026-07-11 05:36:13', '2026-07-09 05:36:13', '2026-07-07 05:36:13', NULL, NULL, '2026-06-05 05:36:13', '2026-07-11 05:36:13'),
(6, 'SUB-2026-000006', 11, 62, 'Jennifer Bautista', 'jennifer@example.com', '+63 975 413 9051', NULL, '2026-06-14', '2026-06-19', 1, 0, NULL, 5, 6800.00, 34000.00, 0.00, 4080.00, 38080.00, NULL, 'completed', 'cash', 'paid', NULL, NULL, NULL, '2026-07-11 05:36:13', '2026-07-10 05:36:13', '2026-07-16 05:36:13', NULL, NULL, '2026-05-14 05:36:13', '2026-07-10 05:36:13'),
(7, 'SUB-2026-000007', 10, 38, 'Michael Torres', 'michael@example.com', '+63 959 201 5598', NULL, '2026-05-28', '2026-05-29', 1, 1, NULL, 1, 4800.00, 4800.00, 0.00, 576.00, 5376.00, NULL, 'confirmed', 'maya', 'paid', NULL, NULL, NULL, '2026-07-09 05:36:13', NULL, NULL, NULL, NULL, '2026-05-02 05:36:13', '2026-07-12 05:36:13'),
(8, 'SUB-2026-000008', 10, 139, 'Michael Torres', 'michael@example.com', '+63 959 201 5598', NULL, '2026-06-18', '2026-06-21', 2, 1, NULL, 3, 21000.00, 63000.00, 0.00, 7560.00, 70560.00, NULL, 'checked_out', 'cash', 'paid', NULL, NULL, NULL, '2026-07-02 05:36:13', '2026-07-12 05:36:13', '2026-07-16 05:36:13', NULL, NULL, '2026-05-18 05:36:13', '2026-06-26 05:36:13'),
(9, 'SUB-2026-000009', 5, 118, 'Ana Reyes', 'ana@example.com', '+63 931 693 6655', NULL, '2026-07-08', '2026-07-10', 2, 0, NULL, 2, 20000.00, 40000.00, 0.00, 4800.00, 44800.00, NULL, 'confirmed', 'gcash', 'paid', NULL, NULL, NULL, '2026-07-07 05:36:13', NULL, NULL, NULL, NULL, '2026-06-18 05:36:13', '2026-06-29 05:36:13'),
(10, 'SUB-2026-000010', 8, 14, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, '2026-05-13', '2026-05-15', 1, 1, NULL, 2, 3600.00, 7200.00, 0.00, 864.00, 8064.00, NULL, 'pending', 'bank_transfer', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-18 05:36:13', '2026-07-13 05:36:13'),
(11, 'SUB-2026-000011', 4, 11, 'Juan dela Cruz', 'juan@example.com', '+63 982 728 3897', NULL, '2026-06-06', '2026-06-09', 1, 0, NULL, 3, 3600.00, 10800.00, 0.00, 1296.00, 12096.00, NULL, 'pending', 'maya', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-16 05:36:13', '2026-07-13 05:36:13'),
(12, 'SUB-2026-000012', 7, 15, 'Grace Villanueva', 'grace@example.com', '+63 967 698 6119', NULL, '2026-06-17', '2026-06-18', 2, 0, NULL, 1, 3600.00, 3600.00, 0.00, 432.00, 4032.00, NULL, 'confirmed', 'cash', 'paid', NULL, NULL, NULL, '2026-06-18 05:36:13', NULL, NULL, NULL, NULL, '2026-06-20 05:36:13', '2026-07-08 05:36:13'),
(13, 'SUB-2026-000013', 7, 135, 'Grace Villanueva', 'grace@example.com', '+63 967 698 6119', NULL, '2026-06-09', '2026-06-16', 1, 0, NULL, 7, 22000.00, 154000.00, 0.00, 18480.00, 172480.00, NULL, 'pending', 'maya', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-18 05:36:13', '2026-07-13 05:36:13'),
(14, 'SUB-2026-000014', 8, 8, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, '2026-06-18', '2026-06-20', 1, 0, NULL, 2, 3800.00, 7600.00, 0.00, 912.00, 8512.00, NULL, 'confirmed', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-07-15 05:36:13', NULL, NULL, NULL, NULL, '2026-05-12 05:36:13', '2026-06-27 05:36:13'),
(15, 'SUB-2026-000015', 9, 54, 'Patricia Cruz', 'patricia@example.com', '+63 934 672 2854', NULL, '2026-05-13', '2026-05-14', 2, 1, NULL, 1, 6500.00, 6500.00, 0.00, 780.00, 7280.00, NULL, 'cancelled', 'cash', 'unpaid', NULL, NULL, '2026-06-21 05:36:13', NULL, NULL, NULL, NULL, NULL, '2026-04-23 05:36:13', '2026-06-24 05:36:13'),
(16, 'SUB-2026-000016', 8, 96, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, '2026-07-16', '2026-07-17', 4, 1, NULL, 1, 11500.00, 11500.00, 0.00, 1380.00, 12880.00, NULL, 'checked_in', 'gcash', 'paid', NULL, NULL, NULL, '2026-07-01 05:36:13', '2026-06-29 05:36:13', NULL, NULL, NULL, '2026-06-29 05:36:13', '2026-06-17 05:36:13'),
(17, 'SUB-2026-000017', 10, 1, 'Michael Torres', 'michael@example.com', '+63 959 201 5598', NULL, '2026-04-27', '2026-05-04', 2, 1, NULL, 7, 3500.00, 24500.00, 0.00, 2940.00, 27440.00, NULL, 'completed', 'cash', 'paid', NULL, NULL, NULL, '2026-06-28 05:36:13', '2026-07-12 05:36:13', '2026-07-10 05:36:13', NULL, NULL, '2026-05-17 05:36:13', '2026-06-24 05:36:13'),
(18, 'SUB-2026-000018', 7, 107, 'Grace Villanueva', 'grace@example.com', '+63 967 698 6119', NULL, '2026-05-19', '2026-05-26', 4, 1, NULL, 7, 14500.00, 101500.00, 0.00, 12180.00, 113680.00, NULL, 'completed', 'gcash', 'paid', NULL, NULL, NULL, '2026-07-01 05:36:13', '2026-06-28 05:36:13', '2026-07-09 05:36:13', NULL, NULL, '2026-05-18 05:36:13', '2026-07-03 05:36:13'),
(19, 'SUB-2026-000019', 11, 35, 'Jennifer Bautista', 'jennifer@example.com', '+63 975 413 9051', NULL, '2026-04-24', '2026-04-29', 1, 0, NULL, 5, 5000.00, 25000.00, 0.00, 3000.00, 28000.00, NULL, 'completed', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-07-08 05:36:13', '2026-07-01 05:36:13', '2026-07-09 05:36:13', NULL, NULL, '2026-05-30 05:36:13', '2026-06-21 05:36:13'),
(20, 'SUB-2026-000020', 4, 13, 'Juan dela Cruz', 'juan@example.com', '+63 982 728 3897', NULL, '2026-07-08', '2026-07-10', 2, 1, NULL, 2, 3600.00, 7200.00, 0.00, 864.00, 8064.00, NULL, 'checked_in', 'maya', 'paid', NULL, NULL, NULL, '2026-07-13 05:36:13', '2026-07-01 05:36:13', NULL, NULL, NULL, '2026-06-27 05:36:13', '2026-07-16 05:36:13'),
(21, 'SUB-2026-000021', 11, 99, 'Jennifer Bautista', 'jennifer@example.com', '+63 975 413 9051', NULL, '2026-05-15', '2026-05-22', 1, 1, NULL, 7, 11500.00, 80500.00, 0.00, 9660.00, 90160.00, NULL, 'confirmed', 'maya', 'paid', NULL, NULL, NULL, '2026-06-27 05:36:13', NULL, NULL, NULL, NULL, '2026-06-15 05:36:13', '2026-06-22 05:36:13'),
(22, 'SUB-2026-000022', 8, 109, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, '2026-06-06', '2026-06-08', 2, 1, NULL, 2, 14500.00, 29000.00, 0.00, 3480.00, 32480.00, NULL, 'cancelled', 'bank_transfer', 'unpaid', NULL, NULL, '2026-07-06 05:36:13', NULL, NULL, NULL, NULL, NULL, '2026-06-22 05:36:13', '2026-06-19 05:36:13'),
(23, 'SUB-2026-000023', 6, 80, 'Carlos Mendoza', 'carlos@example.com', '+63 958 417 9805', NULL, '2026-05-12', '2026-05-19', 1, 0, NULL, 7, 9500.00, 66500.00, 0.00, 7980.00, 74480.00, NULL, 'cancelled', 'bank_transfer', 'unpaid', NULL, NULL, '2026-07-14 05:36:13', NULL, NULL, NULL, NULL, NULL, '2026-06-28 05:36:13', '2026-07-08 05:36:13'),
(24, 'SUB-2026-000024', 4, 80, 'Juan dela Cruz', 'juan@example.com', '+63 982 728 3897', NULL, '2026-07-04', '2026-07-10', 2, 0, NULL, 6, 9500.00, 57000.00, 0.00, 6840.00, 63840.00, NULL, 'checked_in', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-07-08 05:36:13', '2026-07-06 05:36:13', NULL, NULL, NULL, '2026-04-22 05:36:13', '2026-06-24 05:36:13'),
(25, 'SUB-2026-000025', 8, 145, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, '2026-06-14', '2026-06-15', 3, 1, NULL, 1, 23000.00, 23000.00, 0.00, 2760.00, 25760.00, NULL, 'completed', 'gcash', 'paid', NULL, NULL, NULL, '2026-06-30 05:36:13', '2026-07-06 05:36:13', '2026-07-14 05:36:13', NULL, NULL, '2026-05-26 05:36:13', '2026-07-02 05:36:13'),
(26, 'SUB-2026-000026', 10, 25, 'Michael Torres', 'michael@example.com', '+63 959 201 5598', NULL, '2026-06-15', '2026-06-17', 2, 1, NULL, 2, 4000.00, 8000.00, 0.00, 960.00, 8960.00, NULL, 'cancelled', 'gcash', 'unpaid', NULL, NULL, '2026-07-14 05:36:13', NULL, NULL, NULL, NULL, NULL, '2026-07-06 05:36:13', '2026-06-29 05:36:13'),
(27, 'SUB-2026-000027', 3, 51, 'Maria Santos', 'maria@example.com', '+63 949 602 3137', NULL, '2026-04-25', '2026-04-29', 2, 1, NULL, 4, 6500.00, 26000.00, 0.00, 3120.00, 29120.00, NULL, 'confirmed', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-06-19 05:36:13', NULL, NULL, NULL, NULL, '2026-06-29 05:36:13', '2026-07-10 05:36:13'),
(28, 'SUB-2026-000028', 12, 61, 'David Ramos', 'david@example.com', '+63 952 119 2899', NULL, '2026-05-15', '2026-05-18', 2, 1, NULL, 3, 6800.00, 20400.00, 0.00, 2448.00, 22848.00, NULL, 'checked_out', 'cash', 'paid', NULL, NULL, NULL, '2026-07-10 05:36:13', '2026-07-15 05:36:13', '2026-07-16 05:36:13', NULL, NULL, '2026-06-09 05:36:13', '2026-07-10 05:36:13'),
(29, 'SUB-2026-000029', 5, 72, 'Ana Reyes', 'ana@example.com', '+63 931 693 6655', NULL, '2026-05-19', '2026-05-22', 2, 1, NULL, 3, 7500.00, 22500.00, 0.00, 2700.00, 25200.00, NULL, 'checked_in', 'cash', 'paid', NULL, NULL, NULL, '2026-07-09 05:36:13', '2026-07-09 05:36:13', NULL, NULL, NULL, '2026-05-11 05:36:13', '2026-07-01 05:36:13'),
(30, 'SUB-2026-000030', 6, 14, 'Carlos Mendoza', 'carlos@example.com', '+63 958 417 9805', NULL, '2026-06-24', '2026-06-30', 2, 1, NULL, 6, 3600.00, 21600.00, 0.00, 2592.00, 24192.00, NULL, 'confirmed', 'gcash', 'paid', NULL, NULL, NULL, '2026-06-24 05:36:13', NULL, NULL, NULL, NULL, '2026-05-06 05:36:13', '2026-07-04 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `reply`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 'Markjoshua Pastoral', 'markjoshuapastoral9@gmail.com', '64646', 'Complaint', 'ung refund ko asan na', 0, NULL, NULL, '2026-07-16 04:08:10', '2026-07-16 04:08:10'),
(2, 'Markjoshua Pastoral', 'markjoshuapastoral9@gmail.com', '1123123', 'Complaint', 'saan na ung refund ko!!', 0, NULL, NULL, '2026-07-16 04:11:55', '2026-07-16 04:11:55'),
(3, 'Markjoshua Pastoral', 'markjoshuapastoral9@gmail.com', '1123123', 'Complaint', 'saan na ung refund ko!!', 1, 'okay po understood', '2026-07-16 12:49:44', '2026-07-16 04:12:49', '2026-07-16 12:49:44'),
(4, 'Markjoshua Pastoral', 'markjoshuapastoral9@gmail.com', '12312', 'Event Inquiry', 'wqeqwqweqeqeqweqwe', 1, NULL, NULL, '2026-07-16 12:16:39', '2026-07-16 12:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`description_translations`)),
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `operating_hours` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `name_translations`, `slug`, `description`, `description_translations`, `icon`, `image`, `operating_hours`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Swimming Pool', NULL, 'swimming-pool', 'Dive into our stunning outdoor swimming pool surrounded by lush tropical gardens. Available to all guests with dedicated lanes and a shallow wading area for children.', NULL, 'bi-water', NULL, '6:00 AM – 10:00 PM', 1, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(2, 'Restaurant & Dining', NULL, 'restaurant', 'Subo\'s signature restaurant serves an exquisite array of Filipino and international cuisine. From hearty breakfast buffets to intimate candlelit dinners, our culinary team crafts every dish with passion.', NULL, 'bi-cup-hot', NULL, '6:00 AM – 10:30 PM', 1, 1, 2, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(3, 'Fitness Center', NULL, 'fitness-center', 'Maintain your wellness routine with state-of-the-art equipment. Our gym features cardio machines, free weights, and dedicated zones for yoga and stretching.', NULL, 'bi-heart-pulse', NULL, '5:00 AM – 11:00 PM', 1, 1, 3, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(4, 'Spa & Wellness', NULL, 'spa', 'Surrender to tranquility at Subo Spa. Our expert therapists offer a curated menu of massages, body treatments, and facials using locally sourced, natural ingredients.', NULL, 'bi-flower1', NULL, '9:00 AM – 9:00 PM', 1, 1, 4, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(5, 'Conference Hall', NULL, 'conference-hall', 'Host impactful events in our fully equipped conference hall. With a capacity of up to 500 guests, state-of-the-art AV systems, and dedicated event coordinators.', NULL, 'bi-building', NULL, 'By appointment', 1, 1, 5, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(6, 'Wedding Venue', NULL, 'wedding-venue', 'Create the wedding of your dreams at Monarch Hotel. Our stunning grand ballroom and garden venues provide the perfect backdrop for your most special day.', NULL, 'bi-heart', NULL, 'By appointment', 1, 1, 6, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(7, 'Free Parking', NULL, 'parking', 'Complimentary secured parking for all in-house guests. Valet parking service is also available upon request.', NULL, 'bi-p-circle', NULL, '24 hours', 0, 1, 7, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(8, 'Airport Shuttle', NULL, 'airport-shuttle', 'Convenient airport transfer service available to and from NAIA and Clark International Airport. Pre-booking required.', NULL, 'bi-bus-front', NULL, 'By schedule', 0, 1, 8, '2026-07-17 05:36:13', '2026-07-17 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'hotel',
  `imageable_type` varchar(255) DEFAULT NULL,
  `imageable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `imageable_type`, `imageable_id`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Hotel Lobby', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'hotel', NULL, NULL, 1, 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(2, 'Hotel Exterior', 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', 'hotel', NULL, NULL, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(3, 'Hotel Lounge', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&q=80', 'hotel', NULL, NULL, 0, 2, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(4, 'Reception Area', 'https://images.unsplash.com/photo-1590490359854-dfb89b1b8e7a?w=800&q=80', 'hotel', NULL, NULL, 0, 3, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(5, 'Deluxe Room', 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80', 'rooms', NULL, NULL, 1, 4, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(6, 'Executive Suite', 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80', 'rooms', NULL, NULL, 1, 5, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(7, 'Presidential Suite', 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80', 'rooms', NULL, NULL, 0, 6, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(8, 'Bathroom', 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80', 'rooms', NULL, NULL, 0, 7, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(9, 'Swimming Pool', 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'facilities', NULL, NULL, 1, 8, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(10, 'Fitness Center', 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&q=80', 'facilities', NULL, NULL, 0, 9, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(11, 'Spa', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80', 'facilities', NULL, NULL, 0, 10, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(12, 'Fine Dining', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'restaurant', NULL, NULL, 1, 11, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(13, 'Breakfast Buffet', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&q=80', 'restaurant', NULL, NULL, 0, 12, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(14, 'Bar & Lounge', 'https://images.unsplash.com/photo-1510626176961-4b57d4fbad03?w=800&q=80', 'restaurant', NULL, NULL, 0, 13, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(15, 'Pool Daytime', 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800&q=80', 'pool', NULL, NULL, 1, 14, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(16, 'Pool at Night', 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80', 'pool', NULL, NULL, 0, 15, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(17, 'Wedding Venue', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&q=80', 'events', NULL, NULL, 1, 16, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(18, 'Conference Hall', 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80', 'events', NULL, NULL, 0, 17, '2026-07-17 05:36:13', '2026-07-17 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_05_095250_create_permission_tables', 1),
(5, '2026_07_05_100001_create_room_types_table', 1),
(6, '2026_07_05_100002_create_amenities_table', 1),
(7, '2026_07_05_100003_create_rooms_table', 1),
(8, '2026_07_05_100004_create_room_amenity_table', 1),
(9, '2026_07_05_100005_create_bookings_table', 1),
(10, '2026_07_05_100006_create_payments_table', 1),
(11, '2026_07_05_100007_create_facilities_table', 1),
(12, '2026_07_05_100008_create_galleries_table', 1),
(13, '2026_07_05_100009_create_promotions_table', 1),
(14, '2026_07_05_100010_create_contacts_table', 1),
(15, '2026_07_05_100011_create_settings_table', 1),
(16, '2026_07_05_100012_create_activity_logs_table', 1),
(17, '2026_07_05_100013_create_testimonials_table', 1),
(18, '2026_07_05_100014_add_role_to_users_table', 1),
(19, '2026_07_10_024932_create_personal_access_tokens_table', 1),
(20, '2026_07_10_025002_create_otp_verifications_table', 1),
(21, '2026_07_14_041004_add_two_factor_columns_to_users_table', 1),
(22, '2026_07_14_041005_create_passkeys_table', 1),
(23, '2026_07_14_050529_create_notifications_table', 1),
(24, '2026_07_14_141832_add_translations_to_rooms_table', 1),
(25, '2026_07_14_141848_add_translations_to_testimonials_table', 1),
(26, '2026_07_14_141856_add_translations_to_facilities_table', 1),
(27, '2026_07_14_161840_add_translations_to_promotions_table', 1),
(28, '2026_07_16_000001_seed_room_units_b_c_d', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('4b58e854-e217-4eb3-a96a-e97cac518017', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 13, '{\"type\":\"booking_confirmed\",\"title\":\"Booking Confirmed! \\u2705\",\"message\":\"Your booking SUB-2026-000031 for Pool Deluxe has been confirmed.\",\"booking_id\":31,\"booking_number\":\"SUB-2026-000031\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/customer\\/bookings?booking=31\",\"icon\":\"bi-check-circle\",\"color\":\"success\"}', '2026-07-16 12:50:00', '2026-07-16 12:44:59', '2026-07-16 12:50:00'),
('671ba121-1d8b-407b-b313-5e8b428e1255', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 4, '{\"type\":\"booking_confirmed\",\"title\":\"Booking Confirmed! \\u2705\",\"message\":\"Your booking SUB-2026-000014 for Mountain View Suite has been confirmed.\",\"booking_id\":14,\"booking_number\":\"SUB-2026-000014\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/customer\\/bookings?booking=14\",\"icon\":\"bi-check-circle\",\"color\":\"success\"}', NULL, '2026-07-16 12:49:10', '2026-07-16 12:49:10'),
('a406ce64-bd55-4510-9064-5236b4f23afc', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 8, '{\"type\":\"booking_confirmed\",\"title\":\"Booking Confirmed! \\u2705\",\"message\":\"Your booking SUB-2026-000021 for Pool Access Suite has been confirmed.\",\"booking_id\":21,\"booking_number\":\"SUB-2026-000021\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/customer\\/bookings?booking=21\",\"icon\":\"bi-check-circle\",\"color\":\"success\"}', NULL, '2026-07-16 12:48:52', '2026-07-16 12:48:52'),
('b9b04b35-8336-4793-9228-eb7c0b036b35', 'App\\Notifications\\NewBookingNotification', 'App\\Models\\User', 2, '{\"type\":\"new_booking\",\"title\":\"New Booking Received\",\"message\":\"Markjoshua Pastoral booked Pool Deluxe (SUB-2026-000031)\",\"booking_id\":31,\"booking_number\":\"SUB-2026-000031\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/bookings\\/31\",\"icon\":\"bi-calendar-plus\",\"color\":\"warning\"}', NULL, '2026-07-16 03:46:48', '2026-07-16 03:46:48'),
('ffeb8cfb-e2d1-43b1-b9fd-6027c905a49f', 'App\\Notifications\\NewBookingNotification', 'App\\Models\\User', 1, '{\"type\":\"new_booking\",\"title\":\"New Booking Received\",\"message\":\"Markjoshua Pastoral booked Pool Deluxe (SUB-2026-000031)\",\"booking_id\":31,\"booking_number\":\"SUB-2026-000031\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/bookings\\/31\",\"icon\":\"bi-calendar-plus\",\"color\":\"warning\"}', '2026-07-16 12:38:00', '2026-07-16 03:46:48', '2026-07-16 12:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `otp` varchar(64) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` int(11) NOT NULL DEFAULT 0,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passkeys`
--

CREATE TABLE `passkeys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credential`)),
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cash','gcash','maya','bank_transfer') NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage-rooms', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(2, 'manage-bookings', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(3, 'manage-users', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(4, 'manage-payments', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(5, 'manage-settings', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(6, 'view-reports', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(7, 'manage-gallery', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(8, 'manage-facilities', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(9, 'manage-promotions', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`title_translations`)),
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`description_translations`)),
  `image` varchar(255) DEFAULT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(8,2) NOT NULL,
  `minimum_nights` decimal(5,2) NOT NULL DEFAULT 1.00,
  `minimum_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `title_translations`, `code`, `description`, `description_translations`, `image`, `discount_type`, `discount_value`, `minimum_nights`, `minimum_amount`, `valid_from`, `valid_until`, `usage_limit`, `used_count`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Early Bird Special', NULL, 'EARLYBIRD', 'Book 30 days in advance and enjoy 20% off your stay. Valid for all room types.', NULL, NULL, 'percentage', 20.00, 1.00, 0.00, '2026-07-17', '2027-01-17', NULL, 0, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(2, 'Weekend Getaway', NULL, 'WEEKEND', 'Stay 2 nights on a weekend and save ₱1,000 on your total bill.', NULL, NULL, 'fixed', 1000.00, 2.00, 0.00, '2026-07-17', '2026-10-17', NULL, 0, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(3, 'Honeymoon Package', NULL, 'HONEYMOON', 'Celebrate love with 25% off suites plus complimentary roses and champagne.', NULL, NULL, 'percentage', 25.00, 3.00, 0.00, '2026-07-17', '2027-07-17', NULL, 0, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(4, 'Long Stay Discount', NULL, 'LONGSTAY', 'Stay 5 nights or more and get 30% off your entire booking.', NULL, NULL, 'percentage', 30.00, 5.00, 0.00, '2026-07-17', '2027-07-17', NULL, 0, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(5, 'Holiday Season Offer', NULL, 'HOLIDAY2026', 'Celebrate the holidays at Monarch Hotel with ₱2,500 off bookings of 3+ nights.', NULL, NULL, 'fixed', 2500.00, 3.00, 0.00, '2026-12-01', '2026-12-31', NULL, 0, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(2, 'staff', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(3, 'customer', 'web', '2026-07-17 05:36:10', '2026-07-17 05:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`name_translations`)),
  `description` text DEFAULT NULL,
  `description_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`description_translations`)),
  `price_per_night` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 2,
  `beds` int(11) NOT NULL DEFAULT 1,
  `bathrooms` int(11) NOT NULL DEFAULT 1,
  `floor` int(11) NOT NULL DEFAULT 1,
  `size_sqm` decimal(8,2) DEFAULT NULL,
  `has_wifi` tinyint(1) NOT NULL DEFAULT 1,
  `has_aircon` tinyint(1) NOT NULL DEFAULT 1,
  `has_tv` tinyint(1) NOT NULL DEFAULT 1,
  `has_minibar` tinyint(1) NOT NULL DEFAULT 0,
  `breakfast_included` tinyint(1) NOT NULL DEFAULT 0,
  `view` varchar(255) DEFAULT NULL,
  `status` enum('available','occupied','reserved','maintenance') NOT NULL DEFAULT 'available',
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `name`, `name_translations`, `description`, `description_translations`, `price_per_night`, `capacity`, `beds`, `bathrooms`, `floor`, `size_sqm`, `has_wifi`, `has_aircon`, `has_tv`, `has_minibar`, `breakfast_included`, `view`, `status`, `thumbnail`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, '101A', 'Garden Deluxe', NULL, 'The Garden Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3500.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/1. Garden Deluxe.png', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(2, 1, '101B', 'Garden Deluxe', NULL, 'The Garden Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3500.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/1. Garden Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(3, 1, '101C', 'Garden Deluxe', NULL, 'The Garden Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3500.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/1. Garden Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(4, 1, '101D', 'Garden Deluxe', NULL, 'The Garden Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3500.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/1. Garden Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(5, 1, '101E', 'Garden Deluxe', NULL, 'The Garden Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3500.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/1. Garden Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(6, 1, '102A', 'Pool Deluxe', NULL, 'The Pool Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3800.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/2. Pool Deluxe.png', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(7, 1, '102B', 'Pool Deluxe', NULL, 'The Pool Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3800.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/2. Pool Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(8, 1, '102C', 'Pool Deluxe', NULL, 'The Pool Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3800.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/2. Pool Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(9, 1, '102D', 'Pool Deluxe', NULL, 'The Pool Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3800.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/2. Pool Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(10, 1, '102E', 'Pool Deluxe', NULL, 'The Pool Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3800.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/2. Pool Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(11, 1, '103A', 'City Deluxe', NULL, 'The City Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3600.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/3. City Deluxe.png', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(12, 1, '103B', 'City Deluxe', NULL, 'The City Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3600.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/3. City Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(13, 1, '103C', 'City Deluxe', NULL, 'The City Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3600.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/3. City Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(14, 1, '103D', 'City Deluxe', NULL, 'The City Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3600.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/3. City Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(15, 1, '103E', 'City Deluxe', NULL, 'The City Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3600.00, 2, 1, 1, 1, 28.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/3. City Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(16, 1, '104A', 'Twin Deluxe', NULL, 'The Twin Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3700.00, 2, 2, 1, 1, 30.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/4. Twin Deluxe.png', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(17, 1, '104B', 'Twin Deluxe', NULL, 'The Twin Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3700.00, 2, 2, 1, 1, 30.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/4. Twin Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(18, 1, '104C', 'Twin Deluxe', NULL, 'The Twin Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3700.00, 2, 2, 1, 1, 30.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/4. Twin Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(19, 1, '104D', 'Twin Deluxe', NULL, 'The Twin Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3700.00, 2, 2, 1, 1, 30.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/4. Twin Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(20, 1, '104E', 'Twin Deluxe', NULL, 'The Twin Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 3700.00, 2, 2, 1, 1, 30.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/4. Twin Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(21, 1, '105A', 'Corner Deluxe', NULL, 'The Corner Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 4000.00, 2, 1, 1, 1, 32.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/5. Corner Deluxe.png', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(22, 1, '105B', 'Corner Deluxe', NULL, 'The Corner Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 4000.00, 2, 1, 1, 1, 32.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/5. Corner Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(23, 1, '105C', 'Corner Deluxe', NULL, 'The Corner Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 4000.00, 2, 1, 1, 1, 32.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/5. Corner Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(24, 1, '105D', 'Corner Deluxe', NULL, 'The Corner Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 4000.00, 2, 1, 1, 1, 32.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/5. Corner Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(25, 1, '105E', 'Corner Deluxe', NULL, 'The Corner Deluxe offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.', NULL, 4000.00, 2, 1, 1, 1, 32.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/5. Corner Deluxe.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(26, 2, '201A', 'Superior Standard', NULL, 'Experience elevated comfort in our Superior Standard. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4500.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/6. Superior Standard.jpg', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(27, 2, '201B', 'Superior Standard', NULL, 'Experience elevated comfort in our Superior Standard. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4500.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/6. Superior Standard.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(28, 2, '201C', 'Superior Standard', NULL, 'Experience elevated comfort in our Superior Standard. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4500.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/6. Superior Standard.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(29, 2, '201D', 'Superior Standard', NULL, 'Experience elevated comfort in our Superior Standard. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4500.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/6. Superior Standard.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(30, 2, '201E', 'Superior Standard', NULL, 'Experience elevated comfort in our Superior Standard. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4500.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/6. Superior Standard.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(31, 2, '202A', 'Superior Pool', NULL, 'Experience elevated comfort in our Superior Pool. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5000.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/7. Superior Pool.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(32, 2, '202B', 'Superior Pool', NULL, 'Experience elevated comfort in our Superior Pool. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5000.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/7. Superior Pool.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(33, 2, '202C', 'Superior Pool', NULL, 'Experience elevated comfort in our Superior Pool. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5000.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/7. Superior Pool.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(34, 2, '202D', 'Superior Pool', NULL, 'Experience elevated comfort in our Superior Pool. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5000.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/7. Superior Pool.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(35, 2, '202E', 'Superior Pool', NULL, 'Experience elevated comfort in our Superior Pool. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5000.00, 2, 1, 1, 2, 35.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/7. Superior Pool.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(36, 2, '203A', 'Superior Twin', NULL, 'Experience elevated comfort in our Superior Twin. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4800.00, 3, 2, 1, 2, 38.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/8. Superior Twin.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(37, 2, '203B', 'Superior Twin', NULL, 'Experience elevated comfort in our Superior Twin. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4800.00, 3, 2, 1, 2, 38.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/8. Superior Twin.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(38, 2, '203C', 'Superior Twin', NULL, 'Experience elevated comfort in our Superior Twin. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4800.00, 3, 2, 1, 2, 38.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/8. Superior Twin.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(39, 2, '203D', 'Superior Twin', NULL, 'Experience elevated comfort in our Superior Twin. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4800.00, 3, 2, 1, 2, 38.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/8. Superior Twin.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(40, 2, '203E', 'Superior Twin', NULL, 'Experience elevated comfort in our Superior Twin. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 4800.00, 3, 2, 1, 2, 38.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/8. Superior Twin.png', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(41, 2, '204A', 'Superior Deluxe', NULL, 'Experience elevated comfort in our Superior Deluxe. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5200.00, 2, 1, 1, 2, 40.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/9. Superior Deluxe.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(42, 2, '204B', 'Superior Deluxe', NULL, 'Experience elevated comfort in our Superior Deluxe. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5200.00, 2, 1, 1, 2, 40.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/9. Superior Deluxe.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(43, 2, '204C', 'Superior Deluxe', NULL, 'Experience elevated comfort in our Superior Deluxe. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5200.00, 2, 1, 1, 2, 40.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/9. Superior Deluxe.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(44, 2, '204D', 'Superior Deluxe', NULL, 'Experience elevated comfort in our Superior Deluxe. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5200.00, 2, 1, 1, 2, 40.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/9. Superior Deluxe.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(45, 2, '204E', 'Superior Deluxe', NULL, 'Experience elevated comfort in our Superior Deluxe. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5200.00, 2, 1, 1, 2, 40.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/9. Superior Deluxe.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(46, 2, '205A', 'Superior Corner', NULL, 'Experience elevated comfort in our Superior Corner. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5500.00, 2, 1, 1, 2, 42.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/10. Superior Corner.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(47, 2, '205B', 'Superior Corner', NULL, 'Experience elevated comfort in our Superior Corner. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5500.00, 2, 1, 1, 2, 42.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/10. Superior Corner.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(48, 2, '205C', 'Superior Corner', NULL, 'Experience elevated comfort in our Superior Corner. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5500.00, 2, 1, 1, 2, 42.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/10. Superior Corner.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(49, 2, '205D', 'Superior Corner', NULL, 'Experience elevated comfort in our Superior Corner. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5500.00, 2, 1, 1, 2, 42.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/10. Superior Corner.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(50, 2, '205E', 'Superior Corner', NULL, 'Experience elevated comfort in our Superior Corner. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night\'s sleep.', NULL, 5500.00, 2, 1, 1, 2, 42.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/10. Superior Corner.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(51, 3, '301A', 'Premier Classic', NULL, 'The Premier Classic defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6500.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/11. Premier Classic.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(52, 3, '301B', 'Premier Classic', NULL, 'The Premier Classic defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6500.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/11. Premier Classic.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(53, 3, '301C', 'Premier Classic', NULL, 'The Premier Classic defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6500.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/11. Premier Classic.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(54, 3, '301D', 'Premier Classic', NULL, 'The Premier Classic defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6500.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/11. Premier Classic.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(55, 3, '301E', 'Premier Classic', NULL, 'The Premier Classic defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6500.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/11. Premier Classic.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(56, 3, '302A', 'Premier Pool View', NULL, 'The Premier Pool View defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7000.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/12. Premier Pool View.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(57, 3, '302B', 'Premier Pool View', NULL, 'The Premier Pool View defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7000.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/12. Premier Pool View.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(58, 3, '302C', 'Premier Pool View', NULL, 'The Premier Pool View defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7000.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/12. Premier Pool View.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(59, 3, '302D', 'Premier Pool View', NULL, 'The Premier Pool View defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7000.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/12. Premier Pool View.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(60, 3, '302E', 'Premier Pool View', NULL, 'The Premier Pool View defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7000.00, 2, 1, 1, 3, 45.00, 1, 1, 1, 0, 0, 'Pool', 'available', 'images/rooms/12. Premier Pool View.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(61, 3, '303A', 'Premier Garden', NULL, 'The Premier Garden defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6800.00, 2, 1, 1, 3, 48.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/13. Premier Garden.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(62, 3, '303B', 'Premier Garden', NULL, 'The Premier Garden defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6800.00, 2, 1, 1, 3, 48.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/13. Premier Garden.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(63, 3, '303C', 'Premier Garden', NULL, 'The Premier Garden defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6800.00, 2, 1, 1, 3, 48.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/13. Premier Garden.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(64, 3, '303D', 'Premier Garden', NULL, 'The Premier Garden defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6800.00, 2, 1, 1, 3, 48.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/13. Premier Garden.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(65, 3, '303E', 'Premier Garden', NULL, 'The Premier Garden defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 6800.00, 2, 1, 1, 3, 48.00, 1, 1, 1, 0, 0, 'Garden', 'available', 'images/rooms/13. Premier Garden.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(66, 3, '304A', 'Premier Twin', NULL, 'The Premier Twin defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7200.00, 3, 2, 1, 3, 50.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/14. Premier Twin.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(67, 3, '304B', 'Premier Twin', NULL, 'The Premier Twin defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7200.00, 3, 2, 1, 3, 50.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/14. Premier Twin.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(68, 3, '304C', 'Premier Twin', NULL, 'The Premier Twin defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7200.00, 3, 2, 1, 3, 50.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/14. Premier Twin.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(69, 3, '304D', 'Premier Twin', NULL, 'The Premier Twin defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7200.00, 3, 2, 1, 3, 50.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/14. Premier Twin.jpg', 0, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(70, 3, '304E', 'Premier Twin', NULL, 'The Premier Twin defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.', NULL, 7200.00, 3, 2, 1, 3, 50.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/14. Premier Twin.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(71, 3, '305A', 'Premier Executive', NULL, 'The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.', NULL, 7500.00, 2, 1, 1, 3, 52.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/15. Premier Executive.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(72, 3, '305B', 'Premier Executive', NULL, 'The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.', NULL, 7500.00, 2, 1, 1, 3, 52.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/15. Premier Executive.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(73, 3, '305C', 'Premier Executive', NULL, 'The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.', NULL, 7500.00, 2, 1, 1, 3, 52.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/15. Premier Executive.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(74, 3, '305D', 'Premier Executive', NULL, 'The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.', NULL, 7500.00, 2, 1, 1, 3, 52.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/15. Premier Executive.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(75, 3, '305E', 'Premier Executive', NULL, 'The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.', NULL, 7500.00, 2, 1, 1, 3, 52.00, 1, 1, 1, 0, 0, 'City', 'available', 'images/rooms/15. Premier Executive.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(76, 4, '401A', 'Executive Classic', NULL, 'Our Executive Classic is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 9500.00, 2, 1, 1, 4, 60.00, 1, 1, 1, 1, 0, 'City', 'available', 'images/rooms/16. Executive Classic.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(77, 4, '401B', 'Executive Classic', NULL, 'Our Executive Classic is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 9500.00, 2, 1, 1, 4, 60.00, 1, 1, 1, 1, 0, 'City', 'available', 'images/rooms/16. Executive Classic.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(78, 4, '401C', 'Executive Classic', NULL, 'Our Executive Classic is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 9500.00, 2, 1, 1, 4, 60.00, 1, 1, 1, 1, 0, 'City', 'available', 'images/rooms/16. Executive Classic.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(79, 4, '401D', 'Executive Classic', NULL, 'Our Executive Classic is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 9500.00, 2, 1, 1, 4, 60.00, 1, 1, 1, 1, 0, 'City', 'available', 'images/rooms/16. Executive Classic.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(80, 4, '401E', 'Executive Classic', NULL, 'Our Executive Classic is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 9500.00, 2, 1, 1, 4, 60.00, 1, 1, 1, 1, 0, 'City', 'available', 'images/rooms/16. Executive Classic.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(81, 4, '402A', 'Executive Deluxe', NULL, 'The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.', NULL, 10000.00, 2, 1, 1, 4, 62.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/17. Executive Deluxe.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(82, 4, '402B', 'Executive Deluxe', NULL, 'The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.', NULL, 10000.00, 2, 1, 1, 4, 62.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/17. Executive Deluxe.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(83, 4, '402C', 'Executive Deluxe', NULL, 'The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.', NULL, 10000.00, 2, 1, 1, 4, 62.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/17. Executive Deluxe.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(84, 4, '402D', 'Executive Deluxe', NULL, 'The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.', NULL, 10000.00, 2, 1, 1, 4, 62.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/17. Executive Deluxe.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(85, 4, '402E', 'Executive Deluxe', NULL, 'The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.', NULL, 10000.00, 2, 1, 1, 4, 62.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/17. Executive Deluxe.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(86, 4, '403A', 'Executive Suite', NULL, 'Our Executive Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 10500.00, 2, 1, 1, 4, 65.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/18. Executive Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(87, 4, '403B', 'Executive Suite', NULL, 'Our Executive Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 10500.00, 2, 1, 1, 4, 65.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/18. Executive Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(88, 4, '403C', 'Executive Suite', NULL, 'Our Executive Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 10500.00, 2, 1, 1, 4, 65.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/18. Executive Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(89, 4, '403D', 'Executive Suite', NULL, 'Our Executive Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 10500.00, 2, 1, 1, 4, 65.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/18. Executive Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(90, 4, '403E', 'Executive Suite', NULL, 'Our Executive Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 10500.00, 2, 1, 1, 4, 65.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/18. Executive Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(91, 4, '404A', 'Executive Pool Suite', NULL, 'Our Executive Pool Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 11000.00, 4, 2, 1, 4, 70.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/19. Executive Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(92, 4, '404B', 'Executive Pool Suite', NULL, 'Our Executive Pool Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 11000.00, 4, 2, 1, 4, 70.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/19. Executive Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(93, 4, '404C', 'Executive Pool Suite', NULL, 'Our Executive Pool Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 11000.00, 4, 2, 1, 4, 70.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/19. Executive Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(94, 4, '404D', 'Executive Pool Suite', NULL, 'Our Executive Pool Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 11000.00, 4, 2, 1, 4, 70.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/19. Executive Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(95, 4, '404E', 'Executive Pool Suite', NULL, 'Our Executive Pool Suite is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.', NULL, 11000.00, 4, 2, 1, 4, 70.00, 1, 1, 1, 1, 0, 'Pool', 'available', 'images/rooms/19. Executive Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(96, 4, '405A', 'Executive Garden Suite', NULL, 'Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.', NULL, 11500.00, 4, 2, 1, 4, 72.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/20. Executive Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(97, 4, '405B', 'Executive Garden Suite', NULL, 'Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.', NULL, 11500.00, 4, 2, 1, 4, 72.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/20. Executive Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(98, 4, '405C', 'Executive Garden Suite', NULL, 'Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.', NULL, 11500.00, 4, 2, 1, 4, 72.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/20. Executive Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(99, 4, '405D', 'Executive Garden Suite', NULL, 'Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.', NULL, 11500.00, 4, 2, 1, 4, 72.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/20. Executive Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(100, 4, '405E', 'Executive Garden Suite', NULL, 'Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.', NULL, 11500.00, 4, 2, 1, 4, 72.00, 1, 1, 1, 1, 0, 'Garden', 'available', 'images/rooms/20. Executive Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(101, 5, '501A', 'Family Suite', NULL, 'Designed with families in mind, the Family Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 13000.00, 5, 3, 2, 5, 80.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/21. Family Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(102, 5, '501B', 'Family Suite', NULL, 'Designed with families in mind, the Family Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 13000.00, 5, 3, 2, 5, 80.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/21. Family Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(103, 5, '501C', 'Family Suite', NULL, 'Designed with families in mind, the Family Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 13000.00, 5, 3, 2, 5, 80.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/21. Family Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(104, 5, '501D', 'Family Suite', NULL, 'Designed with families in mind, the Family Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 13000.00, 5, 3, 2, 5, 80.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/21. Family Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(105, 5, '501E', 'Family Suite', NULL, 'Designed with families in mind, the Family Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 13000.00, 5, 3, 2, 5, 80.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/21. Family Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(106, 5, '502A', 'Family Pool Suite', NULL, 'Designed with families in mind, the Family Pool Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 14500.00, 6, 3, 2, 5, 85.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/22. Family Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(107, 5, '502B', 'Family Pool Suite', NULL, 'Designed with families in mind, the Family Pool Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 14500.00, 6, 3, 2, 5, 85.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/22. Family Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(108, 5, '502C', 'Family Pool Suite', NULL, 'Designed with families in mind, the Family Pool Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 14500.00, 6, 3, 2, 5, 85.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/22. Family Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(109, 5, '502D', 'Family Pool Suite', NULL, 'Designed with families in mind, the Family Pool Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 14500.00, 6, 3, 2, 5, 85.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/22. Family Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(110, 5, '502E', 'Family Pool Suite', NULL, 'Designed with families in mind, the Family Pool Suite provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.', NULL, 14500.00, 6, 3, 2, 5, 85.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/22. Family Pool Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(111, 5, '503A', 'Family Garden Suite', NULL, 'The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.', NULL, 15000.00, 6, 3, 2, 5, 88.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/23. Family Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(112, 5, '503B', 'Family Garden Suite', NULL, 'The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.', NULL, 15000.00, 6, 3, 2, 5, 88.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/23. Family Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(113, 5, '503C', 'Family Garden Suite', NULL, 'The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.', NULL, 15000.00, 6, 3, 2, 5, 88.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/23. Family Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(114, 5, '503D', 'Family Garden Suite', NULL, 'The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.', NULL, 15000.00, 6, 3, 2, 5, 88.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/23. Family Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(115, 5, '503E', 'Family Garden Suite', NULL, 'The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.', NULL, 15000.00, 6, 3, 2, 5, 88.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/23. Family Garden Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(116, 6, '601A', 'Honeymoon Suite', NULL, 'Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.', NULL, 20000.00, 2, 1, 1, 6, 100.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/24. Honeymoon Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(117, 6, '601B', 'Honeymoon Suite', NULL, 'Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.', NULL, 20000.00, 2, 1, 1, 6, 100.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/24. Honeymoon Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(118, 6, '601C', 'Honeymoon Suite', NULL, 'Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.', NULL, 20000.00, 2, 1, 1, 6, 100.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/24. Honeymoon Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(119, 6, '601D', 'Honeymoon Suite', NULL, 'Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.', NULL, 20000.00, 2, 1, 1, 6, 100.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/24. Honeymoon Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(120, 6, '601E', 'Honeymoon Suite', NULL, 'Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.', NULL, 20000.00, 2, 1, 1, 6, 100.00, 1, 1, 1, 1, 1, 'Garden', 'available', 'images/rooms/24. Honeymoon Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(121, 6, '602A', 'Presidential Suite', NULL, 'The pinnacle of Monarch Hotel luxury. The Presidential Suite offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.', NULL, 25000.00, 4, 2, 1, 6, 120.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/25. Presidential Suite.jpg', 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(122, 6, '602B', 'Presidential Suite', NULL, 'The pinnacle of Monarch Hotel luxury. The Presidential Suite offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.', NULL, 25000.00, 4, 2, 1, 6, 120.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/25. Presidential Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(123, 6, '602C', 'Presidential Suite', NULL, 'The pinnacle of Monarch Hotel luxury. The Presidential Suite offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.', NULL, 25000.00, 4, 2, 1, 6, 120.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/25. Presidential Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(124, 6, '602D', 'Presidential Suite', NULL, 'The pinnacle of Monarch Hotel luxury. The Presidential Suite offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.', NULL, 25000.00, 4, 2, 1, 6, 120.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/25. Presidential Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(125, 6, '602E', 'Presidential Suite', NULL, 'The pinnacle of Monarch Hotel luxury. The Presidential Suite offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.', NULL, 25000.00, 4, 2, 1, 6, 120.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/25. Presidential Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(126, 6, '603A', 'Penthouse Suite', NULL, 'The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.', NULL, 28000.00, 4, 2, 1, 6, 130.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/26. Penthouse Suite.jpg', 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(127, 6, '603B', 'Penthouse Suite', NULL, 'The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.', NULL, 28000.00, 4, 2, 1, 6, 130.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/26. Penthouse Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(128, 6, '603C', 'Penthouse Suite', NULL, 'The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.', NULL, 28000.00, 4, 2, 1, 6, 130.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/26. Penthouse Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(129, 6, '603D', 'Penthouse Suite', NULL, 'The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.', NULL, 28000.00, 4, 2, 1, 6, 130.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/26. Penthouse Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(130, 6, '603E', 'Penthouse Suite', NULL, 'The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.', NULL, 28000.00, 4, 2, 1, 6, 130.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/26. Penthouse Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(131, 6, '604A', 'Ocean View Suite', NULL, 'Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.', NULL, 22000.00, 2, 1, 1, 6, 110.00, 1, 1, 1, 1, 1, 'Ocean', 'available', 'images/rooms/27. Ocean View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(132, 6, '604B', 'Ocean View Suite', NULL, 'Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.', NULL, 22000.00, 2, 1, 1, 6, 110.00, 1, 1, 1, 1, 1, 'Ocean', 'available', 'images/rooms/27. Ocean View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(133, 6, '604C', 'Ocean View Suite', NULL, 'Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.', NULL, 22000.00, 2, 1, 1, 6, 110.00, 1, 1, 1, 1, 1, 'Ocean', 'available', 'images/rooms/27. Ocean View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `name`, `name_translations`, `description`, `description_translations`, `price_per_night`, `capacity`, `beds`, `bathrooms`, `floor`, `size_sqm`, `has_wifi`, `has_aircon`, `has_tv`, `has_minibar`, `breakfast_included`, `view`, `status`, `thumbnail`, `is_featured`, `created_at`, `updated_at`) VALUES
(134, 6, '604D', 'Ocean View Suite', NULL, 'Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.', NULL, 22000.00, 2, 1, 1, 6, 110.00, 1, 1, 1, 1, 1, 'Ocean', 'available', 'images/rooms/27. Ocean View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(135, 6, '604E', 'Ocean View Suite', NULL, 'Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.', NULL, 22000.00, 2, 1, 1, 6, 110.00, 1, 1, 1, 1, 1, 'Ocean', 'available', 'images/rooms/27. Ocean View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(136, 6, '605A', 'Mountain View Suite', NULL, 'Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.', NULL, 21000.00, 2, 1, 1, 6, 105.00, 1, 1, 1, 1, 1, 'Mountain', 'available', 'images/rooms/28. Mountain View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(137, 6, '605B', 'Mountain View Suite', NULL, 'Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.', NULL, 21000.00, 2, 1, 1, 6, 105.00, 1, 1, 1, 1, 1, 'Mountain', 'available', 'images/rooms/28. Mountain View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(138, 6, '605C', 'Mountain View Suite', NULL, 'Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.', NULL, 21000.00, 2, 1, 1, 6, 105.00, 1, 1, 1, 1, 1, 'Mountain', 'available', 'images/rooms/28. Mountain View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(139, 6, '605D', 'Mountain View Suite', NULL, 'Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.', NULL, 21000.00, 2, 1, 1, 6, 105.00, 1, 1, 1, 1, 1, 'Mountain', 'available', 'images/rooms/28. Mountain View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(140, 6, '605E', 'Mountain View Suite', NULL, 'Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.', NULL, 21000.00, 2, 1, 1, 6, 105.00, 1, 1, 1, 1, 1, 'Mountain', 'available', 'images/rooms/28. Mountain View Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(141, 6, '606A', 'Pool Access Suite', NULL, 'Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.', NULL, 23000.00, 3, 2, 1, 6, 115.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/29. Pool Access Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(142, 6, '606B', 'Pool Access Suite', NULL, 'Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.', NULL, 23000.00, 3, 2, 1, 6, 115.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/29. Pool Access Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(143, 6, '606C', 'Pool Access Suite', NULL, 'Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.', NULL, 23000.00, 3, 2, 1, 6, 115.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/29. Pool Access Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(144, 6, '606D', 'Pool Access Suite', NULL, 'Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.', NULL, 23000.00, 3, 2, 1, 6, 115.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/29. Pool Access Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(145, 6, '606E', 'Pool Access Suite', NULL, 'Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.', NULL, 23000.00, 3, 2, 1, 6, 115.00, 1, 1, 1, 1, 1, 'Pool', 'available', 'images/rooms/29. Pool Access Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(146, 6, '607A', 'Royal Suite', NULL, 'The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.', NULL, 35000.00, 6, 3, 2, 6, 150.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/30. Royal Suite.jpg', 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(147, 6, '607B', 'Royal Suite', NULL, 'The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.', NULL, 35000.00, 6, 3, 2, 6, 150.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/30. Royal Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(148, 6, '607C', 'Royal Suite', NULL, 'The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.', NULL, 35000.00, 6, 3, 2, 6, 150.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/30. Royal Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(149, 6, '607D', 'Royal Suite', NULL, 'The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.', NULL, 35000.00, 6, 3, 2, 6, 150.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/30. Royal Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(150, 6, '607E', 'Royal Suite', NULL, 'The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.', NULL, 35000.00, 6, 3, 2, 6, 150.00, 1, 1, 1, 1, 1, 'Panoramic', 'available', 'images/rooms/30. Royal Suite.jpg', 0, '2026-07-17 05:36:13', '2026-07-17 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `slug`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Deluxe Room', 'deluxe-room', 'Comfortable and elegantly furnished with modern amenities.', 'bi-door-open', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(2, 'Superior Room', 'superior-room', 'A step above standard, offering more space and premium furnishings.', 'bi-star', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(3, 'Premier Room', 'premier-room', 'Premium room with exceptional views and luxury fittings.', 'bi-star-fill', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(4, 'Executive Suite', 'executive-suite', 'Spacious suite with separate living area, ideal for business travelers.', 'bi-briefcase', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(5, 'Family Suite', 'family-suite', 'Designed for families, with multiple sleeping areas and extra space.', 'bi-people', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(6, 'Presidential Suite', 'presidential-suite', 'The pinnacle of luxury — our most exclusive accommodation.', 'bi-gem', 1, '2026-07-17 05:36:12', '2026-07-17 05:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'hotel_name', 'Monarch Hotel', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(2, 'hotel_tagline', 'Where Luxury Meets Comfort', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(3, 'hotel_email', 'info@monarchhotel.com', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(4, 'hotel_phone', '+63 75 123 4567', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(5, 'hotel_address', 'Calasiao, Pangasinan, Philippines 2418', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(6, 'hotel_description', 'Monarch Hotel offers world-class accommodations in the heart of Calasiao, Pangasinan. Experience luxury, comfort, and impeccable Filipino hospitality.', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(7, 'check_in_time', '2:00 PM', 'policy', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(8, 'check_out_time', '12:00 PM', 'policy', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(9, 'tax_rate', '12', 'policy', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(10, 'currency', '₱', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(11, 'facebook_url', 'https://facebook.com/subohotel', 'social', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(12, 'instagram_url', 'https://instagram.com/subohotel', 'social', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(13, 'twitter_url', 'https://twitter.com/subohotel', 'social', '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(14, 'google_maps_url', 'https://maps.google.com/?q=Calasiao+Pangasinan', 'general', '2026-07-17 05:36:10', '2026-07-17 05:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_name_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`guest_name_translations`)),
  `guest_location` varchar(255) DEFAULT NULL,
  `guest_location_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`guest_location_translations`)),
  `avatar` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `content_translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content_translations`)),
  `rating` int(11) NOT NULL DEFAULT 5,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `guest_name`, `guest_name_translations`, `guest_location`, `guest_location_translations`, `avatar`, `content`, `content_translations`, `rating`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Maria Santos', NULL, 'Manila, Philippines', NULL, NULL, 'Absolutely stunning hotel! The Presidential Suite exceeded all our expectations. The staff was incredibly attentive and the food at the restaurant was world-class. We will definitely return!', NULL, 5, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(2, 'James Wilson', NULL, 'Singapore', NULL, NULL, 'Monarch Hotel is a hidden gem in Pangasinan. The swimming pool area is beautiful, the rooms are spotless, and the service is impeccable. Perfect for a romantic getaway.', NULL, 5, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(3, 'Ana Reyes', NULL, 'Cebu City, Philippines', NULL, NULL, 'We hosted our wedding reception here and it was magical. The event team went above and beyond to make our special day perfect. The ballroom looked absolutely gorgeous!', NULL, 5, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(4, 'David Chen', NULL, 'Hong Kong', NULL, NULL, 'Great business hotel. The conference facilities are modern and well-equipped. The executive suite was comfortable and the breakfast selection was impressive. Good value for money.', NULL, 4, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(5, 'Grace Villanueva', NULL, 'Dagupan City, PH', NULL, NULL, 'The spa experience was divine! The therapists are highly skilled and the ambiance is incredibly relaxing. The family suite was perfect for our whole family. Highly recommended!', NULL, 5, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13'),
(6, 'Robert Kim', NULL, 'South Korea', NULL, NULL, 'Very comfortable stay. Clean rooms, friendly staff, and excellent facilities. The location is convenient and the food is delicious. Will definitely book again on my next Philippines trip.', NULL, 4, 1, 1, '2026-07-17 05:36:13', '2026-07-17 05:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff','customer') NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `avatar`, `role`, `is_active`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin Subo', 'admin@monarchhotel.com', '+63 912 345 6789', 'Calasiao, Pangasinan, Philippines', NULL, 'admin', 1, '2026-07-17 05:36:10', '$2y$12$tf.ZBMGqRfUywbExCWiMXOiXXc7/fLXgk6nEqO4cSQfoCby0rUdM2', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(2, 'Staff Member', 'staff@monarchhotel.com', '+63 912 345 6780', 'Dagupan City, Pangasinan', NULL, 'staff', 1, '2026-07-17 05:36:10', '$2y$12$/X4Eq0GGo9Zltzf379nLP.BeGXNPKYn6dDE4fJNeCW4kKOKlzhh72', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(3, 'Maria Santos', 'maria@example.com', '+63 949 602 3137', NULL, NULL, 'customer', 1, '2026-07-17 05:36:10', '$2y$12$YbxK9O23szGTwAUg2g1vLuayJkj.pYhDW0scn4cZ/sycD/K5B8WA2', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(4, 'Juan dela Cruz', 'juan@example.com', '+63 982 728 3897', NULL, NULL, 'customer', 1, '2026-07-17 05:36:10', '$2y$12$jjNojZtFcesQgQX7ntrBiuej4ZYddN6lsPKM04M2DnZ44okmQNgL2', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:10', '2026-07-17 05:36:10'),
(5, 'Ana Reyes', 'ana@example.com', '+63 931 693 6655', NULL, NULL, 'customer', 1, '2026-07-17 05:36:11', '$2y$12$Vkgdk/JC1SF0hjBe0NO3muJy.xLQ/MofGZPa6OVjNjmWSNrajQevm', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:11', '2026-07-17 05:36:11'),
(6, 'Carlos Mendoza', 'carlos@example.com', '+63 958 417 9805', NULL, NULL, 'customer', 1, '2026-07-17 05:36:11', '$2y$12$xzmxzx2IqsgGQ1ndnKWrB.WicPSBx23l381MHaxwXegR2bDYh0G4e', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:11', '2026-07-17 05:36:11'),
(7, 'Grace Villanueva', 'grace@example.com', '+63 967 698 6119', NULL, NULL, 'customer', 1, '2026-07-17 05:36:11', '$2y$12$4QGtSK9x5FycFsrl.iAOfepJ2wC5DgO7egHzd2bqrlL1Fo4Bn73Zq', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:11', '2026-07-17 05:36:11'),
(8, 'Robert Lim', 'robert@example.com', '+63 954 340 9177', NULL, NULL, 'customer', 1, '2026-07-17 05:36:11', '$2y$12$Qn7XbwhaIvMA/kWJVIQH/exT.bTDkw/H941LMopTqDPA1ERq3U2Re', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:11', '2026-07-17 05:36:11'),
(9, 'Patricia Cruz', 'patricia@example.com', '+63 934 672 2854', NULL, NULL, 'customer', 1, '2026-07-17 05:36:11', '$2y$12$wJVoVJFLGJtUOTD/eJ2gT.s1bFn05wMiYB9nfzyDigYyvmabI.bJ.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:11', '2026-07-17 05:36:11'),
(10, 'Michael Torres', 'michael@example.com', '+63 959 201 5598', NULL, NULL, 'customer', 1, '2026-07-17 05:36:12', '$2y$12$HQ9ATgDs7xACK8cy1v7Xsek8Cmfai3hyHrfWdPjF9JqVQ8kQ.LtrW', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(11, 'Jennifer Bautista', 'jennifer@example.com', '+63 975 413 9051', NULL, NULL, 'customer', 1, '2026-07-17 05:36:12', '$2y$12$9jzL54hol3rEmJE2ru.48OhcdCElxp8GUe3ktSuY/Bb8aF5AWsyce', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(12, 'David Ramos', 'david@example.com', '+63 952 119 2899', NULL, NULL, 'customer', 1, '2026-07-17 05:36:12', '$2y$12$tzYobJCoIQXv9vW7d3k49el3ZK5XDw/ieCtD4V2MIQ6xmt05AsWUC', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-17 05:36:12', '2026-07-17 05:36:12'),
(13, 'Markjoshua Pastoral', 'markjoshuapastoral9@gmail.com', '123123', NULL, NULL, 'customer', 1, NULL, '$2y$12$Ii5nQnCiZWVcRkXWjUbS/OdqDu92.sj2wjx86G8Dt8.2jCpkK9Vmq', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-16 03:41:11', '2026-07-16 03:41:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_room`
--
ALTER TABLE `amenity_room`
  ADD PRIMARY KEY (`room_id`,`amenity_id`),
  ADD KEY `amenity_room_amenity_id_foreign` (`amenity_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_number_unique` (`booking_number`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facilities_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `passkeys`
--
ALTER TABLE `passkeys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  ADD KEY `passkeys_user_id_index` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_reference_number_unique` (`reference_number`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotions_code_unique` (`code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_types_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passkeys`
--
ALTER TABLE `passkeys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `amenity_room`
--
ALTER TABLE `amenity_room`
  ADD CONSTRAINT `amenity_room_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amenity_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD CONSTRAINT `otp_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `passkeys`
--
ALTER TABLE `passkeys`
  ADD CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
