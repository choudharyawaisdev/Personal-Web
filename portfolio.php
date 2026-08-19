<?php
$page_title = "Projects Portfolio | Full-Stack PHP & Laravel Developer";
$meta_desc = "Explore custom web applications, Laravel systems, MySQL database designs, and WordPress websites developed by Awais Qarni.";
$active_page = 'portfolio';
require_once 'includes/header.php';

// Fetch all projects from database
$projects = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
        $projects = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Fallback
    }
}
?>

<section class="py-20 relative">
    <!-- Glow -->
    <div class="absolute top-[20%] right-[-10%] w-[350px] h-[350px] rounded-full bg-accent/5 blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <!-- Heading -->
        <div class="text-center mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">My Work</div>
            <h1 class="text-4xl font-extrabold font-outfit mb-3">Project Portfolio</h1>
            <p class="text-neutral-400 max-w-lg mx-auto">Explore custom web applications, Laravel backends, database architectures, and WordPress solutions.</p>
        </div>

        <!-- Dynamic Category Filters -->
        <div class="flex flex-wrap justify-center gap-3 mb-12 fade-in-scroll">
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-accent text-white transition duration-200" data-filter="all">
                All Projects
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider btn-outline-custom transition duration-200" data-filter="PHP">
                PHP
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider btn-outline-custom transition duration-200" data-filter="Laravel">
                Laravel
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider btn-outline-custom transition duration-200" data-filter="MySQL">
                MySQL
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider btn-outline-custom transition duration-200" data-filter="WordPress">
                WordPress
            </button>
        </div>

        <!-- Project Cards Grid -->
        <div class="row g-4" id="portfolio-grid">
            <?php if (empty($projects)): ?>
                <div class="col-12 text-center text-neutral-500 py-20 fade-in-scroll">
                    <i class="fa-regular fa-folder-open text-5xl mb-4 text-neutral-700 block"></i>
                    No projects found. Log in to the <a href="admin/login.php" class="text-accent underline font-semibold">Admin Panel</a> to add projects.
                </div>
            <?php else: ?>
                <?php foreach ($projects as $proj): ?>
                    <div class="col-lg-4 col-md-6 project-card-item fade-in-scroll" data-category="<?php echo htmlspecialchars($proj['category']); ?>">
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
                                <?php echo htmlspecialchars($proj['description']); ?>
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

<?php require_once 'includes/footer.php'; ?>

