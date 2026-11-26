-- Core PHP Portfolio Website Database Schema
-- Exported for phpMyAdmin / MySQL direct import


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
(1, 'Sara Store - E-Commerce Store', 'A full-featured WordPress & WooCommerce online store featuring customized product catalogs, instant checkout, payment gateways, and custom sales badges.', 'sarastore.pk.jpg', 'WordPress', 'WordPress, WooCommerce, PHP, MySQL', 'https://sarastore.pk/', NULL),
(2, 'Hafiz Talha - Personal Brand & Portfolio', 'Custom WordPress website designed with high performance, smooth animations, dynamic blog management, and optimized SEO structure.', 'hafiztalha.com.jpg', 'WordPress', 'WordPress, PHP, MySQL, Elementor Pro', 'https://hafiztalha.com/', NULL),
(3, 'Boxwala - Custom Packaging & Store', 'Modern WooCommerce platform engineered for custom packaging solutions, custom quotation forms, responsive catalog filtering, and bulk order management.', 'boxwala.pk.jpg', 'WordPress', 'WordPress, WooCommerce, PHP, MySQL', 'https://boxwala.pk/', NULL),
(4, 'Looking Glass Academy - Educational Portal', 'Comprehensive educational academy website with course enrollments, interactive curriculum showcases, event schedules, and contact lead capture.', 'lookingglassacademy.net.jpg', 'WordPress', 'WordPress, PHP, MySQL, LMS Integration', 'https://lookingglassacademy.net/', NULL),
(5, 'HerbalCare - Natural Products Store', 'Custom-designed herbal e-commerce website with product showcase, discount coupon system, order tracking, and multiple payment integrations.', 'herbal-ecommerce-store.png', 'WordPress', 'WordPress, WooCommerce, PHP, MySQL', NULL, NULL),
(6, 'CoursePro - Online Learning & Course Platform', 'High-performance online course & education management platform built with Laravel featuring student dashboards, course progress tracking, video streaming, and secure payments.', 'coursepro.today.jpg', 'Laravel', 'PHP, Laravel, MySQL, REST APIs', 'https://coursepro.today/', NULL),
(7, 'Multi-Vendor E-Commerce Platform', 'Enterprise multi-vendor e-commerce architecture allowing multiple sellers to register, manage inventory, process orders, and track payout analytics with an admin dashboard.', 'ecommerce-multi-vendor-platform.png', 'Laravel', 'PHP, Laravel, MySQL, Tailwind CSS', NULL, NULL),
(8, 'All-in-One LMS Education System', 'Complete learning management portal for modern education with quizzes, assignments, certificate generation, attendance monitoring, and role-based permissions.', 'learning-management-system-lms.png', 'Laravel', 'PHP, Laravel, MySQL, REST APIs', NULL, NULL),
(9, 'RestroHub - Restaurant POS & Order Management', 'Complete restaurant POS solution with dine-in/takeaway order routing, live kitchen display system (KDS), delivery tracking, and revenue analytics.', 'restaurant-management-pos-system.png', 'Laravel', 'PHP, Laravel, MySQL, WebSockets', NULL, NULL),
(10, 'Employee HRM & Payroll Management System', 'All-in-one HR system managing employee records, real-time biometric attendance, automated salary slips, leave requests, and departmental performance tracking.', 'employee-hrm-management-system.png', 'Laravel', 'PHP, Laravel, MySQL, MVC Architecture', NULL, NULL),
(11, 'Smart Inventory Management Software & ERP', 'Real-time inventory tracking, warehouse multi-location management, sales & purchase invoicing, low-stock alerts, and financial reporting.', 'inventory-management-software.png', 'PHP', 'Core PHP, MySQL, SQL Optimization, Bootstrap 5', NULL, NULL),
(12, 'FinEdge - Corporate FinTech & SaaS Website', 'Bespoke corporate FinTech web application featuring interactive ROI calculators, live financial analytics charts, responsive UI, and high-converting lead capture.', 'finedge-corporate-website.png', 'Custom Website', 'HTML5, Tailwind CSS, JavaScript, PHP, MySQL', NULL, NULL),
(13, 'LuxEstate - Real Estate Property Portal', 'Custom-built luxury real estate listing platform with advanced property filtering, interactive map integration, agent dashboards, and inquiry management.', 'luxestate-real-estate-portal.png', 'Custom Website', 'Custom PHP, MySQL, Tailwind CSS, AJAX', NULL, NULL),
(14, 'MedCare - Clinic & Hospital Management Software', 'Comprehensive healthcare management software covering patient appointments, electronic medical records (EMR), doctor schedules, lab reports, and automated billing.', 'medcare-hospital-software.png', 'Software', 'PHP, MySQL, Bootstrap 5, Chart.js', NULL, NULL),
(15, 'LeadFlow - Enterprise CRM & Sales Pipeline Software', 'Full-featured CRM software with drag-and-drop Kanban deal pipelines, automated follow-up reminders, team performance analytics, and client activity timelines.', 'leadflow-crm-software.png', 'Software', 'Laravel, Vue.js, MySQL, REST APIs', NULL, NULL),
(16, 'CloudVault - Secure Client Portal & Document Manager', 'Object-oriented Core PHP client portal for encrypted document sharing, role-based folder permissions, storage quota tracking, and detailed audit logs.', 'cloudvault-php-portal.png', 'PHP', 'Core PHP, OOP, PDO MySQL, Tailwind CSS', NULL, NULL),
(17, 'SchoolSync - School Fee & Attendance Management System', 'Complete academic administration system in Core PHP featuring daily attendance tracking, automated monthly fee vouchers, PDF receipts, and parent notifications.', 'schoolsync-php-system.png', 'PHP', 'Core PHP, MySQL, AJAX, FPDF', NULL, NULL),
(18, 'BookingPro - Hotel & Resort Reservation Engine', 'Scalable Laravel booking engine with real-time room availability calendars, seasonal pricing rules, Stripe payment integration, and occupancy revenue reports.', 'bookingpro-laravel-app.png', 'Laravel', 'PHP, Laravel, MySQL, Stripe API', NULL, NULL),
(19, 'LogiTrack - Fleet & Courier Tracking System', 'End-to-end Laravel logistics & courier platform with live shipment status tracking, driver dispatch assignment, route optimization, and delivery proof capture.', 'logitrack-laravel-system.png', 'Laravel', 'PHP, Laravel, MySQL, REST APIs', NULL, NULL)
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
(1, 'Awais Qarni | Portfolio', 'chawaisdev92@gmail.com', 'https://www.facebook.com/ch.awais.508218', 'https://www.linkedin.com/in/choudhary-awais/', 'https://github.com/choudharyawaisdev', '<h2>Terms & Services</h2><p>Welcome to our portfolio. By accessing this website, you agree to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws.</p><p>We reserve the right to revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.</p>')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);
