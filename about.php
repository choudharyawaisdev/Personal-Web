<?php
$page_title = "About Awais Qarni | Full-Stack PHP & Laravel Developer";
$meta_desc = "I am a Full-Stack PHP & Laravel Developer focused on building reliable, scalable and user-friendly web applications with PHP, Laravel, MySQL/SQL and WordPress.";
$active_page = 'about';
require_once 'includes/header.php';
?>

<section class="py-20 relative">
    <!-- Background glow -->
    <div class="absolute top-[10%] left-[-10%] w-[300px] h-[300px] rounded-full bg-accent/5 blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <!-- Section Title -->
        <div class="mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Professional Profile</div>
            <h1 class="text-4xl font-extrabold font-outfit mb-3">About My Journey</h1>
            <p class="text-neutral-400">Engineering secure web applications, database architectures, and scalable business systems.</p>
        </div>

        <div class="row g-5 mb-20">
            <!-- Left Info Block: Bio -->
            <div class="col-lg-7 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-4 text-white">Full-Stack PHP & Laravel Developer</h2>
                <div class="space-y-4 text-neutral-300 text-sm sm:text-base leading-relaxed">
                    <p class="text-white font-medium text-lg leading-relaxed">
                        I am a Full-Stack PHP & Laravel Developer focused on building reliable, scalable and user-friendly web applications.
                    </p>
                    <p>
                        My core expertise includes PHP, Laravel, MySQL/SQL and WordPress. I work on custom web applications, business systems, APIs, dashboards and WordPress websites.
                    </p>
                    <p>
                        With a strong focus on clean architecture, OOP principles, relational database design, and high-performance server logic, I deliver secure and robust software tailored to international business requirements.
                    </p>
                </div>
            </div>

            <!-- Right Info Block: Quick Facts / Skills Grid -->
            <div class="col-lg-5 fade-in-scroll">
                <div class="glass-card p-6 md:p-8 space-y-6">
                    <h3 class="text-xl font-bold font-outfit text-white">Technical Core</h3>
                    
                    <div class="space-y-4">
                        <?php 
                        $core_skills = [
                            ['name' => 'PHP (Core & OOP)', 'level' => 95],
                            ['name' => 'Laravel Framework & MVC', 'level' => 92],
                            ['name' => 'MySQL / SQL Databases', 'level' => 90],
                            ['name' => 'WordPress & WooCommerce', 'level' => 88],
                            ['name' => 'REST APIs & Web Services', 'level' => 90],
                            ['name' => 'Database Design & Optimization', 'level' => 88],
                            ['name' => 'CRM & ERP Business Logic', 'level' => 85],
                            ['name' => 'Secure Backend Engineering', 'level' => 90]
                        ];
                        foreach ($core_skills as $skill):
                        ?>
                        <div>
                            <div class="flex justify-between text-xs font-semibold uppercase mb-1.5">
                                <span class="text-white"><?php echo $skill['name']; ?></span>
                                <span class="text-accent"><?php echo $skill['level']; ?>%</span>
                            </div>
                            <div class="w-full bg-neutral-900 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-accent to-orange-500 h-1.5 rounded-full" style="width: <?php echo $skill['level']; ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Milestones timeline -->
        <div class="mb-20 fade-in-scroll">
            <h2 class="text-2xl font-bold font-outfit mb-8 text-white flex items-center gap-2">
                <i class="fa-solid fa-map-signs text-accent text-lg"></i> Journey Milestones
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2020</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Core PHP Foundations</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Mastered backend fundamentals, procedural and object-oriented PHP, and SQL queries.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2021</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Laravel Web Applications</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Built MVC web applications, Eloquent ORM architectures, and secure auth portals.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2023</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Complex Business Systems</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Engineered ERP systems, inventory databases, payment gateways, and custom REST APIs.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2024+</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Full-Stack Solutions</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Delivering production PHP, Laravel, MySQL, and WordPress projects for international clients.</p>
                </div>
            </div>
        </div>

        <!-- Experience & Education Timelines -->
        <div class="row g-5 mb-20">
            <!-- Experience -->
            <div class="col-lg-6 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-6 text-white flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-accent text-lg"></i> Work History
                </h2>
                <div class="space-y-6 border-l-2 border-neutral-900 pl-6 relative ml-3">
                    <!-- Experience Item 1 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent ring-4 ring-darkbg"></span>
                        <span class="text-xs text-accent font-semibold block mb-1">04/2025 - Present</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">Senior Web Developer</h3>
                        <p class="text-xs text-neutral-500 mb-2">TechloStack – Faisalabad, Pakistan</p>
                        <ul class="text-xs text-neutral-400 leading-relaxed list-disc pl-4 space-y-1">
                            <li>Develop and maintain custom PHP and Laravel business software applications.</li>
                            <li>Optimize MySQL database schemas, query execution plans, and security policies.</li>
                            <li>Deliver custom WordPress theme customization and WooCommerce functionality.</li>
                        </ul>
                    </div>

                    <!-- Experience Item 2 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent/40 ring-4 ring-darkbg"></span>
                        <span class="text-xs text-neutral-500 font-semibold block mb-1">04/2024 - 04/2025</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">PHP / Laravel Software Engineer</h3>
                        <p class="text-xs text-neutral-500 mb-2">HKS TechLabs – Vehari, Pakistan</p>
                        <ul class="text-xs text-neutral-400 leading-relaxed list-disc pl-4 space-y-1">
                            <li>Implemented third-party payment gateways and external REST APIs in Laravel.</li>
                            <li>Engineered secure role-based access control (RBAC) and authentication workflows.</li>
                            <li>Utilized Git version control for collaborative development and code review processes.</li>
                            <li>Strengthened SQL injection prevention, validation rules, and server security.</li>
                        </ul>
                    </div>

                    <!-- Experience Item 3 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent/40 ring-4 ring-darkbg"></span>
                        <span class="text-xs text-neutral-500 font-semibold block mb-1">02/2023 - 04/2024</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">PHP Developer</h3>
                        <p class="text-xs text-neutral-500 mb-2">The Web Concept – Faisalabad, Pakistan</p>
                        <ul class="text-xs text-neutral-400 leading-relaxed list-disc pl-4 space-y-1">
                            <li>Developed database-driven web applications and client management portals.</li>
                            <li>Designed relational MySQL schemas, stored procedures, and complex data joins.</li>
                            <li>Engineered RESTful API endpoints for backend data exchange.</li>
                            <li>Customized WordPress websites and implemented custom plugin features.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Education -->
            <div class="col-lg-6 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-6 text-white flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-accent text-lg"></i> Education
                </h2>
                <div class="space-y-6 border-l-2 border-neutral-900 pl-6 relative ml-3">
                    <!-- Education Item 1 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent ring-4 ring-darkbg"></span>
                        <span class="text-xs text-accent font-semibold block mb-1">08/2025 - Present</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">BS in Computer Science</h3>
                        <p class="text-xs text-neutral-500 mb-2">Virtual University, Vehari, Punjab, Pakistan</p>
                        <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed">
                            Focusing on relational database design, data structures, algorithms, computational logic, and web engineering.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certifications & Interests -->
        <div class="row g-5">
            <!-- Certifications -->
            <div class="col-lg-6 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-6 text-white flex items-center gap-2">
                    <i class="fa-solid fa-certificate text-accent text-lg"></i> Certifications & Credentials
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="glass-card p-5">
                        <div class="text-accent text-xl mb-2"><i class="fa-solid fa-code-branch"></i></div>
                        <h3 class="text-sm font-bold text-white font-outfit mb-1">Web Developer Certificate</h3>
                        <p class="text-xs text-neutral-500 m-0">Cybex IT Group (2023)</p>
                        <p class="text-[10px] text-neutral-500 m-0">Advanced Web Development & PHP Certification</p>
                    </div>

                    <div class="glass-card p-5">
                        <div class="text-accent text-xl mb-2"><i class="fa-solid fa-people-group"></i></div>
                        <h3 class="text-sm font-bold text-white font-outfit mb-1">IEEE Member</h3>
                        <p class="text-xs text-neutral-500 m-0">IEEE Membership (2025)</p>
                        <p class="text-[10px] text-neutral-500 m-0">Active member promoting technology innovation</p>
                    </div>
                </div>
            </div>

            <!-- Professional Focus Areas -->
            <div class="col-lg-6 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-6 text-white flex items-center gap-2">
                    <i class="fa-solid fa-compass text-accent text-lg"></i> Professional Focus Areas
                </h2>
                <div class="glass-card p-6 md:p-8 space-y-4">
                    <p class="text-neutral-400 text-sm leading-relaxed">
                        My primary development specializations include:
                    </p>
                    <ul class="list-unstyled space-y-3 text-sm text-neutral-400">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Laravel MVC architecture, Eloquent ORM & REST API development.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Optimizing MySQL database schemas, indexing, and complex queries.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Core PHP backend systems, OOP design patterns & secure data handling.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Custom WordPress websites, plugin development & WooCommerce customization.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

