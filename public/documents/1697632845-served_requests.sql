-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 02:32 PM
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
-- Structure for view `served_requests`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `served_requests`  AS SELECT `applicant_info`.`id` AS `id`, `applicant_info`.`names` AS `names`, `applicant_info`.`email` AS `email`, `applicant_info`.`phone_number` AS `phone_number`, `applicant_info`.`dob` AS `dob`, `applicant_info`.`gender` AS `gender`, `applicant_info`.`father_names` AS `father_names`, `applicant_info`.`father_email` AS `father_email`, `applicant_info`.`father_phone` AS `father_phone`, `applicant_info`.`mother_names` AS `mother_names`, `applicant_info`.`mother_email` AS `mother_email`, `applicant_info`.`mother_phone` AS `mother_phone`, `applicant_info`.`parents_alive` AS `parents_alive`, `applicant_info`.`guardian` AS `guardian`, `applicant_info`.`country` AS `applicant_country`, `applicant_info`.`province` AS `province`, `applicant_info`.`city` AS `applicant_city`, `applications`.`app_id` AS `application_id`, `applications`.`discipline_id` AS `discipline`, `disciplines`.`identifier` AS `discipline_identifier`, `disciplines`.`discipline_name` AS `discipline_name`, `disciplines`.`organization` AS `discipline_organization`, `disciplines`.`country` AS `discipline_country`, `disciplines`.`category` AS `discipline_category`, `disciplines`.`discipline_desc` AS `discipline_desc`, `disciplines`.`poster` AS `poster`, `disciplines`.`includes` AS `includes`, `disciplines`.`requirements` AS `requirements`, `disciplines`.`status` AS `discipline_status`, `disciplines`.`mode` AS `mode`, `disciplines`.`service_fee` AS `service_fee`, `disciplines`.`due_date` AS `due_date`, `disciplines`.`link` AS `link`, `applications`.`request_time` AS `requested_on`, `applications`.`payment_status` AS `payment_status`, `applications`.`amount_paid` AS `amount_paid`, `applications`.`payment_date` AS `payment_date`, `applications`.`status` AS `application_status`, `applications`.`assistant` AS `assistant`, `staff`.`names` AS `assistant_names`, `staff`.`phone_number` AS `assistant_phone_number`, `applications`.`served_on` AS `served_on`, `applications`.`assistant_commission` AS `assistant_commission`, `applications`.`remittance_status` AS `remittance_status` FROM (((`applicant_info` join `applications` on(`applicant_info`.`id` = `applications`.`applicant`)) join `disciplines` on(`disciplines`.`id` = `applications`.`discipline_id`)) join `staff` on(`staff`.`id` = `applications`.`assistant`)) WHERE `applications`.`status` = 'Complete''Complete'  ;

--
-- VIEW `served_requests`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
