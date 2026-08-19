<?php
$page_title = "About Awais Qarni | Professional Profile";
$active_page = 'about';
require_once 'includes/header.php';
?>

<section class="py-20 relative">
    <!-- Background glow -->
    <div class="absolute top-[10%] left-[-10%] w-[300px] h-[300px] rounded-full bg-accent/5 blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <!-- Section Title -->
        <div class="mb-16 fade-in-scroll">
            <h1 class="text-4xl font-extrabold font-outfit mb-3">About My Journey</h1>
            <p class="text-neutral-400">Engineering advanced digital experiences and structured backend systems.</p>
        </div>

        <div class="row g-5 mb-20">
            <!-- Left Info Block: Bio -->
            <div class="col-lg-7 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-4 text-white">Professional Summary</h2>
                <div class="space-y-4 text-neutral-400 text-sm sm:text-base leading-relaxed">
                    <p class="text-white font-medium text-lg leading-relaxed">
                        Solution-oriented Web Developer with strong experience in backend and frontend development, delivering secure, scalable, and high-performance web solutions.
                    </p>
                    <p>
                        I specialize in creating structured and maintainable backend systems using PHP and Laravel, designing efficient database schemas, and transforming complex business requirements into elegant, working code.
                    </p>
                    <p>
                        From third-party API integrations (like Stripe payments) to securing backend applications and managing collaborative workflows using GitHub, I focus on performance, security, and delivering premium solutions that drive business growth.
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
                            ['name' => 'PHP (Core Backend)', 'level' => 90],
                            ['name' => 'Laravel Framework', 'level' => 90],
                            ['name' => 'MySQL (Databases)', 'level' => 88],
                            ['name' => 'React JS & JavaScript', 'level' => 85],
                            ['name' => 'AI Automation (n8n / Zapier / Make)', 'level' => 85],
                            ['name' => 'WordPress CMS', 'level' => 80],
                            ['name' => 'HTML & CSS / Bootstrap', 'level' => 75],
                            ['name' => 'System Design', 'level' => 85]
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
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Started Web Development</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Focused on backend fundamentals and PHP core architectures.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2021</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Laravel Projects</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Built real-world CRUD dashboards and maintainable business systems.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2023</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Advanced Business Logic</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Engineered complex sales, purchases, inventory systems, and transactional logic.</p>
                </div>
                <div class="glass-card p-6 border-l-4 border-l-accent">
                    <span class="text-2xl font-extrabold text-white font-outfit block mb-1">2024</span>
                    <h4 class="text-sm font-bold text-neutral-300 uppercase tracking-wide mb-2">Professional Freelancing</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed m-0">Delivering client-focused custom solutions with long-term reliability and support.</p>
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
                            <li>Create custom software solutions tailored for business growth.</li>
                            <li>Fix bugs, improve performance parameters, and maintain clean, scalable code.</li>
                            <li>Develop bespoke websites and optimized WordPress solutions.</li>
                        </ul>
                    </div>

                    <!-- Experience Item 2 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent/40 ring-4 ring-darkbg"></span>
                        <span class="text-xs text-neutral-500 font-semibold block mb-1">04/2024 - 04/2025</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">Software Engineer</h3>
                        <p class="text-xs text-neutral-500 mb-2">HKS TechLabs – Vehari, Pakistan</p>
                        <ul class="text-xs text-neutral-400 leading-relaxed list-disc pl-4 space-y-1">
                            <li>Implemented third-party API integrations including Stripe payment gateways.</li>
                            <li>Addressed error handling, bug resolving, and core logic optimization.</li>
                            <li>Utilized GitHub version control for collaborative development workflows.</li>
                            <li>Enhanced backend security structures and data protection protocols.</li>
                        </ul>
                    </div>

                    <!-- Experience Item 3 -->
                    <div class="relative">
                        <span class="absolute left-[-31px] top-1.5 w-[10px] h-[10px] rounded-full bg-accent/40 ring-4 ring-darkbg"></span>
                        <span class="text-xs text-neutral-500 font-semibold block mb-1">02/2023 - 04/2024</span>
                        <h3 class="text-base font-bold text-white font-outfit m-0">PHP Laravel Developer</h3>
                        <p class="text-xs text-neutral-500 mb-2">The Web Concept – Faisalabad, Pakistan</p>
                        <ul class="text-xs text-neutral-400 leading-relaxed list-disc pl-4 space-y-1">
                            <li>Developed responsive frontend interfaces using HTML, CSS, Bootstrap, and JavaScript.</li>
                            <li>Built clean backend database structures using PHP & Laravel frameworks.</li>
                            <li>Handled REST API integrations and server execution optimizations.</li>
                            <li>Ensured secure data manipulation and SQL protection.</li>
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
                            Focusing on software structures, databases, computational logic, and web engineering disciplines.
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
                        <p class="text-[10px] text-neutral-500 m-0">Advanced Web Development Certification</p>
                    </div>

                    <div class="glass-card p-5">
                        <div class="text-accent text-xl mb-2"><i class="fa-solid fa-people-group"></i></div>
                        <h3 class="text-sm font-bold text-white font-outfit mb-1">IEEE Member</h3>
                        <p class="text-xs text-neutral-500 m-0">IEEE Membership & Event Org (2025)</p>
                        <p class="text-[10px] text-neutral-500 m-0">Active IEEE member promoting innovation</p>
                    </div>
                </div>
            </div>

            <!-- Interests -->
            <div class="col-lg-6 fade-in-scroll">
                <h2 class="text-2xl font-bold font-outfit mb-6 text-white flex items-center gap-2">
                    <i class="fa-solid fa-compass text-accent text-lg"></i> Professional Focus Areas
                </h2>
                <div class="glass-card p-6 md:p-8 space-y-4">
                    <p class="text-neutral-400 text-sm leading-relaxed">
                        My development priorities include:
                    </p>
                    <ul class="list-unstyled space-y-3 text-sm text-neutral-400">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Laravel ecosystem structures and API engineering.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Optimizing SQL database structures & relational schemas.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Clean architecture & secure input validations.
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-angles-right text-accent text-[10px]"></i> Third-party platform integrations (Stripe, external REST services).
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

