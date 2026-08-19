<?php
$page_title = "Awais Qarni - Full Stack Developer | PHP | Laravel | React | AI Automation";
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
                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-4 leading-tight font-outfit">
                    Hi, I am <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-neutral-100 to-accent">Awais Qarni</span>
                </h1>
                
                <h2 class="text-xl sm:text-2xl text-neutral-400 font-medium mb-6 font-inter">
                    Full Stack Developer | PHP | Laravel | React | AI Automation
                </h2>
                
                <p class="text-neutral-400 text-sm sm:text-base leading-relaxed mb-8 max-w-xl">
                    I design and engineer premium, high-performance web applications, automate enterprise workflows with AI integrations, and develop robust database systems.
                </p>
                
                <div class="flex flex-wrap items-center justify-center justify-content-lg-start gap-4">
                    <a href="portfolio.php" class="px-6 py-3.5 rounded-xl text-sm font-semibold text-white btn-glow no-underline">
                        View Portfolio <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                    <a href="contact.php" class="px-6 py-3.5 rounded-xl text-sm font-semibold btn-outline-custom no-underline">
                        Contact Me
                    </a>
                </div>
            </div>
            
            <!-- Right image / Visual representation -->
            <div class="col-lg-5 order-1 order-lg-2 flex justify-center">
                <div class="relative w-[280px] h-[280px] sm:w-[380px] sm:h-[380px] rounded-3xl overflow-hidden glass-card p-3 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/10 to-transparent"></div>
                    <?php if (file_exists('assets/images/Awais no.jpg')): ?>
                        <img src="assets/images/Awais no.jpg" alt="Awais Qarni Profile" class="w-full h-full object-cover rounded-2xl filter grayscale contrast-125 hover:grayscale-0 transition-all duration-500">
                    <?php elseif (file_exists('Awais no.jpg')): ?>
                        <img src="Awais no.jpg" alt="Awais Qarni Profile" class="w-full h-full object-cover rounded-2xl filter grayscale contrast-125 hover:grayscale-0 transition-all duration-500">
                    <?php else: ?>
                        <div class="w-full h-full bg-neutral-900 rounded-2xl flex items-center justify-center">
                            <i class="fa-solid fa-user-ninja text-7xl text-neutral-800"></i>
                        </div>
                    <?php endif; ?>
                    <!-- Glass badge -->
                    <div class="absolute bottom-6 left-6 right-6 p-3 rounded-xl bg-black/60 backdrop-blur-md border border-neutral-800/80 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center text-accent">
                            <i class="fa-solid fa-code text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 m-0">Experience</p>
                            <p class="text-sm font-bold text-white m-0">5+ Years Developing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Skills Preview Section -->
<section class="py-20 bg-[#08080C]/50 relative border-t border-b border-neutral-900/60">
    <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-16 fade-in-scroll">
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Technical Superpowers</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">A curated set of technologies I use to build robust and responsive applications.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php 
            $skills = [
                ['name' => 'PHP & Laravel', 'icon' => 'fa-brands fa-laravel', 'color' => 'text-red-500'],
                ['name' => 'SQL Databases', 'icon' => 'fa-solid fa-database', 'color' => 'text-emerald-400'],
                ['name' => 'React JS & JS', 'icon' => 'fa-brands fa-react', 'color' => 'text-sky-400'],
                ['name' => 'AI Automation', 'icon' => 'fa-solid fa-robot', 'color' => 'text-accent'],
                ['name' => 'WordPress CMS', 'icon' => 'fa-brands fa-wordpress', 'color' => 'text-blue-400'],
                ['name' => 'HTML & CSS', 'icon' => 'fa-brands fa-bootstrap', 'color' => 'text-purple-500'],
            ];
            foreach ($skills as $s):
            ?>
            <div class="glass-card p-6 flex flex-col items-center justify-center text-center fade-in-scroll">
                <div class="w-12 h-12 rounded-xl bg-neutral-900/80 border border-neutral-800 flex items-center justify-center mb-4 transition duration-300">
                    <i class="<?php echo $s['icon']; ?> text-2xl <?php echo $s['color']; ?>"></i>
                </div>
                <h3 class="text-sm sm:text-base font-semibold text-white font-outfit"><?php echo $s['name']; ?></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 relative border-b border-neutral-900/60">
    <div class="absolute top-[30%] left-[-5%] w-[300px] h-[300px] rounded-full bg-accent/5 blur-[100px] pointer-events-none"></div>
    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="text-center mb-16 fade-in-scroll">
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Professional Services</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">Custom digital solutions focused on quality, performance, and business growth.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">Custom Software</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Custom software solutions designed to match business processes, improve efficiency, and support long-term growth.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">Custom Websites</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Responsive and user-friendly websites built for strong branding, fast performance, and a smooth user experience.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-brands fa-wordpress-simple"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">WordPress Websites</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            SEO-friendly WordPress websites suitable for blogs, business sites, and content management systems.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">Shopify Development</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Secure and scalable Shopify stores with clean design, easy product management, and smooth checkout.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">AI Automation</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Integrating custom AI API workflows, large language models (LLMs), and automating backend data operations.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col fade-in-scroll">
                <div class="glass-card p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-accent mb-4 text-xl">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <h3 class="text-lg font-bold font-outfit text-white mb-2">AI Workflow Agents</h3>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-0">
                            Engineering smart autonomous agents using platforms like n8n, Zapier, Make.com, and custom chatbots.
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
                <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Featured Creations</h2>
                <p class="text-neutral-400 text-sm sm:text-base">Discover the latest architectural designs and production builds.</p>
            </div>
            <a href="portfolio.php" class="text-sm font-semibold text-accent hover:text-orange-400 transition mt-4 sm:mt-0 no-underline">
                Explore All Projects <i class="fa-solid fa-arrow-right-long ml-2 text-xs"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php if (empty($featured_projects)): ?>
                <div class="col-12 text-center text-neutral-500 py-10">
                    No featured projects loaded yet. Visit the <a href="admin/login.php" class="text-accent underline">Admin Panel</a> to upload one.
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
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit mb-3">Client Kind Words</h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-sm sm:text-base">Hear what clients say about building products and automations together.</p>
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
                    'company' => 'Custom Script Client',
                    'text' => 'Outstanding work on our custom backend script. The code is clean, securely validated, and executes database queries with extreme speed. Will work with him again.',
                    'initial' => 'G'
                ],
                [
                    'name' => 'Shahid Mansheer',
                    'company' => 'E-commerce Business Owner',
                    'text' => 'Awais built a highly responsive and custom website for our e-commerce business. Checkout processes are secure, page loading is lightning fast, and client conversions are up!',
                    'initial' => 'S'
                ],
                [
                    'name' => 'Hamza',
                    'company' => 'AI Automation & Social Media',
                    'text' => 'Excellent work setting up our AI automation pipeline. We now manage, schedule, and publish social media posts and technical blogs automatically using custom APIs. Huge time saver.',
                    'initial' => 'H'
                ],
                [
                    'name' => 'Biller Ketlik',
                    'company' => 'AI Agent Workflow Client',
                    'text' => 'Superb AI agent workflow development. He automated our technical blog research and draft writing processes. A real game-changer for our content publishing timeline.',
                    'initial' => 'B'
                ],
                [
                    'name' => 'Hamna Embroidery',
                    'company' => 'Embroidery Textile Software',
                    'text' => 'Awais developed tailored management software for our embroidery textile factory. Now we track production details, inventories, and designs easily. Great backend design!',
                    'initial' => 'H'
                ],
                [
                    'name' => 'Jahanzaib',
                    'company' => 'Inventory System Client',
                    'text' => 'We needed an inventory management system to handle stock alerts, suppliers, and transactions. The solution Awais built is incredibly clean, secure, and intuitive.',
                    'initial' => 'J'
                ],
                [
                    'name' => 'John Bura',
                    'company' => 'LMS System Client',
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
        <h2 class="text-3xl sm:text-5xl font-bold font-outfit mb-4">Let's build something epic together</h2>
        <p class="text-neutral-400 max-w-xl mx-auto mb-8 text-sm sm:text-base">Need a custom web solution, Shopify integration, or AI automation workflow? Let's connect.</p>
        <a href="contact.php" class="px-8 py-4 rounded-xl text-base font-semibold text-white btn-glow no-underline inline-flex items-center gap-3">
            Initiate Project Discussion <i class="fa-solid fa-paper-plane text-sm"></i>
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
