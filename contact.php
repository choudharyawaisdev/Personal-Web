<?php
require_once 'includes/db.php';

$success_msg = "";
$error_msg = "";

// Generate CSRF token if needed
$csrf_token = get_csrf_token();

// Handle AJAX or direct POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $message_content = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    $token_received = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    $is_ajax = isset($_POST['ajax_submit']) && $_POST['ajax_submit'] === '1';

    // Validation
    if (!$name || !$email || !$message_content) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!verify_csrf_token($token_received)) {
        $error = "Security validation failed. Please refresh and try again.";
    } else {
        // Save to Database
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO messages (name, email, message, status) VALUES (?, ?, ?, 'unread')");
                $stmt->execute([$name, $email, $message_content]);
                
                // Attempt SMTP Email Dispatch
                require_once 'includes/smtp_mailer.php';
                
                $to = "chawaisdev92@gmail.com";
                $subject = "Portfolio Contact: " . $name;
                
                $email_body = "
                <html>
                <head><title>New Message</title></head>
                <body style='font-family: Arial, sans-serif; background-color: #F4F5F7; color: #1F2937; padding: 20px; margin: 0;'>
                    <div style='max-width: 600px; margin: 20px auto; background-color: #FFFFFF; border-radius: 12px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden;'>
                        <div style='height: 4px; background: linear-gradient(90deg, #FF6A00 0%, #E04D00 100%);'></div>
                        <div style='padding: 30px;'>
                            <h2 style='color: #FF6A00; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 20px;'>New Contact Inquiry</h2>
                            <p style='margin: 0 0 16px 0; font-size: 14px; color: #4B5563;'>You have received a new contact submission from your Portfolio Website.</p>
                            
                            <table style='width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 14px;'>
                                <tr>
                                    <td style='padding: 8px 0; color: #4B5563; font-weight: 600; width: 80px;'>Name:</td>
                                    <td style='padding: 8px 0; color: #1F2937;'>{$name}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #4B5563; font-weight: 600;'>Email:</td>
                                    <td style='padding: 8px 0; color: #1F2937;'><a href='mailto:{$email}' style='color: #FF6A00; text-decoration: none;'>{$email}</a></td>
                                </tr>
                            </table>

                            <h3 style='color: #1F2937; font-size: 14px; font-weight: 600; margin-top: 0; margin-bottom: 10px;'>Message:</h3>
                            <div style='background-color: #F9FAFB; border: 1px solid #F3F4F6; padding: 16px; border-radius: 8px; font-size: 14px; line-height: 1.6; color: #374151;'>
                                " . nl2br($message_content) . "
                            </div>
                        </div>
                        <div style='background-color: #F9FAFB; padding: 15px 30px; border-top: 1px solid #E5E7EB; text-align: center; font-size: 11px; color: #9CA3AF;'>
                            This is an automated notification from your Portfolio Website CMS.
                        </div>
                    </div>
                </body>
                </html>";
                
                // Send securely via Gmail SMTP using app credentials
                send_smtp_email($to, $subject, $email_body, $name);
                
                $log_dir = __DIR__ . '/uploads/';
                if (!file_exists($log_dir)) {
                    mkdir($log_dir, 0755, true);
                }
                $log_content = "[" . date('Y-m-d H:i:s') . "] To: $to | Subject: $subject\nMessage: $message_content\n---------------------------------\n";
                file_put_contents($log_dir . 'mail_log.txt', $log_content, FILE_APPEND);

                $success = "Your message has been sent successfully!";
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Database connection offline. Message could not be saved.";
        }
    }

    // Response Dispatcher
    if ($is_ajax) {
        header('Content-Type: application/json');
        if (isset($success)) {
            echo json_encode(['status' => 'success', 'message' => $success]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $error]);
        }
        exit;
    } else {
        if (isset($success)) {
            $success_msg = $success;
        } else {
            $error_msg = $error;
        }
    }
}

$page_title = "Hire PHP & Laravel Developer | Contact Awais Qarni";
$meta_desc = "Get in touch with Awais Qarni for custom PHP web applications, Laravel backends, MySQL database architecture, and WordPress solutions.";
$active_page = 'contact';
require_once 'includes/header.php';
?>

<section class="py-20 relative">
    <!-- Glow -->
    <div class="absolute bottom-[10%] left-[-5%] w-[350px] h-[350px] rounded-full bg-accent/5 blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <!-- Title -->
        <div class="text-center mb-16 fade-in-scroll">
            <div class="inline-block text-accent text-xs font-bold tracking-widest uppercase mb-2">Hire Me / Contact</div>
            <h1 class="text-4xl font-extrabold font-outfit mb-3">Get in Touch</h1>
            <p class="text-neutral-400 max-w-lg mx-auto">Have a PHP, Laravel, MySQL, or WordPress project in mind? Drop a message below to discuss your requirements.</p>
        </div>

        <div class="row g-5 justify-content-center">
            <!-- Left Info Block -->
            <div class="col-lg-5 order-2 order-lg-1 fade-in-scroll">
                <div class="glass-card p-6 md:p-8 space-y-6">
                    <h2 class="text-xl font-bold font-outfit text-white">Contact Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-accent/15 flex items-center justify-center text-accent">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-1">Email Me</h3>
                                <a href="mailto:chawaisdev92@gmail.com" class="text-sm text-white hover:text-accent transition no-underline">chawaisdev92@gmail.com</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-accent/15 flex items-center justify-center text-accent">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-1">Location</h3>
                                <p class="text-sm text-white m-0">Punjab, Pakistan (Remote Available)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-accent/15 flex items-center justify-center text-accent">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-1">Working Hours</h3>
                                <p class="text-sm text-white m-0">Mon - Sat: 9:00 AM - 6:00 PM (GMT+5)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-neutral-900/60">
                        <h4 class="text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">Connect Globally</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                            <a href="#" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                            <a href="#" class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-accent hover:border-accent/40 transition"><i class="fa-brands fa-github text-sm"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Block -->
            <div class="col-lg-7 order-1 order-lg-2 fade-in-scroll">
                <div class="glass-card p-6 md:p-8">
                    <h2 class="text-xl font-bold font-outfit text-white mb-6">Send Message</h2>
                    
                    <?php if ($success_msg): ?>
                        <div class="p-4 mb-6 rounded-lg text-sm bg-emerald-950/80 text-emerald-300 border border-emerald-500/30">
                            ✔ <?php echo $success_msg; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error_msg): ?>
                        <div class="p-4 mb-6 rounded-lg text-sm bg-rose-950/80 text-rose-300 border border-rose-500/30">
                            ✖ <?php echo $error_msg; ?>
                        </div>
                    <?php endif; ?>

                    <form id="contact-ajax-form" method="POST" action="contact.php" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="contact-name" class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Name</label>
                                <input type="text" id="contact-name" name="name" required placeholder="John Doe"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                            <div class="col-md-6">
                                <label for="contact-email" class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" id="contact-email" name="email" required placeholder="john@example.com"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="contact-message" class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Message</label>
                            <textarea id="contact-message" name="message" required placeholder="Hi, let's build something epic..."
                                      class="w-full px-4 py-3 form-input-custom rounded-lg text-sm h-32 resize-none"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="w-full py-3.5 btn-glow text-white font-semibold rounded-lg text-sm tracking-wide">
                                Send Message <i class="fa-solid fa-paper-plane ml-2 text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
