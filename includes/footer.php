<?php
// Retrieve settings again if not present
if (!isset($site_settings) && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
        $site_settings = $stmt->fetch() ?: [];
    } catch (PDOException $e) {
        $site_settings = [];
    }
}
$site_name = !empty($site_settings['site_name']) ? $site_settings['site_name'] : 'Awais Qarni';
$fb_link = !empty($site_settings['facebook']) ? $site_settings['facebook'] : 'https://www.facebook.com/ch.awais.508218';
$li_link = !empty($site_settings['linkedin']) ? $site_settings['linkedin'] : 'https://www.linkedin.com/in/choudhary-awais/';
$gh_link = !empty($site_settings['github']) ? $site_settings['github'] : 'https://github.com/choudharyawaisdev';
?>
    </main>
    <!-- Main Content Area Ends -->

    <!-- Footer -->
    <footer class="bg-[#08080C] border-t border-neutral-900/60 pt-16 pb-8 text-neutral-400 font-inter">
        <div class="container mx-auto px-4 md:px-8">
            <div class="row g-4 mb-12">
                <!-- Branding Info -->
                <div class="col-lg-5 col-md-12">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-orange-600 flex items-center justify-center font-bold text-lg text-white">AQ</span>
                        <span class="font-extrabold text-xl tracking-tight text-white font-outfit">Awais<span class="text-accent">.</span></span>
                    </div>
                    <div class="text-xs font-bold text-accent uppercase tracking-wider mb-3">PHP & Laravel Developer</div>
                    <p class="max-w-md text-sm leading-relaxed mb-4">
                        Building secure, scalable, and high-performance web applications using PHP, Laravel, MySQL, and WordPress.
                    </p>
                    <div class="flex flex-wrap gap-2 text-[11px] text-neutral-400 font-semibold mb-6">
                        <span class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-800">PHP</span>
                        <span class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-800">Laravel</span>
                        <span class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-800">MySQL / SQL</span>
                        <span class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-800">WordPress</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo htmlspecialchars($fb_link); ?>" target="_blank" aria-label="Facebook" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800/80 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition duration-300">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="<?php echo htmlspecialchars($li_link); ?>" target="_blank" aria-label="LinkedIn" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800/80 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition duration-300">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="<?php echo htmlspecialchars($gh_link); ?>" target="_blank" aria-label="GitHub" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800/80 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition duration-300">
                            <i class="fa-brands fa-github text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="font-outfit text-white font-semibold text-base tracking-wider uppercase mb-4">Navigation</h4>
                    <ul class="list-unstyled space-y-2.5 text-sm">
                        <li><a href="index.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Home</a></li>
                        <li><a href="about.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> About</a></li>
                        <li><a href="index.php#services" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Services</a></li>
                        <li><a href="index.php#technologies" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Technologies</a></li>
                        <li><a href="portfolio.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Projects</a></li>
                        <li><a href="contact.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Extra Links & Legal -->
                <div class="col-lg-4 col-md-6">
                    <h4 class="font-outfit text-white font-semibold text-base tracking-wider uppercase mb-4">Legal & Policies</h4>
                    <ul class="list-unstyled space-y-2.5 text-sm mb-6">
                        <li><a href="terms.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Terms & Services</a></li>
                        <li><a href="terms.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Privacy Policy</a></li>
                        <li><a href="contact.php" class="no-underline text-neutral-400 hover:text-accent transition duration-200 flex items-center gap-2.5 group"><i class="fa-solid fa-arrow-right text-[11px] text-accent transition group-hover:translate-x-1"></i> Get in Touch</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-neutral-900/60 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site_name); ?>. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="terms.php" class="no-underline text-neutral-500 hover:text-neutral-300">Privacy Policy</a>
                    <span class="text-neutral-800">|</span>
                    <a href="terms.php" class="no-underline text-neutral-500 hover:text-neutral-300">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Animated Glassmorphism Toast Container -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 max-w-sm w-full px-4 sm:px-0"></div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Main Script -->
    <script src="assets/js/main.js"></script>
</body>
</html>
