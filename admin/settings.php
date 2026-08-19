<?php
require_once __DIR__ . '/auth_check.php';

$error = "";
$success = "";

// CSRF token
$csrf_token = get_csrf_token();

// Fetch settings
$settings = null;
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
        $settings = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Error loading settings: " . $e->getMessage();
    }
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = sanitize_input($_POST['site_name']);
    $email = sanitize_input($_POST['email']);
    $facebook = sanitize_input($_POST['facebook']);
    $linkedin = sanitize_input($_POST['linkedin']);
    $github = sanitize_input($_POST['github']);
    $terms_content = $_POST['terms_content']; // Raw HTML from form
    $token_received = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verify_csrf_token($token_received)) {
        $error = "Security validation failed. Please try again.";
    } elseif (empty($site_name) || empty($email)) {
        $error = "Site Name and Admin Email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid admin email address.";
    } else {
        $logo_name = $settings ? $settings['logo'] : '';

        // Handle Logo Upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['logo']['tmp_name'];
            $file_orig_name = $_FILES['logo']['name'];
            $file_size = $_FILES['logo']['size'];
            
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
            $file_ext = strtolower(pathinfo($file_orig_name, PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_exts)) {
                $error = "Invalid file type. Only JPG, JPEG, PNG, GIF, WEBP, and SVG logos are allowed.";
            } elseif ($file_size > 2 * 1024 * 1024) { // 2MB limit
                $error = "Logo file size exceeds limit of 2MB.";
            } else {
                // Generate unique logo name
                $logo_name = 'logo_' . time() . '.' . $file_ext;
                $upload_dir = __DIR__ . '/../uploads/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                if (move_uploaded_file($file_tmp, $upload_dir . $logo_name)) {
                    // Delete old logo if it exists
                    if ($settings && !empty($settings['logo']) && file_exists($upload_dir . $settings['logo'])) {
                        @unlink($upload_dir . $settings['logo']);
                    }
                } else {
                    $error = "Failed to upload logo file.";
                }
            }
        }

        // Update if no error
        if (empty($error)) {
            try {
                if ($settings) {
                    $stmt = $pdo->prepare("UPDATE settings SET site_name = ?, logo = ?, email = ?, facebook = ?, linkedin = ?, github = ?, terms_content = ? WHERE id = ?");
                    $stmt->execute([$site_name, $logo_name, $email, $facebook, $linkedin, $github, $terms_content, $settings['id']]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO settings (site_name, logo, email, facebook, linkedin, github, terms_content) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$site_name, $logo_name, $email, $facebook, $linkedin, $github, $terms_content]);
                }
                
                $_SESSION['flash_success'] = "Site settings updated successfully!";
                header("Location: settings.php");
                exit;
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Flush success message
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings | Awais Qarni CMS</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-darkbg text-white">

    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-darkcard border-r border-neutral-900/60 p-6 flex flex-col gap-8 hidden md:flex">
            <div>
                <a href="../index.php" class="flex items-center gap-2 no-underline text-white">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-orange-600 flex items-center justify-center font-bold text-lg text-white">AQ</span>
                    <span class="font-extrabold text-xl tracking-tight font-outfit">Awais<span class="text-accent">.</span></span>
                </a>
                <span class="text-[10px] text-neutral-500 font-bold uppercase tracking-wider block mt-1">Control Console</span>
            </div>

            <nav class="flex flex-col gap-1.5 flex-grow">
                <a href="dashboard.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-chart-pie text-sm"></i> Dashboard
                </a>
                <a href="projects.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-briefcase text-sm"></i> Projects CRUD
                </a>
                <a href="blogs.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-newspaper text-sm"></i> Blogs CRUD
                </a>
                <a href="messages.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-envelope text-sm"></i> Inbox
                </a>
                <a href="settings.php" class="admin-sidebar-link active">
                    <i class="fa-solid fa-sliders text-sm"></i> Site Settings
                </a>
            </nav>

            <div class="border-t border-neutral-900/80 pt-6">
                <a href="logout.php" class="admin-sidebar-link text-rose-400 hover:bg-rose-950/20 hover:text-rose-300">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i> Log Out
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-grow p-6 md:p-10">
            <header class="flex items-center justify-between mb-8 pb-6 border-b border-neutral-900/60">
                <div>
                    <h1 class="text-3xl font-extrabold font-outfit m-0">Site Settings</h1>
                    <p class="text-neutral-400 text-xs mt-1">Manage global portfolio values, headers, and policies</p>
                </div>
            </header>

            <?php if ($error): ?>
                <div class="p-4 mb-6 rounded-lg text-sm bg-rose-950/80 text-rose-300 border border-rose-500/30">
                    ✖ <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="p-4 mb-6 rounded-lg text-sm bg-emerald-950/80 text-emerald-300 border border-emerald-500/30">
                    ✔ <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <div class="glass-card p-6 md:p-8 max-w-3xl">
                <form method="POST" action="settings.php" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Website Title Name</label>
                            <input type="text" name="site_name" required value="<?php echo $settings ? htmlspecialchars($settings['site_name']) : 'Awais Qarni'; ?>" placeholder="Awais Qarni | Portfolio"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Admin Email address</label>
                            <input type="email" name="email" required value="<?php echo $settings ? htmlspecialchars($settings['email']) : 'chawaisdev92@gmail.com'; ?>" placeholder="chawaisdev92@gmail.com"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">GitHub URL</label>
                            <input type="url" name="github" value="<?php echo $settings ? htmlspecialchars($settings['github']) : ''; ?>" placeholder="https://github.com/profile"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">LinkedIn URL</label>
                            <input type="url" name="linkedin" value="<?php echo $settings ? htmlspecialchars($settings['linkedin']) : ''; ?>" placeholder="https://linkedin.com/in/profile"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Facebook URL</label>
                            <input type="url" name="facebook" value="<?php echo $settings ? htmlspecialchars($settings['facebook']) : ''; ?>" placeholder="https://facebook.com/profile"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Website Logo</label>
                        <?php if ($settings && !empty($settings['logo'])): ?>
                            <div class="mb-3 flex items-center gap-4">
                                <img src="../uploads/<?php echo $settings['logo']; ?>" alt="" class="h-10 w-auto rounded border border-neutral-850 bg-neutral-900 px-3 py-1">
                                <span class="text-xs text-neutral-500">Active logo badge</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="logo" accept="image/*"
                               class="w-full px-4 py-3 bg-neutral-900 border border-neutral-850 rounded-lg text-sm focus:outline-none focus:border-accent text-white">
                        <span class="text-[10px] text-neutral-500 block mt-1">Accepts PNG, JPG, JPEG, SVG up to 2MB</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Terms & Services Editor (HTML allowed)</label>
                        <textarea name="terms_content" placeholder="<h2>Terms & Services</h2><p>Our rules are...</p>"
                                  class="w-full px-4 py-3 form-input-custom rounded-lg text-sm h-48 font-mono"><?php echo $settings ? htmlspecialchars($settings['terms_content']) : ''; ?></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="px-6 py-3.5 rounded-lg text-sm font-semibold text-white bg-accent hover:opacity-90 transition shadow-lg shadow-accent/15">
                            Update Settings <i class="fa-solid fa-circle-check ml-2 text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
