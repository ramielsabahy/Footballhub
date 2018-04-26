-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2018 at 12:19 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repo2`
--

-- --------------------------------------------------------

--
-- Table structure for table `hubcategories`
--

CREATE TABLE `hubcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubcategories`
--

INSERT INTO `hubcategories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2017-12-29 16:59:23', '2017-12-29 16:59:23'),
(2, NULL, 1, 'Category 2', 'category-2', '2017-12-29 16:59:24', '2017-12-29 16:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `hubdata_rows`
--

CREATE TABLE `hubdata_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubdata_rows`
--

INSERT INTO `hubdata_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '', 1),
(2, 1, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, '', 2),
(3, 1, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, '', 3),
(4, 1, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '', 4),
(5, 1, 'excerpt', 'text_area', 'excerpt', 1, 0, 1, 1, 1, 1, '', 5),
(6, 1, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, '', 6),
(7, 1, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(8, 1, 'slug', 'text', 'slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 8),
(9, 1, 'meta_description', 'text_area', 'meta_description', 1, 0, 1, 1, 1, 1, '', 9),
(10, 1, 'meta_keywords', 'text_area', 'meta_keywords', 1, 0, 1, 1, 1, 1, '', 10),
(11, 1, 'status', 'select_dropdown', 'status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(12, 1, 'created_at', 'timestamp', 'created_at', 0, 1, 1, 0, 0, 0, '', 12),
(13, 1, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 13),
(14, 2, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(15, 2, 'author_id', 'text', 'author_id', 1, 0, 0, 0, 0, 0, '', 2),
(16, 2, 'title', 'text', 'title', 1, 1, 1, 1, 1, 1, '', 3),
(17, 2, 'excerpt', 'text_area', 'excerpt', 1, 0, 1, 1, 1, 1, '', 4),
(18, 2, 'body', 'rich_text_box', 'body', 1, 0, 1, 1, 1, 1, '', 5),
(19, 2, 'slug', 'text', 'slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"}}', 6),
(20, 2, 'meta_description', 'text', 'meta_description', 1, 0, 1, 1, 1, 1, '', 7),
(21, 2, 'meta_keywords', 'text', 'meta_keywords', 1, 0, 1, 1, 1, 1, '', 8),
(22, 2, 'status', 'select_dropdown', 'status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(23, 2, 'created_at', 'timestamp', 'created_at', 1, 1, 1, 0, 0, 0, '', 10),
(24, 2, 'updated_at', 'timestamp', 'updated_at', 1, 0, 0, 0, 0, 0, '', 11),
(25, 2, 'image', 'image', 'image', 0, 1, 1, 1, 1, 1, '', 12),
(26, 3, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(27, 3, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, '', 2),
(28, 3, 'email', 'text', 'email', 1, 1, 1, 1, 1, 1, '', 3),
(29, 3, 'password', 'password', 'password', 0, 0, 0, 1, 1, 0, '', 4),
(30, 3, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"roles\",\"pivot\":\"0\"}', 10),
(31, 3, 'remember_token', 'text', 'remember_token', 0, 0, 0, 0, 0, 0, '', 5),
(32, 3, 'created_at', 'timestamp', 'created_at', 0, 1, 1, 0, 0, 0, '', 6),
(33, 3, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 7),
(34, 3, 'avatar', 'image', 'avatar', 0, 1, 1, 1, 1, 1, '', 8),
(35, 5, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(36, 5, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, '', 2),
(37, 5, 'created_at', 'timestamp', 'created_at', 0, 0, 0, 0, 0, 0, '', 3),
(38, 5, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 4),
(39, 4, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, '', 1),
(40, 4, 'parent_id', 'select_dropdown', 'parent_id', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(41, 4, 'order', 'text', 'order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(42, 4, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, '', 4),
(43, 4, 'slug', 'text', 'slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(44, 4, 'created_at', 'timestamp', 'created_at', 0, 0, 1, 0, 0, 0, '', 6),
(45, 4, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, '', 7),
(46, 6, 'id', 'number', 'id', 1, 0, 0, 0, 0, 0, NULL, 1),
(47, 6, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(48, 6, 'created_at', 'timestamp', 'created_at', 0, 0, 0, 0, 0, 0, NULL, 3),
(49, 6, 'updated_at', 'timestamp', 'updated_at', 0, 0, 0, 0, 0, 0, NULL, 4),
(50, 6, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(51, 1, 'seo_title', 'text', 'seo_title', 0, 1, 1, 1, 1, 1, '', 14),
(52, 1, 'featured', 'checkbox', 'featured', 1, 1, 1, 1, 1, 1, '', 15),
(53, 3, 'role_id', 'text', 'role_id', 1, 1, 1, 1, 1, 1, '', 9),
(60, 10, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(61, 10, 'feed_id', 'number', 'Feed Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(62, 10, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(63, 10, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(64, 12, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(65, 12, 'feed_id', 'number', 'Feed Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(66, 12, 'report_id', 'number', 'Report Id', 1, 1, 1, 1, 1, 1, NULL, 3),
(67, 12, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 4),
(68, 12, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 5),
(69, 13, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(70, 13, 'body', 'text', 'Body', 1, 1, 1, 1, 1, 1, NULL, 3),
(71, 13, 'thumbnail', 'checkbox', 'Thumbnail', 1, 1, 1, 1, 1, 1, NULL, 4),
(72, 13, 'type', 'number', 'Type', 1, 1, 1, 1, 1, 1, NULL, 5),
(73, 13, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(74, 13, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 6),
(75, 13, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(76, 15, 'follower', 'number', 'Follower', 1, 1, 1, 1, 1, 1, NULL, 1),
(77, 15, 'following', 'number', 'Following', 1, 1, 1, 1, 1, 1, NULL, 2),
(78, 15, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(79, 15, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(80, 16, 'player_id', 'number', 'Player Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(81, 16, 'friendly_match_id', 'number', 'Friendly Match Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(82, 16, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(83, 16, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(84, 17, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(85, 17, 'place', 'text', 'Place', 1, 1, 1, 1, 1, 1, NULL, 3),
(86, 17, 'time', 'timestamp', 'Time', 1, 1, 1, 1, 1, 1, NULL, 4),
(87, 17, 'matchName', 'text', 'MatchName', 1, 1, 1, 1, 1, 1, NULL, 5),
(88, 17, 'status', 'number', 'Status', 1, 1, 1, 1, 1, 1, NULL, 6),
(89, 17, 'owner_id', 'number', 'Owner Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(90, 17, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 7),
(91, 17, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 8),
(92, 19, 'player_id', 'number', 'Player Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(93, 19, 'friendly_match_id', 'number', 'Friendly Match Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(94, 19, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(95, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(96, 20, 'player_id', 'number', 'Player Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(97, 20, 'total_points', 'number', 'Total Points', 1, 1, 1, 1, 1, 1, NULL, 2),
(98, 20, 'total_number_of_played_matches', 'number', 'Total Number Of Played Matches', 1, 1, 1, 1, 1, 1, NULL, 3),
(99, 20, 'number_of_won_matches', 'number', 'Number Of Won Matches', 1, 1, 1, 1, 1, 1, NULL, 4),
(100, 20, 'number_of_goals', 'number', 'Number Of Goals', 1, 1, 1, 1, 1, 1, NULL, 5),
(101, 20, 'number_of_assists', 'number', 'Number Of Assists', 1, 1, 1, 1, 1, 1, NULL, 6),
(102, 20, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 7),
(103, 20, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 8),
(104, 21, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(105, 21, 'team_id', 'number', 'Team Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(106, 21, 'status', 'number', 'Status', 1, 1, 1, 1, 1, 1, NULL, 3),
(107, 21, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 4),
(108, 21, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 5),
(109, 23, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(110, 23, 'mobileNumber', 'text', 'MobileNumber', 1, 1, 1, 1, 1, 1, NULL, 3),
(111, 23, 'team_id', 'number', 'Team Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(112, 23, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 4),
(113, 23, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 5),
(114, 24, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(115, 24, 'type', 'text', 'Type', 1, 1, 1, 1, 1, 1, NULL, 2),
(116, 24, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, NULL, 3),
(117, 24, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 4),
(118, 24, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 5),
(119, 26, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(120, 26, 'role_id', 'number', 'Role Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(121, 28, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(122, 28, 'name', 'text_area', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(123, 28, 'display_name', 'text_area', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 3),
(124, 28, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, NULL, 4),
(125, 28, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 5),
(126, 28, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 6),
(127, 29, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(128, 29, 'name', 'text_area', 'Name', 1, 1, 1, 1, 1, 1, NULL, 3),
(129, 29, 'description', 'text_area', 'Description', 1, 1, 1, 1, 1, 1, NULL, 4),
(130, 29, 'logo', 'text_area', 'Logo', 1, 1, 1, 1, 1, 1, NULL, 5),
(131, 29, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(132, 29, 'code', 'text_area', 'Code', 1, 1, 1, 1, 1, 1, NULL, 6),
(133, 29, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 7),
(134, 29, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 8),
(135, 30, 'status', 'number', 'Status', 1, 1, 1, 1, 1, 1, NULL, 3),
(136, 30, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(137, 30, 'team_id', 'number', 'Team Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(138, 30, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 4),
(139, 30, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 5),
(140, 31, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 1),
(141, 31, 'team_id', 'number', 'Team Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(142, 31, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(143, 31, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(144, 32, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(145, 32, 'termsandconditions', 'text_area', 'Termsandconditions', 1, 1, 1, 1, 1, 1, NULL, 2),
(146, 32, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 3),
(147, 32, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(148, 33, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(149, 33, 'comment', 'text', 'Comment', 1, 1, 1, 1, 1, 1, NULL, 4),
(150, 33, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(151, 33, 'feed_id', 'number', 'Feed Id', 1, 1, 1, 1, 1, 1, NULL, 3),
(152, 33, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 5),
(153, 33, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 6),
(154, 34, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(155, 34, 'weight', 'number', 'Weight', 1, 1, 1, 1, 1, 1, NULL, 3),
(156, 34, 'height', 'number', 'Height', 1, 1, 1, 1, 1, 1, NULL, 4),
(157, 34, 'birth', 'date', 'Birth', 1, 1, 1, 1, 1, 1, NULL, 5),
(158, 34, 'user_id', 'number', 'User Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(159, 34, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 6),
(160, 34, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(161, 35, 'user_id', 'number', 'User Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(162, 35, 'team_id', 'number', 'Team Id', 1, 1, 1, 1, 1, 1, NULL, 2),
(163, 35, 'join_request', 'number', 'Join Request', 1, 1, 1, 1, 1, 1, NULL, 3),
(164, 35, 'invitation_request', 'number', 'Invitation Request', 1, 1, 1, 1, 1, 1, NULL, 4),
(165, 35, 'status', 'number', 'Status', 1, 1, 1, 1, 1, 1, NULL, 5),
(166, 35, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 6),
(167, 35, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(204, 43, 'id', 'checkbox', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(205, 43, 'pushToken', 'checkbox', 'PushToken', 1, 1, 1, 1, 1, 1, NULL, 2),
(206, 43, 'mobileTypeId', 'checkbox', 'MobileTypeId', 1, 1, 1, 1, 1, 1, NULL, 3),
(207, 43, 'userId', 'checkbox', 'UserId', 1, 1, 1, 1, 1, 1, NULL, 4),
(208, 43, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 5),
(209, 43, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 6),
(210, 6, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, NULL, 4),
(211, 47, 'id', 'number', 'Id', 1, 0, 0, 0, 0, 0, NULL, 1),
(212, 47, 'role_id', 'number', 'Role Id', 0, 1, 1, 1, 1, 1, NULL, 2),
(213, 47, 'fullName', 'text', 'FullName', 1, 1, 1, 1, 1, 1, NULL, 3),
(214, 47, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(215, 47, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 5),
(216, 47, 'avatar', 'text', 'Avatar', 0, 1, 1, 1, 1, 1, NULL, 6),
(217, 47, 'password', 'text', 'Password', 1, 1, 1, 1, 1, 1, NULL, 7),
(218, 47, 'mobileNumber', 'text', 'MobileNumber', 1, 1, 1, 1, 1, 1, NULL, 8),
(219, 47, 'remember_token', 'text', 'Remember Token', 0, 1, 1, 1, 1, 1, NULL, 9),
(220, 47, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, NULL, 10),
(221, 47, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 11),
(222, 47, 'hubuser_belongstomany_hubcategory_relationship', 'relationship', 'hubcategories', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Role\",\"table\":\"hubroles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubrole_user\",\"pivot\":\"1\"}', 12),
(223, 47, 'hubuser_hasmany_hubcategory_relationship', 'relationship', 'hubcategories', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Feed\",\"table\":\"hubfeeds\",\"type\":\"hasMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 13),
(224, 47, 'hubuser_hasmany_hubcategory_relationship_1', 'relationship', 'hubcategories', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\UserFeedComment\",\"table\":\"hubcategories\",\"type\":\"hasMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 14),
(225, 47, 'hubuser_hasmany_hubfeed_like_relationship', 'relationship', 'hubfeed_likes', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\FeedLike\",\"table\":\"hubfeed_likes\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 15),
(226, 47, 'hubuser_hasmany_hubfeed_report_relationship', 'relationship', 'hubfeed_report', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\feed_report\",\"table\":\"hubfeed_report\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 16),
(227, 47, 'hubuser_hasmany_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 17),
(228, 47, 'hubuser_hasmany_hubteams_user_relationship', 'relationship', 'hubteams_users', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\teams_users\",\"table\":\"hubteams_users\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 18),
(229, 47, 'hubuser_hasmany_hubteams_invitation_relationship', 'relationship', 'hubteams_invitations', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\TeamsInvitations\",\"table\":\"hubteams_invitations\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 19),
(230, 47, 'hubuser_hasmany_hubfriendly_match_relationship', 'relationship', 'hubfriendly_matches', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyMatch\",\"table\":\"hubfriendly_matches\",\"type\":\"hasMany\",\"column\":\"owner_id\",\"key\":\"id\",\"label\":\"owner_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 20),
(231, 47, 'hubuser_hasmany_hubfriendly_invitation_relationship', 'relationship', 'hubfriendly_invitations', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyInvitation\",\"table\":\"hubfriendly_invitations\",\"type\":\"hasMany\",\"column\":\"player_id\",\"key\":\"player_id\",\"label\":\"player_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 21),
(232, 47, 'hubuser_hasmany_hubfriendly_member_relationship', 'relationship', 'hubfriendly_members', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyMembers\",\"table\":\"hubfriendly_members\",\"type\":\"hasMany\",\"column\":\"player_id\",\"key\":\"player_id\",\"label\":\"player_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 22),
(233, 47, 'hubuser_hasmany_hubfriendly_score_relationship', 'relationship', 'hubfriendly_scores', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\FriendlyScore\",\"table\":\"hubfriendly_scores\",\"type\":\"hasMany\",\"column\":\"player_id\",\"key\":\"player_id\",\"label\":\"player_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 23),
(234, 35, 'hubuser_team_belongsto_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"belongsTo\",\"column\":\"team_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 8),
(235, 35, 'hubuser_team_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 9),
(236, 34, 'hubuser_info_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 8),
(237, 33, 'hubuser_feed_comment_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 7),
(238, 33, 'hubuser_feed_comment_belongsto_hubfeed_relationship', 'relationship', 'hubfeeds', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Feed\",\"table\":\"hubfeeds\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 8),
(239, 31, 'hubteams_user_belongsto_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 5),
(240, 31, 'hubteams_user_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(241, 30, 'hubteams_invitation_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(242, 30, 'hubteams_invitation_belongsto_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 7),
(243, 28, 'hubrole_belongstomany_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubrole_user\",\"pivot\":\"1\"}', 7),
(244, 24, 'hubreport_hasmany_hubfeed_report_relationship', 'relationship', 'hubfeed_report', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\feed_report\",\"table\":\"hubfeed_report\",\"type\":\"hasMany\",\"column\":\"user_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(245, 43, 'hubdevice_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 7),
(246, 17, 'hubfriendly_match_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"owner_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 9),
(247, 17, 'hubfriendly_match_hasmany_hubfriendly_invitation_relationship', 'relationship', 'hubfriendly_invitations', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyInvitation\",\"table\":\"hubfriendly_invitations\",\"type\":\"hasMany\",\"column\":\"friendly_match_id\",\"key\":\"player_id\",\"label\":\"player_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 10),
(248, 17, 'hubfriendly_match_hasmany_hubfriendly_member_relationship', 'relationship', 'hubfriendly_members', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyMembers\",\"table\":\"hubfriendly_members\",\"type\":\"hasMany\",\"column\":\"friendly_match_id\",\"key\":\"player_id\",\"label\":\"friendly_match_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 11),
(249, 19, 'hubfriendly_member_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"player_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 5),
(250, 19, 'hubfriendly_member_belongsto_hubfriendly_match_relationship', 'relationship', 'hubfriendly_matches', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyMatch\",\"table\":\"hubfriendly_matches\",\"type\":\"belongsTo\",\"column\":\"friendly_match_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(251, 20, 'hubfriendly_score_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"player_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 9),
(252, 21, 'hubinvitation_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(253, 21, 'hubinvitation_belongsto_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 7),
(254, 23, 'hubphones_invitation_belongsto_hubteam_relationship', 'relationship', 'hubteams', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Team\",\"table\":\"hubteams\",\"type\":\"belongsTo\",\"column\":\"team_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(255, 29, 'hubteam_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 9),
(256, 29, 'hubteam_hasmany_hubteams_user_relationship', 'relationship', 'hubteams_users', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\teams_users\",\"table\":\"hubteams_users\",\"type\":\"hasMany\",\"column\":\"team_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 10),
(257, 29, 'hubteam_hasmany_hubteams_invitation_relationship', 'relationship', 'hubteams_invitations', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\TeamsInvitations\",\"table\":\"hubteams_invitations\",\"type\":\"hasMany\",\"column\":\"team_id\",\"key\":\"user_id\",\"label\":\"team_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 11),
(258, 29, 'hubteam_hasmany_hubphones_invitation_relationship', 'relationship', 'hubphones_invitations', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\phonesInvitation\",\"table\":\"hubphones_invitations\",\"type\":\"hasMany\",\"column\":\"team_id\",\"key\":\"id\",\"label\":\"team_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 12),
(259, 16, 'hubfriendly_invitation_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"player_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 5),
(260, 16, 'hubfriendly_invitation_belongsto_hubfriendly_match_relationship', 'relationship', 'hubfriendly_matches', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\friendlyMatch\",\"table\":\"hubfriendly_matches\",\"type\":\"belongsTo\",\"column\":\"friendly_match_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(261, 15, 'hubfollow_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"follower\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 5),
(262, 15, 'hubfollow_belongsto_hubuser_relationship_1', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"following\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(263, 13, 'hubfeed_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 8),
(264, 13, 'hubfeed_hasmany_hubuser_feed_comment_relationship', 'relationship', 'hubuser_feed_comments', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\UserFeedComment\",\"table\":\"hubuser_feed_comments\",\"type\":\"hasMany\",\"column\":\"feed_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 9),
(265, 13, 'hubfeed_hasmany_hubfeed_like_relationship', 'relationship', 'hubfeed_likes', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\FeedLike\",\"table\":\"hubfeed_likes\",\"type\":\"hasMany\",\"column\":\"feed_id\",\"key\":\"user_id\",\"label\":\"user_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 10),
(266, 13, 'hubfeed_hasmany_hubfeed_report_relationship', 'relationship', 'hubfeed_report', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\feed_report\",\"table\":\"hubfeed_report\",\"type\":\"hasMany\",\"column\":\"feed_id\",\"key\":\"user_id\",\"label\":\"feed_id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 11),
(267, 12, 'hubfeed_report_belongsto_hubuser_relationship', 'relationship', 'hubusers', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\User\",\"table\":\"hubusers\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 6),
(268, 12, 'hubfeed_report_belongsto_hubfeed_relationship', 'relationship', 'hubfeeds', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Feed\",\"table\":\"hubfeeds\",\"type\":\"belongsTo\",\"column\":\"feed_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 7),
(269, 12, 'hubfeed_report_belongsto_hubreport_relationship', 'relationship', 'hubreports', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Report\",\"table\":\"hubreports\",\"type\":\"belongsTo\",\"column\":\"report_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"hubcategories\",\"pivot\":\"0\"}', 8);

-- --------------------------------------------------------

--
-- Table structure for table `hubdata_types`
--

CREATE TABLE `hubdata_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubdata_types`
--

INSERT INTO `hubdata_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `created_at`, `updated_at`) VALUES
(1, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, '2017-12-29 16:59:00', '2017-12-29 16:59:00'),
(2, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, '2017-12-29 16:59:00', '2017-12-29 16:59:00'),
(3, 'users', 'users', 'User', 'Users', 'voyager-person', 'App\\User', 'TCG\\Voyager\\Policies\\UserPolicy', '', '', 1, 0, '2017-12-29 16:59:01', '2017-12-29 16:59:01'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, '2017-12-29 16:59:01', '2017-12-29 16:59:01'),
(5, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, '2017-12-29 16:59:01', '2017-12-29 16:59:01'),
(6, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'App\\Role', NULL, NULL, NULL, 1, 1, '2017-12-29 16:59:01', '2017-12-30 11:33:38'),
(10, 'hubfeed_likes', 'hubfeed-likes', 'Hubfeed Like', 'Hubfeed Likes', NULL, 'App\\FeedLike', NULL, NULL, NULL, 0, 1, '2017-12-30 04:39:21', '2017-12-31 07:15:34'),
(12, 'hubfeed_report', 'hubfeed-report', 'Hubfeed Report', 'Hubfeed Reports', NULL, 'App\\feed_report', NULL, NULL, NULL, 1, 1, '2017-12-30 04:41:28', '2017-12-31 06:01:14'),
(13, 'hubfeeds', 'hubfeeds', 'Hubfeed', 'Hubfeeds', NULL, 'App\\Feed', NULL, NULL, NULL, 1, 1, '2017-12-30 04:42:13', '2017-12-30 10:56:39'),
(15, 'hubfollows', 'hubfollows', 'Hubfollow', 'Hubfollows', NULL, 'App\\Follow', NULL, NULL, NULL, 1, 0, '2017-12-30 04:43:22', '2017-12-31 06:08:14'),
(16, 'hubfriendly_invitations', 'hubfriendly-invitations', 'Hubfriendly Invitation', 'Hubfriendly Invitations', NULL, 'App\\friendlyInvitation', NULL, NULL, NULL, 0, 1, '2017-12-30 04:44:11', '2017-12-30 12:15:10'),
(17, 'hubfriendly_matches', 'hubfriendly-matches', 'Hubfriendly Match', 'Hubfriendly Matches', NULL, 'App\\friendlyMatch', NULL, NULL, NULL, 1, 1, '2017-12-30 04:44:54', '2017-12-30 12:15:40'),
(19, 'hubfriendly_members', 'hubfriendly-members', 'Hubfriendly Member', 'Hubfriendly Members', NULL, 'App\\friendlyMembers', NULL, NULL, NULL, 1, 1, '2017-12-30 04:46:21', '2017-12-31 07:05:28'),
(20, 'hubfriendly_scores', 'hubfriendly-scores', 'Hubfriendly Score', 'Hubfriendly Scores', NULL, 'App\\FriendlyScore', NULL, NULL, NULL, 1, 1, '2017-12-30 04:46:58', '2017-12-31 07:04:58'),
(21, 'hubinvitations', 'hubinvitations', 'Hubinvitation', 'Hubinvitations', NULL, 'App\\Invitation', NULL, NULL, NULL, 1, 1, '2017-12-30 04:47:30', '2017-12-31 07:04:31'),
(23, 'hubphones_invitations', 'hubphones-invitations', 'Hubphones Invitation', 'Hubphones Invitations', NULL, 'App\\phonesInvitation', NULL, NULL, NULL, 1, 1, '2017-12-30 04:49:02', '2017-12-30 12:24:55'),
(24, 'hubreports', 'hubreports', 'Hubreport', 'Hubreports', NULL, 'App\\Report', NULL, NULL, NULL, 1, 1, '2017-12-30 04:49:33', '2017-12-31 07:03:44'),
(26, 'hubrole_user', 'hubrole-user', 'Hubrole User', 'Hubrole Users', NULL, 'App\\role_user', NULL, NULL, NULL, 1, 1, '2017-12-30 04:50:22', '2017-12-31 07:02:56'),
(28, 'hubroles', 'hubroles', 'Hubrole', 'Hubroles', NULL, 'App\\Role', NULL, NULL, NULL, 1, 1, '2017-12-30 04:51:35', '2017-12-31 07:02:17'),
(29, 'hubteams', 'hubteams', 'Hubteam', 'Hubteams', NULL, 'App\\Team', NULL, NULL, NULL, 1, 1, '2017-12-30 04:52:33', '2017-12-30 10:53:57'),
(30, 'hubteams_invitations', 'hubteams-invitations', 'Hubteams Invitation', 'Hubteams Invitations', NULL, 'App\\TeamsInvitations', NULL, NULL, NULL, 1, 1, '2017-12-30 04:53:12', '2017-12-31 06:56:47'),
(31, 'hubteams_users', 'hubteams-users', 'Hubteams User', 'Hubteams Users', NULL, 'App\\teams_users', NULL, NULL, NULL, 1, 1, '2017-12-30 04:53:46', '2017-12-31 06:56:23'),
(32, 'hubterms_and_conditions', 'hubterms-and-conditions', 'Hubterms And Condition', 'Hubterms And Conditions', NULL, 'App\\TermsAndCondition', NULL, NULL, NULL, 1, 1, '2017-12-30 04:54:18', '2017-12-31 06:55:34'),
(33, 'hubuser_feed_comments', 'hubuser-feed-comments', 'Hubuser Feed Comment', 'Hubuser Feed Comments', NULL, 'App\\UserFeedComment', NULL, NULL, NULL, 1, 1, '2017-12-30 04:54:53', '2017-12-31 06:55:10'),
(34, 'hubuser_infos', 'hubuser-infos', 'Hubuser Info', 'Hubuser Infos', NULL, 'App\\UserInfo', NULL, NULL, NULL, 1, 1, '2017-12-30 04:58:53', '2017-12-31 06:54:42'),
(35, 'hubuser_teams', 'hubuser-teams', 'User Team', 'Hubuser Teams', NULL, 'App\\teams_users', NULL, NULL, NULL, 1, 1, '2017-12-30 04:59:48', '2017-12-31 06:54:17'),
(43, 'hubdevices', 'hubdevices', 'Hubdevice', 'Hubdevices', NULL, 'App\\Device', NULL, NULL, NULL, 1, 1, '2017-12-30 07:49:40', '2017-12-30 12:13:45'),
(47, 'hubusers', 'hubusers', 'Hubuser', 'Hubusers', NULL, 'App\\User', NULL, NULL, NULL, 1, 1, '2017-12-30 11:39:25', '2017-12-30 11:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `hubdevices`
--

CREATE TABLE `hubdevices` (
  `id` int(10) UNSIGNED NOT NULL,
  `pushToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobileTypeId` int(11) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubfeeds`
--

CREATE TABLE `hubfeeds` (
  `id` int(10) UNSIGNED NOT NULL,
  `body` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `feed_type` int(11) NOT NULL COMMENT '1 = thumbnail , 2 = text , 3 = video',
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfeeds`
--

INSERT INTO `hubfeeds` (`id`, `body`, `thumbnail`, `type`, `feed_type`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'body', 'https://www.youtube.com/embed/3yK6Rp5RXak', 1, 3, 1, '2018-01-06 10:40:36', '2018-01-06 10:40:36'),
(3, 'body', 'picture', 1, 1, 1, '2018-01-06 10:40:36', '2018-01-06 10:40:36'),
(4, 'body', 'https://www.youtube.com/embed/3yK6Rp5RXak', 2, 3, 1, '2018-01-06 10:40:36', '2018-01-06 10:40:36'),
(5, 'body', 'picture', 2, 2, 1, '2018-01-06 10:40:37', '2018-01-06 10:40:37'),
(6, 'body', 'picture', 2, 2, 1, '2018-01-06 10:40:37', '2018-01-06 10:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `hubfeed_likes`
--

CREATE TABLE `hubfeed_likes` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `feed_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfeed_likes`
--

INSERT INTO `hubfeed_likes` (`user_id`, `feed_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2018-01-08 09:41:09', '2018-01-08 09:41:09'),
(1, 4, '2018-01-08 09:41:12', '2018-01-08 09:41:12'),
(2, 2, '2018-01-08 09:41:10', '2018-01-08 09:41:10'),
(2, 4, '2018-01-08 09:41:12', '2018-01-08 09:41:12'),
(3, 2, '2018-01-08 09:41:11', '2018-01-08 09:41:11'),
(3, 4, '2018-01-08 09:41:12', '2018-01-08 09:41:12'),
(4, 2, '2018-01-08 09:41:11', '2018-01-08 09:41:11'),
(4, 4, '2018-01-08 09:41:12', '2018-01-08 09:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `hubfeed_report`
--

CREATE TABLE `hubfeed_report` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `feed_id` int(10) UNSIGNED NOT NULL,
  `report_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfeed_report`
--

INSERT INTO `hubfeed_report` (`user_id`, `feed_id`, `report_id`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2018-01-06 10:44:27', '2018-01-06 10:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `hubfollows`
--

CREATE TABLE `hubfollows` (
  `follower` int(10) UNSIGNED NOT NULL,
  `following` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubfriendly_invitations`
--

CREATE TABLE `hubfriendly_invitations` (
  `player_id` int(10) UNSIGNED NOT NULL,
  `friendly_match_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfriendly_invitations`
--

INSERT INTO `hubfriendly_invitations` (`player_id`, `friendly_match_id`, `created_at`, `updated_at`) VALUES
(2, 1, '2018-01-03 08:24:24', '2018-01-03 08:24:24'),
(3, 1, '2018-01-03 08:24:24', '2018-01-03 08:24:24'),
(4, 1, '2018-01-03 08:24:24', '2018-01-03 08:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `hubfriendly_matches`
--

CREATE TABLE `hubfriendly_matches` (
  `id` int(10) UNSIGNED NOT NULL,
  `place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `matchName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfriendly_matches`
--

INSERT INTO `hubfriendly_matches` (`id`, `place`, `time`, `matchName`, `status`, `owner_id`, `created_at`, `updated_at`) VALUES
(1, 'Sheraton', '2018-01-04 05:30:00', 'Qualifiers', 1, 1, '2018-01-03 07:32:09', '2018-01-03 07:32:09'),
(2, 'Sadat City', '2017-03-03 08:00:00', 'Rami Match', 1, 1, '2018-01-03 09:26:55', '2018-01-03 09:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `hubfriendly_members`
--

CREATE TABLE `hubfriendly_members` (
  `player_id` int(10) UNSIGNED NOT NULL,
  `friendly_match_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubfriendly_scores`
--

CREATE TABLE `hubfriendly_scores` (
  `player_id` int(10) UNSIGNED NOT NULL,
  `total_points` int(11) NOT NULL DEFAULT '0',
  `total_number_of_played_matches` int(11) NOT NULL DEFAULT '0',
  `number_of_won_matches` int(11) NOT NULL DEFAULT '0',
  `number_of_goals` int(11) NOT NULL DEFAULT '0',
  `number_of_assists` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubfriendly_scores`
--

INSERT INTO `hubfriendly_scores` (`player_id`, `total_points`, `total_number_of_played_matches`, `number_of_won_matches`, `number_of_goals`, `number_of_assists`, `created_at`, `updated_at`) VALUES
(4, 0, 0, 0, 0, 0, '2017-12-30 05:43:16', '2017-12-30 05:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `hubinvitations`
--

CREATE TABLE `hubinvitations` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubmenus`
--

CREATE TABLE `hubmenus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubmenus`
--

INSERT INTO `hubmenus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2017-12-29 16:59:07', '2017-12-29 16:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `hubmenu_items`
--

CREATE TABLE `hubmenu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubmenu_items`
--

INSERT INTO `hubmenu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2017-12-29 16:59:08', '2017-12-29 16:59:08', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 25, '2017-12-29 16:59:08', '2017-12-31 07:29:05', 'voyager.media.index', NULL),
(4, 1, 'Users', '', '_self', 'voyager-person', NULL, NULL, 3, '2017-12-29 16:59:09', '2017-12-29 16:59:09', 'voyager.users.index', NULL),
(5, 1, 'Categories', '', '_self', 'voyager-categories', NULL, NULL, 26, '2017-12-29 16:59:09', '2017-12-31 07:29:05', 'voyager.categories.index', NULL),
(7, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2017-12-29 16:59:09', '2017-12-29 16:59:09', 'voyager.roles.index', NULL),
(8, 1, 'Tools', '', '_self', 'voyager-tools', NULL, NULL, 27, '2017-12-29 16:59:10', '2017-12-31 07:29:05', NULL, NULL),
(9, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 8, 1, '2017-12-29 16:59:10', '2017-12-30 05:00:41', 'voyager.menus.index', NULL),
(10, 1, 'Database', '', '_self', 'voyager-data', NULL, 8, 2, '2017-12-29 16:59:10', '2017-12-31 07:27:22', 'voyager.database.index', NULL),
(11, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 8, 3, '2017-12-29 16:59:10', '2017-12-31 07:27:22', 'voyager.compass.index', NULL),
(12, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 8, 4, '2017-12-29 16:59:10', '2017-12-31 07:27:22', 'voyager.hooks', NULL),
(13, 1, 'Settings', '', '_self', 'voyager-settings', NULL, NULL, 28, '2017-12-29 16:59:11', '2017-12-31 07:29:05', 'voyager.settings.index', NULL),
(14, 1, 'Hubdevices', '/admin/devices', '_self', 'voyager-browser', '#000000', NULL, 6, '2017-12-30 04:38:43', '2017-12-31 07:29:18', NULL, ''),
(15, 1, 'Hubfeed Likes', '/admin/hubfeed-likes', '_self', 'voyager-smile', '#000000', NULL, 8, '2017-12-30 04:39:22', '2017-12-31 07:29:18', NULL, ''),
(16, 1, 'Hubfeed Reports', '/admin/hubfeed-report', '_self', 'voyager-calendar', '#000000', NULL, 7, '2017-12-30 04:41:29', '2017-12-31 07:29:18', NULL, ''),
(17, 1, 'Feeds', '/admin/hubfeeds', '_self', 'voyager-bubble-hear', '#000000', NULL, 5, '2017-12-30 04:42:14', '2017-12-31 07:29:22', NULL, ''),
(18, 1, 'Follows', '/admin/hubfollows', '_self', 'voyager-refresh', '#000000', NULL, 10, '2017-12-30 04:43:23', '2017-12-31 07:29:18', NULL, ''),
(19, 1, 'Friendly Invitations', '/admin/hubfriendly-invitations', '_self', 'voyager-double-right', '#000000', NULL, 11, '2017-12-30 04:44:11', '2017-12-31 07:29:19', NULL, ''),
(20, 1, 'Friendly Matches', '/admin/hubfriendly-matches', '_self', 'voyager-lifebuoy', '#000000', NULL, 12, '2017-12-30 04:44:55', '2017-12-31 07:29:19', NULL, ''),
(21, 1, 'Friendly Members', '/admin/hubfriendly-members', '_self', 'voyager-person', '#000000', NULL, 13, '2017-12-30 04:46:22', '2017-12-31 07:29:19', NULL, ''),
(22, 1, 'Friendly Scores', '/admin/hubfriendly-scores', '_self', 'voyager-angle-right', '#000000', NULL, 14, '2017-12-30 04:46:59', '2017-12-31 07:29:19', NULL, ''),
(23, 1, 'Invitations', '/admin/hubinvitations', '_self', 'voyager-paper-plane', '#000000', NULL, 15, '2017-12-30 04:47:30', '2017-12-31 07:29:11', NULL, ''),
(24, 1, 'Phones Invitations', '/admin/hubphones-invitations', '_self', 'voyager-phone', '#000000', NULL, 16, '2017-12-30 04:49:02', '2017-12-31 07:29:11', NULL, ''),
(25, 1, 'Reports', '/admin/hubreports', '_self', 'voyager-window-list', '#000000', NULL, 17, '2017-12-30 04:49:34', '2017-12-31 07:29:11', NULL, ''),
(26, 1, 'Role Users', '/admin/hubrole-user', '_self', 'voyager-folder', '#000000', NULL, 18, '2017-12-30 04:50:23', '2017-12-31 07:29:11', NULL, ''),
(28, 1, 'Teams', '/admin/hubteams', '_self', 'voyager-people', '#000000', NULL, 19, '2017-12-30 04:52:33', '2017-12-31 07:29:11', NULL, ''),
(29, 1, 'Teams Invitations', '/admin/hubteams-invitations', '_self', 'voyager-paper-plane', '#000000', NULL, 20, '2017-12-30 04:53:13', '2017-12-31 07:29:11', NULL, ''),
(30, 1, 'Teams Users', '/admin/hubteams-users', '_self', 'voyager-people', '#000000', NULL, 21, '2017-12-30 04:53:46', '2017-12-31 07:29:11', NULL, ''),
(31, 1, 'Terms And Conditions', '/admin/hubterms-and-conditions', '_self', 'voyager-paperclip', '#000000', NULL, 22, '2017-12-30 04:54:18', '2017-12-31 07:29:11', NULL, ''),
(32, 1, 'Hubuser Feed Comments', '/admin/hubuser-feed-comments', '_self', NULL, NULL, NULL, 23, '2017-12-30 04:54:53', '2017-12-31 07:29:12', NULL, NULL),
(33, 1, 'User Infos', '/admin/hubuser-infos', '_self', 'voyager-person', '#000000', NULL, 4, '2017-12-30 04:58:54', '2017-12-31 07:29:22', NULL, ''),
(34, 1, 'Hubuser Teams', '/admin/hubuser-teams', '_self', 'voyager-people', '#000000', NULL, 9, '2017-12-30 04:59:48', '2017-12-31 07:29:18', NULL, ''),
(36, 1, 'Devices', '/admin/hubdevices', '_self', 'voyager-window-list', '#000000', NULL, 24, '2017-12-30 07:29:20', '2017-12-31 07:29:05', NULL, ''),
(37, 1, 'Hubusers', '/admin/hubusers', '_self', NULL, NULL, NULL, 29, '2017-12-30 11:39:25', '2017-12-31 07:27:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hubmigrations`
--

CREATE TABLE `hubmigrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubmigrations`
--

INSERT INTO `hubmigrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_01_01_000000_create_pages_table', 1),
(6, '2016_01_01_000000_create_posts_table', 1),
(7, '2016_02_15_204651_create_categories_table', 1),
(8, '2016_05_19_173453_create_menu_table', 1),
(9, '2016_10_21_190000_create_roles_table', 1),
(10, '2016_10_21_190000_create_settings_table', 1),
(11, '2016_11_30_135954_create_permission_table', 1),
(12, '2016_11_30_141208_create_permission_role_table', 1),
(13, '2016_12_26_201236_data_types__add__server_side', 1),
(14, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(15, '2017_01_14_005015_create_translations_table', 1),
(16, '2017_01_15_000000_add_permission_group_id_to_permissions_table', 1),
(17, '2017_01_15_000000_create_permission_groups_table', 1),
(18, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(19, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(20, '2017_04_11_000000_alter_post_nullable_fields_table', 1),
(21, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(22, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(23, '2017_08_05_000000_add_group_to_settings_table', 1),
(24, '2017_10_02_083550_create_teams_table', 1),
(25, '2017_10_02_084345_create_user_teams_table', 1),
(26, '2017_10_02_140121_create_invitations_table', 1),
(27, '2017_10_03_124601_create_user_infos_table', 1),
(28, '2017_10_28_181609_create_role_user_table', 1),
(29, '2017_10_29_103050_create_follows_table', 1),
(30, '2017_11_04_063337_create_feeds_table', 1),
(31, '2017_11_04_090221_create_user_feed_comments_table', 1),
(32, '2017_11_04_104611_create_feed_likes_table', 1),
(33, '2017_11_06_151520_create_terms_and_conditions_table', 1),
(34, '2017_11_13_155801_create_reports_table', 1),
(35, '2017_11_13_161446_create_feed_reports_table', 1),
(36, '2017_11_20_082135_create_teams_users_table', 1),
(37, '2017_12_05_120014_create_teams_invitations_table', 1),
(38, '2017_12_06_112548_create_phones_invitations_table', 1),
(39, '2017_12_16_210645_create_friendly_matches_table', 1),
(40, '2017_12_16_211046_create_friendly_invitations_table', 1),
(41, '2017_12_16_211107_create_friendly_members_table', 1),
(42, '2017_12_16_235601_create_friendly_scores_table', 1),
(43, '2017_12_19_134447_create_devices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hubpassword_resets`
--

CREATE TABLE `hubpassword_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubpermissions`
--

CREATE TABLE `hubpermissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission_group_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubpermissions`
--

INSERT INTO `hubpermissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`, `permission_group_id`) VALUES
(1, 'browse_admin', NULL, '2017-12-29 16:59:11', '2017-12-29 16:59:11', NULL),
(2, 'browse_database', NULL, '2017-12-29 16:59:11', '2017-12-29 16:59:11', NULL),
(3, 'browse_media', NULL, '2017-12-29 16:59:11', '2017-12-29 16:59:11', NULL),
(4, 'browse_compass', NULL, '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(5, 'browse_menus', 'menus', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(6, 'read_menus', 'menus', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(7, 'edit_menus', 'menus', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(8, 'add_menus', 'menus', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(9, 'delete_menus', 'menus', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(10, 'browse_pages', 'pages', '2017-12-29 16:59:12', '2017-12-29 16:59:12', NULL),
(11, 'read_pages', 'pages', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(12, 'edit_pages', 'pages', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(13, 'add_pages', 'pages', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(14, 'delete_pages', 'pages', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(15, 'browse_roles', 'roles', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(16, 'read_roles', 'roles', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(17, 'edit_roles', 'roles', '2017-12-29 16:59:13', '2017-12-29 16:59:13', NULL),
(18, 'add_roles', 'roles', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(19, 'delete_roles', 'roles', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(20, 'browse_users', 'users', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(21, 'read_users', 'users', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(22, 'edit_users', 'users', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(23, 'add_users', 'users', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(24, 'delete_users', 'users', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(25, 'browse_posts', 'posts', '2017-12-29 16:59:14', '2017-12-29 16:59:14', NULL),
(26, 'read_posts', 'posts', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(27, 'edit_posts', 'posts', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(28, 'add_posts', 'posts', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(29, 'delete_posts', 'posts', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(30, 'browse_categories', 'categories', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(31, 'read_categories', 'categories', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(32, 'edit_categories', 'categories', '2017-12-29 16:59:15', '2017-12-29 16:59:15', NULL),
(33, 'add_categories', 'categories', '2017-12-29 16:59:16', '2017-12-29 16:59:16', NULL),
(34, 'delete_categories', 'categories', '2017-12-29 16:59:16', '2017-12-29 16:59:16', NULL),
(35, 'browse_settings', 'settings', '2017-12-29 16:59:16', '2017-12-29 16:59:16', NULL),
(36, 'read_settings', 'settings', '2017-12-29 16:59:16', '2017-12-29 16:59:16', NULL),
(37, 'edit_settings', 'settings', '2017-12-29 16:59:16', '2017-12-29 16:59:16', NULL),
(38, 'add_settings', 'settings', '2017-12-29 16:59:17', '2017-12-29 16:59:17', NULL),
(39, 'delete_settings', 'settings', '2017-12-29 16:59:17', '2017-12-29 16:59:17', NULL),
(45, 'browse_hubfeed_report', 'hubfeed_report', '2017-12-30 04:41:29', '2017-12-30 04:41:29', NULL),
(46, 'read_hubfeed_report', 'hubfeed_report', '2017-12-30 04:41:29', '2017-12-30 04:41:29', NULL),
(47, 'edit_hubfeed_report', 'hubfeed_report', '2017-12-30 04:41:29', '2017-12-30 04:41:29', NULL),
(48, 'add_hubfeed_report', 'hubfeed_report', '2017-12-30 04:41:29', '2017-12-30 04:41:29', NULL),
(49, 'delete_hubfeed_report', 'hubfeed_report', '2017-12-30 04:41:29', '2017-12-30 04:41:29', NULL),
(50, 'browse_hubfeeds', 'hubfeeds', '2017-12-30 04:42:14', '2017-12-30 04:42:14', NULL),
(51, 'read_hubfeeds', 'hubfeeds', '2017-12-30 04:42:14', '2017-12-30 04:42:14', NULL),
(52, 'edit_hubfeeds', 'hubfeeds', '2017-12-30 04:42:14', '2017-12-30 04:42:14', NULL),
(53, 'add_hubfeeds', 'hubfeeds', '2017-12-30 04:42:14', '2017-12-30 04:42:14', NULL),
(54, 'delete_hubfeeds', 'hubfeeds', '2017-12-30 04:42:14', '2017-12-30 04:42:14', NULL),
(55, 'browse_hubfollows', 'hubfollows', '2017-12-30 04:43:22', '2017-12-30 04:43:22', NULL),
(56, 'read_hubfollows', 'hubfollows', '2017-12-30 04:43:22', '2017-12-30 04:43:22', NULL),
(57, 'edit_hubfollows', 'hubfollows', '2017-12-30 04:43:22', '2017-12-30 04:43:22', NULL),
(58, 'add_hubfollows', 'hubfollows', '2017-12-30 04:43:22', '2017-12-30 04:43:22', NULL),
(59, 'delete_hubfollows', 'hubfollows', '2017-12-30 04:43:22', '2017-12-30 04:43:22', NULL),
(60, 'browse_hubfriendly_matches', 'hubfriendly_matches', '2017-12-30 04:44:55', '2017-12-30 04:44:55', NULL),
(61, 'read_hubfriendly_matches', 'hubfriendly_matches', '2017-12-30 04:44:55', '2017-12-30 04:44:55', NULL),
(62, 'edit_hubfriendly_matches', 'hubfriendly_matches', '2017-12-30 04:44:55', '2017-12-30 04:44:55', NULL),
(63, 'add_hubfriendly_matches', 'hubfriendly_matches', '2017-12-30 04:44:55', '2017-12-30 04:44:55', NULL),
(64, 'delete_hubfriendly_matches', 'hubfriendly_matches', '2017-12-30 04:44:55', '2017-12-30 04:44:55', NULL),
(65, 'browse_hubfriendly_members', 'hubfriendly_members', '2017-12-30 04:46:22', '2017-12-30 04:46:22', NULL),
(66, 'read_hubfriendly_members', 'hubfriendly_members', '2017-12-30 04:46:22', '2017-12-30 04:46:22', NULL),
(67, 'edit_hubfriendly_members', 'hubfriendly_members', '2017-12-30 04:46:22', '2017-12-30 04:46:22', NULL),
(68, 'add_hubfriendly_members', 'hubfriendly_members', '2017-12-30 04:46:22', '2017-12-30 04:46:22', NULL),
(69, 'delete_hubfriendly_members', 'hubfriendly_members', '2017-12-30 04:46:22', '2017-12-30 04:46:22', NULL),
(70, 'browse_hubfriendly_scores', 'hubfriendly_scores', '2017-12-30 04:46:58', '2017-12-30 04:46:58', NULL),
(71, 'read_hubfriendly_scores', 'hubfriendly_scores', '2017-12-30 04:46:58', '2017-12-30 04:46:58', NULL),
(72, 'edit_hubfriendly_scores', 'hubfriendly_scores', '2017-12-30 04:46:58', '2017-12-30 04:46:58', NULL),
(73, 'add_hubfriendly_scores', 'hubfriendly_scores', '2017-12-30 04:46:58', '2017-12-30 04:46:58', NULL),
(74, 'delete_hubfriendly_scores', 'hubfriendly_scores', '2017-12-30 04:46:58', '2017-12-30 04:46:58', NULL),
(75, 'browse_hubinvitations', 'hubinvitations', '2017-12-30 04:47:30', '2017-12-30 04:47:30', NULL),
(76, 'read_hubinvitations', 'hubinvitations', '2017-12-30 04:47:30', '2017-12-30 04:47:30', NULL),
(77, 'edit_hubinvitations', 'hubinvitations', '2017-12-30 04:47:30', '2017-12-30 04:47:30', NULL),
(78, 'add_hubinvitations', 'hubinvitations', '2017-12-30 04:47:30', '2017-12-30 04:47:30', NULL),
(79, 'delete_hubinvitations', 'hubinvitations', '2017-12-30 04:47:30', '2017-12-30 04:47:30', NULL),
(80, 'browse_hubphones_invitations', 'hubphones_invitations', '2017-12-30 04:49:02', '2017-12-30 04:49:02', NULL),
(81, 'read_hubphones_invitations', 'hubphones_invitations', '2017-12-30 04:49:02', '2017-12-30 04:49:02', NULL),
(82, 'edit_hubphones_invitations', 'hubphones_invitations', '2017-12-30 04:49:02', '2017-12-30 04:49:02', NULL),
(83, 'add_hubphones_invitations', 'hubphones_invitations', '2017-12-30 04:49:02', '2017-12-30 04:49:02', NULL),
(84, 'delete_hubphones_invitations', 'hubphones_invitations', '2017-12-30 04:49:02', '2017-12-30 04:49:02', NULL),
(85, 'browse_hubreports', 'hubreports', '2017-12-30 04:49:34', '2017-12-30 04:49:34', NULL),
(86, 'read_hubreports', 'hubreports', '2017-12-30 04:49:34', '2017-12-30 04:49:34', NULL),
(87, 'edit_hubreports', 'hubreports', '2017-12-30 04:49:34', '2017-12-30 04:49:34', NULL),
(88, 'add_hubreports', 'hubreports', '2017-12-30 04:49:34', '2017-12-30 04:49:34', NULL),
(89, 'delete_hubreports', 'hubreports', '2017-12-30 04:49:34', '2017-12-30 04:49:34', NULL),
(90, 'browse_hubrole_user', 'hubrole_user', '2017-12-30 04:50:23', '2017-12-30 04:50:23', NULL),
(91, 'read_hubrole_user', 'hubrole_user', '2017-12-30 04:50:23', '2017-12-30 04:50:23', NULL),
(92, 'edit_hubrole_user', 'hubrole_user', '2017-12-30 04:50:23', '2017-12-30 04:50:23', NULL),
(93, 'add_hubrole_user', 'hubrole_user', '2017-12-30 04:50:23', '2017-12-30 04:50:23', NULL),
(94, 'delete_hubrole_user', 'hubrole_user', '2017-12-30 04:50:23', '2017-12-30 04:50:23', NULL),
(95, 'browse_hubroles', 'hubroles', '2017-12-30 04:51:35', '2017-12-30 04:51:35', NULL),
(96, 'read_hubroles', 'hubroles', '2017-12-30 04:51:35', '2017-12-30 04:51:35', NULL),
(97, 'edit_hubroles', 'hubroles', '2017-12-30 04:51:35', '2017-12-30 04:51:35', NULL),
(98, 'add_hubroles', 'hubroles', '2017-12-30 04:51:35', '2017-12-30 04:51:35', NULL),
(99, 'delete_hubroles', 'hubroles', '2017-12-30 04:51:35', '2017-12-30 04:51:35', NULL),
(100, 'browse_hubteams', 'hubteams', '2017-12-30 04:52:33', '2017-12-30 04:52:33', NULL),
(101, 'read_hubteams', 'hubteams', '2017-12-30 04:52:33', '2017-12-30 04:52:33', NULL),
(102, 'edit_hubteams', 'hubteams', '2017-12-30 04:52:33', '2017-12-30 04:52:33', NULL),
(103, 'add_hubteams', 'hubteams', '2017-12-30 04:52:33', '2017-12-30 04:52:33', NULL),
(104, 'delete_hubteams', 'hubteams', '2017-12-30 04:52:33', '2017-12-30 04:52:33', NULL),
(105, 'browse_hubteams_invitations', 'hubteams_invitations', '2017-12-30 04:53:13', '2017-12-30 04:53:13', NULL),
(106, 'read_hubteams_invitations', 'hubteams_invitations', '2017-12-30 04:53:13', '2017-12-30 04:53:13', NULL),
(107, 'edit_hubteams_invitations', 'hubteams_invitations', '2017-12-30 04:53:13', '2017-12-30 04:53:13', NULL),
(108, 'add_hubteams_invitations', 'hubteams_invitations', '2017-12-30 04:53:13', '2017-12-30 04:53:13', NULL),
(109, 'delete_hubteams_invitations', 'hubteams_invitations', '2017-12-30 04:53:13', '2017-12-30 04:53:13', NULL),
(110, 'browse_hubteams_users', 'hubteams_users', '2017-12-30 04:53:46', '2017-12-30 04:53:46', NULL),
(111, 'read_hubteams_users', 'hubteams_users', '2017-12-30 04:53:46', '2017-12-30 04:53:46', NULL),
(112, 'edit_hubteams_users', 'hubteams_users', '2017-12-30 04:53:46', '2017-12-30 04:53:46', NULL),
(113, 'add_hubteams_users', 'hubteams_users', '2017-12-30 04:53:46', '2017-12-30 04:53:46', NULL),
(114, 'delete_hubteams_users', 'hubteams_users', '2017-12-30 04:53:46', '2017-12-30 04:53:46', NULL),
(115, 'browse_hubterms_and_conditions', 'hubterms_and_conditions', '2017-12-30 04:54:18', '2017-12-30 04:54:18', NULL),
(116, 'read_hubterms_and_conditions', 'hubterms_and_conditions', '2017-12-30 04:54:18', '2017-12-30 04:54:18', NULL),
(117, 'edit_hubterms_and_conditions', 'hubterms_and_conditions', '2017-12-30 04:54:18', '2017-12-30 04:54:18', NULL),
(118, 'add_hubterms_and_conditions', 'hubterms_and_conditions', '2017-12-30 04:54:18', '2017-12-30 04:54:18', NULL),
(119, 'delete_hubterms_and_conditions', 'hubterms_and_conditions', '2017-12-30 04:54:18', '2017-12-30 04:54:18', NULL),
(120, 'browse_hubuser_infos', 'hubuser_infos', '2017-12-30 04:58:53', '2017-12-30 04:58:53', NULL),
(121, 'read_hubuser_infos', 'hubuser_infos', '2017-12-30 04:58:53', '2017-12-30 04:58:53', NULL),
(122, 'edit_hubuser_infos', 'hubuser_infos', '2017-12-30 04:58:53', '2017-12-30 04:58:53', NULL),
(123, 'add_hubuser_infos', 'hubuser_infos', '2017-12-30 04:58:53', '2017-12-30 04:58:53', NULL),
(124, 'delete_hubuser_infos', 'hubuser_infos', '2017-12-30 04:58:53', '2017-12-30 04:58:53', NULL),
(125, 'browse_hubuser_teams', 'hubuser_teams', '2017-12-30 04:59:48', '2017-12-30 04:59:48', NULL),
(126, 'read_hubuser_teams', 'hubuser_teams', '2017-12-30 04:59:48', '2017-12-30 04:59:48', NULL),
(127, 'edit_hubuser_teams', 'hubuser_teams', '2017-12-30 04:59:48', '2017-12-30 04:59:48', NULL),
(128, 'add_hubuser_teams', 'hubuser_teams', '2017-12-30 04:59:48', '2017-12-30 04:59:48', NULL),
(129, 'delete_hubuser_teams', 'hubuser_teams', '2017-12-30 04:59:48', '2017-12-30 04:59:48', NULL),
(160, 'browse_hubdevices', 'hubdevices', '2017-12-30 07:49:40', '2017-12-30 07:49:40', NULL),
(161, 'read_hubdevices', 'hubdevices', '2017-12-30 07:49:40', '2017-12-30 07:49:40', NULL),
(162, 'edit_hubdevices', 'hubdevices', '2017-12-30 07:49:40', '2017-12-30 07:49:40', NULL),
(163, 'add_hubdevices', 'hubdevices', '2017-12-30 07:49:40', '2017-12-30 07:49:40', NULL),
(164, 'delete_hubdevices', 'hubdevices', '2017-12-30 07:49:40', '2017-12-30 07:49:40', NULL),
(165, 'browse_hubusers', 'hubusers', '2017-12-30 11:39:25', '2017-12-30 11:39:25', NULL),
(166, 'read_hubusers', 'hubusers', '2017-12-30 11:39:25', '2017-12-30 11:39:25', NULL),
(167, 'edit_hubusers', 'hubusers', '2017-12-30 11:39:25', '2017-12-30 11:39:25', NULL),
(168, 'add_hubusers', 'hubusers', '2017-12-30 11:39:25', '2017-12-30 11:39:25', NULL),
(169, 'delete_hubusers', 'hubusers', '2017-12-30 11:39:25', '2017-12-30 11:39:25', NULL),
(170, 'browse_hubuser_feed_comments', 'hubuser_feed_comments', '2017-12-31 06:55:10', '2017-12-31 06:55:10', NULL),
(171, 'read_hubuser_feed_comments', 'hubuser_feed_comments', '2017-12-31 06:55:10', '2017-12-31 06:55:10', NULL),
(172, 'edit_hubuser_feed_comments', 'hubuser_feed_comments', '2017-12-31 06:55:10', '2017-12-31 06:55:10', NULL),
(173, 'add_hubuser_feed_comments', 'hubuser_feed_comments', '2017-12-31 06:55:10', '2017-12-31 06:55:10', NULL),
(174, 'delete_hubuser_feed_comments', 'hubuser_feed_comments', '2017-12-31 06:55:10', '2017-12-31 06:55:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hubpermission_groups`
--

CREATE TABLE `hubpermission_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubpermission_role`
--

CREATE TABLE `hubpermission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubpermission_role`
--

INSERT INTO `hubpermission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 4),
(2, 1),
(2, 4),
(3, 1),
(3, 4),
(4, 1),
(4, 4),
(5, 1),
(5, 4),
(6, 1),
(6, 4),
(7, 1),
(7, 4),
(8, 1),
(8, 4),
(9, 1),
(9, 4),
(10, 1),
(10, 4),
(11, 1),
(11, 4),
(12, 1),
(12, 4),
(13, 1),
(13, 4),
(14, 1),
(14, 4),
(15, 1),
(15, 4),
(16, 1),
(16, 4),
(17, 1),
(17, 4),
(18, 1),
(18, 4),
(19, 1),
(19, 4),
(20, 1),
(20, 4),
(21, 1),
(21, 4),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(25, 4),
(26, 1),
(26, 4),
(27, 1),
(27, 4),
(28, 1),
(28, 4),
(29, 1),
(29, 4),
(30, 1),
(30, 4),
(31, 1),
(31, 4),
(32, 1),
(32, 4),
(33, 1),
(33, 4),
(34, 1),
(34, 4),
(35, 1),
(35, 4),
(36, 1),
(36, 4),
(37, 1),
(37, 4),
(38, 1),
(38, 4),
(39, 1),
(39, 4),
(45, 1),
(45, 4),
(46, 1),
(46, 4),
(47, 1),
(47, 4),
(48, 1),
(48, 4),
(49, 1),
(49, 4),
(50, 1),
(50, 4),
(51, 1),
(51, 4),
(52, 1),
(52, 4),
(53, 1),
(53, 4),
(54, 1),
(54, 4),
(55, 1),
(55, 4),
(56, 1),
(56, 4),
(57, 1),
(57, 4),
(58, 1),
(58, 4),
(59, 1),
(59, 4),
(60, 1),
(60, 4),
(61, 1),
(61, 4),
(62, 1),
(62, 4),
(63, 1),
(63, 4),
(64, 1),
(64, 4),
(65, 1),
(65, 4),
(66, 1),
(66, 4),
(67, 1),
(67, 4),
(68, 1),
(68, 4),
(69, 1),
(69, 4),
(70, 1),
(70, 4),
(71, 1),
(71, 4),
(72, 1),
(72, 4),
(73, 1),
(73, 4),
(74, 1),
(74, 4),
(75, 1),
(75, 4),
(76, 1),
(76, 4),
(77, 1),
(77, 4),
(78, 1),
(78, 4),
(79, 1),
(79, 4),
(80, 1),
(80, 4),
(81, 1),
(81, 4),
(82, 1),
(82, 4),
(83, 1),
(83, 4),
(84, 1),
(84, 4),
(85, 1),
(85, 4),
(86, 1),
(86, 4),
(87, 1),
(87, 4),
(88, 1),
(88, 4),
(89, 1),
(89, 4),
(90, 1),
(90, 4),
(91, 1),
(91, 4),
(92, 1),
(92, 4),
(93, 1),
(93, 4),
(94, 1),
(94, 4),
(95, 1),
(95, 4),
(96, 1),
(96, 4),
(97, 1),
(97, 4),
(98, 1),
(98, 4),
(99, 1),
(99, 4),
(100, 1),
(100, 4),
(101, 1),
(101, 4),
(102, 1),
(102, 4),
(103, 1),
(103, 4),
(104, 1),
(104, 4),
(105, 1),
(105, 4),
(106, 1),
(106, 4),
(107, 1),
(107, 4),
(108, 1),
(108, 4),
(109, 1),
(109, 4),
(110, 1),
(110, 4),
(111, 1),
(111, 4),
(112, 1),
(112, 4),
(113, 1),
(113, 4),
(114, 1),
(114, 4),
(115, 1),
(115, 4),
(116, 1),
(116, 4),
(117, 1),
(117, 4),
(118, 1),
(118, 4),
(119, 1),
(119, 4),
(120, 1),
(120, 4),
(121, 1),
(121, 4),
(122, 1),
(122, 4),
(123, 1),
(123, 4),
(124, 1),
(124, 4),
(125, 1),
(125, 4),
(126, 1),
(126, 4),
(127, 1),
(127, 4),
(128, 1),
(128, 4),
(129, 1),
(129, 4),
(160, 1),
(160, 4),
(161, 1),
(161, 4),
(162, 1),
(162, 4),
(163, 1),
(163, 4),
(164, 1),
(164, 4),
(165, 4),
(166, 4),
(167, 4),
(168, 4),
(169, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hubphones_invitations`
--

CREATE TABLE `hubphones_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `mobileNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubreports`
--

CREATE TABLE `hubreports` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubreports`
--

INSERT INTO `hubreports` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Nudity', 'Description for Nudity', '2018-01-03 05:26:51', '2018-01-03 05:26:51'),
(3, 'Violence', 'Description for Violence', '2018-01-03 05:26:51', '2018-01-03 05:26:51'),
(4, 'Harassement', 'Description for Harassement', '2018-01-03 05:26:51', '2018-01-03 05:26:51'),
(5, 'Suicide or Self-Injury', 'Description for Suicide or Self-Injury', '2018-01-03 05:26:51', '2018-01-03 05:26:51'),
(6, 'Spam', 'Description for Spamy', '2018-01-03 05:26:51', '2018-01-03 05:26:51'),
(7, 'Hate Speach', 'Description for Hate Speach', '2018-01-03 05:26:52', '2018-01-03 05:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `hubroles`
--

CREATE TABLE `hubroles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubroles`
--

INSERT INTO `hubroles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admins', 'Administrator', 'Admins of footballhub', '2017-12-29 16:59:11', '2017-12-29 16:59:11'),
(2, 'Players', 'Players', 'Players of footballhub app', '2017-12-29 16:59:11', '2017-12-29 16:59:11'),
(3, 'Referees', 'Referees', 'Refrees of footballhub app', '2017-12-29 19:13:13', '2017-12-29 19:13:13'),
(4, 'admin', 'admin', 'any', '2017-12-30 10:41:06', '2017-12-30 10:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `hubrole_user`
--

CREATE TABLE `hubrole_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubrole_user`
--

INSERT INTO `hubrole_user` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `hubsettings`
--

CREATE TABLE `hubsettings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubsettings`
--

INSERT INTO `hubsettings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Site Title', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', '', '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Voyager', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', '', '', 'text', 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `hubteams`
--

CREATE TABLE `hubteams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubteams`
--

INSERT INTO `hubteams` (`id`, `name`, `description`, `logo`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Dream Team', 'Dream', 'ss3d5sd5sd5s5ds5d33d', 1, 'sd5s35d', '2018-01-02 11:47:29', '2018-01-02 11:47:29'),
(2, 'Hub', 'hub', 'hub', 1, 'hub', '2018-01-10 09:41:50', '2018-01-10 09:41:50'),
(4, 'Hub', 'hub', 'hub', 1, 'hub1', '2018-01-10 10:53:05', '2018-01-10 10:53:05'),
(5, 'Hub', 'hub', 'hub', 1, 'hub2', '2018-01-10 10:53:05', '2018-01-10 10:53:05'),
(6, 'Hub', 'hub', 'hub', 1, 'hub3', '2018-01-10 10:53:05', '2018-01-10 10:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `hubteams_invitations`
--

CREATE TABLE `hubteams_invitations` (
  `status` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubteams_invitations`
--

INSERT INTO `hubteams_invitations` (`status`, `user_id`, `team_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2018-01-03 08:23:07', '2018-01-03 08:23:07'),
(1, 3, 1, '2018-01-03 08:23:07', '2018-01-03 08:23:07'),
(1, 4, 1, '2018-01-03 08:23:08', '2018-01-03 08:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `hubteams_users`
--

CREATE TABLE `hubteams_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubterms_and_conditions`
--

CREATE TABLE `hubterms_and_conditions` (
  `id` int(10) UNSIGNED NOT NULL,
  `termsandconditions` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubtranslations`
--

CREATE TABLE `hubtranslations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubtranslations`
--

INSERT INTO `hubtranslations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 1, 'pt', 'Post', '2017-12-29 16:59:29', '2017-12-29 16:59:29'),
(2, 'data_types', 'display_name_singular', 2, 'pt', 'Página', '2017-12-29 16:59:29', '2017-12-29 16:59:29'),
(3, 'data_types', 'display_name_singular', 3, 'pt', 'Utilizador', '2017-12-29 16:59:30', '2017-12-29 16:59:30'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2017-12-29 16:59:30', '2017-12-29 16:59:30'),
(5, 'data_types', 'display_name_singular', 5, 'pt', 'Menu', '2017-12-29 16:59:30', '2017-12-29 16:59:30'),
(6, 'data_types', 'display_name_singular', 6, 'pt', 'Função', '2017-12-29 16:59:30', '2017-12-29 16:59:30'),
(7, 'data_types', 'display_name_plural', 1, 'pt', 'Posts', '2017-12-29 16:59:31', '2017-12-29 16:59:31'),
(8, 'data_types', 'display_name_plural', 2, 'pt', 'Páginas', '2017-12-29 16:59:31', '2017-12-29 16:59:31'),
(9, 'data_types', 'display_name_plural', 3, 'pt', 'Utilizadores', '2017-12-29 16:59:31', '2017-12-29 16:59:31'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2017-12-29 16:59:32', '2017-12-29 16:59:32'),
(11, 'data_types', 'display_name_plural', 5, 'pt', 'Menus', '2017-12-29 16:59:32', '2017-12-29 16:59:32'),
(12, 'data_types', 'display_name_plural', 6, 'pt', 'Funções', '2017-12-29 16:59:32', '2017-12-29 16:59:32'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2017-12-29 16:59:32', '2017-12-29 16:59:32'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(22, 'menu_items', 'title', 3, 'pt', 'Publicações', '2017-12-29 16:59:33', '2017-12-29 16:59:33'),
(23, 'menu_items', 'title', 4, 'pt', 'Utilizadores', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(24, 'menu_items', 'title', 5, 'pt', 'Categorias', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(25, 'menu_items', 'title', 6, 'pt', 'Páginas', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(26, 'menu_items', 'title', 7, 'pt', 'Funções', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(27, 'menu_items', 'title', 8, 'pt', 'Ferramentas', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(28, 'menu_items', 'title', 9, 'pt', 'Menus', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(29, 'menu_items', 'title', 10, 'pt', 'Base de dados', '2017-12-29 16:59:34', '2017-12-29 16:59:34'),
(30, 'menu_items', 'title', 13, 'pt', 'Configurações', '2017-12-29 16:59:34', '2017-12-29 16:59:34');

-- --------------------------------------------------------

--
-- Table structure for table `hubusers`
--

CREATE TABLE `hubusers` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `fullName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rami Mohamed Elsabahy',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rami',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobileNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '01010589447',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubusers`
--

INSERT INTO `hubusers` (`id`, `role_id`, `fullName`, `name`, `email`, `avatar`, `password`, `mobileNumber`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rami Mohamed Elsabahy', 'Admin', 'admin@admin.com', 'users/default.png', '$2y$10$6p.154O8FgN3QPUebPnzhuy2mQlZ4OXUIRfXGrHsp8933copliLda', '01010589447', 'vrfGoOBFXVszN8SuVRPS4oQITjGBoNeiMMHby9joxiJP4TjYMcrpg3tGvJUx', '2017-12-29 16:59:24', '2017-12-29 16:59:24'),
(2, 1, 'Rami Mohamed Elsabahy', 'Rami Mohamed', 'ramyelsabahy95@gmail.com', 'users/default.png', '$2y$10$eRzFsgbdAI0eG4T.WJS5IezxlFF5lOGj8PAz01Avbvlwp1ZRv7GZO', '01151058104', 'pbuReqbTubQHX1YPosp3FrMjug9KverXqV7vMYcxiWVMNSFTx8fMyJZtSocy', '2017-12-30 05:08:35', '2017-12-30 05:08:35'),
(3, 2, 'Ref', 'Ref', 'ramielsabahy95@gmail.com', 'users/default.png', '$2y$10$S/eRIi.aWfe43kyG.38kSejKYKo8rI0Ev5ubnhw7tociGDIGRJILe', '01280451839', NULL, '2017-12-30 05:42:36', '2017-12-30 05:42:36'),
(4, 2, 'Player', 'Player', 'player@gmail.com', 'users/default.png', '$2y$10$pp8ndaP7vUKrwWQudAtZBOz6DAqEjBjzJnqYVd.cbhmg4dpj8m18m', '01280451830', NULL, '2017-12-30 05:43:16', '2017-12-30 05:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `hubuser_feed_comments`
--

CREATE TABLE `hubuser_feed_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `feed_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubuser_infos`
--

CREATE TABLE `hubuser_infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `weight` double(5,2) NOT NULL,
  `height` double(4,2) NOT NULL,
  `birth` date NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubuser_infos`
--

INSERT INTO `hubuser_infos` (`id`, `weight`, `height`, `birth`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 55.00, 55.00, '0000-00-00', 1, '2017-12-30 09:10:21', '2017-12-30 09:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `hubuser_teams`
--

CREATE TABLE `hubuser_teams` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `join_request` tinyint(1) NOT NULL DEFAULT '0',
  `invitation_request` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubuser_teams`
--

INSERT INTO `hubuser_teams` (`user_id`, `team_id`, `join_request`, `invitation_request`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2018-01-02 13:01:23', '2018-01-02 13:01:23'),
(2, 1, 1, 1, 1, '2018-01-02 13:08:01', '2018-01-02 13:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admins', 'Administrator', 'Admins of footballhub', '2017-12-29 16:59:11', '2017-12-29 16:59:11'),
(2, 'Players', 'Players', 'Players of footballhub app', '2017-12-29 16:59:11', '2017-12-29 16:59:11'),
(3, 'Referees', 'Referees', 'Refrees of footballhub app', '2017-12-29 19:13:13', '2017-12-29 19:13:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hubcategories`
--
ALTER TABLE `hubcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `hubdata_rows`
--
ALTER TABLE `hubdata_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indexes for table `hubdata_types`
--
ALTER TABLE `hubdata_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indexes for table `hubdevices`
--
ALTER TABLE `hubdevices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_userid_index` (`userId`);

--
-- Indexes for table `hubfeeds`
--
ALTER TABLE `hubfeeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feeds_user_id_index` (`user_id`);

--
-- Indexes for table `hubfeed_likes`
--
ALTER TABLE `hubfeed_likes`
  ADD PRIMARY KEY (`user_id`,`feed_id`),
  ADD KEY `feed_likes_user_id_index` (`user_id`),
  ADD KEY `feed_likes_feed_id_index` (`feed_id`);

--
-- Indexes for table `hubfeed_report`
--
ALTER TABLE `hubfeed_report`
  ADD PRIMARY KEY (`user_id`,`feed_id`),
  ADD KEY `feed_report_user_id_index` (`user_id`),
  ADD KEY `feed_report_feed_id_index` (`feed_id`),
  ADD KEY `feed_report_report_id_index` (`report_id`);

--
-- Indexes for table `hubfollows`
--
ALTER TABLE `hubfollows`
  ADD PRIMARY KEY (`follower`,`following`),
  ADD KEY `follows_follower_index` (`follower`),
  ADD KEY `follows_following_index` (`following`);

--
-- Indexes for table `hubfriendly_invitations`
--
ALTER TABLE `hubfriendly_invitations`
  ADD PRIMARY KEY (`player_id`,`friendly_match_id`),
  ADD KEY `friendly_invitations_player_id_index` (`player_id`),
  ADD KEY `friendly_invitations_friendly_match_id_index` (`friendly_match_id`);

--
-- Indexes for table `hubfriendly_matches`
--
ALTER TABLE `hubfriendly_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friendly_matches_owner_id_index` (`owner_id`);

--
-- Indexes for table `hubfriendly_members`
--
ALTER TABLE `hubfriendly_members`
  ADD PRIMARY KEY (`player_id`,`friendly_match_id`),
  ADD KEY `friendly_members_player_id_index` (`player_id`),
  ADD KEY `friendly_members_friendly_match_id_index` (`friendly_match_id`);

--
-- Indexes for table `hubfriendly_scores`
--
ALTER TABLE `hubfriendly_scores`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `friendly_scores_player_id_index` (`player_id`);

--
-- Indexes for table `hubinvitations`
--
ALTER TABLE `hubinvitations`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `invitations_user_id_index` (`user_id`),
  ADD KEY `invitations_team_id_index` (`team_id`);

--
-- Indexes for table `hubmenus`
--
ALTER TABLE `hubmenus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `hubmenu_items`
--
ALTER TABLE `hubmenu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `hubmigrations`
--
ALTER TABLE `hubmigrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubpassword_resets`
--
ALTER TABLE `hubpassword_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `hubpermissions`
--
ALTER TABLE `hubpermissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indexes for table `hubpermission_groups`
--
ALTER TABLE `hubpermission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_name_unique` (`name`);

--
-- Indexes for table `hubpermission_role`
--
ALTER TABLE `hubpermission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `hubphones_invitations`
--
ALTER TABLE `hubphones_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phones_invitations_team_id_mobilenumber_unique` (`team_id`,`mobileNumber`),
  ADD KEY `phones_invitations_team_id_index` (`team_id`);

--
-- Indexes for table `hubreports`
--
ALTER TABLE `hubreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubroles`
--
ALTER TABLE `hubroles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `hubrole_user`
--
ALTER TABLE `hubrole_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_user_id_index` (`user_id`),
  ADD KEY `role_user_role_id_index` (`role_id`);

--
-- Indexes for table `hubsettings`
--
ALTER TABLE `hubsettings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `hubteams`
--
ALTER TABLE `hubteams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_code_unique` (`code`),
  ADD KEY `teams_user_id_index` (`user_id`);

--
-- Indexes for table `hubteams_invitations`
--
ALTER TABLE `hubteams_invitations`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `teams_invitations_status_index` (`status`),
  ADD KEY `teams_invitations_user_id_index` (`user_id`),
  ADD KEY `teams_invitations_team_id_index` (`team_id`);

--
-- Indexes for table `hubteams_users`
--
ALTER TABLE `hubteams_users`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `teams_users_user_id_index` (`user_id`),
  ADD KEY `teams_users_team_id_index` (`team_id`);

--
-- Indexes for table `hubterms_and_conditions`
--
ALTER TABLE `hubterms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubtranslations`
--
ALTER TABLE `hubtranslations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indexes for table `hubusers`
--
ALTER TABLE `hubusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobilenumber_unique` (`mobileNumber`);

--
-- Indexes for table `hubuser_feed_comments`
--
ALTER TABLE `hubuser_feed_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_feed_comments_user_id_index` (`user_id`),
  ADD KEY `user_feed_comments_feed_id_index` (`feed_id`);

--
-- Indexes for table `hubuser_infos`
--
ALTER TABLE `hubuser_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_infos_user_id_unique` (`user_id`);

--
-- Indexes for table `hubuser_teams`
--
ALTER TABLE `hubuser_teams`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_teams_user_id_index` (`user_id`),
  ADD KEY `user_teams_team_id_index` (`team_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hubcategories`
--
ALTER TABLE `hubcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hubdata_rows`
--
ALTER TABLE `hubdata_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- AUTO_INCREMENT for table `hubdata_types`
--
ALTER TABLE `hubdata_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `hubdevices`
--
ALTER TABLE `hubdevices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hubfeeds`
--
ALTER TABLE `hubfeeds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `hubfriendly_matches`
--
ALTER TABLE `hubfriendly_matches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hubmenus`
--
ALTER TABLE `hubmenus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hubmenu_items`
--
ALTER TABLE `hubmenu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `hubmigrations`
--
ALTER TABLE `hubmigrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `hubpermissions`
--
ALTER TABLE `hubpermissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `hubpermission_groups`
--
ALTER TABLE `hubpermission_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hubphones_invitations`
--
ALTER TABLE `hubphones_invitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hubreports`
--
ALTER TABLE `hubreports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `hubroles`
--
ALTER TABLE `hubroles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hubsettings`
--
ALTER TABLE `hubsettings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `hubteams`
--
ALTER TABLE `hubteams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `hubterms_and_conditions`
--
ALTER TABLE `hubterms_and_conditions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hubtranslations`
--
ALTER TABLE `hubtranslations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `hubusers`
--
ALTER TABLE `hubusers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hubuser_feed_comments`
--
ALTER TABLE `hubuser_feed_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hubuser_infos`
--
ALTER TABLE `hubuser_infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `hubcategories`
--
ALTER TABLE `hubcategories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `hubcategories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `hubdata_rows`
--
ALTER TABLE `hubdata_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `hubdata_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubdevices`
--
ALTER TABLE `hubdevices`
  ADD CONSTRAINT `devices_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfeeds`
--
ALTER TABLE `hubfeeds`
  ADD CONSTRAINT `feeds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubfeed_likes`
--
ALTER TABLE `hubfeed_likes`
  ADD CONSTRAINT `feed_likes_feed_id_foreign` FOREIGN KEY (`feed_id`) REFERENCES `hubfeeds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feed_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubfeed_report`
--
ALTER TABLE `hubfeed_report`
  ADD CONSTRAINT `feed_report_feed_id_foreign` FOREIGN KEY (`feed_id`) REFERENCES `hubfeeds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feed_report_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `hubreports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feed_report_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfollows`
--
ALTER TABLE `hubfollows`
  ADD CONSTRAINT `follows_follower_foreign` FOREIGN KEY (`follower`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follows_following_foreign` FOREIGN KEY (`following`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfriendly_invitations`
--
ALTER TABLE `hubfriendly_invitations`
  ADD CONSTRAINT `friendly_invitations_friendly_match_id_foreign` FOREIGN KEY (`friendly_match_id`) REFERENCES `hubfriendly_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendly_invitations_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfriendly_matches`
--
ALTER TABLE `hubfriendly_matches`
  ADD CONSTRAINT `friendly_matches_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfriendly_members`
--
ALTER TABLE `hubfriendly_members`
  ADD CONSTRAINT `friendly_members_friendly_match_id_foreign` FOREIGN KEY (`friendly_match_id`) REFERENCES `hubfriendly_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendly_members_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubfriendly_scores`
--
ALTER TABLE `hubfriendly_scores`
  ADD CONSTRAINT `friendly_scores_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubinvitations`
--
ALTER TABLE `hubinvitations`
  ADD CONSTRAINT `invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `hubteams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubmenu_items`
--
ALTER TABLE `hubmenu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `hubmenus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubpermission_role`
--
ALTER TABLE `hubpermission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `hubpermissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `hubroles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubphones_invitations`
--
ALTER TABLE `hubphones_invitations`
  ADD CONSTRAINT `phones_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `hubteams` (`id`);

--
-- Constraints for table `hubrole_user`
--
ALTER TABLE `hubrole_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `hubroles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hubteams`
--
ALTER TABLE `hubteams`
  ADD CONSTRAINT `teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubteams_invitations`
--
ALTER TABLE `hubteams_invitations`
  ADD CONSTRAINT `teams_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `hubteams` (`id`),
  ADD CONSTRAINT `teams_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`);

--
-- Constraints for table `hubteams_users`
--
ALTER TABLE `hubteams_users`
  ADD CONSTRAINT `teams_users_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `hubteams` (`id`),
  ADD CONSTRAINT `teams_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`);

--
-- Constraints for table `hubuser_feed_comments`
--
ALTER TABLE `hubuser_feed_comments`
  ADD CONSTRAINT `user_feed_comments_feed_id_foreign` FOREIGN KEY (`feed_id`) REFERENCES `hubfeeds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_feed_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubuser_infos`
--
ALTER TABLE `hubuser_infos`
  ADD CONSTRAINT `user_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hubuser_teams`
--
ALTER TABLE `hubuser_teams`
  ADD CONSTRAINT `user_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `hubteams` (`id`),
  ADD CONSTRAINT `user_teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hubusers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
