-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2025 at 10:24 PM
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
-- Database: `fatimah_collection_schema.sql`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `content`, `thumbnail`, `published_at`, `created_at`, `updated_at`) VALUES
(2, 'Mengenal Trend Fashion Muslim yang Makin Berkembang', 'https://baznas.go.id/artikel-show/Mengenal-Trend-Fashion-Muslim-yang-Makin-Berkembang/267?back=https://baznas.go.id/artikel-all', 'Perkembangan zaman mempengaruhi berbagai sisi kehidupan, termasuk industri fashion, yang memiliki perubahan sangat pesat dari segi warna, model serta bahan yang semakin beragam.\r\n\r\nPara produsen terus membuat model baru untuk memenuhi minat dan permintaan pelanggan. Di antara banyaknya tren fashion yang bermunculan, trend fashion muslim juga cukup berkembang pesat dikarenakan banyaknya populasi muslim, khususnya di Indonesia.', 'blog_693dbeee813847.85459045.jpg', '2025-12-13 20:30:54', '2025-12-14 02:25:33', '2025-12-14 02:30:54'),
(3, 'Prinsip Fashion Dalam Islam', 'https://jurnaluniv45sby.ac.id/index.php/Inisiatif/article/download/510/487', 'Fashion sudah menjelma menjadi identitas bagi setiap muslim didunia tanpa\r\ndisadari menjadi brand positif masyarakat Islam.\r\nTrend Fashion memiliki prinsip bahwasanya keinginan atau keseleraan konsumen\r\nakan selalu berubah dan berinovasi. Hal itu dipengaruhi karena sosial dan budaya\r\ndilingkup masyarakat dan arus zaman seperti hal nya sekarang wanita yang\r\nberagama Islam sudah banyak yang menggunakan hijab.\r\n\r\nDidalam Islam tentu sudah di atur di Al-Qur’an dan sunnah tentang menggunakan\r\nhijab syar’i untuk kaum wanita muslimah. Fashion didalam konsep syar’i\r\nmempunyai etika dan nilai yang tinggi dalam berbusana yang tidak hanya untuk\r\nmenutup aurat bagian tubuh saja, namun memupukkan nilai-nilai Islam dalam\r\nfashion muslimah.\r\n\r\nBerbagai jenis pakaian yang digunakan oleh muslim dan muslimah menurut\r\nperspektif Islam yakni haruslah yang sesuai dengan ketentuan syariat Islam,\r\nmaksudnya adalah menutupi bagian-bagian tubuh yang tidak pantas diperlihatkan\r\nkepada khalayak ramai dan keterkaitan ketaqwaan seseorang kepada Tuhan nya\r\nakan diperlihatkan dari mode fashion yang dikenakan oleh orang tersebut.\r\nBerbusana bukan hanya berfungsi sebagai perlengkapan tubuh manusia tetapi juga\r\nbisa menambah tingkat kepercayaan diri bagi penggunanya.', 'blog_693dc2daa6ae25.52722339.jpg', '2025-12-13 20:47:38', '2025-12-14 02:36:43', '2025-12-14 02:47:38'),
(4, 'Tren Fashion Muslim: Dari Tradisional ke Modern', 'https://greisyofficial.com/blogs/lifestyle-blog/tren-fashion-muslim-2025-apa-yang-akan-booming?srsltid=AfmBOoo6D__j1ChJ0Qf1dmX8mJ5C9qloXpxfG0Mb3acaiyKdVDFD9en7', 'Sahabat fathclo, tren fashion muslim dari tahun ke tahun terus berevolusi. Kalau dulu busana muslim identik dengan warna gelap, potongan monoton, dan kurang fleksibel, kini semuanya berubah. Fashion muslim 2025 menghadirkan sentuhan modern yang tetap memegang teguh nilai-nilai kesyar’ian.\r\n\r\nDengan hadirnya influencer muslimah, desainer kreatif, hingga kampanye fashion global, kini hijab dan busana muslim menjadi bagian dari industri mode dunia. Dan kabar baiknya, tren fashion muslim kini tak hanya soal penampilan luar, tetapi juga mencerminkan gaya hidup yang berkelas dan berkelanjutan.', 'blog_693dc0d97ab378.51748852.jpg', '2025-12-13 20:39:05', '2025-12-14 02:39:05', '2025-12-14 02:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `qty`, `created_at`) VALUES
(1, 1, 1, 2, '2025-11-28 08:50:06'),
(2, 1, 3, 1, '2025-11-28 08:50:06'),
(3, 2, 2, 3, '2025-11-28 08:50:06'),
(4, 3, 4, 1, '2025-11-28 08:50:06'),
(41, 6, 3, 1, '2025-12-08 22:22:37'),
(42, 6, 6, 1, '2025-12-08 22:22:42'),
(58, 8, 2, 1, '2025-12-13 20:48:43'),
(59, 8, 3, 1, '2025-12-13 20:48:44'),
(60, 8, 4, 1, '2025-12-13 20:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('baru','dibaca') DEFAULT 'baru',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `status`, `created_at`) VALUES
(1, 'hanafi', 'ibrhan487@gmail.com', 'jangan', 'dibaca', '2025-11-27 18:10:32'),
(2, 'labib asshidqi ', 'labib321@gmail.com', 'kontol', 'dibaca', '2025-11-27 19:46:34'),
(3, 'benedectus', 'bene@gmail.com', 'bagus dan relavan ', 'dibaca', '2025-11-28 04:59:20'),
(4, 'Asep septian', 'asep1@gmail.com', 'Produk nya premium dan berkualitas modern', 'dibaca', '2025-12-09 05:50:03'),
(5, 'labib', 'labib@gmail.com', 'bagus dan wort it', 'dibaca', '2025-12-12 10:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT 'manual',
  `created_at` datetime DEFAULT current_timestamp(),
  `order_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `created_at`, `order_code`) VALUES
(1, NULL, 672000, 'pending', 'cod', '2025-12-02 20:27:04', NULL),
(2, NULL, 403000, 'pending', 'transfer', '2025-12-02 20:35:23', NULL),
(3, NULL, 1695000, 'pending', 'cod', '2025-12-02 20:59:18', NULL),
(4, NULL, 1953000, 'paid', 'cod', '2025-12-03 13:13:56', NULL),
(5, NULL, 144000, 'paid', 'cod', '2025-12-03 19:42:41', NULL),
(6, 6, 531000, 'pending', 'cod', '2025-12-09 04:51:40', NULL),
(7, 7, 264000, 'paid', 'cod', '2025-12-09 12:48:21', NULL),
(8, 7, 264000, 'pending', 'transfer', '2025-12-10 00:44:01', NULL),
(9, 9, 144000, 'paid', 'cod', '2025-12-12 17:39:36', NULL),
(10, 8, 1168000, 'paid', 'cod', '2025-12-14 03:42:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 1, 1, 249000.00),
(2, 1, 7, 1, 279000.00),
(3, 1, 2, 1, 129000.00),
(4, 2, 3, 1, 329000.00),
(5, 2, 4, 1, 59000.00),
(6, 3, 2, 1, 129000.00),
(7, 3, 1, 1, 249000.00),
(8, 3, 3, 1, 329000.00),
(9, 3, 4, 1, 59000.00),
(10, 3, 5, 1, 199000.00),
(11, 3, 6, 1, 159000.00),
(12, 3, 7, 1, 279000.00),
(13, 3, 8, 1, 99000.00),
(14, 3, 9, 1, 139000.00),
(15, 3, NULL, 1, 39000.00),
(16, 4, 2, 3, 129000.00),
(17, 4, 1, 1, 249000.00),
(18, 4, 3, 1, 329000.00),
(19, 4, 4, 1, 59000.00),
(20, 4, 8, 1, 99000.00),
(21, 4, 7, 1, 279000.00),
(22, 4, 6, 1, 159000.00),
(23, 4, 5, 1, 199000.00),
(24, 4, 9, 1, 139000.00),
(25, 4, NULL, 1, 39000.00),
(26, 5, 2, 1, 129000.00),
(27, 6, 2, 4, 129000.00),
(28, 7, 1, 1, 249000.00),
(29, 8, 1, 1, 249000.00),
(30, 9, 2, 1, 129000.00),
(31, 10, 1, 1, 249000.00),
(32, 10, 2, 4, 129000.00),
(33, 10, 4, 1, 59000.00),
(34, 10, 3, 1, 329000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `category`, `published`, `description`, `price`, `stock`, `image`, `created_at`) VALUES
(1, 'FC-ABAYA-001', 'Abaya Premium Hitam', '', 1, 'Abaya premium berbahan woolpeach halus, nyaman dipakai harian maupun acara formal.', 249000.00, 25, 'abaya_hitam.jpg', '2025-11-22 03:34:27'),
(2, 'FC-KG-002', 'Khimar Ceruti Daily', '', 1, 'Khimar berbahan ceruti premium, jatuh dan elegan. Cocok untuk aktivitas harian.', 129000.00, 40, 'khimar_ceruti.jpg', '2025-11-22 03:34:27'),
(3, 'FC-GML-003', 'Gamis Linen Embroidery', '', 1, 'Gamis berbahan linen bordir mewah dengan detail elegan dan nyaman dipakai.', 329000.00, 15, 'gamis_linen.jpg', '2025-11-22 03:34:27'),
(4, 'FC-PSTL-004', 'Pasmina Plisket Pastel', '', 1, 'Pasmina plisket warna pastel dengan bahan premium anti kusut.', 59000.00, 80, 'pasmina_plisket.jpg', '2025-11-22 03:34:27'),
(5, 'FC-MKN-005', 'Mukena Traveling Ultralight', '', 1, 'Mukena traveling super ringan, bahan premium adem dan mudah dilipat.', 199000.00, 30, 'mukena_travel.jpg', '2025-11-22 03:34:27'),
(6, 'FC-KRDB-006', 'Kardigan Rajut Basic', '', 1, 'Kardigan rajut tebal lembut cocok untuk outfit harian.', 159000.00, 22, 'kardigan_rajut.jpg', '2025-11-22 03:34:27'),
(7, 'FC-SR-007', 'Set Rok & Blouse Muslimah', '', 1, 'Set rok dan blouse stylish namun tetap syar\'i.', 279000.00, 18, 'set_rokmuslimah.jpg', '2025-11-22 03:34:27'),
(8, 'FC-HB-008', 'Handbag Mini Elegant', '', 1, 'Tas wanita mini elegan cocok untuk kegiatan formal maupun casual.', 99000.00, 50, 'handbag_mini.jpg', '2025-11-22 03:34:27'),
(9, 'FC-PYT-009', 'Piyama Muslimah Soft Cotton', '', 1, 'Set piyama muslimah bahan cotton premium super lembut.', 139000.00, 35, 'piyama_muslimah.jpg', '2025-11-22 03:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `tanggal_transaksi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `profile_photo`) VALUES
(1, 'ibrahim hanafi', 'ibrhan487@gmail.com', '$2y$10$FdB1IPrDULmZ.uA0BTi8E.zJ92gUBPLWGRN9hWibCIVal7JGGKM1y', '2025-11-21 23:59:09', NULL),
(2, 'labib ashshiddiqi', 'labibashshiddiqi@gmal.com', '$2y$10$F.2iLQxzHmyVyo.hhT9fy.rrMTkT7k0F1Xi.PGz4Wc3c/oCVgJAPK', '2025-11-22 00:11:14', NULL),
(3, 'labib ashshiddiqi', 'labib.ashshiddiqi@gmal.com', '$2y$10$l3rKfF2VsYjEPF1mUeecUeqYRklezNJQpcT80PabX0mRJY0nM5I3q', '2025-11-22 00:13:15', NULL),
(5, 'hanafi', 'ibrhan@gmail.com', '$2y$10$Zl/MzJUfXKqOoyuMTdEB8.X65xkY9eiDPGFqkM3OxuwsX8LNLIh9S', '2025-11-22 12:54:21', NULL),
(6, 'ibrahim hanafi', 'hanafi@gmail.com', '$2y$10$lk0xQ9ppy89RamE1vrSmWux3ykXZYe.5T0rVLSg0lUcAVOIedkLwy', '2025-12-09 04:10:38', 'USER_1765228598.jpg'),
(7, 'Asep septian', 'asep1@gmail.com', '$2y$10$r.fIrkrhqiDoxcHKyl.TFuJU.eH050/J9knaI4bldt7lBqaCGvolq', '2025-12-09 12:46:11', 'USER_1765259777.jpg'),
(8, 'aloy', 'kingaloy34@gmail.com', '$2y$10$IN67i./s2/wNRPWULzX84eWD0oKsyurIfVWZcEXQleGVANgx94.UW', '2025-12-12 17:10:40', NULL),
(9, 'bejo', 'bejo45@gmail.com', '$2y$10$I.UnZFbQrp4vJTI4jzAfz.b5PIThUBMvFUMZr/TXA6o9ILUVzYNFq', '2025-12-12 17:37:11', 'USER_1765536203.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(10, 7, 2, '2025-12-09 18:54:33'),
(22, 8, 1, '2025-12-13 20:48:47'),
(23, 8, 2, '2025-12-13 20:48:48'),
(24, 8, 3, '2025-12-13 20:48:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
