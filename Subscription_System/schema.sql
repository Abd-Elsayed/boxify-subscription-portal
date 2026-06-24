SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `subscription_db`;
USE `subscription_db`;

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `swaps_left` varchar(50) DEFAULT NULL,
  `referral_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `subscriptions` (`id`, `user_id`, `plan_name`, `swaps_left`, `referral_code`) VALUES
(9, 11, 'Standard', '1', NULL),
(11, 12, 'Gold', '0', NULL),
(22, 8, 'Gold', '2', 'F36C65');



CREATE TABLE `subscription_items` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `subscription_items` (`id`, `subscription_id`, `item_id`) VALUES
(77, 11, 9),
(78, 11, 3),
(79, 11, 15),
(80, 11, 11),
(81, 11, 7),
(82, 11, 6),
(126, 22, 9),
(127, 22, 3),
(128, 22, 7),
(129, 22, 8),
(130, 22, 4),
(131, 22, 1);



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `referral_code` varchar(10) DEFAULT NULL,
  `credits` int(11) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `referral_code`, `credits`, `phone`, `address`) VALUES
(8, 'Abdelrahman', 'boody@gmail.com', '$2y$10$Fr8rfq9yDubopxm33tPKC.DYVSXgqTlD2D7OtoscNTgayZ.499.yW', 'F36C65', 0, '01203533764', 'future');


ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);


ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `subscription_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;