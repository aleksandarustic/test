-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 28, 2020 at 01:21 PM
-- Server version: 10.3.4-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) CHARACTER SET latin1 NOT NULL,
  `email` varchar(60) CHARACTER SET latin1 NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `name`, `email`, `text`, `product_id`, `approved`, `created_at`) VALUES
(18, 'Aleksandar Ustic', 'aleksandarustic2@gmail.com', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque nesciunt maxime placeat a animi dolorem, unde ipsum sit sint id quasi minus ab ratione consequuntur accusamus laudantium perspiciatis eligendi? Doloremque.\r\n', NULL, 1, '2020-03-28 11:57:52'),
(19, 'Nikola Radovic', 'nikola@gmail.com', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque nesciunt maxime placeat a animi dolorem, unde ipsum sit sint id quasi minus ab ratione consequuntur accusamus laudantium perspiciatis eligendi? Doloremque.\r\n', NULL, 1, '2020-03-28 11:58:25'),
(22, ' Nemanje Milenkovic', 'nemanja@gmail.com', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque nesciunt maxime placeat a animi dolorem, unde ipsum sit sint id quasi minus ab ratione consequuntur accusamus laudantium perspiciatis eligendi? Doloremque.', NULL, 0, '2020-03-28 12:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `image`) VALUES
(4, 'Lemon', 'The lemon, Citrus limon Osbeck, is a species of small evergreen tree in the flowering plant family Rutaceae, native to South Asia,', 'products/lemon.jpg'),
(5, 'Pomelo', 'The pomelo, pummelo, or in scientific terms Citrus maxima or Citrus grandis, is the largest citrus fruit from the family Rutaceae', 'products/pamelo.jpg'),
(6, 'Key lime', 'The Key lime is a citrus hybrid with a spherical fruit, 2.5–5 cm in diameter. The Key lime is usually picked while it is still green, but it becomes yellow when ripe.', 'products/key-lime.jpg'),
(7, 'Mandarin orange', 'The mandarin orange, also known as the mandarin or mandarine, is a small citrus tree with fruit resembling other oranges, usually eaten plain or in fruit salads.', 'products/mandarin-orange.jpg'),
(8, 'Grapefruit', 'The grapefruit is a subtropical citrus tree known for its relatively large sour to semi-sweet, somewhat bitter fruit. Grapefruit is a citrus hybrid originating in Barbados as an accidental cross between the sweet orange and pomelo', 'products/grapefruit.jpg'),
(9, 'Bitter orange', 'Bitter orange, Seville orange, sour orange, bigarade orange, or marmalade orange is the citrus tree Citrus × aurantium and its fruit. It is native to southeast Asia ', 'products/bitter-orange.jpg'),
(10, 'Yuzu', 'Yuzu is a citrus fruit and plant in the family Rutaceae. It is believed to have originated in central China as a hybrid of mandarin orange and the ichang papeda.', 'products/yuzu.jpg'),
(11, 'Bergamot orange', 'Citrus bergamia, the bergamot orange, is a fragrant citrus fruit the size of an orange, with a yellow or green color similar to a lime, depending on ripeness.', 'products/bergamot-orange.jpg'),
(12, 'Kaffir lime', 'Citrus hystrix, called the kaffir lime, makrut lime, Thai lime or Mauritius papeda, is a citrus fruit native to tropical Southeast Asia and southern China.', 'products/kaffir-lime.jpg'),
(13, 'Kumquat', 'Kumquats are a group of small fruit-bearing trees in the flowering plant family Rutaceae. ', 'products/kumquat.jpg'),
(14, 'Tangelo', 'The tangelo, Citrus × tangelo, is a citrus fruit hybrid of a Citrus reticulata variety such as mandarin orange or a tangerine, and Citrus maxima variety, such as a pomelo or grapefruit', 'products/tangelo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '$2y$10$Fvl7w162ukNJeufs4DLRweDw3AjSHOIEh1yscImlepxBKj/cqY3Dq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
