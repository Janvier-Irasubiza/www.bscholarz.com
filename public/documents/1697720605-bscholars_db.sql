-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 08:18 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bscholars_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` bigint(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `owner_phone` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` int(20) NOT NULL,
  `payment_circle` varchar(100) NOT NULL DEFAULT 'daily',
  `amount_gen` int(50) NOT NULL,
  `posted_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_taken` varchar(255) NOT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `media` varchar(255) NOT NULL,
  `media_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `owner`, `owner_phone`, `type`, `amount`, `payment_circle`, `amount_gen`, `posted_on`, `time_taken`, `expiry_date`, `media`, `media_type`, `status`) VALUES
(1, 'MTN Isanzure', 'MTN', '', 'Primary', 2000, 'daily', 78000, '2023-09-05 11:16:15', '', '2023-10-25 11:15:07', 'photo6.webp', 'image', 'active'),
(3, 'RBA', 'RBA', 'RBA', 'Primary', 34567, 'RBA', 0, '2023-10-14 13:01:06', '', '2023-11-11 13:00:00', '1697288466-Hacker logo.jpg', 'image/jpeg', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_documents`
--

CREATE TABLE `applicant_documents` (
  `id` bigint(100) NOT NULL,
  `applicant` bigint(100) NOT NULL,
  `document` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_documents`
--

INSERT INTO `applicant_documents` (`id`, `applicant`, `document`) VALUES
(8, 1, '1697633400-served_requests.sql'),
(9, 1, '1697633444-bscholars_db.sql'),
(10, 1, '1697634197-Electronic Diversity Visa Program - page2.pdf'),
(11, 7, '1697638348-Electronic Diversity Visa Program - page1.1.pdf'),
(12, 7, '1697638348-Electronic Diversity Visa Program - page1.pdf'),
(13, 8, '1697638579-Electronic Diversity Visa Program - page2.pdf'),
(14, 8, '1697638579-Electronic Diversity Visa Program - page1.pdf'),
(15, 9, '1697640811-Electronic Diversity Visa Program - page2.pdf'),
(16, 10, '1697640934-Electronic Diversity Visa Program - page2.pdf'),
(17, 11, '1697644934-Electronic Diversity Visa Program - page1.1.pdf'),
(18, 11, '1697644934-Electronic Diversity Visa Program - page1.pdf'),
(19, 12, '1697645760-Electronic Diversity Visa Program - page1.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_education_info`
--

CREATE TABLE `applicant_education_info` (
  `id` bigint(100) NOT NULL,
  `applicant` bigint(100) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `graduation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_education_info`
--

INSERT INTO `applicant_education_info` (`id`, `applicant`, `education_level`, `institution`, `graduation_date`) VALUES
(1, 4, 'Level 1', 'Inst 1', '2023-11-06'),
(2, 4, 'Level 2', 'Inst 2', '2023-10-24'),
(3, 4, 'Level 3', 'Inst 3', '2023-10-23'),
(4, 5, 'A0', 'UR', '2023-10-23'),
(5, 5, 'A1', 'Bumba', '2023-10-29'),
(103, 1, 'wert', 'werty', '2023-10-19'),
(126, 1, 'fg', 'hgf', '2023-10-21'),
(127, 7, 'A0', 'UR', '2023-10-03'),
(128, 7, 'A1', 'Bumba', '2023-10-24'),
(129, 8, 'A0', 'UR', '2023-10-17'),
(130, 8, 'A1', 'Bumba', '2023-10-10'),
(131, 9, 'fghjk', 'ghjk', '2023-10-24'),
(132, 10, 'cvbnm,', 'vbnm', '2023-10-24'),
(133, 11, 'retyui', 'ortyu', '2023-10-23'),
(134, 12, 'ertyu', 'rtyui', '2023-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_info`
--

CREATE TABLE `applicant_info` (
  `id` bigint(100) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `father_names` varchar(255) DEFAULT NULL,
  `father_email` varchar(255) DEFAULT NULL,
  `father_phone` varchar(20) DEFAULT NULL,
  `mother_names` varchar(255) DEFAULT NULL,
  `mother_email` varchar(255) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `parents_alive` varchar(10) DEFAULT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_info`
--

INSERT INTO `applicant_info` (`id`, `names`, `email`, `phone_number`, `dob`, `gender`, `father_names`, `father_email`, `father_phone`, `mother_names`, `mother_email`, `mother_phone`, `parents_alive`, `guardian`, `country`, `province`, `city`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `profile_picture`) VALUES
(1, 'Janvier IRASUBIZA', 'akcentmsc@gmail.com', '3456789067', '2023-10-03', 'Male', 'ertyuio', 'rtyuio@gmail.com', 'yuio', 'qwer', 'wer@gmai.com', '123456', 'yes', 'John Doe', 'fghjk', 'fghjk', 'fghjk', NULL, '$2y$10$I2YWhUXsofUZLZCOsy80HunlIgMGrftpviCtSCWtoWTgzTGz16TGK', NULL, '2023-10-13 12:34:01', '2023-10-13 12:34:01', '1697631825-P.jpg'),
(4, 'John Doe', 'jd@gmail.com', '123456', '2023-10-17', 'Male', 'qwe', 'jd@gmail.com', '234567', 'qwe', 'jd@gmail.com', '234567', 'yes', NULL, 'RW', 'wer', 'wrewer', NULL, '$2y$10$I2YWhUXsofUZLZCOsy80HunlIgMGrftpviCtSCWtoWTgzTGz16TGK', NULL, NULL, NULL, NULL),
(5, 'James Kabera', 'jameskabera@gmail.com', '1234567', '2023-10-23', 'Male', 'father', 'father@gmailcom', '2345', 'father', 'father@gmailcom', '2345', 'yes', NULL, 'RW', 'kigali', 'Kigali', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'James Kabera', 'jk@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$oEh35dZiZZPwH8hCVRbWB.N/u.6aa/mObaM1kSUOG27CnTNPVvGYi', NULL, '2023-10-15 15:03:57', '2023-10-15 15:03:57', NULL),
(7, 'Maguire', 'mag@gmail.com', '234567890', '2023-10-18', 'Male', 'maguire', 'maguire@gmail.com', '3456789', 'maguire', 'maguire@gmail.com', '3456789', 'yes', NULL, 'RW', 'Kigali', 'Kigali', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Maguire', 'magg@gmail.com', '3456789', '2023-10-01', 'Male', 'Maguire', 'magg@gmail.com', '3456789', 'Maguire', 'magg@gmail.com', '3456789', 'yes', NULL, 'RW', 'Kigali', 'Kigali', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'M', 'h@gmail.com', '4567', '2023-10-16', 'Male', 'fghjk', 'h@gmail.com', '45678', 'fghjk', 'h@gmail.com', '45678', 'yes', NULL, 'fghjk', 'ghjkl', 'jhkl;', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'M', 'akcent@gmail.com', '345678', '2023-10-25', 'Male', 'wert', 'ert@gmail.com', '12132', 'wert', 'ert@gmail.com', '12132', 'yes', NULL, 'xcvbn', 'cvbnm', 'vbnm,', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'bnm', 'ibm@gmail.com', '34567', '2023-10-16', 'Male', 'wertyu', 'ibm@gmail.com', '345678', 'wertyu', 'ibm@gmail.com', '345678', 'yes', NULL, 'ertyu', 'ertyui', 'tryuio', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'wert', 'mail@gmail.com', '34567', '2023-10-02', 'Male', 'werty', 'mail@gmail.com', '34567', 'werty', 'mail@gmail.com', '34567', 'yes', 'ertyui', 'ertyu', 'ertyu', 'rtyui', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `app_id` bigint(100) NOT NULL,
  `applicant` bigint(100) NOT NULL,
  `discipline_id` bigint(100) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'Not yet paid',
  `amount_paid` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `assistant` bigint(100) DEFAULT NULL,
  `served_on` timestamp NULL DEFAULT NULL,
  `assistant_commission` int(20) DEFAULT NULL,
  `remittance_status` varchar(20) NOT NULL DEFAULT 'on hold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`app_id`, `applicant`, `discipline_id`, `request_time`, `payment_status`, `amount_paid`, `payment_date`, `status`, `assistant`, `served_on`, `assistant_commission`, `remittance_status`) VALUES
(1, 4, 14, '2023-10-16 12:35:03', 'Paid', '5000', NULL, 'Complete', 1, '2023-10-16 08:32:02', 2000, 'Paid'),
(2, 5, 6, '2023-10-16 12:48:24', 'Paid', '5000', NULL, 'Complete', 1, '2023-10-16 06:33:18', 2000, 'on hold'),
(3, 4, 11, '2023-10-16 12:48:50', 'Paid', '5000', NULL, 'Complete', 1, NULL, 2000, 'on hold'),
(4, 6, 10, '2023-10-16 14:04:23', 'Not yet paid', NULL, NULL, 'Postponed', NULL, NULL, 0, 'on hold'),
(18, 1, 16, '2023-10-18 12:15:31', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(19, 1, 2, '2023-10-18 12:16:08', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(20, 1, 5, '2023-10-18 12:16:27', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(21, 1, 5, '2023-10-18 12:17:36', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(22, 1, 16, '2023-10-18 12:18:04', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(23, 7, 1, '2023-10-18 14:12:28', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(24, 8, 1, '2023-10-18 14:16:19', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(25, 9, 1, '2023-10-18 14:53:31', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(26, 10, 1, '2023-10-18 14:55:34', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(27, 11, 1, '2023-10-18 16:02:14', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold'),
(28, 12, 1, '2023-10-18 16:16:00', 'Not yet paid', NULL, NULL, 'Pending', NULL, NULL, NULL, 'on hold');

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` bigint(100) NOT NULL,
  `identifier` varchar(50) DEFAULT NULL,
  `discipline_name` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `discipline_desc` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `includes` varchar(100) NOT NULL,
  `requirements` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `service_fee` varchar(50) NOT NULL,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `due_date` timestamp NULL DEFAULT NULL,
  `speciality` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`id`, `identifier`, `discipline_name`, `organization`, `country`, `category`, `discipline_desc`, `poster`, `includes`, `requirements`, `status`, `mode`, `service_fee`, `publish_date`, `due_date`, `speciality`, `link`) VALUES
(1, 'km8xfzot', 'Turkey Government Scholarship', 'Turkey University', 'Turkey', 'scholarship', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'img15.webp', 'Air Fee, Restaurant, Accommodation', 'Transcripts, Notified Diploma, 1+ Million Bank Statement ', 'Coming Soon', 'Online', '5000', '2023-10-18 15:02:07', '0000-00-00 00:00:00', 'carousel', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(2, '19kbp8xy', 'China Government Scholarship', 'China University', 'Turkey', 'scholarship', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Now Available', 'Blended', '10000', '2023-10-14 10:21:39', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(5, '12fyht30', 'Hanga Ideation Program', 'University of Rwanda', 'Rwanda', 'opportunity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Now Available', 'Online', '10000', '2023-10-18 15:02:13', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(6, 'yu9eoc1k', 'Andela Software Program', 'Andela', 'Rwanda', 'opportunity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Coming Soon', 'Blended', '15000', '2023-10-18 15:02:17', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(10, 'km8xfzot', 'Turkey Government Scholarship', 'Turkey University', 'Turkey', 'scholarship', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'img15.webp', 'Air Fee, Restaurant, Accommodation', 'Transcripts, Notified Diploma, 1+ Million Bank Statement ', 'Coming Soon', 'Online', '5000', '2023-10-18 15:02:22', '0000-00-00 00:00:00', 'carousel', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(11, '19kbp8xy', 'China Government Scholarship', 'China University', 'Turkey', 'scholarship', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Now Available', 'Blended', '10000', '2023-10-18 15:02:27', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(12, 'poxukf7g', 'Tokyo University Scholarship ', 'Tokyo University', 'Turkey', 'scholarship', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Coming Soon', 'Online', '15000', '2023-10-18 15:02:51', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(13, 'rfon4jxp', 'Cisco Tech Women Program', 'Cisco Networking Academy', 'Rwanda', 'opportunity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'img15.webp', 'Air Fee, Restaurant, Accommodation', 'Transcripts, Notified Diploma, 1+ Million Bank Statement ', 'Now Available', 'Onsite', '5000', '2023-10-18 15:02:56', '0000-00-00 00:00:00', 'carousel', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(14, '12fyht30', 'Hanga Ideation Program', 'University of Rwanda', 'Rwanda', 'opportunity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Now Available', 'Online', '10000', '2023-10-18 15:02:59', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(15, 'yu9eoc1k', 'Andela Software Program', 'Andela', 'Rwanda', 'opportunity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Coming Soon', 'Blended', '15000', '2023-10-18 15:03:05', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(16, 'of93mtlh', 'Cisco Tech Women Program', 'Cisco Networking Academy', 'Rwanda', 'training', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'img15.webp', 'Air Fee, Restaurant, Accommodation', 'Transcripts, Notified Diploma, 1+ Million Bank Statement ', 'Available', 'Onsite ( Full Time )', '5000', '2023-10-14 10:04:21', '0000-00-00 00:00:00', 'carousel', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(17, 'o8aw5upb', 'Hanga Ideation Program', 'University of Rwanda', 'Rwanda', 'training', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Now Available', 'Remote ( Half Time )', '10000', '2023-10-18 15:03:11', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps'),
(18, '1imtn5ds', 'Andela Software Program', 'Andela', 'Rwanda', 'training', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad veniam suscipit natus. Voluptatibus, asperiores maiores? Molestiae repellendus fugiat sequi nesciunt aliquid perspiciatis dolorem cum porro, labore dolore veniam, eum eos.', 'photo6.webp', 'Air fee, Restaurant, Accommodation', 'Transcripts\r\nNotified Diploma\r\n1 Million+ Bank Statement', 'Coming Soon', 'Remote', '15000', '2023-10-18 15:03:15', '0000-00-00 00:00:00', 'special', 'https://www.turkiyeburslari.gov.tr/applysteps');

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
(1, '2023_10_13_111919_applicant_info', 1),
(2, '2014_10_12_000000_create_staff_table', 2),
(3, '2023_10_16_163929_create_rhythm_box_table', 3);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rhythmbox`
--

CREATE TABLE `rhythmbox` (
  `id` bigint(20) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `percentage` int(50) NOT NULL DEFAULT 25,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rhythmbox`
--

INSERT INTO `rhythmbox` (`id`, `names`, `email`, `phone_number`, `percentage`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'James Kabera K', 'jameskabera@gmail.com', '456789', 25, NULL, '$2y$10$74PQkb9Eg/BS.VKrPbSAvugd8Leu0lDOg/5U/pgbAZMWwzeGqpYji', NULL, '2023-10-16 15:55:39', '2023-10-16 15:55:39');

-- --------------------------------------------------------

--
-- Stand-in structure for view `served_requests`
-- (See below for the actual view)
--
CREATE TABLE `served_requests` (
`id` bigint(100)
,`names` varchar(255)
,`email` varchar(255)
,`phone_number` varchar(20)
,`dob` date
,`gender` varchar(20)
,`father_names` varchar(255)
,`father_email` varchar(255)
,`father_phone` varchar(20)
,`mother_names` varchar(255)
,`mother_email` varchar(255)
,`mother_phone` varchar(20)
,`parents_alive` varchar(10)
,`guardian` varchar(255)
,`applicant_country` varchar(200)
,`province` varchar(100)
,`applicant_city` varchar(100)
,`application_id` bigint(100)
,`discipline` bigint(100)
,`discipline_identifier` varchar(50)
,`discipline_name` varchar(100)
,`discipline_organization` varchar(100)
,`discipline_country` varchar(100)
,`discipline_category` varchar(50)
,`discipline_desc` varchar(255)
,`poster` varchar(255)
,`includes` varchar(100)
,`requirements` varchar(100)
,`discipline_status` varchar(50)
,`mode` varchar(50)
,`service_fee` varchar(50)
,`due_date` timestamp
,`link` varchar(255)
,`requested_on` timestamp
,`payment_status` varchar(50)
,`amount_paid` varchar(50)
,`payment_date` timestamp
,`application_status` varchar(50)
,`assistant` bigint(100)
,`assistant_names` varchar(255)
,`assistant_phone_number` varchar(20)
,`served_on` timestamp
,`assistant_commission` int(20)
,`remittance_status` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `department` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `percentage` int(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Offline',
  `profile_picture` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `names`, `email`, `phone_number`, `department`, `role`, `percentage`, `status`, `profile_picture`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sano Olivier', 'sano@gmail.com', '123456789', 'Applications', 'Assistant ', 40, 'Offline', 'profile.png', NULL, '$2y$10$9fHiHODFKtrJbmkgMx.kzeZOrMWXX1rs2pcH0r58Uv2NqdHLXlrSO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Akcent', 'akcentmsc@gmail.com', '0987654321', NULL, '$2y$10$3aW6hk9zB/JSBFWPrW2dTeVcEk69OHBNXBDEB2cC1fodFLHE79c8a', NULL, '2023-08-19 08:39:36', '2023-10-16 11:51:34'),
(3, 'OKO', 'lokko.sings@gmail.com', '', NULL, '$2y$10$waYAbElO6Mq9VjNanbl2C.tcNFOkb8//sA5gvZyEbF9CNNJTXC8/e', NULL, '2023-08-19 10:56:57', '2023-08-19 10:56:57'),
(6, 'iLokko', 'patufaith1@gmail.com', '', NULL, '$2y$10$pO8XjCYEY6EN.H1kEHMe3O9F74DhSz3c.YmrOO9up7HVvy3FYiZu6', NULL, '2023-10-04 11:01:39', '2023-10-04 11:01:39');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_requests`
-- (See below for the actual view)
--
CREATE TABLE `user_requests` (
`id` bigint(100)
,`names` varchar(255)
,`email` varchar(255)
,`phone_number` varchar(20)
,`dob` date
,`gender` varchar(20)
,`father_names` varchar(255)
,`father_email` varchar(255)
,`father_phone` varchar(20)
,`mother_names` varchar(255)
,`mother_email` varchar(255)
,`mother_phone` varchar(20)
,`parents_alive` varchar(10)
,`guardian` varchar(255)
,`applicant_country` varchar(200)
,`province` varchar(100)
,`applicant_city` varchar(100)
,`application_id` bigint(100)
,`discipline` bigint(100)
,`discipline_identifier` varchar(50)
,`discipline_name` varchar(100)
,`discipline_organization` varchar(100)
,`discipline_country` varchar(100)
,`discipline_category` varchar(50)
,`discipline_desc` varchar(255)
,`poster` varchar(255)
,`includes` varchar(100)
,`requirements` varchar(100)
,`discipline_status` varchar(50)
,`mode` varchar(50)
,`service_fee` varchar(50)
,`due_date` timestamp
,`link` varchar(255)
,`requested_on` timestamp
,`payment_status` varchar(50)
,`amount_paid` varchar(50)
,`payment_date` timestamp
,`application_status` varchar(50)
,`assistant` bigint(100)
,`served_on` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `served_requests`
--
DROP TABLE IF EXISTS `served_requests`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `served_requests`  AS SELECT `applicant_info`.`id` AS `id`, `applicant_info`.`names` AS `names`, `applicant_info`.`email` AS `email`, `applicant_info`.`phone_number` AS `phone_number`, `applicant_info`.`dob` AS `dob`, `applicant_info`.`gender` AS `gender`, `applicant_info`.`father_names` AS `father_names`, `applicant_info`.`father_email` AS `father_email`, `applicant_info`.`father_phone` AS `father_phone`, `applicant_info`.`mother_names` AS `mother_names`, `applicant_info`.`mother_email` AS `mother_email`, `applicant_info`.`mother_phone` AS `mother_phone`, `applicant_info`.`parents_alive` AS `parents_alive`, `applicant_info`.`guardian` AS `guardian`, `applicant_info`.`country` AS `applicant_country`, `applicant_info`.`province` AS `province`, `applicant_info`.`city` AS `applicant_city`, `applications`.`app_id` AS `application_id`, `applications`.`discipline_id` AS `discipline`, `disciplines`.`identifier` AS `discipline_identifier`, `disciplines`.`discipline_name` AS `discipline_name`, `disciplines`.`organization` AS `discipline_organization`, `disciplines`.`country` AS `discipline_country`, `disciplines`.`category` AS `discipline_category`, `disciplines`.`discipline_desc` AS `discipline_desc`, `disciplines`.`poster` AS `poster`, `disciplines`.`includes` AS `includes`, `disciplines`.`requirements` AS `requirements`, `disciplines`.`status` AS `discipline_status`, `disciplines`.`mode` AS `mode`, `disciplines`.`service_fee` AS `service_fee`, `disciplines`.`due_date` AS `due_date`, `disciplines`.`link` AS `link`, `applications`.`request_time` AS `requested_on`, `applications`.`payment_status` AS `payment_status`, `applications`.`amount_paid` AS `amount_paid`, `applications`.`payment_date` AS `payment_date`, `applications`.`status` AS `application_status`, `applications`.`assistant` AS `assistant`, `staff`.`names` AS `assistant_names`, `staff`.`phone_number` AS `assistant_phone_number`, `applications`.`served_on` AS `served_on`, `applications`.`assistant_commission` AS `assistant_commission`, `applications`.`remittance_status` AS `remittance_status` FROM (((`applicant_info` join `applications` on(`applicant_info`.`id` = `applications`.`applicant`)) join `disciplines` on(`disciplines`.`id` = `applications`.`discipline_id`)) join `staff` on(`staff`.`id` = `applications`.`assistant`)) WHERE `applications`.`status` = 'Complete''Complete'  ;

-- --------------------------------------------------------

--
-- Structure for view `user_requests`
--
DROP TABLE IF EXISTS `user_requests`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_requests`  AS SELECT `applicant_info`.`id` AS `id`, `applicant_info`.`names` AS `names`, `applicant_info`.`email` AS `email`, `applicant_info`.`phone_number` AS `phone_number`, `applicant_info`.`dob` AS `dob`, `applicant_info`.`gender` AS `gender`, `applicant_info`.`father_names` AS `father_names`, `applicant_info`.`father_email` AS `father_email`, `applicant_info`.`father_phone` AS `father_phone`, `applicant_info`.`mother_names` AS `mother_names`, `applicant_info`.`mother_email` AS `mother_email`, `applicant_info`.`mother_phone` AS `mother_phone`, `applicant_info`.`parents_alive` AS `parents_alive`, `applicant_info`.`guardian` AS `guardian`, `applicant_info`.`country` AS `applicant_country`, `applicant_info`.`province` AS `province`, `applicant_info`.`city` AS `applicant_city`, `applications`.`app_id` AS `application_id`, `applications`.`discipline_id` AS `discipline`, `disciplines`.`identifier` AS `discipline_identifier`, `disciplines`.`discipline_name` AS `discipline_name`, `disciplines`.`organization` AS `discipline_organization`, `disciplines`.`country` AS `discipline_country`, `disciplines`.`category` AS `discipline_category`, `disciplines`.`discipline_desc` AS `discipline_desc`, `disciplines`.`poster` AS `poster`, `disciplines`.`includes` AS `includes`, `disciplines`.`requirements` AS `requirements`, `disciplines`.`status` AS `discipline_status`, `disciplines`.`mode` AS `mode`, `disciplines`.`service_fee` AS `service_fee`, `disciplines`.`due_date` AS `due_date`, `disciplines`.`link` AS `link`, `applications`.`request_time` AS `requested_on`, `applications`.`payment_status` AS `payment_status`, `applications`.`amount_paid` AS `amount_paid`, `applications`.`payment_date` AS `payment_date`, `applications`.`status` AS `application_status`, `applications`.`assistant` AS `assistant`, `applications`.`served_on` AS `served_on` FROM ((`applicant_info` join `applications` on(`applicant_info`.`id` = `applications`.`applicant`)) join `disciplines` on(`disciplines`.`id` = `applications`.`discipline_id`)) WHERE `applications`.`status` <> 'Complete''Complete'  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_documents`
--
ALTER TABLE `applicant_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_info_to_applicant_documents_fk` (`applicant`);

--
-- Indexes for table `applicant_education_info`
--
ALTER TABLE `applicant_education_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_info_to_applicant_education_info_fk` (`applicant`);

--
-- Indexes for table `applicant_info`
--
ALTER TABLE `applicant_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applicant_info_applicant_email_unique` (`email`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `disciplines_to_applications_foreign_key` (`discipline_id`),
  ADD KEY `applicant_info_to_applications_fk` (`applicant`),
  ADD KEY `staff_to_applications_fk` (`assistant`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rhythmbox`
--
ALTER TABLE `rhythmbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rhythmbox_email_unique` (`email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `applicant_documents`
--
ALTER TABLE `applicant_documents`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `applicant_education_info`
--
ALTER TABLE `applicant_education_info`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `applicant_info`
--
ALTER TABLE `applicant_info`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rhythmbox`
--
ALTER TABLE `rhythmbox`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_documents`
--
ALTER TABLE `applicant_documents`
  ADD CONSTRAINT `applicant_info_to_applicant_documents_fk` FOREIGN KEY (`applicant`) REFERENCES `applicant_info` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `applicant_education_info`
--
ALTER TABLE `applicant_education_info`
  ADD CONSTRAINT `applicant_info_to_applicant_education_info_fk` FOREIGN KEY (`applicant`) REFERENCES `applicant_info` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applicant_info_to_applications_fk` FOREIGN KEY (`applicant`) REFERENCES `applicant_info` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `disciplines_to_applications_foreign_key` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_to_applications_fk` FOREIGN KEY (`assistant`) REFERENCES `staff` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
