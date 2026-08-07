-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2026 at 04:33 AM
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
-- Database: `dentaease`
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
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_image` varchar(255) DEFAULT NULL,
  `service_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`service_ids`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `store_id`, `user_id`, `dentist_id`, `appointment_date`, `appointment_time`, `booking_end_time`, `status`, `appointment_type`, `arrived_at`, `desc`, `created_at`, `updated_at`, `work_done`, `total_price`, `payment_type`, `payment_image`, `service_ids`) VALUES
(100, 1, 82, 26, '2026-05-02', '09:00:00', '09:45:00', 'completed', 'scheduled', NULL, NULL, '2026-05-01 22:06:25', '2026-05-01 22:07:26', NULL, 1000.00, 'GCASH', NULL, '[\"1\",\"3\"]'),
(101, 1, 82, 26, '2026-05-04', '09:00:00', '10:00:00', 'approved', 'scheduled', NULL, NULL, '2026-05-01 22:09:39', '2026-05-01 22:09:48', NULL, NULL, NULL, NULL, '[\"3\",\"4\"]');

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
(45, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-01 00:27:11', '2026-05-01 00:27:11'),
(46, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-01 20:43:38', '2026-05-01 20:43:38');

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
(72, 82, '54', '{\"center\":{\"group\":\"restoration\",\"code\":\"Ab\",\"color\":\"#a855f7\"}}', '2026-05-01 20:38:25', '2026-05-01 20:38:25'),
(73, 82, '52', '{\"left\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"},\"center\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"},\"right\":{\"group\":\"restoration\",\"code\":\"P\",\"color\":\"#f97316\"}}', '2026-07-10 02:21:12', '2026-07-10 02:21:18'),
(74, 82, '53', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"Att\",\"color\":\"#ec4899\"}}', '2026-07-10 02:21:20', '2026-07-10 02:21:20'),
(75, 82, '55', '{\"left\":{\"group\":\"restoration\",\"code\":\"Imp\",\"color\":\"#14b8a6\"}}', '2026-07-10 02:21:45', '2026-07-10 02:21:45'),
(76, 82, '61', '{\"bottom\":{\"group\":\"restoration\",\"code\":\"S\",\"color\":\"#84cc16\"}}', '2026-07-10 02:32:02', '2026-07-10 02:32:02');

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
(4, 4, 1, 4, '2025-09-18', '2025-09-17 02:52:50', '2026-05-01 21:58:32', 'expired'),
(5, 5, 1, 0, '2026-01-01', '2025-10-07 23:24:15', '2026-01-11 23:37:47', 'suspended'),
(6, 6, 1, 20, '2026-01-13', '2026-01-13 02:28:32', '2026-01-13 02:28:54', 'expired'),
(7, 1, 1, 8, '2026-02-02', '2026-02-02 06:45:00', '2026-05-01 21:34:15', 'expired'),
(8, 1, 1, 20, '2027-02-28', '2026-02-02 06:45:30', '2026-05-01 22:07:10', 'active'),
(9, 2, 1, 6, '2029-02-14', '2026-02-02 06:46:24', '2026-05-01 22:07:10', 'active'),
(10, 3, 1, 50, '2026-02-26', '2026-02-25 15:00:35', '2026-02-25 15:00:35', 'active'),
(11, 4, 1, 100, '2026-02-25', '2026-02-25 15:01:07', '2026-02-25 15:01:18', 'suspended'),
(12, 4, 1, 70, '2026-02-25', '2026-02-25 15:01:34', '2026-02-25 15:03:09', 'expired'),
(13, 5, 1, 57, '2026-02-26', '2026-02-25 15:01:55', '2026-05-01 21:58:32', 'active'),
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
(42, 2, 2, 2, 'stock_out', -2, 'Sale #14', '2026-04-01 00:26:58', '2026-04-01 00:26:58'),
(43, 1, 1, 7, 'stock_out', -5, 'Sale #15', '2026-05-01 21:07:22', '2026-05-01 21:07:22'),
(44, 1, 1, 7, 'stock_out', -5, 'Sale #16', '2026-05-01 21:14:15', '2026-05-01 21:14:15'),
(45, 2, 1, 9, 'stock_out', -5, 'Sale #16', '2026-05-01 21:14:15', '2026-05-01 21:14:15'),
(46, 1, 1, 7, 'stock_out', -1, 'Sale #17', '2026-05-01 21:21:43', '2026-05-01 21:21:43'),
(47, 2, 1, 9, 'stock_out', -1, 'Sale #17', '2026-05-01 21:21:43', '2026-05-01 21:21:43'),
(48, 1, 1, 7, 'stock_out', -1, 'Sale #18', '2026-05-01 21:34:15', '2026-05-01 21:34:15'),
(49, 5, 1, 13, 'stock_out', -2, 'Sale #18', '2026-05-01 21:34:15', '2026-05-01 21:34:15'),
(50, 1, 1, 8, 'stock_out', -10, 'Sale #19', '2026-05-01 21:57:09', '2026-05-01 21:57:09'),
(51, 2, 1, 9, 'stock_out', -8, 'Sale #19', '2026-05-01 21:57:09', '2026-05-01 21:57:09'),
(52, 5, 1, 13, 'stock_out', -1, 'Sale #20', '2026-05-01 21:58:32', '2026-05-01 21:58:32'),
(53, 4, 1, 4, 'stock_out', -1, 'Sale #20', '2026-05-01 21:58:32', '2026-05-01 21:58:32'),
(54, 1, 1, 8, 'stock_out', -10, 'Sale #21', '2026-05-01 22:07:10', '2026-05-01 22:07:10'),
(55, 2, 1, 9, 'stock_out', -5, 'Sale #21', '2026-05-01 22:07:10', '2026-05-01 22:07:10');

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
(31, 2, 30, NULL, '494579798_693373853415594_8083316453582063649_n.jpg', 0, '2026-01-15 00:42:41', '2026-01-15 00:42:41', 'file', 'chat_files/P1KgcS9fxofq2YsvhwBMvgZu1J4MDUHj14uV8aVs.jpg', NULL),
(32, 2, 30, NULL, 'Birth-Certificate-Template-10.jpg', 0, '2026-01-15 00:43:06', '2026-01-15 00:43:06', 'file', 'chat_files/SM6KfMDydhIg50aRRoOO6K1jJZVVzPdw14O6O7Et.jpg', NULL),
(34, 2, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:50:26', '2026-01-15 00:50:26', 'file', 'chat_files/qwxKPUagFmpUm3td3pBcPIqKnZVamEDh7wfasD1l.jpg', NULL),
(35, 2, 30, NULL, 'Info-Website-19.jpg', 0, '2026-01-15 00:50:49', '2026-01-15 00:50:49', 'file', 'chat_files/OXjOk8qYHzIJrOIJPwQgjMCd8wwGDpr5g3t9bOxq.jpg', NULL),
(37, 2, 30, NULL, 'java-programming-tutorial.jpg', 0, '2026-01-15 00:58:33', '2026-01-15 00:58:33', 'file', 'chat_files/3yZcalFyMo30kspMqr8t9Z33qChykyTLzIRQYIZi.jpg', NULL);

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
(59, '2026_05_01_120000_create_store_schedule_overrides_table', 18),
(60, '2026_05_01_120100_create_doctor_schedules_table', 18),
(61, '2026_05_01_120200_create_parent_child_links_table', 19),
(62, '2026_05_04_100000_add_verification_to_parent_child_links_table', 20),
(63, '2026_07_02_000000_add_is_managed_to_users_table', 21),
(64, '2026_07_10_000000_create_patient_medications_table', 22),
(65, '2026_07_19_000001_add_appointment_type_to_appointments_table', 23);

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
('08ec17ae-bded-48e6-963a-26745aac3068', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 2, 2026 (9:00 AM - 10:00 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 21:13:27', '2026-07-02 08:21:15'),
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
('194c30db-d544-4f19-acdc-60a624554ac1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 2, 2026 (9:00 AM - 9:45 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 22:06:41', '2026-07-02 08:21:15'),
('1b37f983-c7fb-4599-be9c-cc36efa3e4ef', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 12, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on March 5, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-03-05 22:27:16', '2026-03-05 17:33:58', '2026-03-05 22:27:16'),
('1ceb9463-7a8f-468e-b9b4-5566af5ced8f', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 13, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved and updated at Prenza 1 Santiago-Amancio Branch\",\"url\":null}', NULL, '2025-09-07 22:33:46', '2025-09-07 22:33:46'),
('1dca694d-4a82-4b21-b765-b635b3cd97fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 11, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 5, 2025 (9:10 AM - 9:25 AM)\",\"url\":null}', NULL, '2025-11-24 16:22:47', '2025-11-24 16:22:47'),
('23ffb69a-ef3c-4b52-8f07-8a2bc0d131b2', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 64, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment at Lambakin Santiago-Amancio Branch has been cancelled.\",\"url\":null}', '2026-01-20 13:30:46', '2026-01-20 13:30:17', '2026-01-20 13:30:46'),
('2593b66f-a9f0-4306-b338-e2ef960139c1', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:11', '2025-11-26 20:42:11'),
('2c0b8360-faef-41b2-84f1-f8c6e8bca7fc', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 8, '{\"title\":\"Appointment Rescheduled\",\"message\":\"Your appointment time has been changed at Prenza 1 Santiago-Amancio Branch to September 3, 2025 (10:30 AM - 11:30 AM)\",\"url\":null}', NULL, '2025-11-26 20:42:10', '2025-11-26 20:42:10'),
('2ccc4c92-984a-48f0-8c50-804be8dd0b10', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 9, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 21:49:47', '2026-07-02 08:21:15'),
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
('7243fac0-9d8c-4e66-ba45-5bd6c7ccaf54', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 1, 2026 (9:00 AM - 9:15 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 10:04:09', '2026-07-02 08:21:15'),
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
('b4d5be5c-4083-4279-b5e4-c45dbf43daef', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 4, 2026 (9:00 AM - 10:00 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 22:09:52', '2026-07-02 08:21:15'),
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
('e906ca0b-78b2-412d-bcf7-cb8a229130be', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 82, '{\"title\":\"Appointment Approved\",\"message\":\"Your appointment has been approved at Prenza 1 Santiago-Amancio Branch on May 2, 2026 (9:00 AM - 9:45 AM)\",\"url\":null}', '2026-07-02 08:21:15', '2026-05-01 21:29:12', '2026-07-02 08:21:15'),
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
(5, 82, 85, 'Grandparent', 'active', NULL, NULL, '2026-07-02 07:52:34', '2026-07-02 07:52:34');

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
(1, 82, 101, 'Mefenamic Acid (MG)', NULL, '1x daily', '2026-07-10', '2026-07-24', '10, morning, 2 weeks', '2026-07-10 01:56:46', '2026-07-10 01:56:46');

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
(45, 'pedro', 'juan', 'san', NULL, '2000-04-10', NULL, NULL, NULL, NULL, 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09454454744', 'andersonandy046@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-05-01 00:18:38', '2026-05-01 00:26:11', 82),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, '2026-05-01 20:43:38', '2026-05-01 20:43:38', 26),
(47, 'pedro', 'juan', 'san', NULL, '2000-04-10', NULL, NULL, NULL, NULL, 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09454454744', 'padillajoshuaanderson.pdm@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-05-04 01:51:00', '2026-05-04 01:51:12', 84),
(48, 'marcos', 'bong bong', NULL, NULL, '2026-07-02', NULL, NULL, NULL, NULL, 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09454454744', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, '2026-07-02 07:53:01', '2026-07-02 07:53:24', 85);

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
  `payment_method` varchar(30) DEFAULT NULL,
  `status` enum('pending','completed','void') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `store_id`, `user_id`, `patient_id`, `total_amount`, `amount_given`, `change_amount`, `payment_method`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(21, 1, 26, 82, 85.00, 85.00, 0.00, 'cash', 'completed', NULL, '2026-05-01 22:07:10', '2026-05-01 22:07:10');

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
(27, 21, 1, 8, 10, 5.00, 50.00, '2026-05-01 22:07:10', '2026-05-01 22:07:10'),
(28, 21, 2, 9, 5, 7.00, 35.00, '2026-05-01 22:07:10', '2026-05-01 22:07:10');

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
('hdlF9uyX2rPeD81RxDFo1gffNPAJQYNNCcd4ftMP', 26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaE1zWE1USEx3RE43QURZVkFwckdldGpCeGx6bURCU1doRm5ubTV0UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcHBvaW50bWVudHMvMTAxL3ZpZXc/dGFiPXBvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTY6ImFjdGl2ZV9icmFuY2hfaWQiO3M6MToiMSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjY7czoxODoicG9zX2FwcG9pbnRtZW50X2lkIjtzOjM6IjEwMSI7fQ==', 1783651439),
('tCsnvKXjaALXXSSrKtXT1jkQPkeHHmwR7eYBujcX', 82, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib1ljVDFiTDZhNG02U2t4Q1FaYkdNMjVqTks3TFJaZ2RWU2hMS0FvNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwcG9pbnRtZW50cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmFnZS9xcl9jb2Rlcy9xcl84Mi5wbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4Mjt9', 1783651380),
('tgn2V0KcY09We72tZGyNPvXSftsGew7TIvUEOiS8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.128.0 Chrome/148.0.7778.271 Electron/42.5.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiako2czllMExKNUhWR01OU1dXVlk1WnBBd05ZYm93Tjdmc01HUEk4byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdG9yYWdlL3Byb2ZpbGVfcGljdHVyZXMvNjhlZTVlOWVjMjcxNy5qcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783649438);

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
(11, 4, 10, 'Receptionist', '2025-09-15 00:07:11', '2025-09-15 00:07:11'),
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
(1, 'qwe', 'admin', 0, NULL, NULL, 'qwe', NULL, '09999999999', '$2y$12$ML4eIg4E/VG4TIj86ej/VO1kS5QraTFPgFyNMeTOSLAWfOtorjrS2', NULL, '2025-08-17 21:59:37', '2026-01-31 18:35:11', NULL, NULL, 'admin', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68e4e9569f302.jpg', '675945c8-a059-460a-a730-929e7278e77b', 'qr_1.svg', 1, NULL, '2026-01-31 18:35:11'),
(3, 'Lenard', 'admin', 0, NULL, NULL, 'Lenard', NULL, NULL, '$2y$12$CY4Ri9701m3pxpeUHYKDreasUDBb5oMVBU15PzuFNJYke04ihwqjC', NULL, '2025-08-28 04:20:40', '2025-10-14 03:15:08', NULL, NULL, 'admin', 0, NULL, 'Espiritu', 'Dela Cruz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca948182392.jpeg', '03c1317c-0873-453a-98bc-45dc30eefb46', 'qr_3.svg', NULL, NULL, '2025-10-14 03:15:08'),
(6, 'Dhan Leonardo', 'admin', 0, NULL, NULL, 'Dhan', 'dhanalfonso@gmail.com', '09949499451', '$2y$12$8tUA.9MFvd3FTlc5KP/1qOikWOQQItOG1dPuM3xIBDKUn4vrYg0IG', NULL, '2025-08-28 04:22:37', '2025-10-14 03:18:33', NULL, NULL, 'Dentist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ca9264a1933.jpg', '13adc600-df57-47d9-90e9-7ce8922bc213', 'qr_6.svg', NULL, NULL, '2025-10-14 03:18:33'),
(7, 'Czarina Jade', 'admin', 0, NULL, NULL, 'CzarinaJade', 'baroraczarinajade@gmail.com', '09339247279', '$2y$12$rT6EqmpfPrn3WRzPvHbVWe0ba7/aIXrujMLyUBtmqDU3FqkMCHDc6', NULL, '2025-08-28 04:22:59', '2025-10-14 03:18:51', NULL, NULL, 'Dentist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f9fd8277.jpg', '5fafe406-8d05-410f-a568-dc498536ed63', 'qr_7.svg', NULL, NULL, '2025-10-14 03:18:51'),
(8, 'Dani', 'admin', 0, NULL, NULL, 'Dani', 'kimjeonlee03@gmail.com', '09183239884', '$2y$12$IEtaGQqw3dTufz2Mv0zexuY2ngItaE2CMxMzsFK0if3Wkm4GQ0OVy', NULL, '2025-08-28 04:23:22', '2025-10-14 03:12:40', NULL, NULL, 'Receptionist', 0, NULL, 'Gomez', 'Alfonso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80f02c7c4a.jpg', 'e58ed137-2f8c-44c2-b2f0-de9175fec727', 'qr_8.svg', NULL, NULL, '2025-10-14 03:12:40'),
(9, 'Czarina Jade', 'admin', 0, NULL, NULL, 'Jade', 'barorac.26@gmail.com', '09515170014', '$2y$12$7C9E2l4cktpftWutmb/JReyxjUW5GfFDZH7oim1zllZJrywiUm1jK', NULL, '2025-08-28 04:23:41', '2025-10-14 03:13:12', NULL, NULL, 'Receptionist', 0, NULL, 'Mabini', 'Barora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c80ed97b4b1.jpg', '53b8edf5-c5c9-4858-9823-8cd76b87592b', 'qr_9.svg', NULL, NULL, '2025-10-14 03:13:12'),
(10, 'Joan Gail', 'admin', 0, NULL, NULL, 'Joan', 'zaratejoangail1028@gmail.com', '09949499453', '$2y$12$s.avtG/WCQ.Wh9p4rSRSye3J7p60d4raO1z3C/11Xx/eh7j.dSa7u', NULL, '2025-08-28 04:24:10', '2025-10-14 03:13:58', NULL, NULL, 'Receptionist', 0, NULL, 'Caluag', 'Zarate', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68c7cac583e00.jpg', 'c242a93c-9a22-4f90-8b93-6da6484d09d7', 'qr_10.svg', NULL, NULL, '2025-10-14 03:13:58'),
(16, 'Lailla', 'admin', 0, NULL, NULL, 'Lailacruz', NULL, NULL, '$2y$12$eds0wqa7ZhyECiTv/lN/v.N0hT/JSVwzGs8bNYkY14IjAR6Jho5hC', NULL, '2025-10-07 22:22:18', '2025-10-14 03:19:04', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Gomez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eb39a2c8-1713-4c7f-96d6-e3faada76655', 'qr_16.svg', NULL, NULL, '2025-10-14 03:19:04'),
(17, 'Elijah', 'admin', 0, NULL, NULL, 'Elijahvergara', NULL, NULL, '$2y$12$3BoNQleFlwyRVFbdNN9TVe3c21VQCrm1oaxceV5WwSgSawJOTjfqC', NULL, '2025-10-07 22:26:37', '2025-10-14 03:20:20', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Vergara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2ca00ba3-1321-4fc4-9164-57f19a52a12f', 'qr_17.svg', NULL, NULL, '2025-10-14 03:20:20'),
(22, 'Admin', 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, '$2y$12$D3wdaMRxqMXOqcb/KSsACO6VtDbh9JtR8rZC08Lov/kcxo1i0XNNC', NULL, '2025-10-14 03:20:43', '2026-04-10 03:50:47', NULL, NULL, 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10a7d672-b0e8-4844-8fa5-6e085fc9cda1', 'qr_22.png', NULL, NULL, NULL),
(24, 'Admin', 'admin', 0, NULL, NULL, 'Admin1', NULL, NULL, '$2y$12$drlKxr8WLRK585/yF6O8uuU7o5a6KrdV7h7kJr.5ER4MixldzWJFi', NULL, '2025-10-14 03:41:10', '2025-10-14 03:41:42', NULL, NULL, 'admin', 0, NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3dc25ae5-e654-4de6-b060-6185eeefd593', 'qr_24.svg', NULL, NULL, '2025-10-14 03:41:42'),
(26, 'Marieta', 'admin', 0, NULL, NULL, 'Marieta', NULL, NULL, '$2y$12$kH2iZejDSvlN5k.hJStnceguLgw48MOI.nAWkBLC09gIMTX4xJVuO', NULL, '2025-10-14 04:00:26', '2026-05-01 10:31:34', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69f3eef7534f9.jpg', '48cd6954-bbab-4780-a36b-664f2fe91f98', 'qr_26.png', NULL, NULL, NULL),
(30, 'Abelardo', 'admin', 0, NULL, NULL, 'Abelardo', NULL, NULL, '$2y$12$mL6AtGGDgpcQJT5abHGPouhFMpD4yqWWkX9jExq9c4M3mzR81bMtS', NULL, '2025-10-14 04:01:43', '2026-04-10 03:50:47', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Santiago', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5e9ec2717.jpg', '7621a5ee-c885-4b31-be50-add793034a58', 'qr_30.png', NULL, NULL, NULL),
(31, 'Sophia', 'admin', 0, NULL, NULL, 'Sophia', NULL, NULL, '$2y$12$/f3VFNvlFsXapaMydrtgc.ynMKscMXDdv2HGP3PrGrM3L9oxrJIRG', NULL, '2025-10-14 04:02:20', '2026-04-10 03:50:47', NULL, NULL, 'Dentist', 0, NULL, NULL, 'Amancio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5a4bed193.jpg', '96284677-af80-4bc6-b5ee-fed5909129b9', 'qr_31.png', NULL, NULL, NULL),
(32, 'Mhara Grace', 'admin', 0, NULL, NULL, 'Mhara Grace', NULL, NULL, '$2y$12$eS9gRRYHwh2hriuX5Zf7Wu.X/q5i2qNZseiQmp8si1oSMyKw92kLi', NULL, '2025-10-14 04:03:05', '2026-04-10 03:50:47', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Robles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5b9f26481.jpg', '2cc4edc4-a649-4c73-a3f4-e4c93ece931c', 'qr_32.png', NULL, NULL, NULL),
(33, 'Sherry', 'admin', 0, NULL, NULL, 'Sherry', NULL, NULL, '$2y$12$gU64TU4ZXztAausvkac4C.Mr6mtXaP9zVsxWQbg0bYlMNvlaBVsIS', NULL, '2025-10-14 04:03:54', '2026-04-10 03:50:47', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Antonio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5bcd2729b.jpg', '167c88e2-c720-4f7d-8c77-20c25d71d3bd', 'qr_33.png', NULL, NULL, NULL),
(34, 'Gloria', 'admin', 0, NULL, NULL, 'Gloria', NULL, NULL, '$2y$12$yvY7M7VZ0WUG.25tRUIhje7nzap8mFqXzhe4rIYIPisWBOBhaTQ42', NULL, '2025-10-14 04:06:07', '2026-04-10 03:50:47', NULL, NULL, 'Receptionist', 0, NULL, NULL, 'Espiritu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68ee5c7790e93.jpg', 'fcdbc738-256e-4d51-9f7f-db9455533af5', 'qr_34.png', NULL, NULL, NULL),
(82, 'juan', 'patient', 0, NULL, '2000-04-10', 'andersonandy046', 'andersonandy046@gmail.com', '09454454744', '$2y$12$FOk8QxWNoAUl8GOyjqk9SOZQknbT8uiV.ED2i8ssJcEUb4AE1csNa', NULL, '2026-05-01 00:18:20', '2026-07-09 03:55:54', NULL, NULL, NULL, 0, NULL, 'san', 'pedro', NULL, NULL, 'Sta.Maria, Bulacan', 'Sta.Maria', 'Bulacan', 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', 'Apartment', '9999', 'tibagan', 'sta.rosa 2', 'Marilao', 'Bulacan', NULL, NULL, '5c25fe20-295d-431b-9be9-201db3e52b6b', 'qr_82.png', 1, 1, NULL),
(84, 'padilla joshua', 'patient', 0, NULL, '2000-04-10', 'padillajoshuaanderson.pdm', 'padillajoshuaanderson.pdm@gmail.com', '09454454744', '$2y$12$PRQVDYoyY64vWP7or/AmueuQtwYgr6jxvuppDsq7/9FuCU6vTos2W', NULL, '2026-05-04 01:50:44', '2026-05-04 01:51:12', NULL, NULL, NULL, 0, NULL, 'san', 'pedro', NULL, NULL, 'Sta.Maria, Bulacan', 'Sta.Maria', 'Bulacan', 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', 'Apartment', '9999', 'tibagan', 'sta.rosa 2', 'Marilao', 'Bulacan', NULL, NULL, '5e7c353f-7ebb-4cb0-991b-781800b1a13a', 'qr_84.png', 1, 1, NULL),
(85, 'bong bong', 'patient', 1, NULL, '2026-07-02', 'dep_vocyo6navohk', NULL, '09454454744', '$2y$12$eLs4J7abyQW/BYkmZQ2dQOiK.9XzmVFNU3DpkvqIwltfDf5.9DBaq', NULL, '2026-07-02 07:52:33', '2026-07-02 07:53:24', NULL, NULL, NULL, 0, NULL, NULL, 'marcos', NULL, NULL, NULL, NULL, NULL, 'Apartment, 9999, tibagan, sta.rosa 2, Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14e422cd-8e4a-4ce7-a09e-945a7b138c1a', 'qr_85.png', 1, 1, NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `daily_logs`
--
ALTER TABLE `daily_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dental_charts`
--
ALTER TABLE `dental_charts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `dental_teeth`
--
ALTER TABLE `dental_teeth`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `doctor_schedules`
--
ALTER TABLE `doctor_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `parent_child_links`
--
ALTER TABLE `parent_child_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_medications`
--
ALTER TABLE `patient_medications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_records`
--
ALTER TABLE `patient_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_schedule_overrides`
--
ALTER TABLE `store_schedule_overrides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_staff`
--
ALTER TABLE `store_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

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
  ADD CONSTRAINT `messages_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

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
