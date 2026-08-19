<?php
require_once 'includes/db.php';

// Check if displaying a specific blog post
$slug = isset($_GET['slug']) ? sanitize_input($_GET['slug']) : null;
$blog_post = null;

if ($slug && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $blog_post = $stmt->fetch();
    } catch (PDOException $e) {
        // Fallback
    }
}

// Set SEO parameters based on view mode
if ($blog_post) {
    $page_title = $blog_post['title'] . " | Awais Qarni Tech Blog";
    $meta_desc = htmlspecialchars(substr(strip_tags($blog_post['content']), 0, 150));
} else {
    $page_title = "Tech Insights & Development Blog | Awais Qarni";
    $meta_desc = "Articles on Core PHP, Laravel Framework, MySQL Database Optimization, and WordPress development.";
}

$active_page = 'blog';
require_once 'includes/header.php';
?>

<?php if ($blog_post): ?>
    <!-- Blog Detail View -->
    <article class="py-20 relative">
        <div class="absolute top-[15%] left-[-5%] w-[300px] h-[300px] rounded-full bg-accent/5 blur-[120px] pointer-events-none"></div>
        
        <div class="container mx-auto px-4 md:px-8 max-w-4xl relative z-10">
            <!-- Back to list -->
            <a href="blog.php" class="inline-flex items-center gap-2 text-xs font-semibold text-neutral-400 hover:text-accent no-underline mb-8 transition">
                <i class="fa-solid fa-arrow-left"></i> Back to Tech Blog
            </a>
            
            <!-- Category and Date -->
            <div class="flex items-center gap-4 text-xs text-neutral-400 mb-4 font-inter">
                <span class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-800 text-accent font-semibold uppercase">Articles</span>
                <span><i class="fa-regular fa-calendar mr-1.5"></i> <?php echo date('M d, Y', strtotime($blog_post['created_at'])); ?></span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-5xl font-extrabold font-outfit mb-6 text-white leading-tight">
                <?php echo htmlspecialchars($blog_post['title']); ?>
            </h1>

            <!-- Featured Image -->
            <?php 
            $img_path = 'uploads/projects/' . $blog_post['image']; // Store blog and project images cleanly
            if (!empty($blog_post['image']) && file_exists($img_path)): 
            ?>
                <div class="w-full aspect-[2/1] rounded-2xl overflow-hidden mb-10 border border-neutral-900 shadow-xl">
                    <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($blog_post['title']); ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <!-- Post Content -->
            <div class="blog-content font-inter text-neutral-300 text-sm sm:text-base leading-relaxed space-y-6">
                <?php 
                // Render HTML content safely if stored from rich text, else double escape
                // We will assume stored content has basic markdown/tags. Let's output it.
                echo $blog_post['content']; 
                ?>
            </div>
            
            <!-- Author Card -->
            <div class="mt-16 pt-8 border-t border-neutral-900/80 flex items-center gap-4">
                <?php if (file_exists('assets/images/image.jpeg')): ?>
                    <img src="assets/images/image.jpeg" alt="Awais Qarni Profile" class="w-12 h-12 rounded-full object-cover border border-neutral-800">
                <?php elseif (file_exists('assets/images/image.jpg')): ?>
                    <img src="assets/images/image.jpg" alt="Awais Qarni Profile" class="w-12 h-12 rounded-full object-cover border border-neutral-800">
                <?php elseif (file_exists('assets/images/Awais no.jpg')): ?>
                    <img src="assets/images/Awais no.jpg" alt="Awais Qarni Profile" class="w-12 h-12 rounded-full object-cover border border-neutral-800">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center text-accent">
                        <i class="fa-solid fa-code"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <h4 class="text-sm font-bold text-white font-outfit m-0">Written by Awais Qarni</h4>
                    <p class="text-xs text-neutral-500 m-0">Full-Stack PHP & Laravel Developer</p>
                </div>
            </div>
        </div>
    </article>

<?php else: ?>
    <!-- Blog Listing View -->
    <section class="py-20 relative">
        <div class="absolute top-[20%] right-[-10%] w-[350px] h-[350px] rounded-full bg-accent/5 blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-8 relative z-10">
            <!-- Heading -->
            <div class="text-center mb-16 fade-in-scroll">
                <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Technical Articles</div>
                <h1 class="text-4xl font-extrabold font-outfit mb-3">Tech Insights</h1>
                <p class="text-neutral-400 max-w-lg mx-auto">Read technical deep-dives on Core PHP, Laravel architectures, MySQL optimization, and WordPress development.</p>
            </div>

            <!-- Fetch and loop blogs -->
            <?php
            $blogs = [];
            if ($pdo) {
                try {
                    $stmt = $pdo->query("SELECT * FROM blogs ORDER BY id DESC");
                    $blogs = $stmt->fetchAll();
                } catch (PDOException $e) {
                    // Fallback
                }
            }
            ?>

            <div class="row g-4 justify-content-center">
                <?php if (empty($blogs)): ?>
                    <div class="col-12 text-center text-neutral-500 py-20 fade-in-scroll">
                        <i class="fa-regular fa-newspaper text-5xl mb-4 text-neutral-700 block"></i>
                        No blog posts published yet. Visit the <a href="admin/login.php" class="text-accent underline font-semibold">Admin Panel</a> to write your first post.
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $post): ?>
                        <div class="col-lg-4 col-md-6 fade-in-scroll">
                            <div class="glass-card h-full flex flex-col p-4">
                                <!-- Featured Image wrapper -->
                                <div class="project-card-image mb-4 relative aspect-[16/10] bg-neutral-900 rounded-xl overflow-hidden">
                                    <?php 
                                    $img_path = 'uploads/projects/' . $post['image'];
                                    if (!empty($post['image']) && file_exists($img_path)): 
                                    ?>
                                        <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-neutral-800">
                                            <i class="fa-regular fa-newspaper text-5xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Date -->
                                <div class="text-[10px] text-neutral-500 mb-2 font-inter">
                                    <i class="fa-regular fa-calendar mr-1"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-bold font-outfit text-white mb-3 hover:text-accent transition duration-200">
                                    <a href="blog.php?slug=<?php echo $post['slug']; ?>" class="no-underline text-white hover:text-accent">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h3>

                                <!-- Snippet -->
                                <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed mb-4 flex-grow">
                                    <?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 120)) . (strlen(strip_tags($post['content'])) > 120 ? '...' : ''); ?>
                                </p>

                                <!-- Read More link -->
                                <div class="pt-3 border-t border-neutral-900/80 mt-auto">
                                    <a href="blog.php?slug=<?php echo $post['slug']; ?>" class="text-xs text-accent hover:text-orange-400 font-semibold flex items-center gap-1.5 no-underline transition">
                                        Read Article <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
