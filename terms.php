<?php
require_once 'includes/db.php';

// Fetch terms content
$terms_content = "";
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT terms_content FROM settings LIMIT 1");
        $terms_content = $stmt->fetchColumn() ?: "";
    } catch (PDOException $e) {
        // Fallback
    }
}

// Fallback if empty
if (empty($terms_content)) {
    $terms_content = "
    <h2>1. Acceptance of Terms</h2>
    <p>By accessing this website, you are agreeing to be bound by these website Terms and Services, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p>
    
    <h2>2. Use License</h2>
    <p>Permission is granted to temporarily view the materials (information or software) on Awais Qarni's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
    <ul>
        <li>Modify or copy the materials;</li>
        <li>Use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
        <li>Attempt to decompile or reverse engineer any software contained on this website;</li>
        <li>Remove any copyright or other proprietary notations from the materials; or</li>
        <li>Transfer the materials to another person or 'mirror' the materials on any other server.</li>
    </ul>

    <h2>3. Disclaimer</h2>
    <p>The materials on this website are provided 'as is'. Awais Qarni makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
    
    <h2>4. Limitations</h2>
    <p>In no event shall Awais Qarni or his suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on this website.</p>";
}

$page_title = "Terms & Services | Awais Qarni";
$active_page = 'terms';
require_once 'includes/header.php';
?>

<section class="py-20 relative">
    <!-- Glow -->
    <div class="absolute top-[10%] left-[-5%] w-[250px] h-[250px] rounded-full bg-accent/5 blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 max-w-4xl relative z-10">
        <!-- Title -->
        <div class="mb-12 fade-in-scroll">
            <h1 class="text-4xl font-extrabold font-outfit mb-3">Terms & Services</h1>
            <p class="text-neutral-400">Please read our terms of use and policies carefully before navigating.</p>
        </div>

        <!-- Terms Content Wrapper -->
        <div class="glass-card p-6 md:p-10 fade-in-scroll">
            <div class="prose prose-invert max-w-none text-neutral-300 text-sm sm:text-base leading-relaxed space-y-6">
                <?php echo $terms_content; ?>
            </div>
        </div>
        
        <div class="mt-8 text-center text-xs text-neutral-500 fade-in-scroll">
            Last Updated: June 8, 2026. For inquiries, email <a href="mailto:chawaisdev92@gmail.com" class="text-accent underline">chawaisdev92@gmail.com</a>.
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
