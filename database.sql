-- Core PHP Portfolio Website Database Schema
-- Exported for phpMyAdmin / MySQL direct import
-- Database: `devtasoft_portfolio`

CREATE DATABASE IF NOT EXISTS `devtasoft_portfolio` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `devtasoft_portfolio`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Seeding default admin user (Password: awaisdev92#)
--
INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'chawaisdev92@gmail.com', '$2y$10$kP.OswWfPZtN/p6Y1zO0f.T7H6.a9.D2u2rW26n4/KzP187.gK9.b')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `tech_stack` VARCHAR(255) NOT NULL,
  `live_url` VARCHAR(255) DEFAULT NULL,
  `github_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Seeding initial projects
--
INSERT INTO `projects` (`id`, `title`, `description`, `image`, `category`, `tech_stack`, `live_url`, `github_url`) VALUES
(1, 'E-commerce Platform Architecture', 'A custom-designed e-commerce web application with secure payments, detailed catalogs, and cart managers.', 'Gemini_Generated_Image_868fj4868fj4868f.png', 'Laravel', 'PHP, Laravel, MySQL, Tailwind CSS', NULL, NULL),
(2, 'WordPress Custom Theme & WooCommerce', 'Custom WordPress WooCommerce solution with customized checkout, product catalogs, and custom plugin features.', 'Gemini_Generated_Image_gzdn35gzdn35gzdn.png', 'WordPress', 'WordPress, WooCommerce, PHP, MySQL', NULL, NULL),
(3, 'Custom REST API & Admin Portal', 'A robust backend API and administrative dashboard built with Laravel, role-based auth, and optimized SQL.', 'Gemini_Generated_Image_isb6p6isb6p6isb6.png', 'Laravel', 'PHP, Laravel, MySQL, REST APIs', NULL, NULL),
(4, 'Custom Textile Manufacturing Software', 'Bespoke ERP software built for textile factory scheduling, embroidery designs, and inventory tracking.', 'Gemini_Generated_Image_msbmwnmsbmwnmsbm.png', 'PHP', 'Core PHP, MySQL, Bootstrap 5', NULL, NULL),
(5, 'Relational Inventory Management System', 'Tracks orders, supplier lists, warehouse stock, and logs real-time business financial statements.', 'Gemini_Generated_Image_qtjabzqtjabzqtja.png', 'MySQL', 'Core PHP, MySQL, SQL Queries', NULL, NULL),
(6, 'Learning Management System (LMS)', 'Multi-role portal supporting video lectures, course subscriptions, student trackers, and payment gateways.', 'Gemini_Generated_Image_t6hwy4t6hwy4t6hw.png', 'Laravel', 'PHP, Laravel, MySQL, MVC', NULL, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `content` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Seeding initial blogs
--
INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `image`) VALUES
(1, 'Building Modern Portfolios with Core PHP in 2026', 'building-modern-portfolios-core-php-2026', '<p>This article explores why building with Core PHP is still an incredibly fast, secure, and viable option for modern web development when using Object-Oriented principles and prepared statements.</p>', 'placeholder_blog1.jpg')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read') DEFAULT 'unread',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `site_name` VARCHAR(255) DEFAULT 'Awais Qarni',
  `logo` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT 'chawaisdev92@gmail.com',
  `facebook` VARCHAR(255) DEFAULT NULL,
  `linkedin` VARCHAR(255) DEFAULT NULL,
  `github` VARCHAR(255) DEFAULT NULL,
  `terms_content` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Seeding initial settings
--
INSERT INTO `settings` (`id`, `site_name`, `email`, `facebook`, `linkedin`, `github`, `terms_content`) VALUES
(1, 'Awais Qarni | Portfolio', 'chawaisdev92@gmail.com', 'https://facebook.com/chawaisdev', 'https://www.linkedin.com/in/choudhary-awais/', 'https://github.com/chawaisdev', '<h2>Terms & Services</h2><p>Welcome to our portfolio. By accessing this website, you agree to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws.</p><p>We reserve the right to revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.</p>')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);
