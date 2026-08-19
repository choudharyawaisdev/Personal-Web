<?php
require_once __DIR__ . '/db.php';

// Fetch global site settings
$site_settings = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
        $site_settings = $stmt->fetch() ?: [];
    } catch (PDOException $e) {
        // Silently fail if settings table is not ready
    }
}

// Fallbacks
$site_name = !empty($site_settings['site_name']) ? $site_settings['site_name'] : 'Awais Qarni';
$site_email = !empty($site_settings['email']) ? $site_settings['email'] : 'chawaisdev92@gmail.com';
$site_logo = !empty($site_settings['logo']) ? $site_settings['logo'] : '';

// SEO parameters
$page_title = isset($page_title) ? $page_title . " | " . $site_name : $site_name . " | Full Stack Developer & AI Automation";
$meta_desc = isset($meta_desc) ? $meta_desc : "Professional portfolio of Awais Qarni - Full Stack Developer | PHP | Laravel | React | AI Automation.";
$active_page = isset($active_page) ? $active_page : 'home';
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for utility spacing and custom layout adjustments) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
    
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-darkbg text-white transition-colors duration-300">

    <!-- Page Loader Screen -->
    <div id="loader" class="fixed inset-0 z-50 flex items-center justify-center bg-darkbg">
        <div class="relative w-20 h-20">
            <div class="absolute inset-0 rounded-full border-4 border-neutral-800"></div>
            <div class="absolute inset-0 rounded-full border-4 border-t-accent border-r-transparent border-b-transparent border-l-transparent animate-spin"></div>
            <div class="absolute inset-4 rounded-full border-4 border-neutral-700"></div>
            <div class="absolute inset-4 rounded-full border-4 border-b-accent border-t-transparent border-r-transparent border-l-transparent animate-spin-reverse animate-duration-1000"></div>
        </div>
    </div>
    <script>
        // Emergency loader backup: Auto-hide loader after 1.5 seconds if scripts fail to load
        setTimeout(function() {
            var loaderEl = document.getElementById('loader');
            if (loaderEl && loaderEl.style.display !== 'none') {
                loaderEl.style.opacity = '0';
                loaderEl.style.transition = 'opacity 0.4s ease';
                setTimeout(function() { loaderEl.style.display = 'none'; }, 400);
            }
        }, 1500);
    </script>

    <!-- Scroll Progress Bar -->
    <div id="scroll-progress" class="fixed top-0 left-0 h-[4px] bg-gradient-to-r from-accent via-orange-400 to-amber-500 z-50 transition-all duration-75" style="width: 0%;"></div>

    <!-- Navigation Header -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-40 py-4 transition-all duration-300">
        <div class="container mx-auto px-4 md:px-8 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 no-underline text-white">
                <?php if ($site_logo && file_exists('uploads/' . $site_logo)): ?>
                    <img src="uploads/<?php echo htmlspecialchars($site_logo); ?>" alt="Logo" class="h-10 w-auto rounded-lg">
                <?php else: ?>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-orange-600 flex items-center justify-center font-bold text-lg text-white shadow-lg shadow-orange-600/30">AQ</span>
                        <span class="font-extrabold text-xl tracking-tight hidden sm:inline-block font-outfit">Awais<span class="text-accent">.</span></span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8 font-inter text-sm font-medium">
                <a href="index.php" class="nav-custom-link <?php echo $active_page === 'home' ? 'active text-accent' : 'text-neutral-400 hover:text-white'; ?> transition duration-200 no-underline">Home</a>
                <a href="about.php" class="nav-custom-link <?php echo $active_page === 'about' ? 'active text-accent' : 'text-neutral-400 hover:text-white'; ?> transition duration-200 no-underline">About</a>
                <a href="portfolio.php" class="nav-custom-link <?php echo $active_page === 'portfolio' ? 'active text-accent' : 'text-neutral-400 hover:text-white'; ?> transition duration-200 no-underline">Portfolio</a>
                <a href="blog.php" class="nav-custom-link <?php echo $active_page === 'blog' ? 'active text-accent' : 'text-neutral-400 hover:text-white'; ?> transition duration-200 no-underline">Blog</a>
                <a href="contact.php" class="nav-custom-link <?php echo $active_page === 'contact' ? 'active text-accent' : 'text-neutral-400 hover:text-white'; ?> transition duration-200 no-underline">Contact</a>
            </div>

            <!-- Header Action Elements -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <button id="theme-toggle" class="w-10 h-10 rounded-full flex items-center justify-center border border-neutral-800 bg-neutral-900/60 hover:bg-neutral-800 text-neutral-400 hover:text-white transition duration-200">
                    <i class="fa-solid fa-moon text-lg dark-icon"></i>
                    <i class="fa-solid fa-sun text-lg light-icon hidden"></i>
                </button>
                
                <!-- CTA Contact button -->
                <a href="contact.php" class="hidden lg:inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-accent to-orange-600 hover:shadow-[0_0_15px_rgba(255,106,0,0.4)] transition duration-300 no-underline">
                    Let's Talk
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden w-10 h-10 rounded-lg flex items-center justify-center border border-neutral-800 hover:bg-neutral-900/60 text-neutral-400 hover:text-white transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden fixed inset-x-0 top-[72px] bg-darkbg border-b border-neutral-900 px-6 py-8 flex flex-col gap-6 font-inter text-base font-semibold shadow-2xl transition duration-300">
            <a href="index.php" class="no-underline <?php echo $active_page === 'home' ? 'text-accent' : 'text-neutral-400'; ?> hover:text-white py-2">Home</a>
            <a href="about.php" class="no-underline <?php echo $active_page === 'about' ? 'text-accent' : 'text-neutral-400'; ?> hover:text-white py-2">About</a>
            <a href="portfolio.php" class="no-underline <?php echo $active_page === 'portfolio' ? 'text-accent' : 'text-neutral-400'; ?> hover:text-white py-2">Portfolio</a>
            <a href="blog.php" class="no-underline <?php echo $active_page === 'blog' ? 'text-accent' : 'text-neutral-400'; ?> hover:text-white py-2">Blog</a>
            <a href="contact.php" class="no-underline <?php echo $active_page === 'contact' ? 'text-accent' : 'text-neutral-400'; ?> hover:text-white py-2">Contact</a>
            <a href="contact.php" class="text-center bg-gradient-to-r from-accent to-orange-600 text-white py-3 rounded-xl hover:shadow-[0_0_15px_rgba(255,106,0,0.4)] transition duration-200 mt-4 no-underline">
                Let's Talk
            </a>
        </div>
    </nav>

    <!-- Main Content Area Starts -->
    <main class="pt-24 min-h-[calc(100vh-120px)]">
