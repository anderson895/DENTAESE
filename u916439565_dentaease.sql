-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 26, 2026 at 10:02 AM
-- Server version: 11.8.8-MariaDB-log
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
  `appointment_type` varchar(255) NOT NULL DEFAULT 'scheduled',
  `arrived_at` timestamp NULL DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `work_done` text DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `amount_given` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_image` varchar(255) DEFAULT NULL,
  `service_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`service_ids`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `store_id`, `user_id`, `dentist_id`, `appointment_date`, `appointment_time`, `booking_end_time`, `status`, `appointment_type`, `arrived_at`, `desc`, `created_at`, `updated_at`, `work_done`, `total_price`, `amount_given`, `change_amount`, `payment_type`, `payment_image`, `service_ids`) VALUES
(107, 3, 85, 31, '2026-05-02', '21:15:00', '21:30:00', 'completed', 'scheduled', '2026-05-02 17:54:29', NULL, '2026-05-02 17:53:56', '2026-05-02 17:55:08', 'yeah u good', 600.00, NULL, NULL, 'GCASH', NULL, '[\"1\"]'),
(108, 1, 83, 31, '2026-05-04', '16:00:00', '16:30:00', 'completed', 'scheduled', '2026-05-04 15:02:42', NULL, '2026-05-04 15:01:18', '2026-05-04 15:04:17', 'Okay kana', 600.00, NULL, NULL, 'GCASH', NULL, '[\"2\"]'),
(111, 1, 86, 26, '2026-05-23', '09:00:00', '09:15:00', 'completed', 'scheduled', NULL, NULL, '2026-05-22 21:54:59', '2026-07-28 00:43:40', NULL, 600.00, NULL, NULL, 'GCASH', NULL, '[\"1\",\"4\"]'),
(112, 1, 83, 26, '2026-07-02', '09:00:00', '10:00:00', 'completed', 'scheduled', '2026-07-02 08:36:26', NULL, '2026-07-02 08:23:04', '2026-07-02 08:38:45', NULL, 1000.00, NULL, NULL, 'GCASH', NULL, '[\"3\",\"4\"]'),
(113, 1, 83, 26, '2026-07-03', '09:00:00', '10:00:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-02 17:26:14', '2026-07-06 15:25:38', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\",\"6\"]'),
(114, 2, 83, 30, '2026-07-06', '16:00:00', '16:45:00', 'completed', 'scheduled', NULL, NULL, '2026-07-06 15:26:05', '2026-07-06 15:46:32', 'Don\'t Eat malansa', 5000.00, NULL, NULL, 'GCASH', NULL, '[\"1\",\"2\"]'),
(115, 2, 94, 30, '2026-07-06', '16:45:00', '17:45:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-06 15:42:55', '2026-07-08 23:59:23', NULL, NULL, NULL, NULL, NULL, NULL, '[\"3\",\"4\"]'),
(116, 1, 83, 31, '2026-07-16', '14:00:00', '15:00:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-08 18:15:24', '2026-07-19 10:31:48', NULL, NULL, NULL, NULL, NULL, NULL, '[\"3\",\"4\"]'),
(118, 1, 94, 26, '2026-07-09', '09:00:00', '10:15:00', 'completed', 'scheduled', '2026-07-09 00:21:29', NULL, '2026-07-08 23:59:40', '2026-07-09 16:20:27', 'asdnbm,./', 5000.00, NULL, NULL, 'GCASH', NULL, '[\"1\",\"2\",\"3\"]'),
(119, 1, 86, 26, '2026-07-13', '12:00:00', '13:35:00', 'completed', 'scheduled', NULL, NULL, '2026-07-09 12:27:33', '2026-07-11 11:55:16', NULL, 600.00, NULL, NULL, 'GCASH', NULL, '[\"2\"]'),
(120, 1, 86, 26, '2026-07-11', '11:38:00', '12:08:00', 'no_show', 'scheduled', NULL, NULL, '2026-07-11 11:38:59', '2026-07-11 12:07:50', NULL, NULL, NULL, NULL, NULL, NULL, '[2]'),
(121, 1, 86, 26, '2026-07-11', '11:39:00', '12:09:00', 'no_show', 'scheduled', NULL, NULL, '2026-07-11 11:39:11', '2026-07-19 15:56:50', NULL, NULL, NULL, NULL, NULL, NULL, '[2]'),
(122, 1, 86, 26, '2026-07-11', '11:39:00', '12:09:00', 'completed', 'scheduled', NULL, NULL, '2026-07-11 11:39:19', '2026-07-11 12:10:50', NULL, 500.00, NULL, NULL, 'GCASH', NULL, '[2]'),
(123, 1, 86, 26, '2026-07-11', '11:42:00', '12:12:00', 'no_show', 'scheduled', NULL, NULL, '2026-07-11 11:42:58', '2026-07-11 12:08:26', NULL, NULL, NULL, NULL, NULL, NULL, '[2]'),
(124, 1, 86, 26, '2026-07-11', '12:06:00', '12:21:00', 'no_show', 'scheduled', NULL, NULL, '2026-07-11 12:06:30', '2026-07-11 12:40:11', NULL, NULL, NULL, NULL, NULL, NULL, '[1]'),
(125, 2, 86, 30, '2026-07-19', '10:58:00', '11:13:00', 'completed', 'walkin', NULL, 'Auto-created walk-in from visit log', '2026-07-19 10:58:59', '2026-07-19 11:01:38', NULL, 600.00, NULL, NULL, 'GCASH', NULL, '[1]'),
(126, 1, 83, 26, '2026-07-19', '16:11:00', '16:26:00', 'completed', 'walkin', NULL, 'Auto-created walk-in from visit log', '2026-07-19 16:11:41', '2026-07-19 16:16:45', NULL, 600.00, NULL, NULL, 'CASH', NULL, '[1]'),
(127, 1, 86, 26, '2026-07-22', '13:00:00', '13:10:00', 'no_show', 'scheduled', NULL, NULL, '2026-07-19 18:01:34', '2026-07-19 20:02:38', NULL, NULL, NULL, NULL, NULL, NULL, '[\"11\"]'),
(128, 1, 95, 26, '2026-07-20', '13:00:00', '15:30:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-19 23:52:25', '2026-07-20 16:24:13', NULL, NULL, NULL, NULL, NULL, NULL, '[\"3\",\"7\"]'),
(129, 1, 86, 26, '2026-07-23', '11:00:00', '11:45:00', 'completed', 'scheduled', NULL, NULL, '2026-07-20 03:53:14', '2026-07-27 15:00:02', NULL, 300.00, NULL, NULL, 'GCASH', NULL, '[\"5\"]'),
(130, 1, 83, 26, '2026-07-22', '15:10:00', '15:20:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-22 11:56:50', '2026-07-23 11:10:30', NULL, NULL, NULL, NULL, NULL, NULL, '[\"11\"]'),
(131, 1, 83, 26, '2026-07-27', '16:00:00', '16:10:00', 'completed', 'scheduled', '2026-07-27 15:27:07', NULL, '2026-07-27 14:55:31', '2026-07-27 15:31:39', NULL, 200.00, NULL, NULL, 'CASH', NULL, '[\"11\"]'),
(132, 1, 103, 26, '2026-07-28', '09:00:00', '09:55:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-27 15:53:07', '2026-07-28 22:51:06', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\",\"2\",\"11\"]'),
(133, 1, 104, 26, '2026-07-28', '09:55:00', '10:35:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-27 15:54:45', '2026-07-28 00:58:41', NULL, NULL, NULL, NULL, NULL, NULL, '[\"2\",\"11\"]'),
(134, 2, 83, 30, '2026-07-28', '15:00:00', '15:40:00', 'completed', 'scheduled', NULL, NULL, '2026-07-27 17:40:24', '2026-07-27 18:17:18', NULL, 500.00, NULL, NULL, 'CASH', NULL, '[\"2\",\"11\"]'),
(135, 2, 86, 30, '2026-07-30', '17:00:00', '18:50:00', 'arrived', 'walkin', NULL, NULL, '2026-07-27 18:40:00', '2026-07-27 18:54:58', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\",\"11\"]'),
(136, 2, 95, 30, '2026-07-30', '15:00:00', '17:00:00', 'approved', 'scheduled', NULL, NULL, '2026-07-27 18:46:01', '2026-07-27 18:56:38', NULL, NULL, NULL, NULL, NULL, NULL, '[9]'),
(137, 2, 95, 30, '2026-07-27', '18:58:00', '19:13:00', 'completed', 'walkin', '2026-07-27 18:58:21', 'Auto-created walk-in from visit log', '2026-07-27 18:58:21', '2026-07-27 20:00:32', NULL, 600.00, NULL, NULL, 'GCASH', NULL, '[1]'),
(138, 4, 105, 30, '2026-07-30', '21:00:00', '21:45:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-27 19:13:10', '2026-07-30 23:13:14', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\",\"2\"]'),
(139, 2, 106, 30, '2026-07-28', '16:40:00', '16:50:00', 'cancelled', 'scheduled', NULL, NULL, '2026-07-27 19:20:50', '2026-07-28 22:51:06', NULL, NULL, NULL, NULL, NULL, NULL, '[\"11\"]'),
(140, 2, 86, 30, '2026-07-27', '19:58:00', '20:28:00', 'completed', 'emergency', '2026-07-27 23:47:19', NULL, '2026-07-27 19:58:35', '2026-07-28 00:01:42', NULL, 800.00, NULL, NULL, 'GCASH', NULL, '[4]'),
(141, 1, 84, 26, '2026-07-28', '22:51:00', '00:51:00', 'completed', 'walkin', NULL, NULL, '2026-07-28 22:51:23', '2026-07-30 17:28:55', NULL, 500.00, 1000.00, 500.00, 'GCASH', NULL, '[7]'),
(143, 1, 86, 26, '2026-07-30', '23:16:00', '23:31:00', 'completed', 'emergency', NULL, NULL, '2026-07-30 23:16:42', '2026-07-30 23:17:24', NULL, 500.00, 700.00, 88.00, 'GCASH', NULL, '[1]'),
(144, 1, 90, 26, '2026-08-03', '10:00:00', '10:15:00', 'completed', 'scheduled', NULL, NULL, '2026-07-30 23:21:56', '2026-07-30 23:23:28', NULL, 700.00, 1000.00, 300.00, 'GCASH', NULL, '[1]'),
(145, 3, 84, 26, '2026-08-03', '21:00:00', '21:45:00', 'completed', 'emergency', NULL, NULL, '2026-08-03 00:26:52', '2026-08-03 00:27:33', NULL, 700.00, 1000.00, 300.00, 'GCASH', NULL, '[5]'),
(146, 3, 83, 31, '2026-08-03', '21:00:00', '21:55:00', 'cancelled', 'scheduled', NULL, NULL, '2026-08-03 13:46:43', '2026-08-05 02:04:51', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\",\"2\",\"11\"]'),
(147, 1, 86, 31, '2026-08-06', '15:34:00', '17:04:00', 'arrived', 'emergency', NULL, NULL, '2026-08-06 15:34:58', '2026-08-06 15:34:58', NULL, NULL, NULL, NULL, NULL, NULL, '[8]'),
(148, 1, 82, 26, '2026-08-08', '09:00:00', '10:00:00', 'approved', 'scheduled', NULL, NULL, '2026-08-08 06:05:43', '2026-08-08 06:29:11', NULL, NULL, NULL, NULL, NULL, NULL, '[\"3\",\"4\"]'),
(149, 1, 111, 31, '2026-08-12', '16:20:00', '17:15:00', 'completed', 'scheduled', '2026-08-12 16:15:00', NULL, '2026-08-12 16:02:31', '2026-08-12 16:17:51', 'Bawal chismosa dito', 600.00, 1000.00, 390.00, 'GCASH', NULL, '[\"1\"]'),
(150, 1, 113, 26, '2026-08-13', '10:00:00', '10:15:00', 'completed', 'scheduled', NULL, NULL, '2026-08-13 09:22:30', '2026-08-13 09:34:34', NULL, 600.00, 700.00, 93.00, 'CASH', NULL, '[\"1\"]'),
(151, 1, 112, 26, '2026-08-13', '09:29:00', '09:44:00', 'completed', 'walkin', NULL, 'Auto-created walk-in from visit log', '2026-08-13 09:29:05', '2026-08-13 12:50:10', NULL, 700.00, NULL, NULL, 'GCASH', NULL, '[1]'),
(152, 1, 113, 31, '2026-08-14', '12:00:00', '12:15:00', 'cancelled', 'scheduled', NULL, NULL, '2026-08-13 12:48:37', '2026-08-20 12:27:44', NULL, NULL, NULL, NULL, NULL, NULL, '[\"1\"]'),
(153, 1, 112, 26, '2026-08-28', '13:00:00', '13:30:00', 'completed', 'scheduled', NULL, NULL, '2026-08-13 12:51:15', '2026-08-13 12:55:23', NULL, 800.00, 1000.00, 200.00, 'GCASH', NULL, '[\"3\"]'),
(154, 1, 112, 26, '2026-08-14', '17:00:00', '17:30:00', 'cancelled', 'scheduled', NULL, NULL, '2026-08-13 12:56:46', '2026-08-13 12:57:13', NULL, NULL, NULL, NULL, NULL, NULL, '[\"3\"]'),
(155, 1, 83, 26, '2026-08-26', '16:59:00', '17:29:00', 'completed', 'walkin', NULL, NULL, '2026-08-26 16:59:41', '2026-08-26 17:06:46', 'Bawal magbuhat ng mabibigat at sa pagkaing malansa', 600.00, 1000.00, 103.00, 'GCASH', NULL, '[2]');

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
(14, 83, NULL, 4, '2026-05-01 20:49:55', '2026-05-01 20:49:55', '2026-05-01 20:49:55'),
(16, 85, 107, 3, '2026-05-02 17:54:29', '2026-05-02 17:54:29', '2026-05-02 17:54:29'),
(17, 83, 108, 1, '2026-05-04 15:02:42', '2026-05-04 15:02:42', '2026-05-04 15:02:42'),
(19, 83, 112, 1, '2026-07-02 08:36:26', '2026-07-02 08:36:26', '2026-07-02 08:36:26'),
(23, 94, 118, 1, '2026-07-09 00:21:29', '2026-07-09 00:21:29', '2026-07-09 00:21:29'),
(24, 86, 125, 2, '2026-07-19 10:58:59', '2026-07-19 10:58:59', '2026-07-19 10:58:59'),
(25, 83, 126, 1, '2026-07-19 16:11:41', '2026-07-19 16:11:41', '2026-07-19 16:11:41'),
(26, 83, 131, 1, '2026-07-27 15:27:07', '2026-07-27 15:27:07', '2026-07-27 15:27:07'),
(29, 95, 137, 2, '2026-07-27 18:58:21', '2026-07-27 18:58:21', '2026-07-27 18:58:21'),
(30, 86, 140, 2, '2026-07-27 23:47:19', '2026-07-27 23:47:19', '2026-07-27 23:47:19'),
(31, 111, 149, 1, '2026-08-12 16:15:00', '2026-08-12 16:15:00', '2026-08-12 16:15:00'),
(32, 112, 151, 1, '2026-08-13 09:29:05', '2026-08-13 09:29:05', '2026-08-13 09:29:05');

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
(3, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-02 09:58:05', '2025-09-02 09:58:36'),
(5, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-07 22:44:41', '2025-09-07 22:44:41'),
(14, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '✓', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-19 00:34:52', '2025-10-19 01:09:08'),
(45, 83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-04-10 13:49:49', '2026-07-06 15:44:10'),
(46, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-04-10 14:57:28', '2026-04-10 14:57:28'),
(47, 86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-01 21:03:33', '2026-07-27 14:59:03'),
(49, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-02 15:14:34', '2026-05-02 15:14:34'),
(50, 85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-02 17:54:00', '2026-05-02 17:54:00'),
(51, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-04 15:02:00', '2026-05-04 15:02:00'),
(53, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-22 14:06:59', '2026-05-22 14:06:59'),
(54, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-22 15:53:56', '2026-05-22 15:53:56'),
(55, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-02 08:37:50', '2026-07-02 08:37:50'),
(56, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-02 16:02:06', '2026-07-02 16:02:06'),
(57, 93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-02 16:37:08', '2026-07-02 16:37:08'),
(58, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-02 17:09:24', '2026-07-02 17:09:24'),
(59, 95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-08 17:33:16', '2026-07-08 17:33:16'),
(60, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-09 00:01:07', '2026-07-09 00:01:07'),
(62, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-27 15:54:53', '2026-07-27 15:54:53'),
(63, 105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-27 19:12:07', '2026-07-27 19:12:07'),
(64, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-27 23:44:46', '2026-07-27 23:44:46'),
(65, 97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-30 17:54:04', '2026-07-30 17:54:04'),
(66, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-07-30 23:22:12', '2026-07-30 23:22:12'),
(67, 106, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-08-06 15:33:24', '2026-08-06 15:33:24'),
(68, 110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-08-08 13:18:42', '2026-08-08 13:18:42'),
(69, 111, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-08-12 16:13:25', '2026-08-12 16:13:25'),
(70, 113, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-08-13 09:25:41', '2026-08-13 09:25:41'),
(71, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-08-13 09:26:25', '2026-08-13 09:26:25');

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
(72, 83, '53', '{\"center\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"}}', '2026-04-10 18:12:31', '2026-04-10 18:12:31'),
(73, 82, '51', '{\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-04-30 19:40:09', '2026-04-30 19:40:11'),
(74, 83, '51', '{\"right\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"},\"left\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-05-01 18:56:38', '2026-05-01 18:56:39'),
(75, 83, '54', '{\"top\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"right\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"center\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"left\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-05-01 20:50:59', '2026-05-01 20:51:05'),
(77, 85, '37', '{\"left\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"top\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"right\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"},\"center\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-05-02 17:54:39', '2026-05-02 17:54:47'),
(78, 85, '42', '{\"center\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-05-02 17:54:48', '2026-05-02 17:54:50'),
(79, 85, '44', '{\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"left\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"right\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"}}', '2026-05-02 17:54:51', '2026-05-02 17:54:55'),
(80, 83, '73', '{\"right\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"},\"left\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"},\"top\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"In\",\"color\":\"#06b6d4\"}}', '2026-05-04 15:03:04', '2026-05-04 15:03:09'),
(82, 86, '54', '{\"center\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"},\"top\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"}}', '2026-05-22 21:57:08', '2026-07-09 18:07:49'),
(83, 86, '52', '{\"center\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"},\"left\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"}}', '2026-05-22 21:57:12', '2026-05-22 21:57:16'),
(84, 86, '61', '{\"center\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"},\"top\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"}}', '2026-05-22 21:57:20', '2026-05-22 21:57:27'),
(85, 86, '62', '{\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"}}', '2026-05-22 21:57:37', '2026-05-22 21:57:42'),
(86, 83, '11', '{\"center\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"right\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"},\"left\":{\"group\":\"restoration\",\"code\":\"JC\",\"color\":\"#facc15\"}}', '2026-07-02 08:38:18', '2026-07-02 08:38:21'),
(87, 83, '32', '{\"right\":{\"group\":\"condition\",\"code\":\"Sp\",\"color\":\"#8b5cf6\"},\"left\":{\"group\":\"condition\",\"code\":\"Sp\",\"color\":\"#8b5cf6\"}}', '2026-07-06 15:44:07', '2026-07-06 15:44:08'),
(88, 86, '53', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"},\"top\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"left\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"},\"right\":{\"group\":\"restoration\",\"code\":\"Rm\",\"color\":\"#f472b6\"}}', '2026-07-08 23:51:45', '2026-07-08 23:51:50'),
(89, 94, '74', '{\"center\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"},\"left\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"},\"right\":{\"group\":\"condition\",\"code\":\"Un\",\"color\":\"#cbd5e1\"}}', '2026-07-09 16:25:55', '2026-07-09 16:26:00'),
(90, 94, '73', '{\"center\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"}}', '2026-07-09 16:26:03', '2026-07-09 16:26:03'),
(91, 94, '32', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"left\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"top\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-07-09 16:26:10', '2026-07-09 16:26:13'),
(92, 86, '72', '{\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"}}', '2026-07-27 14:59:01', '2026-07-27 14:59:01'),
(93, 83, '24', '{\"center\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"},\"top\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-07-27 15:28:20', '2026-07-27 15:28:24'),
(94, 86, '21', '{\"center\":{\"group\":\"restoration\",\"code\":\"Co\",\"color\":\"#3b82f6\"}}', '2026-07-27 19:59:00', '2026-07-27 19:59:00'),
(95, 86, '22', '{\"top\":{\"group\":\"condition\",\"code\":\"D\",\"color\":\"#ef4444\"},\"center\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-07-27 19:59:06', '2026-07-27 19:59:08'),
(96, 111, '52', '{\"right\":{\"group\":\"surgery\",\"code\":\"XO\",\"color\":\"#991b1b\"}}', '2026-08-12 16:15:46', '2026-08-12 16:15:46'),
(97, 113, '52', '{\"center\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"},\"bottom\":{\"group\":\"surgery\",\"code\":\"X\",\"color\":\"#dc2626\"}}', '2026-08-13 09:31:16', '2026-08-13 09:31:19'),
(98, 83, '85', '{\"center\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"top\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"},\"bottom\":{\"group\":\"restoration\",\"code\":\"Am\",\"color\":\"#737373\"}}', '2026-08-26 17:00:07', '2026-08-26 17:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedules`
--

CREATE TABLE `doctor_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dentist_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `schedule_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('available','off') NOT NULL DEFAULT 'available',
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_schedules`
--

INSERT INTO `doctor_schedules` (`id`, `dentist_id`, `store_id`, `schedule_date`, `start_time`, `end_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 30, 3, '2026-05-15', NULL, NULL, 'off', 'Urgent Meeting with supplier', '2026-05-01 20:24:52', '2026-05-01 20:24:52'),
(2, 30, 4, '2026-05-12', NULL, NULL, 'off', NULL, '2026-05-01 20:54:26', '2026-05-01 20:54:26'),
(4, 31, 4, '2026-05-15', NULL, NULL, 'available', NULL, '2026-05-01 20:54:57', '2026-05-01 20:54:57'),
(5, 26, 1, '2026-05-22', NULL, NULL, 'off', 'Rest Day', '2026-05-22 14:07:46', '2026-05-22 14:07:46'),
(6, 31, 2, '2026-07-02', NULL, NULL, 'available', NULL, '2026-07-19 23:31:21', '2026-07-19 23:31:21'),
(7, 26, 2, '2026-07-15', NULL, NULL, 'off', NULL, '2026-07-22 13:50:42', '2026-07-22 13:50:42'),
(9, 31, 1, '2026-07-30', '21:00:00', '22:00:00', 'available', NULL, '2026-07-27 19:56:28', '2026-07-27 19:56:28'),
(10, 30, 1, '2026-07-07', NULL, NULL, 'off', 'May sakit', '2026-07-29 02:59:31', '2026-07-29 02:59:31'),
(11, 26, 1, '2026-08-05', NULL, NULL, 'off', NULL, '2026-08-13 09:38:12', '2026-08-13 09:38:12');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `unit`, `price`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mefenamic Acid', 'mg capsule', 12.00, '500 mg capsule', '2025-08-28 04:56:00', '2026-08-26 16:43:00', NULL),
(2, 'Amoxicillin', 'mg capsule', 9.00, '500 mg capsule', '2025-08-28 05:35:43', '2026-08-26 16:42:00', NULL),
(3, 'Mefenamic', 'mL', 5.00, 'Gamot sa sakit', '2025-09-17 02:40:08', '2025-09-17 02:40:08', NULL),
(4, 'Anesthesia', 'bottle', 1000.00, 'Anti sakit', '2025-09-17 02:41:37', '2026-07-30 17:57:08', NULL),
(5, 'Antidote', 'mL', 10.00, 'Eme', '2025-10-07 23:22:00', '2026-08-06 15:36:25', '2026-08-06 15:36:25'),
(6, 'Yakapsul', 'G', 20.00, 'Hahaaha', '2026-01-13 02:26:50', '2026-07-30 17:55:52', '2026-07-30 17:55:52'),
(7, 'Pain Relievers', 'G', 15.00, 'To ease the pain', '2026-01-20 16:19:24', '2026-07-30 17:56:23', '2026-07-30 17:56:23'),
(8, 'Azithromycin', 'box', 120.00, 'Pangontra', '2026-02-02 06:47:18', '2026-07-23 21:57:54', NULL),
(11, 'Clindamycin', 'mg tablet', 4.00, NULL, '2026-05-01 20:50:22', '2026-08-26 16:54:18', NULL),
(12, 'expirasetamol', 'bottle', 200.00, NULL, '2026-05-02 02:43:16', '2026-08-26 17:36:12', '2026-08-26 17:36:12'),
(13, 'Paracetamol', 'mg tablet', 5.00, '500 mg tablet', '2026-07-20 02:51:36', '2026-08-26 16:54:18', NULL),
(14, 'Amoxcillin', 'mg tablet', 6.00, '500mg', '2026-07-27 18:22:39', '2026-08-26 16:54:18', NULL),
(15, 'Mefenamic', 'pcs', 5.00, '250mg', '2026-07-27 18:24:50', '2026-08-26 16:40:06', '2026-08-26 16:40:06'),
(16, 'Antidote', 'mg capsule', 10.00, '5mg', '2026-07-27 18:29:18', '2026-08-26 16:50:38', '2026-08-26 16:50:38'),
(19, 'Pain Relieve', 'mg tablet', 100.00, NULL, '2026-07-28 00:18:33', '2026-08-26 17:36:42', NULL);

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
(1, 1, 2, 1, '2025-11-08', '2025-08-28 04:56:38', '2026-05-02 15:46:27', 'expired'),
(2, 2, 2, 1, '2026-03-15', '2025-08-28 05:36:13', '2026-05-02 18:31:13', 'expired'),
(3, 1, 1, 0, '2025-09-05', '2025-09-07 22:09:15', '2026-03-09 10:48:09', 'suspended'),
(4, 4, 1, 5, '2025-09-18', '2025-09-17 02:52:50', '2026-01-20 16:15:29', 'expired'),
(5, 5, 1, 0, '2026-01-01', '2025-10-07 23:24:15', '2026-01-11 23:37:47', 'suspended'),
(6, 6, 1, 20, '2026-01-13', '2026-01-13 02:28:32', '2026-01-13 02:28:54', 'expired'),
(7, 1, 1, 0, '2026-02-02', '2026-02-02 06:45:00', '2026-07-09 14:09:19', 'suspended'),
(8, 1, 1, 0, '2027-02-28', '2026-02-02 06:45:30', '2026-07-30 23:14:19', 'suspended'),
(9, 2, 1, 0, '2029-02-14', '2026-02-02 06:46:24', '2026-08-13 09:33:18', 'suspended'),
(10, 3, 1, 49, '2026-02-26', '2026-02-25 15:00:35', '2026-05-22 15:00:08', 'expired'),
(11, 4, 1, 100, '2026-02-25', '2026-02-25 15:01:07', '2026-02-25 15:01:18', 'suspended'),
(12, 4, 1, 70, '2026-02-25', '2026-02-25 15:01:34', '2026-02-25 15:03:09', 'expired'),
(13, 5, 1, 58, '2026-02-26', '2026-02-25 15:01:55', '2026-05-22 15:00:20', 'expired'),
(14, 4, 1, 30, '2026-02-25', '2026-02-25 15:03:19', '2026-05-22 14:59:55', 'expired'),
(15, 1, 4, 14, '2026-02-25', '2026-02-25 15:05:35', '2026-05-22 15:02:00', 'expired'),
(16, 1, 4, 20, '2026-02-28', '2026-02-25 15:05:52', '2026-05-22 15:02:06', 'expired'),
(17, 11, 2, 0, '2028-05-31', '2026-05-01 20:50:22', '2026-08-26 17:37:06', 'suspended'),
(18, 12, 1, 10, '2026-04-30', '2026-05-02 02:43:16', '2026-05-22 15:00:46', 'expired'),
(19, 1, 2, 8, '2026-03-06', '2026-05-02 15:46:19', '2026-07-27 23:58:00', 'expired'),
(20, 1, 2, 0, '2027-08-20', '2026-05-02 17:44:47', '2026-08-26 17:26:38', 'active'),
(21, 2, 2, 0, '2027-12-20', '2026-05-02 18:31:26', '2026-08-26 17:29:31', 'active'),
(22, 3, 3, 0, '2027-03-13', '2026-05-02 18:32:05', '2026-08-26 16:37:54', 'active'),
(23, 4, 3, 0, '2027-11-11', '2026-05-02 18:32:31', '2026-08-26 16:38:07', 'active'),
(24, 2, 3, 0, '2027-12-12', '2026-05-02 18:32:48', '2026-08-26 16:45:20', 'suspended'),
(25, 2, 4, 0, '2027-09-09', '2026-05-02 18:33:09', '2026-08-26 16:44:25', 'suspended'),
(27, 8, 3, 10, '2026-05-10', '2026-05-04 14:58:37', '2026-05-22 15:01:30', 'expired'),
(28, 1, 1, 0, '2027-06-22', '2026-05-22 15:15:15', '2026-08-12 16:16:57', 'suspended'),
(29, 8, 2, 0, '2027-12-23', '2026-07-06 15:49:50', '2026-08-26 16:35:46', 'active'),
(30, 2, 1, 0, '2026-10-28', '2026-07-08 21:52:08', '2026-07-30 23:14:19', 'suspended'),
(31, 13, 1, 0, '2026-12-28', '2026-07-20 02:51:36', '2026-08-26 16:53:02', 'suspended'),
(32, 1, 3, 50, '2027-07-27', '2026-07-27 15:15:54', '2026-08-26 16:45:03', 'active'),
(33, 14, 2, 0, '2027-06-15', '2026-07-27 18:22:39', '2026-08-26 16:36:27', 'active'),
(34, 15, 2, 0, '2027-04-13', '2026-07-27 18:24:50', '2026-08-26 16:36:03', 'active'),
(35, 15, 2, 0, '2027-09-14', '2026-07-27 18:25:49', '2026-08-26 16:36:11', 'active'),
(36, 16, 2, 123, '2026-07-27', '2026-07-27 18:29:18', '2026-08-26 16:36:53', 'expired'),
(38, 19, 1, 0, '2026-09-29', '2026-07-28 00:19:26', '2026-08-26 16:34:43', 'active'),
(39, 1, 4, 45, '2027-10-28', '2026-08-26 16:43:47', '2026-08-26 18:00:37', 'active'),
(40, 2, 4, 48, '2027-10-28', '2026-08-26 16:44:18', '2026-08-26 18:00:37', 'active'),
(41, 2, 3, 50, '2027-10-28', '2026-08-26 16:45:34', '2026-08-26 16:45:34', 'active'),
(42, 2, 2, 50, '2027-10-28', '2026-08-26 16:46:11', '2026-08-26 16:46:11', 'active'),
(43, 1, 2, 50, '2027-10-28', '2026-08-26 16:46:33', '2026-08-26 16:46:33', 'active'),
(44, 1, 1, 41, '2027-10-28', '2026-08-26 16:47:45', '2026-08-26 17:06:01', 'active'),
(45, 2, 1, 29, '2027-10-28', '2026-08-26 16:48:16', '2026-08-26 17:06:01', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_movements`
--

CREATE TABLE `medicine_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('stock_in','stock_out','suspended','expired','reactivated') NOT NULL,
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
(42, 2, 2, 2, 'stock_out', -2, 'Sale #14', '2026-04-01 00:26:58', '2026-04-01 00:26:58'),
(43, 3, 1, 10, 'stock_out', -1, 'Sale #15', '2026-05-01 20:41:46', '2026-05-01 20:41:46'),
(44, 2, 1, 9, 'stock_out', -2, 'Sale #15', '2026-05-01 20:41:46', '2026-05-01 20:41:46'),
(45, 1, 1, 7, 'stock_out', -3, 'Sale #15', '2026-05-01 20:41:46', '2026-05-01 20:41:46'),
(46, 2, 2, 2, 'stock_out', -2, 'Sale #16', '2026-05-01 20:48:15', '2026-05-01 20:48:15'),
(47, 1, 4, 15, 'stock_out', -6, 'Sale #17', '2026-05-01 20:55:02', '2026-05-01 20:55:02'),
(48, 5, 1, 13, 'stock_out', -2, 'Sale #18', '2026-05-01 21:06:45', '2026-05-01 21:06:45'),
(49, 2, 1, 9, 'stock_out', -2, 'Sale #19', '2026-05-01 21:19:19', '2026-05-01 21:19:19'),
(50, 1, 1, 7, 'stock_out', -14, 'Sale #20', '2026-05-01 21:58:42', '2026-05-01 21:58:42'),
(51, 1, 1, 8, 'stock_out', -14, 'Sale #21', '2026-05-01 22:01:18', '2026-05-01 22:01:18'),
(52, 2, 1, 9, 'stock_out', -14, 'Sale #22', '2026-05-01 22:04:10', '2026-05-01 22:04:10'),
(53, 2, 2, 2, 'stock_out', -3, 'Sale #23', '2026-05-02 15:20:59', '2026-05-02 15:20:59'),
(54, 1, 2, 19, 'stock_in', 20, 'New Batch', '2026-05-02 15:46:19', '2026-05-02 15:46:19'),
(55, 1, 2, 1, 'expired', 1, 'Manual Expired', '2026-05-02 15:46:27', '2026-05-02 15:46:27'),
(56, 1, 2, 19, 'expired', 20, 'Manual Expired', '2026-05-02 15:46:32', '2026-05-02 15:46:32'),
(57, 1, 2, 20, 'stock_in', 50, 'New Batch', '2026-05-02 17:44:47', '2026-05-02 17:44:47'),
(58, 2, 2, 2, 'expired', 1, 'Manual Expired', '2026-05-02 18:31:13', '2026-05-02 18:31:13'),
(59, 2, 2, 21, 'stock_in', 50, 'New Batch', '2026-05-02 18:31:26', '2026-05-02 18:31:26'),
(60, 3, 3, 22, 'stock_in', 50, 'New Batch', '2026-05-02 18:32:05', '2026-05-02 18:32:05'),
(61, 4, 3, 23, 'stock_in', 30, 'New Batch', '2026-05-02 18:32:31', '2026-05-02 18:32:31'),
(62, 2, 3, 24, 'stock_in', 40, 'New Batch', '2026-05-02 18:32:48', '2026-05-02 18:32:48'),
(63, 2, 4, 25, 'stock_in', 35, 'New Batch', '2026-05-02 18:33:09', '2026-05-02 18:33:09'),
(65, 8, 3, 27, 'stock_in', 10, 'New Batch', '2026-05-04 14:58:37', '2026-05-04 14:58:37'),
(66, 2, 1, 9, 'stock_out', -3, 'Sale #24', '2026-05-04 15:04:09', '2026-05-04 15:04:09'),
(67, 1, 4, 15, 'stock_out', -10, 'Sale #25', '2026-05-04 20:05:39', '2026-05-04 20:05:39'),
(68, 4, 1, 14, 'expired', 30, 'Manual Expired', '2026-05-22 14:59:55', '2026-05-22 14:59:55'),
(69, 3, 1, 10, 'expired', 49, 'Manual Expired', '2026-05-22 15:00:08', '2026-05-22 15:00:08'),
(70, 5, 1, 13, 'expired', 58, 'Manual Expired', '2026-05-22 15:00:20', '2026-05-22 15:00:20'),
(71, 12, 1, 18, 'expired', 10, 'Manual Expired', '2026-05-22 15:00:46', '2026-05-22 15:00:46'),
(72, 8, 3, 27, 'expired', 10, 'Manual Expired', '2026-05-22 15:01:30', '2026-05-22 15:01:30'),
(73, 1, 4, 15, 'expired', 14, 'Manual Expired', '2026-05-22 15:02:00', '2026-05-22 15:02:00'),
(74, 1, 4, 16, 'expired', 20, 'Manual Expired', '2026-05-22 15:02:06', '2026-05-22 15:02:06'),
(76, 1, 1, 28, 'stock_in', 20, 'New Batch', '2026-05-22 15:15:15', '2026-05-22 15:15:15'),
(77, 1, 1, 8, 'suspended', 26, 'Manual Suspended', '2026-05-22 15:15:25', '2026-05-22 15:15:25'),
(78, 1, 1, 8, 'stock_out', -9, 'Sale #26', '2026-07-02 08:42:27', '2026-07-02 08:42:27'),
(79, 8, 2, 29, 'stock_in', 10, 'New Batch', '2026-07-06 15:49:50', '2026-07-06 15:49:50'),
(80, 2, 2, 21, 'stock_out', -2, 'Sale #27', '2026-07-06 15:52:18', '2026-07-06 15:52:18'),
(81, 8, 2, 29, 'stock_out', -3, 'Sale #27', '2026-07-06 15:52:18', '2026-07-06 15:52:18'),
(82, 3, 3, 22, 'stock_out', -6, 'Sale #28', '2026-07-08 21:24:57', '2026-07-08 21:24:57'),
(83, 2, 3, 24, 'stock_out', -9, 'Sale #28', '2026-07-08 21:24:57', '2026-07-08 21:24:57'),
(84, 2, 1, 30, 'stock_in', 30, 'New Batch', '2026-07-08 21:52:08', '2026-07-08 21:52:08'),
(85, 3, 3, 22, 'stock_out', -2, 'Sale #29', '2026-07-08 22:32:02', '2026-07-08 22:32:02'),
(86, 2, 3, 24, 'stock_out', -2, 'Sale #29', '2026-07-08 22:32:02', '2026-07-08 22:32:02'),
(87, 1, 1, 7, 'stock_out', -1, 'Sale #30', '2026-07-08 23:52:33', '2026-07-08 23:52:33'),
(88, 1, 1, 7, 'stock_out', -1, 'Sale #31', '2026-07-08 23:52:51', '2026-07-08 23:52:51'),
(89, 2, 1, 30, 'stock_out', -1, 'Sale #32', '2026-07-09 14:09:19', '2026-07-09 14:09:19'),
(90, 1, 1, 7, 'stock_out', -1, 'Sale #32', '2026-07-09 14:09:19', '2026-07-09 14:09:19'),
(91, 1, 1, 8, 'stock_out', -1, 'Sale #33', '2026-07-09 14:14:30', '2026-07-09 14:14:30'),
(92, 2, 1, 30, 'stock_out', -1, 'Sale #33', '2026-07-09 14:14:30', '2026-07-09 14:14:30'),
(93, 1, 1, 8, 'stock_out', -9, 'Sale #34', '2026-07-09 17:02:06', '2026-07-09 17:02:06'),
(94, 2, 1, 30, 'stock_out', -2, 'Sale #35', '2026-07-11 11:47:27', '2026-07-11 11:47:27'),
(95, 1, 1, 8, 'stock_out', -1, 'Sale #35', '2026-07-11 11:47:27', '2026-07-11 11:47:27'),
(96, 2, 1, 30, 'stock_out', -7, 'Sale #36', '2026-07-11 11:51:18', '2026-07-11 11:51:18'),
(97, 1, 1, 8, 'stock_out', -5, 'Sale #36', '2026-07-11 11:51:18', '2026-07-11 11:51:18'),
(98, 2, 1, 30, 'stock_out', -4, 'Sale #37', '2026-07-11 12:02:13', '2026-07-11 12:02:13'),
(99, 1, 1, 28, 'stock_out', -5, 'Sale #37', '2026-07-11 12:02:13', '2026-07-11 12:02:13'),
(100, 11, 2, 17, 'stock_out', -5, 'Sale #38', '2026-07-19 11:00:29', '2026-07-19 11:00:29'),
(101, 1, 1, 28, 'stock_out', -5, 'Sale #39', '2026-07-20 02:34:11', '2026-07-20 02:34:11'),
(102, 13, 1, 31, 'stock_out', -20, 'Sale #40', '2026-07-20 02:52:38', '2026-07-20 02:52:38'),
(103, 1, 3, 32, 'stock_in', 20, 'New Batch', '2026-07-27 15:15:54', '2026-07-27 15:15:54'),
(104, 3, 3, 22, 'stock_out', 10, 'Manual Decrease', '2026-07-27 15:21:47', '2026-07-27 15:21:47'),
(105, 1, 1, 28, 'stock_out', -3, 'Sale #41', '2026-07-27 15:30:40', '2026-07-27 15:30:40'),
(106, 11, 2, 17, 'stock_out', -2, 'Sale #42', '2026-07-27 18:10:44', '2026-07-27 18:10:44'),
(107, 1, 2, 19, 'stock_out', -5, 'Sale #43', '2026-07-27 18:11:13', '2026-07-27 18:11:13'),
(108, 15, 2, 35, 'stock_in', 200, 'New Batch', '2026-07-27 18:25:49', '2026-07-27 18:25:49'),
(109, 13, 1, 31, 'stock_out', 30, 'Manual Decrease', '2026-07-27 18:33:38', '2026-07-27 18:33:38'),
(112, 2, 2, 21, 'stock_out', -15, 'Sale #44', '2026-07-27 19:26:22', '2026-07-27 19:26:22'),
(113, 1, 2, 19, 'stock_out', -2, 'Sale #45', '2026-07-27 19:33:46', '2026-07-27 19:33:46'),
(114, 11, 2, 17, 'stock_out', -2, 'Sale #46', '2026-07-27 20:00:17', '2026-07-27 20:00:17'),
(115, 1, 2, 19, 'stock_out', -5, 'Sale #47', '2026-07-27 23:58:00', '2026-07-27 23:58:00'),
(116, 2, 1, 30, 'stock_out', -10, 'Sale #48', '2026-07-28 00:16:05', '2026-07-28 00:16:05'),
(117, 19, 1, 38, 'stock_in', 10, 'New Batch', '2026-07-28 00:19:26', '2026-07-28 00:19:26'),
(118, 2, 2, 21, 'stock_out', -3, 'Sale #49', '2026-07-29 02:47:43', '2026-07-29 02:47:43'),
(119, 8, 2, 29, 'stock_out', -2, 'Sale #50', '2026-07-29 02:48:16', '2026-07-29 02:48:16'),
(120, 2, 1, 30, 'stock_out', -4, 'Sale #51', '2026-07-30 17:21:41', '2026-07-30 17:21:41'),
(121, 1, 1, 28, 'stock_out', -2, 'Sale #51', '2026-07-30 17:21:41', '2026-07-30 17:21:41'),
(122, 19, 1, 38, 'stock_out', -5, 'Sale #52', '2026-07-30 17:26:19', '2026-07-30 17:26:19'),
(123, 2, 1, 30, 'stock_out', -1, 'Sale #53', '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(124, 1, 1, 8, 'stock_out', -1, 'Sale #53', '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(125, 19, 1, 38, 'stock_out', -1, 'Sale #53', '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(126, 1, 1, 28, 'stock_out', -1, 'Sale #54', '2026-07-30 23:19:48', '2026-07-30 23:19:48'),
(127, 2, 1, 9, 'stock_out', -1, 'Sale #54', '2026-07-30 23:19:48', '2026-07-30 23:19:48'),
(128, 19, 1, 38, 'stock_out', -1, 'Sale #55', '2026-07-30 23:20:36', '2026-07-30 23:20:36'),
(129, 1, 1, 28, 'stock_out', -1, 'Sale #55', '2026-07-30 23:20:36', '2026-07-30 23:20:36'),
(130, 1, 1, 28, 'stock_out', -1, 'Sale #56', '2026-07-30 23:22:56', '2026-07-30 23:22:56'),
(131, 2, 1, 9, 'stock_out', -2, 'Sale #56', '2026-07-30 23:22:56', '2026-07-30 23:22:56'),
(132, 19, 1, 38, 'stock_out', -1, 'Sale #57', '2026-08-03 00:10:15', '2026-08-03 00:10:15'),
(133, 3, 3, 22, 'stock_out', -5, 'Sale #58', '2026-08-03 00:21:35', '2026-08-03 00:21:35'),
(134, 4, 3, 23, 'stock_out', -1, 'Sale #59', '2026-08-03 14:12:16', '2026-08-03 14:12:16'),
(135, 4, 3, 23, 'stock_out', -1, 'Sale #60', '2026-08-03 14:13:42', '2026-08-03 14:13:42'),
(136, 2, 3, 24, 'stock_out', -4, 'Sale #61', '2026-08-05 14:51:42', '2026-08-05 14:51:42'),
(137, 1, 1, 28, 'stock_out', -2, 'Sale #62', '2026-08-12 16:16:57', '2026-08-12 16:16:57'),
(138, 2, 1, 9, 'stock_out', -1, 'Sale #63', '2026-08-13 09:33:18', '2026-08-13 09:33:18'),
(139, 19, 1, 38, 'stock_out', 2, 'Manual Decrease', '2026-08-26 16:34:43', '2026-08-26 16:34:43'),
(140, 1, 2, 20, 'stock_out', 50, 'Manual Decrease', '2026-08-26 16:35:07', '2026-08-26 16:35:07'),
(141, 2, 2, 21, 'stock_out', 30, 'Manual Decrease', '2026-08-26 16:35:23', '2026-08-26 16:35:23'),
(142, 8, 2, 29, 'stock_out', 5, 'Manual Decrease', '2026-08-26 16:35:46', '2026-08-26 16:35:46'),
(143, 15, 2, 34, 'stock_out', 100, 'Manual Decrease', '2026-08-26 16:36:03', '2026-08-26 16:36:03'),
(144, 15, 2, 35, 'stock_out', 200, 'Manual Decrease', '2026-08-26 16:36:11', '2026-08-26 16:36:11'),
(145, 14, 2, 33, 'stock_out', 100, 'Manual Decrease', '2026-08-26 16:36:27', '2026-08-26 16:36:27'),
(146, 11, 2, 17, 'stock_out', 1, 'Manual Decrease', '2026-08-26 16:36:40', '2026-08-26 16:36:40'),
(147, 16, 2, 36, 'expired', 123, 'Manual Expired', '2026-08-26 16:36:53', '2026-08-26 16:36:53'),
(148, 1, 3, 32, 'stock_out', 20, 'Manual Decrease', '2026-08-26 16:37:22', '2026-08-26 16:37:22'),
(149, 2, 3, 24, 'stock_out', 25, 'Manual Decrease', '2026-08-26 16:37:36', '2026-08-26 16:37:36'),
(150, 3, 3, 22, 'stock_out', 27, 'Manual Decrease', '2026-08-26 16:37:54', '2026-08-26 16:37:54'),
(151, 4, 3, 23, 'stock_out', 28, 'Manual Decrease', '2026-08-26 16:38:07', '2026-08-26 16:38:07'),
(152, 2, 4, 25, 'stock_out', 35, 'Manual Decrease', '2026-08-26 16:39:06', '2026-08-26 16:39:06'),
(153, 1, 4, 39, 'stock_in', 50, 'New Batch', '2026-08-26 16:43:47', '2026-08-26 16:43:47'),
(154, 2, 4, 40, 'stock_in', 50, 'New Batch', '2026-08-26 16:44:18', '2026-08-26 16:44:18'),
(155, 2, 4, 25, 'suspended', 0, 'Manual Suspended', '2026-08-26 16:44:25', '2026-08-26 16:44:25'),
(156, 1, 3, 32, 'stock_in', 50, 'Manual Add', '2026-08-26 16:45:03', '2026-08-26 16:45:03'),
(157, 2, 3, 24, 'suspended', 0, 'Manual Suspended', '2026-08-26 16:45:20', '2026-08-26 16:45:20'),
(158, 2, 3, 41, 'stock_in', 50, 'New Batch', '2026-08-26 16:45:34', '2026-08-26 16:45:34'),
(159, 2, 2, 21, 'suspended', 0, 'Manual Suspended', '2026-08-26 16:45:58', '2026-08-26 16:45:58'),
(160, 2, 2, 42, 'stock_in', 50, 'New Batch', '2026-08-26 16:46:11', '2026-08-26 16:46:11'),
(161, 1, 2, 20, 'suspended', 0, 'Manual Suspended', '2026-08-26 16:46:22', '2026-08-26 16:46:22'),
(162, 1, 2, 43, 'stock_in', 50, 'New Batch', '2026-08-26 16:46:33', '2026-08-26 16:46:33'),
(163, 1, 1, 44, 'stock_in', 50, 'New Batch', '2026-08-26 16:47:45', '2026-08-26 16:47:45'),
(164, 2, 1, 45, 'stock_in', 50, 'New Batch', '2026-08-26 16:48:16', '2026-08-26 16:48:16'),
(165, 13, 1, 31, 'suspended', 0, 'Manual Suspended', '2026-08-26 16:53:02', '2026-08-26 16:53:02'),
(166, 1, 1, 44, 'stock_out', -9, 'Sale #64', '2026-08-26 17:06:01', '2026-08-26 17:06:01'),
(167, 2, 1, 45, 'stock_out', -21, 'Sale #64', '2026-08-26 17:06:01', '2026-08-26 17:06:01'),
(168, 1, 2, 20, 'reactivated', 0, 'Batch reactivated', '2026-08-26 17:26:38', '2026-08-26 17:26:38'),
(169, 2, 2, 21, 'reactivated', 0, 'Batch reactivated', '2026-08-26 17:29:31', '2026-08-26 17:29:31'),
(170, 11, 2, 17, 'suspended', 0, 'Manual Suspended', '2026-08-26 17:37:06', '2026-08-26 17:37:06'),
(171, 1, 4, 39, 'stock_out', -5, 'Sale #65', '2026-08-26 18:00:37', '2026-08-26 18:00:37'),
(172, 2, 4, 40, 'stock_out', -2, 'Sale #65', '2026-08-26 18:00:37', '2026-08-26 18:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `to_store_id` bigint(20) UNSIGNED DEFAULT NULL,
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

INSERT INTO `messages` (`id`, `store_id`, `to_store_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`, `updated_at`, `type`, `file_path`, `file_name`) VALUES
(31, 2, NULL, 30, NULL, '494579798_693373853415594_8083316453582063649_n.jpg', 0, '2026-01-15 00:42:41', '2026-01-15 00:42:41', 'file', 'chat_files/P1KgcS9fxofq2YsvhwBMvgZu1J4MDUHj14uV8aVs.jpg', NULL),
(32, 2, NULL, 30, NULL, 'Birth-Certificate-Template-10.jpg', 0, '2026-01-15 00:43:06', '2026-01-15 00:43:06', 'file', 'chat_files/SM6KfMDydhIg50aRRoOO6K1jJZVVzPdw14O6O7Et.jpg', NULL),
(34, 2, NULL, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:50:26', '2026-01-15 00:50:26', 'file', 'chat_files/qwxKPUagFmpUm3td3pBcPIqKnZVamEDh7wfasD1l.jpg', NULL),
(35, 2, NULL, 30, NULL, 'Info-Website-19.jpg', 0, '2026-01-15 00:50:49', '2026-01-15 00:50:49', 'file', 'chat_files/OXjOk8qYHzIJrOIJPwQgjMCd8wwGDpr5g3t9bOxq.jpg', NULL),
(37, 2, NULL, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:58:33', '2026-01-15 00:58:33', 'file', 'chat_files/3yZcalFyMo30kspMqr8t9Z33qChykyTLzIRQYIZi.jpg', NULL),
(71, 1, NULL, 95, 22, 'hi', 1, '2026-07-08 23:45:12', '2026-07-19 16:07:26', 'text', NULL, NULL),
(72, 1, NULL, 26, 86, 'We request a time change on your appointment', 1, '2026-07-11 11:35:10', '2026-07-19 10:56:55', 'text', NULL, NULL),
(73, 1, NULL, 86, 22, '123', 1, '2026-07-19 18:03:01', '2026-07-19 20:00:21', 'text', NULL, NULL),
(74, 1, NULL, 86, NULL, 'ChatGPT Image Jul 18, 2026, 07_30_06 AM.png', 1, '2026-07-19 18:03:20', '2026-07-19 20:00:21', 'file', 'chat_files/jY0WQWA0TsfwkH07a8skxSwQJ60WlSuGnzQBWlGL.png', NULL),
(75, 2, NULL, 33, 103, 'Hi', 0, '2026-07-27 19:38:35', '2026-07-27 19:38:35', 'text', NULL, NULL),
(76, 2, NULL, 33, 103, 'IMG_3190.png', 0, '2026-07-27 19:38:55', '2026-07-27 19:38:55', 'file', 'chat_files/NkHt6092vR4kyFLv16yVlcorHtb31v7dgsA6SkLm.png', NULL),
(77, 2, NULL, 30, 106, 'Hi', 0, '2026-07-27 19:59:33', '2026-07-27 19:59:33', 'text', NULL, NULL),
(78, 1, NULL, 26, 94, 'Good day. The doctor will not be available today due to illness. We apologize for the inconvenience, please confirm if your want to reschedule your appointment.', 0, '2026-07-29 03:05:49', '2026-07-29 03:05:49', 'text', NULL, NULL);

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
(56, '2026_04_10_000001_break_down_address_fields', 15),
(57, '2026_04_30_120000_add_pda_fields_to_patient_records_table', 16),
(58, '2026_04_30_130000_add_payment_method_to_sales_table', 17),
(59, '2026_05_01_120000_create_store_schedule_overrides_table', 17),
(60, '2026_05_01_120100_create_doctor_schedules_table', 17),
(61, '2026_05_01_120200_create_parent_child_links_table', 17),
(62, '2026_05_04_100000_add_verification_to_parent_child_links_table', 18),
(63, '2026_07_02_000000_add_is_managed_to_users_table', 19),
(64, '2026_07_10_000000_create_patient_medications_table', 20),
(65, '2026_07_19_000001_add_appointment_type_to_appointments_table', 21),
(66, '2026_07_28_000000_create_sms_logs_table', 22),
(67, '2026_07_29_000001_add_payment_amounts_to_appointments_table', 22),
(68, '2026_07_29_000002_create_units_table', 22),
(69, '2026_07_29_000003_add_soft_deletes_to_medicines_table', 22),
(70, '2026_08_01_090000_add_appointment_id_to_sales_table', 23),
(71, '2026_08_01_090100_add_to_store_id_to_messages_table', 23),
(72, '2026_08_26_000000_add_reactivated_to_medicine_movements_type', 24);

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
('030294cc-4f2d-4755-a9b4-92186413becb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on April 10, 2026 (3:00 PM - 5:45 PM)\",\"url\":null}', '2026-07-20 16:31:51', '2026-04-10 14:56:28', '2026-07-20 16:31:51'),
('0362715c-3b1f-4ed7-92cb-2b26709340d1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 77, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:00 PM - 1:45 PM)\",\"url\":null}', '2026-02-25 16:22:07', '2026-02-25 16:13:29', '2026-02-25 16:22:07'),
('03aa3a7c-3f42-498e-a5e3-5543f28b9feb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Valentin, Celestine was moved from Aug 28, 2026 at 12:00 PM to Aug 28, 2026 at 1:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-26 17:47:14', '2026-08-13 12:53:54', '2026-08-26 17:47:14'),
('03caa410-acbf-4b5a-9dcc-825eb174707d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Root Canal Treatment\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:37', '2026-08-26 17:51:58'),
('04ecb8b6-9c28-4e96-92a2-5143a4d1f15b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Restored\",\"message\":\"Patient Datron, Liam has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-07-30 17:58:50', '2026-07-30 17:55:10', '2026-07-30 17:58:50'),
('04f987a2-4314-46a0-a5af-09e1ea00aecb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2025-11-24 16:20:11', '2025-11-24 16:20:11'),
('05e0bf80-7d84-4a46-b858-9003c28954bf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Emergency Appointment Recorded\",\"message\":\"Your emergency appointment at Prenza 1 Santiago-Amancio Branch on Aug 06, 2026 at 3:34 PM has been recorded.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-12 16:30:14', '2026-08-06 15:34:58', '2026-08-12 16:30:14'),
('06485a2a-2786-43ab-bf5a-5c0e45d12ae8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:58:51', '2025-10-07 05:26:23'),
('08083061-00bf-4f7d-83cc-91f6c60a53a5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Dental Check-up\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:23:47', '2026-08-06 15:27:12'),
('08233f66-53d8-4d83-8a8c-17a5cb9ba5df', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:19:46', '2026-01-16 01:00:58'),
('098228bd-3a2d-4729-939d-6ee611737163', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-05 02:14:26', '2025-08-31 01:36:20', '2025-09-05 02:14:26'),
('0b3b9297-54fd-470e-9739-07130616857b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"padilla, joshua booked an appointment on Aug 08, 2026 at 9:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:33:15', '2026-08-08 06:05:43', '2026-08-12 16:33:15'),
('0b5bfd79-69c8-4805-b9dd-894ecfff5c56', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:18:59', '2026-01-16 01:00:58'),
('0cd33978-edec-48bf-b689-1c533b186f7b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:33', '2025-10-07 05:26:23'),
('0d12ec94-f882-4cd7-8309-588c6b50141f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 22:45:18', '2025-10-07 22:44:36', '2025-10-07 22:45:18'),
('0dec409a-3a8b-4f43-bc62-214ea87dc309', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 30, '{\"title\":\"Medicine Marked as Expired\",\"message\":\"\\\"Antidote\\\" (Batch #36, qty 123) has been marked as expired.\",\"url\":\"https:\\/\\/dentaease.online\\/inventory\\/archived\"}', '2026-08-26 16:57:24', '2026-08-26 16:36:53', '2026-08-26 16:57:24'),
('0ef7a2ff-3c65-42bb-acf8-44d2bbd9a356', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 59, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 17, 2026 (1:00 PM - 2:30 PM)\",\"url\":null}', NULL, '2026-01-16 04:23:43', '2026-01-16 04:23:43'),
('0ef9a5d7-b4af-49cd-966f-9e69b061e5f6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 22, 2026 (4:00 PM - 7:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 19:05:43', '2026-01-16 01:00:58'),
('10180c6b-6e02-4330-8d82-8d7841d4a131', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 5, 2025 (9:10 AM - 9:25 AM)\",\"url\":null}', NULL, '2025-11-26 20:45:44', '2025-11-26 20:45:44'),
('12386d1f-8f6b-4a5b-833e-a7bf863997bc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('12558c83-45bd-4eee-8db0-f32d4d0f61fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 105, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 30, 2026 at San Jose Del Monte Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', NULL, '2026-07-30 23:13:14', '2026-07-30 23:13:14'),
('12e395fd-4141-48ef-9338-420914952d25', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"New Service Added\",\"message\":\"The service \\\"lalalala\\\" has been added to the clinic\'s service list.\",\"url\":\"\\/services\"}', '2026-07-30 18:03:22', '2026-07-30 18:03:15', '2026-07-30 18:03:22'),
('133d7f9c-db64-4f4f-9bd9-226a7b0acd6a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 28, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:49:31', '2026-08-13 12:51:15', '2026-08-26 17:49:31'),
('17293ce7-23ea-4420-83af-148ce823af25', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 18, 2025 (7:00 AM - 7:45 AM)\",\"url\":null}', '2025-11-29 02:23:34', '2025-11-26 06:49:54', '2025-11-29 02:23:34'),
('177cc7a8-38b7-4659-8e21-962cdcb6b536', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Denture (Removable)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:22:13', '2026-08-06 15:27:12'),
('17d955aa-8a84-4576-8fa8-ea50a3b57e72', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-01-11 23:36:05', '2026-01-11 23:36:05'),
('1b37f983-c7fb-4599-be9c-cc36efa3e4ef', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 5, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-03-05 22:27:16', '2026-03-05 17:33:58', '2026-03-05 22:27:16'),
('1b66f6a5-c239-4f4f-ab08-59eeecb921e9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Patient Archived\",\"message\":\"Patient Datron, Liam has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-07-30 17:54:15', '2026-07-30 17:54:09', '2026-07-30 17:54:15'),
('1ceb9463-7a8f-468e-b9b4-5566af5ced8f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:46', '2025-09-07 22:33:46'),
('1dca694d-4a82-4b21-b765-b635b3cd97fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 5, 2025 (9:10 AM - 9:25 AM)\",\"url\":null}', NULL, '2025-11-24 16:22:47', '2025-11-24 16:22:47'),
('1e36ec3a-0ac7-4536-9c8b-a75457c3f501', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient Zarate, Jayvee has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-12 16:02:15', '2026-08-08 15:13:45', '2026-08-12 16:02:15'),
('1e4d6b2a-ca26-4332-a234-067e4ed01cf4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Aug 06, 2026 at 3:34 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/147\\/view\"}', '2026-08-06 15:36:29', '2026-08-06 15:34:58', '2026-08-06 15:36:29'),
('1e784c6d-e66a-43d4-9868-c4ffb5ec5f37', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Braces (Initial Placement)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:44:14', '2026-08-03 13:45:09'),
('1eee2d62-f517-47c7-99a6-f14b0cfc2f8f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 113, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Aug 14, 2026 at Prenza 1 Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', NULL, '2026-08-20 12:27:44', '2026-08-20 12:27:44'),
('1fdb2d14-555b-4baf-9e0e-eebe5cc924d2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Zarate, Joan booked an appointment on Aug 12, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:05:03', '2026-08-12 16:02:31', '2026-08-12 16:05:03'),
('206c28b7-18cb-4d2c-8d8e-8271cd9f9abc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Dental Check-up\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:30:15', '2026-08-12 16:30:28'),
('235cd072-16dd-40a9-91ae-5b2912ccff47', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 89, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on May 4, 2026 (9:00 PM - 9:15 PM)\",\"url\":null}', '2026-07-01 18:35:23', '2026-05-04 20:02:58', '2026-07-01 18:35:23'),
('23ffb69a-ef3c-4b52-8f07-8a2bc0d131b2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 64, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-20 13:30:46', '2026-01-20 13:30:17', '2026-01-20 13:30:46'),
('2593b66f-a9f0-4306-b338-e2ef960139c1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:11', '2025-11-26 20:42:11'),
('26acad9b-54c9-441c-b38e-a1a140ecc859', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Restoration (Filling)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:21:58', '2026-08-06 15:27:12'),
('26cd47b9-708c-44cb-9c57-8cea88d1fd2b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Appointment Services Changed\",\"message\":\"Services for Valentin, Celestine changed from [Simple Extraction] to [Restoration (Filling)].\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-26 17:47:14', '2026-08-13 12:53:00', '2026-08-26 17:47:14'),
('28427d98-4a7b-4c82-91cb-c263405a20c0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Wisdom Tooth Surgery\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:28', '2026-08-26 17:51:58'),
('28a992dc-ac11-4b43-ba5f-8445051687a2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Fixed Prosthesis (Bridge)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:44:00', '2026-08-03 13:45:09'),
('2946ecc1-f30a-48aa-a487-f73556f6443d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 87, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on May 2, 2026 (4:00 PM - 4:15 PM)\",\"url\":null}', '2026-05-02 15:17:35', '2026-05-02 15:17:28', '2026-05-02 15:17:35'),
('2b353c44-e54e-45f7-b38c-076f39eb38f7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Villanueva, Adrian has an appointment on Aug 03, 2026 at 10:00 AM pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-03 00:16:26', '2026-07-30 23:21:56', '2026-08-03 00:16:26'),
('2c0b8360-faef-41b2-84f1-f8c6e8bca7fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('2e1f0338-7f57-4d4c-859b-3b1162860c76', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-30 10:02:09', '2026-01-13 01:10:48'),
('2ec64b43-da16-4507-bc13-daf50bbaef1e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 111, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 12, 2026 at 5:00 PM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-12 16:57:58', '2026-08-12 16:02:31', '2026-08-12 16:57:58'),
('2f854ee6-b60c-4ff2-8f61-dc054b2c3b3e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 13, 2025 (9:00 AM - 9:30 AM)\",\"url\":null}', '2026-01-31 16:16:44', '2025-11-26 20:48:17', '2026-01-31 16:16:44'),
('303e9b26-e5c2-44ae-b333-5b1767e3bbdf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 78, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-02-26 14:55:11', '2026-02-26 14:55:11'),
('30bba75a-8d27-403d-91a9-32b49056f969', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on July 28, 2026 (3:00 PM - 3:40 PM)\",\"url\":null}', '2026-08-03 13:45:36', '2026-07-27 17:51:26', '2026-08-03 13:45:36'),
('31f19bdb-67eb-43cf-8a06-9d7912f54f5a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Jacket Crown (Front Tooth)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:29:19', '2026-08-12 16:30:28'),
('32f04779-9fe5-40bc-b496-caa99698a787', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Jul 30, 2026 at 11:16 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/143\\/view\"}', '2026-08-02 23:48:22', '2026-07-30 23:16:42', '2026-08-02 23:48:22'),
('340ce178-feac-4ad7-a5db-75f2c23cda99', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on July 2, 2026 (9:00 AM - 10:00 AM)\",\"url\":null}', '2026-07-02 08:34:37', '2026-07-02 08:34:19', '2026-07-02 08:34:37'),
('3521dbd9-823d-4173-a972-4dd9a71e7b04', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat, Sun.\",\"url\":\"\\/branch\"}', '2026-08-12 16:02:15', '2026-08-08 06:04:58', '2026-08-12 16:02:15'),
('3712f047-77e7-49e0-bbda-09a013777d8d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Schedule Calendar Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch is marked CLOSED on Aug 08, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 17:49:31', '2026-08-13 09:38:26', '2026-08-26 17:49:31'),
('3745a3df-8194-4b26-9601-84f9d5b1e87b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 54, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 31, 2026 (10:00 AM - 10:15 AM)\",\"url\":null}', NULL, '2026-01-31 18:10:29', '2026-01-31 18:10:29'),
('3a44d9de-df1b-456e-aad5-c1d12845b095', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 27, 2025 (7:00 AM - 8:00 AM)\",\"url\":null}', '2025-11-26 20:30:08', '2025-11-24 16:29:29', '2025-11-26 20:30:08'),
('3abd7254-4fe5-4396-86f8-9bf4e541723d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Dental Check-up\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:44:46', '2026-08-03 13:45:09'),
('3b12360f-f84f-40d5-b015-34da3668c611', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 95, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on July 30, 2026 (3:00 PM - 5:00 PM)\",\"url\":null}', NULL, '2026-07-27 18:56:42', '2026-07-27 18:56:42'),
('3b7522ee-6532-4579-9313-0c6fa235206b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-03-06 10:37:24', '2026-03-06 10:32:24', '2026-03-06 10:37:24'),
('3e9c30b4-01be-440d-b471-cc42c10428fd', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Simple Extraction\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:42:52', '2026-08-03 13:45:09'),
('3f6a2766-d3ef-4d0b-9acd-36f051316e68', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Appointment Cancelled\",\"message\":\"The appointment of Valentin, Celestine on Aug 14, 2026 at 5:00 PM was cancelled.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\"}', '2026-08-20 12:29:42', '2026-08-13 12:57:13', '2026-08-20 12:29:42'),
('40e2ea9c-c292-4592-a87c-dcfa15e43349', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 111, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on August 12, 2026 (5:00 PM - 5:15 PM)\",\"url\":null}', '2026-08-12 16:57:58', '2026-08-12 16:11:48', '2026-08-12 16:57:58'),
('419028e7-e414-4122-8a98-05810046bc46', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Schedule Calendar Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch is marked CLOSED on Aug 08, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-20 12:29:42', '2026-08-13 09:38:26', '2026-08-20 12:29:42'),
('41f6db0b-6186-43d8-b815-66828ba26a30', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Staff Archived\",\"message\":\"Staff member Montenegro, Luna has been archived.\",\"url\":\"\\/useraccount\"}', '2026-08-03 13:54:22', '2026-08-03 13:53:54', '2026-08-03 13:54:22'),
('425853dd-870d-490b-90ed-1cbf21888334', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Villanueva, Adrian at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/145\\/view\"}', '2026-08-03 13:48:01', '2026-08-03 00:26:52', '2026-08-03 13:48:01'),
('439d5819-fa0d-433c-9589-183976b4dafe', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:06:40', '2026-01-13 01:10:48'),
('443ea319-6ccb-4af2-bb5e-7035830e646d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 78, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:45 PM - 2:00 PM)\",\"url\":null}', NULL, '2026-02-26 14:57:32', '2026-02-26 14:57:32'),
('44f1cc58-6ae5-45a9-a67a-a193f396760a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat, Sun.\",\"url\":\"\\/branch\"}', '2026-08-12 16:05:03', '2026-08-08 06:04:58', '2026-08-12 16:05:03'),
('47c3955f-6e3d-40e1-a8e6-78a333e920a8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 19:04:19', '2026-01-16 01:00:58'),
('4a1976f2-fba3-4811-9199-a200a4e876c2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Fixed Prosthesis (Bridge)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:22:40', '2026-08-06 15:27:12'),
('4a6695ae-821c-4f85-a70b-923f6f06fc6e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 23, 2026 (4:00 PM - 6:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:51:28', '2026-01-16 01:00:58'),
('4ccb00ff-29c2-4ded-b671-108d1538a965', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (9:00 AM - 10:15 AM)\",\"url\":null}', '2026-01-20 03:32:00', '2026-01-16 02:40:47', '2026-01-20 03:32:00'),
('4d0a8557-e646-4dcd-a753-cac4b175585b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient Datron, Liam has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-07-30 17:58:50', '2026-07-30 17:54:09', '2026-07-30 17:58:50'),
('4e1dfacf-7d41-473b-865d-08fbea618e5f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 34, '{\"title\":\"New Appointment Booking\",\"message\":\"Diaz, Junjun booked an appointment on Aug 03, 2026 at 9:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:33:43', '2026-08-03 13:46:43', '2026-08-12 16:33:43'),
('4e3345dc-47c8-44f4-be2b-936f727da3a7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-02-23 17:43:55', '2026-02-23 17:43:37', '2026-02-23 17:43:55'),
('4f481e05-9a09-4d2b-a839-71f441396d0e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"padilla, joshua booked an appointment on Aug 08, 2026 at 9:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:05:03', '2026-08-08 06:05:43', '2026-08-12 16:05:03'),
('507f5fb7-c678-4a6c-a09d-0412580a236c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-05 19:29:10', '2026-08-03 13:47:37', '2026-08-05 19:29:10'),
('5084a05a-4729-438b-aea9-f2d1b9b6bd04', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Walk-in Appointment Booked\",\"message\":\"A walk-in appointment was booked for Diaz, Junjun on Aug 26, 2026 at 4:59 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/155\\/view\"}', '2026-08-26 17:05:13', '2026-08-26 16:59:41', '2026-08-26 17:05:13'),
('50d30e9e-2178-40bb-92a9-48575695bff1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Appointment Services Changed\",\"message\":\"Services for Valentin, Celestine changed from [Simple Extraction] to [Restoration (Filling)].\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-26 17:49:31', '2026-08-13 12:53:00', '2026-08-26 17:49:31'),
('51928d9f-b9f6-487a-b9ea-2ca89dfda57c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 14, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:47:14', '2026-08-13 12:48:37', '2026-08-26 17:47:14'),
('5483cbfa-cf5c-4c00-9e33-9f9ddf4c5613', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-07-30 18:10:54', '2026-07-30 18:10:32', '2026-07-30 18:10:54'),
('54f16692-c45f-4a5a-abc9-c01c8e2e3f76', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (12:46 PM - 1:16 PM)\",\"url\":null}', '2026-02-21 13:05:59', '2026-02-13 13:04:52', '2026-02-21 13:05:59'),
('550addb7-4972-4bdf-99e2-cb3b2fec5575', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:00:30', '2025-10-07 05:26:23'),
('5579640f-9133-4b56-97c5-e7789ef0ffda', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-24 16:57:59', '2026-01-13 01:10:48'),
('55f8c5b1-6a35-4f0c-9995-bb24f9e5a225', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (9:00 AM - 9:45 AM)\",\"url\":null}', '2026-03-06 10:37:24', '2026-03-06 10:36:46', '2026-03-06 10:37:24'),
('55fe8835-7139-4aa8-87de-ac47cdfd9c0e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 80, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 6, 2026 (2:15 PM - 3:00 PM)\",\"url\":null}', '2026-03-06 10:59:30', '2026-03-06 10:57:16', '2026-03-06 10:59:30'),
('56b7f5e7-16b7-4f9d-8130-558a905b833a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-12 16:34:23', '2026-08-03 13:46:43', '2026-08-12 16:34:23'),
('58ddc856-fad7-4c32-9d56-f7e9ecd642c8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 28, 2026 at 12:00 PM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:51:15', '2026-08-13 12:51:15'),
('59ed5555-b5dd-44a5-8901-edad0ed63bc9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 23:36:44', '2025-10-07 23:36:44'),
('5a30f687-413c-4e45-abd6-2fc1f519dac5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Denture (Removable)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:43:28', '2026-08-03 13:45:09'),
('5b57b6c6-e824-411f-bd87-c2c61c92c88d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Dental Check-up\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:45', '2026-08-26 17:51:58'),
('5bde7202-e113-42ad-aeed-7b2f07e84d53', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Zarate, Joan was moved from Aug 12, 2026 at 5:00 PM to Aug 12, 2026 at 4:20 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/149\\/view\"}', '2026-08-12 16:33:15', '2026-08-12 16:12:15', '2026-08-12 16:33:15'),
('5c699ba8-df22-4987-bbab-d206c4c7f12c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:00 AM)\",\"url\":null}', NULL, '2026-01-11 20:49:07', '2026-01-11 20:49:07'),
('5d504327-b344-42ec-8272-1637a38273a0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Jacket Crown (Front Tooth)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:43:44', '2026-08-03 13:45:09'),
('601f2e40-6304-45d7-ada1-14724352747e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"padilla, joshua booked an appointment on Aug 08, 2026 at 9:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:30:45', '2026-08-08 06:05:43', '2026-08-12 16:30:45'),
('6105ec9b-44c2-4934-8177-fe7c9db9d0b8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 7, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2026-02-13 09:12:17', '2026-02-13 09:12:17'),
('610969e6-3df5-4e97-a8e6-e75d27698744', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Santa Maria Santiago-Amancio Branch schedule was updated. Hours: 9:00 PM - 11:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat.\",\"url\":\"\\/branch\"}', '2026-08-03 13:48:01', '2026-08-03 13:47:25', '2026-08-03 13:48:01'),
('61b31c7d-62a9-4f70-a73f-bce60b79a5ec', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Doctor Schedule Updated\",\"message\":\"Marieta Amancio is marked OFF on Aug 05, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 16:37:41', '2026-08-13 09:38:12', '2026-08-26 16:37:41'),
('633b72fa-1027-4664-8ae4-f9612ae7d6e7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 90, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on August 3, 2026 (10:00 AM - 10:15 AM)\",\"url\":null}', NULL, '2026-07-30 23:22:08', '2026-07-30 23:22:08'),
('66132e7f-d655-46dd-9129-fed4fd770757', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Doctor Schedule Updated\",\"message\":\"Marieta Amancio is marked OFF on Aug 05, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 17:49:31', '2026-08-13 09:38:12', '2026-08-26 17:49:31'),
('66584c95-fe70-4ee3-9612-983aaf72d1f2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 15, 2026 (2:00 PM - 3:30 PM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 22:34:05', '2026-01-16 01:00:58'),
('67e2aa25-1a05-4c17-b7ec-acd4ed15a639', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on January 27, 2026 (10:00 PM - 11:00 PM)\",\"url\":null}', NULL, '2026-01-18 14:00:15', '2026-01-18 14:00:15'),
('6803f2ab-c0a4-4ff5-a414-b1adca5085fb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (3:16 PM - 3:46 PM)\",\"url\":null}', '2026-02-21 13:05:59', '2026-02-13 13:40:49', '2026-02-21 13:05:59'),
('6812ecf5-d7da-45cc-90c6-282eaa8c657f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-10-21 02:03:28', '2025-10-21 02:03:27', '2025-10-21 02:03:28'),
('686919d7-e710-43d9-8743-681e743d973f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 104, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-07-28 00:58:41', '2026-07-28 00:58:41'),
('6972c281-2a41-4d85-9e44-b5c1b828bf6c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:25:12', '2025-10-07 05:26:23'),
('69c1157d-5f91-4756-8e9e-3e7a3ad81a40', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:41', '2025-09-07 22:33:41'),
('6a904dfb-faf9-42de-8eb2-ecf95d630e59', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Schedule Calendar Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch is marked CLOSED on Aug 08, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 17:47:14', '2026-08-13 09:38:26', '2026-08-26 17:47:14'),
('6a9dff2f-bb2f-4084-bac5-fd46fc1f000d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:54', '2025-09-07 22:33:54'),
('6aff8f50-d367-4ca8-894c-10043e0b86bc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Restored\",\"message\":\"Patient Fortune, Crystal has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:31:17', '2026-08-06 15:30:25', '2026-08-06 15:31:17'),
('6b549db8-949c-44dd-aa2c-ce205a6d83d5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:25:00', '2026-01-16 01:00:58'),
('6c1330aa-4c84-464e-a386-942adcefb9dc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 08, 2026 at 9:00 AM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-08 06:18:37', '2026-08-08 06:05:43', '2026-08-08 06:18:37'),
('6cffb6e6-141f-48ed-babc-8c873e5bab9a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 50, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (7:00 AM - 8:00 AM)\",\"url\":null}', '2025-11-26 20:30:08', '2025-11-24 16:29:31', '2025-11-26 20:30:08'),
('6d2cc96e-3b73-4e45-9ce8-85fec2c27b13', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Braces (Initial Placement)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:29:43', '2026-08-12 16:30:28'),
('6de8dd2e-8db9-4a5d-b09a-d93dcdff4140', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on July 6, 2026 (4:00 PM - 4:45 PM)\",\"url\":null}', '2026-07-27 15:25:29', '2026-07-06 15:43:37', '2026-07-27 15:25:29'),
('6f141d10-0fc4-4fec-906a-cb039d07cfcb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Oral Prophylaxis (Cleaning)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:43:04', '2026-08-03 13:45:09'),
('6f23d579-75e9-46d4-9419-1ed334a4bf05', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 42, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on January 24, 2026 (10:00 PM - 10:30 PM)\",\"url\":null}', NULL, '2026-02-25 14:59:09', '2026-02-25 14:59:09'),
('70d85a8a-d1d3-4bf6-b75a-d8580ab4be7c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Medicine Marked as Expired\",\"message\":\"\\\"Antidote\\\" (Batch #36, qty 123) has been marked as expired.\",\"url\":\"https:\\/\\/dentaease.online\\/inventory\\/archived\"}', '2026-08-26 16:37:41', '2026-08-26 16:36:53', '2026-08-26 16:37:41'),
('710183d6-bf5b-4ca4-b90d-7f627f08798f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 14, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:47:14', '2026-08-13 12:56:47', '2026-08-26 17:47:14'),
('72d9efb6-e1bf-4506-a41a-03eb9a8c1923', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:52:46', '2026-01-13 01:10:48'),
('730c6dc5-0f4c-4fb1-b5b7-16876720e1e6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 14, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:49:31', '2026-08-13 12:48:37', '2026-08-26 17:49:31'),
('7318b3f5-cc92-4e32-9cdb-5fcc676382ff', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Your Schedule Was Updated\",\"message\":\"Marieta Amancio is marked OFF on Aug 05, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-20 12:29:42', '2026-08-13 09:38:12', '2026-08-20 12:29:42'),
('73b4a7b0-5ec7-4a6e-94ed-28941b12d0e4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 30, 2026 (11:00 AM - 11:45 AM)\",\"url\":null}', NULL, '2026-02-05 06:47:59', '2026-02-05 06:47:59'),
('7488f695-12c0-4b19-bb91-ca94e8d81627', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Appointment Services Changed\",\"message\":\"Services for Valentin, Celestine changed from [Simple Extraction] to [Restoration (Filling)].\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-20 12:29:42', '2026-08-13 12:53:00', '2026-08-20 12:29:42'),
('753bd3f4-c62e-4d6a-92a7-0af16324e743', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Restored\",\"message\":\"Patient pAGOD NAKo, Ayuko na has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:40:14', '2026-08-06 15:40:07', '2026-08-06 15:40:14'),
('767d346e-07e4-4f35-8f43-ad5a06486d15', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 111, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"Your appointment was moved from Aug 12, 2026 at 5:00 PM to Aug 12, 2026 at 4:20 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-12 16:57:58', '2026-08-12 16:12:15', '2026-08-12 16:57:58'),
('769aa53e-6f04-4162-8e6f-f75e1cb7b283', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:50', '2025-09-07 22:33:50'),
('7700d849-0e51-4ebc-a98c-baf257c2b724', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Simple Extraction\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:51:14', '2026-08-26 17:51:58'),
('7741a924-b510-421f-b5ea-41ae9d984b75', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 18, 2025 (10:30 AM - 10:45 AM)\",\"url\":null}', '2025-10-31 17:37:57', '2025-10-19 00:39:55', '2025-10-31 17:37:57'),
('77554393-6eca-4a34-8165-9669d10f5397', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 60, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 17, 2026 (12:00 PM - 12:45 PM)\",\"url\":null}', NULL, '2026-01-16 05:16:58', '2026-01-16 05:16:58'),
('77edf510-fd7b-4951-8343-33e28910e4f1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 13, 2026 at 10:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:47:14', '2026-08-13 09:22:30', '2026-08-26 17:47:14'),
('790942db-d1e0-4b7f-8234-f06a28eecfa3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Braces (Initial Placement)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:23:06', '2026-08-06 15:27:12'),
('79d7e8fc-7c0c-4796-95fc-1eb7b5e45a46', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"Your appointment was moved from Aug 28, 2026 at 12:00 PM to Aug 28, 2026 at 1:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:53:54', '2026-08-13 12:53:54'),
('7c618291-775d-42bd-9d7b-7e6e917310df', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient Lee, Catherine has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:29:21', '2026-08-06 15:29:08', '2026-08-06 15:29:21'),
('7d52a837-5529-4ffd-95d1-5661cf815ea5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Aug 06, 2026 at 3:34 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/147\\/view\"}', '2026-08-06 15:37:05', '2026-08-06 15:34:58', '2026-08-06 15:37:05');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('7e9e9bed-8eb1-4903-9fac-d1922c12f9eb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on July 22, 2026 (1:00 PM - 1:10 PM)\",\"url\":null}', '2026-07-20 03:51:00', '2026-07-19 20:00:51', '2026-07-20 03:51:00'),
('7ea09d0e-ebf4-4ed1-b583-ed78cecd4e0a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Diaz, Junjun booked an appointment on Aug 03, 2026 at 9:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-03 13:48:01', '2026-08-03 13:46:43', '2026-08-03 13:48:01'),
('7ec9b106-9759-4720-9bd7-9ee086afb6d1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Denture (Removable)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:44:57', '2026-08-26 17:51:58'),
('7f70f865-a369-474e-872b-81741ed95147', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (8:30 AM - 9:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:18:50', '2025-11-24 16:18:50'),
('8053b06f-78a9-452a-9922-192a72eec0a4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 72, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 24, 2026 (5:00 PM - 5:15 PM)\",\"url\":null}', NULL, '2026-02-24 18:16:53', '2026-02-24 18:16:53'),
('80cf7f6e-5245-4c8d-9db4-9a30e59c9e46', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 89, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-07-01 18:35:23', '2026-05-04 20:01:36', '2026-07-01 18:35:23'),
('8105431f-1346-4373-84f1-2d55e72b1429', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Restoration (Filling)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:28:56', '2026-08-12 16:30:28'),
('81ae4ef9-d27f-4421-bbee-dc56903acc14', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Restored\",\"message\":\"Patient Lee, Catherine has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:28:33', '2026-08-06 15:28:26', '2026-08-06 15:28:33'),
('820b3d50-097e-439f-8fc1-9a285b4f40b6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 79, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on March 2, 2026 (3:45 PM - 4:15 PM)\",\"url\":null}', NULL, '2026-03-01 21:17:59', '2026-03-01 21:17:59'),
('832c12cf-b889-4228-a043-e4800631673c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-03 13:54:22', '2026-08-03 13:47:37', '2026-08-03 13:54:22'),
('849feee9-f3f7-4d6b-933b-eda5aefd63e9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:19:16', '2025-11-24 16:19:16'),
('8613a38c-0253-42de-9054-8947fd857a85', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Walk-in Appointment Recorded\",\"message\":\"Your walk-in appointment at Prenza 1 Santiago-Amancio Branch on Aug 26, 2026 at 4:59 PM has been recorded.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-26 17:46:42', '2026-08-26 16:59:41', '2026-08-26 17:46:42'),
('8641441f-33c4-48a7-a6a5-899f384b9510', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:46:26', '2025-10-07 21:46:26'),
('873af7cf-ed34-4878-ad75-d503143ae992', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Walk-in Appointment Booked\",\"message\":\"A walk-in appointment was booked for Diaz, Junjun on Aug 26, 2026 at 4:59 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/155\\/view\"}', '2026-08-26 17:47:14', '2026-08-26 16:59:41', '2026-08-26 17:47:14'),
('8767c496-075d-4961-b773-db6b5c2b7daa', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Patient Restored\",\"message\":\"Patient Datron, Liam has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-08-05 19:29:10', '2026-07-30 17:55:10', '2026-08-05 19:29:10'),
('87903a07-dece-4a1f-ac75-b065274577b4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 4, 2026 (4:00 PM - 4:30 PM)\",\"url\":null}', '2026-05-04 15:02:23', '2026-05-04 15:02:23', '2026-05-04 15:02:23'),
('87952d61-01cf-4d26-9413-e2311adf357f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Simple Extraction\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:44:20', '2026-08-26 17:51:58'),
('887842a9-48c8-4f10-bd85-07e503c33ee4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 71, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 19, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', NULL, '2026-02-13 12:45:31', '2026-02-13 12:45:31'),
('88981a9c-eef7-4e31-976f-ebfdbe5ccf7b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Oral Prophylaxis (Cleaning)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:44:31', '2026-08-26 17:51:58'),
('88f4fc6c-cc44-4065-91dc-e312967cf2eb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 90, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"An appointment was booked for you at Prenza 1 Santiago-Amancio Branch on Aug 03, 2026 at 10:00 AM. It is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-07-30 23:21:56', '2026-07-30 23:21:56'),
('89a509f1-0266-4eb5-a303-1dd5bb6dc68e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-14 21:02:06', '2025-09-07 22:41:37', '2025-09-14 21:02:06'),
('89ee7a99-d691-4e4c-9421-debeaa8735f1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Santa Maria Santiago-Amancio Branch schedule was updated. Hours: 9:00 PM - 11:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat.\",\"url\":\"\\/branch\"}', '2026-08-03 14:14:30', '2026-08-03 13:47:25', '2026-08-03 14:14:30'),
('8d00448b-50fa-4173-af1e-4c9a3a40aac3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 15, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 21, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', NULL, '2026-01-31 18:11:36', '2026-01-31 18:11:36'),
('8d6ce1d3-ef6a-4c59-a4de-12be61d0d28c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Aug 06, 2026 at 3:34 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/147\\/view\"}', '2026-08-12 16:33:15', '2026-08-06 15:34:58', '2026-08-12 16:33:15'),
('8eb21dd2-2135-42f1-9aaa-367f49895b96', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 87, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on May 2, 2026 (9:00 PM - 9:15 PM)\",\"url\":null}', '2026-05-04 19:34:45', '2026-05-02 17:52:00', '2026-05-04 19:34:45'),
('8ef12381-a266-4dda-8d1d-70b603310844', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Walk-in Appointment Booked\",\"message\":\"A walk-in appointment was booked for Diaz, Junjun on Aug 26, 2026 at 4:59 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/155\\/view\"}', '2026-08-26 17:49:31', '2026-08-26 16:59:41', '2026-08-26 17:49:31'),
('8efa1828-10ab-476f-ab10-3a4d3f37f48a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Villanueva, Adrian at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/145\\/view\"}', '2026-08-03 13:45:09', '2026-08-03 00:26:52', '2026-08-03 13:45:09'),
('8f052e4d-02af-4733-a7e7-305b97d405db', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at San Jose Del Monte Santiago-Amancio Branch on May 1, 2026 (10:00 PM - 10:15 PM)\",\"url\":null}', '2026-05-04 15:02:23', '2026-05-01 20:48:48', '2026-05-04 15:02:23'),
('8f102df2-3702-4e64-8432-cc16fcfb5d2d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Wisdom Tooth Surgery\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:44:26', '2026-08-03 13:45:09'),
('8f4441a2-7c7b-4192-9c0b-7670031cc4e1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Villanueva, Adrian has an appointment on Aug 03, 2026 at 10:00 AM pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-05 19:29:10', '2026-07-30 23:21:56', '2026-08-05 19:29:10'),
('8f9842e2-97b1-4f35-9c47-e50def0adc66', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient Fortune, Crystal has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:31:17', '2026-08-06 15:30:09', '2026-08-06 15:31:17'),
('9058f8e6-857e-4110-ad35-b5de795eaf36', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-30 10:52:39', '2026-01-13 01:10:48'),
('9061a9ea-4114-487c-b504-6ce908f92a40', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on October 18, 2025 (10:30 AM - 10:45 AM)\",\"url\":null}', '2025-10-31 17:37:57', '2025-10-19 00:39:55', '2025-10-31 17:37:57'),
('913137af-d060-46ab-98f0-25437a55b7a5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Jacket Crown (Front Tooth)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:22:25', '2026-08-06 15:27:12'),
('91a5edac-3b8b-4e3c-b63e-ac8548e521f0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', '2025-10-17 08:18:41', '2025-10-17 08:16:47', '2025-10-17 08:18:41'),
('922d75c8-5c85-4ed1-81a1-e9b6cd4bd108', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:47:15', '2025-10-07 21:47:15'),
('94049e0b-9d19-4710-be82-8ea430008d9c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 21:46:29', '2025-10-07 21:46:29'),
('9408d595-2000-4541-8832-7567a377023a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Root Canal Treatment\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:30:04', '2026-08-12 16:30:28'),
('94ced9e3-3cde-4dc6-bd1d-09ac193ef636', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 85, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on May 2, 2026 (9:15 PM - 9:30 PM)\",\"url\":null}', NULL, '2026-05-02 17:54:20', '2026-05-02 17:54:20'),
('9507c4c8-cd1b-4a30-adae-f4683720c7e3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 35, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to November 27, 2025 (8:00 AM - 9:15 AM)\",\"url\":null}', '2026-01-13 01:10:48', '2025-11-26 07:06:37', '2026-01-13 01:10:48'),
('9636c377-585b-4117-8f80-21d9b38a830e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Restoration (Filling)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:43:15', '2026-08-03 13:45:09'),
('9658a2fa-3468-4695-bbfc-37bfbd0c6fa8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Aug 06, 2026 at 3:34 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/147\\/view\"}', '2026-08-12 16:05:03', '2026-08-06 15:34:58', '2026-08-12 16:05:03'),
('9660abdc-3946-4aab-af75-0be381d2146a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on July 23, 2026 (11:00 AM - 11:45 AM)\",\"url\":null}', '2026-07-28 00:28:42', '2026-07-20 12:20:51', '2026-07-28 00:28:42'),
('985b4afb-b010-46d9-b48f-98e899372d11', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Appointment Cancelled\",\"message\":\"The appointment of Valentin, Celestine on Aug 14, 2026 at 5:00 PM was cancelled.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\"}', '2026-08-26 17:47:14', '2026-08-13 12:57:13', '2026-08-26 17:47:14'),
('9876a143-271b-4e09-8cc9-e6f9f96b7513', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Patient Restored\",\"message\":\"Patient Datron, Liam has been restored.\",\"url\":\"\\/patientaccount\"}', '2026-07-30 17:55:38', '2026-07-30 17:55:10', '2026-07-30 17:55:38'),
('9877b230-8ca9-4816-abda-4dbfc7af02e9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Zarate, Joan was moved from Aug 12, 2026 at 5:00 PM to Aug 12, 2026 at 4:20 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/149\\/view\"}', '2026-08-12 16:30:45', '2026-08-12 16:12:15', '2026-08-12 16:30:45'),
('98900487-aacd-4b70-96b6-a0b31c380ea5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 66, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on January 26, 2026 (8:00 PM - 8:15 PM)\",\"url\":null}', NULL, '2026-02-01 07:33:46', '2026-02-01 07:33:46'),
('9d872949-16dd-4f0c-96cc-c6c1d90c2fec', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 16, 2026 at Prenza 1 Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', '2026-07-27 15:25:29', '2026-07-19 10:31:48', '2026-07-27 15:25:29'),
('9de0f9af-4513-46e0-a61b-276055ce92b9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Appointment Services Changed\",\"message\":\"The services for your appointment changed from [Simple Extraction] to [Restoration (Filling)].\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:53:00', '2026-08-13 12:53:00'),
('9ea7aea6-35c6-47f6-96a0-79b22821f14e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-07-27 15:25:29', '2026-07-06 15:25:38', '2026-07-27 15:25:29'),
('9ebfc04e-adc5-4286-a15a-57df0898dd99', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 44, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 18, 2025 (8:45 AM - 10:15 AM)\",\"url\":null}', NULL, '2026-01-11 20:40:13', '2026-01-11 20:40:13'),
('a0a280e8-1720-4a8c-ab35-59f69e639185', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:57', '2025-10-07 05:26:23'),
('a18248d6-a468-4a08-bf34-11a94a74febc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:19:19', '2025-11-24 16:19:19'),
('a2e2a5a5-a904-4180-8678-499e7a47b3db', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Patient Archived\",\"message\":\"Patient Datron, Liam has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-05 19:29:10', '2026-07-30 17:54:09', '2026-08-05 19:29:10'),
('a55d37e7-aca2-411a-8335-b5609010a831', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 13, 2026 at 10:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:49:31', '2026-08-13 09:22:30', '2026-08-26 17:49:31'),
('a784193c-8a55-468a-b438-6c4d031b64af', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 34, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Santa Maria Santiago-Amancio Branch schedule was updated. Hours: 9:00 PM - 11:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat.\",\"url\":\"\\/branch\"}', '2026-08-12 16:33:43', '2026-08-03 13:47:25', '2026-08-12 16:33:43'),
('a802e96c-89f7-4972-bcb4-5b98c64b0a02', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Oral Prophylaxis (Cleaning)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:28:46', '2026-08-12 16:30:28'),
('a82d1137-702a-4d85-883a-f83a94f1a100', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-01 22:49:49', '2025-08-31 00:49:13', '2025-09-01 22:49:49'),
('a890de24-8f19-4a84-aaae-6aaa9f7af188', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on July 13, 2026 (9:00 AM - 9:30 AM)\",\"url\":null}', '2026-07-10 10:08:12', '2026-07-09 18:07:25', '2026-07-10 10:08:12'),
('a9b651c9-2fed-442a-a2e4-029441995f82', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:24:57', '2026-01-16 01:00:58'),
('aa3c0b8c-8742-462a-b519-05f87886621d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Jacket Crown (Front Tooth)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:03', '2026-08-26 17:51:58'),
('aa642806-68fe-4f05-97cd-72579b72da34', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 43, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 13, 2025 (9:00 AM - 9:30 AM)\",\"url\":null}', '2026-01-31 16:16:44', '2025-11-11 07:04:11', '2026-01-31 16:16:44'),
('aa7d82bc-98ed-4d06-9b23-2017501d5a61', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Villanueva, Adrian at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/145\\/view\"}', '2026-08-03 14:14:30', '2026-08-03 00:26:52', '2026-08-03 14:14:30'),
('ae268bf0-4f54-4d58-8404-db3aa61aa2b3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 07:46:16', '2025-11-26 07:46:16'),
('aecf70a9-90b0-42c4-9239-4eb4b7f93139', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat, Sun.\",\"url\":\"\\/branch\"}', '2026-08-12 16:33:15', '2026-08-08 06:04:58', '2026-08-12 16:33:15'),
('af60ab77-7e4e-479e-ad57-46d3b7743a4d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-11 01:12:39', '2026-01-16 01:00:58'),
('af7e3c7f-7c29-4eaa-ba16-6ba37432bd67', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Diaz, Junjun booked an appointment on Aug 03, 2026 at 9:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-03 14:14:30', '2026-08-03 13:46:43', '2026-08-03 14:14:30'),
('af9761db-170a-4885-ad38-1497ed21d767', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 51, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2025-11-26 08:05:38', '2025-11-26 08:05:13', '2025-11-26 08:05:38'),
('b14f73b0-4762-4b25-834a-63ed3adf196d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 04:56:33', '2025-10-07 05:26:23'),
('b1b720f5-6011-4936-998f-8b960fdb4438', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 4, 2026 (9:00 AM - 10:15 AM)\",\"url\":null}', '2026-03-05 22:27:16', '2026-03-04 16:44:36', '2026-03-05 22:27:16'),
('b235162b-43f0-48fa-a582-94c6fed88799', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Schedule Calendar Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch is marked CLOSED on Aug 08, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 16:37:41', '2026-08-13 09:38:26', '2026-08-26 16:37:41'),
('b488905f-3bd2-4977-afd3-cadb8d0dd75e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 87, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-05-02 15:17:35', '2026-05-02 15:15:13', '2026-05-02 15:17:35'),
('b5c86f3e-a571-4e33-acbf-b285f69554e5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 56, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Santa Maria Santiago-Amancio Branch on January 16, 2026 (9:00 PM - 10:00 PM)\",\"url\":null}', '2026-01-16 02:47:38', '2026-01-16 02:15:36', '2026-01-16 02:47:38'),
('b5c8c847-89b3-4a88-9915-033ac4b96a17', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 13, 2026 at 10:00 AM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-20 12:29:42', '2026-08-13 09:22:30', '2026-08-20 12:29:42'),
('b65c9a9b-f67a-4b52-b93f-704cd4472ce0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Mabini, Crystal booked an appointment on Aug 14, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-20 12:29:42', '2026-08-13 12:48:37', '2026-08-20 12:29:42'),
('b79b228f-2a3d-4090-83dc-014e845ecd1e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on July 27, 2026 (4:00 PM - 4:10 PM)\",\"url\":null}', '2026-07-27 15:25:29', '2026-07-27 15:24:56', '2026-07-27 15:25:29'),
('b7ea230f-ec61-4f35-adc1-c8714a8f669c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on February 23, 2026 (6:00 PM - 6:15 PM)\",\"url\":null}', '2026-02-23 17:54:00', '2026-02-23 17:47:46', '2026-02-23 17:54:00'),
('b7f0f75d-c729-4345-bb80-ea9f8e22e6bf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on August 8, 2026 (9:00 AM - 10:00 AM)\",\"url\":null}', NULL, '2026-08-08 06:29:14', '2026-08-08 06:29:14'),
('b8e89f22-4a95-45bb-81c4-09635cbce6d7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 57, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 26, 2026 (1:00 PM - 2:30 PM)\",\"url\":null}', NULL, '2026-02-25 16:14:18', '2026-02-25 16:14:18'),
('b8ea1e0a-cf14-4e1c-9b3d-449d85bc18c3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Denture (Removable)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:29:06', '2026-08-12 16:30:28'),
('ba86a829-7299-4011-bf5d-93717cb7044a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Doctor Schedule Updated\",\"message\":\"Marieta Amancio is marked OFF on Aug 05, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-20 12:29:42', '2026-08-13 09:38:12', '2026-08-20 12:29:42'),
('bafca1cb-46ae-482d-a2b8-3c3106c81284', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-02 22:53:05', '2025-09-02 10:15:35', '2025-09-02 22:53:05'),
('bb5c99a6-5791-40c8-97f6-3c6db1534d1c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-11-11 06:20:58', '2025-10-31 17:45:02', '2025-11-11 06:20:58'),
('bbcedcaa-d36b-46dc-aa24-a3a444452632', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 28, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:47:14', '2026-08-13 12:51:15', '2026-08-26 17:47:14'),
('befb150c-3c1c-4e02-a2a3-f335f6bbeb0d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Simple Extraction\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:21:25', '2026-08-06 15:27:12'),
('bfc0804d-1814-426e-b60a-ec857243cf65', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Braces (Initial Placement)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:20', '2026-08-26 17:51:58'),
('c034094e-f828-40bc-b51e-b8dc52dd17be', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 65, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at San Jose Del Monte Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-01-18 13:59:23', '2026-01-18 13:59:23'),
('c0f8c690-e477-446c-a591-b5d3dd75da42', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on October 23, 2025 (9:00 AM - 9:15 AM)\",\"url\":null}', '2025-10-21 02:03:28', '2025-10-21 02:03:24', '2025-10-21 02:03:28'),
('c107a423-0c9d-4292-b3f3-20d59f0b20c7', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 70, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 13, 2026 (10:31 AM - 10:46 AM)\",\"url\":null}', NULL, '2026-02-13 09:35:17', '2026-02-13 09:35:17'),
('c1bb2458-eacd-4aec-bfd0-d0d8a451df4f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 14, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-26 17:49:31', '2026-08-13 12:56:47', '2026-08-26 17:49:31'),
('c1d9371c-c33c-4447-b938-37eeba82942e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to January 15, 2026 (11:00 AM - 11:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-13 02:25:17', '2026-01-16 01:00:58'),
('c384fd9b-0806-468e-8bb9-bd15f2b6e6eb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Root Canal Treatment\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:23:35', '2026-08-06 15:27:12'),
('c43fa279-5bea-450c-ae75-f941ddec9350', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Valentin, Celestine was moved from Aug 28, 2026 at 12:00 PM to Aug 28, 2026 at 1:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-20 12:29:42', '2026-08-13 12:53:54', '2026-08-20 12:29:42'),
('c460f848-fdcc-4b87-a3ce-12673502c44c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat, Sun.\",\"url\":\"\\/branch\"}', '2026-08-12 16:30:45', '2026-08-08 06:04:58', '2026-08-12 16:30:45'),
('c6b27e7b-b4a5-4781-b897-097bd92bb6dd', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 06:03:52', '2025-10-07 06:03:52'),
('c8e662c7-5c0e-4e42-947a-af9e86bd6fde', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 5:00 PM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:56:47', '2026-08-13 12:56:47'),
('cc79b9ce-51c8-45a8-bf10-4ff1b1751a4d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 84, '{\"title\":\"Emergency Appointment Recorded\",\"message\":\"Your emergency appointment at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM has been recorded.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-03 00:26:52', '2026-08-03 00:26:52'),
('ccb8ea29-0724-4e8b-afd7-e6fa595dfa7d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Simple Extraction\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:28:37', '2026-08-12 16:30:28'),
('ccde1715-fbf8-43e8-9401-441f290190bd', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 94, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-07-08 23:59:23', '2026-07-08 23:59:23'),
('cd80d1ae-a543-45e8-a7d1-b09bae49814b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 05:26:23', '2025-10-07 05:25:21', '2025-10-07 05:26:23'),
('cf26e54a-c731-46ba-8d1c-c1f45c2e99cc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 89, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', NULL, '2026-07-28 22:52:20', '2026-07-28 22:52:20'),
('cf8cb6f9-66f6-4d96-bd1b-4283b21438cb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 2, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-07-10 10:08:12', '2026-05-01 21:03:28', '2026-07-10 10:08:12'),
('d0061c8f-2e4a-4c01-acc7-d683c3a3ec0f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-03 13:48:01', '2026-08-03 13:47:37', '2026-08-03 13:48:01'),
('d128f31b-8c6c-4a4a-985e-5ebdaa5f9fac', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 1, 2026 (10:00 AM - 12:15 PM)\",\"url\":null}', '2026-07-20 16:31:51', '2026-05-01 18:01:07', '2026-07-20 16:31:51'),
('d14c5581-f576-4ee0-a4f3-5c860184a7e8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 44, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on November 17, 2025 (6:00 AM - 6:45 AM)\",\"url\":null}', NULL, '2025-11-14 06:06:18', '2025-11-14 06:06:18'),
('d17eb262-6ec6-49ba-97d1-9e2b4107aca9', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2025-08-28 22:18:38', '2025-08-28 22:18:24', '2025-08-28 22:18:38'),
('d1852a19-5d16-4214-9a3a-54e4ef052479', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 113, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 13, 2026 at 10:00 AM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-13 09:24:29', '2026-08-13 09:22:30', '2026-08-13 09:24:29'),
('d1d6302f-9fa8-48d6-8001-6db8c5fc5536', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Zarate, Joan was moved from Aug 12, 2026 at 5:00 PM to Aug 12, 2026 at 4:20 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/149\\/view\"}', '2026-08-12 16:18:15', '2026-08-12 16:12:15', '2026-08-12 16:18:15'),
('d2f7dba1-ccbb-42cf-8230-8a3b29395e44', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 95, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 20, 2026 at Prenza 1 Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', '2026-07-27 14:54:51', '2026-07-20 16:24:13', '2026-07-27 14:54:51'),
('d57e8e69-4656-4a7e-b910-12b6e4e9dff6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 113, '{\"title\":\"Booking Successfully Submitted\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 12:00 PM has been submitted and is waiting for approval.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:48:37', '2026-08-13 12:48:37'),
('d5b63e64-bf19-42e8-bff5-eb1c4961bc69', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Root Canal Treatment\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-03 13:45:09', '2026-08-03 13:44:38', '2026-08-03 13:45:09'),
('d76dbcb4-bc7f-480d-a0d3-ce2e1bf510cf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 33, '{\"title\":\"Medicine Marked as Expired\",\"message\":\"\\\"Antidote\\\" (Batch #36, qty 123) has been marked as expired.\",\"url\":\"https:\\/\\/dentaease.online\\/inventory\\/archived\"}', NULL, '2026-08-26 16:36:53', '2026-08-26 16:36:53'),
('d9a3df6e-f69a-480e-a726-a365e26dbb61', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient pAGOD NAKo, Ayuko na has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-06 15:41:41', '2026-08-06 15:41:31', '2026-08-06 15:41:41'),
('d9fe7b36-120e-4224-aa7f-06136f92ef0f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-03 00:16:26', '2026-07-30 18:10:32', '2026-08-03 00:16:26'),
('da4af703-be51-45d5-a965-655f6ca4634c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Wisdom Tooth Surgery\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:23:20', '2026-08-06 15:27:12'),
('da57d1b1-8877-4980-b09c-ad10c66730f0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 14, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-20 12:29:42', '2026-08-13 12:56:47', '2026-08-20 12:29:42'),
('daa942c2-bcc5-476c-865d-486d9d9e61be', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Oral Prophylaxis (Cleaning)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-06 15:27:12', '2026-08-05 19:21:46', '2026-08-06 15:27:12'),
('dddbbf75-c3ef-45c0-86a8-b2222e03ac4b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('df4a67ea-4310-4c45-bdb4-f0040cff7a40', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 4, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-07-10 10:08:12', '2026-05-01 22:02:01', '2026-07-10 10:08:12'),
('e08bf123-e77d-4b19-bc87-0442860bd68e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-03 14:14:30', '2026-08-03 13:47:37', '2026-08-03 14:14:30'),
('e0bd5f22-ae95-429b-8753-2d79f2c4686b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Valentin, Celestine booked an appointment on Aug 28, 2026 at 12:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-20 12:29:42', '2026-08-13 12:51:15', '2026-08-20 12:29:42'),
('e0fac739-f275-47a3-9aee-abf69dde3b4a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 79, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on March 2, 2026 (3:00 PM - 3:45 PM)\",\"url\":null}', NULL, '2026-03-01 21:13:11', '2026-03-01 21:13:11'),
('e1bffd79-e148-4a78-b30a-3a40dc1bedaf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Fixed Prosthesis (Bridge)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:45:12', '2026-08-26 17:51:58'),
('e38b84c4-9915-4fbc-9d46-64e346faf370', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Santa Maria Santiago-Amancio Branch schedule was updated. Hours: 9:00 PM - 11:00 PM. Open days: Mon, Tue, Wed, Thu, Fri, Sat.\",\"url\":\"\\/branch\"}', '2026-08-03 13:54:22', '2026-08-03 13:47:25', '2026-08-03 13:54:22'),
('e41bee49-ed13-4464-90f8-5617000c9341', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 81, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 9, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-03-09 10:16:17', '2026-03-09 10:15:18', '2026-03-09 10:16:17'),
('e45d8a10-68d8-4c79-8cc7-dab2fb29974c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-10-07 23:36:43', '2025-10-07 23:36:43'),
('e5347b4e-c5f7-45aa-8313-ce8c28283d3b', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Fixed Prosthesis (Bridge)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:29:31', '2026-08-12 16:30:28'),
('e58e52db-4a5f-4c8b-be1a-8d559b30c18c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Branch Schedule Updated\",\"message\":\"Prenza 1 Santiago-Amancio Branch schedule was updated. Hours: 9:00 AM - 6:00 PM. Open days: Mon, Tue, Wed, Thu, Fri.\",\"url\":\"\\/branch\"}', '2026-08-05 19:29:10', '2026-07-30 18:10:32', '2026-08-05 19:29:10'),
('e6b44a31-b263-4bdc-a602-290fef64d4d1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"New Appointment Booking\",\"message\":\"Zarate, Joan booked an appointment on Aug 12, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:33:15', '2026-08-12 16:02:31', '2026-08-12 16:33:15'),
('e7626199-8372-4979-a4a1-32415ab9e312', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 31, '{\"title\":\"Doctor Schedule Updated\",\"message\":\"Marieta Amancio is marked OFF on Aug 05, 2026.\",\"url\":\"https:\\/\\/dentaease.online\\/schedule\\/calendar\"}', '2026-08-26 17:47:14', '2026-08-13 09:38:12', '2026-08-26 17:47:14'),
('e78c7435-d6ee-4085-9236-21fdc6c69e95', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 21:49:18', '2025-10-07 06:46:45', '2025-10-07 21:49:18'),
('e932f707-abb7-47ad-8ac5-1c2793a93957', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Aug 03, 2026 at Santa Maria Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', '2026-08-12 16:34:23', '2026-08-05 02:04:51', '2026-08-12 16:34:23'),
('e96735fb-aa26-48fd-bc3e-31ce68548a6a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 5:00 PM has been cancelled by the clinic.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', NULL, '2026-08-13 12:57:13', '2026-08-13 12:57:13'),
('eb31867c-6a6f-4695-86c9-0ceafd18ac6e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 112, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on August 28, 2026 (12:00 PM - 12:15 PM)\",\"url\":null}', NULL, '2026-08-13 12:53:36', '2026-08-13 12:53:36'),
('ec3d87a4-688e-4f9a-a624-9dd9d03bba49', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Santa Maria Santiago-Amancio Branch to October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', NULL, '2026-01-13 02:47:23', '2026-01-13 02:47:23'),
('ee2a6eec-8d55-40cd-a3f2-e1baea59033c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"New Appointment Booking\",\"message\":\"Zarate, Joan booked an appointment on Aug 12, 2026 at 5:00 PM. It is pending approval.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments?status=pending\"}', '2026-08-12 16:30:45', '2026-08-12 16:02:31', '2026-08-12 16:30:45'),
('ef11ee08-b565-4881-9aa4-ed68fba54449', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Appointment Date\\/Time Changed\",\"message\":\"The appointment of Valentin, Celestine was moved from Aug 28, 2026 at 12:00 PM to Aug 28, 2026 at 1:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/153\\/view\"}', '2026-08-26 17:49:31', '2026-08-13 12:53:54', '2026-08-26 17:49:31'),
('ef36a10c-23a4-4444-a229-6f19bcc2ce7d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 103, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 28, 2026 at Prenza 1 Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', NULL, '2026-07-28 22:51:06', '2026-07-28 22:51:06'),
('f04d8897-35b3-4d0d-8a37-ffd19dfa0259', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 37, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Santa Maria Santiago-Amancio Branch to October 21, 2025 (9:30 PM - 10:15 PM)\",\"url\":null}', NULL, '2026-01-13 02:47:24', '2026-01-13 02:47:24');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('f1c46e7a-1c0b-4863-baf2-f16ece18031c', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 15, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-11 20:52:07', '2026-01-16 01:00:58'),
('f3364244-a982-4429-8c96-3ef4553307e3', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Jul 30, 2026 at 11:16 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/143\\/view\"}', '2026-08-05 19:29:10', '2026-07-30 23:16:42', '2026-08-05 19:29:10'),
('f3c9571f-b12d-4de2-a287-49fdd7161144', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 23, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-07-10 10:08:12', '2026-05-22 21:55:29', '2026-07-10 10:08:12'),
('f4a9d7c4-3cf2-46a3-8f0a-da2ce2d6730e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 32, '{\"title\":\"Appointment Cancelled\",\"message\":\"The appointment of Valentin, Celestine on Aug 14, 2026 at 5:00 PM was cancelled.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\"}', '2026-08-26 17:49:31', '2026-08-13 12:57:13', '2026-08-26 17:49:31'),
('f5d1b686-1790-492d-8d30-f954a3dd2746', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-10-07 21:49:18', '2025-10-07 21:47:57', '2025-10-07 21:49:18'),
('f68c3515-3ffa-4889-80e4-78b2cbeaf5b0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 38, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on February 5, 2026 (10:00 AM - 10:30 AM)\",\"url\":null}', NULL, '2026-02-25 16:21:11', '2026-02-25 16:21:11'),
('f75ac8c5-2410-4935-ada2-1be0ccc1044d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 34, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Villanueva, Adrian at Santa Maria Santiago-Amancio Branch on Aug 03, 2026 at 9:00 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/145\\/view\"}', '2026-08-03 13:40:33', '2026-08-03 00:26:52', '2026-08-03 13:40:33'),
('f791561b-bde8-4500-90b7-687f35868705', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 14, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', '2025-09-10 05:06:55', '2025-09-10 05:01:06', '2025-09-10 05:06:55'),
('f7bb6700-e48f-4fb3-9de5-ff66cc318c88', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Restoration (Filling)\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-26 17:51:58', '2026-08-26 17:44:39', '2026-08-26 17:51:58'),
('f891b580-cdd7-44b6-b1aa-ffde0f624132', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 106, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 28, 2026 at Lambakin Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', NULL, '2026-07-28 22:51:06', '2026-07-28 22:51:06'),
('fa1bdde1-b822-479f-8c12-23ac04eaed58', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 26, '{\"title\":\"\\ud83d\\udea8 Emergency Appointment Booked\",\"message\":\"An EMERGENCY appointment was booked for Fortune, Crystal at Prenza 1 Santiago-Amancio Branch on Jul 30, 2026 at 11:16 PM.\",\"url\":\"https:\\/\\/dentaease.online\\/appointments\\/143\\/view\"}', '2026-08-03 00:16:26', '2026-07-30 23:16:42', '2026-08-03 00:16:26'),
('faa6f750-7b44-4416-b94b-8da3a3c1a197', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 86, '{\"title\":\"Emergency Appointment Recorded\",\"message\":\"Your emergency appointment at Prenza 1 Santiago-Amancio Branch on Jul 30, 2026 at 11:16 PM has been recorded.\",\"url\":\"https:\\/\\/dentaease.online\\/bookingongoing\"}', '2026-08-03 12:58:53', '2026-07-30 23:16:42', '2026-08-03 12:58:53'),
('fb831b96-c344-4c6d-b9b0-fd7ce5088229', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Cancelled\",\"message\":\"Your appointment on Jul 22, 2026 at Prenza 1 Santiago-Amancio Branch was not approved in time and has been automatically cancelled. You may book a new appointment anytime.\",\"url\":null}', '2026-07-27 15:25:29', '2026-07-23 11:10:30', '2026-07-27 15:25:29'),
('fcc1d5c4-46f1-49f4-b1ad-b770f1271e16', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Patient Archived\",\"message\":\"Patient Zarate, Joan has been archived.\",\"url\":\"\\/patientaccount\"}', '2026-08-12 16:02:15', '2026-08-08 15:13:26', '2026-08-12 16:02:15'),
('fdfa5fd7-513e-4fb1-ba79-3196916cd0b4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 22, '{\"title\":\"Service Updated\",\"message\":\"The service \\\"Wisdom Tooth Surgery\\\" has been updated.\",\"url\":\"\\/services\"}', '2026-08-12 16:30:28', '2026-08-12 16:29:56', '2026-08-12 16:30:28'),
('fe3e6a81-3251-4ebf-b436-32b6de47fa35', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 60, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 19, 2026 (12:00 PM - 12:30 PM)\",\"url\":null}', NULL, '2026-01-31 18:11:13', '2026-01-31 18:11:13'),
('feb2bf22-740c-47e1-8a58-19de3295fc56', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on January 16, 2026 (11:00 AM - 11:15 AM)\",\"url\":null}', '2026-01-16 01:00:58', '2026-01-14 18:17:13', '2026-01-16 01:00:58'),
('ff032b7a-2646-4a52-8eda-bd61a3852c0f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (8:30 AM - 9:00 AM)\",\"url\":null}', NULL, '2025-11-24 16:18:47', '2025-11-24 16:18:47'),
('ff3855e5-f9b6-4e4c-b875-3cc2cec6421e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 83, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Lambakin Santiago-Amancio Branch on April 10, 2026 (3:00 PM - 3:45 PM)\",\"url\":null}', '2026-04-30 18:56:50', '2026-04-10 13:49:05', '2026-04-30 18:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `parent_child_links`
--

CREATE TABLE `parent_child_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_user_id` bigint(20) UNSIGNED NOT NULL,
  `child_user_id` bigint(20) UNSIGNED NOT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `verification_token` varchar(64) DEFAULT NULL,
  `token_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_child_links`
--

INSERT INTO `parent_child_links` (`id`, `parent_user_id`, `child_user_id`, `relationship`, `status`, `verification_token`, `token_expires_at`, `created_at`, `updated_at`) VALUES
(1, 88, 82, 'Partner', 'pending', 'wZvuvQpZpmVptN6DmAEJTXGevU6TgeOmVaxo7byu2eoKf2gC', '2026-05-06 15:25:29', '2026-05-04 15:25:29', '2026-05-04 15:25:29'),
(8, 86, 92, 'Sibling', 'active', NULL, NULL, '2026-07-02 16:01:30', '2026-07-02 16:01:30'),
(11, 95, 97, 'Sibling', 'active', NULL, NULL, '2026-07-08 22:23:18', '2026-07-08 22:23:18'),
(14, 103, 104, 'Sibling', 'active', NULL, NULL, '2026-07-27 15:54:04', '2026-07-27 15:54:04'),
(15, 105, 106, 'Grandparent', 'active', NULL, NULL, '2026-07-27 19:19:28', '2026-07-27 19:19:28'),
(16, 112, 113, 'Parent', 'active', NULL, NULL, '2026-08-13 09:21:17', '2026-08-13 09:21:17');

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
-- Table structure for table `patient_medications`
--

CREATE TABLE `patient_medications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_medications`
--

INSERT INTO `patient_medications` (`id`, `user_id`, `appointment_id`, `medicine_name`, `dosage`, `frequency`, `start_date`, `end_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 86, 119, 'Amoxicillin (MG)', NULL, '1x daily', '2026-07-11', '2026-07-12', '1, 1-0-0, 1 day', '2026-07-11 11:48:24', '2026-07-11 11:48:24'),
(2, 86, 129, 'Mefenamic Acid (pcs)', NULL, '1x daily', '2026-07-27', '2026-07-28', '1, Morning, 1 day', '2026-07-27 14:59:41', '2026-07-27 14:59:41'),
(3, 83, 131, 'Amoxicillin (pcs)', '500 mg cap', '3x daily', '2026-07-27', '2026-07-28', '3 tabs, Mor, lunch, and eve, 1day', '2026-07-27 15:29:27', '2026-08-26 17:08:46'),
(5, 84, 141, 'Mefenamic Acid (pcs)', NULL, '2x daily', '2026-07-30', '2026-08-13', '28 capsule, 1-0-1, 2 weeks', '2026-07-30 17:17:00', '2026-07-30 17:17:00'),
(6, 86, 143, 'Mefenamic Acid (pcs)', NULL, '2x daily', '2026-07-30', '2026-08-13', '14 tablet, 1-0-1, 2 weeks', '2026-07-30 23:18:42', '2026-07-30 23:18:42'),
(7, 90, 144, 'Paracetamol (pcs)', NULL, '1x daily', '2026-07-30', '2026-08-06', '7 capsule, morning, 1 week', '2026-07-30 23:25:54', '2026-07-30 23:25:54'),
(8, 111, 149, 'Mefenamic Acid (pcs)', NULL, '3x daily', '2026-08-12', '2026-08-15', '3, after lunch, for 3 days', '2026-08-12 16:16:23', '2026-08-12 16:16:23'),
(9, 113, 150, 'Mefenamic Acid (pcs)', NULL, '3x daily', '2026-08-13', '2026-08-14', '3 tablets, Morning, afternoon, evening, 1 day', '2026-08-13 09:32:08', '2026-08-13 09:32:08'),
(10, 113, 150, 'Amoxicillin (pcs)', NULL, '1x daily', '2026-08-13', '2026-08-14', '1 capsule, morning, 1 day', '2026-08-13 09:33:51', '2026-08-13 09:33:51'),
(13, 83, 155, 'Amoxicillin (mg capsule)', '500 mg cap', '3x daily', '2026-08-26', '2026-09-02', '21 capsules, , 6 am, 12 pm, & 6 pm, For 7 days', '2026-08-26 17:04:25', '2026-08-26 17:08:38'),
(14, 83, 155, 'Mefenamic Acid (mg capsule)', '500 mg cap', 'every 6 hours', '2026-08-26', '2026-08-31', '9 capsules, 1 cap , After lunch, For 3 to 5 consecutive days', '2026-08-26 17:05:26', '2026-08-26 17:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `patient_records`
--

CREATE TABLE `patient_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `home_no` varchar(255) DEFAULT NULL,
  `office_address` varchar(255) DEFAULT NULL,
  `office_no` varchar(255) DEFAULT NULL,
  `fax_no` varchar(255) DEFAULT NULL,
  `dental_insurance` varchar(255) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `parent_guardian_name` varchar(255) DEFAULT NULL,
  `parent_guardian_occupation` varchar(255) DEFAULT NULL,
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
  `allergic_lidocaine` tinyint(1) NOT NULL DEFAULT 0,
  `allergic_penicillin` tinyint(1) NOT NULL DEFAULT 0,
  `allergic_sulfa` tinyint(1) NOT NULL DEFAULT 0,
  `allergic_aspirin` tinyint(1) NOT NULL DEFAULT 0,
  `allergic_latex` tinyint(1) NOT NULL DEFAULT 0,
  `allergic_others` varchar(255) DEFAULT NULL,
  `bleeding_time` tinyint(1) NOT NULL DEFAULT 0,
  `pregnant` tinyint(1) NOT NULL DEFAULT 0,
  `nursing` tinyint(1) NOT NULL DEFAULT 0,
  `birth_control_pills` tinyint(1) NOT NULL DEFAULT 0,
  `blood_type` varchar(255) DEFAULT NULL,
  `blood_pressure` varchar(255) DEFAULT NULL,
  `profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  `health_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`health_conditions`)),
  `medical_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medical_conditions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_records`
--

INSERT INTO `patient_records` (`id`, `last_name`, `first_name`, `middle_name`, `nickname`, `birthdate`, `sex`, `nationality`, `religion`, `occupation`, `home_address`, `home_no`, `office_address`, `office_no`, `fax_no`, `dental_insurance`, `effective_date`, `parent_guardian_name`, `parent_guardian_occupation`, `contact_number`, `email`, `referred_by`, `reason_for_consultation`, `previous_dentist`, `last_dental_visit`, `physician_name`, `physician_specialty`, `physician_contact`, `in_good_health`, `under_treatment`, `had_illness_operation`, `hospitalized`, `taking_medication`, `allergic`, `allergic_lidocaine`, `allergic_penicillin`, `allergic_sulfa`, `allergic_aspirin`, `allergic_latex`, `allergic_others`, `bleeding_time`, `pregnant`, `nursing`, `birth_control_pills`, `blood_type`, `blood_pressure`, `profile_completed`, `health_conditions`, `medical_conditions`, `created_at`, `updated_at`, `user_id`) VALUES
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2025-09-02 09:58:05', '2025-09-02 09:58:05', 6),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2025-09-07 22:44:41', '2025-09-07 22:44:41', 8),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2025-10-19 00:34:52', '2025-10-19 00:34:52', 32),
(45, 'Diaz', 'Junjun', 'Bahil', NULL, '2001-10-28', NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', 'junichidiaz@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-04-10 13:49:49', '2026-05-01 20:45:42', 83),
(46, 'padilla', 'joshua', NULL, NULL, '2000-04-17', 'M', NULL, NULL, NULL, 'Apartment, 1234, Tibagan, Sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09454454744', 'andersonandy046@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, '[\"Hay Fever \\/ Allergies\"]', '2026-04-10 14:57:28', '2026-07-19 22:27:44', 82),
(47, 'Diaz', 'Elsie', 'Bahil', 'Els', '1969-02-14', 'F', 'Filipino', 'Roman Catholic', 'Office Worker - Supervisor', '1221, 507, Kakawate St. Camangyanan Santa Maria Bulacsn, Camangyanan, Sta. Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '095198459536', 'elsiediazbahil14@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 'A', '180/70', 1, NULL, '[\"High Blood Pressure\"]', '2026-05-01 20:37:44', '2026-05-01 20:39:34', 85),
(48, 'Mabini', 'Crystal', 'Laurel', 'Crys', '2002-03-08', 'F', 'Filipino', 'Roman Catholic', 'Book Writer', 'Corner of Jacinto Street, 91, Maligaya Street, Patubig, Marilao, Bulacan', '09648661081', NULL, '09515170014', NULL, NULL, NULL, NULL, NULL, '09708505234', 'crystalfortune0308@gmail.com', 'My Relatives', 'Checkup', 'Dr. Jaxine Valencia', '05/26/2016', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, '0+', '120/80', 1, NULL, '[\"High Blood Pressure\",\"Chest Pain\"]', '2026-05-01 20:41:14', '2026-07-30 11:51:28', 86),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-05-02 15:14:34', '2026-05-02 15:14:34', 30),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-05-04 15:02:00', '2026-05-04 15:02:00', 31),
(52, 'de leon', 'april jane', NULL, NULL, '2000-05-04', NULL, NULL, NULL, NULL, '634, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09454454744', 'padillajoshuaanderson.pdm@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-05-04 15:25:14', '2026-05-04 15:25:18', 88),
(54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-05-22 14:06:59', '2026-05-22 14:06:59', 26),
(55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-05-22 15:53:56', '2026-05-22 15:53:56', 22),
(56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-07-02 08:37:50', '2026-07-02 08:37:50', 33),
(58, 'Mendoza', 'Caleb', 'Jacob', NULL, '2026-07-02', NULL, NULL, NULL, NULL, 'Corner of Jacinto Street, 91, Maligaya Street, Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09708505234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-02 16:01:56', '2026-07-02 16:02:02', 92),
(59, 'Zarate', 'Jayvee', 'Caluag', NULL, '2016-03-06', NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-02 16:21:22', '2026-07-02 16:21:41', 93),
(60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-07-02 17:09:24', '2026-07-02 17:09:24', 84),
(61, 'Zarate', 'Jayvee', 'Caluag', NULL, '2016-06-03', NULL, NULL, NULL, NULL, 'Ph3 blk4 lot 7, Estrella Homes, Sta rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-06 15:42:34', '2026-07-06 15:42:39', 94),
(62, 'Laurent', 'Kael', 'Evren', 'Kael', '2008-09-14', 'M', 'Filipino', 'Catholic', 'Student', '#118, Maple Grove Street, Lias, Marilao, Bulacan', 'N/A', NULL, 'N/A', 'N/A', 'N/A', NULL, 'Lory Dela Cruz', 'Business woman', '09949499451', 'laurentkael44@gmail.com', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-08 17:29:47', '2026-07-08 17:32:38', 95),
(63, 'Kita', 'Mahal', NULL, NULL, '2026-07-09', NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-09 01:03:13', '2026-07-09 01:03:18', 98),
(64, '456', '123', NULL, NULL, '2026-07-09', NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-09 01:16:41', '2026-07-09 01:16:57', 99),
(65, 'pAGOD NAKo', 'Ayuko na', NULL, NULL, '2026-07-01', NULL, NULL, NULL, NULL, '8, 3, 4, 5, 6, 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09610812705', 'cjbarora@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-09 01:57:32', '2026-07-09 01:57:39', 100),
(66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-07-16 19:42:09', '2026-07-16 19:42:09', 101),
(67, 'Gatchalian', 'Margaux', 'Santiago', NULL, '2017-12-25', NULL, NULL, NULL, NULL, '109, M. Vill, Prenza, Marilao, Bul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0999123456', 'sophiaamanciostudent@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-27 15:51:42', '2026-07-27 15:52:13', 103),
(68, 'Santiago', 'Gabriel', NULL, NULL, '2019-07-27', NULL, NULL, NULL, NULL, '109, M. Vill, Prenza, Marilao, Bul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0999123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-27 15:54:20', '2026-07-27 15:54:26', 104),
(69, 'Antonio', 'Sophia', 'Caguiat', NULL, '2006-11-05', NULL, NULL, NULL, NULL, 'Blk 12 lot 24, Dela Roas, Lambakin, Marilao, Bulcan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09555964740', 'sherry1927antonio@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-27 19:10:26', '2026-07-27 19:11:21', 105),
(70, 'Gutierrez', 'Gabriel', 'Caguiat', NULL, '2010-11-27', NULL, NULL, NULL, NULL, 'Blk 12 lot 24, Dela Roas, Lambakin, Marilao, Bulcan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09555964740', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-27 19:19:49', '2026-07-27 19:19:56', 106),
(71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-07-30 17:54:04', '2026-07-30 17:54:04', 97),
(72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-07-30 23:22:12', '2026-07-30 23:22:12', 90),
(73, 'Serapio', 'John Peter', 'Caluag', NULL, '1996-10-27', NULL, NULL, NULL, NULL, 'Ph3 blk4 lot 7, None, Sta Rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09208815520', 'peterserapio27@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-08-08 13:18:27', '2026-08-08 13:18:32', 110),
(74, 'Zarate', 'Joan', 'Caluag', NULL, '2004-01-28', NULL, NULL, NULL, NULL, 'Ph3 blk4 lot 7, Estrella Homes, Sta rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09612709883', 'joancaluag.28@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-08-12 16:01:01', '2026-08-12 16:01:10', 111),
(75, 'Valentin', 'Celestine', NULL, NULL, '2000-07-23', NULL, NULL, NULL, NULL, '91, Maligaya, Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0970850534', 'celestinevalentin0813@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-08-13 09:18:52', '2026-08-13 09:19:01', 112),
(76, 'Mabini', 'Crystal', NULL, NULL, '2026-08-13', NULL, NULL, NULL, NULL, '91, Maligaya, Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0970850534', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-08-13 09:21:39', '2026-08-13 09:21:44', 113);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_given` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(30) DEFAULT NULL,
  `status` enum('pending','completed','void') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `store_id`, `user_id`, `patient_id`, `appointment_id`, `total_amount`, `amount_given`, `change_amount`, `payment_method`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(23, 2, 30, NULL, NULL, 21.00, 21.00, 0.00, 'cash', 'completed', NULL, '2026-05-02 15:20:59', '2026-05-02 15:20:59'),
(24, 1, 31, 83, NULL, 21.00, 21.00, 0.00, 'cash', 'completed', NULL, '2026-05-04 15:04:09', '2026-05-04 15:04:09'),
(25, 4, 30, NULL, NULL, 50.00, 50.00, 0.00, 'cash', 'completed', NULL, '2026-05-04 20:05:39', '2026-05-04 20:05:39'),
(26, 1, 26, 83, NULL, 45.00, 49.99, 4.99, 'cash', 'completed', NULL, '2026-07-02 08:42:27', '2026-07-02 08:42:27'),
(27, 2, 30, 83, NULL, 3014.00, 3020.00, 6.00, 'cash', 'completed', NULL, '2026-07-06 15:52:18', '2026-07-06 15:52:18'),
(28, 3, 31, NULL, NULL, 93.00, 100.00, 7.00, 'cash', 'completed', NULL, '2026-07-08 21:24:57', '2026-07-08 21:24:57'),
(29, 3, 26, 86, NULL, 24.00, 30.00, 6.00, 'cash', 'completed', NULL, '2026-07-08 22:32:02', '2026-07-08 22:32:02'),
(30, 1, 26, 86, NULL, 5.00, NULL, NULL, 'cash', 'completed', NULL, '2026-07-08 23:52:33', '2026-07-08 23:52:33'),
(31, 1, 26, 86, NULL, 5.00, 10.00, 5.00, 'cash', 'completed', NULL, '2026-07-08 23:52:51', '2026-07-08 23:52:51'),
(32, 1, 26, 83, NULL, 12.00, 15.00, 3.00, 'gcash', 'completed', NULL, '2026-07-09 14:09:19', '2026-07-09 14:09:19'),
(33, 1, 26, 88, NULL, 12.00, 20.00, 8.00, 'cash', 'completed', NULL, '2026-07-09 14:14:30', '2026-07-09 14:14:30'),
(34, 1, 26, 94, NULL, 45.00, 50.00, 5.00, 'cash', 'completed', NULL, '2026-07-09 17:02:06', '2026-07-09 17:02:06'),
(35, 1, 26, 86, NULL, 19.00, 20.00, 1.00, 'cash', 'completed', NULL, '2026-07-11 11:47:27', '2026-07-11 11:47:27'),
(36, 1, 26, 86, NULL, 74.00, 100.00, 26.00, 'cash', 'completed', NULL, '2026-07-11 11:51:18', '2026-07-11 11:51:18'),
(37, 1, 26, NULL, NULL, 53.00, 60.00, 7.00, 'cash', 'completed', NULL, '2026-07-11 12:02:13', '2026-07-11 12:02:13'),
(38, 2, 33, 86, NULL, 20.00, 50.00, 30.00, 'cash', 'completed', NULL, '2026-07-19 11:00:29', '2026-07-19 11:00:29'),
(39, 1, 26, 97, NULL, 25.00, 50.00, 25.00, 'cash', 'completed', NULL, '2026-07-20 02:34:11', '2026-07-20 02:34:11'),
(40, 1, 22, 95, NULL, 360.00, 500.00, 140.00, 'cash', 'completed', NULL, '2026-07-20 02:52:38', '2026-07-20 02:52:38'),
(41, 1, 26, 83, NULL, 15.00, 20.00, 5.00, 'cash', 'completed', NULL, '2026-07-27 15:30:40', '2026-07-27 15:30:40'),
(42, 2, 33, 83, NULL, 8.00, 10.00, 2.00, 'cash', 'completed', NULL, '2026-07-27 18:10:44', '2026-07-27 18:10:44'),
(43, 2, 33, 83, NULL, 25.00, 20.00, 0.00, 'cash', 'completed', NULL, '2026-07-27 18:11:13', '2026-07-27 18:11:13'),
(44, 2, 33, 83, NULL, 105.00, 200.00, 95.00, 'cash', 'completed', NULL, '2026-07-27 19:26:22', '2026-07-27 19:26:22'),
(45, 2, 33, NULL, NULL, 10.00, 20.00, 10.00, 'cash', 'completed', NULL, '2026-07-27 19:33:46', '2026-07-27 19:33:46'),
(46, 2, 30, 95, NULL, 8.00, 10.00, 2.00, 'cash', 'completed', NULL, '2026-07-27 20:00:17', '2026-07-27 20:00:17'),
(47, 2, 33, 86, NULL, 25.00, 50.00, 25.00, 'cash', 'completed', NULL, '2026-07-27 23:58:00', '2026-07-27 23:58:00'),
(48, 1, 26, NULL, NULL, 70.00, 100.00, 30.00, 'cash', 'completed', NULL, '2026-07-28 00:16:05', '2026-07-28 00:16:05'),
(49, 2, 33, NULL, NULL, 21.00, 19.00, 0.00, 'cash', 'completed', NULL, '2026-07-29 02:47:43', '2026-07-29 02:47:43'),
(50, 2, 33, NULL, NULL, 240.00, 200.00, 0.00, 'cash', 'completed', NULL, '2026-07-29 02:48:16', '2026-07-29 02:48:16'),
(51, 1, 26, NULL, NULL, 38.00, 50.00, 12.00, 'cash', 'completed', NULL, '2026-07-30 17:21:41', '2026-07-30 17:21:41'),
(52, 1, 26, 84, NULL, 500.00, 1000.00, 500.00, 'cash', 'completed', NULL, '2026-07-30 17:26:19', '2026-07-30 17:26:19'),
(53, 1, 26, 86, NULL, 112.00, 150.00, 38.00, 'cash', 'completed', NULL, '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(54, 1, 26, 86, NULL, 12.00, 50.00, 38.00, 'cash', 'completed', NULL, '2026-07-30 23:19:48', '2026-07-30 23:19:48'),
(55, 1, 26, 86, NULL, 105.00, 200.00, 95.00, 'cash', 'completed', NULL, '2026-07-30 23:20:36', '2026-07-30 23:20:36'),
(56, 1, 26, 90, NULL, 19.00, 20.00, 1.00, 'gcash', 'completed', NULL, '2026-07-30 23:22:56', '2026-07-30 23:22:56'),
(57, 1, 26, NULL, NULL, 100.00, 100.00, 0.00, 'cash', 'completed', NULL, '2026-08-03 00:10:15', '2026-08-03 00:10:15'),
(58, 3, 26, NULL, NULL, 25.00, 50.00, 25.00, 'cash', 'completed', NULL, '2026-08-03 00:21:35', '2026-08-03 00:21:35'),
(59, 3, 26, NULL, NULL, 1000.00, 1000.00, 0.00, 'cash', 'completed', NULL, '2026-08-03 14:12:16', '2026-08-03 14:12:16'),
(60, 3, 26, 97, NULL, 1000.00, 1000.00, 0.00, 'cash', 'completed', NULL, '2026-08-03 14:13:42', '2026-08-03 14:13:42'),
(61, 3, 26, NULL, NULL, 28.00, 50.00, 22.00, 'cash', 'completed', NULL, '2026-08-05 14:51:42', '2026-08-05 14:51:42'),
(62, 1, 31, 111, 149, 10.00, 10.00, 0.00, 'cash', 'completed', NULL, '2026-08-12 16:16:57', '2026-08-12 16:16:57'),
(63, 1, 26, 113, 150, 7.00, 10.00, 3.00, 'cash', 'completed', NULL, '2026-08-13 09:33:18', '2026-08-13 09:33:18'),
(64, 1, 26, 83, 155, 297.00, 300.00, 3.00, 'cash', 'completed', NULL, '2026-08-26 17:06:01', '2026-08-26 17:06:01'),
(65, 4, 30, NULL, NULL, 78.00, 500.00, 422.00, 'cash', 'completed', NULL, '2026-08-26 18:00:37', '2026-08-26 18:00:37');

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
(26, 23, 2, 2, 3, 7.00, 21.00, '2026-05-02 15:20:59', '2026-05-02 15:20:59'),
(27, 24, 2, 9, 3, 7.00, 21.00, '2026-05-04 15:04:09', '2026-05-04 15:04:09'),
(28, 25, 1, 15, 10, 5.00, 50.00, '2026-05-04 20:05:39', '2026-05-04 20:05:39'),
(29, 26, 1, 8, 9, 5.00, 45.00, '2026-07-02 08:42:27', '2026-07-02 08:42:27'),
(30, 27, 2, 21, 2, 7.00, 14.00, '2026-07-06 15:52:18', '2026-07-06 15:52:18'),
(31, 27, 8, 29, 3, 1000.00, 3000.00, '2026-07-06 15:52:18', '2026-07-06 15:52:18'),
(32, 28, 3, 22, 6, 5.00, 30.00, '2026-07-08 21:24:57', '2026-07-08 21:24:57'),
(33, 28, 2, 24, 9, 7.00, 63.00, '2026-07-08 21:24:57', '2026-07-08 21:24:57'),
(34, 29, 3, 22, 2, 5.00, 10.00, '2026-07-08 22:32:02', '2026-07-08 22:32:02'),
(35, 29, 2, 24, 2, 7.00, 14.00, '2026-07-08 22:32:02', '2026-07-08 22:32:02'),
(36, 30, 1, 7, 1, 5.00, 5.00, '2026-07-08 23:52:33', '2026-07-08 23:52:33'),
(37, 31, 1, 7, 1, 5.00, 5.00, '2026-07-08 23:52:51', '2026-07-08 23:52:51'),
(38, 32, 2, 30, 1, 7.00, 7.00, '2026-07-09 14:09:19', '2026-07-09 14:09:19'),
(39, 32, 1, 7, 1, 5.00, 5.00, '2026-07-09 14:09:19', '2026-07-09 14:09:19'),
(40, 33, 1, 8, 1, 5.00, 5.00, '2026-07-09 14:14:30', '2026-07-09 14:14:30'),
(41, 33, 2, 30, 1, 7.00, 7.00, '2026-07-09 14:14:30', '2026-07-09 14:14:30'),
(42, 34, 1, 8, 9, 5.00, 45.00, '2026-07-09 17:02:06', '2026-07-09 17:02:06'),
(43, 35, 2, 30, 2, 7.00, 14.00, '2026-07-11 11:47:27', '2026-07-11 11:47:27'),
(44, 35, 1, 8, 1, 5.00, 5.00, '2026-07-11 11:47:27', '2026-07-11 11:47:27'),
(45, 36, 2, 30, 7, 7.00, 49.00, '2026-07-11 11:51:18', '2026-07-11 11:51:18'),
(46, 36, 1, 8, 5, 5.00, 25.00, '2026-07-11 11:51:18', '2026-07-11 11:51:18'),
(47, 37, 2, 30, 4, 7.00, 28.00, '2026-07-11 12:02:13', '2026-07-11 12:02:13'),
(48, 37, 1, 28, 5, 5.00, 25.00, '2026-07-11 12:02:13', '2026-07-11 12:02:13'),
(49, 38, 11, 17, 5, 4.00, 20.00, '2026-07-19 11:00:29', '2026-07-19 11:00:29'),
(50, 39, 1, 28, 5, 5.00, 25.00, '2026-07-20 02:34:11', '2026-07-20 02:34:11'),
(51, 40, 13, 31, 20, 18.00, 360.00, '2026-07-20 02:52:38', '2026-07-20 02:52:38'),
(52, 41, 1, 28, 3, 5.00, 15.00, '2026-07-27 15:30:40', '2026-07-27 15:30:40'),
(53, 42, 11, 17, 2, 4.00, 8.00, '2026-07-27 18:10:44', '2026-07-27 18:10:44'),
(54, 43, 1, 19, 5, 5.00, 25.00, '2026-07-27 18:11:13', '2026-07-27 18:11:13'),
(55, 44, 2, 21, 15, 7.00, 105.00, '2026-07-27 19:26:22', '2026-07-27 19:26:22'),
(56, 45, 1, 19, 2, 5.00, 10.00, '2026-07-27 19:33:46', '2026-07-27 19:33:46'),
(57, 46, 11, 17, 2, 4.00, 8.00, '2026-07-27 20:00:17', '2026-07-27 20:00:17'),
(58, 47, 1, 19, 5, 5.00, 25.00, '2026-07-27 23:58:00', '2026-07-27 23:58:00'),
(59, 48, 2, 30, 10, 7.00, 70.00, '2026-07-28 00:16:05', '2026-07-28 00:16:05'),
(60, 49, 2, 21, 3, 7.00, 21.00, '2026-07-29 02:47:43', '2026-07-29 02:47:43'),
(61, 50, 8, 29, 2, 120.00, 240.00, '2026-07-29 02:48:16', '2026-07-29 02:48:16'),
(62, 51, 2, 30, 4, 7.00, 28.00, '2026-07-30 17:21:41', '2026-07-30 17:21:41'),
(63, 51, 1, 28, 2, 5.00, 10.00, '2026-07-30 17:21:41', '2026-07-30 17:21:41'),
(64, 52, 19, 38, 5, 100.00, 500.00, '2026-07-30 17:26:19', '2026-07-30 17:26:19'),
(65, 53, 2, 30, 1, 7.00, 7.00, '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(66, 53, 1, 8, 1, 5.00, 5.00, '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(67, 53, 19, 38, 1, 100.00, 100.00, '2026-07-30 23:14:19', '2026-07-30 23:14:19'),
(68, 54, 1, 28, 1, 5.00, 5.00, '2026-07-30 23:19:48', '2026-07-30 23:19:48'),
(69, 54, 2, 9, 1, 7.00, 7.00, '2026-07-30 23:19:48', '2026-07-30 23:19:48'),
(70, 55, 19, 38, 1, 100.00, 100.00, '2026-07-30 23:20:36', '2026-07-30 23:20:36'),
(71, 55, 1, 28, 1, 5.00, 5.00, '2026-07-30 23:20:36', '2026-07-30 23:20:36'),
(72, 56, 1, 28, 1, 5.00, 5.00, '2026-07-30 23:22:56', '2026-07-30 23:22:56'),
(73, 56, 2, 9, 2, 7.00, 14.00, '2026-07-30 23:22:56', '2026-07-30 23:22:56'),
(74, 57, 19, 38, 1, 100.00, 100.00, '2026-08-03 00:10:15', '2026-08-03 00:10:15'),
(75, 58, 3, 22, 5, 5.00, 25.00, '2026-08-03 00:21:35', '2026-08-03 00:21:35'),
(76, 59, 4, 23, 1, 1000.00, 1000.00, '2026-08-03 14:12:16', '2026-08-03 14:12:16'),
(77, 60, 4, 23, 1, 1000.00, 1000.00, '2026-08-03 14:13:42', '2026-08-03 14:13:42'),
(78, 61, 2, 24, 4, 7.00, 28.00, '2026-08-05 14:51:42', '2026-08-05 14:51:42'),
(79, 62, 1, 28, 2, 5.00, 10.00, '2026-08-12 16:16:57', '2026-08-12 16:16:57'),
(80, 63, 2, 9, 1, 7.00, 7.00, '2026-08-13 09:33:18', '2026-08-13 09:33:18'),
(81, 64, 1, 44, 9, 12.00, 108.00, '2026-08-26 17:06:01', '2026-08-26 17:06:01'),
(82, 64, 2, 45, 21, 9.00, 189.00, '2026-08-26 17:06:01', '2026-08-26 17:06:01'),
(83, 65, 1, 39, 5, 12.00, 60.00, '2026-08-26 18:00:37', '2026-08-26 18:00:37'),
(84, 65, 2, 40, 2, 9.00, 18.00, '2026-08-26 18:00:37', '2026-08-26 18:00:37');

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
(1, 'Simple Extraction', 'Oral Surgery', 15, 500.00, 'Removal of a tooth that is loose or damaged.', 'service_6a8eb712cc5f6.jpg', '2025-08-28 04:25:32', '2026-08-26 17:51:14'),
(2, 'Oral Prophylaxis (Cleaning)', 'General Dentistry', 30, 500.00, 'Professional cleaning to remove plaque and tartar.', 'service_6a8eb57f12303.jpeg', '2025-08-28 04:29:04', '2026-08-26 17:44:31'),
(3, 'Restoration (Filling)', 'General Dentistry', 30, 1000.00, 'Filling a cavity or repairing minor tooth damage.', 'service_6a8eb5874363d.jpg', '2025-08-28 04:29:42', '2026-08-26 17:44:39'),
(4, 'Denture (Removable)', 'General Dentistry', 30, 20000.00, 'Replacement of missing teeth with a removable appliance.', 'service_6a8eb59901e53.jpg', '2025-08-28 04:31:06', '2026-08-26 17:44:57'),
(5, 'Jacket Crown (Front Tooth)', 'General Dentistry', 45, 2000.00, 'A tooth-shaped cap to restore strength and appearance.', 'service_6a8eb59f7c88b.webp', '2025-08-28 04:32:06', '2026-08-26 17:45:03'),
(6, 'Fixed Prosthesis (Bridge)', 'General Dentistry', 45, 6000.00, 'A fixed replacement for one or more missing teeth.', 'service_6a8eb5a8086c6.webp', '2025-08-28 04:32:33', '2026-08-26 17:45:12'),
(7, 'Braces (Initial Placement)', 'Orthodontics', 120, 40000.00, 'Devices to straighten teeth and improve bite alignment.', 'service_6a8eb5b063d0f.jpg', '2025-08-28 04:33:35', '2026-08-26 17:45:20'),
(8, 'Wisdom Tooth Surgery', 'Oral Surgery', 90, 5000.00, 'Surgical removal of impacted or problematic wisdom teeth.', 'service_6a8eb5b8d6b6d.webp', '2025-08-28 04:34:30', '2026-08-26 17:45:28'),
(9, 'Root Canal Treatment', 'General Dentistry', 120, 6000.00, 'Cleaning and sealing of tooth roots to save damaged teeth.', 'service_6a8eb5c1246a1.jpg', '2025-08-28 04:36:13', '2026-08-26 17:45:37'),
(11, 'Dental Check-up', 'General Dentistry', 10, 0.00, 'is a preventive oral healthcare service that involves the examination of the teeth, gums, and overall mouth condition by a licensed dentist.', 'service_6a8eb5c9952bb.jpg', '2026-05-22 15:54:59', '2026-08-26 17:45:45');

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
('1sVN2FNRiLM5CbI06SxlKIiMXu0iWaxWQjUZLPFV', NULL, '2a02:4780:a:c0de::fac6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/136.0.7103.25 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidndpczZQSjhkUG1hdzJDMzNrNmNpMkcxMkxVaEFWcTZKcWU0NG5waSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODk6Imh0dHBzOi8vc3RlZWxibHVlLWZseS04MzI3NzkuaG9zdGluZ2Vyc2l0ZS5jb20vc3RvcmFnZS9wcm9maWxlX3BpY3R1cmVzLzZhN2MyZmQ2MDkxNWMuanBnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787737465),
('71UV6DM6NhST4qNXpXK3Fy4eGi04UhYYBUF0qhko', NULL, '2a02:4780:a:c0de::fac8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.7632.6 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXV2MWhpVmNvNnNJNzhZTWVoM2luOGJqdzVucnFXTVVWMnh1VEdpVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODk6Imh0dHBzOi8vc3RlZWxibHVlLWZseS04MzI3NzkuaG9zdGluZ2Vyc2l0ZS5jb20vc3RvcmFnZS9wcm9maWxlX3BpY3R1cmVzLzZhN2MyZjg1ODA5M2MuanBnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787737289),
('DaTQoLUgbV7S5vFvHBUz2wsFaoUND5WaUQK2ZmxY', NULL, '2a02:4780:a:c0de::fac5', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/136.0.7103.25 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1RPZUo3UkxGNURMd0doYVk4dERUSjQxSUxUZ3ptdUw2OWZiSXZUVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODk6Imh0dHBzOi8vc3RlZWxibHVlLWZseS04MzI3NzkuaG9zdGluZ2Vyc2l0ZS5jb20vc3RvcmFnZS9wcm9maWxlX3BpY3R1cmVzLzZhOGViNjhiZTFkYjQuanBnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787738298),
('G0KI4ZptTiNSDMKdGmUOz0UF4Khgo7btbirQQrfq', 30, '136.158.63.149', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSEVzeENYNm1ST2RFaG5VTTc5N1N2UjVtbXlib3NCaGtsazZMaURiayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZS9zdG9yYWdlL3Byb2ZpbGVfcGljdHVyZXMvNmE4ZWI2NTcyYjM2MC5qcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE2OiJhY3RpdmVfYnJhbmNoX2lkIjtzOjE6IjQiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMwO30=', 1787738448),
('j9AMwMxah4dS25b6IvDV1lXkF6G422Gey6A3zERj', NULL, '2a02:4780:a:c0de::fac4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/140.0.7339.16 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjdpbjk5QjA2Um91TmpySmQ1aGkyZTg3VEtiRFprRkthcTlud2dGcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODk6Imh0dHBzOi8vc3RlZWxibHVlLWZseS04MzI3NzkuaG9zdGluZ2Vyc2l0ZS5jb20vc3RvcmFnZS9wcm9maWxlX3BpY3R1cmVzLzZhOGViNmE4YzYzNjAuanBnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787738084),
('qPVGxcLi9I8JiIyxdpQkts22hTAYMyZTP7cbCbX5', NULL, '138.252.131.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidkpQNGYyRUpLOHNoM1RFekk5emVpVHlTTHVFdlcwaDE0TVl2VXo3QiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI0OiJodHRwczovL2RlbnRhZWFzZS5vbmxpbmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE2OiJhY3RpdmVfYnJhbmNoX2lkIjtzOjU6ImFkbWluIjt9', 1787737925),
('sRMyBtuylhlBy3gnrxOaGhHU6KzCEl4XgmOPPWmg', NULL, '88.201.241.104', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2951.85 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT281ZkdWcDZ1S3Z0b3VnbFBISHFVN1NnZU9vQXdGaVJhbXBUM05PcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZS9zaWdudXB1aSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1787733720),
('Tr8HM1QrzJYqhK4ZwWYVIVgkD9ZXEVXe71SVcpgB', NULL, '9.142.181.97', 'Mozilla/5.0 (compatible; crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjJYbzRoODVFS1pmTUhyNmNxRloxWFhJQWh0dkYxR2hsamdoaEl4NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHBzOi8vZGVudGFlYXNlLm9ubGluZS9zdG9yYWdlL3Byb2ZpbGVfcGljdHVyZXMvNmE3MzFkZDkwNTQxNC5qcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1787735831);

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `recipient` varchar(255) DEFAULT NULL,
  `raw_number` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `channel` varchar(255) NOT NULL DEFAULT 'messages',
  `status` varchar(255) NOT NULL,
  `error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `purpose`, `recipient`, `raw_number`, `message`, `channel`, `status`, `error`, `created_at`, `updated_at`) VALUES
(1, 'password_reset_otp', '639708505234', '09708505234', 'DentalEase: Your password reset code is {otp}. Valid for 10 minutes. Do not share this code with anyone.', 'otp', 'failed', '[{\"senderName\":\"The senderName supplied is not valid\"}]', '2026-07-30 17:42:48', '2026-07-30 17:42:48'),
(2, 'appointment_confirmed', '639183239884', '09183239884', 'DentalEase: Hi Adrian, your appointment at Prenza 1 Santiago-Amancio Branch is CONFIRMED on Aug 3, 2026, 10:00 AM - 10:15 AM. Please arrive 10 minutes early.', 'messages', 'failed', '[{\"senderName\":\"The senderName supplied is not valid\"}]', '2026-07-30 23:22:09', '2026-07-30 23:22:09'),
(3, 'appointment_booked', '639610812705', '09610812705', 'DentalEase: Hi Junjun, your appointment request at Santa Maria Santiago-Amancio Branch on Aug 3, 2026 at 9:00 PM has been received. Please wait for the clinic to confirm.', 'messages', 'failed', '[{\"senderName\":\"The senderName supplied is not valid\"}]', '2026-08-03 13:46:43', '2026-08-03 13:46:43'),
(4, 'appointment_booked', '639454454744', '09454454744', 'DentalEase: Hi joshua, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 8, 2026 at 9:00 AM has been received. Please wait for the clinic to confirm.', 'messages', 'sent', NULL, '2026-08-08 06:05:43', '2026-08-08 06:05:43'),
(5, 'appointment_confirmed', '639454454744', '09454454744', 'Hi joshua, your appointment at Prenza 1 Santiago-Amancio Branch is CONFIRMED on Aug 8, 2026, 9:00 AM - 10:00 AM. Please arrive 10 minutes early.', 'messages', 'sent', NULL, '2026-08-08 06:29:14', '2026-08-08 06:29:14'),
(6, 'signup_otp', '639208815520', '09208815520', 'Your verification code is {otp}. Do not share this code with anyone.', 'otp', 'sent', NULL, '2026-08-08 13:07:10', '2026-08-08 13:07:10'),
(7, 'signup_otp', '639612709883', '09612709883', 'Your verification code is {otp}. Do not share this code with anyone.', 'otp', 'sent', NULL, '2026-08-12 16:00:01', '2026-08-12 16:00:01'),
(8, 'appointment_booked', '639612709883', '09612709883', 'Hi Joan, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 12, 2026 at 5:00 PM has been received. Please wait for the clinic to confirm.', 'messages', 'sent', NULL, '2026-08-12 16:02:31', '2026-08-12 16:02:31'),
(9, 'appointment_confirmed', '639612709883', '09612709883', 'Hi Joan, your appointment at Prenza 1 Santiago-Amancio Branch is CONFIRMED on Aug 12, 2026, 5:00 PM - 5:15 PM. Please arrive 10 minutes early.', 'messages', 'sent', NULL, '2026-08-12 16:11:48', '2026-08-12 16:11:48'),
(10, 'password_reset_otp', '639612709883', '09612709883', 'Your password reset code is {otp}. Valid for 10 minutes. Do not share this code with anyone.', 'otp', 'sent', NULL, '2026-08-12 16:41:00', '2026-08-12 16:41:00'),
(11, 'signup_otp', NULL, '0970850534', 'Your verification code is {otp}. Do not share this code with anyone.', 'otp', 'failed', 'Invalid PH mobile number: 0970850534', '2026-08-13 09:17:33', '2026-08-13 09:17:33'),
(12, 'appointment_booked', NULL, '0970850534', 'Hi Crystal, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 13, 2026 at 10:00 AM has been received. Please wait for the clinic to confirm.', 'messages', 'failed', 'Invalid PH mobile number: 0970850534', '2026-08-13 09:22:30', '2026-08-13 09:22:30'),
(13, 'appointment_booked', NULL, '0970850534', 'Hi Crystal, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 12:00 PM has been received. Please wait for the clinic to confirm.', 'messages', 'failed', 'Invalid PH mobile number: 0970850534', '2026-08-13 12:48:37', '2026-08-13 12:48:37'),
(14, 'appointment_booked', '639708505234', '09708505234', 'Hi Celestine, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 28, 2026 at 12:00 PM has been received. Please wait for the clinic to confirm.', 'messages', 'sent', NULL, '2026-08-13 12:51:15', '2026-08-13 12:51:15'),
(15, 'appointment_confirmed', '639708505234', '09708505234', 'Hi Celestine, your appointment at Prenza 1 Santiago-Amancio Branch is CONFIRMED on Aug 28, 2026, 12:00 PM - 12:15 PM. Please arrive 10 minutes early.', 'messages', 'sent', NULL, '2026-08-13 12:53:37', '2026-08-13 12:53:37'),
(16, 'appointment_booked', '639708505234', '09708505234', 'Hi Celestine, your appointment request at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 5:00 PM has been received. Please wait for the clinic to confirm.', 'messages', 'sent', NULL, '2026-08-13 12:56:47', '2026-08-13 12:56:47'),
(17, 'appointment_cancelled', '639708505234', '09708505234', 'Hi Celestine, your appointment at Prenza 1 Santiago-Amancio Branch on Aug 14, 2026 at 5:00 PM has been CANCELLED. You may book again anytime.', 'messages', 'sent', NULL, '2026-08-13 12:57:13', '2026-08-13 12:57:13');

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
(1, 'Prenza 1 Santiago-Amancio Branch', 'Prenza 1 Marilao Bulacan', '2025-08-28 04:53:41', '2026-08-08 06:04:58', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\",\"sun\"]', '09:00:00', '18:00:00'),
(2, 'Lambakin Santiago-Amancio Branch', 'Lambakin Marilao Bulacan', '2025-08-28 04:54:01', '2026-02-24 17:40:29', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '15:00:00', '19:00:00'),
(3, 'Santa Maria Santiago-Amancio Branch', 'Parada Sta. Maria', '2025-08-28 04:54:20', '2025-08-29 05:37:58', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '21:00:00', '23:00:00'),
(4, 'San Jose Del Monte Santiago-Amancio Branch', 'SJDM Bulacan Harmony Hills', '2025-08-28 04:54:44', '2025-08-29 05:38:44', '[\"mon\",\"tue\",\"wed\",\"thu\",\"fri\",\"sat\"]', '21:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_schedule_overrides`
--

CREATE TABLE `store_schedule_overrides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_date` date NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 1,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_schedule_overrides`
--

INSERT INTO `store_schedule_overrides` (`id`, `store_id`, `schedule_date`, `is_open`, `opening_time`, `closing_time`, `reason`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-26', 0, NULL, NULL, NULL, '2026-05-01 20:19:10', '2026-05-01 20:19:10'),
(2, 1, '2026-05-10', 1, '13:00:00', '17:00:00', NULL, '2026-05-01 20:56:17', '2026-05-01 20:56:17'),
(3, 1, '2026-05-15', 0, NULL, NULL, 'Family Reunion of Dentists', '2026-05-01 20:56:50', '2026-05-01 20:56:50'),
(4, 2, '2026-05-22', 0, NULL, NULL, 'Urgent meeting', '2026-05-22 15:57:16', '2026-05-22 15:57:16'),
(6, 2, '2026-07-09', 0, NULL, NULL, 'Family Day', '2026-07-19 17:31:19', '2026-07-19 17:31:19'),
(7, 1, '2026-07-09', 0, NULL, NULL, 'Holiday', '2026-07-22 13:50:03', '2026-07-22 13:50:03'),
(8, 2, '2026-07-30', 0, NULL, NULL, 'Birthday ko', '2026-07-27 19:55:31', '2026-07-27 19:55:31'),
(9, 1, '2026-08-08', 0, NULL, NULL, NULL, '2026-08-13 09:38:26', '2026-08-13 09:38:26');

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
(32, 1, 31, 'Dentist', '2026-08-03 13:47:35', '2026-08-03 13:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'mL', '2026-07-30 09:37:28', '2026-07-30 09:37:28', NULL),
(2, 'G', '2026-07-30 09:37:28', '2026-07-30 17:57:47', '2026-07-30 17:57:47'),
(3, 'mg capsule', '2026-07-30 09:37:28', '2026-08-26 16:33:26', NULL),
(4, 'mg tablet', '2026-07-30 09:37:28', '2026-08-26 16:54:18', NULL),
(5, 'bottle', '2026-07-30 09:37:28', '2026-07-30 09:37:28', NULL),
(6, 'box', '2026-07-30 09:37:28', '2026-07-30 09:37:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_type` enum('admin','patient') DEFAULT NULL,
  `is_managed` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `users` (`id`, `name`, `account_type`, `is_managed`, `status`, `birth_date`, `user`, `email`, `contact_number`, `password`, `remember_token`, `created_at`, `updated_at`, `face_token`, `face_descriptor`, `position`, `is_verified`, `otp_code`, `middlename`, `lastname`, `suffix`, `birthdate`, `birthplace`, `birthplace_municipality`, `birthplace_province`, `current_address`, `address_other_details`, `address_house_number`, `address_street`, `address_barangay`, `address_municipality`, `address_province`, `verification_id`, `profile_image`, `qr_token`, `qr_code`, `formstatus`, `is_consent`, `deleted_at`) VALUES
(3, 'Lenard', 'admin', 0, NULL, NULL, 'Lenard', NULL, NULL, '$2y$12$CY4Ri9701m3pxpeUHYKDreasUDBb5oMVBU15PzuFNJYke04ihwqjC', NULL, '2025-08-28 04:20:40', '2025-10-14 03:15:08', NULL, NULL, 'admin', 0, NULL, 'Espiritu', 'Dela Cruz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca948182392.jpeg', '03c1317c-0873-453a-98bc-45dc30eefb46', 'qr_3.svg', NULL, NULL, '2025-10-14 03:15:08'),
(5, 'Reynaldo', 'admin', 0, NULL, NULL, 'Reynaldo', 'reynaldodiazjunjun28@gmail.com', '09948701129', '$2y$12$Mn1BYzVEQE/h.rlrHGFXcuueJL2AoR5fDgUngNZ0L0Glj4abrS69i', NULL, '2025-08-28 04:22:16', '2025-10-14 03:14:52', NULL, NULL, 'Dentist', 0, NULL, 'Bahil', 'Diaz', 'Jr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c7ca2c5b96a.jpg', '263e8a8c-6130-4802-8a52-9dc347ce3e5b', 'qr_5.svg', NULL, NULL, '2025-10-14 03:14:52'),
(6, 'Dhan Leonardo', 'admin', 0, NULL, NULL, 'Dhan', 'dhanalfonso@gmail.com', '09949499451', '$2y$12$8tUA.9MFvd3FTlc5KP/1qOikWOQQItOG1dPuM3xIBDKUn4vrYg0IG', NULL, '2025-08-28 04:22:37', '2025-10-14 03:18:33', NULL, NULL, 'Dentist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca9264a1933.jpg', '13adc600-df57-47d9-90e9-7ce8922bc213', 'qr_6.svg', NULL, NULL, '2025-10-14 03:18:33'),
(7, 'Czarina Jade', 'admin', 0, NULL, NULL, 'CzarinaJade', 'baroraczarinajade@gmail.com', '09339247279', '$2y$12$rT6EqmpfPrn3WRzPvHbVWe0ba7/aIXrujMLyUBtmqDU3FqkMCHDc6', NULL, '2025-08-28 04:22:59', '2025-10-14 03:18:51', NULL, NULL, 'Dentist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f9fd8277.jpg', '5fafe406-8d05-410f-a568-dc498536ed63', 'qr_7.svg', NULL, NULL, '2025-10-14 03:18:51'),
(8, 'Dani', 'admin', 0, NULL, NULL, 'Dani', 'kimjeonlee03@gmail.com', '09183239884', '$2y$12$IEtaGQqw3dTufz2Mv0zexuY2ngItaE2CMxMzsFK0if3Wkm4GQ0OVy', NULL, '2025-08-28 04:23:22', '2025-10-14 03:12:40', NULL, NULL, 'Receptionist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f02c7c4a.jpg', 'e58ed137-2f8c-44c2-b2f0-de9175fec727', 'qr_8.svg', NULL, NULL, '2025-10-14 03:12:40'),
(9, 'Czarina Jade', 'admin', 0, NULL, NULL, 'Jade', 'barorac.26@gmail.com', '09515170014', '$2y$12$7C9E2l4cktpftWutmb/JReyxjUW5GfFDZH7oim1zllZJrywiUm1jK', NULL, '2025-08-28 04:23:41', '2025-10-14 03:13:12', NULL, NULL, 'Receptionist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80ed97b4b1.jpg', '53b8edf5-c5c9-4858-9823-8cd76b87592b', 'qr_9.svg', NULL, NULL, '2025-10-14 03:13:12'),
(10, 'Joan Gail', 'admin', 0, NULL, NULL, 'Joan', 'zaratejoangail1028@gmail.com', '09949499453', '$2y$12$s.avtG/WCQ.Wh9p4rSRSye3J7p60d4raO1z3C/11Xx/eh7j.dSa7u', NULL, '2025-08-28 04:24:10', '2025-10-14 03:13:58', NULL, NULL, 'Receptionist', 0, NULL, 'Caluag', 'Zarate', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c7cac583e00.jpg', 'c242a93c-9a22-4f90-8b93-6da6484d09d7', 'qr_10.svg', NULL, NULL, '2025-10-14 03:13:58'),
(16, 'Lailla', 'admin', 0, NULL, NULL, 'Lailacruz', NULL, NULL, '$2y$12$eds0wqa7ZhyECiTv/lN/v.N0hT/JSVwzGs8bNYkY14IjAR6Jho5hC', NULL, '2025-10-07 22:22:18', '2025-10-14 03:19:04', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Gomez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eb39a2c8-1713-4c7f-96d6-e3faada76655', 'qr_16.svg', NULL, NULL, '2025-10-14 03:19:04'),
(17, 'Elijah', 'admin', 0, NULL, NULL, 'Elijahvergara', NULL, NULL, '$2y$12$3BoNQleFlwyRVFbdNN9TVe3c21VQCrm1oaxceV5WwSgSawJOTjfqC', NULL, '2025-10-07 22:26:37', '2025-10-14 03:20:20', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Vergara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2ca00ba3-1321-4fc4-9164-57f19a52a12f', 'qr_17.svg', NULL, NULL, '2025-10-14 03:20:20'),
(22, 'Admin', 'admin', 0, NULL, NULL, 'Admin', 'leonardogomezalfonso@gmail.com', NULL, '$2y$12$o5wXARUriv4EZF/f5sb2h.m7vftx3MMw2HLABJdgMLQofJY6Te7Ku', 'n7YSax5tcrfeVCPBuWhPIjpqxtgPMc6jdrzzgrEhncehNgnd1IZs7381SY53', '2025-10-14 03:20:43', '2026-07-27 23:33:37', NULL, NULL, 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9643df51-cc77-41cb-8cfa-fd25d6380a5a', 'qr_22.png', NULL, NULL, NULL),
(26, 'Marieta', 'admin', 0, NULL, NULL, 'Marieta', NULL, NULL, '$2y$12$kH2iZejDSvlN5k.hJStnceguLgw48MOI.nAWkBLC09gIMTX4xJVuO', 'BeCcmVZhx3AaAqxr04kJQCoMrsZZCGAqzXRUfhcly02YN1cY8G36EROGu4kJ', '2025-10-14 04:00:26', '2026-08-12 16:31:39', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a7c2f6bc95eb.jpg', '66fcd019-aabd-4e05-bb8a-fcf687455986', 'qr_26.png', NULL, NULL, NULL),
(30, 'Abelardo', 'admin', 0, NULL, NULL, 'Abelardo', NULL, NULL, '$2y$12$mL6AtGGDgpcQJT5abHGPouhFMpD4yqWWkX9jExq9c4M3mzR81bMtS', 'WYeepE2l31jcvv6iQFtmjXhPPumaU8be3k6Atdv5hDo3oIWOzAhMvxU6vO2U', '2025-10-14 04:01:43', '2026-08-26 17:48:07', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Santiago', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a8eb6572b360.jpg', '18e4cd05-f70c-40bb-92eb-c4310e2e8aae', 'qr_30.png', NULL, NULL, NULL),
(31, 'Sophia', 'admin', 0, NULL, NULL, 'Sophia', 'drsophiaamancio@gmail.com', NULL, '$2y$12$b5XOd/EF08ObWqhJnhtlx.PegJA7RTULATId8PfDKZw/WU2zx0CSG', '380sX2O24fB2sQ9UlxTfqWAW9ce2s2gAGkLabd5C5ovmE29Jf2uObBJLPVQi', '2025-10-14 04:02:20', '2026-08-26 17:47:25', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a8eb62ddd95a.jpg', '9e9b4cd0-f3c4-48cd-96fc-ead6b3a29b37', 'qr_31.png', NULL, NULL, NULL),
(32, 'Mhara Grace', 'admin', 0, NULL, NULL, 'Mhara Grace', NULL, NULL, '$2y$12$eS9gRRYHwh2hriuX5Zf7Wu.X/q5i2qNZseiQmp8si1oSMyKw92kLi', 'k4Si74GcNubHbzZ5ppaPadreRBz3yr2Rk4569JpqqNrCgmEgmkseokgw08I8', '2025-10-14 04:03:05', '2026-08-26 17:49:28', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Robles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a8eb6a8c6360.jpg', '2cc4edc4-a649-4c73-a3f4-e4c93ece931c', 'qr_32.png', NULL, NULL, NULL),
(33, 'Sherry', 'admin', 0, NULL, NULL, 'Sherry', NULL, '09876543321', '$2y$12$gU64TU4ZXztAausvkac4C.Mr6mtXaP9zVsxWQbg0bYlMNvlaBVsIS', 'xogO3eg5cwTMwmP38cTTHlkOaFNV8SgiH3LnyNLBc5iq4j9O08ekH14lXGtU', '2025-10-14 04:03:54', '2026-08-26 17:48:59', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Antonio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a8eb68be1db4.jpg', 'f325ca6a-1645-404e-9fe4-721a40b60ddf', 'qr_33.png', NULL, NULL, NULL),
(34, 'Gloria', 'admin', 0, NULL, NULL, 'Gloria', NULL, NULL, '$2y$12$yvY7M7VZ0WUG.25tRUIhje7nzap8mFqXzhe4rIYIPisWBOBhaTQ42', 'kNznEvBEMu3gKfdKs7DQ1gOvpbx4o5IhdNNWccoYAGerIQUcc6RsKVr0wndY', '2025-10-14 04:06:07', '2026-08-26 17:50:03', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Espiritu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6a8eb6cb086c0.jpg', 'fcdbc738-256e-4d51-9f7f-db9455533af5', 'qr_34.png', NULL, NULL, NULL),
(82, 'joshua', 'patient', 0, NULL, '2000-04-17', 'andersonandy046', 'andersonandy046@gmail.com', '09454454744', '$2y$12$tRWoeRijh3wPwEMiCvbfk.GeYxiZHoLkd9M63pzQVSygxxsvDiRli', 'uuMS2gIWLKONadelZ4WgpA2z7HpdG0P4OtklMvSMPKVJtISBYD1cxrOER3OO', '2026-04-10 13:39:04', '2026-08-08 06:28:20', NULL, NULL, NULL, 0, NULL, NULL, 'padilla', NULL, NULL, 'Sta.Maria, Bulacan', 'Sta.Maria', 'Bulacan', 'Apartment, 1234, Tibagan, Sta.rosa 2, Marilao, Bulacan', 'Apartment', '1234', 'Tibagan', 'Sta.rosa 2', 'Marilao', 'Bulacan', NULL, '6a765c0439125.png', '71e0041b-4541-4f8f-a49f-b5b24538ac5e', 'qr_82.png', 1, 1, NULL),
(83, 'Junjun', 'patient', 0, NULL, '2001-10-28', 'Junjun', 'junichidiaz@gmail.com', '09610812705', '$2y$12$Q0kKzPfxivNequ.N4F78j.QAUClNuCvhEET2.NMaFTL.QgrdlP6xS', 'Xr9fKMXbBNrXmLv18AezgRjLMrx2GdfRVnDYjtQZBGasZ47fjCJL7W2fqlLk', '2026-04-10 13:43:48', '2026-08-12 16:34:46', NULL, '[-0.07448949664831161,0.10974812507629395,0.07654283940792084,-0.055396948009729385,-0.09459958970546722,-0.0076218461617827415,-0.10277234762907028,-0.031801991164684296,0.11020489782094955,-0.10070584714412689,0.20242585241794586,-0.12207178771495819,-0.21193666756153107,-0.10417830944061279,0.01577240601181984,0.16531424224376678,-0.14008912444114685,-0.13019952178001404,-0.009923851117491722,-0.012636619620025158,0.09722722321748734,0.013345683924853802,0.019570987671613693,0.04174171760678291,-0.08372341096401215,-0.41607576608657837,-0.08654575794935226,-0.12670715153217316,0.016652725636959076,-0.1446060985326767,-0.08112271130084991,0.04691417142748833,-0.2221171110868454,-0.08223269879817963,-0.009300323203206062,0.06463208049535751,-0.015278303064405918,-0.010728485882282257,0.14200808107852936,0.006797801703214645,-0.1706811785697937,0.00563043775036931,-0.009325249120593071,0.25609856843948364,0.15508916974067688,0.10407701879739761,0.021382920444011688,-0.1169169545173645,0.04242301359772682,-0.11092788726091385,0.08519721031188965,0.16091187298297882,0.06895848363637924,0.07382801920175552,0.01954035274684429,-0.09201761335134506,0.038834355771541595,0.04396612197160721,-0.1490526646375656,0.016402775421738625,0.10008475184440613,-0.012158064171671867,-0.03463344648480415,-0.08550281822681427,0.3214981257915497,0.0012274468317627907,-0.09248718619346619,-0.16214895248413086,0.14423878490924835,-0.05323846638202667,-0.0673241913318634,0.04763372987508774,-0.1659466028213501,-0.13393692672252655,-0.2419755458831787,0.09228230267763138,0.38769039511680603,0.0838925763964653,-0.23129722476005554,0.0669347494840622,-0.10341578722000122,-0.07427604496479034,0.09025918692350388,0.1296262890100479,-0.008692273870110512,0.043337754905223846,-0.04124656692147255,0.07142858952283859,0.1393199861049652,-0.07137508690357208,0.0037850490771234035,0.18149133026599884,-0.014659099280834198,0.07943905144929886,0.030791303142905235,-0.024397805333137512,-0.08905788511037827,0.07482890039682388,-0.14191335439682007,-0.054957062005996704,0.061079464852809906,-0.01734495721757412,-0.03376761078834534,0.15029078722000122,-0.1363469660282135,0.13803686201572418,0.01749286614358425,-0.007428918499499559,0.013003433123230934,0.04949192330241203,-0.12802299857139587,-0.12981927394866943,0.11600930243730545,-0.23883089423179626,0.15712013840675354,0.156453937292099,0.09440603852272034,0.09684484452009201,0.10347037762403488,0.13494855165481567,0.03144952282309532,-0.013133357279002666,-0.2601637542247772,0.017199799418449402,0.16862592101097107,0.01819547824561596,0.0357130728662014,0.024811018258333206]', NULL, 0, NULL, 'Bahil', 'Diaz', 'Jr.', NULL, 'Davao Del Sur, Davao City', 'Davao Del Sur', 'Davao City', 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', 'Near Ipharma Mart', '1221', 'Kakawate St. Dulo 2', 'Camangyanan', 'Santa Maria', 'Bulacan', NULL, '6a7c302612757.jpg', '15f576af-53f4-46ea-8601-be615b4e8911', 'qr_83.png', 1, 1, NULL),
(84, 'Adrian', 'patient', 0, NULL, '2001-07-19', 'Adrian', 'ZyrenV4821@gmail.com', '09183239884', '$2y$12$tlj3.V0IRVYi9pT2pZocBeHfDdPUuZShOH5m2MubrAtNz4Ti/RoVK', NULL, '2026-04-30 19:46:27', '2026-04-30 19:46:27', NULL, '[-0.12083812057971954,0.08722362667322159,0.025689449161291122,-0.05763395503163338,-0.12560616433620453,0.03318759799003601,-0.043500468134880066,-0.044819604605436325,0.10716892033815384,-0.04917220398783684,0.27272558212280273,-0.038523972034454346,-0.205980584025383,-0.20438973605632782,0.06090794503688812,0.16229712963104248,-0.11435156315565109,-0.17394784092903137,-0.01961817964911461,-0.006589156575500965,0.0011382994707673788,0.02441496029496193,-0.019023125991225243,0.02397160232067108,-0.09377885609865189,-0.4051271975040436,-0.07487110793590546,-0.11446730047464371,0.05746278539299965,-0.11435259133577347,-0.10796797275543213,0.06303057819604874,-0.1806880384683609,-0.09089526534080505,0.07487598806619644,0.13753683865070343,-0.11838701367378235,-0.10301152616739273,0.1703689992427826,0.003912956453859806,-0.17591053247451782,-0.041820228099823,0.029196523129940033,0.2683018743991852,0.14482860267162323,0.05333518609404564,0.03108099475502968,-0.0287104994058609,0.07733272016048431,-0.18196538090705872,0.11378726363182068,0.1771119385957718,0.11766248196363449,0.05830025672912598,0.0678282231092453,-0.12684409320354462,0.02147654816508293,0.08629974722862244,-0.21053476631641388,-0.022232629358768463,-0.0008657351136207581,-0.05556965619325638,-0.049916815012693405,-0.12084431201219559,0.23176929354667664,0.135869562625885,-0.039300285279750824,-0.167527437210083,0.20380760729312897,-0.10334333032369614,-0.09866666048765182,0.03396587446331978,-0.16482532024383545,-0.1831730753183365,-0.2445136457681656,0.06141231209039688,0.34192681312561035,0.14390943944454193,-0.17862865328788757,0.055235978215932846,0.015505185350775719,-0.07387422770261765,0.07296845316886902,0.0814271867275238,-0.03587682917714119,0.009984858334064484,-0.056158553808927536,-0.001276915892958641,0.20642653107643127,-0.04435316473245621,-0.025249935686588287,0.12650766968727112,-0.024397511035203934,0.016931824386119843,0.09470278024673462,-0.0568518228828907,0.019222712144255638,0.030345357954502106,-0.1149187833070755,-0.03768168389797211,0.045202307403087616,-0.14073596894741058,-0.020776569843292236,0.1267797350883484,-0.1851210743188858,0.10338533669710159,0.046649862080812454,-0.008227545768022537,-0.0020905165001749992,-0.020724497735500336,-0.1028527319431305,-0.0519845224916935,0.1295825093984604,-0.25056159496307373,0.2701073884963989,0.17166705429553986,0.054298870265483856,0.15460486710071564,0.08167408406734467,0.07064929604530334,0.01702948287129402,-0.08557247370481491,-0.19424483180046082,-0.09054768830537796,0.10031570494174957,0.006702375132590532,0.04346557706594467,0.043966080993413925]', NULL, 0, NULL, 'Marcelo`', 'Villanueva', NULL, NULL, 'San Ildefonso, Bulacan', 'San Ildefonso', 'Bulacan', '127 Mabini Street, San Ildefonso, Bulacan, Sampaguita Street, Brgy. Anyatam, San Ildefonso, Bulacan', NULL, '127 Mabini Street, San Ildefonso, Bulacan', 'Sampaguita Street', 'Brgy. Anyatam', 'San Ildefonso', 'Bulacan', NULL, NULL, '39763701-5dc5-4bcf-aeaf-16446a8aab07', 'qr_84.png', NULL, NULL, NULL),
(85, 'Elsie', 'patient', 0, NULL, '1969-02-14', 'Elsie', 'elsiediazbahil14@gmail.com', '095198459536', '$2y$12$X5.noIraOJ3f.QznffqCK.NsoJfYTUgmEjpp/X5v0XiurGdLgc82q', NULL, '2026-05-01 20:35:57', '2026-05-01 20:39:34', NULL, '[-0.06242922320961952,0.17156988382339478,0.02686358243227005,0.030605509877204895,-0.0779130682349205,-0.0032519912347197533,-0.07005632668733597,-0.17829546332359314,0.17936649918556213,-0.11218369752168655,0.22390547394752502,-0.03593847528100014,-0.1822069138288498,-0.10937289148569107,0.0034412676468491554,0.15628153085708618,-0.19116558134555817,-0.12331587821245193,-0.052326273173093796,-0.039594221860170364,0.04078418016433716,-0.0033011939376592636,0.05463847145438194,-0.007700121030211449,-0.01476120576262474,-0.41346853971481323,-0.10057302564382553,-0.08044706284999847,0.11932925134897232,0.001353858271613717,-0.10229101032018661,0.02740926668047905,-0.20956973731517792,-0.13465061783790588,0.045001257210969925,0.08547452092170715,0.007973681204020977,-0.006637888494879007,0.1394576132297516,-0.06677151471376419,-0.19229644536972046,0.03124644048511982,0.06111001595854759,0.2009306401014328,0.1297619491815567,0.12139992415904999,0.0030293315649032593,-0.14932626485824585,0.1263808012008667,-0.12507513165473938,0.044999297708272934,0.14241226017475128,0.095404252409935,0.05449076369404793,0.02699136734008789,-0.1468791514635086,0.011848055757582188,0.10786903649568558,-0.15658952295780182,-0.032566361129283905,0.070048987865448,-0.04862936958670616,-0.05869615823030472,-0.05011994019150734,0.2518022060394287,0.10013903677463531,-0.05291102081537247,-0.16026347875595093,0.14699064195156097,-0.09375913441181183,-0.025124676525592804,0.048538923263549805,-0.10507892072200775,-0.14195960760116577,-0.25072383880615234,0.030453039333224297,0.4382026195526123,0.05304863303899765,-0.1646399199962616,0.02791033312678337,-0.06319486349821091,-0.041289594024419785,0.11385389417409897,0.10673415660858154,-0.0407397598028183,-0.005602664314210415,-0.0972360223531723,-0.0058414023369550705,0.17747311294078827,-0.06629842519760132,0.027482159435749054,0.1877039670944214,-0.012665722519159317,0.099848672747612,0.0033445125445723534,0.07328133285045624,-0.11758030205965042,0.04894028604030609,-0.17926721274852753,-0.07917409390211105,0.07469095289707184,0.007522397208958864,-0.028115680441260338,0.1021442636847496,-0.196685791015625,0.08885624259710312,0.009043334051966667,0.013571982271969318,0.08019964396953583,-0.04390077292919159,0.00542391836643219,-0.08759769797325134,0.11522193253040314,-0.23812644183635712,0.18990913033485413,0.17028838396072388,-0.01751156896352768,0.17435036599636078,0.040194638073444366,0.0922200009226799,0.01040282379835844,-0.08172489702701569,-0.24905923008918762,-0.06737598776817322,0.10208936780691147,-0.04624248296022415,-0.030452080070972443,-0.01451052539050579]', NULL, 0, NULL, 'Bahil', 'Diaz', NULL, NULL, 'Roxas, Capiz', 'Roxas', 'Capiz', '1221, 507, Kakawate St. Camangyanan Santa Maria Bulacsn, Camangyanan, Sta. Maria, Bulacan', '1221', '507', 'Kakawate St. Camangyanan Santa Maria Bulacsn', 'Camangyanan', 'Sta. Maria', 'Bulacan', NULL, NULL, 'a6a5acf6-2e49-47c1-904c-04e6cc066a19', 'qr_85.png', 1, 1, NULL),
(86, 'Crystal', 'patient', 0, NULL, '2002-03-08', 'Crystal', 'crystalfortune0308@gmail.com', '09708505234', '$2y$12$fIIrAjaGewaqQu80vU2HReZUMQZI5CDWnxCpV7oxecFgIkKnRfQxC', 'UhnWocWYe6MKnlCmMbfsMLp0V4fipyBAKbKdf3ks68jwgW9062ysP0CZwh7Z', '2026-05-01 20:40:36', '2026-08-12 16:28:18', NULL, '[-0.09393806010484695,0.09877713024616241,0.07817047089338303,-0.12701937556266785,-0.0667116791009903,-0.03573925048112869,-0.046341635286808014,-0.08255370706319809,0.22088713943958282,-0.046157803386449814,0.27770039439201355,0.021910162642598152,-0.2328372448682785,-0.10527704656124115,-0.05164802446961403,0.14746932685375214,-0.15108013153076172,-0.16947773098945618,0.03817959874868393,0.017894864082336426,0.07630432397127151,0.011670093983411789,0.005835049785673618,0.05398113653063774,-0.1336950808763504,-0.32304850220680237,-0.10365734994411469,-0.11987973749637604,0.013318289071321487,-0.1037999764084816,-0.06305088847875595,0.016367658972740173,-0.22264567017555237,-0.05802307650446892,0.015971273183822632,0.10978875309228897,-0.03313498571515083,-0.025261154398322105,0.2188095599412918,0.04727015271782875,-0.23480786383152008,-0.04739775508642197,0.0518929697573185,0.23700591921806335,0.19954584538936615,0.0234327781945467,0.025290781632065773,-0.08279295265674591,0.05878722295165062,-0.1970045566558838,0.10418792814016342,0.1430484652519226,0.16895583271980286,0.041826728731393814,0.06332357972860336,-0.1460709273815155,-0.0068451277911663055,0.1181909367442131,-0.2618667781352997,0.03450489044189453,0.01912541314959526,-0.10973245650529861,-0.02401319332420826,-0.019639896228909492,0.25030848383903503,0.09222519397735596,-0.09652001410722733,-0.10224445909261703,0.24133150279521942,-0.14387811720371246,-0.04474737122654915,0.1302034854888916,-0.10256067663431168,-0.1869506537914276,-0.29671773314476013,0.019951043650507927,0.38618406653404236,0.12763960659503937,-0.194279745221138,0.07516442239284515,-0.06514324247837067,-0.0658847987651825,0.04618634283542633,0.0888262689113617,-0.03738899156451225,0.10775528848171234,-0.11215540766716003,0.01722779870033264,0.18198901414871216,-0.021471716463565826,0.02424336038529873,0.21279706060886383,-0.013092853128910065,0.05233961343765259,0.07086579501628876,0.05961369723081589,-0.03987998515367508,-0.04356414079666138,-0.14993993937969208,-0.0792955756187439,-0.02382143773138523,-0.047519322484731674,-0.001862777047790587,0.12513352930545807,-0.188798189163208,0.04435284063220024,0.030618702992796898,-0.09762821346521378,-0.08184850960969925,-0.012560837902128696,0.00023681169841438532,-0.11778935045003891,0.12574534118175507,-0.27160754799842834,0.17055992782115936,0.12931928038597107,-0.029523884877562523,0.14424929022789001,0.012626816518604755,0.059127870947122574,-0.02601063810288906,-0.1553935557603836,-0.122160904109478,-0.02278716117143631,0.045595183968544006,-0.028683410957455635,0.1522161364555359,0.029278187081217766]', NULL, 0, NULL, NULL, 'Fortune', NULL, NULL, 'Marilao, Bulacan', 'Marilao', 'Bulacan', 'Corner of Jacinto Street, 91, Maligaya Street, Patubig, Marilao, Bulacan', 'Corner of Jacinto Street', '91', 'Maligaya Street', 'Patubig', 'Marilao', 'Bulacan', NULL, '6a702be7706a7.jpg', '3f6111bd-19f6-4539-96f8-60b093c03323', 'qr_86.png', 1, 1, NULL),
(88, 'april jane', 'patient', 0, NULL, '2000-05-04', 'padillajoshuaanderson.pdm', 'padillajoshuaanderson.pdm@gmail.com', '09454454744', '$2y$12$7tKRLfqhDbayv/c0ZEQ4/.hh9fUk2G26kHHprfgtUbUDXXdMoc3gO', NULL, '2026-05-04 15:24:59', '2026-05-04 15:25:18', NULL, '[-0.14442211389541626,0.11687109619379044,0.06980306655168533,-0.02009783498942852,-0.08948838710784912,-0.04453711211681366,-0.08827606588602066,-0.1240224689245224,0.06865783035755157,-0.07174157351255417,0.2661881744861603,-0.04986029490828514,-0.28876787424087524,-0.0766301155090332,-0.03317345678806305,0.1766628473997116,-0.17997436225414276,-0.11254727840423584,-0.060161132365465164,0.0025987401604652405,0.10540395230054855,0.030689503997564316,0.016296330839395523,0.03285903483629227,-0.10319604724645615,-0.2962493896484375,-0.09751509130001068,-0.07180777192115784,-0.017223164439201355,-0.03939727693796158,-0.03053545393049717,-0.023763779550790787,-0.2084846943616867,-0.07807981967926025,0.036718275398015976,0.019905371591448784,0.027812452986836433,-0.019392458721995354,0.14142939448356628,-0.02392907626926899,-0.2049781084060669,-0.013512223027646542,0.11783693730831146,0.21950168907642365,0.10383354127407074,0.15256892144680023,-0.01331313606351614,-0.08126109838485718,0.0523996464908123,-0.2114790678024292,0.03359588608145714,0.1577075719833374,0.10129185765981674,0.018337657675147057,0.04792226478457451,-0.1822863221168518,0.04064178466796875,0.08752870559692383,-0.15365444123744965,0.022290565073490143,0.07946944236755371,-0.010103332810103893,-0.009252523072063923,-0.06405068933963776,0.21807831525802612,0.0391404926776886,-0.13568702340126038,-0.12069912999868393,0.10328415036201477,-0.1136077493429184,-0.07853968441486359,0.07243295758962631,-0.15228842198848724,-0.18171396851539612,-0.37713345885276794,-0.019842663779854774,0.3703678548336029,0.08992982655763626,-0.189100444316864,-0.009863457642495632,-0.034818027168512344,0.009384718723595142,0.09256496280431747,0.060699157416820526,-0.0278367567807436,-0.002111922251060605,-0.14092832803726196,-0.014961779117584229,0.18286503851413727,-0.053597573190927505,0.013182457536458969,0.22919349372386932,0.022621802985668182,0.014749925583600998,-0.013469708152115345,0.08822108060121536,-0.090775266289711,-0.04770369455218315,-0.1318175196647644,-0.0010856211883947253,0.01598549447953701,0.01876327022910118,-0.025327948853373528,0.15175239741802216,-0.15119324624538422,0.02553820051252842,0.0023234672844409943,-0.029218902811408043,-0.057632289826869965,0.02949623577296734,-0.1278301179409027,-0.10649602115154266,0.07572364807128906,-0.19188693165779114,0.14659792184829712,0.21269847452640533,-0.0042268638499081135,0.05567087233066559,0.09426990151405334,0.05362260341644287,-0.042324960231781006,-0.006647048518061638,-0.18018591403961182,-0.12921348214149475,0.08220203965902328,-0.07367803156375885,0.055191099643707275,-0.007750297896564007]', NULL, 0, NULL, NULL, 'de leon', NULL, NULL, 'Marilao, Bulacan', 'Marilao', 'Bulacan', '634, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, '634', 'tibagan', 'sta.rosa 2', 'Marilao', 'Bulacan', NULL, NULL, '586511de-a6af-470b-a1ea-4b9966523f25', 'qr_88.png', 1, 1, NULL),
(90, 'Adrian', 'patient', 0, NULL, '2001-03-18', 'Addy', 'villanuevaaacc2001@gmail.com', '09183239884', '$2y$12$1zZNyHdf5UYTlXMefzIiseR3sVX04gjOXef2hwu5ANokuADckLcqe', NULL, '2026-07-01 17:49:52', '2026-07-01 17:49:52', NULL, '[-0.2887198328971863,0.03801234811544418,0.11860989034175873,-0.025029148906469345,-0.04318699613213539,-0.0970141738653183,-0.006566311698406935,-0.10871856659650803,0.09340716153383255,-0.03835952654480934,0.24671036005020142,-0.03950470685958862,-0.2569507360458374,-0.07795725017786026,-0.004274909850209951,0.18450231850147247,-0.18504492938518524,-0.08102516829967499,-0.06204691156744957,-0.01708170585334301,0.06539037078619003,-0.044362857937812805,0.016700930893421173,0.17228877544403076,-0.16291573643684387,-0.38552311062812805,-0.10388179868459702,-0.12367617338895798,-0.0003839768760371953,-0.09054898470640182,-0.06047097221016884,0.019619423896074295,-0.1739281415939331,-0.04586663469672203,-0.034522946923971176,0.08495403826236725,0.021587882190942764,-0.03426172956824303,0.15125565230846405,-0.032382406294345856,-0.22299470007419586,-0.036142151802778244,0.03391651436686516,0.22040189802646637,0.18791529536247253,0.036233969032764435,0.09714558720588684,-0.07102235406637192,0.004910821095108986,-0.1990746706724167,0.03039868175983429,0.09435487538576126,0.15038830041885376,0.02757265605032444,0.014433915726840496,-0.19505679607391357,-0.03711239621043205,0.09815526008605957,-0.18993446230888367,0.07601694762706757,0.02461513876914978,-0.06830009818077087,0.01325361616909504,0.0006780856638215482,0.215932235121727,0.10994929820299149,-0.20346620678901672,-0.06838314980268478,0.1607203483581543,-0.16611048579216003,0.010787926614284515,0.03713748976588249,-0.11766437441110611,-0.2635520398616791,-0.36020463705062866,0.056581057608127594,0.39096206426620483,0.15841735899448395,-0.25538280606269836,-0.008840410970151424,-0.14585167169570923,-0.017030110582709312,0.06098059564828873,0.15292486548423767,-0.07788411527872086,0.040044497698545456,-0.09223384410142899,0.0439460314810276,0.11610434949398041,0.060197681188583374,0.012132209725677967,0.24077589809894562,0.037192534655332565,0.03122980333864689,0.017421500757336617,0.09574602544307709,-0.11293669044971466,-0.026584502309560776,-0.06546054035425186,0.01060796994715929,-0.02414686419069767,0.002157345414161682,0.057607755064964294,0.10130364447832108,-0.14010462164878845,0.1527683585882187,0.021258562803268433,-0.017970792949199677,-0.05219631269574165,0.07343054562807083,-0.11149610579013824,-0.08879014849662781,0.0945633128285408,-0.23754124343395233,0.12434948980808258,0.2424968034029007,0.012225499376654625,0.15965408086776733,0.08217062801122665,0.0634756088256836,0.0056595769710838795,-0.005104233045130968,-0.1193871945142746,0.04115264117717743,0.12691646814346313,-0.11889981478452682,0.1286722719669342,0.02161531336605549]', NULL, 0, NULL, 'Santos', 'Villanueva', NULL, NULL, 'Malolos, Malolos, Bulacan', 'Malolos', 'Malolos, Bulacan', 'Mabini Street, Barangay Tikay, Malolos, Bulacan', NULL, NULL, 'Mabini Street', 'Barangay Tikay', 'Malolos', 'Bulacan', NULL, NULL, '50f512dd-27f5-45f0-8561-22bf58c9bed9', 'qr_90.png', NULL, NULL, NULL),
(92, 'Caleb', 'patient', 1, NULL, '2026-07-02', 'dep_mvir76at3peo', NULL, '09708505234', '$2y$12$XE9n.Q3bOAR/52DO5Wn3PuTfH5wiDlugZsG.GyONvd1FsIJz44pm2', NULL, '2026-07-02 16:01:30', '2026-07-27 18:00:31', NULL, NULL, NULL, 0, NULL, 'Jacob', 'Mendoza', NULL, NULL, NULL, NULL, NULL, 'Corner of Jacinto Street, 91, Maligaya Street, Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd06f1b5c-ad3c-4f39-8ca1-d8d291a33f18', 'qr_92.png', 1, 1, '2026-07-27 18:00:31'),
(93, 'Jayvee', 'patient', 1, NULL, '2016-03-06', 'dep_btmivz82sob6', NULL, '09610812705', '$2y$12$La4ZM5xy20RfGjj70otjFOezu9OQNwg7JY.O3U9srrNSnH/RXGdXW', NULL, '2026-07-02 16:19:57', '2026-07-06 15:35:30', NULL, NULL, NULL, 0, NULL, 'Caluag', 'Zarate', NULL, NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '38699965-f83f-44e3-b9d4-f8c60cb50989', 'qr_93.png', 1, 1, '2026-07-06 15:35:30'),
(94, 'Jayvee', 'patient', 1, NULL, '2016-06-03', 'dep_orhcpk4qrb6o', NULL, '09610812705', '$2y$12$G2eRV9It0gAfk.Bc9uiJT.xf3GPFx92yowO7nj77R19UAfDI/TP9u', NULL, '2026-07-06 15:36:39', '2026-07-27 18:01:18', NULL, NULL, NULL, 0, NULL, 'Caluag', 'Zarate', NULL, NULL, NULL, NULL, NULL, 'Ph3 blk4 lot 7, Estrella Homes, Sta rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2ea13386-603a-4d98-b1a7-0910c5c62ec0', 'qr_94.png', 1, 1, NULL),
(95, 'Kael', 'patient', 0, NULL, '2008-09-14', 'Kael', 'laurentkael44@gmail.com', '09949499451', '$2y$12$caoLjCrqMxVSag8.Hkmdauakr.zzHe1R7jpjz5q/TkMTN9XCjgR.q', NULL, '2026-07-08 17:29:15', '2026-07-27 18:57:43', NULL, '[-0.07159353792667389,0.08066101372241974,0.06903328001499176,-0.02661261335015297,-0.09650879353284836,-0.08516136556863785,0.005071548745036125,-0.12452458590269089,0.1732228547334671,-0.07130727916955948,0.17156337201595306,-0.03839728981256485,-0.19473658502101898,-0.042040999978780746,0.03103615716099739,0.13422545790672302,-0.17693687975406647,-0.204447939991951,0.01709139719605446,-0.026854384690523148,0.06534097343683243,0.013181440532207489,-0.01584460958838463,0.08074703067541122,-0.07321921736001968,-0.3547447621822357,-0.07324009388685226,-0.10520938783884048,0.10959550738334656,-0.09466362744569778,-0.014790808781981468,0.07076927274465561,-0.2292405068874359,-0.071483314037323,0.02442294731736183,0.09642086923122406,-0.01692296750843525,-0.02386428415775299,0.18528510630130768,0.012650039047002792,-0.2883366048336029,-0.01705528423190117,0.03808537498116493,0.26889142394065857,0.1411091387271881,0.12716516852378845,-0.001588243991136551,-0.06525007635354996,0.002050922019407153,-0.18164712190628052,0.05705451965332031,0.1612289845943451,0.10964925587177277,0.015444045886397362,-0.05142471566796303,-0.21153950691223145,0.03813910484313965,-0.009211089462041855,-0.28352195024490356,0.0758582353591919,0.15073758363723755,-0.13766418397426605,-0.009865790605545044,0.019307130947709084,0.28608009219169617,0.06425408273935318,-0.06447318941354752,-0.12994509935379028,0.18909086287021637,-0.2171548455953598,-0.09448392689228058,0.06478366255760193,-0.10579302161931992,-0.15991957485675812,-0.2733667492866516,-0.009402776136994362,0.4254598915576935,0.084041528403759,-0.1559380441904068,0.06897375732660294,-0.06299769878387451,0.01533801481127739,0.12314023077487946,0.12603642046451569,-0.04394716024398804,0.025034219026565552,-0.10829530656337738,0.005743847228586674,0.20179623365402222,-0.006430915556848049,-0.04223895072937012,0.1526879519224167,-0.014091907069087029,0.029086366295814514,0.02650315873324871,0.024277063086628914,-0.031843170523643494,0.027274003252387047,-0.146623894572258,-0.07402058690786362,0.012946082279086113,-0.016998324543237686,0.004181679803878069,0.17041592299938202,-0.22288042306900024,0.1395547091960907,0.022844839841127396,-0.06195816397666931,0.001391798723489046,0.0625310018658638,-0.08833809196949005,-0.11181221902370453,0.13793323934078217,-0.24208784103393555,0.2586853504180908,0.24299925565719604,0.048862989991903305,0.12421947717666626,0.0319998562335968,0.07069675624370575,0.023030757904052734,-0.07668501138687134,-0.23048117756843567,-0.04795648530125618,0.07786083966493607,-0.07489965856075287,0.11103987693786621,0.04619494080543518]', NULL, 0, NULL, 'Evren', 'Laurent', NULL, NULL, 'Meycauayan, Bulacan', 'Meycauayan', 'Bulacan', '#118, Maple Grove Street, Lias, Marilao, Bulacan', NULL, '#118', 'Maple Grove Street', 'Lias', 'Marilao', 'Bulacan', NULL, NULL, '9e99cac2-c0b1-43cb-a0e0-fa8c8e7ee05b', 'qr_95.png', 1, 1, NULL),
(97, 'Liam', 'patient', 1, NULL, '2010-09-10', 'dep_wp9h4ygeq6zq', NULL, '09946709762', '$2y$12$6rMbqt74QC9ut/DBK3WeV.dZd8TxAAuNumhP5LrTzAD/THAKn4Bk6', NULL, '2026-07-08 22:23:18', '2026-07-30 17:55:10', NULL, NULL, NULL, 0, NULL, 'Gonzales', 'Datron', NULL, NULL, NULL, NULL, NULL, '#118, Maple Grove Street, Lias, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3cdcc850-a7b8-4f44-9370-825fb26d238d', 'qr_97.png', NULL, NULL, NULL),
(98, 'Mahal', 'patient', 1, NULL, '2026-07-09', 'dep_wxsyw6arn59h', NULL, '09610812705', '$2y$12$v20fEfBl/ntz52leuCvhyeDtcIy58Vu6FgllZjtnRPJTsOTeniak6', NULL, '2026-07-09 01:02:33', '2026-07-09 02:18:17', NULL, NULL, NULL, 0, NULL, NULL, 'Kita', NULL, NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1daad988-84e7-4a10-823b-c63f434dd7e7', 'qr_98.png', 1, 1, '2026-07-09 02:18:17'),
(99, '123', 'patient', 1, NULL, '2026-07-09', 'dep_swxboeckmf0a', NULL, '09610812705', '$2y$12$HOgmTiqW2f5dxtPgK5wkbuDjjl3knwX1nGHNqxBX6fiLK7O/SAkq.', NULL, '2026-07-09 01:16:28', '2026-07-09 02:18:13', NULL, NULL, NULL, 0, NULL, NULL, '456', NULL, NULL, NULL, NULL, NULL, 'Near Ipharma Mart, 1221, Kakawate St. Dulo 2, Camangyanan, Santa Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e94f5346-33bb-4b77-b6e7-306285c567bb', 'qr_99.png', 1, 1, '2026-07-09 02:18:13'),
(100, 'Ayuko na', 'patient', 0, NULL, '2026-07-01', 'cjbarora', 'Sampleemail@gmail.com', '09610812705', '$2y$12$DIpW11k9Oj2cMFSB5xehyOCwv2XHm5s0aO5tKSL30/M4O2mrxsqv2', NULL, '2026-07-09 01:43:21', '2026-08-06 15:41:31', NULL, '[-0.11564186960458755,0.12315364181995392,0.029088623821735382,-0.12536713480949402,-0.04158763960003853,0.004147550091147423,-0.017696864902973175,-0.03290460631251335,0.24303805828094482,-0.05621526017785072,0.2484622746706009,-0.009026234969496727,-0.22379103302955627,-0.07099652290344238,-0.037559207528829575,0.1743645817041397,-0.2351299375295639,-0.1302739977836609,-0.026734568178653717,0.03480106219649315,0.060574039816856384,0.04314672574400902,0.016889497637748718,0.07682140171527863,-0.0944378674030304,-0.3589174151420593,-0.06532372534275055,-0.11840473115444183,0.10200337320566177,-0.09334281086921692,-0.04471161589026451,-0.01803131401538849,-0.1960279941558838,-0.07486830651760101,0.06356427073478699,0.10826542973518372,-0.10866236686706543,-0.09670424461364746,0.18319076299667358,0.06388306617736816,-0.20534908771514893,-0.031012095510959625,0.010252716019749641,0.2849263548851013,0.19487479329109192,0.10221543163061142,0.015257308259606361,-0.14140383899211884,0.07905195653438568,-0.27870556712150574,0.036223649978637695,0.14027245342731476,0.07047626376152039,0.05098256841301918,0.0449543222784996,-0.166946142911911,0.0442737452685833,0.09668856114149094,-0.3043011724948883,0.04960847273468971,0.031514376401901245,-0.06488880515098572,0.0003183683438692242,-0.0187258068472147,0.23141516745090485,0.09666453301906586,-0.131200909614563,-0.12743644416332245,0.18298014998435974,-0.1982995867729187,0.006484013982117176,0.13331757485866547,-0.03371814265847206,-0.23525990545749664,-0.2200431078672409,-0.014547625556588173,0.42918986082077026,0.16322024166584015,-0.1305219829082489,0.01873505860567093,-0.07645795494318008,-0.06558564305305481,0.08357604593038559,0.10628408938646317,-0.08734060823917389,0.013359548524022102,-0.11301352828741074,-0.032862819731235504,0.2087942212820053,-0.0275283120572567,0.018358446657657623,0.23608674108982086,-0.0022789929062128067,-0.015021909959614277,0.051309484988451004,0.047618407756090164,-0.11203370243310928,-0.0018504990730434656,-0.12349077314138412,-0.11412418633699417,-0.007562927436083555,-0.09121870994567871,0.006772198248654604,0.1077190712094307,-0.19717201590538025,0.10660633444786072,0.00756362359970808,-0.09109169244766235,0.011365524493157864,-0.02476709708571434,-0.07017797231674194,-0.11232627928256989,0.15620261430740356,-0.26465868949890137,0.1724659502506256,0.2042199820280075,0.05094694718718529,0.17212948203086853,0.06035629287362099,0.08008184283971786,-0.018131781369447708,-0.08503978699445724,-0.12554986774921417,-0.044448237866163254,0.017109187319874763,-0.008771577849984169,0.11126399785280228,-0.048367489129304886]', NULL, 0, NULL, NULL, 'pAGOD NAKo', NULL, NULL, '1, 2', '1', '2', '8, 3, 4, 5, 6, 7', '8', '3', '4', '5', '6', '7', NULL, NULL, '9cff79cf-ba1e-4414-8751-dfb71c40cb55', 'qr_100.png', 1, 1, '2026-08-06 15:41:31'),
(101, 'Zion Marlon', 'patient', 0, NULL, '2006-10-16', 'Zion', 'zionmarlon222@gmail.com', '09952326370', '$2y$12$2Aw.gtqI4iuk57fTH8efd.TV/KrVSKHpu8k.FK.XgHtsIDqfnLgX2', NULL, '2026-07-16 19:41:59', '2026-07-16 19:42:09', NULL, '[-0.15482424199581146,0.06562229245901108,0.0841110348701477,-0.018182845786213875,-0.057321853935718536,-0.021353842690587044,-0.023096557706594467,-0.06029891595244408,0.1602538377046585,-0.08768215775489807,0.25713688135147095,0.029974618926644325,-0.16898533701896667,-0.14175552129745483,-0.0062896390445530415,0.16689111292362213,-0.119679756462574,-0.11641378700733185,-0.034223008900880814,-0.04416660964488983,0.008889317512512207,0.021502060815691948,0.03172002360224724,0.036519087851047516,-0.113338403403759,-0.4420298933982849,-0.10630563646554947,-0.09784401208162308,-0.023651553317904472,-0.059681486338377,-0.05724390223622322,0.08824621886014938,-0.14185409247875214,-0.023944556713104248,-0.004819630645215511,0.10351230204105377,-0.01037823036313057,0.010766473598778248,0.16287530958652496,0.011781945824623108,-0.2029404193162918,0.009159558452665806,0.00939899031072855,0.2750837206840515,0.1771232634782791,0.0792437493801117,0.043357398360967636,-0.04967942461371422,0.03970906138420105,-0.11930254846811295,0.059646036475896835,0.12490613013505936,0.054568927735090256,0.04142209142446518,-0.024255378171801567,-0.1093783751130104,-0.026560993865132332,0.04193057119846344,-0.09791535884141922,0.0014579325215891004,0.00565674901008606,-0.14281858503818512,-0.04187195003032684,-0.012515250593423843,0.2370743453502655,0.08416973054409027,-0.10918094962835312,-0.13167214393615723,0.1387898474931717,-0.1504584103822708,-0.04952229931950569,0.014107451774179935,-0.1785237044095993,-0.1747017800807953,-0.2925845980644226,0.11982069909572601,0.40385347604751587,0.08322642743587494,-0.17437796294689178,0.019044671207666397,-0.06549737602472305,-0.01271228026598692,0.10818316042423248,0.15195956826210022,-0.05963050201535225,-0.012866229750216007,-0.10029690712690353,0.009588050656020641,0.2219041883945465,-0.01499919779598713,-0.04588397219777107,0.18414664268493652,-0.02109643816947937,0.10628896951675415,0.014409792609512806,0.02609231509268284,-0.023191023617982864,0.07048886269330978,-0.09112127125263214,0.008825019933283329,0.07947647571563721,-0.05836975574493408,0.003772103926166892,0.11150597035884857,-0.1695016324520111,0.1117115318775177,0.021588528528809547,0.03464508801698685,0.07906921207904816,0.08772813528776169,-0.12625961005687714,-0.14545148611068726,0.1325189769268036,-0.16790181398391724,0.2144751399755478,0.23236685991287231,0.07212993502616882,0.1673625409603119,0.13943731784820557,0.10918229818344116,-0.007332284469157457,-0.014246318489313126,-0.17563048005104065,0.017857765778899193,0.11020564287900925,-0.014812582172453403,0.07646264135837555,0.03378869965672493]', NULL, 0, NULL, 'Flores', 'Espiritu', NULL, NULL, 'Santa Maria, Bulacan', 'Santa Maria', 'Bulacan', 'N/A, 453, Ibayong Tabon, Parada, Santa Maria, Bulacan', 'N/A', '453', 'Ibayong Tabon', 'Parada', 'Santa Maria', 'Bulacan', NULL, NULL, '8945d79c-eec2-4361-82ab-840c4548dea3', 'qr_101.png', NULL, 1, NULL),
(103, 'Margaux', 'patient', 0, NULL, '2017-12-25', 'Margaux', 'sophiaamanciostudent@gmail.com', '0999123456', '$2y$12$.72ZZav4TOmY47n5wh2hq.P5YOzt00yOy0QEOOxXfaR3qHgHDqWRC', NULL, '2026-07-27 15:51:16', '2026-07-27 15:52:13', NULL, '[-0.1066499873995781,0.027877485379576683,0.009182319976389408,-0.08643867075443268,-0.08745503425598145,-0.03569551184773445,0.02116902731359005,-0.10159515589475632,0.19303645193576813,-0.17456014454364777,0.2039918154478073,-0.07839547097682953,-0.1404838263988495,-0.07283654063940048,-0.07105797529220581,0.23438940942287445,-0.2117440551519394,-0.15127795934677124,-0.01490676961839199,-0.10500238090753555,0.020648924633860588,-0.008375968784093857,0.0073414938524365425,0.14720343053340912,-0.09867937862873077,-0.36700692772865295,-0.0792500227689743,-0.1304747313261032,-0.0006205901736393571,-0.05440981686115265,0.058942507952451706,0.17042255401611328,-0.2631118893623352,0.022561727091670036,-0.04601612314581871,0.062084805220365524,0.007741491310298443,0.0012539157178252935,0.20549511909484863,0.07087797671556473,-0.21286317706108093,-0.014221676625311375,-0.0030692655127495527,0.3012523651123047,0.12578360736370087,-0.020157359540462494,-0.017892247065901756,0.0040541295893490314,0.048730671405792236,-0.1689435988664627,-0.01984286494553089,0.1280309110879898,0.06181568652391434,-0.007525731343775988,-0.029001766815781593,-0.06583517044782639,0.026402194052934647,0.033015891909599304,-0.1886509209871292,-0.013902869075536728,0.021893203258514404,-0.13309507071971893,-0.06820032745599747,-0.06847970932722092,0.2880658507347107,0.08835258334875107,-0.12642547488212585,-0.09846221655607224,0.17616969347000122,-0.15940120816230774,-0.029324980452656746,0.028596315532922745,-0.1252613365650177,-0.14409543573856354,-0.3181968927383423,0.04336021840572357,0.4316532015800476,0.09705991297960281,-0.16070102155208588,0.09452258795499802,-0.05788985267281532,-0.022904619574546814,0.10640574246644974,0.204811692237854,-0.02895304746925831,0.07227353006601334,-0.012386133894324303,0.042793530970811844,0.11556582152843475,0.000722274708095938,-0.08090965449810028,0.21215729415416718,-0.06220070272684097,0.022823844105005264,0.004645003937184811,-0.0437069907784462,-0.02212267555296421,-0.018111607059836388,-0.1042436808347702,0.010710985399782658,-0.04738348349928856,-0.01680327020585537,-0.05756685510277748,0.07788429409265518,-0.17186719179153442,0.1280917376279831,0.006073446944355965,-0.04347177594900131,-0.035682935267686844,0.1082170382142067,-0.136681467294693,-0.09594898670911789,0.10442358255386353,-0.24763455986976624,0.14865122735500336,0.1748850792646408,-0.004620959982275963,0.16563266515731812,0.08749083429574966,0.08123639971017838,-0.03766607865691185,-0.03147462010383606,-0.1784142255783081,-0.02899363450706005,0.15411266684532166,-0.07027079910039902,0.0975935086607933,-0.014884022064507008]', NULL, 0, NULL, 'Santiago', 'Gatchalian', NULL, NULL, 'Marilao, Bulacan', 'Marilao', 'Bulacan', '109, M. Vill, Prenza, Marilao, Bul', NULL, '109', 'M. Vill', 'Prenza', 'Marilao', 'Bul', NULL, NULL, '71e4b2e0-92e3-460a-b186-994171d9ee43', 'qr_103.png', 1, 1, NULL),
(104, 'Gabriel', 'patient', 1, NULL, '2019-07-27', 'dep_q2sozxhyajuk', NULL, '0999123456', '$2y$12$TZRdje.e8UQoXp6wdhcuf.l04FPxvJ4NMlvKT9dSzOSn8bH6dJiii', NULL, '2026-07-27 15:54:04', '2026-07-27 15:54:26', NULL, NULL, NULL, 0, NULL, NULL, 'Santiago', NULL, NULL, NULL, NULL, NULL, '109, M. Vill, Prenza, Marilao, Bul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9efa35d8-7358-4837-90b4-3f36c267b7de', 'qr_104.png', 1, 1, NULL),
(105, 'Sophia', 'patient', 0, NULL, '2006-11-05', 'Phia', 'sherry1927antonio@gmail.com', '09555964740', '$2y$12$3R87IhoNNCPToATZzI4L1eVLsPHWA60wACfG.WiRDszMQUnkVNOBG', NULL, '2026-07-27 19:09:47', '2026-07-27 19:11:21', NULL, '[-0.08349253982305527,0.06712043285369873,0.011263241991400719,-0.08553657680749893,0.008509393781423569,-0.12459734082221985,0.08182011544704437,-0.11713184416294098,0.1827736645936966,-0.05836128816008568,0.2621144652366638,-0.05425520986318588,-0.1500311642885208,-0.11972560733556747,0.009944369085133076,0.1824679970741272,-0.14180433750152588,-0.09099183976650238,-0.13381388783454895,-0.018184060230851173,-0.017881551757454872,-0.06792867183685303,0.07636047899723053,0.11019935458898544,-0.022058973088860512,-0.3343558609485626,-0.07505407184362411,-0.13020238280296326,0.06465643644332886,-0.009092430584132671,-0.004118279553949833,0.1256033480167389,-0.18729916214942932,-0.07928037643432617,0.03769019618630409,0.04178490862250328,-0.03293253853917122,-0.016943199560046196,0.25156551599502563,-0.0006143970531411469,-0.2043296843767166,-0.07368151843547821,0.04341769590973854,0.269634485244751,0.17784671485424042,0.012815302237868309,0.027149783447384834,-0.0507638044655323,0.06739802658557892,-0.22479619085788727,0.019532721489667892,0.112000972032547,0.09575971961021423,0.0626019686460495,-0.009091074578464031,-0.06841763854026794,0.08076636493206024,0.05558820068836212,-0.25827643275260925,-0.024383602663874626,0.04625939577817917,-0.10666520893573761,-0.14945252239704132,-0.004515266045928001,0.2718360126018524,0.16232441365718842,-0.12601789832115173,-0.10286570340394974,0.1600702702999115,-0.1635955274105072,0.012661545537412167,0.03813450410962105,-0.1314290463924408,-0.16975757479667664,-0.2277306318283081,0.017001282423734665,0.32223883271217346,0.11765430867671967,-0.1696319431066513,0.04982219636440277,-0.1416599154472351,-0.017837001010775566,0.07014110684394836,0.0894288569688797,-0.06651769578456879,0.04808155447244644,-0.0535043329000473,0.00995556265115738,0.12584152817726135,-0.09348946809768677,0.012172498740255833,0.23815712332725525,-0.01781582087278366,-0.025089100003242493,-0.021794065833091736,-0.002139575546607375,-0.02596583217382431,0.007317033130675554,-0.1627863198518753,-0.04814508184790611,0.10007819533348083,-0.0008415674674324691,0.02950853668153286,0.053078822791576385,-0.2591375708580017,0.1097458079457283,0.019848834723234177,-0.01871034875512123,0.0874938890337944,-0.028851812705397606,-0.03562842309474945,-0.1502453088760376,0.10016192495822906,-0.16062285006046295,0.18490727245807648,0.18239305913448334,0.009134833700954914,0.10436519980430603,0.04596904665231705,0.05525989085435867,0.027628591284155846,-0.059434644877910614,-0.12232597917318344,0.008864353410899639,0.13133150339126587,0.010747242718935013,0.01872534677386284,-0.04203754663467407]', NULL, 0, NULL, 'Caguiat', 'Antonio', NULL, NULL, 'Marilao, Bulacan', 'Marilao', 'Bulacan', 'Blk 12 lot 24, Dela Roas, Lambakin, Marilao, Bulcan', NULL, 'Blk 12 lot 24', 'Dela Roas', 'Lambakin', 'Marilao', 'Bulcan', NULL, NULL, '0e04dd97-69bb-4dd0-9038-bea41b3329f7', 'qr_105.png', 1, 1, NULL),
(106, 'Gabriel', 'patient', 1, NULL, '2010-11-27', 'dep_6rfpegewjk2f', NULL, '09555964740', '$2y$12$allp9esdPFZ5mMnB7Ni11.umRFMheUGm/o5rLy7SVfzSjEofk0j5K', NULL, '2026-07-27 19:19:28', '2026-07-27 19:19:56', NULL, NULL, NULL, 0, NULL, 'Caguiat', 'Gutierrez', NULL, NULL, NULL, NULL, NULL, 'Blk 12 lot 24, Dela Roas, Lambakin, Marilao, Bulcan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '45acc452-bced-4bbe-800a-5978adc1af1d', 'qr_106.png', 1, 1, NULL),
(109, 'Luna', 'admin', 0, NULL, NULL, 'Luna', NULL, NULL, '$2y$12$DOBAEIeVa7ZSXUxm0LnFZODUuvsSLHOK4W1nxq./SvfhaIqEYumai', NULL, '2026-07-28 00:29:57', '2026-08-03 13:53:54', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Montenegro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eb041ab6-426e-49ba-8207-c77652d63162', 'qr_109.png', NULL, NULL, '2026-08-03 13:53:54');
INSERT INTO `users` (`id`, `name`, `account_type`, `is_managed`, `status`, `birth_date`, `user`, `email`, `contact_number`, `password`, `remember_token`, `created_at`, `updated_at`, `face_token`, `face_descriptor`, `position`, `is_verified`, `otp_code`, `middlename`, `lastname`, `suffix`, `birthdate`, `birthplace`, `birthplace_municipality`, `birthplace_province`, `current_address`, `address_other_details`, `address_house_number`, `address_street`, `address_barangay`, `address_municipality`, `address_province`, `verification_id`, `profile_image`, `qr_token`, `qr_code`, `formstatus`, `is_consent`, `deleted_at`) VALUES
(110, 'John Peter', 'patient', 0, NULL, '1996-10-27', 'Peter27', 'peterserapio27@gmail.com', '09069494370', '$2y$12$F.OV1WkTZ25zkSxG1bMdHeepqwZYO7VT1d8QRK.Ai.4hUwTB9x53C', NULL, '2026-08-08 13:07:40', '2026-08-08 13:26:24', NULL, '[-0.14140082895755768,0.1253080517053604,0.02793891727924347,0.047046490013599396,-0.07266877591609955,-0.08471076190471649,-0.11419371515512466,-0.13873103260993958,0.12929676473140717,0.0016374923288822174,0.19912004470825195,-0.016743436455726624,-0.13272972404956818,-0.12661267817020416,-0.036072686314582825,0.13254877924919128,-0.12002390623092651,-0.13843722641468048,-0.02286038175225258,-0.02587626315653324,-0.003622181713581085,0.008981882594525814,0.09644507616758347,0.039549991488456726,-0.12707364559173584,-0.33471569418907166,-0.04356096684932709,-0.14184466004371643,0.00852534081786871,-0.06212105229496956,-0.09032663702964783,0.06014589965343475,-0.17852695286273956,-0.13132211565971375,0.08546136319637299,0.05304873734712601,-0.01588176190853119,0.016077397391200066,0.24404962360858917,0.0480908527970314,-0.22544774413108826,-0.03295944631099701,0.03311879560351372,0.3075837194919586,0.16324469447135925,0.0917457789182663,0.01284838654100895,-0.0785425454378128,0.15622389316558838,-0.17400573194026947,0.1490262746810913,0.14020901918411255,0.0895870178937912,0.0036184932105243206,0.03688134625554085,-0.1349780261516571,-0.0071907974779605865,0.08157291263341904,-0.16854643821716309,0.04360752925276756,0.057121776044368744,-0.051161810755729675,-0.0924627035856247,-0.06354421377182007,0.2259131669998169,0.13211120665073395,-0.07571834325790405,-0.09750515967607498,0.12103808671236038,-0.06428371369838715,-0.06408030539751053,0.07021017372608185,-0.10573536902666092,-0.20742808282375336,-0.29991090297698975,0.03385535627603531,0.4183378219604492,0.0926637053489685,-0.19706866145133972,0.039597101509571075,-0.01785215549170971,-0.05433941259980202,0.07312513142824173,0.14305713772773743,-0.07986928522586823,0.09949957579374313,-0.0271493811160326,-0.04024412855505943,0.16039395332336426,0.00007680058479309082,-0.08677703887224197,0.19047704339027405,-0.03182041272521019,0.07306698709726334,0.06394272297620773,0.043859951198101044,-0.06361835449934006,-0.009350711479783058,-0.15878692269325256,-0.10625231266021729,0.10640954226255417,-0.008370771072804928,0.017086906358599663,0.08360173553228378,-0.2085634469985962,0.10066353529691696,0.0374695286154747,0.03224267065525055,0.026253553107380867,0.0043201325461268425,-0.043403416872024536,-0.08110097795724869,0.09552045166492462,-0.21300813555717468,0.20382234454154968,0.12124715745449066,0.0549997016787529,0.1761440932750702,0.10220510512590408,0.005146202631294727,0.04162584990262985,-0.0007278202101588249,-0.12138912081718445,-0.07046975940465927,0.12320509552955627,0.006464362144470215,0.09805567562580109,0.04489125683903694]', NULL, 0, NULL, 'Caluag', 'Serapio', NULL, NULL, 'Marilao, Bulacan', 'Marilao', 'Bulacan', 'Ph3 blk4 lot 7, None, Sta Rosa 2, Marilao, Bulacan', NULL, 'Ph3 blk4 lot 7', 'None', 'Sta Rosa 2', 'Marilao', 'Bulacan', NULL, NULL, 'd98679da-a2d8-475f-98f7-aa7cbc2ee4e0', 'qr_110.png', 1, 1, NULL),
(111, 'Joan', 'patient', 0, NULL, '2004-01-28', 'Joan28', 'joancaluag.28@gmail.com', '09612709883', '$2y$12$agyXFam0g41RByQZJLfjKu8dTkln./YQdw0qfVaYJmD0fYOlcOvfW', NULL, '2026-08-12 16:00:43', '2026-08-12 16:58:22', NULL, '[-0.10095953196287155,0.09619204699993134,0.030094217509031296,-0.08243487775325775,-0.09017327427864075,-0.032814476639032364,-0.04471079260110855,-0.14599043130874634,0.1543000340461731,-0.10225698351860046,0.19397878646850586,-0.07701725512742996,-0.19942890107631683,-0.07221410423517227,-0.042724449187517166,0.25193461775779724,-0.25689858198165894,-0.1152111142873764,-0.0011028610169887543,-0.03563860431313515,0.034323856234550476,-0.051132507622241974,0.022496584802865982,0.10509208589792252,-0.08749482035636902,-0.3099527060985565,-0.11069045960903168,-0.17743325233459473,-0.03705252334475517,-0.0669354572892189,-0.0921383872628212,0.03594960272312164,-0.14313971996307373,-0.04068223387002945,0.032200880348682404,0.045713961124420166,-0.022846590727567673,-0.08185157924890518,0.15505830943584442,0.016053296625614166,-0.21995952725410461,0.056465230882167816,0.08764680474996567,0.22909727692604065,0.15815050899982452,0.032433345913887024,-0.0009587723761796951,-0.17966535687446594,0.14309358596801758,-0.14114540815353394,0.00397089309990406,0.1275113821029663,0.04671050235629082,0.10394439101219177,-0.019388217478990555,-0.12035162001848221,0.08462932705879211,0.06730557978153229,-0.19598715007305145,0.03642207756638527,0.11493539810180664,-0.08723178505897522,-0.013047607615590096,-0.06867268681526184,0.30082133412361145,0.15494497120380402,-0.1401596963405609,-0.17541325092315674,0.10127711296081543,-0.13121074438095093,-0.09945833683013916,0.03615470230579376,-0.15004195272922516,-0.20077486336231232,-0.22812604904174805,0.016489652916789055,0.34992408752441406,0.16509808599948883,-0.20559045672416687,0.03273303061723709,-0.11539843678474426,-0.05632229894399643,0.13218992948532104,0.2547158896923065,0.021353652700781822,0.04501137137413025,-0.033077068626880646,-0.0344976931810379,0.19929204881191254,-0.08937062323093414,0.030367352068424225,0.28849536180496216,-0.012313405983150005,0.09702752530574799,-0.023965299129486084,-0.006855826824903488,-0.135062575340271,0.05403663590550423,-0.1382209211587906,-0.08698239922523499,-0.016510475426912308,0.0027009244076907635,0.0166514590382576,0.07830365747213364,-0.16913890838623047,0.11273486912250519,0.007497996091842651,0.012002400122582912,-0.017467545345425606,-0.0051265135407447815,-0.03147848695516586,-0.06984341889619827,0.11799802631139755,-0.21661508083343506,0.2314419150352478,0.18161620199680328,0.11712198704481125,0.09554498642683029,0.10705788433551788,0.07817871868610382,-0.009015797637403011,-0.07047558575868607,-0.18719665706157684,0.07012277841567993,0.15678612887859344,-0.05287104845046997,0.06721422076225281,-0.023795468732714653]', NULL, 0, NULL, 'Caluag', 'Zarate', NULL, NULL, 'Tondo Manila, Bulacan', 'Tondo Manila', 'Bulacan', 'Ph3 blk4 lot 7, Estrella Homes, Sta rosa 2, Marilao, Bulacan', NULL, 'Ph3 blk4 lot 7', 'Estrella Homes', 'Sta rosa 2', 'Marilao', 'Bulacan', NULL, '6a7c30acdef71.jpg', '06ffcd36-bade-4dd5-82d3-69fa499aa086', 'qr_111.png', 1, 1, NULL),
(112, 'Celestine', 'patient', 0, NULL, '2000-07-23', 'Celestine', 'celestinevalentin0813@gmail.com', '09708505234', '$2y$12$7/WnmF7LkE8vqYF9SpTySudYO76ql0O9syVtUxlFkxkOpzinNBtQS', 'fr1Jp1doh5HgQbwnFJmUrefN6OMMG7tGRh0UcP7KDmPNPeo0QSml3ggDmVlQ', '2026-08-13 09:18:24', '2026-08-13 12:47:08', NULL, '[-0.13768748939037323,0.07062971591949463,0.07099730521440506,-0.06528621166944504,-0.1134905070066452,-0.07592365890741348,0.012368849478662014,-0.08902502059936523,0.23185870051383972,-0.10933027416467667,0.2907411754131317,-0.06156594306230545,-0.19274386763572693,-0.12115949392318726,-0.06035177782177925,0.23582299053668976,-0.1606319397687912,-0.09946026653051376,-0.035940021276474,0.014714986085891724,0.08481576293706894,-0.0416494719684124,0.015595587901771069,0.13173414766788483,-0.0940166711807251,-0.34954753518104553,-0.08913484960794449,-0.15747858583927155,0.02191098965704441,-0.08148442208766937,-0.055881794542074203,0.060883354395627975,-0.13902583718299866,-0.11518178135156631,-0.01170655433088541,0.058146312832832336,-0.08362340182065964,-0.04650979861617088,0.20837238430976868,-0.04244576022028923,-0.28171306848526,-0.0776420310139656,0.053263477981090546,0.22724828124046326,0.19300758838653564,0.06594404578208923,0.0666104182600975,-0.11856900900602341,0.1275053471326828,-0.25501748919487,0.03168126568198204,0.10980897396802902,0.09384913742542267,0.03899074345827103,0.05629558116197586,-0.1941782385110855,0.0038225133903324604,0.12459222227334976,-0.23074029386043549,-0.010594718158245087,0.007380950264632702,-0.06658031791448593,-0.021726718172430992,-0.027380164712667465,0.3024197518825531,0.12455619126558304,-0.14653600752353668,-0.07492377609014511,0.28722259402275085,-0.15508916974067688,0.003913499880582094,0.07527109980583191,-0.11984069645404816,-0.213482066988945,-0.30904021859169006,-0.027959711849689484,0.45524147152900696,0.07543151080608368,-0.1550731062889099,0.03915167599916458,-0.14701269567012787,-0.028332341462373734,0.03463037312030792,0.14605830609798431,-0.012391917407512665,0.001883610151708126,-0.08741214871406555,-0.0689229816198349,0.1443086862564087,-0.08271849155426025,0.06973078101873398,0.223647803068161,0.03323002904653549,-0.0002545572060626,0.02556777186691761,0.05428926646709442,-0.1216658502817154,0.01375147420912981,-0.12056095898151398,-0.022939784452319145,-0.030775977298617363,-0.05048128589987755,0.002736269496381283,0.08032843470573425,-0.22551198303699493,0.14765800535678864,0.033158302307128906,-0.01202335674315691,-0.028536396101117134,-0.025722147896885872,-0.05117443948984146,-0.08972159028053284,0.1360970288515091,-0.22000156342983246,0.16158686578273773,0.13961154222488403,0.025008220225572586,0.20500530302524567,0.059318892657756805,0.09848392009735107,-0.014332938008010387,-0.1103597953915596,-0.18274691700935364,0.010029513388872147,0.08928513526916504,-0.09746841341257095,0.03754402697086334,0.02662128396332264]', NULL, 0, NULL, NULL, 'Valentin', 'II', NULL, 'Dasmariñas, Cavite', 'Dasmariñas', 'Cavite', '91, Maligaya, Patubig, Marilao, Bulacan', NULL, '91', 'Maligaya', 'Patubig', 'Marilao', 'Bulacan', NULL, NULL, '64448ba8-8e06-416c-bd2f-e909b4f578bc', 'qr_112.png', 1, 1, NULL),
(113, 'Crystal', 'patient', 1, NULL, '2026-08-13', 'dep_1gjp3aap54dm', NULL, '0970850534', '$2y$12$4eWKtbFr9X3Tsv4zDvYmXOOsMD6CnDhWBQGu2supma4R3lTDZnbKO', NULL, '2026-08-13 09:21:17', '2026-08-13 09:21:44', NULL, NULL, NULL, 0, NULL, NULL, 'Mabini', NULL, NULL, NULL, NULL, NULL, '91, Maligaya, Patubig, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0b7604bd-f2fd-4eb6-bc3b-8dc81f248d7c', 'qr_113.png', 1, 1, NULL);

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
-- Indexes for table `doctor_schedules`
--
ALTER TABLE `doctor_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctor_schedule_unique` (`dentist_id`,`store_id`,`schedule_date`),
  ADD KEY `doctor_schedules_store_id_foreign` (`store_id`),
  ADD KEY `doctor_schedules_schedule_date_index` (`schedule_date`);

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
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_to_store_id_foreign` (`to_store_id`),
  ADD KEY `messages_store_id_to_store_id_index` (`store_id`,`to_store_id`);

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
-- Indexes for table `parent_child_links`
--
ALTER TABLE `parent_child_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_child_unique` (`parent_user_id`,`child_user_id`),
  ADD UNIQUE KEY `parent_child_links_verification_token_unique` (`verification_token`),
  ADD KEY `parent_child_links_child_user_id_index` (`child_user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_medications_user_id_foreign` (`user_id`),
  ADD KEY `patient_medications_appointment_id_foreign` (`appointment_id`);

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
  ADD KEY `sales_patient_id_foreign` (`patient_id`),
  ADD KEY `sales_appointment_id_index` (`appointment_id`);

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
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_logs_status_index` (`status`),
  ADD KEY `sms_logs_created_at_index` (`created_at`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_schedule_overrides`
--
ALTER TABLE `store_schedule_overrides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_schedule_overrides_store_id_schedule_date_unique` (`store_id`,`schedule_date`);

--
-- Indexes for table `store_staff`
--
ALTER TABLE `store_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_staff_store_id_foreign` (`store_id`),
  ADD KEY `store_staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `daily_logs`
--
ALTER TABLE `daily_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `dental_charts`
--
ALTER TABLE `dental_charts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `dental_teeth`
--
ALTER TABLE `dental_teeth`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `doctor_schedules`
--
ALTER TABLE `doctor_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `medicine_movements`
--
ALTER TABLE `medicine_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `parent_child_links`
--
ALTER TABLE `parent_child_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `patient_medications`
--
ALTER TABLE `patient_medications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `patient_records`
--
ALTER TABLE `patient_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `store_schedule_overrides`
--
ALTER TABLE `store_schedule_overrides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `store_staff`
--
ALTER TABLE `store_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

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
-- Constraints for table `doctor_schedules`
--
ALTER TABLE `doctor_schedules`
  ADD CONSTRAINT `doctor_schedules_dentist_id_foreign` FOREIGN KEY (`dentist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_schedules_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `messages_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_to_store_id_foreign` FOREIGN KEY (`to_store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parent_child_links`
--
ALTER TABLE `parent_child_links`
  ADD CONSTRAINT `parent_child_links_child_user_id_foreign` FOREIGN KEY (`child_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parent_child_links_parent_user_id_foreign` FOREIGN KEY (`parent_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD CONSTRAINT `patient_medications_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patient_medications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_records`
--
ALTER TABLE `patient_records`
  ADD CONSTRAINT `patient_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `store_schedule_overrides`
--
ALTER TABLE `store_schedule_overrides`
  ADD CONSTRAINT `store_schedule_overrides_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

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
