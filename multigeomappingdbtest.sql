-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2022 at 10:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multigeomappingdbtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `affaires`
--

CREATE TABLE `affaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `REF` varchar(191) NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `PTE_KNOWN` varchar(191) NOT NULL,
  `TIT_REQ` varchar(191) NOT NULL,
  `place` varchar(191) NOT NULL,
  `DATE_ENTRY` date NOT NULL,
  `DATE_LAI` date NOT NULL,
  `UNITE` int(11) NOT NULL,
  `PRICE` double NOT NULL,
  `Inter_id` int(10) UNSIGNED DEFAULT NULL,
  `aff_sit_id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `resp_id` int(10) UNSIGNED NOT NULL,
  `nature_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `affairesituations`
--

CREATE TABLE `affairesituations` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `orderChr` int(11) NOT NULL,
  `Name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affairesituations`
--

INSERT INTO `affairesituations` (`id`, `organisation_id`, `orderChr`, `Name`, `created_at`, `updated_at`) VALUES
(5, 3, 15, 'affair25', '2022-06-02 13:47:20', '2022-06-02 13:47:20'),
(7, 3, 15, 'affair1', '2022-06-02 13:52:42', '2022-06-02 13:52:42'),
(8, 3, 15, 'affair2', '2022-06-02 13:52:42', '2022-06-02 13:52:42'),
(9, 3, 15, 'affair3', '2022-06-02 13:52:42', '2022-06-02 13:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `affaire_natures`
--

CREATE TABLE `affaire_natures` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED DEFAULT NULL,
  `Name` varchar(191) NOT NULL,
  `Abr_v` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affaire_natures`
--

INSERT INTO `affaire_natures` (`id`, `organisation_id`, `Name`, `Abr_v`, `created_at`, `updated_at`) VALUES
(10, 3, 'Lccccccc', 'kh', '2022-04-28 04:15:27', '2022-04-28 04:15:27'),
(12, 3, 'Lccc', 'kh', '2022-04-28 04:19:05', '2022-04-28 04:19:05'),
(15, 3, 'Lcktt', 'kh', '2022-04-28 04:33:07', '2022-04-28 04:33:07'),
(16, 3, 'Lchhtt', 'kh', '2022-04-28 06:01:33', '2022-04-28 06:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `allocated_brigades`
--

CREATE TABLE `allocated_brigades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `devis_date_c` date NOT NULL,
  `devis_date_e` date NOT NULL,
  `client_n` varchar(191) NOT NULL,
  `client_ice` varchar(191) NOT NULL,
  `Etablissement` varchar(191) NOT NULL,
  `details` varchar(191) DEFAULT NULL,
  `REF` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE `bill_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `Ds` varchar(191) DEFAULT NULL,
  `Un` double DEFAULT NULL,
  `pt` double DEFAULT NULL,
  `pu` double DEFAULT NULL,
  `qt` int(11) DEFAULT NULL,
  `bills_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `ICE` varchar(191) NOT NULL,
  `RC` varchar(191) NOT NULL,
  `tel` varchar(191) NOT NULL,
  `Cour` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `business_managements`
--

CREATE TABLE `business_managements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `DATE_ENTRY` date NOT NULL,
  `DATE_LAI` date NOT NULL,
  `membership_id` bigint(20) DEFAULT NULL,
  `membership_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `business_management_files`
--

CREATE TABLE `business_management_files` (
  `id` bigint(20) NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cadastralconsultations`
--

CREATE TABLE `cadastralconsultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `REQ_TIT` char(1) NOT NULL,
  `NUM` int(11) DEFAULT NULL,
  `INDICE` int(11) DEFAULT NULL,
  `GENRE_OP` varchar(191) DEFAULT NULL,
  `TITRE_MERE` varchar(191) DEFAULT NULL,
  `REQ_MERE` varchar(191) DEFAULT NULL,
  `X` varchar(191) DEFAULT NULL,
  `Y` varchar(191) DEFAULT NULL,
  `DATE_ARRIVEE` date DEFAULT NULL,
  `DATE_BORNAGE` date DEFAULT NULL,
  `RESULTAT_BORNAGE` varchar(191) DEFAULT NULL,
  `BORNEUR` varchar(191) DEFAULT NULL,
  `NUM_DEPOT` varchar(191) DEFAULT NULL,
  `DATE_DEPOT` date DEFAULT NULL,
  `CARNET` varchar(191) DEFAULT NULL,
  `BON` varchar(191) DEFAULT NULL,
  `DATE_DELIVRANCE` date DEFAULT NULL,
  `NBRE_FRACTION` int(11) DEFAULT NULL,
  `PRIVE` varchar(191) DEFAULT NULL,
  `OBSERVATIONS` varchar(191) DEFAULT NULL,
  `DATE_ARCHIVE` date DEFAULT NULL,
  `CONT_ARR` int(11) DEFAULT NULL,
  `SITUATION` varchar(191) DEFAULT NULL,
  `PTE_DITE` varchar(191) DEFAULT NULL,
  `MAPPE` varchar(191) DEFAULT NULL,
  `STATUT` varchar(191) DEFAULT NULL,
  `COMMUNE` varchar(191) DEFAULT NULL,
  `CONSISTANCE` varchar(191) DEFAULT NULL,
  `CLEF` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `others` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `num_quit` varchar(191) NOT NULL,
  `desi` varchar(191) NOT NULL,
  `unite` int(11) NOT NULL,
  `somme_due` double NOT NULL,
  `date_fac` date NOT NULL,
  `avence` double NOT NULL,
  `reste` double NOT NULL,
  `date_pai` date NOT NULL,
  `date_del` date NOT NULL,
  `invoiceStatusId` bigint(20) UNSIGNED NOT NULL,
  `typeSchargeId` bigint(20) UNSIGNED NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `isPayed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_user`
--

CREATE TABLE `chat_user` (
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `Street` varchar(191) NOT NULL,
  `Street2` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `ZIP_code` varchar(191) NOT NULL,
  `Country` varchar(191) NOT NULL,
  `membership_id` bigint(20) DEFAULT NULL,
  `membership_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `personal_number` varchar(191) NOT NULL,
  `profession_number` varchar(191) NOT NULL,
  `position_held` varchar(191) NOT NULL,
  `linked_documents` varchar(191) NOT NULL,
  `Start_date` date NOT NULL,
  `Salary` double NOT NULL,
  `workplace` enum('Ground','Office') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `organisation_id`, `personal_number`, `profession_number`, `position_held`, `linked_documents`, `Start_date`, `Salary`, `workplace`, `created_at`, `updated_at`) VALUES
(1, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:04:55', '2022-06-02 20:04:55'),
(2, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:05:27', '2022-06-02 20:05:27'),
(3, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:05:50', '2022-06-02 20:05:50'),
(4, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:06:08', '2022-06-02 20:06:08'),
(5, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:07:16', '2022-06-02 20:07:16'),
(6, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:17:04', '2022-06-02 20:17:04'),
(7, 3, '0666666666', '06555555555', 'PPPPPP', '0', '2022-06-02', 213.22, NULL, '2022-06-02 20:36:29', '2022-06-02 20:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `advanced` double NOT NULL,
  `price` double NOT NULL,
  `observation` text NOT NULL,
  `type` varchar(191) NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feesfolderteches`
--

CREATE TABLE `feesfolderteches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `advanced` double NOT NULL,
  `observation` text NOT NULL,
  `folder_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `file_loads`
--

CREATE TABLE `file_loads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) NOT NULL,
  `load_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folderteches`
--

CREATE TABLE `folderteches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `REF` varchar(191) NOT NULL,
  `PTE_KNOWN` varchar(191) NOT NULL,
  `TIT_REQ` varchar(191) NOT NULL,
  `place` varchar(191) NOT NULL,
  `DATE_ENTRY` date NOT NULL,
  `DATE_LAI` date NOT NULL,
  `UNITE` int(11) NOT NULL,
  `PRICE` double NOT NULL,
  `Inter_id` int(11) NOT NULL,
  `folder_sit_id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `resp_id` int(10) UNSIGNED NOT NULL,
  `nature_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `foldertechsituations`
--

CREATE TABLE `foldertechsituations` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `orderChr` int(11) NOT NULL,
  `Name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folder_tech_natures`
--

CREATE TABLE `folder_tech_natures` (
  `id` int(10) UNSIGNED NOT NULL,
  `Name` varchar(191) NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `Abr_v` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g_c_s`
--

CREATE TABLE `g_c_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `fees_decompte` double NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `Market_title` varchar(191) NOT NULL,
  `resp_id` int(10) UNSIGNED NOT NULL,
  `State_of_progress` enum('En cours','Teminé','En Attente de validation','Annulé') DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `Class_service` varchar(191) DEFAULT NULL,
  `Execution_report` varchar(191) DEFAULT NULL,
  `Execution_phase` text DEFAULT NULL,
  `date_of_receipt` date NOT NULL,
  `DATE_LAI` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g_c_s_a_b`
--

CREATE TABLE `g_c_s_a_b` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `g_c_id` bigint(20) UNSIGNED NOT NULL,
  `a_b_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intermediates`
--

CREATE TABLE `intermediates` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `second_name` varchar(191) NOT NULL,
  `Street` varchar(191) NOT NULL,
  `Street2` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `ZIP code` varchar(191) NOT NULL,
  `Country` varchar(191) NOT NULL,
  `Function` varchar(191) NOT NULL,
  `tel` varchar(191) NOT NULL,
  `Cour` varchar(191) NOT NULL,
  `fees` enum('inclusive','Percentage') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoicestatuses`
--

CREATE TABLE `invoicestatuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `linked__documents`
--

CREATE TABLE `linked__documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loads`
--

CREATE TABLE `loads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `REF` varchar(191) NOT NULL,
  `amount` double NOT NULL,
  `DATE_LOAD` date NOT NULL,
  `load_related_to` int(10) UNSIGNED NOT NULL,
  `TVA` enum('20','14') DEFAULT NULL,
  `load_types_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loads`
--

INSERT INTO `loads` (`id`, `organisation_id`, `REF`, `amount`, `DATE_LOAD`, `load_related_to`, `TVA`, `load_types_name`, `created_at`, `updated_at`) VALUES
(13, 3, 'fvqfdsvf', 20, '2022-05-11', 1, '20', 'string', '2022-05-01 22:46:42', '2022-04-30 22:46:42'),
(17, 3, 'QSCQDSC', 14756.2, '2022-05-29', 1, '20', 'string', '2022-05-29 20:56:15', '2022-05-29 20:56:15'),
(18, 3, 'QSCQDSC', 14756.2, '2022-05-29', 1, '20', 'string', '2022-05-29 20:56:52', '2022-05-29 20:56:52'),
(19, 3, 'QSCQDSC', 14756.2, '2022-05-29', 1, '20', 'string', '2022-05-29 20:58:34', '2022-05-29 20:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `load_types`
--

CREATE TABLE `load_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `load_types`
--

INSERT INTO `load_types` (`id`, `organisation_id`, `name`, `created_at`, `updated_at`) VALUES
(8, 3, 'string', '2022-05-28 17:59:46', '2022-05-28 17:59:46'),
(9, 3, 'test11', '2022-05-28 17:59:46', '2022-05-28 17:59:46'),
(10, 3, 'strinjg', '2022-05-28 18:01:04', '2022-05-28 18:01:04'),
(11, 3, 'testj11', '2022-05-28 18:01:04', '2022-05-28 18:01:04'),
(12, 3, 'strinjgn', '2022-05-28 18:05:24', '2022-05-28 18:05:24'),
(13, 3, 'testj11n', '2022-05-28 18:05:24', '2022-05-28 18:05:24'),
(14, 3, 'struuu', '2022-05-28 18:06:36', '2022-05-28 18:06:36'),
(15, 3, 'testj1', '2022-05-28 18:06:36', '2022-05-28 18:06:36'),
(16, 3, 'struuuglh', '2022-05-28 18:07:54', '2022-05-28 18:07:54'),
(17, 3, 'testj1hjkhj', '2022-05-28 18:07:54', '2022-05-28 18:07:54'),
(18, 3, 'struuuglhxfx', '2022-05-28 18:09:40', '2022-05-28 18:09:40'),
(19, 3, 'testj1hjkhxxj', '2022-05-28 18:09:40', '2022-05-28 18:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_activities`
--

CREATE TABLE `log_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(191) NOT NULL,
  `url` varchar(191) NOT NULL,
  `method` varchar(191) NOT NULL,
  `ip` varchar(191) NOT NULL,
  `agent` varchar(191) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `from_id` int(10) UNSIGNED NOT NULL,
  `to_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message_files`
--

CREATE TABLE `message_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `fileName` varchar(191) NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_05_000000_create_organisations_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_02_17_174646_entrust_setup_tables', 1),
(6, '2020_02_24_123402_create_affairenatures_table', 1),
(7, '2020_02_24_123917_create_foldertechnatures_table', 1),
(8, '2020_02_24_170402_create_clients_table', 1),
(9, '2020_02_24_171456_create_intermediates_table', 1),
(10, '2020_02_24_174827_create_affairesituations_table', 1),
(11, '2020_02_24_180557_create_foldertechsituations_table', 1),
(12, '2020_02_25_154642_create_particulars_table', 1),
(13, '2020_02_25_154719_create_businesses_table', 1),
(14, '2020_02_26_115111_create_employees_table', 1),
(15, '2020_02_26_164842_create_folderteches_table', 1),
(16, '2020_02_26_164929_create_affaires_table', 1),
(17, '2020_02_26_174022_create_feesfolderteches_table', 1),
(18, '2020_02_29_182436_create_business_managements_table', 1),
(19, '2020_03_01_161941_create_files_table', 1),
(20, '2020_03_02_122312_create_business_management_files_table', 1),
(21, '2020_03_02_131638_create_chats_table', 1),
(22, '2020_03_02_134752_create_chat_messages_table', 1),
(23, '2020_03_02_134900_create_chat_user_table', 1),
(24, '2020_03_03_191858_create_fees_table', 1),
(25, '2020_03_13_135630_create_routes_table', 1),
(26, '2020_04_06_103742_create_allocated_brigades_table', 1),
(27, '2020_04_06_113220_create_locations_table', 1),
(28, '2020_04_06_113221_create_greatconstructionsites_table', 1),
(29, '2020_04_10_185623_create_notifcations_table', 1),
(30, '2020_04_14_123415_create_missions_table', 1),
(31, '2020_04_16_120419_create_cadastralconsultations_table', 1),
(32, '2020_04_16_120419_create_loadtypes_table', 1),
(33, '2020_04_21_122608_create_loads_table', 1),
(34, '2020_04_22_101013_create_file_loads_table', 1),
(35, '2020_04_29_184846_create_bills_table', 1),
(36, '2020_04_29_185006_create_bill_details_table', 1),
(37, '2020_04_29_195146_create_messages_table', 1),
(38, '2020_04_30_111524_create_mesage_files_table', 1),
(39, '2020_05_07_113602_create_greatconstructionsite_allocatedbrigades_table', 1),
(40, '2020_06_05_111707_create_typescharges_table', 1),
(41, '2020_06_07_140046_create_log_activity_table', 1),
(42, '2020_07_01_113303_create_invoicestatuses_table', 1),
(43, '2020_07_06_154053_create_charges_table', 1),
(44, '2020_07_27_131434_create_linked__documents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE `missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `allDay` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `emailOrganisation` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `owner` varchar(191) DEFAULT NULL,
  `cto` int(10) UNSIGNED NOT NULL,
  `file_avatar_name` varchar(191) DEFAULT NULL,
  `link1` varchar(191) DEFAULT NULL,
  `link2` varchar(191) DEFAULT NULL,
  `link3` varchar(191) DEFAULT NULL,
  `link4` varchar(191) DEFAULT NULL,
  `activer` tinyint(1) DEFAULT NULL,
  `desactiver` varchar(191) DEFAULT NULL,
  `blocked` varchar(191) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `name`, `emailOrganisation`, `description`, `owner`, `cto`, `file_avatar_name`, `link1`, `link2`, `link3`, `link4`, `activer`, `desactiver`, `blocked`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'lcc', 'lcc@lcc', 'test', NULL, 1, '77eebd99e2da3a667dae6ed5ebfef052.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-25 18:44:11', NULL),
(101, 'classclass', 'classclass@gmail.com', 'xsdcd', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-25 14:33:04', '2022-07-25 14:33:04', NULL),
(102, 'classclass', 'classclass1@gmail.com', 'csdcsdcsdsd', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-25 14:34:29', '2022-07-25 14:34:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `particulars`
--

CREATE TABLE `particulars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `Function` varchar(191) NOT NULL,
  `tel` varchar(191) NOT NULL,
  `Cour` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'Project Owner', 'User is the owner of a given project', '2020-07-10 10:01:37', '2020-07-10 10:01:37'),
(2, 'admin', 'Administrator', 'User has access to all system functionality expect user management', '2020-07-10 10:01:38', '2020-07-10 10:01:38'),
(3, 'user', 'user', 'User can create data in the system', '2020-07-10 10:01:38', '2020-07-10 10:01:38'),
(4, 'affairenatures_create', 'create affairenatures', 'Allow user to create a new DB affairenatures', '2020-07-10 10:01:39', '2020-07-10 10:01:39'),
(5, 'affairenatures_edit', 'edit affairenatures', 'Allow user to edit a new DB affairenatures', '2020-07-10 10:01:40', '2020-07-10 10:01:40'),
(6, 'affairenatures_read', 'read affairenatures', 'Allow user to read a new DB affairenatures', '2020-07-10 10:01:40', '2020-07-10 10:01:40'),
(7, 'affairenatures_delete', 'delete affairenatures', 'Allow user to delete a new DB affairenatures', '2020-07-10 10:01:40', '2020-07-10 10:01:40'),
(8, 'foldertechnatures_create', 'create foldertechnatures', 'Allow user to create a new DB foldertechnatures', '2020-07-10 10:01:41', '2020-07-10 10:01:41'),
(9, 'foldertechnatures_edit', 'edit foldertechnatures', 'Allow user to edit a new DB foldertechnatures', '2020-07-10 10:01:41', '2020-07-10 10:01:41'),
(10, 'foldertechnatures_read', 'read foldertechnatures', 'Allow user to read a new DB foldertechnatures', '2020-07-10 10:01:42', '2020-07-10 10:01:42'),
(11, 'foldertechnatures_delete', 'delete foldertechnatures', 'Allow user to delete a new DB foldertechnatures', '2020-07-10 10:01:42', '2020-07-10 10:01:42'),
(12, 'loadtypes_create', 'create loadtypes', 'Allow user to create a new DB loadtypes', '2020-07-10 10:01:42', '2020-07-10 10:01:42'),
(13, 'loadtypes_edit', 'edit loadtypes', 'Allow user to edit a new DB loadtypes', '2020-07-10 10:01:43', '2020-07-10 10:01:43'),
(14, 'loadtypes_read', 'read loadtypes', 'Allow user to read a new DB loadtypes', '2020-07-10 10:01:43', '2020-07-10 10:01:43'),
(15, 'loadtypes_delete', 'delete loadtypes', 'Allow user to delete a new DB loadtypes', '2020-07-10 10:01:43', '2020-07-10 10:01:43'),
(16, 'loads_create', 'create loads', 'Allow user to create a new DB loads', '2020-07-10 10:01:44', '2020-07-10 10:01:44'),
(17, 'loads_edit', 'edit loads', 'Allow user to edit a new DB loads', '2020-07-10 10:01:44', '2020-07-10 10:01:44'),
(18, 'loads_read', 'read loads', 'Allow user to read a new DB loads', '2020-07-10 10:01:45', '2020-07-10 10:01:45'),
(19, 'loads_delete', 'delete loads', 'Allow user to delete a new DB loads', '2020-07-10 10:01:45', '2020-07-10 10:01:45'),
(20, 'clients_create', 'create clients', 'Allow user to create a new DB clients', '2020-07-10 10:01:45', '2020-07-10 10:01:45'),
(21, 'clients_edit', 'edit clients', 'Allow user to edit a new DB clients', '2020-07-10 10:01:46', '2020-07-10 10:01:46'),
(22, 'clients_read', 'read clients', 'Allow user to read a new DB clients', '2020-07-10 10:01:46', '2020-07-10 10:01:46'),
(23, 'clients_delete', 'delete clients', 'Allow user to delete a new DB clients', '2020-07-10 10:01:46', '2020-07-10 10:01:46'),
(24, 'employees_create', 'create employees', 'Allow user to create a new DB employees', '2020-07-10 10:01:47', '2020-07-10 10:01:47'),
(25, 'employees_edit', 'edit employees', 'Allow user to edit a new DB employees', '2020-07-10 10:01:47', '2020-07-10 10:01:47'),
(26, 'employees_read', 'read employees', 'Allow user to read a new DB employees', '2020-07-10 10:01:47', '2020-07-10 10:01:47'),
(27, 'employees_delete', 'delete employees', 'Allow user to delete a new DB employees', '2020-07-10 10:01:48', '2020-07-10 10:01:48'),
(28, 'foldertechsituations_create', 'create foldertechsituations', 'Allow user to create a new DB foldertechsituations', '2020-07-10 10:01:48', '2020-07-10 10:01:48'),
(29, 'foldertechsituations_edit', 'edit foldertechsituations', 'Allow user to edit a new DB foldertechsituations', '2020-07-10 10:01:48', '2020-07-10 10:01:48'),
(30, 'foldertechsituations_read', 'read foldertechsituations', 'Allow user to read a new DB foldertechsituations', '2020-07-10 10:01:49', '2020-07-10 10:01:49'),
(31, 'foldertechsituations_delete', 'delete foldertechsituations', 'Allow user to delete a new DB foldertechsituations', '2020-07-10 10:01:49', '2020-07-10 10:01:49'),
(32, 'affaires_create', 'create affaires', 'Allow user to create a new DB affaires', '2020-07-10 10:01:50', '2020-07-10 10:01:50'),
(33, 'affaires_edit', 'edit affaires', 'Allow user to edit a new DB affaires', '2020-07-10 10:01:50', '2020-07-10 10:01:50'),
(34, 'affaires_read', 'read affaires', 'Allow user to read a new DB affaires', '2020-07-10 10:01:51', '2020-07-10 10:01:51'),
(35, 'affaires_delete', 'delete affaires', 'Allow user to delete a new DB affaires', '2020-07-10 10:01:51', '2020-07-10 10:01:51'),
(36, 'folderteches_create', 'create folderteches', 'Allow user to create a new DB folderteches', '2020-07-10 10:01:51', '2020-07-10 10:01:51'),
(37, 'folderteches_edit', 'edit folderteches', 'Allow user to edit a new DB folderteches', '2020-07-10 10:01:51', '2020-07-10 10:01:51'),
(38, 'folderteches_read', 'read folderteches', 'Allow user to read a new DB folderteches', '2020-07-10 10:01:52', '2020-07-10 10:01:52'),
(39, 'folderteches_delete', 'delete folderteches', 'Allow user to delete a new DB folderteches', '2020-07-10 10:01:52', '2020-07-10 10:01:52'),
(40, 'intermediates_create', 'create intermediates', 'Allow user to create a new DB intermediates', '2020-07-10 10:01:52', '2020-07-10 10:01:52'),
(41, 'intermediates_edit', 'edit intermediates', 'Allow user to edit a new DB intermediates', '2020-07-10 10:01:53', '2020-07-10 10:01:53'),
(42, 'intermediates_read', 'read intermediates', 'Allow user to read a new DB intermediates', '2020-07-10 10:01:53', '2020-07-10 10:01:53'),
(43, 'intermediates_delete', 'delete intermediates', 'Allow user to delete a new DB intermediates', '2020-07-10 10:01:54', '2020-07-10 10:01:54'),
(44, 'fees_create', 'create fees', 'Allow user to create a new DB fees', '2020-07-10 10:01:54', '2020-07-10 10:01:54'),
(45, 'fees_edit', 'edit fees', 'Allow user to edit a new DB fees', '2020-07-10 10:01:54', '2020-07-10 10:01:54'),
(46, 'fees_read', 'read fees', 'Allow user to read a new DB fees', '2020-07-10 10:01:55', '2020-07-10 10:01:55'),
(47, 'fees_delete', 'delete fees', 'Allow user to delete a new DB fees', '2020-07-10 10:01:55', '2020-07-10 10:01:55'),
(48, 'files_create', 'create files', 'Allow user to create a new DB files', '2020-07-10 10:01:55', '2020-07-10 10:01:55'),
(49, 'files_edit', 'edit files', 'Allow user to edit a new DB files', '2020-07-10 10:01:56', '2020-07-10 10:01:56'),
(50, 'files_read', 'read files', 'Allow user to read a new DB files', '2020-07-10 10:01:56', '2020-07-10 10:01:56'),
(51, 'files_delete', 'delete files', 'Allow user to delete a new DB files', '2020-07-10 10:01:57', '2020-07-10 10:01:57'),
(52, 'charges_create', 'create charges', 'Allow user to create a new DB charges', '2020-07-10 10:01:57', '2020-07-10 10:01:57'),
(53, 'charges_edit', 'edit charges', 'Allow user to edit a new DB charges', '2020-07-10 10:01:57', '2020-07-10 10:01:57'),
(54, 'charges_read', 'read charges', 'Allow user to read a new DB charges', '2020-07-10 10:01:58', '2020-07-10 10:01:58'),
(55, 'charges_delete', 'delete charges', 'Allow user to delete a new DB charges', '2020-07-10 10:01:58', '2020-07-10 10:01:58'),
(56, 'typeCharge_create', 'create typeCharge', 'Allow user to create a new DB typeCharge', '2020-07-10 10:01:58', '2020-07-10 10:01:58'),
(57, 'typeCharge_edit', 'edit typeCharge', 'Allow user to edit a new DB typeCharge', '2020-07-10 10:01:59', '2020-07-10 10:01:59'),
(58, 'typeCharge_read', 'read typeCharge', 'Allow user to read a new DB typeCharge', '2020-07-10 10:01:59', '2020-07-10 10:01:59'),
(59, 'typeCharge_delete', 'delete typeCharge', 'Allow user to delete a new DB typeCharge', '2020-07-10 10:01:59', '2020-07-10 10:01:59'),
(60, 'EtatFacture_create', 'create EtatFacture', 'Allow user to create a new DB EtatFacture', '2020-07-10 10:02:00', '2020-07-10 10:02:00'),
(61, 'EtatFacture_edit', 'edit EtatFacture', 'Allow user to edit a new DB EtatFacture', '2020-07-10 10:02:00', '2020-07-10 10:02:00'),
(62, 'EtatFacture_read', 'read EtatFacture', 'Allow user to read a new DB EtatFacture', '2020-07-10 10:02:00', '2020-07-10 10:02:00'),
(63, 'EtatFacture_delete', 'delete EtatFacture', 'Allow user to delete a new DB EtatFacture', '2020-07-10 10:02:01', '2020-07-10 10:02:01'),
(64, 'GreatConstructionSites_create', 'create GreatConstructionSites', 'Allow user to create a new DB GreatConstructionSites', '2020-07-10 10:02:01', '2020-07-10 10:02:01'),
(65, 'GreatConstructionSites_edit', 'edit GreatConstructionSites', 'Allow user to edit a new DB GreatConstructionSites', '2020-07-10 10:02:01', '2020-07-10 10:02:01'),
(66, 'GreatConstructionSites_read', 'read GreatConstructionSites', 'Allow user to read a new DB GreatConstructionSites', '2020-07-10 10:02:02', '2020-07-10 10:02:02'),
(67, 'GreatConstructionSites_delete', 'delete GreatConstructionSites', 'Allow user to delete a new DB GreatConstructionSites', '2020-07-10 10:02:02', '2020-07-10 10:02:02'),
(68, 'Cadastralconsultation_create', 'create Cadastralconsultation', 'Allow user to create a new DB Cadastralconsultation', '2020-07-10 10:02:02', '2020-07-10 10:02:02'),
(69, 'Cadastralconsultation_edit', 'edit Cadastralconsultation', 'Allow user to edit a new DB Cadastralconsultation', '2020-07-10 10:02:03', '2020-07-10 10:02:03'),
(70, 'Cadastralconsultation_read', 'read Cadastralconsultation', 'Allow user to read a new DB Cadastralconsultation', '2020-07-10 10:02:04', '2020-07-10 10:02:04'),
(71, 'Cadastralconsultation_delete', 'delete Cadastralconsultation', 'Allow user to delete a new DB Cadastralconsultation', '2020-07-10 10:02:04', '2020-07-10 10:02:04'),
(72, 'affairesituations_create', 'create affairesituations', 'Allow user to create a new DB affairesituations', '2020-07-10 10:02:04', '2020-07-10 10:02:04'),
(73, 'affairesituations_edit', 'edit affairesituations', 'Allow user to edit a new DB affairesituations', '2020-07-10 10:02:05', '2020-07-10 10:02:05'),
(74, 'affairesituations_read', 'read affairesituations', 'Allow user to read a new DB affairesituations', '2020-07-10 10:02:05', '2020-07-10 10:02:05'),
(75, 'affairesituations_delete', 'delete affairesituations', 'Allow user to delete a new DB affairesituations', '2020-07-10 10:02:05', '2020-07-10 10:02:05'),
(76, 'super', 'do anything', 'do anything', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 76);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `typescharges`
--

CREATE TABLE `typescharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `auth_token` text DEFAULT NULL,
  `token_expired_at` date DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `last_signin` timestamp NULL DEFAULT NULL,
  `firstname` varchar(191) DEFAULT NULL,
  `middlename` varchar(191) DEFAULT NULL,
  `lastname` varchar(191) DEFAULT NULL,
  `gender` enum('male','female','') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `directory` varchar(191) DEFAULT NULL,
  `filename` varchar(191) DEFAULT NULL,
  `original_filename` varchar(191) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `thumbnail_filesize` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `organisation_id` int(11) UNSIGNED DEFAULT NULL,
  `membership_id` bigint(20) DEFAULT NULL,
  `membership_type` varchar(191) DEFAULT NULL,
  `activer` tinyint(1) NOT NULL DEFAULT 1,
  `desactiver` tinyint(1) NOT NULL DEFAULT 0,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail_url` text DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  `deleted_by` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `auth_token`, `token_expired_at`, `verified_at`, `last_signin`, `firstname`, `middlename`, `lastname`, `gender`, `birthdate`, `address`, `directory`, `filename`, `original_filename`, `filesize`, `thumbnail_filesize`, `url`, `organisation_id`, `membership_id`, `membership_type`, `activer`, `desactiver`, `blocked`, `thumbnail_url`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'benchamekhd11', NULL, 'benchamekh@gmail.com', NULL, '183461', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, '2022-07-25 16:39:22', NULL),
(2, 'affaire1111', NULL, 'ayoub@ayoub.com', NULL, '$2y$10$jtDjuU8QZVU3cz3sfYfijOij.0NEQUxez1nsAfYin53r7h4DUm6ZS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, '2022-06-02 20:07:16', '2022-06-02 20:07:16', NULL),
(3, 'affaire1111', NULL, 'ayoub@ayoub1.com', NULL, '$2y$10$LJkSdgBL/SyovhI2VEdWp.pc9FxGCReTK1pwTVhxPWxuVc5HJfXWy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, '2022-06-02 20:17:04', '2022-06-02 20:17:04', NULL),
(4, 'affaire1111', NULL, 'ayoub@ayoub2.com', NULL, '$2y$10$iii3ihbdGn8qZYsZPDRf5eDEAc4jj4WVnXZMl3ndJvL7B2l3sI25G', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, '2022-06-02 20:36:29', '2022-07-25 14:22:05', NULL),
(5, 'taha485', NULL, 'ayoubbenchamekhid@gmail.com', NULL, '$2y$10$FLtJrQAbdQPyC60DetveV.8QIxME0yY4rm08ff1nDwRMmLupMBxR.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, '2022-07-25 14:33:04', '2022-07-25 14:33:04', NULL),
(6, 'taha485', NULL, 'ayoubbenchamekhid1@gmail.com', NULL, '$2y$10$hhdSSIZLGUM2kosWvTGYteuhMThNClQLLHEkYJZSXbYBH/OuKTxkK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 102, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, '2022-07-25 14:34:29', '2022-07-25 14:34:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affaires`
--
ALTER TABLE `affaires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affaires_ref_unique` (`REF`),
  ADD KEY `affaires_aff_sit_id_foreign` (`aff_sit_id`),
  ADD KEY `affaires_client_id_foreign` (`client_id`),
  ADD KEY `affaires_resp_id_foreign` (`resp_id`),
  ADD KEY `affaires_nature_name_foreign` (`nature_name`),
  ADD KEY `affaires_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `affairesituations`
--
ALTER TABLE `affairesituations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affairesituations_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `affaire_natures`
--
ALTER TABLE `affaire_natures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affaire_natures_name_unique` (`Name`),
  ADD KEY `affaire_natures_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `allocated_brigades`
--
ALTER TABLE `allocated_brigades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allocated_brigades_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_ref_unique` (`REF`),
  ADD KEY `bills_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_details_organisation_id_foreign` (`organisation_id`),
  ADD KEY `bill_details_bills_id_foreign` (`bills_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businesses_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `business_managements`
--
ALTER TABLE `business_managements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_managements_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `business_management_files`
--
ALTER TABLE `business_management_files`
  ADD PRIMARY KEY (`business_id`,`file_id`),
  ADD KEY `business_management_files_organisation_id_foreign` (`organisation_id`),
  ADD KEY `business_management_files_file_id_foreign` (`file_id`);

--
-- Indexes for table `cadastralconsultations`
--
ALTER TABLE `cadastralconsultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cadastralconsultations_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charges_organisation_id_foreign` (`organisation_id`),
  ADD KEY `charges_invoicestatusid_foreign` (`invoiceStatusId`),
  ADD KEY `charges_typeschargeid_foreign` (`typeSchargeId`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_organisation_id_foreign` (`organisation_id`),
  ADD KEY `chat_messages_chat_id_foreign` (`chat_id`),
  ADD KEY `chat_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `chat_user`
--
ALTER TABLE `chat_user`
  ADD PRIMARY KEY (`chat_id`,`user_id`),
  ADD KEY `chat_user_organisation_id_foreign` (`organisation_id`),
  ADD KEY `chat_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fees_organisation_id_foreign` (`organisation_id`),
  ADD KEY `fees_business_id_foreign` (`business_id`);

--
-- Indexes for table `feesfolderteches`
--
ALTER TABLE `feesfolderteches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feesfolderteches_organisation_id_foreign` (`organisation_id`),
  ADD KEY `feesfolderteches_folder_id_foreign` (`folder_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_organisation_id_foreign` (`organisation_id`),
  ADD KEY `files_business_id_foreign` (`business_id`);

--
-- Indexes for table `file_loads`
--
ALTER TABLE `file_loads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_loads_organisation_id_foreign` (`organisation_id`),
  ADD KEY `file_loads_load_id_foreign` (`load_id`);

--
-- Indexes for table `folderteches`
--
ALTER TABLE `folderteches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folderteches_organisation_id_foreign` (`organisation_id`),
  ADD KEY `folderteches_folder_sit_id_foreign` (`folder_sit_id`),
  ADD KEY `folderteches_client_id_foreign` (`client_id`),
  ADD KEY `folderteches_resp_id_foreign` (`resp_id`),
  ADD KEY `folderteches_nature_name_foreign` (`nature_name`);

--
-- Indexes for table `foldertechsituations`
--
ALTER TABLE `foldertechsituations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foldertechsituations_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `folder_tech_natures`
--
ALTER TABLE `folder_tech_natures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `folder_tech_natures_name_unique` (`Name`),
  ADD KEY `folder_tech_natures_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `g_c_s`
--
ALTER TABLE `g_c_s`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `g_c_s_market_title_unique` (`Market_title`),
  ADD KEY `g_c_s_organisation_id_foreign` (`organisation_id`),
  ADD KEY `g_c_s_location_id_foreign` (`location_id`),
  ADD KEY `g_c_s_resp_id_foreign` (`resp_id`),
  ADD KEY `g_c_s_client_id_foreign` (`client_id`);

--
-- Indexes for table `g_c_s_a_b`
--
ALTER TABLE `g_c_s_a_b`
  ADD PRIMARY KEY (`id`),
  ADD KEY `g_c_s_a_b_organisation_id_foreign` (`organisation_id`),
  ADD KEY `g_c_s_a_b_g_c_id_foreign` (`g_c_id`),
  ADD KEY `g_c_s_a_b_a_b_id_foreign` (`a_b_id`);

--
-- Indexes for table `intermediates`
--
ALTER TABLE `intermediates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intermediates_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `invoicestatuses`
--
ALTER TABLE `invoicestatuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoicestatuses_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `linked__documents`
--
ALTER TABLE `linked__documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `linked__documents_organisation_id_foreign` (`organisation_id`),
  ADD KEY `linked__documents_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `loads`
--
ALTER TABLE `loads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loads_organisation_id_foreign` (`organisation_id`),
  ADD KEY `loads_load_related_to_foreign` (`load_related_to`),
  ADD KEY `loads_load_types_name_foreign` (`load_types_name`);

--
-- Indexes for table `load_types`
--
ALTER TABLE `load_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `load_types_name_unique` (`name`),
  ADD KEY `load_types_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_activities_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_organisation_id_foreign` (`organisation_id`),
  ADD KEY `messages_from_id_foreign` (`from_id`),
  ADD KEY `messages_to_id_foreign` (`to_id`);

--
-- Indexes for table `message_files`
--
ALTER TABLE `message_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_files_organisation_id_foreign` (`organisation_id`),
  ADD KEY `message_files_message_id_foreign` (`message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `missions_text_unique` (`text`),
  ADD KEY `missions_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organisations_emailorganisation_unique` (`emailOrganisation`),
  ADD KEY `organisations_created_by_foreign` (`created_by`),
  ADD KEY `organisations_updated_by_foreign` (`updated_by`),
  ADD KEY `organisations_deleted_by_foreign` (`deleted_by`),
  ADD KEY `organisations_cto_foreign` (`cto`);

--
-- Indexes for table `particulars`
--
ALTER TABLE `particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `particulars_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routes_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `typescharges`
--
ALTER TABLE `typescharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `typescharges_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `organisation_id` (`organisation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affaires`
--
ALTER TABLE `affaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affairesituations`
--
ALTER TABLE `affairesituations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `affaire_natures`
--
ALTER TABLE `affaire_natures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `allocated_brigades`
--
ALTER TABLE `allocated_brigades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_managements`
--
ALTER TABLE `business_managements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cadastralconsultations`
--
ALTER TABLE `cadastralconsultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feesfolderteches`
--
ALTER TABLE `feesfolderteches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_loads`
--
ALTER TABLE `file_loads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `folderteches`
--
ALTER TABLE `folderteches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foldertechsituations`
--
ALTER TABLE `foldertechsituations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folder_tech_natures`
--
ALTER TABLE `folder_tech_natures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `g_c_s`
--
ALTER TABLE `g_c_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `g_c_s_a_b`
--
ALTER TABLE `g_c_s_a_b`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intermediates`
--
ALTER TABLE `intermediates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoicestatuses`
--
ALTER TABLE `invoicestatuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `linked__documents`
--
ALTER TABLE `linked__documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loads`
--
ALTER TABLE `loads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `load_types`
--
ALTER TABLE `load_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_files`
--
ALTER TABLE `message_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `particulars`
--
ALTER TABLE `particulars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typescharges`
--
ALTER TABLE `typescharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affaires`
--
ALTER TABLE `affaires`
  ADD CONSTRAINT `affaires_aff_sit_id_foreign` FOREIGN KEY (`aff_sit_id`) REFERENCES `affairesituations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affaires_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affaires_nature_name_foreign` FOREIGN KEY (`nature_name`) REFERENCES `affaire_natures` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affaires_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affaires_resp_id_foreign` FOREIGN KEY (`resp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `affairesituations`
--
ALTER TABLE `affairesituations`
  ADD CONSTRAINT `affairesituations_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `affaire_natures`
--
ALTER TABLE `affaire_natures`
  ADD CONSTRAINT `affaire_natures_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `allocated_brigades`
--
ALTER TABLE `allocated_brigades`
  ADD CONSTRAINT `allocated_brigades_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD CONSTRAINT `bill_details_bills_id_foreign` FOREIGN KEY (`bills_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bill_details_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_managements`
--
ALTER TABLE `business_managements`
  ADD CONSTRAINT `business_managements_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_management_files`
--
ALTER TABLE `business_management_files`
  ADD CONSTRAINT `business_management_files_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business_managements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `business_management_files_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `business_management_files_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cadastralconsultations`
--
ALTER TABLE `cadastralconsultations`
  ADD CONSTRAINT `cadastralconsultations_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_invoicestatusid_foreign` FOREIGN KEY (`invoiceStatusId`) REFERENCES `invoicestatuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `charges_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `charges_typeschargeid_foreign` FOREIGN KEY (`typeSchargeId`) REFERENCES `typescharges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_messages_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_user`
--
ALTER TABLE `chat_user`
  ADD CONSTRAINT `chat_user_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_user_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business_managements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fees_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feesfolderteches`
--
ALTER TABLE `feesfolderteches`
  ADD CONSTRAINT `feesfolderteches_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folderteches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feesfolderteches_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business_managements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `files_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `file_loads`
--
ALTER TABLE `file_loads`
  ADD CONSTRAINT `file_loads_load_id_foreign` FOREIGN KEY (`load_id`) REFERENCES `loads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `file_loads_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `folderteches`
--
ALTER TABLE `folderteches`
  ADD CONSTRAINT `folderteches_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folderteches_folder_sit_id_foreign` FOREIGN KEY (`folder_sit_id`) REFERENCES `foldertechsituations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folderteches_nature_name_foreign` FOREIGN KEY (`nature_name`) REFERENCES `folder_tech_natures` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folderteches_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `folderteches_resp_id_foreign` FOREIGN KEY (`resp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `foldertechsituations`
--
ALTER TABLE `foldertechsituations`
  ADD CONSTRAINT `foldertechsituations_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `folder_tech_natures`
--
ALTER TABLE `folder_tech_natures`
  ADD CONSTRAINT `folder_tech_natures_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `g_c_s`
--
ALTER TABLE `g_c_s`
  ADD CONSTRAINT `g_c_s_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `g_c_s_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `g_c_s_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `g_c_s_resp_id_foreign` FOREIGN KEY (`resp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `g_c_s_a_b`
--
ALTER TABLE `g_c_s_a_b`
  ADD CONSTRAINT `g_c_s_a_b_a_b_id_foreign` FOREIGN KEY (`a_b_id`) REFERENCES `allocated_brigades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `g_c_s_a_b_g_c_id_foreign` FOREIGN KEY (`g_c_id`) REFERENCES `g_c_s` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `g_c_s_a_b_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `intermediates`
--
ALTER TABLE `intermediates`
  ADD CONSTRAINT `intermediates_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoicestatuses`
--
ALTER TABLE `invoicestatuses`
  ADD CONSTRAINT `invoicestatuses_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `linked__documents`
--
ALTER TABLE `linked__documents`
  ADD CONSTRAINT `linked__documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linked__documents_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loads`
--
ALTER TABLE `loads`
  ADD CONSTRAINT `loads_load_related_to_foreign` FOREIGN KEY (`load_related_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loads_load_types_name_foreign` FOREIGN KEY (`load_types_name`) REFERENCES `load_types` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loads_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `load_types`
--
ALTER TABLE `load_types`
  ADD CONSTRAINT `load_types_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD CONSTRAINT `log_activities_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message_files`
--
ALTER TABLE `message_files`
  ADD CONSTRAINT `message_files_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_files_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organisations`
--
ALTER TABLE `organisations`
  ADD CONSTRAINT `organisations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organisations_cto_foreign` FOREIGN KEY (`cto`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organisations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organisations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `particulars`
--
ALTER TABLE `particulars`
  ADD CONSTRAINT `particulars_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `typescharges`
--
ALTER TABLE `typescharges`
  ADD CONSTRAINT `typescharges_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
