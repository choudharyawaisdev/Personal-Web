<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$status = "";

if (isset($_POST['install'])) {
    $host = $_POST['host'] ?? 'localhost';
    $user = $_POST['user'] ?? 'devtasoft_portfolio';
    $pass = $_POST['pass'] ?? 'devtasoft_portfolio';
    $dbname = $_POST['dbname'] ?? 'devtasoft_portfolio';

    try {
        // Connect to MySQL server
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Create Database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname`");

        // Create Users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) UNIQUE NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Create Projects table
        $pdo->exec("CREATE TABLE IF NOT EXISTS `projects` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NOT NULL,
            `image` VARCHAR(255) NOT NULL,
            `category` VARCHAR(100) NOT NULL,
            `tech_stack` VARCHAR(255) NOT NULL,
            `live_url` VARCHAR(255) DEFAULT NULL,
            `github_url` VARCHAR(255) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Create Blogs table
        $pdo->exec("CREATE TABLE IF NOT EXISTS `blogs` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) UNIQUE NOT NULL,
            `content` TEXT NOT NULL,
            `image` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Create Messages table
        $pdo->exec("CREATE TABLE IF NOT EXISTS `messages` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `message` TEXT NOT NULL,
            `status` ENUM('unread', 'read') DEFAULT 'unread',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Create Settings table
        $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `site_name` VARCHAR(255) DEFAULT 'Awais Qarni',
            `logo` VARCHAR(255) DEFAULT NULL,
            `email` VARCHAR(255) DEFAULT 'chawaisdev92@gmail.com',
            `facebook` VARCHAR(255) DEFAULT NULL,
            `linkedin` VARCHAR(255) DEFAULT NULL,
            `github` VARCHAR(255) DEFAULT NULL,
            `terms_content` TEXT DEFAULT NULL
        ) ENGINE=InnoDB;");

        // Check if admin user already exists, if not, insert
        $admin_email = 'chawaisdev92@gmail.com';
        $admin_pass = password_hash('awaisdev92#', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->execute([$admin_email]);
        if (!$stmt->fetch()) {
            $insert_user = $pdo->prepare("INSERT INTO `users` (`email`, `password`) VALUES (?, ?)");
            $insert_user->execute([$admin_email, $admin_pass]);
        }

        // Check if settings exist, if not, insert initial settings
        $stmt_settings = $pdo->query("SELECT COUNT(*) FROM `settings`");
        if ($stmt_settings->fetchColumn() == 0) {
            $insert_settings = $pdo->prepare("INSERT INTO `settings` 
                (`site_name`, `email`, `facebook`, `linkedin`, `github`, `terms_content`) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $insert_settings->execute([
                'Awais Qarni | Portfolio',
                'chawaisdev92@gmail.com',
                'https://facebook.com/chawaisdev',
                'https://www.linkedin.com/in/choudhary-awais/',
                'https://github.com/chawaisdev',
                '<h2>Terms & Services</h2><p>Welcome to our portfolio. By accessing this website, you agree to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws.</p><p>We reserve the right to revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.</p>'
            ]);
        }

        // Insert initial projects if empty (to look awesome immediately)
        $stmt_proj = $pdo->query("SELECT COUNT(*) FROM `projects`");
        if ($stmt_proj->fetchColumn() == 0) {
            $insert_proj = $pdo->prepare("INSERT INTO `projects` 
                (`title`, `description`, `image`, `category`, `tech_stack`, `live_url`, `github_url`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $insert_proj->execute([
                'E-commerce Platform Architecture',
                'A custom-designed e-commerce web application with secure payments, detailed catalogs, and cart managers.',
                'Gemini_Generated_Image_868fj4868fj4868f.png',
                'Laravel',
                'PHP, Laravel, MySQL, Tailwind CSS',
                null,
                null
            ]);
            $insert_proj->execute([
                'WordPress Custom Theme & WooCommerce',
                'Custom WordPress WooCommerce solution with customized checkout, product catalogs, and custom plugin features.',
                'Gemini_Generated_Image_gzdn35gzdn35gzdn.png',
                'WordPress',
                'WordPress, WooCommerce, PHP, MySQL',
                null,
                null
            ]);
            $insert_proj->execute([
                'Custom REST API & Admin Portal',
                'A robust backend API and administrative dashboard built with Laravel, role-based auth, and optimized SQL.',
                'Gemini_Generated_Image_isb6p6isb6p6isb6.png',
                'Laravel',
                'PHP, Laravel, MySQL, REST APIs',
                null,
                null
            ]);
            $insert_proj->execute([
                'Custom Textile Manufacturing Software',
                'Bespoke ERP software built for textile factory scheduling, embroidery designs, and inventory tracking.',
                'Gemini_Generated_Image_msbmwnmsbmwnmsbm.png',
                'PHP',
                'Core PHP, MySQL, Bootstrap 5',
                null,
                null
            ]);
            $insert_proj->execute([
                'Relational Inventory Management System',
                'Tracks orders, supplier lists, warehouse stock, and logs real-time business financial statements.',
                'Gemini_Generated_Image_qtjabzqtjabzqtja.png',
                'MySQL',
                'Core PHP, MySQL, SQL Queries',
                null,
                null
            ]);
            $insert_proj->execute([
                'Learning Management System (LMS)',
                'Multi-role portal supporting video lectures, course subscriptions, student trackers, and payment gateways.',
                'Gemini_Generated_Image_t6hwy4t6hwy4t6hw.png',
                'Laravel',
                'PHP, Laravel, MySQL, MVC',
                null,
                null
            ]);
        }

        // Insert initial blogs if empty
        $stmt_blog = $pdo->query("SELECT COUNT(*) FROM `blogs`");
        if ($stmt_blog->fetchColumn() == 0) {
            $insert_blog = $pdo->prepare("INSERT INTO `blogs` 
                (`title`, `slug`, `content`, `image`) 
                VALUES (?, ?, ?, ?)");
            $insert_blog->execute([
                'Building Modern Portfolios with Core PHP in 2026',
                'building-modern-portfolios-core-php-2026',
                '<p>This article explores why building with Core PHP is still an incredibly fast, secure, and viable option for modern web development when using Object-Oriented principles and prepared statements.</p>',
                'placeholder_blog1.jpg'
            ]);
        }

        // Write configuration dynamically to includes/db.php if we want to update it
        // Since we predefined db.php, we don't strictly need to write it unless config changed.
        
        // Create upload folders
        $upload_dir = 'uploads/projects/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Copy generated images if they exist in uploads root folder to projects uploads folder
        $generated_images = [
            'Gemini_Generated_Image_868fj4868fj4868f.png',
            'Gemini_Generated_Image_gzdn35gzdn35gzdn.png',
            'Gemini_Generated_Image_isb6p6isb6p6isb6.png',
            'Gemini_Generated_Image_msbmwnmsbmwnmsbm.png',
            'Gemini_Generated_Image_qtjabzqtjabzqtja.png',
            'Gemini_Generated_Image_t6hwy4t6hwy4t6hw.png'
        ];
        foreach ($generated_images as $img) {
            $src = 'uploads/' . $img;
            $dest = $upload_dir . $img;
            if (file_exists($src) && !file_exists($dest)) {
                copy($src, $dest);
            }
        }

        // Create assets/images/ folder and copy profile picture
        $assets_img_dir = 'assets/images/';
        if (!file_exists($assets_img_dir)) {
            mkdir($assets_img_dir, 0755, true);
        }
        if (file_exists('Awais no.jpg') && !file_exists($assets_img_dir . 'Awais no.jpg')) {
            copy('Awais no.jpg', $assets_img_dir . 'Awais no.jpg');
        }

        $status = "success";
        $message = "Database configured and initialized successfully! Initial admin seeded.";
    } catch (PDOException $e) {
        $status = "danger";
        $message = "Installation failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Portfolio Installer</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/style.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0B0B0F',
                        darkcard: '#16161D',
                        accent: '#FF6A00',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B0B0F;
            color: #FFFFFF;
        }
        h1, h2, h3 {
            font-family: 'Outfit', sans-serif;
        }
        .glass-card {
            background: rgba(22, 22, 29, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 106, 0, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .accent-glow {
            box-shadow: 0 0 40px rgba(255, 106, 0, 0.25);
        }
        .btn-accent {
            background: linear-gradient(135deg, #FF6A00 0%, #E04D00 100%);
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.4);
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            box-shadow: 0 6px 20px rgba(255, 106, 0, 0.6), 0 0 10px rgba(255, 106, 0, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-neutral-900 via-darkbg to-darkbg">
    <div class="w-full max-w-lg glass-card rounded-2xl p-8 accent-glow relative overflow-hidden">
        <!-- Orange light top border decorative glow -->
        <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-transparent via-accent to-transparent"></div>
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-neutral-100 to-accent tracking-tight">Database Installation</h1>
            <p class="text-neutral-400 text-sm mt-2">Initialize your modern Portfolio CMS Database & Admin User</p>
        </div>

        <?php if ($message): ?>
            <div class="p-4 mb-6 rounded-lg text-sm <?php echo $status === 'success' ? 'bg-emerald-950/80 text-emerald-300 border border-emerald-500/30' : 'bg-rose-950/80 text-rose-300 border border-rose-500/30'; ?>">
                <p class="font-semibold"><?php echo $status === 'success' ? '✔ Success' : '✖ Error'; ?></p>
                <p class="mt-1"><?php echo $message; ?></p>
                <?php if ($status === 'success'): ?>
                    <div class="mt-4 flex gap-4">
                        <a href="index.php" class="text-xs bg-emerald-800 text-white px-3 py-1.5 rounded hover:bg-emerald-700 transition">Go to Home</a>
                        <a href="admin/login.php" class="text-xs bg-accent text-white px-3 py-1.5 rounded hover:opacity-90 transition">Admin Login</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Database Host</label>
                <input type="text" name="host" value="localhost" required 
                       class="w-full px-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Database Username</label>
                <input type="text" name="user" value="devtasoft_portfolio" required 
                       class="w-full px-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Database Password</label>
                <input type="password" name="pass" value="devtasoft_portfolio" required 
                       class="w-full px-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Database Name</label>
                <input type="text" name="dbname" value="devtasoft_portfolio" required 
                       class="w-full px-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>

            <div class="pt-4">
                <button type="submit" name="install" class="w-full py-3.5 btn-accent text-white font-semibold rounded-lg text-sm tracking-wide">
                    Install Database & Create Admin
                </button>
            </div>
        </form>

        <div class="mt-6 border-t border-neutral-800/80 pt-4 text-center">
            <p class="text-xs text-neutral-500">
                Created for Awais Qarni. Remember to delete or secure this file after installation.
            </p>
        </div>
    </div>
</body>
</html>
