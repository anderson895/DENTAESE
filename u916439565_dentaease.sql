-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 10, 2026 at 03:30 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u916439565_dentaease`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dentist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `booking_end_time` time DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `arrived_at` timestamp NULL DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `work_done` text DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_image` varchar(255) DEFAULT NULL,
  `service_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`service_ids`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `store_id`, `user_id`, `dentist_id`, `appointment_date`, `appointment_time`, `booking_end_time`, `status`, `arrived_at`, `desc`, `created_at`, `updated_at`, `work_done`, `total_price`, `payment_type`, `payment_image`, `service_ids`) VALUES
(33, 1, 12, 26, '2026-01-16', '11:00:00', '11:15:00', 'cancelled', NULL, 'ad', '2026-01-14 17:12:29', '2026-01-19 08:49:17', 'test', 500.00, 'GCASH', NULL, '[\"1\"]'),
(34, 2, 12, 30, '2026-01-23', '16:00:00', '18:30:00', 'completed', NULL, 'aaaa', '2026-01-14 18:49:34', '2026-01-14 22:30:05', 'dsddsd', 3000.00, 'GCASH', NULL, '[\"2\"]'),
(35, 4, 12, 30, '2026-01-22', '22:00:00', '00:30:00', 'cancelled', NULL, NULL, '2026-01-14 19:03:15', '2026-01-14 19:04:19', NULL, NULL, NULL, NULL, '[\"4\",\"7\"]'),
(36, 2, 12, 30, '2026-01-22', '16:00:00', '19:30:00', 'completed', NULL, NULL, '2026-01-14 19:04:59', '2026-01-14 22:29:34', 'awdwadawd', 3000.00, 'GCASH', NULL, '[\"5\",\"6\",\"7\"]'),
(37, 2, 45, 30, '2026-01-24', '11:00:00', '11:30:00', 'completed', NULL, 'th', '2026-01-14 22:30:37', '2026-01-18 17:20:06', NULL, 6000.00, 'GCASH', NULL, '[3]'),
(38, 2, 12, 30, '2026-01-15', '16:00:00', '19:30:00', 'completed', NULL, NULL, '2026-01-14 22:32:36', '2026-01-21 04:33:16', NULL, 1200.00, 'GCASH', NULL, '[\"2\",\"3\",\"4\"]'),
(41, 1, 59, 26, '2026-01-17', '13:00:00', '14:30:00', 'completed', NULL, NULL, '2026-01-16 02:38:52', '2026-01-26 01:54:20', 'Extraction', 500.00, 'GCASH', NULL, '[\"5\",\"6\"]'),
(46, 1, 45, 26, '2026-01-19', '09:56:00', '10:11:00', 'completed', NULL, 'awdawd', '2026-01-19 09:56:49', '2026-01-31 08:25:51', 'asdcvbnmn,', 1000.00, 'GCASH', NULL, '[1]'),
(47, 2, 42, 30, '2026-01-19', '10:04:00', '10:49:00', 'completed', NULL, 'Yeah', '2026-01-19 10:04:14', '2026-01-19 10:05:31', 'nice dok', 3000.00, 'GCASH', NULL, '[6]'),
(48, 2, 45, 30, '2026-01-19', '11:57:00', '12:27:00', 'completed', NULL, 'essfe', '2026-01-19 11:57:54', '2026-03-01 21:22:28', NULL, 600.00, 'GCASH', NULL, '[4]'),
(49, 1, 13, 26, '2026-01-19', '12:02:00', '12:47:00', 'completed', NULL, 'awdawd', '2026-01-19 12:02:09', '2026-01-20 16:07:19', 'Pagaling ka', 2000.00, 'GCASH', NULL, '[6]'),
(51, 2, 43, 30, '2026-01-19', '12:28:00', '12:58:00', 'completed', NULL, 'dada', '2026-01-19 12:28:33', '2026-01-31 16:15:25', NULL, 600.00, 'CASH', NULL, '[3]'),
(53, 1, 18, 26, '2026-01-19', '12:34:00', '13:04:00', 'completed', NULL, 'hj', '2026-01-19 12:34:03', '2026-03-05 19:44:50', 'yeah yeah yeah', 5000.00, 'GCASH', NULL, '[4]'),
(54, 2, 64, 30, '2026-01-23', '10:00:00', '10:45:00', 'cancelled', NULL, 'awdwa', '2026-01-19 13:03:18', '2026-01-20 13:30:17', NULL, NULL, NULL, NULL, '[5]'),
(55, 4, 42, 30, '2026-01-24', '22:00:00', '22:30:00', 'approved', NULL, 'rerg', '2026-01-19 13:04:01', '2026-02-25 14:59:06', NULL, NULL, NULL, NULL, '[4]'),
(56, 4, 36, 30, '2026-01-24', '22:30:00', '23:00:00', 'pending', NULL, NULL, '2026-01-19 13:26:03', '2026-01-19 13:26:03', NULL, NULL, NULL, NULL, '[4]'),
(60, 2, 11, 30, '2026-01-19', '13:36:00', '14:06:00', 'completed', NULL, NULL, '2026-01-19 13:36:18', '2026-01-19 13:37:34', NULL, 1500.00, 'GCASH', NULL, '[4]'),
(63, 2, 66, 30, '2026-01-26', '20:00:00', '20:15:00', 'approved', NULL, NULL, '2026-01-21 07:33:02', '2026-02-01 07:33:43', NULL, NULL, NULL, NULL, '[\"1\"]'),
(64, 1, 13, 26, '2026-01-28', '06:00:00', '08:00:00', 'completed', NULL, NULL, '2026-01-28 02:15:39', '2026-03-06 10:52:35', 'asd', 5000.00, 'GCASH', NULL, '[7]'),
(65, 1, 54, 26, '2026-01-31', '10:00:00', '10:15:00', 'approved', NULL, NULL, '2026-01-30 08:24:56', '2026-01-31 18:10:26', NULL, NULL, NULL, NULL, '[\"1\"]'),
(66, 4, 67, 30, '2026-02-03', '22:00:00', '22:15:00', 'pending', NULL, NULL, '2026-01-31 03:14:02', '2026-01-31 03:14:02', NULL, NULL, NULL, NULL, '[1]'),
(67, 1, 42, 26, '2026-01-31', '06:00:00', '06:30:00', 'completed', NULL, NULL, '2026-01-31 03:14:34', '2026-01-31 03:14:53', 'yeagh', 500.00, 'GCASH', NULL, '[2]'),
(68, 1, 38, 26, '2026-02-05', '10:00:00', '10:30:00', 'approved', NULL, NULL, '2026-01-31 16:11:05', '2026-02-25 16:21:08', NULL, NULL, NULL, NULL, '[\"2\"]'),
(69, 1, 43, 26, '2026-02-07', '10:00:00', '10:30:00', 'completed', NULL, NULL, '2026-01-31 16:16:32', '2026-02-13 09:13:49', NULL, 100.00, 'CASH', NULL, '[\"2\"]'),
(71, 1, 43, 26, '2026-02-13', '09:16:00', '09:31:00', 'approved', NULL, NULL, '2026-02-13 09:16:25', '2026-02-13 09:16:25', NULL, NULL, NULL, NULL, '[1]'),
(72, 1, 70, 26, '2026-02-13', '10:31:00', '10:46:00', 'approved', NULL, NULL, '2026-02-13 09:34:03', '2026-02-13 09:35:14', NULL, NULL, NULL, NULL, '[\"1\"]'),
(74, 1, 12, 26, '2026-02-13', '12:46:00', '13:16:00', 'completed', NULL, NULL, '2026-02-13 13:04:09', '2026-02-13 13:26:35', 'Umiwas sa malansang pagkain', 500.00, 'GCASH', NULL, '[\"2\"]'),
(75, 1, 12, 26, '2026-02-13', '15:16:00', '15:46:00', 'completed', NULL, 'palinis po', '2026-02-13 13:27:53', '2026-03-04 16:40:26', NULL, 5000.00, 'GCASH', NULL, '[\"2\"]'),
(78, 2, 42, 30, '2026-02-23', '18:14:00', '18:29:00', 'arrived', NULL, NULL, '2026-02-23 18:14:35', '2026-02-23 18:14:35', NULL, NULL, NULL, NULL, '[1]'),
(79, 1, 72, 26, '2026-02-24', '17:00:00', '17:15:00', 'completed', NULL, NULL, '2026-02-24 18:14:08', '2026-02-24 18:27:35', NULL, 2000.00, 'GCASH', NULL, '[\"2\",\"3\"]'),
(80, 1, 77, 31, '2026-02-26', '13:00:00', '13:45:00', 'approved', NULL, NULL, '2026-02-25 15:24:19', '2026-02-25 16:13:26', NULL, NULL, NULL, NULL, '[\"5\"]'),
(82, 4, 78, 30, '2026-02-27', '22:00:00', '22:30:00', 'cancelled', NULL, NULL, '2026-02-26 14:52:58', '2026-02-26 14:55:11', NULL, NULL, NULL, NULL, '[\"3\"]'),
(83, 1, 78, 31, '2026-02-26', '13:45:00', '14:00:00', 'completed', NULL, NULL, '2026-02-26 14:56:50', '2026-02-26 15:06:08', NULL, 600.00, 'GCASH', NULL, '[\"1\"]'),
(84, 2, 79, 30, '2026-03-02', '15:00:00', '15:45:00', 'completed', NULL, 'hahah', '2026-03-01 21:11:55', '2026-03-01 21:13:59', NULL, 3000.00, 'GCASH', NULL, '[\"6\"]'),
(85, 2, 79, 30, '2026-03-02', '15:45:00', '16:15:00', 'approved', NULL, NULL, '2026-03-01 21:17:17', '2026-03-01 21:17:56', NULL, NULL, NULL, NULL, '[\"3\"]'),
(86, 1, 12, 26, '2026-03-04', '09:00:00', '10:15:00', 'completed', NULL, NULL, '2026-03-04 16:41:05', '2026-03-04 16:56:05', NULL, 2000.00, 'GCASH', NULL, '[\"1\",\"2\",\"3\"]'),
(87, 1, 12, 26, '2026-03-05', '09:00:00', '09:15:00', 'completed', NULL, NULL, '2026-03-05 17:31:13', '2026-03-05 17:35:01', NULL, 200.00, 'CASH', NULL, '[\"1\"]'),
(88, 2, 45, 30, '2026-03-06', '15:00:00', '15:15:00', 'arrived', NULL, NULL, '2026-03-06 09:35:57', '2026-03-06 09:35:57', NULL, NULL, NULL, NULL, '[1]'),
(89, 1, 80, 26, '2026-03-06', '11:00:00', '11:15:00', 'completed', NULL, NULL, '2026-03-06 10:28:56', '2026-03-06 10:35:40', NULL, 222.00, 'GCASH', NULL, '[\"1\"]'),
(90, 1, 80, 26, '2026-03-06', '09:00:00', '09:45:00', 'no_show', NULL, NULL, '2026-03-06 10:36:21', '2026-03-06 10:39:24', NULL, NULL, NULL, NULL, '[\"1\",\"3\"]'),
(91, 1, 80, 26, '2026-03-06', '14:15:00', '15:00:00', 'completed', NULL, NULL, '2026-03-06 10:56:57', '2026-03-06 11:00:45', NULL, 500.00, 'GCASH', NULL, '[\"2\"]'),
(92, 3, 12, 26, '2026-03-06', '21:00:00', '21:15:00', 'pending', NULL, 'hello', '2026-03-06 11:10:37', '2026-03-06 11:10:37', NULL, NULL, NULL, NULL, '[\"1\"]'),
(93, 1, 45, 26, '2026-03-06', '11:20:00', '11:50:00', 'arrived', NULL, NULL, '2026-03-06 11:20:57', '2026-03-06 11:20:57', NULL, NULL, NULL, NULL, '[2]'),
(94, 1, 81, 26, '2026-03-09', '09:00:00', '09:15:00', 'completed', NULL, NULL, '2026-03-09 10:07:49', '2026-03-09 10:33:56', NULL, 500.00, 'GCASH', NULL, '[\"1\"]'),
(95, 1, 81, 26, '2026-03-09', '10:56:00', '11:26:00', 'arrived', NULL, NULL, '2026-03-09 10:56:23', '2026-03-09 10:56:23', NULL, NULL, NULL, NULL, '[3]');

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
-- Table structure for table `daily_logs`
--

CREATE TABLE `daily_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_logs`
--

INSERT INTO `daily_logs` (`id`, `user_id`, `appointment_id`, `store_id`, `scanned_at`, `created_at`, `updated_at`) VALUES
(5, 12, 74, 1, '2026-02-13 13:08:49', '2026-02-13 13:08:49', '2026-02-13 13:08:49'),
(7, 45, NULL, 2, '2026-02-25 13:53:30', '2026-02-25 13:53:30', '2026-02-25 13:53:30'),
(8, 77, NULL, 1, '2026-02-25 15:26:23', '2026-02-25 15:26:23', '2026-02-25 15:26:23'),
(9, 78, 83, 1, '2026-02-26 15:03:40', '2026-02-26 15:03:40', '2026-02-26 15:03:40'),
(10, 79, NULL, 2, '2026-03-01 21:18:30', '2026-03-01 21:18:30', '2026-03-01 21:18:30'),
(11, 80, 91, 1, '2026-03-06 10:57:52', '2026-03-06 10:57:52', '2026-03-06 10:57:52'),
(12, 81, 94, 1, '2026-03-09 10:21:06', '2026-03-09 10:21:06', '2026-03-09 10:21:06'),
(13, 77, NULL, 2, '2026-04-01 00:13:00', '2026-04-01 00:13:00', '2026-04-01 00:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `dental_charts`
--

CREATE TABLE `dental_charts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `tooth_11_condition` text DEFAULT NULL,
  `tooth_11_treatment` text DEFAULT NULL,
  `tooth_12_condition` text DEFAULT NULL,
  `tooth_12_treatment` text DEFAULT NULL,
  `tooth_13_condition` text DEFAULT NULL,
  `tooth_13_treatment` text DEFAULT NULL,
  `tooth_14_condition` text DEFAULT NULL,
  `tooth_14_treatment` text DEFAULT NULL,
  `tooth_15_condition` text DEFAULT NULL,
  `tooth_15_treatment` text DEFAULT NULL,
  `tooth_16_condition` text DEFAULT NULL,
  `tooth_16_treatment` text DEFAULT NULL,
  `tooth_17_condition` text DEFAULT NULL,
  `tooth_17_treatment` text DEFAULT NULL,
  `tooth_18_condition` text DEFAULT NULL,
  `tooth_18_treatment` text DEFAULT NULL,
  `tooth_21_condition` text DEFAULT NULL,
  `tooth_21_treatment` text DEFAULT NULL,
  `tooth_22_condition` text DEFAULT NULL,
  `tooth_22_treatment` text DEFAULT NULL,
  `tooth_23_condition` text DEFAULT NULL,
  `tooth_23_treatment` text DEFAULT NULL,
  `tooth_24_condition` text DEFAULT NULL,
  `tooth_24_treatment` text DEFAULT NULL,
  `tooth_25_condition` text DEFAULT NULL,
  `tooth_25_treatment` text DEFAULT NULL,
  `tooth_26_condition` text DEFAULT NULL,
  `tooth_26_treatment` text DEFAULT NULL,
  `tooth_27_condition` text DEFAULT NULL,
  `tooth_27_treatment` text DEFAULT NULL,
  `tooth_28_condition` text DEFAULT NULL,
  `tooth_28_treatment` text DEFAULT NULL,
  `tooth_31_condition` text DEFAULT NULL,
  `tooth_31_treatment` text DEFAULT NULL,
  `tooth_32_condition` text DEFAULT NULL,
  `tooth_32_treatment` text DEFAULT NULL,
  `tooth_33_condition` text DEFAULT NULL,
  `tooth_33_treatment` text DEFAULT NULL,
  `tooth_34_condition` text DEFAULT NULL,
  `tooth_34_treatment` text DEFAULT NULL,
  `tooth_35_condition` text DEFAULT NULL,
  `tooth_35_treatment` text DEFAULT NULL,
  `tooth_36_condition` text DEFAULT NULL,
  `tooth_36_treatment` text DEFAULT NULL,
  `tooth_37_condition` text DEFAULT NULL,
  `tooth_37_treatment` text DEFAULT NULL,
  `tooth_38_condition` text DEFAULT NULL,
  `tooth_38_treatment` text DEFAULT NULL,
  `tooth_41_condition` text DEFAULT NULL,
  `tooth_41_treatment` text DEFAULT NULL,
  `tooth_42_condition` text DEFAULT NULL,
  `tooth_42_treatment` text DEFAULT NULL,
  `tooth_43_condition` text DEFAULT NULL,
  `tooth_43_treatment` text DEFAULT NULL,
  `tooth_44_condition` text DEFAULT NULL,
  `tooth_44_treatment` text DEFAULT NULL,
  `tooth_45_condition` text DEFAULT NULL,
  `tooth_45_treatment` text DEFAULT NULL,
  `tooth_46_condition` text DEFAULT NULL,
  `tooth_46_treatment` text DEFAULT NULL,
  `tooth_47_condition` text DEFAULT NULL,
  `tooth_47_treatment` text DEFAULT NULL,
  `tooth_48_condition` text DEFAULT NULL,
  `tooth_48_treatment` text DEFAULT NULL,
  `tooth_51_condition` text DEFAULT NULL,
  `tooth_51_treatment` text DEFAULT NULL,
  `tooth_52_condition` text DEFAULT NULL,
  `tooth_52_treatment` text DEFAULT NULL,
  `tooth_53_condition` text DEFAULT NULL,
  `tooth_53_treatment` text DEFAULT NULL,
  `tooth_54_condition` text DEFAULT NULL,
  `tooth_54_treatment` text DEFAULT NULL,
  `tooth_55_condition` text DEFAULT NULL,
  `tooth_55_treatment` text DEFAULT NULL,
  `tooth_61_condition` text DEFAULT NULL,
  `tooth_61_treatment` text DEFAULT NULL,
  `tooth_62_condition` text DEFAULT NULL,
  `tooth_62_treatment` text DEFAULT NULL,
  `tooth_63_condition` text DEFAULT NULL,
  `tooth_63_treatment` text DEFAULT NULL,
  `tooth_64_condition` text DEFAULT NULL,
  `tooth_64_treatment` text DEFAULT NULL,
  `tooth_65_condition` text DEFAULT NULL,
  `tooth_65_treatment` text DEFAULT NULL,
  `tooth_71_condition` text DEFAULT NULL,
  `tooth_71_treatment` text DEFAULT NULL,
  `tooth_72_condition` text DEFAULT NULL,
  `tooth_72_treatment` text DEFAULT NULL,
  `tooth_73_condition` text DEFAULT NULL,
  `tooth_73_treatment` text DEFAULT NULL,
  `tooth_74_condition` text DEFAULT NULL,
  `tooth_74_treatment` text DEFAULT NULL,
  `tooth_75_condition` text DEFAULT NULL,
  `tooth_75_treatment` text DEFAULT NULL,
  `tooth_81_condition` text DEFAULT NULL,
  `tooth_81_treatment` text DEFAULT NULL,
  `tooth_82_condition` text DEFAULT NULL,
  `tooth_82_treatment` text DEFAULT NULL,
  `tooth_83_condition` text DEFAULT NULL,
  `tooth_83_treatment` text DEFAULT NULL,
  `tooth_84_condition` text DEFAULT NULL,
  `tooth_84_treatment` text DEFAULT NULL,
  `tooth_85_condition` text DEFAULT NULL,
  `tooth_85_treatment` text DEFAULT NULL,
  `gingivitis` tinyint(1) NOT NULL DEFAULT 0,
  `early_periodontitis` tinyint(1) NOT NULL DEFAULT 0,
  `moderate_periodontitis` tinyint(1) NOT NULL DEFAULT 0,
  `advanced_periodontitis` tinyint(1) NOT NULL DEFAULT 0,
  `occlusion_class_molar` tinyint(1) NOT NULL DEFAULT 0,
  `overjet` tinyint(1) NOT NULL DEFAULT 0,
  `overbite` tinyint(1) NOT NULL DEFAULT 0,
  `midline_deviation` tinyint(1) NOT NULL DEFAULT 0,
  `crossbite` tinyint(1) NOT NULL DEFAULT 0,
  `appliance_orthodontic` tinyint(1) NOT NULL DEFAULT 0,
  `appliance_stayplate` tinyint(1) NOT NULL DEFAULT 0,
  `appliance_others` tinyint(1) NOT NULL DEFAULT 0,
  `tmd_clenching` tinyint(1) NOT NULL DEFAULT 0,
  `tmd_clicking` tinyint(1) NOT NULL DEFAULT 0,
  `tmd_trismus` tinyint(1) NOT NULL DEFAULT 0,
  `tmd_muscle_spasm` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dental_charts`
--

INSERT INTO `dental_charts` (`id`, `patient_id`, `tooth_11_condition`, `tooth_11_treatment`, `tooth_12_condition`, `tooth_12_treatment`, `tooth_13_condition`, `tooth_13_treatment`, `tooth_14_condition`, `tooth_14_treatment`, `tooth_15_condition`, `tooth_15_treatment`, `tooth_16_condition`, `tooth_16_treatment`, `tooth_17_condition`, `tooth_17_treatment`, `tooth_18_condition`, `tooth_18_treatment`, `tooth_21_condition`, `tooth_21_treatment`, `tooth_22_condition`, `tooth_22_treatment`, `tooth_23_condition`, `tooth_23_treatment`, `tooth_24_condition`, `tooth_24_treatment`, `tooth_25_condition`, `tooth_25_treatment`, `tooth_26_condition`, `tooth_26_treatment`, `tooth_27_condition`, `tooth_27_treatment`, `tooth_28_condition`, `tooth_28_treatment`, `tooth_31_condition`, `tooth_31_treatment`, `tooth_32_condition`, `tooth_32_treatment`, `tooth_33_condition`, `tooth_33_treatment`, `tooth_34_condition`, `tooth_34_treatment`, `tooth_35_condition`, `tooth_35_treatment`, `tooth_36_condition`, `tooth_36_treatment`, `tooth_37_condition`, `tooth_37_treatment`, `tooth_38_condition`, `tooth_38_treatment`, `tooth_41_condition`, `tooth_41_treatment`, `tooth_42_condition`, `tooth_42_treatment`, `tooth_43_condition`, `tooth_43_treatment`, `tooth_44_condition`, `tooth_44_treatment`, `tooth_45_condition`, `tooth_45_treatment`, `tooth_46_condition`, `tooth_46_treatment`, `tooth_47_condition`, `tooth_47_treatment`, `tooth_48_condition`, `tooth_48_treatment`, `tooth_51_condition`, `tooth_51_treatment`, `tooth_52_condition`, `tooth_52_treatment`, `tooth_53_condition`, `tooth_53_treatment`, `tooth_54_condition`, `tooth_54_treatment`, `tooth_55_condition`, `tooth_55_treatment`, `tooth_61_condition`, `tooth_61_treatment`, `tooth_62_condition`, `tooth_62_treatment`, `tooth_63_condition`, `tooth_63_treatment`, `tooth_64_condition`, `tooth_64_treatment`, `tooth_65_condition`, `tooth_65_treatment`, `tooth_71_condition`, `tooth_71_treatment`, `tooth_72_condition`, `tooth_72_treatment`, `tooth_73_condition`, `tooth_73_treatment`, `tooth_74_condition`, `tooth_74_treatment`, `tooth_75_condition`, `tooth_75_treatment`, `tooth_81_condition`, `tooth_81_treatment`, `tooth_82_condition`, `tooth_82_treatment`, `tooth_83_condition`, `tooth_83_treatment`, `tooth_84_condition`, `tooth_84_treatment`, `tooth_85_condition`, `tooth_85_treatment`, `gingivitis`, `early_periodontitis`, `moderate_periodontitis`, `advanced_periodontitis`, `occlusion_class_molar`, `overjet`, `overbite`, `midline_deviation`, `crossbite`, `appliance_orthodontic`, `appliance_stayplate`, `appliance_others`, `tmd_clenching`, `tmd_clicking`, `tmd_trismus`, `tmd_muscle_spasm`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, NULL, NULL, NULL, 'D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', 'Ab', 'Rf', 'Ab', '✓', 'Co', 'D', 'JC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-08-31 01:36:37', '2026-01-30 08:22:08'),
(2, 11, NULL, NULL, NULL, NULL, 'Rf', NULL, 'M', 'Att', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-02 09:56:48', '2026-01-11 23:23:39'),
(3, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-02 09:58:05', '2025-09-02 09:58:36'),
(4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-07 22:16:18', '2026-03-06 10:51:22'),
(5, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-07 22:44:41', '2025-09-07 22:44:41'),
(8, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-07 23:53:44', '2026-02-05 07:11:05'),
(10, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-08 05:14:54', '2025-10-08 05:14:54'),
(12, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Co', NULL, 'JC', NULL, 'Ab', NULL, 'Att', NULL, 'Imp', NULL, 'In', NULL, 'P', NULL, 'S', NULL, 'Am', 'Rf', NULL, 'Sp', NULL, '✓', NULL, 'Rf', NULL, 'Un', NULL, 'D', NULL, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Rm', 'D', 'XO', 'D', 'Imp', 'Sp', 'X', NULL, NULL, 'MO', 'Imp', NULL, NULL, 'D', NULL, 'Im', 'Imp', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-15 22:42:53', '2026-01-11 21:04:47'),
(13, 37, NULL, NULL, 'MO', 'In', 'D', NULL, NULL, 'Co', 'M', NULL, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-17 08:16:51', '2026-01-13 02:53:07'),
(14, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-19 00:34:52', '2025-10-19 01:09:08'),
(17, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-12 05:38:13', '2025-11-12 05:38:13'),
(21, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-23 01:44:37', '2025-11-23 01:44:37'),
(22, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-24 07:56:24', '2025-11-24 07:56:24'),
(23, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-24 16:25:20', '2025-11-24 16:25:20'),
(24, 43, NULL, NULL, NULL, NULL, NULL, NULL, 'M', 'Rm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', 'Imp', 'D', 'In', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 07:06:45', '2025-12-02 23:13:59'),
(26, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Co', NULL, NULL, NULL, NULL, NULL, NULL, 'D', 'Co', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Am', 'Im', '', 'Im', 'JC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-01-14 22:30:38', '2026-01-18 02:29:25'),
(29, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Im', 'In', 'D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-01-16 04:23:46', '2026-01-16 04:24:13'),
(34, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-01-19 14:18:24', '2026-01-19 14:18:24'),
(35, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-01-21 07:33:15', '2026-01-21 07:33:15'),
(36, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-01-31 18:10:41', '2026-01-31 18:10:41'),
(37, 70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-13 10:18:57', '2026-02-13 10:18:57'),
(39, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-24 18:18:39', '2026-02-24 18:18:39'),
(40, 77, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-25 15:24:26', '2026-02-25 16:17:36'),
(41, 78, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-26 15:05:38', '2026-02-26 15:05:59'),
(42, 79, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-03-01 21:13:20', '2026-03-01 21:13:42'),
(43, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-03-06 10:35:05', '2026-03-06 10:35:05'),
(44, 81, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-03-09 10:18:15', '2026-03-09 10:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `dental_teeth`
--

CREATE TABLE `dental_teeth` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `tooth` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dental_teeth`
--

INSERT INTO `dental_teeth` (`id`, `patient_id`, `tooth`, `data`, `created_at`, `updated_at`) VALUES
(1, 45, '75', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-01-18 02:29:33', '2026-01-18 02:29:33'),
(2, 45, '55', '{\"center\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"},\"top\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"right\":{\"group\":\"condition\",\"code\":\"Im\",\"color\":\"#f59e0b\"}}', '2026-01-18 02:30:18', '2026-01-18 02:30:23'),
(3, 45, '61', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-01-18 02:30:31', '2026-01-18 02:30:31'),
(4, 59, '55', '{\"center\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"},\"right\":{\"group\":\"condition\",\"code\":\"M\",\"color\":\"#7c2d12\"},\"bottom\":{\"group\":\"condition\",\"code\":\"Sp\",\"color\":\"#8b5cf6\"},\"left\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"top\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#10b981\"}}', '2026-01-18 03:36:31', '2026-01-18 14:20:27'),
(8, 42, '54', '{\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"right\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"},\"left\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-01-19 10:04:42', '2026-01-19 10:05:07'),
(12, 11, '52', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-01-19 13:37:21', '2026-01-19 13:37:23'),
(14, 18, '84', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-01-19 14:42:59', '2026-01-19 14:42:59'),
(15, 18, '42', '{\"bottom\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"}}', '2026-01-19 14:43:05', '2026-01-19 14:43:05'),
(16, 13, '51', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-01-20 16:07:06', '2026-01-20 16:07:12'),
(17, 12, '12', '{\"center\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"right\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"},\"top\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"}}', '2026-01-21 04:32:58', '2026-01-21 04:33:06'),
(19, 59, '51', '{\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"right\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"left\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-01-26 01:53:56', '2026-01-26 01:54:05'),
(20, 45, '74', '{\"center\":{\"group\":\"condition\",\"code\":\"MO\",\"color\":\"#6b7280\"}}', '2026-01-26 02:34:18', '2026-01-26 02:34:18'),
(21, 45, '52', '{\"center\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"}}', '2026-01-26 02:34:32', '2026-01-26 02:34:32'),
(22, 18, '55', '{\"left\":{\"group\":\"condition\",\"code\":\"MO\",\"color\":\"#6b7280\"},\"center\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-01-28 00:12:14', '2026-01-28 00:12:22'),
(23, 18, '54', '{\"center\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"}}', '2026-01-28 00:12:29', '2026-01-28 00:12:29'),
(24, 18, '53', '{\"top\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"},\"center\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"}}', '2026-01-28 00:12:35', '2026-01-28 00:12:37'),
(25, 18, '16', '{\"right\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"},\"center\":{\"group\":\"restoration\",\"code\":\"Co\",\"color\":\"#3b82f6\"}}', '2026-01-28 00:12:41', '2026-01-28 00:12:44'),
(26, 18, '23', '{\"center\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"}}', '2026-01-28 00:13:03', '2026-01-28 00:13:03'),
(27, 18, '15', '{\"top\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"},\"center\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"}}', '2026-01-28 00:13:19', '2026-01-28 00:13:23'),
(28, 18, '14', '{\"center\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"},\"top\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"}}', '2026-01-28 00:13:25', '2026-01-28 00:13:27'),
(29, 18, '13', '{\"top\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"bottom\":{\"group\":\"condition\",\"code\":\"Rf\",\"color\":\"#78350f\"},\"right\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"},\"left\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"}}', '2026-01-28 00:13:29', '2026-03-05 19:44:36'),
(30, 18, '12', '{\"center\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"}}', '2026-01-28 00:13:34', '2026-03-05 19:44:30'),
(31, 18, '11', '{\"left\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"}}', '2026-01-28 00:13:37', '2026-01-28 00:13:37'),
(32, 45, '63', '{\"center\":{\"group\":\"condition\",\"code\":\"\\u2713\",\"color\":\"#ffffff\"},\"top\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"left\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"right\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"}}', '2026-01-28 00:54:23', '2026-01-31 08:25:40'),
(33, 45, '62', '{\"center\":{\"group\":\"condition\",\"code\":\"Sp\",\"color\":\"#8b5cf6\"}}', '2026-01-28 00:54:28', '2026-01-28 00:54:28'),
(34, 45, '24', '{\"top\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"},\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-01-28 00:54:35', '2026-01-28 00:55:17'),
(35, 45, '26', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"}}', '2026-01-28 00:54:44', '2026-01-28 00:54:44'),
(36, 45, '12', '{\"left\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"},\"center\":{\"group\":\"condition\",\"code\":\"Im\",\"color\":\"#f59e0b\"}}', '2026-01-28 00:55:22', '2026-01-28 00:55:23'),
(37, 11, '18', '{\"center\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"}}', '2026-01-28 01:14:59', '2026-01-28 01:15:03'),
(38, 11, '55', '{\"center\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"bottom\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"}}', '2026-01-28 01:27:45', '2026-01-28 01:27:53'),
(39, 11, '54', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"}}', '2026-01-28 01:27:59', '2026-01-28 01:27:59'),
(40, 11, '53', '{\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-01-28 01:28:05', '2026-01-28 01:28:05'),
(41, 11, '51', '{\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-01-28 01:28:07', '2026-01-28 01:28:07'),
(42, 11, '61', '{\"center\":{\"group\":\"restoration\",\"code\":\"Co\",\"color\":\"#3b82f6\"}}', '2026-01-28 01:28:09', '2026-01-28 01:28:09'),
(43, 12, '13', '{\"left\":{\"group\":\"condition\",\"code\":\"Rf\",\"color\":\"#78350f\"}}', '2026-01-30 08:21:55', '2026-01-30 08:21:55'),
(44, 12, '14', '{\"top\":{\"group\":\"condition\",\"code\":\"MO\",\"color\":\"#6b7280\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"}}', '2026-01-30 08:21:59', '2026-01-30 08:22:02'),
(45, 42, '51', '{\"center\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"}}', '2026-01-31 03:14:39', '2026-01-31 03:14:39'),
(53, 12, '61', '{\"right\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"left\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"}}', '2026-02-13 13:26:10', '2026-02-13 13:26:11'),
(57, 72, '61', '{\"center\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"left\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"top\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-02-24 18:25:59', '2026-02-24 18:26:30'),
(58, 77, '15', '{\"top\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"},\"center\":{\"group\":\"condition\",\"code\":\"Rf\",\"color\":\"#78350f\"}}', '2026-02-25 16:17:18', '2026-02-25 16:17:26'),
(59, 78, '52', '{\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"right\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"left\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"top\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-02-26 15:05:46', '2026-02-26 15:05:56'),
(60, 79, '51', '{\"top\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-03-01 21:13:37', '2026-03-01 21:13:37'),
(61, 12, '24', '{\"center\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"right\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"left\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-03-04 16:40:09', '2026-03-04 16:40:16'),
(62, 79, '53', '{\"center\":{\"group\":\"condition\",\"code\":\"MO\",\"color\":\"#6b7280\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-03-05 23:25:37', '2026-03-05 23:25:53'),
(63, 13, '55', '{\"top\":{\"group\":\"condition\",\"code\":\"MO\",\"color\":\"#6b7280\"},\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-03-06 10:50:22', '2026-03-06 10:50:28'),
(64, 13, '54', '{\"left\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"}}', '2026-03-06 10:50:39', '2026-03-06 10:50:39'),
(65, 13, '53', '{\"top\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"center\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"left\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-03-06 10:50:49', '2026-03-06 10:50:56'),
(66, 13, '52', '{\"center\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"}}', '2026-03-06 10:51:02', '2026-03-06 10:51:02'),
(67, 54, '11', '{\"right\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"},\"left\":{\"group\":\"restoration\",\"code\":\"Co\",\"color\":\"#3b82f6\"}}', '2026-03-06 10:55:50', '2026-03-06 10:55:51'),
(68, 38, '52', '{\"right\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"},\"left\":{\"group\":\"restoration\",\"code\":\"Co\",\"color\":\"#3b82f6\"}}', '2026-03-06 10:56:23', '2026-03-06 10:56:24'),
(69, 80, '52', '{\"center\":{\"group\":\"condition\",\"code\":\"Im\",\"color\":\"#f59e0b\"},\"right\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"}}', '2026-03-06 10:59:42', '2026-03-06 10:59:44'),
(70, 81, '53', '{\"center\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"top\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"left\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-03-09 10:28:42', '2026-03-09 10:29:02'),
(71, 81, '63', '{\"right\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"left\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"}}', '2026-03-09 10:56:42', '2026-03-09 10:56:51');

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
-- Table structure for table `medical_forms`
--

CREATE TABLE `medical_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `allergies` tinyint(1) DEFAULT NULL,
  `allergies_details` varchar(255) DEFAULT NULL,
  `heart_condition` tinyint(1) DEFAULT NULL,
  `heart_condition_details` varchar(255) DEFAULT NULL,
  `asthma` tinyint(1) DEFAULT NULL,
  `asthma_details` varchar(255) DEFAULT NULL,
  `had_surgeries` tinyint(1) DEFAULT NULL,
  `surgery_type` varchar(255) DEFAULT NULL,
  `surgery_date` date DEFAULT NULL,
  `surgery_location` varchar(255) DEFAULT NULL,
  `surgery_remarks` varchar(255) DEFAULT NULL,
  `medication_name` varchar(255) DEFAULT NULL,
  `medication_dosage` varchar(255) DEFAULT NULL,
  `medication_reason` varchar(255) DEFAULT NULL,
  `visit_reason` varchar(255) DEFAULT NULL,
  `last_dental_visit` date DEFAULT NULL,
  `had_dental_issues` tinyint(1) DEFAULT NULL,
  `dental_issue_description` varchar(255) DEFAULT NULL,
  `dental_anxiety` tinyint(1) DEFAULT NULL,
  `emergency_name` varchar(255) DEFAULT NULL,
  `emergency_relationship` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_forms`
--

INSERT INTO `medical_forms` (`id`, `user_id`, `allergies`, `allergies_details`, `heart_condition`, `heart_condition_details`, `asthma`, `asthma_details`, `had_surgeries`, `surgery_type`, `surgery_date`, `surgery_location`, `surgery_remarks`, `medication_name`, `medication_dosage`, `medication_reason`, `visit_reason`, `last_dental_visit`, `had_dental_issues`, `dental_issue_description`, `dental_anxiety`, `emergency_name`, `emergency_relationship`, `emergency_contact`, `created_at`, `updated_at`) VALUES
(1, 12, 0, 'N/A', 1, 'Had a heart attack in 2020, taking maintenance meds', 1, 'Mild asthma attacks; uses inhaler occasionally', 1, 'Coronary Angioplasty', '2020-10-15', 'St. Luke’s Medical Center', 'Post-heart attack procedure, successful recovery', 'Aspirin', '81 mg daily', 'Blood thinner after heart attack', 'Toothache on upper right molar', '2023-03-10', 1, 'Root canal treatment in 2020', 0, 'Maria Teresa Santos', 'Wife', '0918-765-4321', '2025-08-28 22:16:26', '2025-08-28 22:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `unit`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Mefenamic Acid', 'MG', 5.00, 'Pain reliever for toothaches and post-surgery pain', '2025-08-28 04:56:00', '2025-08-28 04:56:00'),
(2, 'Amoxicillin', 'MG', 7.00, 'Broad-spectrum antibiotic for dental infections', '2025-08-28 05:35:43', '2025-08-28 05:35:43'),
(3, 'Mefenamic', 'mL', 5.00, 'Gamot sa sakit', '2025-09-17 02:40:08', '2025-09-17 02:40:08'),
(4, 'Anesthesia', 'G', 1000.00, 'Anti sakit', '2025-09-17 02:41:37', '2025-09-17 02:41:37'),
(5, 'Antidote', 'mL', 10.00, 'Eme', '2025-10-07 23:22:00', '2025-10-07 23:22:00'),
(6, 'Yakapsul', 'G', 20.00, 'Hahaaha', '2026-01-13 02:26:50', '2026-01-13 02:26:50'),
(7, 'Pain Relievers', 'G', 15.00, 'To ease the pain', '2026-01-20 16:19:24', '2026-01-20 16:19:24'),
(8, 'Anti-covid', 'mL', 1000.00, 'Pangontra', '2026-02-02 06:47:18', '2026-02-02 06:47:18'),
(9, 'Mimik', 'G', 12.00, 'Gamot sa batang isip', '2026-02-25 14:57:36', '2026-02-25 14:57:36'),
(10, 'Yakapsule', 'mL', 200.00, 'sakit sa likod', '2026-03-31 23:46:58', '2026-03-31 23:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_batches`
--

CREATE TABLE `medicine_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','suspended','expired') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_batches`
--

INSERT INTO `medicine_batches` (`id`, `medicine_id`, `store_id`, `quantity`, `expiration_date`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 2, 1, '2025-11-08', '2025-08-28 04:56:38', '2025-10-07 23:31:51', 'active'),
(2, 2, 2, 6, '2026-03-15', '2025-08-28 05:36:13', '2026-04-01 00:26:58', 'active'),
(3, 1, 1, 0, '2025-09-05', '2025-09-07 22:09:15', '2026-03-09 10:48:09', 'suspended'),
(4, 4, 1, 5, '2025-09-18', '2025-09-17 02:52:50', '2026-01-20 16:15:29', 'expired'),
(5, 5, 1, 0, '2026-01-01', '2025-10-07 23:24:15', '2026-01-11 23:37:47', 'suspended'),
(6, 6, 1, 20, '2026-01-13', '2026-01-13 02:28:32', '2026-01-13 02:28:54', 'expired'),
(7, 1, 1, 20, '2026-02-02', '2026-02-02 06:45:00', '2026-02-02 06:45:10', 'expired'),
(8, 1, 1, 40, '2027-02-28', '2026-02-02 06:45:30', '2026-02-02 06:45:30', 'active'),
(9, 2, 1, 25, '2029-02-14', '2026-02-02 06:46:24', '2026-02-24 18:29:26', 'active'),
(10, 3, 1, 50, '2026-02-26', '2026-02-25 15:00:35', '2026-02-25 15:00:35', 'active'),
(11, 4, 1, 100, '2026-02-25', '2026-02-25 15:01:07', '2026-02-25 15:01:18', 'suspended'),
(12, 4, 1, 70, '2026-02-25', '2026-02-25 15:01:34', '2026-02-25 15:03:09', 'expired'),
(13, 5, 1, 60, '2026-02-26', '2026-02-25 15:01:55', '2026-02-25 15:01:55', 'active'),
(14, 4, 1, 30, '2026-02-25', '2026-02-25 15:03:19', '2026-02-25 15:03:19', 'active'),
(15, 1, 4, 30, '2026-02-25', '2026-02-25 15:05:35', '2026-02-25 15:05:35', 'active'),
(16, 1, 4, 20, '2026-02-28', '2026-02-25 15:05:52', '2026-02-25 15:05:52', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_movements`
--

CREATE TABLE `medicine_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('stock_in','stock_out','suspended','expired') NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_movements`
--

INSERT INTO `medicine_movements` (`id`, `medicine_id`, `store_id`, `medicine_batch_id`, `type`, `quantity`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'stock_in', 20, 'New Batch', '2025-08-28 04:56:38', '2025-08-28 04:56:38'),
(2, 2, 2, 2, 'stock_in', 20, 'New Batch', '2025-08-28 05:36:13', '2025-08-28 05:36:13'),
(3, 1, 1, 3, 'stock_in', 20, 'New Batch', '2025-09-07 22:09:15', '2025-09-07 22:09:15'),
(4, 1, 1, 3, 'stock_out', 2, 'Manual Decrease', '2025-09-07 22:13:53', '2025-09-07 22:13:53'),
(5, 1, 2, 1, 'stock_out', 2, 'Manual Decrease', '2025-09-07 23:07:36', '2025-09-07 23:07:36'),
(6, 1, 1, 3, 'expired', 18, 'Manual Expired', '2025-09-10 05:12:27', '2025-09-10 05:12:27'),
(7, 1, 2, 1, 'stock_out', -8, 'Sale #1', '2025-09-12 22:25:31', '2025-09-12 22:25:31'),
(8, 1, 2, 1, 'stock_out', -5, 'Sale #2', '2025-09-12 22:25:42', '2025-09-12 22:25:42'),
(9, 2, 2, 2, 'stock_out', -7, 'Sale #3', '2025-09-15 05:11:54', '2025-09-15 05:11:54'),
(10, 2, 2, 2, 'stock_out', -3, 'Sale #4', '2025-09-17 02:27:25', '2025-09-17 02:27:25'),
(11, 1, 2, 1, 'stock_out', -2, 'Sale #5', '2025-09-17 02:27:54', '2025-09-17 02:27:54'),
(12, 4, 1, 4, 'stock_in', 5, 'New Batch', '2025-09-17 02:52:50', '2025-09-17 02:52:50'),
(13, 1, 2, 1, 'stock_out', -1, 'Sale #6', '2025-10-07 21:53:31', '2025-10-07 21:53:31'),
(14, 5, 1, 5, 'stock_in', 20, 'New Batch', '2025-10-07 23:24:15', '2025-10-07 23:24:15'),
(15, 5, 1, 5, 'stock_in', 4, 'Manual Add', '2025-10-07 23:24:26', '2025-10-07 23:24:26'),
(16, 5, 1, 5, 'stock_out', 9, 'Manual Decrease', '2025-10-07 23:24:35', '2025-10-07 23:24:35'),
(17, 5, 1, 5, 'stock_out', -2, 'Sale #7', '2025-10-07 23:25:30', '2025-10-07 23:25:30'),
(18, 1, 2, 1, 'stock_out', -1, 'Sale #8', '2025-10-07 23:31:51', '2025-10-07 23:31:51'),
(19, 5, 1, 5, 'stock_out', -5, 'Sale #9', '2025-10-07 23:56:07', '2025-10-07 23:56:07'),
(20, 2, 2, 2, 'stock_out', -2, 'Sale #10', '2025-11-24 07:59:40', '2025-11-24 07:59:40'),
(21, 5, 1, 5, 'stock_out', -8, 'Sale #11', '2026-01-11 23:37:47', '2026-01-11 23:37:47'),
(22, 6, 1, 6, 'stock_in', 20, 'New Batch', '2026-01-13 02:28:32', '2026-01-13 02:28:32'),
(23, 6, 1, 6, 'expired', 20, 'Manual Expired', '2026-01-13 02:28:54', '2026-01-13 02:28:54'),
(24, 4, 1, 4, 'expired', 5, 'Manual Expired', '2026-01-20 16:15:29', '2026-01-20 16:15:29'),
(25, 1, 1, 7, 'stock_in', 20, 'New Batch', '2026-02-02 06:45:00', '2026-02-02 06:45:00'),
(26, 1, 1, 7, 'expired', 20, 'Manual Expired', '2026-02-02 06:45:10', '2026-02-02 06:45:10'),
(27, 1, 1, 8, 'stock_in', 40, 'New Batch', '2026-02-02 06:45:30', '2026-02-02 06:45:30'),
(28, 2, 1, 9, 'stock_in', 60, 'New Batch', '2026-02-02 06:46:24', '2026-02-02 06:46:24'),
(29, 2, 1, 9, 'stock_out', 30, 'Manual Decrease', '2026-02-05 07:48:37', '2026-02-05 07:48:37'),
(30, 1, 1, 3, 'stock_out', -3, 'Sale #12', '2026-02-24 18:29:26', '2026-02-24 18:29:26'),
(31, 2, 1, 9, 'stock_out', -5, 'Sale #12', '2026-02-24 18:29:26', '2026-02-24 18:29:26'),
(32, 3, 1, 10, 'stock_in', 50, 'New Batch', '2026-02-25 15:00:35', '2026-02-25 15:00:35'),
(33, 4, 1, 11, 'stock_in', 100, 'New Batch', '2026-02-25 15:01:07', '2026-02-25 15:01:07'),
(34, 4, 1, 11, 'suspended', 100, 'Manual Suspended', '2026-02-25 15:01:18', '2026-02-25 15:01:18'),
(35, 4, 1, 12, 'stock_in', 70, 'New Batch', '2026-02-25 15:01:34', '2026-02-25 15:01:34'),
(36, 5, 1, 13, 'stock_in', 60, 'New Batch', '2026-02-25 15:01:55', '2026-02-25 15:01:55'),
(37, 4, 1, 12, 'expired', 70, 'Manual Expired', '2026-02-25 15:03:09', '2026-02-25 15:03:09'),
(38, 4, 1, 14, 'stock_in', 30, 'New Batch', '2026-02-25 15:03:19', '2026-02-25 15:03:19'),
(39, 1, 4, 15, 'stock_in', 30, 'New Batch', '2026-02-25 15:05:35', '2026-02-25 15:05:35'),
(40, 1, 4, 16, 'stock_in', 20, 'New Batch', '2026-02-25 15:05:52', '2026-02-25 15:05:52'),
(41, 1, 1, 3, 'stock_out', -15, 'Sale #13', '2026-03-09 10:48:09', '2026-03-09 10:48:09'),
(42, 2, 2, 2, 'stock_out', -2, 'Sale #14', '2026-04-01 00:26:58', '2026-04-01 00:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `store_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`, `updated_at`, `type`, `file_path`, `file_name`) VALUES
(5, 1, 1, 12, 'hi', 0, '2025-11-11 06:13:52', '2025-11-11 06:13:52', 'text', NULL, NULL),
(6, 1, 44, 1, 'Hello po, good morning.', 0, '2025-11-11 06:26:26', '2025-11-11 06:26:26', 'text', NULL, NULL),
(9, 2, 30, 54, 'test', 0, '2026-01-14 22:28:45', '2026-01-14 22:28:45', 'text', NULL, NULL),
(10, 2, 30, 12, 'test', 0, '2026-01-14 23:19:20', '2026-01-14 23:19:20', 'text', NULL, NULL),
(13, 2, 30, 12, 'ddd', 0, '2026-01-14 23:22:49', '2026-01-14 23:22:49', 'text', NULL, NULL),
(14, 3, 12, 3, 'awdaw', 0, '2026-01-14 23:32:23', '2026-01-14 23:32:23', 'text', NULL, NULL),
(19, 2, 30, 12, 'ssss', 0, '2026-01-14 23:36:58', '2026-01-14 23:36:58', 'text', NULL, NULL),
(22, 2, 12, NULL, 'ccc', 0, '2026-01-14 23:40:14', '2026-01-14 23:40:14', 'text', NULL, NULL),
(23, 2, 12, NULL, 'qqqq', 0, '2026-01-14 23:40:18', '2026-01-14 23:40:18', 'text', NULL, NULL),
(25, 2, 30, 12, ';pppp', 0, '2026-01-14 23:40:54', '2026-01-14 23:40:54', 'text', NULL, NULL),
(26, 2, 30, 54, 'sss', 0, '2026-01-14 23:55:42', '2026-01-14 23:55:42', 'text', NULL, NULL),
(27, 2, 12, 1, 'ccc', 0, '2026-01-15 00:11:06', '2026-01-15 00:11:06', 'text', NULL, NULL),
(28, 2, 12, 1, 'xxx', 0, '2026-01-15 00:11:09', '2026-01-15 00:11:09', 'text', NULL, NULL),
(29, 2, 30, 12, 'nnnn', 0, '2026-01-15 00:11:23', '2026-01-15 00:11:23', 'text', NULL, NULL),
(30, 2, 12, NULL, 'Is-Web-Development-Oversaturated.jpg', 0, '2026-01-15 00:34:46', '2026-01-15 00:34:46', 'file', 'chat_files/hChpTHj8koEgR3oiCeF1JYtsoQ7utckiVVXr2fl4.jpg', NULL),
(31, 2, 30, NULL, '494579798_693373853415594_8083316453582063649_n.jpg', 0, '2026-01-15 00:42:41', '2026-01-15 00:42:41', 'file', 'chat_files/P1KgcS9fxofq2YsvhwBMvgZu1J4MDUHj14uV8aVs.jpg', NULL),
(32, 2, 30, NULL, 'Birth-Certificate-Template-10.jpg', 0, '2026-01-15 00:43:06', '2026-01-15 00:43:06', 'file', 'chat_files/SM6KfMDydhIg50aRRoOO6K1jJZVVzPdw14O6O7Et.jpg', NULL),
(33, 2, 30, 12, 'vbbb', 0, '2026-01-15 00:43:37', '2026-01-15 00:43:37', 'text', NULL, NULL),
(34, 2, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:50:26', '2026-01-15 00:50:26', 'file', 'chat_files/qwxKPUagFmpUm3td3pBcPIqKnZVamEDh7wfasD1l.jpg', NULL),
(35, 2, 30, NULL, 'Info-Website-19.jpg', 0, '2026-01-15 00:50:49', '2026-01-15 00:50:49', 'file', 'chat_files/OXjOk8qYHzIJrOIJPwQgjMCd8wwGDpr5g3t9bOxq.jpg', NULL),
(36, 2, 30, 12, 'yyy', 0, '2026-01-15 00:56:52', '2026-01-15 00:56:52', 'text', NULL, NULL),
(37, 2, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:58:33', '2026-01-15 00:58:33', 'file', 'chat_files/3yZcalFyMo30kspMqr8t9Z33qChykyTLzIRQYIZi.jpg', NULL),
(38, 2, 30, 12, 'xxxxaa', 0, '2026-01-15 01:01:02', '2026-01-15 01:01:02', 'text', NULL, NULL),
(39, 2, 30, 55, 'data-analysis-skills-duties-responsibilities.webp', 0, '2026-01-15 01:03:38', '2026-01-15 01:03:38', 'file', 'chat_files/GFEw8UOk1yT1akKdzqWO6OKtTsKqXVl1HwTwTC13.webp', NULL),
(40, 2, 30, 12, 'Info-Website-19.jpg', 0, '2026-01-15 01:03:45', '2026-01-15 01:03:45', 'file', 'chat_files/9RKKvwPXg578Ce5nMXabPzqeohOS4KC2McmH59yl.jpg', NULL),
(41, 2, 30, 12, 'test upload', 0, '2026-01-15 01:05:24', '2026-01-15 01:05:24', 'text', NULL, NULL),
(42, 2, 30, 12, 'images.webp', 0, '2026-01-15 01:05:31', '2026-01-15 01:05:31', 'file', 'chat_files/gVYgyUTQofHDmkwSuGYLF04uqOjYdOgWZVJXZ4JI.webp', NULL),
(43, 1, 32, 44, 'comments.txt', 0, '2026-01-15 01:06:53', '2026-01-15 01:06:53', 'file', 'chat_files/LpcPrCZrq91WfuvYqP2GFNNGURWOX4966E0wMg92', NULL),
(44, 1, 32, 44, 'landing.png', 0, '2026-01-15 01:09:03', '2026-01-15 01:09:03', 'file', 'chat_files/CMrCsIGIgIVqbN9239LVlUnfEYGkd59mv2b7dstm.png', NULL),
(45, 4, 12, NULL, 'data-analysis-skills-duties-responsibilities.webp', 0, '2026-01-15 01:09:22', '2026-01-15 01:09:22', 'file', 'chat_files/No502gajzUdes5TD8Xmz9s66FNqprsauXdtrwFqk.webp', NULL),
(46, 1, 32, 50, 'menu.bmp', 0, '2026-01-15 01:10:30', '2026-01-15 01:10:30', 'file', 'chat_files/8aYq9b08eqkWlUmxlGTsxJk5ZbkZwu64cIpZPxQe.png', NULL),
(47, 1, 32, 50, 'ss', 0, '2026-01-15 01:10:36', '2026-01-15 01:10:36', 'text', NULL, NULL),
(48, 1, 26, 52, '68c80f9fd8277.jpg', 0, '2026-01-16 01:35:15', '2026-01-16 01:35:15', 'file', 'chat_files/bnppaTVAS9dwGpiaYgj4LZ4GDpOjl8JoE8jAZ0J6.jpg', NULL),
(49, 4, 12, NULL, 'JCZ-monogram-from-MakeMonogram.com-1767679419866.png', 0, '2026-01-16 02:17:29', '2026-01-16 02:17:29', 'file', 'chat_files/dkfwhEVWiYUaZkejmNumSEk6UlXtFXWWa9T9YxkZ.png', NULL),
(50, 2, 33, 12, 'account.txt', 0, '2026-01-16 02:44:23', '2026-01-16 02:44:23', 'file', 'chat_files/2joREcKVihag7vIRa2njWODOIncanFcS6yk7oHNq.txt', NULL),
(51, 4, 64, NULL, 'Screenshot_2026-01-14-10-27-22-11_a23b203fd3aafc6dcb84e438dda678b6.jpg', 0, '2026-01-18 03:50:19', '2026-01-18 03:50:19', 'file', 'chat_files/laQy7bhrvkB00rlz8X7jUM7JPw7NrrBGXX4uXwPx.jpg', NULL),
(52, 4, 30, 18, 'Screenshot_2026-01-18-11-17-44-88_ccc4ff946bf847a7c199bff6d87da37a.jpg', 0, '2026-01-18 03:55:30', '2026-01-18 03:55:30', 'file', 'chat_files/LsOj8ViJI1KXhUj6RycxM0Ozt74HL741JnoZyoam.jpg', NULL),
(53, 1, 26, 11, 'joshua.jpg', 0, '2026-01-18 04:23:09', '2026-01-18 04:23:09', 'text', NULL, NULL),
(54, 1, 26, 11, 'Picture1.png', 0, '2026-01-18 04:23:50', '2026-01-18 04:23:50', 'file', 'chat_files/aW0Qnmf2X7yVPll7dy7fm0nYURq93CbrdflRJxh5.png', NULL),
(55, 2, 30, 12, 'cold_manngo.webp', 0, '2026-01-18 16:44:51', '2026-01-18 16:44:51', 'file', 'chat_files/QuPka9CDriOKzbyKWHYVD34MAe2C7ETRi9baTFmc.webp', NULL),
(56, 2, 30, 12, 'strawverry_shake.webp', 0, '2026-01-19 08:43:43', '2026-01-19 08:43:43', 'file', 'chat_files/hqOOYAoWptiGtFdZHyHZX2WMwzTzyVisYHejIxxT.webp', NULL),
(57, 1, 26, 12, 'Expected po namin na di kayo malalate sa appointment niyo po, salamat', 0, '2026-01-20 16:18:16', '2026-01-20 16:18:16', 'text', NULL, NULL),
(58, 2, 66, 1, 'doc muzta', 0, '2026-01-21 07:33:55', '2026-01-21 07:33:55', 'text', NULL, NULL),
(59, 1, 32, 12, 'ok', 0, '2026-01-28 02:14:59', '2026-01-28 02:14:59', 'text', NULL, NULL),
(60, 1, 32, 12, 'Picture1.png', 0, '2026-01-28 02:15:13', '2026-01-28 02:15:13', 'file', 'chat_files/9TCoBJBgWDZ8KPi7rx9gCcG643unwDSzDow7sJfh.png', NULL),
(61, 1, 43, 1, 'May I ask', 0, '2026-01-31 16:28:42', '2026-01-31 16:28:42', 'text', NULL, NULL),
(62, 2, 43, 1, '“May I request an emergency appointment for tomorrow? My gums are bleeding nonstop after a tooth extraction.', 0, '2026-01-31 16:34:47', '2026-01-31 16:34:47', 'text', NULL, NULL),
(63, 2, 33, 43, 'Sure Ma\'am, May we know your available time for tomorrow?', 0, '2026-01-31 16:42:27', '2026-01-31 16:42:27', 'text', NULL, NULL),
(64, 1, 80, 22, 'hindi po ako makakapunta', 0, '2026-03-06 11:06:17', '2026-03-06 11:06:17', 'text', NULL, NULL),
(65, 1, 80, 22, 'hiiiii', 0, '2026-03-06 11:30:36', '2026-03-06 11:30:36', 'text', NULL, NULL),
(66, 1, 22, 80, 'hello', 0, '2026-03-06 11:30:50', '2026-03-06 11:30:50', 'text', NULL, NULL),
(67, 1, 80, NULL, 'PicsArt_02-14-09.30.16.png', 0, '2026-03-06 11:31:14', '2026-03-06 11:31:14', 'file', 'chat_files/8DwqNmwFmkduArztM9GG7hllPF3epyPkRie1rzeM.png', NULL),
(68, 1, 81, 22, 'hiiii', 0, '2026-03-09 10:51:04', '2026-03-09 10:51:04', 'text', NULL, NULL),
(69, 1, 32, 81, 'hello', 0, '2026-03-09 10:51:13', '2026-03-09 10:51:13', 'text', NULL, NULL),
(70, 1, 81, NULL, 'Blue-And-White-Simple-Watercolor-Name-Tag.pdf', 0, '2026-03-09 10:51:42', '2026-03-09 10:51:42', 'file', 'chat_files/QfOUb5MubMKqqh0pVcxK7CMb9uoBgKa3ZmGzd1Jz.pdf', NULL);

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
(4, '2025_04_12_080159_create_newusers_table', 1),
(5, '2025_04_26_084553_add_face_to_usertbl', 1),
(6, '2025_05_04_092023_change_contact_number_to_string_in_users_table', 1),
(7, '2025_05_11_031904_addposition_usertbl', 1),
(8, '2025_05_11_032331_make_email_nullable_in_users_table', 1),
(9, '2025_05_25_044343_create_stores_table', 1),
(10, '2025_05_25_044809_create_store_staff_table', 1),
(11, '2025_06_01_131635_fix_contactnumber', 1),
(12, '2025_06_12_072949_add_openings_schedule', 1),
(13, '2025_06_17_142116_create_appointments_table', 1),
(14, '2025_06_19_130321_add_booking_end_time_to_appointments_table', 1),
(15, '2025_06_19_150234_add_work_done_and_total_price_to_appointments_table', 1),
(16, '2025_06_20_132941_add_dentist_id_to_appointments_table', 1),
(17, '2025_06_20_165336_add_otp_to_users_table', 1),
(18, '2025_06_21_143457_add_signup_fields_to_users_table', 1),
(19, '2025_06_21_145443_add_signup_fields_to_newusers_table', 1),
(20, '2025_06_24_074538_create_services_table', 1),
(21, '2025_06_25_090009_add_service_name_to_appointments_table', 1),
(22, '2025_06_25_092411_paymenttype_to_appointments_table', 1),
(23, '2025_06_28_025529_add_profileimage_to_user_table', 1),
(24, '2025_06_29_054331_make_payment_type_nullable_in_appointments_table', 1),
(25, '2025_06_29_074954_add_qr_in_users_table', 1),
(26, '2025_06_29_091623_add_qrtoken_in_users_table', 1),
(27, '2025_07_01_134136_create_notifications_table', 1),
(28, '2025_07_06_130812_create_daily_logs_table', 1),
(29, '2025_07_20_050951_create_medical_forms_table', 1),
(30, '2025_07_20_070345_add_formstatus_to_table_users', 1),
(31, '2025_07_27_134745_create_medicines_table', 1),
(32, '2025_07_27_134816_create_medicine_batches_table', 1),
(33, '2025_08_03_110711_create_medicine_movements_table', 1),
(34, '2025_08_13_020126_make_formstatus_null', 1),
(35, '2025_08_13_085859_add_status_to_batches_table', 1),
(36, '2025_08_14_073633_change_type_in_medicine_movements', 1),
(37, '2025_08_21_065025_add_consent_users_table', 2),
(38, '2025_08_21_072534_create_patient_records_table', 2),
(39, '2025_08_23_030612_create_dental_charts_table', 2),
(40, '2025_08_31_062002_add_user_id_to_patients_records_table', 3),
(41, '2025_08_31_065153_modify_lastname_firstname_nullable_in_patient_records', 3),
(42, '2025_09_11_134334_create_sales_table', 4),
(43, '2025_09_11_134335_create_sale_items_table', 4),
(44, '2025_09_12_130941_add_patient_id_to_sales_table', 4),
(45, '2025_09_20_034421_create_messages_table', 5),
(46, '2025_10_10_124648_add_soft_deletes_to_users_table', 6),
(47, '2025_10_30_141313_add_service_ids_to_appointments_table', 7),
(48, '2025_10_30_145606_change_service_ids_type_in_appointments_table', 7),
(49, '2025_11_14_140131_remove_service_name_from_appointments_table', 8),
(50, '2026_01_15_074240_add_files_to_messages_table', 9),
(51, '2026_01_15_075258_add_file_columns_to_messages_table', 10),
(52, '2026_01_15_083328_add_file_columns_to_messages_table', 11),
(53, '2026_01_18_014024_create_dental_teeth_table', 12),
(54, '2026_02_12_162318_create_dailylogs_add_store', 13),
(55, '2026_02_25_131440_add_face_descriptor_to_users_table', 14),
(56, '2026_04_10_000001_break_down_address_fields', 15);

-- --------------------------------------------------------

--
-- Table structure for table `newusers`
--

CREATE TABLE `newusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `verification_id` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newusers`
--

INSERT INTO `newusers` (`id`, `name`, `status`, `birth_date`, `user`, `email`, `contact_number`, `password`, `remember_token`, `created_at`, `updated_at`, `middlename`, `lastname`, `suffix`, `birthdate`, `birthplace`, `current_address`, `verification_id`, `account_type`) VALUES
(18, 'Charlotte', NULL, NULL, 'Boxie', 'boxerrobotlover@gmail.com', '09876543211', '$2y$12$4iQQnpHyVcLErace/Le0o.DJifbso8Bgj3W5wzY5hfDoUSnGFkWeG', NULL, '2026-02-13 09:32:22', '2026-02-13 09:32:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'patient'),
(19, 'Jorey', NULL, NULL, 'jorey', 'Jorey282019@gmail.com', '09612709883', '$2y$12$hZVxuINpzOOqooKi73d67unqb6X6g72o2FimAscfMfItNsOFBfMn.', NULL, '2026-02-13 12:41:57', '2026-02-13 12:41:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'patient'),
(20, 'Dhan', NULL, NULL, 'liam123', 'l38674900@gmail.com', '09949499451', '$2y$12$4qQe3Vyx7exQ3Fsoe.WDy.QsG/4NJnB88DyU5zS6kbywNcYtI3p1u', NULL, '2026-02-24 18:08:01', '2026-02-24 18:08:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'patient');

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
('002d3531-82e6-4b99-9ebf-2c4778fe05e3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2025-11-24 16:24:33', '2025-11-24 16:24:03', '2025-11-24 16:24:33'),
('02e285a5-bdbe-4ecd-b065-214a06d6219a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on February 23, 2026 (6:15 PM - 6:30 PM)\",\"url\":null}', NULL, '2026-02-23 18:09:07', '2026-02-23 18:09:07'),
('0362715c-3b1f-4ed7-92cb-2b26709340d1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 77, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:00 PM - 1:45 PM)\",\"url\":null}', '2026-02-25 16:22:07', '2026-02-25 16:13:29', '2026-02-25 16:22:07'),
('04f987a2-4314-46a0-a5af-09e1ea00aecb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2025-11-24 16:20:11', '2025-11-24 16:20:11'),
('06485a2a-2786-43ab-bf5a-5c0e45d12ae8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:58:51', '2025-10-07 05:26:23'),
('08233f66-53d8-4d83-8a8c-17a5cb9ba5df', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:19:46', '2026-01-16 01:00:58'),
('098228bd-3a2d-4729-939d-6ee611737163', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-05 02:14:26', '2025-08-31 01:36:20', '2025-09-05 02:14:26'),
('0b5bfd79-69c8-4805-b9dd-894ecfff5c56', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:18:59', '2026-01-16 01:00:58'),
('0cd33978-edec-48bf-b689-1c533b186f7b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:33', '2025-10-07 05:26:23'),
('0d12ec94-f882-4cd7-8309-588c6b50141f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 22:45:18', '2025-10-07 22:44:36', '2025-10-07 22:45:18'),
('0ef7a2ff-3c65-42bb-acf8-44d2bbd9a356', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 59, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 17, 2026 (1:00 PM - 2:30 PM)\",\"url\":null}', NULL, '2026-01-16 04:23:43', '2026-01-16 04:23:43'),
('0ef9a5d7-b4af-49cd-966f-9e69b061e5f6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 22, 2026 (4:00 PM - 7:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 19:05:43', '2026-01-16 01:00:58'),
('10180c6b-6e02-4330-8d82-8d7841d4a131', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 5, 2025 (9:10 AM - 9:25 AM)\",\"url\":null}', NULL, '2025-11-26 20:45:44', '2025-11-26 20:45:44'),
('12386d1f-8f6b-4a5b-833e-a7bf863997bc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('17293ce7-23ea-4420-83af-148ce823af25', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 18, 2025 (7:00 AM - 7:45 AM)\",\"url\":null}', '2025-11-29 02:23:34', '2025-11-26 06:49:54', '2025-11-29 02:23:34'),
('17d955aa-8a84-4576-8fa8-ea50a3b57e72', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-01-11 23:36:05', '2026-01-11 23:36:05'),
('1b37f983-c7fb-4599-be9c-cc36efa3e4ef', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 5, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-03-05 22:27:16', '2026-03-05 17:33:58', '2026-03-05 22:27:16'),
('1ceb9463-7a8f-468e-b9b4-5566af5ced8f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:46', '2025-09-07 22:33:46'),
('1dca694d-4a82-4b21-b765-b635b3cd97fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 5, 2025 (9:10 AM - 9:25 AM)\",\"url\":null}', NULL, '2025-11-24 16:22:47', '2025-11-24 16:22:47'),
('23ffb69a-ef3c-4b52-8f07-8a2bc0d131b2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 64, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-20 13:30:46', '2026-01-20 13:30:17', '2026-01-20 13:30:46'),
('2593b66f-a9f0-4306-b338-e2ef960139c1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:11', '2025-11-26 20:42:11'),
('2c0b8360-faef-41b2-84f1-f8c6e8bca7fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('2e1f0338-7f57-4d4c-859b-3b1162860c76', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-30 10:02:09', '2026-01-13 01:10:48'),
('2f854ee6-b60c-4ff2-8f61-dc054b2c3b3e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 13, 2025 (9:00 AM - 9:30 AM)\",\"url\":null}', '2026-01-31 16:16:44', '2025-11-26 20:48:17', '2026-01-31 16:16:44'),
('303e9b26-e5c2-44ae-b333-5b1767e3bbdf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 78, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-02-26 14:55:11', '2026-02-26 14:55:11'),
('3745a3df-8194-4b26-9601-84f9d5b1e87b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 54, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 31, 2026 (10:00 AM - 10:15 AM)\",\"url\":null}', NULL, '2026-01-31 18:10:29', '2026-01-31 18:10:29'),
('3a44d9de-df1b-456e-aad5-c1d12845b095', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 27, 2025 (7:00 AM - 8:00 AM)\",\"url\":null}', '2025-11-26 20:30:08', '2025-11-24 16:29:29', '2025-11-26 20:30:08'),
('3b7522ee-6532-4579-9313-0c6fa235206b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-03-06 10:37:24', '2026-03-06 10:32:24', '2026-03-06 10:37:24'),
('439d5819-fa0d-433c-9589-183976b4dafe', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:06:40', '2026-01-13 01:10:48'),
('443ea319-6ccb-4af2-bb5e-7035830e646d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 78, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:45 PM - 2:00 PM)\",\"url\":null}', NULL, '2026-02-26 14:57:32', '2026-02-26 14:57:32'),
('47c3955f-6e3d-40e1-a8e6-78a333e920a8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 19:04:19', '2026-01-16 01:00:58'),
('4a6695ae-821c-4f85-a70b-923f6f06fc6e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 23, 2026 (4:00 PM - 6:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:51:28', '2026-01-16 01:00:58'),
('4ccb00ff-29c2-4ded-b671-108d1538a965', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (9:00 AM - 10:15 AM)\",\"url\":null}', '2026-01-20 03:32:00', '2026-01-16 02:40:47', '2026-01-20 03:32:00'),
('4e3345dc-47c8-44f4-be2b-936f727da3a7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-02-23 17:43:55', '2026-02-23 17:43:37', '2026-02-23 17:43:55'),
('54f16692-c45f-4a5a-abc9-c01c8e2e3f76', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (12:46 PM - 1:16 PM)\",\"url\":null}', '2026-02-21 13:05:59', '2026-02-13 13:04:52', '2026-02-21 13:05:59'),
('550addb7-4972-4bdf-99e2-cb3b2fec5575', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:00:30', '2025-10-07 05:26:23'),
('5579640f-9133-4b56-97c5-e7789ef0ffda', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-24 16:57:59', '2026-01-13 01:10:48'),
('55f8c5b1-6a35-4f0c-9995-bb24f9e5a225', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (9:00 AM - 9:45 AM)\",\"url\":null}', '2026-03-06 10:37:24', '2026-03-06 10:36:46', '2026-03-06 10:37:24'),
('55fe8835-7139-4aa8-87de-ac47cdfd9c0e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (2:15 PM - 3:00 PM)\",\"url\":null}', '2026-03-06 10:59:30', '2026-03-06 10:57:16', '2026-03-06 10:59:30'),
('59ed5555-b5dd-44a5-8901-edad0ed63bc9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 23:36:44', '2025-10-07 23:36:44'),
('5c699ba8-df22-4987-bbab-d206c4c7f12c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:00 AM)\",\"url\":null}', NULL, '2026-01-11 20:49:07', '2026-01-11 20:49:07'),
('6105ec9b-44c2-4934-8177-fe7c9db9d0b8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 7, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2026-02-13 09:12:17', '2026-02-13 09:12:17'),
('66584c95-fe70-4ee3-9612-983aaf72d1f2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 15, 2026 (2:00 PM - 3:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 22:34:05', '2026-01-16 01:00:58'),
('67e2aa25-1a05-4c17-b7ec-acd4ed15a639', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on January 27, 2026 (10:00 PM - 11:00 PM)\",\"url\":null}', NULL, '2026-01-18 14:00:15', '2026-01-18 14:00:15'),
('6803f2ab-c0a4-4ff5-a414-b1adca5085fb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (3:16 PM - 3:46 PM)\",\"url\":null}', '2026-02-21 13:05:59', '2026-02-13 13:40:49', '2026-02-21 13:05:59'),
('6812ecf5-d7da-45cc-90c6-282eaa8c657f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-10-21 02:03:28', '2025-10-21 02:03:27', '2025-10-21 02:03:28'),
('6972c281-2a41-4d85-9e44-b5c1b828bf6c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:25:12', '2025-10-07 05:26:23'),
('69c1157d-5f91-4756-8e9e-3e7a3ad81a40', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:41', '2025-09-07 22:33:41'),
('6a9dff2f-bb2f-4084-bac5-fd46fc1f000d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:54', '2025-09-07 22:33:54'),
('6b549db8-949c-44dd-aa2c-ce205a6d83d5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:25:00', '2026-01-16 01:00:58'),
('6cffb6e6-141f-48ed-babc-8c873e5bab9a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (7:00 AM - 8:00 AM)\",\"url\":null}', '2025-11-26 20:30:08', '2025-11-24 16:29:31', '2025-11-26 20:30:08'),
('6f23d579-75e9-46d4-9419-1ed334a4bf05', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 42, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on January 24, 2026 (10:00 PM - 10:30 PM)\",\"url\":null}', NULL, '2026-02-25 14:59:09', '2026-02-25 14:59:09'),
('72d9efb6-e1bf-4506-a41a-03eb9a8c1923', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:52:46', '2026-01-13 01:10:48'),
('73b4a7b0-5ec7-4a6e-94ed-28941b12d0e4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 30, 2026 (11:00 AM - 11:45 AM)\",\"url\":null}', NULL, '2026-02-05 06:47:59', '2026-02-05 06:47:59'),
('769aa53e-6f04-4162-8e6f-f75e1cb7b283', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:50', '2025-09-07 22:33:50'),
('7741a924-b510-421f-b5ea-41ae9d984b75', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 18, 2025 (10:30 AM - 10:45 AM)\",\"url\":null}', '2025-10-31 17:37:57', '2025-10-19 00:39:55', '2025-10-31 17:37:57'),
('77554393-6eca-4a34-8165-9669d10f5397', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 60, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 17, 2026 (12:00 PM - 12:45 PM)\",\"url\":null}', NULL, '2026-01-16 05:16:58', '2026-01-16 05:16:58'),
('7f70f865-a369-474e-872b-81741ed95147', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (8:30 AM - 9:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:18:50', '2025-11-24 16:18:50'),
('8053b06f-78a9-452a-9922-192a72eec0a4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 72, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 24, 2026 (5:00 PM - 5:15 PM)\",\"url\":null}', NULL, '2026-02-24 18:16:53', '2026-02-24 18:16:53'),
('820b3d50-097e-439f-8fc1-9a285b4f40b6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 79, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on March 2, 2026 (3:45 PM - 4:15 PM)\",\"url\":null}', NULL, '2026-03-01 21:17:59', '2026-03-01 21:17:59'),
('849feee9-f3f7-4d6b-933b-eda5aefd63e9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:19:16', '2025-11-24 16:19:16'),
('8641441f-33c4-48a7-a6a5-899f384b9510', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:46:26', '2025-10-07 21:46:26'),
('887842a9-48c8-4f10-bd85-07e503c33ee4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 71, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 19, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', NULL, '2026-02-13 12:45:31', '2026-02-13 12:45:31'),
('89a509f1-0266-4eb5-a303-1dd5bb6dc68e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-14 21:02:06', '2025-09-07 22:41:37', '2025-09-14 21:02:06'),
('8d00448b-50fa-4173-af1e-4c9a3a40aac3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 15, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 21, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', NULL, '2026-01-31 18:11:36', '2026-01-31 18:11:36'),
('9058f8e6-857e-4110-ad35-b5de795eaf36', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-30 10:52:39', '2026-01-13 01:10:48'),
('9061a9ea-4114-487c-b504-6ce908f92a40', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on October 18, 2025 (10:30 AM - 10:45 AM)\",\"url\":null}', '2025-10-31 17:37:57', '2025-10-19 00:39:55', '2025-10-31 17:37:57'),
('91a5edac-3b8b-4e3c-b63e-ac8548e521f0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', '2025-10-17 08:18:41', '2025-10-17 08:16:47', '2025-10-17 08:18:41'),
('922d75c8-5c85-4ed1-81a1-e9b6cd4bd108', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:47:15', '2025-10-07 21:47:15'),
('94049e0b-9d19-4710-be82-8ea430008d9c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:46:29', '2025-10-07 21:46:29'),
('9507c4c8-cd1b-4a30-adae-f4683720c7e3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:06:37', '2026-01-13 01:10:48'),
('98900487-aacd-4b70-96b6-a0b31c380ea5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 66, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 26, 2026 (8:00 PM - 8:15 PM)\",\"url\":null}', NULL, '2026-02-01 07:33:46', '2026-02-01 07:33:46'),
('9ebfc04e-adc5-4286-a15a-57df0898dd99', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 44, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 18, 2025 (8:45 AM - 10:15 AM)\",\"url\":null}', NULL, '2026-01-11 20:40:13', '2026-01-11 20:40:13'),
('a0a280e8-1720-4a8c-ab35-59f69e639185', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:57', '2025-10-07 05:26:23'),
('a18248d6-a468-4a08-bf34-11a94a74febc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:19:19', '2025-11-24 16:19:19'),
('a82d1137-702a-4d85-883a-f83a94f1a100', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-01 22:49:49', '2025-08-31 00:49:13', '2025-09-01 22:49:49'),
('a9b651c9-2fed-442a-a2e4-029441995f82', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:24:57', '2026-01-16 01:00:58'),
('aa642806-68fe-4f05-97cd-72579b72da34', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 13, 2025 (9:00 AM - 9:30 AM)\",\"url\":null}', '2026-01-31 16:16:44', '2025-11-11 07:04:11', '2026-01-31 16:16:44'),
('ae268bf0-4f54-4d58-8404-db3aa61aa2b3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 07:46:16', '2025-11-26 07:46:16'),
('af60ab77-7e4e-479e-ad57-46d3b7743a4d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-11 01:12:39', '2026-01-16 01:00:58'),
('af9761db-170a-4885-ad38-1497ed21d767', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 51, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2025-11-26 08:05:38', '2025-11-26 08:05:13', '2025-11-26 08:05:38'),
('b14f73b0-4762-4b25-834a-63ed3adf196d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:33', '2025-10-07 05:26:23'),
('b1b720f5-6011-4936-998f-8b960fdb4438', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 4, 2026 (9:00 AM - 10:15 AM)\",\"url\":null}', '2026-03-05 22:27:16', '2026-03-04 16:44:36', '2026-03-05 22:27:16'),
('b5c86f3e-a571-4e33-acbf-b285f69554e5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 56, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on January 16, 2026 (9:00 PM - 10:00 PM)\",\"url\":null}', '2026-01-16 02:47:38', '2026-01-16 02:15:36', '2026-01-16 02:47:38'),
('b7ea230f-ec61-4f35-adc1-c8714a8f669c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on February 23, 2026 (6:00 PM - 6:15 PM)\",\"url\":null}', '2026-02-23 17:54:00', '2026-02-23 17:47:46', '2026-02-23 17:54:00'),
('b8e89f22-4a95-45bb-81c4-09635cbce6d7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:00 PM - 2:30 PM)\",\"url\":null}', NULL, '2026-02-25 16:14:18', '2026-02-25 16:14:18'),
('bafca1cb-46ae-482d-a2b8-3c3106c81284', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-02 22:53:05', '2025-09-02 10:15:35', '2025-09-02 22:53:05'),
('bb5c99a6-5791-40c8-97f6-3c6db1534d1c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-11-11 06:20:58', '2025-10-31 17:45:02', '2025-11-11 06:20:58'),
('c034094e-f828-40bc-b51e-b8dc52dd17be', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-01-18 13:59:23', '2026-01-18 13:59:23'),
('c0f8c690-e477-446c-a591-b5d3dd75da42', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-10-21 02:03:28', '2025-10-21 02:03:24', '2025-10-21 02:03:28'),
('c107a423-0c9d-4292-b3f3-20d59f0b20c7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 70, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (10:31 AM - 10:46 AM)\",\"url\":null}', NULL, '2026-02-13 09:35:17', '2026-02-13 09:35:17'),
('c1d9371c-c33c-4447-b938-37eeba82942e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:25:17', '2026-01-16 01:00:58'),
('c6b27e7b-b4a5-4781-b897-097bd92bb6dd', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 06:03:52', '2025-10-07 06:03:52'),
('cd80d1ae-a543-45e8-a7d1-b09bae49814b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:25:21', '2025-10-07 05:26:23'),
('d14c5581-f576-4ee0-a4f3-5c860184a7e8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 44, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 17, 2025 (6:00 AM - 6:45 AM)\",\"url\":null}', NULL, '2025-11-14 06:06:18', '2025-11-14 06:06:18'),
('d17eb262-6ec6-49ba-97d1-9e2b4107aca9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2025-08-28 22:18:38', '2025-08-28 22:18:24', '2025-08-28 22:18:38'),
('dddbbf75-c3ef-45c0-86a8-b2222e03ac4b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('e0fac739-f275-47a3-9aee-abf69dde3b4a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 79, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on March 2, 2026 (3:00 PM - 3:45 PM)\",\"url\":null}', NULL, '2026-03-01 21:13:11', '2026-03-01 21:13:11'),
('e41bee49-ed13-4464-90f8-5617000c9341', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 81, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 9, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-03-09 10:16:17', '2026-03-09 10:15:18', '2026-03-09 10:16:17'),
('e45d8a10-68d8-4c79-8cc7-dab2fb29974c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 23:36:43', '2025-10-07 23:36:43'),
('e78c7435-d6ee-4085-9236-21fdc6c69e95', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 21:49:18', '2025-10-07 06:46:45', '2025-10-07 21:49:18'),
('ec3d87a4-688e-4f9a-a624-9dd9d03bba49', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Santa Maria Santiago-Amancio Branch to October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', NULL, '2026-01-13 02:47:23', '2026-01-13 02:47:23'),
('f04d8897-35b3-4d0d-8a37-ffd19dfa0259', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Santa Maria Santiago-Amancio Branch to October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', NULL, '2026-01-13 02:47:24', '2026-01-13 02:47:24'),
('f1c46e7a-1c0b-4863-baf2-f16ece18031c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 15, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-11 20:52:07', '2026-01-16 01:00:58'),
('f5d1b686-1790-492d-8d30-f954a3dd2746', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 21:49:18', '2025-10-07 21:47:57', '2025-10-07 21:49:18'),
('f68c3515-3ffa-4889-80e4-78b2cbeaf5b0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 38, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 5, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2026-02-25 16:21:11', '2026-02-25 16:21:11'),
('f791561b-bde8-4500-90b7-687f35868705', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 14, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-10 05:06:55', '2025-09-10 05:01:06', '2025-09-10 05:06:55'),
('fe3e6a81-3251-4ebf-b436-32b6de47fa35', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 60, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 19, 2026 (12:00 PM - 12:30 PM)\",\"url\":null}', NULL, '2026-01-31 18:11:13', '2026-01-31 18:11:13'),
('feb2bf22-740c-47e1-8a58-19de3295fc56', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:17:13', '2026-01-16 01:00:58'),
('ff032b7a-2646-4a52-8eda-bd61a3852c0f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (8:30 AM - 9:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:18:47', '2025-11-24 16:18:47');

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
-- Table structure for table `patient_records`
--

CREATE TABLE `patient_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `office_address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `reason_for_consultation` varchar(255) DEFAULT NULL,
  `previous_dentist` varchar(255) DEFAULT NULL,
  `last_dental_visit` varchar(255) DEFAULT NULL,
  `physician_name` varchar(255) DEFAULT NULL,
  `physician_specialty` varchar(255) DEFAULT NULL,
  `physician_contact` varchar(255) DEFAULT NULL,
  `in_good_health` tinyint(1) NOT NULL DEFAULT 0,
  `under_treatment` tinyint(1) NOT NULL DEFAULT 0,
  `had_illness_operation` tinyint(1) NOT NULL DEFAULT 0,
  `hospitalized` tinyint(1) NOT NULL DEFAULT 0,
  `taking_medication` tinyint(1) NOT NULL DEFAULT 0,
  `allergic` tinyint(1) NOT NULL DEFAULT 0,
  `bleeding_time` tinyint(1) NOT NULL DEFAULT 0,
  `pregnant` tinyint(1) NOT NULL DEFAULT 0,
  `nursing` tinyint(1) NOT NULL DEFAULT 0,
  `birth_control_pills` tinyint(1) NOT NULL DEFAULT 0,
  `blood_type` varchar(255) DEFAULT NULL,
  `health_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`health_conditions`)),
  `medical_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medical_conditions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_records`
--

INSERT INTO `patient_records` (`id`, `last_name`, `first_name`, `middle_name`, `birthdate`, `sex`, `nationality`, `religion`, `occupation`, `home_address`, `office_address`, `contact_number`, `email`, `referred_by`, `reason_for_consultation`, `previous_dentist`, `last_dental_visit`, `physician_name`, `physician_specialty`, `physician_contact`, `in_good_health`, `under_treatment`, `had_illness_operation`, `hospitalized`, `taking_medication`, `allergic`, `bleeding_time`, `pregnant`, `nursing`, `birth_control_pills`, `blood_type`, `health_conditions`, `medical_conditions`, `created_at`, `updated_at`, `user_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-08-31 01:36:36', '2025-09-05 05:32:34', 12),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-09-02 09:56:48', '2025-09-02 09:56:48', 11),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-09-02 09:58:05', '2025-09-02 09:58:05', 6),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-09-07 22:16:18', '2025-09-07 22:16:18', 13),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-09-07 22:44:41', '2025-09-07 22:44:41', 8),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-10-07 23:53:44', '2025-10-07 23:53:44', 18),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-10-08 05:14:54', '2025-10-08 05:14:54', 19),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-10-15 22:42:53', '2025-10-15 22:42:53', 36),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-10-17 08:16:51', '2025-10-17 08:16:51', 37),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-10-19 00:34:52', '2025-10-19 00:34:52', 32),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-11-12 05:38:13', '2025-11-12 05:38:13', 44),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-11-23 01:44:36', '2025-11-23 01:44:36', 42),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-11-24 07:56:23', '2025-11-24 07:56:23', 38),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-11-24 16:25:18', '2025-11-24 16:25:18', 50),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2025-11-26 07:06:45', '2025-11-26 07:06:45', 43),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-01-14 22:30:38', '2026-01-14 22:30:38', 45),
(29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-01-16 04:23:46', '2026-01-16 04:23:46', 59),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-01-19 14:18:24', '2026-01-19 14:18:24', 64),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-01-21 07:33:15', '2026-01-21 07:33:15', 66),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-01-31 18:10:41', '2026-01-31 18:10:41', 54),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-02-13 10:18:57', '2026-02-13 10:18:57', 70),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-02-24 18:18:39', '2026-02-24 18:18:39', 72),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-02-25 15:24:26', '2026-02-25 15:24:26', 77),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-02-26 15:05:38', '2026-02-26 15:05:38', 78),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-03-01 21:13:20', '2026-03-01 21:13:20', 79),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-03-06 10:35:05', '2026-03-06 10:35:05', 80),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2026-03-09 10:18:15', '2026-03-09 10:18:15', 81);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_given` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','completed','void') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `store_id`, `user_id`, `patient_id`, `total_amount`, `amount_given`, `change_amount`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 40.00, NULL, NULL, 'completed', NULL, '2025-09-12 22:25:31', '2025-09-12 22:25:31'),
(2, 2, 1, NULL, 25.00, NULL, NULL, 'completed', NULL, '2025-09-12 22:25:42', '2025-09-12 22:25:42'),
(3, 2, 7, 11, 49.00, NULL, NULL, 'completed', NULL, '2025-09-15 05:11:54', '2025-09-15 05:11:54'),
(4, 2, 7, NULL, 21.00, NULL, NULL, 'completed', NULL, '2025-09-17 02:27:25', '2025-09-17 02:27:25'),
(5, 2, 7, NULL, 10.00, NULL, NULL, 'completed', NULL, '2025-09-17 02:27:54', '2025-09-17 02:27:54'),
(6, 2, 9, 11, 5.00, NULL, NULL, 'completed', NULL, '2025-10-07 21:53:31', '2025-10-07 21:53:31'),
(7, 1, 3, NULL, 20.00, NULL, NULL, 'completed', NULL, '2025-10-07 23:25:30', '2025-10-07 23:25:30'),
(8, 2, 9, NULL, 5.00, NULL, NULL, 'completed', NULL, '2025-10-07 23:31:51', '2025-10-07 23:31:51'),
(9, 1, 3, NULL, 50.00, NULL, NULL, 'completed', NULL, '2025-10-07 23:56:07', '2025-10-07 23:56:07'),
(10, 2, 33, NULL, 14.00, NULL, NULL, 'completed', NULL, '2025-11-24 07:59:40', '2025-11-24 07:59:40'),
(11, 1, 26, 13, 80.00, NULL, NULL, 'completed', NULL, '2026-01-11 23:37:46', '2026-01-11 23:37:46'),
(12, 1, 26, NULL, 50.00, NULL, NULL, 'completed', NULL, '2026-02-24 18:29:26', '2026-02-24 18:29:26'),
(13, 1, 32, 81, 75.00, NULL, NULL, 'completed', NULL, '2026-03-09 10:48:09', '2026-03-09 10:48:09'),
(14, 2, 33, 43, 14.00, NULL, NULL, 'completed', NULL, '2026-04-01 00:26:58', '2026-04-01 00:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `medicine_id`, `medicine_batch_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 8, 5.00, 40.00, '2025-09-12 22:25:31', '2025-09-12 22:25:31'),
(2, 2, 1, 1, 5, 5.00, 25.00, '2025-09-12 22:25:42', '2025-09-12 22:25:42'),
(3, 3, 2, 2, 7, 7.00, 49.00, '2025-09-15 05:11:54', '2025-09-15 05:11:54'),
(4, 4, 2, 2, 3, 7.00, 21.00, '2025-09-17 02:27:25', '2025-09-17 02:27:25'),
(5, 5, 1, 1, 2, 5.00, 10.00, '2025-09-17 02:27:54', '2025-09-17 02:27:54'),
(6, 6, 1, 1, 1, 5.00, 5.00, '2025-10-07 21:53:31', '2025-10-07 21:53:31'),
(7, 7, 5, 5, 2, 10.00, 20.00, '2025-10-07 23:25:30', '2025-10-07 23:25:30'),
(8, 8, 1, 1, 1, 5.00, 5.00, '2025-10-07 23:31:51', '2025-10-07 23:31:51'),
(9, 9, 5, 5, 5, 10.00, 50.00, '2025-10-07 23:56:07', '2025-10-07 23:56:07'),
(10, 10, 2, 2, 2, 7.00, 14.00, '2025-11-24 07:59:40', '2025-11-24 07:59:40'),
(11, 11, 5, 5, 8, 10.00, 80.00, '2026-01-11 23:37:46', '2026-01-11 23:37:46'),
(12, 12, 1, 3, 3, 5.00, 15.00, '2026-02-24 18:29:26', '2026-02-24 18:29:26'),
(13, 12, 2, 9, 5, 7.00, 35.00, '2026-02-24 18:29:26', '2026-02-24 18:29:26'),
(14, 13, 1, 3, 15, 5.00, 75.00, '2026-03-09 10:48:09', '2026-03-09 10:48:09'),
(15, 14, 2, 2, 2, 7.00, 14.00, '2026-04-01 00:26:58', '2026-04-01 00:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `approx_time` int(11) NOT NULL,
  `approx_price` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `type`, `approx_time`, `approx_price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Simple Extraction', 'Oral Surgery', 15, 500.00, 'Removal of a tooth that is loose or damaged.', 'service_68cbe0f3cc38a.png', '2025-08-28 04:25:32', '2025-09-18 02:37:39'),
(2, 'Oral Prophylaxis (Cleaning)', 'General Dentistry', 30, 500.00, 'Professional cleaning to remove plaque and tartar.', 'service_68cbe10109705.png', '2025-08-28 04:29:04', '2025-09-18 02:37:53'),
(3, 'Restoration (Filling)', 'General Dentistry', 30, 1000.00, 'Filling a cavity or repairing minor tooth damage.', 'service_68cbe10b80ede.png', '2025-08-28 04:29:42', '2025-09-18 02:38:03'),
(4, 'Denture (Removable)', 'General Dentistry', 30, 20000.00, 'Replacement of missing teeth with a removable appliance.', 'service_68cbe115abeac.png', '2025-08-28 04:31:06', '2025-09-18 02:38:13'),
(5, 'Jacket Crown (Front Tooth)', 'General Dentistry', 45, 2000.00, 'A tooth-shaped cap to restore strength and appearance.', 'service_68cbe123d1a3f.png', '2025-08-28 04:32:06', '2025-09-18 02:38:27'),
(6, 'Fixed Prosthesis (Bridge)', 'General Dentistry', 45, 6000.00, 'A fixed replacement for one or more missing teeth.', 'service_68cbe145c8d13.png', '2025-08-28 04:32:33', '2025-09-18 02:39:01'),
(7, 'Braces (Initial Placement)', 'Orthodontics', 120, 40000.00, 'Devices to straighten teeth and improve bite alignment.', 'service_68cbe14f75b1c.png', '2025-08-28 04:33:35', '2025-09-18 02:39:11'),
(8, 'Wisdom Tooth Surgery', 'Oral Surgery', 90, 5000.00, 'Surgical removal of impacted or problematic wisdom teeth.', 'service_68cbe15aa11d0.png', '2025-08-28 04:34:30', '2025-09-18 02:39:22'),
(9, 'Root Canal Treatment', 'General Dentistry', 120, 6000.00, 'Cleaning and sealing of tooth roots to save damaged teeth.', 'service_68cbe17372f35.png', '2025-08-28 04:36:13', '2025-09-18 02:39:47');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5RSUQvPkfiLOFAsuMZnKNAJYDejLYqP1dZygMl9i', NULL, '2001:4ba0:cafe:b2c::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36 Edg/91.0.864.54', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmtZUHB3enN3TUdyUnZjVXNsR1AzeHpGOVZGZjg1NWMwTkFyeVVLdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775786622),
('71G4aB6HJPP7s7uvlvhDUBizxbLCKQ8hEJi7KRCT', NULL, '43.134.28.2', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemljTUhiT2VkRWlDNHlwZmxYUGlBWmJBYVVVOWE0cHhJb1RZaDV6VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmRlbnRhZWFzZS5vbmxpbmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1775781714),
('dtmZYJA3rOQDc7PoHLbj75QhmZacVgT2JK8467Ul', NULL, '198.244.183.76', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQVprb0VaTERzQkNDTVBKMFViWWR6b0xrMjRzWUU5OUNQQ0g4Uk0yMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775783624),
('E62tKFjiuFgXYtx9Dved2zqPCQCYmcytA2bP8Go1', NULL, '207.46.13.168', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2p4c2hCRUtsRlVwd28wUG5lelhQZVMwWGVBaFBCdk5ZSHNXV0VNdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775791228),
('lSe4GTAoSRJ5Kx6F1S3wHgQz9gM5P5N2vBJSm48e', NULL, '43.156.28.204', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1lqV1R5VXhKZUJIZ0VTMFlIOFdNOWFWVGdaMlBFekNXbE1KNTZCVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmRlbnRhZWFzZS5vbmxpbmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1775782543),
('P5ULFMELCgewTEBeOnSY3ZqKnXDLMRak4p7AiQKF', 64, '111.125.106.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZEtxRHgzbDUzTFpVckRqUHBLZlZzcGxXVlFyWm01YnBqb3R6b2tmTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZS9jcHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY0O30=', 1775790872),
('wSiHapS2Kznwh0oBZHmvSeTImSBbWCdTRsW0EhFS', NULL, '51.68.236.64', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.5; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXdLdGJlQlZaZ0F4QUV6OW5JOTdheFprZThVTVF5eGpyZTdOeU5sSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775783053);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `open_days` text DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `created_at`, `updated_at`, `open_days`, `opening_time`, `closing_time`) VALUES
(1, 'Prenza 1 Santiago-Amancio Branch', 'Prenza 1 Marilao Bulacan', '2025-08-28 04:53:41', '2026-02-25 19:17:11', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '09:00:00', '18:00:00'),
(2, 'Lambakin Santiago-Amancio Branch', 'Lambakin Marilao Bulacan', '2025-08-28 04:54:01', '2026-02-24 17:40:29', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '15:00:00', '19:00:00'),
(3, 'Santa Maria Santiago-Amancio Branch', 'Parada Sta. Maria', '2025-08-28 04:54:20', '2025-08-29 05:37:58', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '21:00:00', '23:00:00'),
(4, 'San Jose Del Monte Santiago-Amancio Branch', 'SJDM Bulacan Harmony Hills', '2025-08-28 04:54:44', '2025-08-29 05:38:44', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '21:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_staff`
--

CREATE TABLE `store_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_staff`
--

INSERT INTO `store_staff` (`id`, `store_id`, `user_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Dentist', '2025-08-28 05:30:37', '2025-08-28 05:30:37'),
(2, 1, 8, 'Receptionist', '2025-08-28 05:30:43', '2025-08-28 05:30:43'),
(4, 2, 7, 'Dentist', '2025-08-28 05:33:19', '2025-08-28 05:33:19'),
(6, 2, 9, 'Receptionist', '2025-08-28 05:33:39', '2025-08-28 05:33:39'),
(7, 2, 8, 'Receptionist', '2025-09-10 05:21:02', '2025-09-10 05:21:02'),
(8, 2, 6, 'Dentist', '2025-09-10 05:21:19', '2025-09-10 05:21:19'),
(9, 3, 10, 'Receptionist', '2025-09-15 00:06:52', '2025-09-15 00:06:52'),
(10, 3, 5, 'Dentist', '2025-09-15 00:06:58', '2025-09-15 00:06:58'),
(11, 4, 10, 'Receptionist', '2025-09-15 00:07:11', '2025-09-15 00:07:11'),
(12, 4, 5, 'Dentist', '2025-09-15 00:07:15', '2025-09-15 00:07:15'),
(13, 4, 9, 'Receptionist', '2025-09-15 00:07:21', '2025-09-15 00:07:21'),
(14, 4, 7, 'Dentist', '2025-09-15 00:07:26', '2025-09-15 00:07:26'),
(15, 1, 26, 'Dentist', '2025-10-14 04:17:01', '2025-10-14 04:17:01'),
(16, 1, 32, 'Receptionist', '2025-10-14 04:18:08', '2025-10-14 04:18:08'),
(17, 2, 33, 'Receptionist', '2025-10-14 04:18:33', '2025-10-14 04:18:33'),
(18, 2, 30, 'Dentist', '2025-10-14 04:18:39', '2025-10-14 04:18:39'),
(19, 3, 31, 'Dentist', '2025-10-14 04:19:04', '2025-10-14 04:19:04'),
(20, 3, 34, 'Receptionist', '2025-10-14 04:19:12', '2025-10-14 04:19:12'),
(21, 4, 30, 'Dentist', '2025-10-14 04:19:32', '2025-10-14 04:19:32'),
(24, 3, 26, 'Dentist', '2026-01-31 05:31:01', '2026-01-31 05:31:01'),
(25, 1, 31, 'Dentist', '2026-02-24 18:32:15', '2026-02-24 18:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_type` enum('admin','patient') DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `face_token` varchar(255) DEFAULT NULL,
  `face_descriptor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`face_descriptor`)),
  `position` enum('admin','Dentist','Receptionist') DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `otp_code` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `birthplace_municipality` varchar(255) DEFAULT NULL,
  `birthplace_province` varchar(255) DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `address_other_details` varchar(255) DEFAULT NULL,
  `address_house_number` varchar(255) DEFAULT NULL,
  `address_street` varchar(255) DEFAULT NULL,
  `address_barangay` varchar(255) DEFAULT NULL,
  `address_municipality` varchar(255) DEFAULT NULL,
  `address_province` varchar(255) DEFAULT NULL,
  `verification_id` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `formstatus` tinyint(1) DEFAULT NULL,
  `is_consent` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `account_type`, `status`, `birth_date`, `user`, `email`, `contact_number`, `password`, `remember_token`, `created_at`, `updated_at`, `face_token`, `face_descriptor`, `position`, `is_verified`, `otp_code`, `middlename`, `lastname`, `suffix`, `birthdate`, `birthplace`, `birthplace_municipality`, `birthplace_province`, `current_address`, `address_other_details`, `address_house_number`, `address_street`, `address_barangay`, `address_municipality`, `address_province`, `verification_id`, `profile_image`, `qr_token`, `qr_code`, `formstatus`, `is_consent`, `deleted_at`) VALUES
(1, 'qwe', 'admin', NULL, NULL, 'qwe', NULL, '09999999999', '$2y$12$ML4eIg4E/VG4TIj86ej/VO1kS5QraTFPgFyNMeTOSLAWfOtorjrS2', NULL, '2025-08-17 21:59:37', '2026-01-31 18:35:11', NULL, NULL, 'admin', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68e4e9569f302.jpg', '675945c8-a059-460a-a730-929e7278e77b', 'qr_1.svg', 1, NULL, '2026-01-31 18:35:11'),
(3, 'Lenard', 'admin', NULL, NULL, 'Lenard', NULL, NULL, '$2y$12$CY4Ri9701m3pxpeUHYKDreasUDBb5oMVBU15PzuFNJYke04ihwqjC', NULL, '2025-08-28 04:20:40', '2025-10-14 03:15:08', NULL, NULL, 'admin', 0, NULL, 'Espiritu', 'Dela Cruz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca948182392.jpeg', '03c1317c-0873-453a-98bc-45dc30eefb46', 'qr_3.svg', NULL, NULL, '2025-10-14 03:15:08'),
(5, 'Reynaldo', 'admin', NULL, NULL, 'Reynaldo', 'reynaldodiazjunjun28@gmail.com', '09948701129', '$2y$12$Mn1BYzVEQE/h.rlrHGFXcuueJL2AoR5fDgUngNZ0L0Glj4abrS69i', NULL, '2025-08-28 04:22:16', '2025-10-14 03:14:52', NULL, NULL, 'Dentist', 0, NULL, 'Bahil', 'Diaz', 'Jr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c7ca2c5b96a.jpg', '263e8a8c-6130-4802-8a52-9dc347ce3e5b', 'qr_5.svg', NULL, NULL, '2025-10-14 03:14:52'),
(6, 'Dhan Leonardo', 'admin', NULL, NULL, 'Dhan', 'dhanalfonso@gmail.com', '09949499451', '$2y$12$8tUA.9MFvd3FTlc5KP/1qOikWOQQItOG1dPuM3xIBDKUn4vrYg0IG', NULL, '2025-08-28 04:22:37', '2025-10-14 03:18:33', NULL, NULL, 'Dentist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca9264a1933.jpg', '13adc600-df57-47d9-90e9-7ce8922bc213', 'qr_6.svg', NULL, NULL, '2025-10-14 03:18:33'),
(7, 'Czarina Jade', 'admin', NULL, NULL, 'CzarinaJade', 'baroraczarinajade@gmail.com', '09339247279', '$2y$12$rT6EqmpfPrn3WRzPvHbVWe0ba7/aIXrujMLyUBtmqDU3FqkMCHDc6', NULL, '2025-08-28 04:22:59', '2025-10-14 03:18:51', NULL, NULL, 'Dentist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f9fd8277.jpg', '5fafe406-8d05-410f-a568-dc498536ed63', 'qr_7.svg', NULL, NULL, '2025-10-14 03:18:51'),
(8, 'Dani', 'admin', NULL, NULL, 'Dani', 'kimjeonlee03@gmail.com', '09183239884', '$2y$12$IEtaGQqw3dTufz2Mv0zexuY2ngItaE2CMxMzsFK0if3Wkm4GQ0OVy', NULL, '2025-08-28 04:23:22', '2025-10-14 03:12:40', NULL, NULL, 'Receptionist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f02c7c4a.jpg', 'e58ed137-2f8c-44c2-b2f0-de9175fec727', 'qr_8.svg', NULL, NULL, '2025-10-14 03:12:40'),
(9, 'Czarina Jade', 'admin', NULL, NULL, 'Jade', 'barorac.26@gmail.com', '09515170014', '$2y$12$7C9E2l4cktpftWutmb/JReyxjUW5GfFDZH7oim1zllZJrywiUm1jK', NULL, '2025-08-28 04:23:41', '2025-10-14 03:13:12', NULL, NULL, 'Receptionist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80ed97b4b1.jpg', '53b8edf5-c5c9-4858-9823-8cd76b87592b', 'qr_9.svg', NULL, NULL, '2025-10-14 03:13:12'),
(10, 'Joan Gail', 'admin', NULL, NULL, 'Joan', 'zaratejoangail1028@gmail.com', '09949499453', '$2y$12$s.avtG/WCQ.Wh9p4rSRSye3J7p60d4raO1z3C/11Xx/eh7j.dSa7u', NULL, '2025-08-28 04:24:10', '2025-10-14 03:13:58', NULL, NULL, 'Receptionist', 0, NULL, 'Caluag', 'Zarate', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c7cac583e00.jpg', 'c242a93c-9a22-4f90-8b93-6da6484d09d7', 'qr_10.svg', NULL, NULL, '2025-10-14 03:13:58'),
(11, 'Lian', 'patient', NULL, '2001-10-03', 'Lian', 'kimjeonlee03@gmail.com', '09949499451', '$2y$12$WKgg21GafvqtmpJFjgKt5e40TLIZrzybFJ047NirpEu9TxdeEyPje', NULL, '2025-08-28 21:24:03', '2026-01-28 01:42:42', NULL, NULL, NULL, 0, NULL, NULL, 'Mercado', NULL, NULL, 'Malolos Bulacan', NULL, NULL, 'Sta.rosa II, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68b138f807057.png', NULL, 'cbd42bc2-b95a-452b-ba82-6079dc6690ef', 'qr_11.svg', NULL, 1, '2026-01-28 01:42:42'),
(12, 'Junjun', 'patient', NULL, '2001-10-28', 'Junjun', 'reynaldodiazjunjun28@gmail.com', '09610812705', '$2y$12$iDlZWzCgM0qx1jMEqFFMTeE2Jn8tc2kMg9SyG27ZzXQWS2Ej5.TEq', NULL, '2025-08-28 22:10:36', '2026-02-13 13:03:03', NULL, NULL, NULL, 0, NULL, 'Bahil', 'Diaz', 'Jr.', NULL, 'Davao City', NULL, NULL, 'Estrella Homes BLk 5 LOT 2 PHASE $ Sta. Rosa II Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68b058c265f1e.jpg', '698eaf5841fe8.jpg', 'f19299f3-b166-4662-b2c1-0a42df53bf2d', 'qr_12.svg', 1, 1, NULL),
(13, 'Jefferson', 'patient', NULL, '2025-09-07', 'Jeff', 'jeffersoncarreon22@gmail.com', '09515170014', '$2y$12$MXZ7v.AstJLshyQWMX6RseT4zgYTqz2LDIJjF6Qh4DttZx1KqLKRy', NULL, '2025-09-07 22:16:06', '2025-09-07 22:22:04', NULL, NULL, NULL, 0, NULL, 'NA', 'Carreon', NULL, NULL, 'Marilao', NULL, NULL, 'Patubig', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68be6d392104e.jpg', NULL, '5ed7a043-e648-4432-b3f3-0f73de84d3d5', 'qr_13.svg', NULL, 1, NULL),
(16, 'Lailla', 'admin', NULL, NULL, 'Lailacruz', NULL, NULL, '$2y$12$eds0wqa7ZhyECiTv/lN/v.N0hT/JSVwzGs8bNYkY14IjAR6Jho5hC', NULL, '2025-10-07 22:22:18', '2025-10-14 03:19:04', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Gomez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eb39a2c8-1713-4c7f-96d6-e3faada76655', 'qr_16.svg', NULL, NULL, '2025-10-14 03:19:04'),
(17, 'Elijah', 'admin', NULL, NULL, 'Elijahvergara', NULL, NULL, '$2y$12$3BoNQleFlwyRVFbdNN9TVe3c21VQCrm1oaxceV5WwSgSawJOTjfqC', NULL, '2025-10-07 22:26:37', '2025-10-14 03:20:20', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Vergara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2ca00ba3-1321-4fc4-9164-57f19a52a12f', 'qr_17.svg', NULL, NULL, '2025-10-14 03:20:20'),
(18, 'Joshua', 'patient', NULL, '2001-10-03', 'Joshua', 'kimjeonlee03@gmail.com', '09949499451', '$2y$12$Ygtq9RM8G0HjjgXsxg55Sez6pf3Wh3F6QofarViM9hdLZMV3Y4gZe', NULL, '2025-10-07 23:29:55', '2025-10-07 23:29:55', NULL, NULL, NULL, 0, NULL, 'Delos Reyes', 'Villnueva', NULL, NULL, 'Malolos Bulacan', NULL, NULL, 'Sta.rosa II, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68b1378b9ea27.png', NULL, 'e4465f7a-349f-4420-b43a-22bf1eeacae0', 'qr_18.svg', NULL, NULL, NULL),
(19, 'Ronaldo', 'patient', NULL, '1998-09-23', 'Ronaldo', 'dhanalfonso@gmail.com', '09183239884', '$2y$12$cv4Xm1BeKnh7V./Sn5xdn.UOHRf6RbHjHZNr5Qp0fnbFUYCz13c.O', NULL, '2025-10-08 05:08:48', '2025-10-08 05:08:48', NULL, NULL, NULL, 0, NULL, 'Delos Reyes', 'Valenzuela', NULL, NULL, 'Marilao', NULL, NULL, 'Prenza 1, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68b7382b96b7c.jpg', NULL, 'cee34ca2-d67c-4676-8ff8-1acb556cd041', 'qr_19.svg', NULL, NULL, NULL),
(22, 'Admin', 'admin', NULL, NULL, 'Admin', NULL, NULL, '$2y$12$D3wdaMRxqMXOqcb/KSsACO6VtDbh9JtR8rZC08Lov/kcxo1i0XNNC', NULL, '2025-10-14 03:20:43', '2025-10-14 03:20:43', NULL, NULL, 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10a7d672-b0e8-4844-8fa5-6e085fc9cda1', 'qr_22.svg', NULL, NULL, NULL),
(24, 'Admin', 'admin', NULL, NULL, 'Admin1', NULL, NULL, '$2y$12$drlKxr8WLRK585/yF6O8uuU7o5a6KrdV7h7kJr.5ER4MixldzWJFi', NULL, '2025-10-14 03:41:10', '2025-10-14 03:41:42', NULL, NULL, 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3dc25ae5-e654-4de6-b060-6185eeefd593', 'qr_24.svg', NULL, NULL, '2025-10-14 03:41:42'),
(26, 'Marieta', 'admin', NULL, NULL, 'Marieta', NULL, NULL, '$2y$12$kH2iZejDSvlN5k.hJStnceguLgw48MOI.nAWkBLC09gIMTX4xJVuO', NULL, '2025-10-14 04:00:26', '2026-02-13 00:39:21', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '698e02392d303.jpg', '2ac9bad9-6049-40b5-a167-55a62f089378', 'qr_26.svg', NULL, NULL, NULL),
(30, 'Abelardo', 'admin', NULL, NULL, 'Abelardo', NULL, NULL, '$2y$12$mL6AtGGDgpcQJT5abHGPouhFMpD4yqWWkX9jExq9c4M3mzR81bMtS', NULL, '2025-10-14 04:01:43', '2025-10-14 06:30:54', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Santiago', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5e9ec2717.jpg', '7621a5ee-c885-4b31-be50-add793034a58', 'qr_30.svg', NULL, NULL, NULL),
(31, 'Sophia', 'admin', NULL, NULL, 'Sophia', NULL, NULL, '$2y$12$/f3VFNvlFsXapaMydrtgc.ynMKscMXDdv2HGP3PrGrM3L9oxrJIRG', NULL, '2025-10-14 04:02:20', '2025-10-14 06:12:27', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5a4bed193.jpg', '96284677-af80-4bc6-b5ee-fed5909129b9', 'qr_31.svg', NULL, NULL, NULL),
(32, 'Mhara Grace', 'admin', NULL, NULL, 'Mhara Grace', NULL, NULL, '$2y$12$eS9gRRYHwh2hriuX5Zf7Wu.X/q5i2qNZseiQmp8si1oSMyKw92kLi', NULL, '2025-10-14 04:03:05', '2025-10-14 06:18:07', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Robles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5b9f26481.jpg', '2cc4edc4-a649-4c73-a3f4-e4c93ece931c', 'qr_32.svg', NULL, NULL, NULL),
(33, 'Sherry', 'admin', NULL, NULL, 'Sherry', NULL, NULL, '$2y$12$gU64TU4ZXztAausvkac4C.Mr6mtXaP9zVsxWQbg0bYlMNvlaBVsIS', NULL, '2025-10-14 04:03:54', '2025-10-14 06:18:53', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Antonio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5bcd2729b.jpg', '167c88e2-c720-4f7d-8c77-20c25d71d3bd', 'qr_33.svg', NULL, NULL, NULL),
(34, 'Gloria', 'admin', NULL, NULL, 'Gloria', NULL, NULL, '$2y$12$yvY7M7VZ0WUG.25tRUIhje7nzap8mFqXzhe4rIYIPisWBOBhaTQ42', NULL, '2025-10-14 04:06:07', '2025-10-14 06:21:43', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Espiritu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5c7790e93.jpg', 'fcdbc738-256e-4d51-9f7f-db9455533af5', 'qr_34.svg', NULL, NULL, NULL),
(36, 'Charmaine Joy', 'patient', NULL, '2025-10-16', 'Joy', 'lenardx48@gmail.com', '09164115414', '$2y$12$6G73rLQjemYyv/oYUcf5x.SVk/dEwLwigF9NCjXBMLa.nuyEMczlO', NULL, '2025-10-15 22:13:50', '2026-02-25 11:04:56', NULL, NULL, NULL, 0, NULL, 'Mabini', 'Barora', 'Jr.', NULL, 'Dasmariñas Cavite', NULL, NULL, 'Patubig Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68f08b8b823d9.png', NULL, 'f6f937aa-6025-46e3-8fc0-d05781703f98', 'qr_36.svg', NULL, 1, NULL),
(37, 'Ayesha', 'patient', NULL, '2008-07-11', 'matchayesha', 'ayeshajassenc@gmail.com', '09623887507', '$2y$12$RbohKFeEmt/U2ngLetXYSuSpoErkGItcrwuFvyddLG9bpcdSUG2QG', NULL, '2025-10-17 08:12:05', '2025-10-17 08:24:10', NULL, NULL, NULL, 0, NULL, NULL, 'Jassen', NULL, NULL, 'Quezon City', NULL, NULL, 'Mandaue City, Cebu', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68f26a9144640.jpg', NULL, 'affe40ca-3edf-4924-8c32-91ac9ed292c5', 'qr_37.svg', NULL, 1, '2025-10-17 08:24:10'),
(38, 'John Christopher', 'patient', NULL, '1999-01-11', 'Jc', 'jcbarora@gmail.com', '09927756676', '$2y$12$rSUGtcVMelVpw2y4xIhsXOtm9M.gvRb2fF5dmkNJMHQnRehj91C.e', NULL, '2025-10-19 17:27:33', '2026-01-31 16:09:31', NULL, NULL, NULL, 0, NULL, 'Mabini', 'Barora', NULL, NULL, 'Trece Martires, Cavite', NULL, NULL, '91 Maligaya St. Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68f58fb9e5b60.jpg', NULL, 'e9591aff-9b15-49ab-9b2e-b1b29f87d09d', 'qr_38.svg', NULL, 1, NULL),
(42, 'Joan Gail', 'patient', NULL, '2025-10-21', 'Gail', 'zarate.joangail1028@gmail.com', '0912345678', '$2y$12$Nz3dzoApFERzlKmKmOjxj.9/3LvFeDz0t2LBBis4BSy7cHXkGZKDi', NULL, '2025-10-21 02:42:28', '2026-02-26 14:39:52', NULL, NULL, NULL, 0, NULL, 'Caluag', 'Zarate', NULL, NULL, 'Malolos Bulacan', NULL, NULL, 'Sta.rosa II, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68f7637e2db8e.png', NULL, 'b386e7ba-61d0-4223-8471-36e949b4c873', 'qr_42.svg', NULL, NULL, '2026-02-26 14:39:52'),
(43, 'Czamaya', 'patient', NULL, '2024-08-07', 'Czamaya', 'cbarora.pdm@gmail.com', '09515170014', '$2y$12$gkCICimwle6wKKKf0x4e7O632dlS40RCkqwdpnUqv2Zu1t6BJy0iW', NULL, '2025-10-31 16:56:50', '2026-01-31 16:13:47', NULL, NULL, NULL, 0, NULL, NULL, 'Barao', NULL, NULL, 'Basilan', NULL, NULL, 'Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_69055a7eecf23.jpg', NULL, '15b533b9-6a66-42ae-bc55-d05dd15ba3fc', 'qr_43.svg', NULL, 1, NULL),
(44, 'Lea', 'patient', NULL, '1998-05-02', 'LeaGomez10', 'kevinkurt071@gmail.com', '09183239884', '$2y$12$c/TL0zOpx7z3GJ3TWCgJsOMPrEJYpQSI9Y9.x67jcuy7eSY/Zy/vG', NULL, '2025-11-11 06:21:06', '2025-11-12 05:26:59', NULL, NULL, NULL, 0, NULL, 'Santos', 'Alfonso', NULL, NULL, 'Marilao, Bulacan', NULL, NULL, 'Sta.Rosa II, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_691346313fefd.png', NULL, 'a49fd28a-65b8-4eab-8d89-9cf49df9ff99', 'qr_44.svg', NULL, 1, NULL),
(45, 'Barora', 'patient', NULL, '2025-11-12', 'Czarlyn', 'czarlynchavez@gmail.com', '09515170010', '$2y$12$AqIMZbMXfrrJ7HD8KkdcvOAYj8kdZs4jkv0XNStz0O6xhuVsAuVVG', NULL, '2025-11-12 00:03:39', '2026-02-25 13:52:27', NULL, NULL, NULL, 0, NULL, NULL, 'CJ', NULL, NULL, 'Dasma', NULL, NULL, 'Marilao', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_69143f07e8d1b.jpeg', NULL, '50518f09-ffc5-43bb-a9fb-c970aeb2f86d', 'qr_45.svg', NULL, 1, NULL),
(50, 'Dan', 'patient', NULL, '2025-11-25', 'Dan123', 'dhanleonardoalfonso16@gmail.com', '09876543212', '$2y$12$RmQMBAzWv0KN2sjYf.TQ0eudcXYi7XGyPEzHrDgXWMwqbHQ5D7ote', NULL, '2025-11-24 16:11:46', '2025-11-24 16:13:39', NULL, NULL, NULL, 0, NULL, NULL, 'Alfonso', NULL, NULL, 'Marilao', NULL, NULL, 'Marilao', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_6924f416de3d1.jpeg', NULL, '39997e9b-d1eb-4a08-a5bb-8eb44fc8c63f', 'qr_50.svg', NULL, 1, NULL),
(52, 'Ryle', 'patient', NULL, '2001-12-21', 'Ryle', 'alfonsodhanleonardogomez@gmail.com', '09183239884', '$2y$12$ij9ONTtMMxEhMxcs2.z9y.JvgzTZRlRe0/L63pAWybBdMTQC8Dnra', NULL, '2025-11-29 07:59:15', '2025-11-29 07:59:15', NULL, NULL, NULL, 0, NULL, 'Fernandez', 'Mendoza', NULL, NULL, 'Marilao', NULL, NULL, 'Laot, Prenza 1, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_68f2836165363.png', NULL, '293d7abe-26f6-42f3-8018-7e97a7e5bc27', 'qr_52.svg', NULL, NULL, NULL),
(54, 'Dhan Leonardo', 'patient', NULL, '1998-08-25', 'Leo', 'ravenkade01@gmail.com', '09183239884', '$2y$12$qWr9oU2j3BIbhbIG/MobFe1wuA048rlMsLbh5M5K5IskOX2ZV/Cdy', NULL, '2026-01-13 02:16:32', '2026-01-13 02:17:10', NULL, NULL, NULL, 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, 'Malolos', NULL, NULL, 'Prenza 1, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_69661b69a32c4.jpeg', NULL, '9792d5ad-574c-4556-b1b7-efde92ff3206', 'qr_54.svg', NULL, 1, NULL),
(55, 'john', 'patient', NULL, '2026-01-13', 'JoshuaPogi123', 'awdawdaw.pdm@gmail.com', '09454454744', '$2y$12$pTBZ.v2MLKzu5ymFy0fFyeza4O0tCdISn2ptEm8bMJ2wcwuV.NtPi', NULL, '2026-01-13 02:20:44', '2026-01-13 02:20:44', NULL, NULL, NULL, 0, NULL, NULL, 'doe', NULL, NULL, 'sta.maria', NULL, NULL, 'mexico pampanga', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_69661c616274c.png', NULL, 'f52704b7-cb8f-4e46-a828-fff97d4ed4f8', 'qr_55.svg', NULL, NULL, NULL),
(59, 'Gail', 'patient', NULL, '2005-01-28', 'gail_123', 'joancaluag.28@gmail.com', '09612709883', '$2y$12$XrqbBxKKe5pQal9CMp1druyUzuCXoNZjOi4oETy3kM1PO9RLOc1jC', NULL, '2026-01-16 02:38:12', '2026-01-16 02:38:28', NULL, NULL, NULL, 0, NULL, NULL, 'Caluag', NULL, NULL, 'Tondo Manila', NULL, NULL, 'Sta. Rosa 2 Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, 'verify_6969a47f3f592.jpg', NULL, 'a587bdd7-2137-40fa-b2f5-e341b8375dcd', 'qr_59.svg', NULL, 1, NULL),
(62, 'Jake', 'patient', NULL, '2000-02-01', 'jake', 'diazreynaldojrb.pdm@gmail.com', '09612709883', '$2y$12$SlaVewqxFb6FicypZ2Slb.VqqP7aMPLMKOygC2z5F4gYAa3EIqYqm', NULL, '2026-01-17 12:20:57', '2026-01-17 12:21:23', NULL, NULL, NULL, 0, NULL, NULL, 'Cyrus', NULL, NULL, 'Cavite', NULL, NULL, 'Sta. Rosa 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd34f4f2d-a8c5-451a-88e5-a98bc4b007bc', 'qr_62.svg', NULL, 1, NULL),
(63, 'Yer', 'patient', NULL, '1999-05-25', 'yer', 'reynaldoverbo.25@gmail.com', '09811460053', '$2y$12$DBFfs1e7OyIUs6cWxzJgXeFxg2oGPryn75CR9YU5qo9lh/.pAy1r.', NULL, '2026-01-17 12:31:01', '2026-01-17 13:02:52', NULL, NULL, NULL, 0, NULL, NULL, 'Zida', NULL, NULL, 'Davao', NULL, NULL, 'Sta. maria', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5d3f8e9c-865a-47d1-ba0c-7eb36c8b9982', 'qr_63.svg', NULL, NULL, NULL),
(64, 'joshua', 'patient', NULL, '2000-01-17', 'andersonandy046', 'andersonandy046@gmail.com', '09454454744', '$2y$12$DXbpAjrqsWVrQrufcrlIsu.PwUMKxfujQ/9P55C4zlsPNUHCTbLXW', NULL, '2026-01-18 02:28:34', '2026-02-25 13:39:56', NULL, NULL, NULL, 0, NULL, NULL, 'padilla', NULL, NULL, 'sta.maria', NULL, NULL, 'mexico pampanga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '698e033326f6d.jpg', 'd61b921c-1d03-430e-80b3-57f1edf84558', 'qr_64.svg', NULL, 1, NULL),
(66, 'Anjanete', 'patient', NULL, '2003-08-04', 'ajlopez', 'ajlopez3993@gmail.com', '09550657737', '$2y$12$zBL2evJhPXj7TL96YmuKlekxCYgpEOqWjKl01GV/gHJnj2HseB74G', NULL, '2026-01-21 07:30:33', '2026-01-21 07:31:17', NULL, NULL, NULL, 0, NULL, 'Cruz', 'Lopez', NULL, NULL, 'Baliwag, Bulacan', NULL, NULL, '1273 Mulawin, Matanda, Tarcan, Baliwag, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'becd668b-4860-4c82-9580-dbe4fca0df23', 'qr_66.svg', NULL, 1, NULL),
(67, 'Daniel Jeremy', 'patient', NULL, '2004-09-14', 'Daniel', 'jeremy20gonzales@gmail.com', '09951710263', '$2y$12$DWWyhJhInlb2aPmLCYWxZupIhL53/f.lnRm2WhP6Piv7vw8r20kNm', NULL, '2026-01-21 07:46:06', '2026-01-21 07:46:06', NULL, NULL, NULL, 0, NULL, 'Dela Cruz', 'Gonzales', NULL, NULL, 'Manila', NULL, NULL, 'lambakin bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ad0115c-f274-41f9-a1cc-85b2f25ff1af', 'qr_67.svg', NULL, NULL, NULL),
(68, 'Alex', 'patient', NULL, '2002-01-28', 'DhanLeo73', 'dhanleonardo73@gmail.com', '09876543212', '$2y$12$yHqUJRyyeDSB4jNCetypNuvRpX7D.vMWoJ7JAmi0mlQFvfbklYDXa', NULL, '2026-01-28 00:39:56', '2026-01-28 00:39:56', NULL, NULL, NULL, 0, NULL, NULL, 'Dalton', NULL, NULL, 'Marilao', NULL, NULL, 'Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '426b1eaf-dd17-42ef-86fe-f2c3fca77ceb', 'qr_68.svg', NULL, NULL, NULL),
(69, 'Jenny', 'patient', NULL, '1976-08-19', 'jenny', 'geronimojenny1976@gmail.com', '09612709883', '$2y$12$LyssluVTfKHzqpRhksTPT.NHybjtXUUe61.rHUskgV6LU3bc.lDgq', NULL, '2026-01-30 08:21:34', '2026-01-30 08:21:34', NULL, NULL, NULL, 0, NULL, NULL, 'Geronimo', NULL, NULL, 'Caloocan', NULL, NULL, 'Tayuman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2d73d997-9dd9-41dc-9302-520dbe9d2602', 'qr_69.svg', NULL, NULL, NULL),
(70, 'Charlotte', 'patient', NULL, '1990-02-14', 'Boxie', 'boxerrobotlover@gmail.com', '09876543211', '$2y$12$1Xa7jdYaYzz982Ton/4umOOv3b9nK/k51.AHlicu/iMDnu136ipHO', NULL, '2026-02-13 09:32:22', '2026-02-13 09:32:22', NULL, NULL, NULL, 0, NULL, NULL, 'Thompson', NULL, NULL, 'Cavite', NULL, NULL, 'Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '35ea140e-f3b8-4f32-8299-bdaf8aaa71c1', 'qr_70.svg', NULL, NULL, NULL),
(72, 'Dhan', 'patient', NULL, '2001-10-03', 'liam123', 'l38674900@gmail.com', '09949499451', '$2y$12$p.qthp5hzAvh3DE3U9hfh.kyplWkemUOzfVzCpypq6Aro1lsduc7q', NULL, '2026-02-24 18:08:01', '2026-02-24 18:23:43', NULL, NULL, NULL, 0, NULL, NULL, 'Alfonso', NULL, NULL, 'Bulacan', NULL, NULL, 'Sta Rosa II', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b71b3574-3622-4feb-ba8a-73a8cc7f2ceb', 'qr_72.svg', NULL, 1, NULL),
(76, 'test', 'patient', NULL, '2026-02-14', 'lazyprince482', 'lazyprince482@gmail.com', '09454454744', '$2y$12$aA8IxrJJ79NsJl1Pf/WBQuS4ytk1Zsf.J9/gLvnOd5SO/aK5Tlm1C', NULL, '2026-02-25 14:43:15', '2026-02-25 14:43:57', NULL, '[-0.13238532841205597,0.11691826581954956,0.0864550769329071,0.021952295675873756,-0.07820651680231094,-0.03572319820523262,-0.12083764374256134,-0.14847223460674286,0.10305069386959076,-0.09063200652599335,0.2063910961151123,-0.05143085867166519,-0.21051925420761108,-0.059629179537296295,-0.03220410645008087,0.16898378729820251,-0.15215067565441132,-0.13315409421920776,-0.05948998034000397,-0.008324520662426949,0.08886932581663132,0.03832026943564415,0.039092663675546646,0.02370559796690941,-0.12416058778762817,-0.34827500581741333,-0.12635233998298645,-0.04231652244925499,0.03429970517754555,0.019130602478981018,-0.0982380136847496,0.033469609916210175,-0.20406574010849,-0.11262965202331543,0.031047893688082695,0.0839465782046318,0.020113354548811913,0.005711122415959835,0.12192016839981079,-0.05486808344721794,-0.22429107129573822,0.04920090362429619,0.07256776094436646,0.20919416844844818,0.12226390093564987,0.14656765758991241,0.023264562711119652,-0.11544695496559143,0.0432417131960392,-0.16622935235500336,0.08262963593006134,0.17505115270614624,0.09664718061685562,0.07999717444181442,0.04158395156264305,-0.12687309086322784,0.028079509735107422,0.1208450049161911,-0.11971622705459595,0.03768504783511162,0.09327913820743561,-0.02328968234360218,0.08779978007078171,-0.08571949601173401,0.20718824863433838,0.06744384765625,-0.08612557500600815,-0.14563266932964325,0.06868037581443787,-0.13320372998714447,-0.09014062583446503,0.0424075610935688,-0.12812446057796478,-0.17483489215373993,-0.3960200846195221,0.017509043216705322,0.36532995104789734,0.13103365898132324,-0.173489049077034,0.04028262197971344,-0.003056420711800456,-0.03850168734788895,0.1090753823518753,0.09334586560726166,-0.05807971581816673,0.03470310941338539,-0.0992746576666832,-0.006408534944057465,0.23169419169425964,-0.02023063413798809,0.0006818554829806089,0.23469063639640808,0.007392674218863249,0.07386501133441925,0.013913334347307682,0.10037728399038315,-0.09694375097751617,-0.002043401589617133,-0.12268372625112534,0.020825525745749474,0.00999403465539217,0.03277523070573807,0.00371292931959033,0.13610079884529114,-0.11416684091091156,0.09461022168397903,-0.04626483470201492,0.03491310402750969,-0.03476797044277191,0.05078885331749916,-0.10976628214120865,-0.10339323431253433,0.10851609706878662,-0.1702440232038498,0.15474173426628113,0.18796256184577942,0.008555189706385136,0.0949581116437912,0.1262614130973816,0.09026277810335159,-0.033126454800367355,0.01304122619330883,-0.18581441044807434,-0.07362331449985504,0.14248165488243103,-0.08988185971975327,0.08293364197015762,0.06433100998401642]', NULL, 0, NULL, 'san', 'padilla', NULL, NULL, 'sta.maria', NULL, NULL, 'marilao bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21546e29-cc1e-415d-9882-c3505b816fd0', 'qr_76.svg', NULL, 1, NULL),
(77, 'Seohan', 'patient', NULL, '2000-09-30', 'kim123', 'kimseohan013@gmail.com', '09183239884', '$2y$12$l.UD6BBKdXuSG6lE8YBaveujm.HqiVmqt9kMmiyHlj081fJUDOCUK', NULL, '2026-02-25 15:22:56', '2026-02-25 15:23:29', NULL, '[-0.07100650668144226,0.07153338193893433,0.033171601593494415,-0.024690451100468636,-0.1252131164073944,-0.07490358501672745,-0.03197821229696274,-0.13672320544719696,0.17065225541591644,-0.06501228362321854,0.19483327865600586,-0.09256342798471451,-0.21332481503486633,-0.08741003274917603,-0.05818620324134827,0.23292358219623566,-0.19631029665470123,-0.1922033429145813,0.0026180557906627655,0.020283769816160202,0.06958729773759842,-0.04032158851623535,-0.024243762716650963,0.11378885060548782,-0.04974061995744705,-0.3319125771522522,-0.11600003391504288,-0.0926891565322876,0.07012494653463364,-0.08013535290956497,-0.07455360144376755,0.08347088098526001,-0.19177119433879852,-0.08568812161684036,0.04266621172428131,0.08156272023916245,-0.0162981990724802,-0.07596900314092636,0.19939491152763367,0.014224228449165821,-0.29726317524909973,0.0014440561644732952,0.07979068160057068,0.24356763064861298,0.15262722969055176,0.08300656825304031,0.005976604297757149,-0.11628040671348572,0.04960934817790985,-0.1671144962310791,0.03865843266248703,0.1453607678413391,0.1555839627981186,0.05163775011897087,-0.04143475741147995,-0.21202753484249115,0.0158114954829216,0.07523921877145767,-0.20959891378879547,0.030430348590016365,0.09594157338142395,-0.10941096395254135,-0.013653557747602463,-0.07105898857116699,0.31337106227874756,0.10581520944833755,-0.12843230366706848,-0.1617903858423233,0.15259361267089844,-0.184575155377388,-0.08135122060775757,0.08777370303869247,-0.11614377051591873,-0.15314507484436035,-0.32269996404647827,-0.01702425256371498,0.4571656286716461,0.0909985676407814,-0.2127622663974762,0.03457069396972656,-0.05919608473777771,-0.01265709102153778,0.11362291127443314,0.2053070217370987,-0.032036423683166504,0.04857815057039261,-0.09503699839115143,-0.07316663861274719,0.19237373769283295,-0.045063287019729614,-0.017689833417534828,0.18900468945503235,-0.0015110168606042862,0.10532663017511368,-0.005736369173973799,-0.005385649390518665,-0.030025627464056015,0.012013327330350876,-0.10733923316001892,-0.06315835565328598,-0.03959714621305466,0.008946605026721954,0.00016433512791991234,0.12049012631177902,-0.1386316418647766,0.07618914544582367,0.043761786073446274,0.005882386118173599,-0.013069761916995049,0.05008585751056671,-0.08423712104558945,-0.12075098603963852,0.12966081500053406,-0.2691861689090729,0.19807620346546173,0.1793501377105713,0.05265247821807861,0.09580504894256592,0.09670940786600113,0.11836695671081543,-0.005799267441034317,-0.08112890273332596,-0.19068177044391632,0.025167444720864296,0.1374688595533371,-0.10178080201148987,0.1147676333785057,0.01044827327132225]', NULL, 0, NULL, 'Marquez', 'Kim', NULL, NULL, 'Malolos', NULL, NULL, 'Marilao', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2c299b62-716f-4a69-a73b-46c2a31e2985', 'qr_77.svg', NULL, 1, NULL),
(78, 'Jayvee', 'patient', NULL, '2016-06-03', 'Jayvee', 'zaratejv03@gmail.com', '09612709883', '$2y$12$eIGLhdAn.wCoWQP8Bf/Gj.C9MbWKCN/A3scxsjyn5V7JfnGjZ1wE2', NULL, '2026-02-26 14:52:15', '2026-02-26 14:52:32', NULL, '[-0.08200017362833023,0.09819446504116058,0.010876532644033432,-0.04783692583441734,-0.10950204730033875,0.0013913554139435291,-0.02034953236579895,-0.06443125754594803,0.17005671560764313,-0.10802431404590607,0.19532112777233124,-0.05168543756008148,-0.22834157943725586,-0.040669891983270645,0.007050513289868832,0.18590737879276276,-0.24664518237113953,-0.05216670036315918,-0.04094848409295082,-0.02204788476228714,0.0812801644206047,0.009973526000976562,-0.005137588828802109,0.042158275842666626,-0.09884846210479736,-0.37378421425819397,-0.10177534818649292,-0.144142284989357,0.08086327463388443,-0.05182682350277901,-0.07881151884794235,0.09219907969236374,-0.13394448161125183,-0.05126621574163437,0.018256627023220062,-0.009140348061919212,-0.04417558014392853,-0.03219817951321602,0.17105230689048767,0.025390267372131348,-0.20197011530399323,-0.019884824752807617,0.01729961857199669,0.2513022720813751,0.11646132916212082,0.04564357176423073,0.06187614053487778,-0.153072789311409,0.1259046345949173,-0.1520020216703415,0.029737398028373718,0.15250134468078613,0.1274157166481018,0.091147281229496,0.00709306076169014,-0.10661649703979492,0.04368562996387482,0.08823446929454803,-0.25038114190101624,0.04274740815162659,0.10460516810417175,-0.07016488909721375,-0.0189385823905468,-0.05711555853486061,0.2638230621814728,0.10731517523527145,-0.10576454550027847,-0.15778085589408875,0.13318969309329987,-0.13313370943069458,-0.05057443678379059,0.02989945188164711,-0.1344880759716034,-0.19846190512180328,-0.2511778473854065,0.015828831121325493,0.3342306315898895,0.1376202255487442,-0.1758037656545639,0.0056385984644293785,-0.10073092579841614,-0.10842819511890411,0.1392398476600647,0.17566043138504028,-0.06754393875598907,0.004845300689339638,-0.023220457136631012,0.03333517536520958,0.196943461894989,-0.12245965003967285,0.04117770865559578,0.22460097074508667,0.03454374894499779,0.015836510807275772,-0.022216135635972023,-0.003364676609635353,-0.14599379897117615,0.01091962493956089,-0.10510574281215668,-0.05867515876889229,0.006275784224271774,-0.05050405487418175,0.0038104890845716,0.10760348290205002,-0.17488114535808563,0.1587933748960495,0.003747600829228759,-0.04628845304250717,-0.0019401791505515575,-0.05872248113155365,-0.08173031359910965,-0.10474374890327454,0.13139230012893677,-0.17312127351760864,0.16590413451194763,0.15483710169792175,0.0655808299779892,0.13517819344997406,0.04218226298689842,0.08882588893175125,-0.03349588066339493,-0.060679905116558075,-0.19039344787597656,0.022872302681207657,0.19278191030025482,-0.03279343247413635,0.02011908032000065,-0.07343435287475586]', NULL, 0, NULL, NULL, 'Zarate', NULL, NULL, 'Bulacan', NULL, NULL, 'Ph3 blk4 lot 7 Estrella Homes Sta Rosa 2 Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '81258e83-c9d6-4968-85cb-0cce10f57129', 'qr_78.svg', NULL, 1, NULL),
(79, 'Julius Dave', 'patient', NULL, '2001-07-26', 'Dave', 'juantamad367@gmail.com', '09937130723', '$2y$12$NFRehbSNLkYp/HEXwmhTkuxtB34oSQYUBdwiKtwTgRxGgjbHySTfa', NULL, '2026-03-01 21:09:41', '2026-03-01 21:10:05', NULL, '[-0.21103374660015106,0.11598823219537735,0.05016479641199112,-0.016591234132647514,-0.004365017171949148,-0.08429454267024994,0.03580964356660843,-0.07219304889440536,0.12858542799949646,-0.055585265159606934,0.2671408951282501,-0.060612790286540985,-0.1892995685338974,-0.193069189786911,0.04168107360601425,0.2083282470703125,-0.19075019657611847,-0.1863885223865509,-0.05791056156158447,-0.0706925317645073,0.07881911844015121,-0.06886586546897888,-0.030308319255709648,0.1276303082704544,-0.11583824455738068,-0.3691934645175934,-0.07560190558433533,-0.11772400140762329,0.047294557094573975,-0.08540703356266022,-0.06532011181116104,0.019932223483920097,-0.2612913250923157,-0.0514754094183445,-0.06534819304943085,0.023525146767497063,0.03824303299188614,-0.030630258843302727,0.1861221045255661,-0.006569193210452795,-0.19307354092597961,-0.02123250626027584,0.012267601676285267,0.2924993634223938,0.23736098408699036,-0.06661243736743927,0.03651391342282295,-0.03986109420657158,0.0701223835349083,-0.12713073194026947,-0.015603199601173401,0.1474279761314392,0.13749976456165314,0.06687154620885849,-0.026877587661147118,-0.12811750173568726,-0.0510888434946537,0.08933492004871368,-0.12301887571811676,-0.005603068508207798,-0.012542099691927433,-0.09036406129598618,-0.07172594964504242,-0.07674578577280045,0.2512543797492981,0.032914552837610245,-0.1455279141664505,-0.15531423687934875,0.1461382657289505,-0.09280509501695633,0.012424332089722157,0.05595039576292038,-0.1714271903038025,-0.17846940457820892,-0.3468547761440277,0.12465066462755203,0.3291761875152588,0.05124659463763237,-0.2784082889556885,0.05349155515432358,-0.13310010731220245,0.004859262146055698,0.11058371514081955,0.14483563601970673,-0.019341738894581795,0.04877544939517975,-0.13375504314899445,0.047502435743808746,0.14183597266674042,-0.021898740902543068,-0.006855029612779617,0.18249374628067017,-0.020929550752043724,0.027544545009732246,0.011960525065660477,0.058725371956825256,-0.06122881919145584,0.022672291845083237,-0.11231545358896255,0.011836936697363853,0.010455673560500145,-0.018239421769976616,-0.04021798446774483,0.09231740981340408,-0.1160605177283287,0.07951701432466507,0.07793070375919342,0.05063844472169876,-0.07671558856964111,0.009649970568716526,-0.09220882505178452,-0.10618620365858078,0.045373983681201935,-0.21076220273971558,0.1626448631286621,0.1907663494348526,-0.016097646206617355,0.1353800743818283,0.0701034814119339,0.07730919122695923,-0.05268259719014168,-0.02349289320409298,-0.14842036366462708,0.07159838825464249,0.15021276473999023,-0.007089244667440653,0.05817929655313492,-0.013646508567035198]', NULL, 0, NULL, 'Garcia', 'Bergania', NULL, NULL, 'Marilao,Bulacan', NULL, NULL, 'Prenza 1 Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4c771028-1da5-410e-863e-a587c3d6c3b7', 'qr_79.svg', NULL, 1, NULL),
(80, 'Lenard', 'patient', NULL, '2002-08-04', 'Cruz', 'Cruzcarlojohn24@gmail.com', '09164115414', '$2y$12$IPxRdUI5YJFgiV6NnzRq0uWDt07dXvw9CHiHzRirW837VvVms2Kre', NULL, '2026-03-06 10:26:22', '2026-03-06 10:27:08', NULL, '[-0.1253688484430313,0.058725032955408096,0.032208796590566635,0.007927220314741135,0.061897192150354385,-0.11255914717912674,0.0239923894405365,-0.14119258522987366,0.12581101059913635,-0.04193319007754326,0.3309803605079651,-0.0705656036734581,-0.2064323127269745,-0.17917190492153168,0.033211492002010345,0.1280638426542282,-0.21790814399719238,-0.10219284892082214,-0.07320227473974228,-0.09561935812234879,0.04099394381046295,-0.0960359200835228,0.048016902059316635,0.05612729489803314,-0.15627066791057587,-0.29921939969062805,-0.11050452291965485,-0.17619384825229645,0.10929447412490845,-0.05124044790863991,0.039904989302158356,0.025307316333055496,-0.23826201260089874,-0.09192445874214172,-0.027306407690048218,0.01037495955824852,0.01579022780060768,0.0031710946932435036,0.2735804319381714,-0.05130532756447792,-0.12283442914485931,-0.07396091520786285,-0.03391452133655548,0.24094563722610474,0.12378975003957748,0.012594526633620262,0.014253802597522736,-0.01771654188632965,0.08637791872024536,-0.2487117201089859,0.08309897780418396,0.11514216661453247,0.13651101291179657,0.07622390985488892,-0.013639303855597973,-0.11959490925073624,0.018880270421504974,0.12983664870262146,-0.23276592791080475,0.0644424706697464,0.0509771928191185,-0.1086832731962204,-0.05121450871229172,0.020629215985536575,0.28007492423057556,0.10972823202610016,-0.11805698275566101,-0.0656002014875412,0.23345914483070374,-0.0585535392165184,0.06875314563512802,0.09319600462913513,-0.10536013543605804,-0.19840842485427856,-0.3006332516670227,0.12689176201820374,0.42689836025238037,0.0773809552192688,-0.19218698143959045,-0.0004234965890645981,-0.16657383739948273,-0.009044235572218895,0.09022228419780731,0.0033081055153161287,-0.07371664047241211,0.02116723172366619,-0.10420814156532288,0.05454524978995323,0.13609781861305237,-0.028384078294038773,-0.051112692803144455,0.22202372550964355,-0.03618040680885315,0.06664852797985077,0.0573444664478302,0.009875631891191006,-0.022984370589256287,-0.03984662517905235,-0.11290507018566132,0.0355643630027771,0.07101278007030487,-0.02467365190386772,0.017665445804595947,0.07811763137578964,-0.09054913371801376,0.11564072221517563,0.051560938358306885,-0.025301873683929443,-0.0186817217618227,0.02126067690551281,-0.08585064113140106,-0.10464008152484894,0.12747430801391602,-0.24278788268566132,0.21700015664100647,0.1358678936958313,0.02646208181977272,0.1542760580778122,0.016856206580996513,0.06546754390001297,-0.03605067357420921,-0.05854674428701401,-0.16108299791812897,0.005097275599837303,0.12495561689138412,-0.011359287425875664,0.06549418717622757,0.0015151523984968662]', NULL, 0, NULL, 'Espirito', 'Delacruz', NULL, NULL, 'Marilao Bulcan', NULL, NULL, 'Laot, Prenza 1, Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f2f528a4-362a-4430-89ef-7b0cb5369618', 'qr_80.svg', NULL, 1, NULL),
(81, 'Czarina Jade', 'patient', NULL, '2003-01-16', 'Cjade', 'lenardxdelacruz04@gmail.com', '09876543321', '$2y$12$ng0s8LxOZexNHxJlOgxfJeo3dy/LCGnL7zTn4BV7PMDEXPmmGtBne', NULL, '2026-03-09 10:04:34', '2026-03-09 10:05:45', NULL, '[-0.03441096469759941,-0.0200156569480896,0.03832332789897919,-0.06523982435464859,-0.10298943519592285,-0.09834416955709457,-0.030283061787486076,-0.07856013625860214,0.21413521468639374,-0.10394145548343658,0.22849281132221222,-0.019476857036352158,-0.19093815982341766,-0.11650949716567993,-0.03422447293996811,0.2358793169260025,-0.20212186872959137,-0.167538583278656,-0.09817460179328918,-0.03108525648713112,-0.028995385393500328,-0.04312251880764961,0.023258570581674576,0.04387027025222778,-0.13684453070163727,-0.3448773920536041,-0.09548689424991608,-0.11031154543161392,0.008603794500231743,-0.07879684120416641,-0.008701086975634098,0.12743976712226868,-0.16929619014263153,-0.08563103526830673,0.081721231341362,0.06828874349594116,-0.050243355333805084,-0.07171352207660675,0.20753802359104156,-0.00671906815841794,-0.25323525071144104,-0.1137872263789177,0.020842555910348892,0.1970679759979248,0.23608927428722382,0.06259892880916595,0.05924379825592041,-0.13562053442001343,0.11176259815692902,-0.24843144416809082,0.03409784287214279,0.09705240279436111,0.06956863403320312,0.00034412555396556854,0.0337601937353611,-0.12337437272071838,-0.0002125576138496399,0.1557459831237793,-0.24636735022068024,-0.03638692945241928,0.018540717661380768,-0.11832956969738007,-0.08389215171337128,-0.04978807270526886,0.2553906738758087,0.12989120185375214,-0.1254424899816513,-0.11778874695301056,0.2719407081604004,-0.19757859408855438,-0.021884862333536148,0.020839612931013107,-0.06599932909011841,-0.205474391579628,-0.33088815212249756,-0.07761391997337341,0.44701898097991943,0.06780882924795151,-0.17275625467300415,0.048037849366664886,-0.041746992617845535,-0.03726383298635483,0.07308550924062729,0.12020982056856155,-0.09680327773094177,0.031099896878004074,-0.06137213483452797,-0.039984043687582016,0.2163853645324707,-0.06428726762533188,0.017500465735793114,0.15372765064239502,-0.04593744874000549,-0.003682575188577175,0.07706478983163834,-0.00516513641923666,-0.05091759189963341,0.017496977001428604,-0.15124823153018951,-0.0404905304312706,0.025049299001693726,-0.025084376335144043,0.02618197724223137,0.07903875410556793,-0.10081028938293457,0.0863880142569542,-0.0066633326932787895,-0.05122300982475281,0.002320531290024519,-0.04401509463787079,-0.0984048992395401,-0.16427762806415558,0.17402881383895874,-0.20027732849121094,0.12752880156040192,0.15158677101135254,-0.0006095778662711382,0.18330281972885132,0.07610348612070084,0.12943118810653687,-0.031043268740177155,-0.06528838723897934,-0.16974642872810364,0.010708831250667572,0.09776773303747177,-0.03742050379514694,0.11250582337379456,-0.01923949085175991]', NULL, 0, NULL, 'Mabini', 'Barora', NULL, NULL, 'Malolos Bulacan', NULL, NULL, 'Marilao Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6fda4d1f-3875-49b4-becf-98af407e2988', 'qr_81.svg', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_store_id_foreign` (`store_id`),
  ADD KEY `appointments_user_id_foreign` (`user_id`),
  ADD KEY `appointments_dentist_id_foreign` (`dentist_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `daily_logs`
--
ALTER TABLE `daily_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_logs_user_id_foreign` (`user_id`),
  ADD KEY `daily_logs_appointment_id_foreign` (`appointment_id`),
  ADD KEY `daily_logs_store_id_foreign` (`store_id`);

--
-- Indexes for table `dental_charts`
--
ALTER TABLE `dental_charts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dental_charts_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `dental_teeth`
--
ALTER TABLE `dental_teeth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dental_teeth_patient_id_tooth_unique` (`patient_id`,`tooth`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `medical_forms`
--
ALTER TABLE `medical_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_forms_user_id_foreign` (`user_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_batches_medicine_id_foreign` (`medicine_id`),
  ADD KEY `medicine_batches_store_id_foreign` (`store_id`);

--
-- Indexes for table `medicine_movements`
--
ALTER TABLE `medicine_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_movements_medicine_id_foreign` (`medicine_id`),
  ADD KEY `medicine_movements_store_id_foreign` (`store_id`),
  ADD KEY `medicine_movements_medicine_batch_id_foreign` (`medicine_batch_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_store_id_foreign` (`store_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newusers`
--
ALTER TABLE `newusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newusers_user_unique` (`user`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient_records`
--
ALTER TABLE `patient_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_records_user_id_foreign` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_store_id_foreign` (`store_id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_medicine_id_foreign` (`medicine_id`),
  ADD KEY `sale_items_medicine_batch_id_foreign` (`medicine_batch_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_staff`
--
ALTER TABLE `store_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_staff_store_id_foreign` (`store_id`),
  ADD KEY `store_staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_unique` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `daily_logs`
--
ALTER TABLE `daily_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dental_charts`
--
ALTER TABLE `dental_charts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `dental_teeth`
--
ALTER TABLE `dental_teeth`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_forms`
--
ALTER TABLE `medical_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `medicine_movements`
--
ALTER TABLE `medicine_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `patient_records`
--
ALTER TABLE `patient_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_staff`
--
ALTER TABLE `store_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_dentist_id_foreign` FOREIGN KEY (`dentist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_logs`
--
ALTER TABLE `daily_logs`
  ADD CONSTRAINT `daily_logs_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `daily_logs_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `daily_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dental_charts`
--
ALTER TABLE `dental_charts`
  ADD CONSTRAINT `dental_charts_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dental_teeth`
--
ALTER TABLE `dental_teeth`
  ADD CONSTRAINT `dental_teeth_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_forms`
--
ALTER TABLE `medical_forms`
  ADD CONSTRAINT `medical_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD CONSTRAINT `medicine_batches_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicine_batches_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medicine_movements`
--
ALTER TABLE `medicine_movements`
  ADD CONSTRAINT `medicine_movements_medicine_batch_id_foreign` FOREIGN KEY (`medicine_batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medicine_movements_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicine_movements_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_records`
--
ALTER TABLE `patient_records`
  ADD CONSTRAINT `patient_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_medicine_batch_id_foreign` FOREIGN KEY (`medicine_batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `store_staff`
--
ALTER TABLE `store_staff`
  ADD CONSTRAINT `store_staff_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `store_staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
