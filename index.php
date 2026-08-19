<?php
$page_title = "PHP & Laravel Developer | Awais Qarni";
$meta_desc = "I build secure, scalable and high-performance web applications using PHP, Laravel, MySQL and WordPress. Full-Stack PHP & Laravel Developer.";
$active_page = 'home';
require_once 'includes/header.php';

// Fetch 3 featured projects
$featured_projects = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC LIMIT 3");
        $featured_projects = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Fallback
    }
}
?>

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden py-20">
    <!-- Background glows -->
    <div class="absolute top-[20%] right-[-10%] w-[300px] h-[300px] sm:w-[500px] sm:h-[500px] rounded-full bg-accent/10 blur-[80px] sm:blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[10%] left-[-10%] w-[250px] h-[250px] sm:w-[400px] sm:h-[400px] rounded-full bg-orange-600/5 blur-[80px] sm:blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="row align-items-center g-5">
            <!-- Left content -->
            <div class="col-lg-7 order-2 order-lg-1 text-center text-lg-start">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-accent/20 bg-accent/5 text-accent text-xs sm:text-sm font-semibold tracking-wider uppercase mb-6 fade-in-scroll is-visible">
                    <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                    Available for Freelance & Remote Work
                </div>
                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-3 leading-tight font-outfit">
                    Hi, I am <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-neutral-100 to-accent">Awais Qarni</span>
                </h1>
                
                <h2 class="text-2xl sm:text-3xl text-accent font-bold mb-5 font-outfit">
                    PHP & Laravel Developer
                </h2>
                
                <p class="text-neutral-300 text-sm sm:text-base leading-relaxed mb-8 max-w-xl">
                    I build secure, scalable and high-performance web applications using PHP, Laravel, MySQL and WordPress.
                </p>
                
                <div class="flex flex-wrap items-center justify-center justify-content-lg-start gap-4">
                    <a href="portfolio.php" class="px-6 py-3.5 rounded-xl text-sm font-semibold text-white btn-glow no-underline">
                        View My Work <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                    <a href="contact.php" class="px-6 py-3.5 rounded-xl text-sm font-semibold btn-outline-custom no-underline">
                        Hire Me
                    </a>
                </div>
            </div>
            
            <!-- Right image / Visual representation -->
            <div class="col-lg-5 order-1 order-lg-2 flex justify-center">
                <div class="relative w-[280px] h-[280px] sm:w-[380px] sm:h-[380px] rounded-3xl overflow-hidden glass-card p-3 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/10 to-transparent"></div>
                    <?php if (file_exists('assets/images/image.jpeg')): ?>
                        <img src="assets/images/image.jpeg" alt="Awais Qarni Profile" class="w-full h-full object-cover rounded-2xl filter contrast-105 hover:scale-105 transition-all duration-500">
                    <?php elseif (file_exists('assets/images/image.jpg')): ?>
                        <img src="assets/images/image.jpg" alt="Awais Qarni Profile" class="w-full h-full object-cover rounded-2xl filter contrast-105 hover:scale-105 transition-all duration-500">
                    <?php elseif (file_exists('assets/images/Awais no.jpg')): ?>
                        <img src="assets/images/Awais no.jpg" alt="Awais Qarni Profile" class="w-full h-full object-cover rounded-2xl filter contrast-105 hover:scale-105 transition-all duration-500">
                    <?php else: ?>
                        <div class="w-full h-full bg-neutral-900 rounded-2xl flex items-center justify-center">
                            <i class="fa-solid fa-code text-7xl text-neutral-800"></i>
                        </div>
                    <?php endif; ?>
                    <!-- Glass badge -->
                    <div class="absolute bottom-6 left-6 right-6 p-3 rounded-xl bg-black/60 backdrop-blur-md border border-neutral-800/80 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center text-accent">
                            <i class="fa-solid fa-code text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 m-0">Specialization</p>
                            <p class="text-sm font-bold text-white m-0">PHP & Laravel Specialist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technologies Section -->
<section id="technologies" class="py-20 bg-[#08080C]/50 relative border-t border-b border-neutral-900/60">
    <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Core Tech Stack</div>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Technologies</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">Specialized in robust backend engineering, frameworks, database architecture, and CMS solutions.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- PHP Card -->
            <div class="glass-card p-6 flex flex-col justify-between fade-in-scroll border-t-2 border-t-indigo-500/60">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-5 text-indigo-400">
                        <i class="fa-brands fa-php text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white font-outfit mb-2">PHP</h3>
                    <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                        Core PHP, OOP, MVC, secure backend development and database-driven applications.
                    </p>
                </div>
            </div>

            <!-- Laravel Card -->
            <div class="glass-card p-6 flex flex-col justify-between fade-in-scroll border-t-2 border-t-red-500/60">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center mb-5 text-red-500">
                        <i class="fa-brands fa-laravel text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white font-outfit mb-2">Laravel</h3>
                    <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                        Laravel MVC, Eloquent ORM, migrations, authentication, REST APIs, queues, middleware and custom applications.
                    </p>
                </div>
            </div>

            <!-- MySQL / SQL Card -->
            <div class="glass-card p-6 flex flex-col justify-between fade-in-scroll border-t-2 border-t-emerald-500/60">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-5 text-emerald-400">
                        <i class="fa-solid fa-database text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white font-outfit mb-2">MySQL / SQL</h3>
                    <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                        Database design, relationships, joins, queries, indexing and optimization.
                    </p>
                </div>
            </div>

            <!-- WordPress Card -->
            <div class="glass-card p-6 flex flex-col justify-between fade-in-scroll border-t-2 border-t-blue-500/60">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-5 text-blue-400">
                        <i class="fa-brands fa-wordpress text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white font-outfit mb-2">WordPress</h3>
                    <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                        WordPress development, theme customization, plugin customization, WooCommerce and WordPress customization.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 relative border-b border-neutral-900/60">
    <div class="absolute top-[30%] left-[-5%] w-[300px] h-[300px] rounded-full bg-accent/5 blur-[100px] pointer-events-none"></div>
    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="text-center mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">What I Offer</div>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Professional Services</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">Targeted backend and full-stack development services tailored for scalability, speed, and reliability.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4 max-w-5xl mx-auto">
            <!-- PHP Development -->
            <div class="col fade-in-scroll">
                <div class="glass-card p-8 h-full flex flex-col justify-between border-l-4 border-l-accent">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-brands fa-php text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-white mb-2">PHP Development</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Custom PHP websites, web applications, backend systems and database-driven solutions.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Laravel Development -->
            <div class="col fade-in-scroll">
                <div class="glass-card p-8 h-full flex flex-col justify-between border-l-4 border-l-accent">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-brands fa-laravel text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-white mb-2">Laravel Development</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Laravel web applications, REST APIs, admin dashboards, authentication systems, CRM, ERP and custom business applications.
                        </p>
                    </div>
                </div>
            </div>

            <!-- MySQL / SQL -->
            <div class="col fade-in-scroll">
                <div class="glass-card p-8 h-full flex flex-col justify-between border-l-4 border-l-accent">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-database text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-white mb-2">MySQL / SQL</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Database design, SQL queries, relationships, optimization, data management and performance optimization.
                        </p>
                    </div>
                </div>
            </div>

            <!-- WordPress Development -->
            <div class="col fade-in-scroll">
                <div class="glass-card p-8 h-full flex flex-col justify-between border-l-4 border-l-accent">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-brands fa-wordpress text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-white mb-2">WordPress Development</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Custom WordPress websites, theme customization, plugin customization, WooCommerce and custom WordPress functionality.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="py-20 relative">
    <div class="container mx-auto px-4 md:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 fade-in-scroll">
            <div>
                <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Portfolio Showcase</div>
                <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Featured Projects</h2>
                <p class="text-neutral-400 text-sm sm:text-base">Production web applications, database architectures, and custom solutions.</p>
            </div>
            <a href="portfolio.php" class="text-sm font-semibold text-accent hover:text-orange-400 transition mt-4 sm:mt-0 no-underline">
                Explore All Projects <i class="fa-solid fa-arrow-right-long ml-2 text-xs"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php if (empty($featured_projects)): ?>
                <div class="col-12 text-center text-neutral-500 py-10">
                    Featured web applications and systems will be displayed here soon.
                </div>
            <?php else: ?>
                <?php foreach ($featured_projects as $proj): ?>
                    <div class="col-lg-4 col-md-6 fade-in-scroll">
                        <div class="glass-card h-full flex flex-col p-4">
                            <div class="project-card-image mb-4 relative aspect-[16/10] bg-neutral-900 rounded-xl overflow-hidden">
                                <?php 
                                $img_path = 'uploads/projects/' . $proj['image'];
                                if (!empty($proj['image']) && file_exists($img_path)): 
                                ?>
                                    <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-neutral-800">
                                        <i class="fa-regular fa-image text-5xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <span class="text-[10px] font-bold uppercase tracking-wider text-accent mb-2 block"><?php echo htmlspecialchars($proj['category']); ?></span>
                            
                            <h3 class="text-lg font-bold font-outfit text-white mb-2"><?php echo htmlspecialchars($proj['title']); ?></h3>
                            
                            <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-4 flex-grow">
                                <?php echo htmlspecialchars(substr($proj['description'], 0, 100)) . (strlen($proj['description']) > 100 ? '...' : ''); ?>
                            </p>
                            
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                <?php 
                                $tags = explode(',', $proj['tech_stack']);
                                foreach ($tags as $tag): 
                                ?>
                                    <span class="tech-badge"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                <?php endforeach; ?>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-neutral-900/80 mt-auto">
                                <?php if (!empty($proj['live_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($proj['live_url']); ?>" target="_blank" class="text-xs text-white hover:text-accent font-semibold flex items-center gap-1.5 no-underline transition">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Live Preview
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($proj['github_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($proj['github_url']); ?>" target="_blank" class="text-xs text-neutral-400 hover:text-white font-semibold flex items-center gap-1.5 no-underline ml-auto transition">
                                        <i class="fa-brands fa-github text-sm"></i> Code Repository
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-[#08080C]/50 border-t border-neutral-900/60 relative">
    <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Testimonials</div>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Client Feedback</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">Hear what clients say about building reliable PHP, Laravel, and WordPress solutions together.</p>
        </div>

        <div class="row g-4">
            <?php
            $testimonials = [
                [
                    'name' => 'Jenni Hamilton',
                    'company' => 'MKA (Laravel Web App Bug Fix)',
                    'text' => 'Hired Awais to resolve critical bugs on our Laravel web application. He optimized the performance, resolved error exceptions, and ensured everything runs flawlessly. Highly recommended!',
                    'initial' => 'J'
                ],
                [
                    'name' => 'Garudeya',
                    'company' => 'Custom PHP Script Client',
                    'text' => 'Outstanding work on our custom backend script. The code is clean, securely validated, and executes database queries with extreme speed. Will work with him again.',
                    'initial' => 'G'
                ],
                [
                    'name' => 'Shahid Mansheer',
                    'company' => 'WordPress & WooCommerce Client',
                    'text' => 'Awais built a highly responsive and custom WooCommerce website for our business. Checkout processes are secure, page loading is lightning fast, and client conversions are up!',
                    'initial' => 'S'
                ],
                [
                    'name' => 'Hamza',
                    'company' => 'Laravel REST API & Dashboard',
                    'text' => 'Excellent work setting up our Laravel backend API and administration dashboard. Everything from user authentication to complex SQL queries is built with high precision.',
                    'initial' => 'H'
                ],
                [
                    'name' => 'Biller Ketlik',
                    'company' => 'MySQL Database Optimization',
                    'text' => 'Superb database architecture and query optimization. He refactored our MySQL schema, added proper indexing, and reduced query latency significantly.',
                    'initial' => 'B'
                ],
                [
                    'name' => 'Hamna Embroidery',
                    'company' => 'Embroidery Factory ERP Software',
                    'text' => 'Awais developed tailored management software for our embroidery textile factory. Now we track production details, inventories, and designs easily. Great backend design!',
                    'initial' => 'H'
                ],
                [
                    'name' => 'Jahanzaib',
                    'company' => 'PHP Inventory System Client',
                    'text' => 'We needed an inventory management system to handle stock alerts, suppliers, and transactions. The solution Awais built is incredibly clean, secure, and intuitive.',
                    'initial' => 'J'
                ],
                [
                    'name' => 'John Bura',
                    'company' => 'Laravel LMS Portal Client',
                    'text' => 'Awesome job building our Learning Management System (LMS). Structured courses, video streaming, user roles, and payment gates work perfectly. High quality code.',
                    'initial' => 'J'
                ]
            ];
            foreach ($testimonials as $t):
            ?>
            <div class="col-lg-4 col-md-6 fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <p class="text-xs sm:text-sm text-neutral-300 italic leading-relaxed mb-6">
                        "<?php echo htmlspecialchars($t['text']); ?>"
                    </p>
                    <div class="flex items-center gap-3 border-t border-neutral-900/60 pt-4">
                        <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center font-bold text-accent font-outfit text-sm">
                            <?php echo $t['initial']; ?>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white font-outfit m-0"><?php echo htmlspecialchars($t['name']); ?></h4>
                            <p class="text-[10px] text-neutral-500 m-0"><?php echo htmlspecialchars($t['company']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-tr from-accent/5 to-transparent pointer-events-none"></div>
    <div class="container mx-auto px-4 md:px-8 text-center relative z-10 fade-in-scroll">
        <h2 class="text-3xl sm:text-5xl font-bold font-outfit mb-4">Let's build something scalable & secure together</h2>
        <p class="text-neutral-400 max-w-xl mx-auto mb-8 text-sm sm:text-base">Need a custom PHP web application, Laravel API, MySQL database optimization, or WordPress website? Let's connect.</p>
        <a href="contact.php" class="px-8 py-4 rounded-xl text-base font-semibold text-white btn-glow no-underline inline-flex items-center gap-3">
            Hire Me <i class="fa-solid fa-paper-plane text-sm"></i>
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

