-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 01:22 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plantify`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_data`
--

CREATE TABLE `monitoring_data` (
  `ID` int(11) NOT NULL,
  `hum` varchar(10) NOT NULL,
  `temp` varchar(10) NOT NULL,
  `lm` varchar(10) NOT NULL,
  `soil` varchar(10) NOT NULL,
  `water` varchar(10) NOT NULL,
  `light` varchar(10) NOT NULL,
  `Time` timestamp(2) NOT NULL DEFAULT current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plant_care`
--

CREATE TABLE `plant_care` (
  `id` int(11) NOT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `climate` varchar(255) DEFAULT NULL,
  `soil` varchar(255) DEFAULT NULL,
  `sunlight` varchar(255) DEFAULT NULL,
  `watering` varchar(255) DEFAULT NULL,
  `pruning` varchar(255) DEFAULT NULL,
  `fertilizer` varchar(255) DEFAULT NULL,
  `protection` varchar(255) DEFAULT NULL,
  `resource` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plant_care`
--

INSERT INTO `plant_care` (`id`, `plant_name`, `climate`, `soil`, `sunlight`, `watering`, `pruning`, `fertilizer`, `protection`, `resource`) VALUES
(1, 'Mango', 'Requires a warm climate.', 'Well-drained soil.', 'Full sunlight exposure for 6 to 8 hours a day.', 'Regular watering, especially during flowering and fruiting stages.', 'Pruning for size and shape maintenance.', 'Balanced fertilizer during the growing season.', 'Protect from strong winds and frost.', 'https://edis.ifas.ufl.edu/publication/mg216 '),
(2, 'Basil', 'Thrives in warm temperatures.', 'Well-drained soil with a pH of 6 to 7.', 'Full sunlight exposure for 6 to 8 hours a day.', 'Regular watering, keeping the soil consistently moist.', 'Pinching off flowers to encourage leaf growth.', 'Balanced fertilizer every few weeks.', '-', 'https://www.almanac.com/plant/basil'),
(3, 'Lemon', 'Requires a warm climate.', 'Well-drained, slightly acidic soil (pH 5.5 to 6.5).', 'Full sunlight exposure for 6 or more hours a day.', 'Regular watering, keeping the soil moist but not overly wet.', 'Pruning to remove dead or damaged branches and promote air circulation.', 'Citrus-specific fertilizer throughout the growing season.', 'Protect from frost, provide shelter in colder regions.', ' https://www.gardeningknowhow.com/edible/fruits/lemons/how-to-grow-a-lemon-tree.htm');

-- --------------------------------------------------------

--
-- Table structure for table `proceeded_images`
--

CREATE TABLE `proceeded_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_path` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `analysis_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proceeded_images`
--

INSERT INTO `proceeded_images` (`id`, `user_id`, `image_path`, `analysis_date`) VALUES
(91, 1, 'proccessed_images/a39bc84e-5585-407c-885d-347366d8e5e3.png', '2023-05-17 11:51:23'),
(96, 1, 'proccessed_images/54de985f-5b0e-4838-87a6-1a5449d30214.png', '2023-05-17 12:14:57'),
(97, 1, 'proccessed_images/63176496-151b-42fa-bfa0-f217473ab03a.png', '2023-05-17 12:17:21'),
(98, 1, 'proccessed_images/bdc26bf8-0b20-4db8-8f0b-de7d1b4e942f.png', '2023-05-17 12:17:41'),
(99, 1, 'proccessed_images/b68afa1f-488f-4f82-8f7a-9d0442056b39.png', '2023-05-17 12:17:57'),
(100, 1, 'proccessed_images/e06d7ba7-0f73-42a8-92d4-f12815fd46a7.png', '2023-05-17 12:21:45'),
(101, 1, 'proccessed_images/59f74e22-4d91-4339-8dcc-59e5e8905cd6.png', '2023-05-17 12:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `app_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'Plantify',
  `admin_email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `admin_email`) VALUES
(1, 'Plantify', 'nawaf@admin.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `role`, `created_at`) VALUES
(1, 'nawaf@nawaf.com', 'nawaf', '$2y$10$VSVItYRb9xHoFx8HZHMJk.ATXR6WCP.//StcK3nKbEDm60oJHG/k6', 'user', '2023-05-05 18:13:04'),
(2, 'fahad@fahad.com', 'fahad', '$2y$10$4rKY2gqclEukdR08j41paOLeCP.M.Rr.0GFOg8q3olnqtPQEzQUQi', 'user', '2023-05-05 19:24:11'),
(3, 'admin@admin.com', 'admin', '$2y$10$lE2uSmF9c0mgInKLKQmj4.nrufSgZF8oASegIT2.ExxCCjfgWAOpu', 'admin', '2023-05-08 14:42:13'),
(4, 'jef@jef.com', 'jef', '$2y$10$t3oYOOhhqyHB7kZCRDzAW.dtEjdj4pdthK06fP7JKZ/rXH6kfvMaK', 'admin', '2023-05-14 00:21:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitoring_data`
--
ALTER TABLE `monitoring_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `plant_care`
--
ALTER TABLE `plant_care`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proceeded_images`
--
ALTER TABLE `proceeded_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_proceeded_image` (`user_id`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `monitoring_data`
--
ALTER TABLE `monitoring_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `plant_care`
--
ALTER TABLE `plant_care`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proceeded_images`
--
ALTER TABLE `proceeded_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `proceeded_images`
--
ALTER TABLE `proceeded_images`
  ADD CONSTRAINT `user_id_proceeded_image` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
