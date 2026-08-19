<?php
require_once __DIR__ . '/../includes/db.php';

// Auth validation
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = "";
$success = "";
$project = null;

// CSRF token for operations
$csrf_token = get_csrf_token();

// Fetch project for Edit mode
if (($action === 'edit' || $action === 'delete') && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();
        if (!$project && $action !== 'delete') {
            header("Location: projects.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Add / Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $category = sanitize_input($_POST['category']);
    $tech_stack = sanitize_input($_POST['tech_stack']);
    $live_url = sanitize_input($_POST['live_url']);
    $github_url = sanitize_input($_POST['github_url']);
    $token_received = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verify_csrf_token($token_received)) {
        $error = "Security verification failed. Please try again.";
    } elseif (empty($title) || empty($description) || empty($category) || empty($tech_stack)) {
        $error = "Title, Description, Category and Tech Stack fields are required.";
    } else {
        $image_name = $project ? $project['image'] : ''; // Default to old image name if editing
        
        // Handle Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_orig_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $file_ext = strtolower(pathinfo($file_orig_name, PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_exts)) {
                $error = "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
            } elseif ($file_size > 5 * 1024 * 1024) { // 5MB limit
                $error = "File size exceeds limit of 5MB.";
            } else {
                // Generate a unique file name to avoid overwrite
                $image_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                $upload_dir = __DIR__ . '/../uploads/projects/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                if (move_uploaded_file($file_tmp, $upload_dir . $image_name)) {
                    // Delete old image if editing and upload succeeds
                    if ($action === 'edit' && !empty($project['image']) && file_exists($upload_dir . $project['image'])) {
                        @unlink($upload_dir . $project['image']);
                    }
                } else {
                    $error = "Failed to upload image. Please check directory permissions.";
                }
            }
        } elseif ($action === 'add') {
            $error = "Please upload a project preview image.";
        }

        // Save if no error
        if (empty($error)) {
            try {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, category, tech_stack, live_url, github_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $image_name, $category, $tech_stack, $live_url, $github_url]);
                    $_SESSION['flash_success'] = "Project added successfully!";
                    header("Location: projects.php");
                    exit;
                } else {
                    $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image = ?, category = ?, tech_stack = ?, live_url = ?, github_url = ? WHERE id = ?");
                    $stmt->execute([$title, $description, $image_name, $category, $tech_stack, $live_url, $github_url, $id]);
                    $_SESSION['flash_success'] = "Project updated successfully!";
                    header("Location: projects.php");
                    exit;
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Handle Delete Action
if ($action === 'delete' && $project) {
    // Simple deletion verification via post / get token check
    $confirm = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';
    if ($confirm) {
        try {
            $upload_dir = __DIR__ . '/../uploads/projects/';
            if (!empty($project['image']) && file_exists($upload_dir . $project['image'])) {
                @unlink($upload_dir . $project['image']);
            }
            $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = "Project deleted successfully!";
            header("Location: projects.php");
            exit;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Handle Flush alert messages
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}

// Fetch all projects for listing
$projects = [];
if ($action === 'list') {
    try {
        $projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
    } catch (PDOException $e) {
        $error = "Error fetching projects: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Manager | Awais Qarni</title>
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
                <a href="projects.php" class="admin-sidebar-link active">
                    <i class="fa-solid fa-briefcase text-sm"></i> Projects CRUD
                </a>
                <a href="blogs.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-newspaper text-sm"></i> Blogs CRUD
                </a>
                <a href="messages.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-envelope text-sm"></i> Inbox
                </a>
                <a href="settings.php" class="admin-sidebar-link">
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
                    <h1 class="text-3xl font-extrabold font-outfit m-0">Portfolio Manager</h1>
                    <p class="text-neutral-400 text-xs mt-1">Create, update, and manage your portfolio creations</p>
                </div>
                <div class="flex gap-3">
                    <?php if ($action !== 'list'): ?>
                        <a href="projects.php" class="px-4 py-2 rounded-lg text-xs font-bold text-neutral-400 bg-neutral-900 hover:bg-neutral-800 no-underline transition border border-neutral-800">
                            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to List
                        </a>
                    <?php else: ?>
                        <a href="projects.php?action=add" class="px-4 py-2 rounded-lg text-xs font-bold text-white bg-accent hover:opacity-90 no-underline transition shadow-lg shadow-accent/20">
                            <i class="fa-solid fa-plus mr-1.5"></i> Add Project
                        </a>
                    <?php endif; ?>
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

            <!-- Action Block -->
            <?php if ($action === 'list'): ?>
                <div class="glass-card p-6 md:p-8">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle text-sm border-0 m-0">
                            <thead>
                                <tr class="border-b border-neutral-900 text-neutral-500 uppercase tracking-wider text-xs">
                                    <th class="py-3 px-4 border-0">Image</th>
                                    <th class="py-3 px-4 border-0">Title</th>
                                    <th class="py-3 px-4 border-0">Category</th>
                                    <th class="py-3 px-4 border-0">Tech Stack</th>
                                    <th class="py-3 px-4 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($projects)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-neutral-500 py-10">No projects added yet. Click Add Project to start!</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($projects as $proj): ?>
                                        <tr class="border-b border-neutral-900/40">
                                            <td class="py-3 px-4 border-0">
                                                <?php 
                                                $img_path = '../uploads/projects/' . $proj['image'];
                                                if (!empty($proj['image']) && file_exists($img_path)): 
                                                ?>
                                                    <img src="<?php echo $img_path; ?>" alt="" class="w-12 h-8 object-cover rounded border border-neutral-800">
                                                <?php else: ?>
                                                    <div class="w-12 h-8 bg-neutral-900 rounded flex items-center justify-center text-neutral-700"><i class="fa-regular fa-image text-xs"></i></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-4 border-0 font-bold text-white"><?php echo htmlspecialchars($proj['title']); ?></td>
                                            <td class="py-3 px-4 border-0 text-neutral-400"><span class="px-2 py-0.5 bg-neutral-900 border border-neutral-850 rounded text-xs"><?php echo htmlspecialchars($proj['category']); ?></span></td>
                                            <td class="py-3 px-4 border-0 text-neutral-400 text-xs truncate max-w-xs"><?php echo htmlspecialchars($proj['tech_stack']); ?></td>
                                            <td class="py-3 px-4 border-0 text-end">
                                                <div class="inline-flex gap-2">
                                                    <a href="projects.php?action=edit&id=<?php echo $proj['id']; ?>" class="w-8 h-8 rounded bg-neutral-900 border border-neutral-800 hover:border-accent flex items-center justify-center text-neutral-400 hover:text-accent transition no-underline" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="projects.php?action=delete&id=<?php echo $proj['id']; ?>" class="w-8 h-8 rounded bg-neutral-900 border border-neutral-800 hover:border-rose-500 flex items-center justify-center text-neutral-400 hover:text-rose-400 transition no-underline" title="Delete"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php elseif ($action === 'add' || $action === 'edit'): ?>
                <div class="glass-card p-6 md:p-8 max-w-3xl">
                    <h2 class="text-xl font-bold font-outfit text-white mb-6"><?php echo $action === 'add' ? 'Add New Project' : 'Edit Project'; ?></h2>
                    
                    <form method="POST" action="projects.php?action=<?php echo $action; ?><?php echo $action === 'edit' ? '&id='.$id : ''; ?>" enctype="multipart/form-data" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div>
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Project Title</label>
                            <input type="text" name="title" required value="<?php echo $project ? htmlspecialchars($project['title']) : ''; ?>" placeholder="E-commerce Architecture"
                                   class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Description</label>
                            <textarea name="description" required placeholder="Describe details, challenges solved, and components built..."
                                      class="w-full px-4 py-3 form-input-custom rounded-lg text-sm h-32 resize-none"><?php echo $project ? htmlspecialchars($project['description']) : ''; ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Category</label>
                                <select name="category" required class="w-full px-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-sm focus:outline-none focus:border-accent text-white">
                                    <option value="PHP" <?php echo ($project && $project['category'] === 'PHP') ? 'selected' : ''; ?>>PHP</option>
                                    <option value="Laravel" <?php echo ($project && $project['category'] === 'Laravel') ? 'selected' : ''; ?>>Laravel</option>
                                    <option value="MySQL" <?php echo ($project && $project['category'] === 'MySQL') ? 'selected' : ''; ?>>MySQL</option>
                                    <option value="WordPress" <?php echo ($project && $project['category'] === 'WordPress') ? 'selected' : ''; ?>>WordPress</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Tech Stack (comma separated)</label>
                                <input type="text" name="tech_stack" required value="<?php echo $project ? htmlspecialchars($project['tech_stack']) : ''; ?>" placeholder="PHP, Laravel, MySQL, WordPress"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Live Demo URL (optional)</label>
                                <input type="url" name="live_url" value="<?php echo $project ? htmlspecialchars($project['live_url']) : ''; ?>" placeholder="https://example.com/demo"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">GitHub Code URL (optional)</label>
                                <input type="url" name="github_url" value="<?php echo $project ? htmlspecialchars($project['github_url']) : ''; ?>" placeholder="https://github.com/profile/repo"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Project Image</label>
                            <?php if ($project && !empty($project['image'])): ?>
                                <div class="mb-3 flex items-center gap-4">
                                    <img src="../uploads/projects/<?php echo $project['image']; ?>" alt="" class="w-24 h-16 object-cover rounded border border-neutral-800">
                                    <span class="text-xs text-neutral-500">Current image on server</span>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" <?php echo $action === 'add' ? 'required' : ''; ?> accept="image/*"
                                   class="w-full px-4 py-3 bg-neutral-900 border border-neutral-850 rounded-lg text-sm focus:outline-none focus:border-accent text-white">
                            <span class="text-[10px] text-neutral-500 block mt-1">Accepts JPG, JPEG, PNG, GIF, WEBP up to 5MB</span>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <button type="submit" class="px-6 py-3 rounded-lg text-sm font-semibold text-white bg-accent hover:opacity-90 transition shadow-lg shadow-accent/10">
                                <?php echo $action === 'add' ? 'Publish Project' : 'Save Changes'; ?>
                            </button>
                            <a href="projects.php" class="px-6 py-3 rounded-lg text-sm font-semibold text-neutral-400 bg-neutral-900 border border-neutral-800 hover:bg-neutral-800 transition no-underline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

            <?php elseif ($action === 'delete' && $project): ?>
                <div class="glass-card p-6 md:p-8 max-w-md border-rose-500/30">
                    <h2 class="text-xl font-bold font-outfit text-rose-400 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Delete Project?
                    </h2>
                    <p class="text-neutral-400 text-sm leading-relaxed mb-6">
                        Are you sure you want to permanently delete the project <strong>"<?php echo htmlspecialchars($project['title']); ?>"</strong>? This action cannot be undone and will delete the preview image.
                    </p>
                    <div class="flex gap-4">
                        <a href="projects.php?action=delete&id=<?php echo $project['id']; ?>&confirm=yes" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-white bg-rose-600 hover:bg-rose-500 no-underline transition text-center">
                            Yes, Confirm Delete
                        </a>
                        <a href="projects.php" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-neutral-400 bg-neutral-900 border border-neutral-800 hover:bg-neutral-800 no-underline transition text-center">
                            No, Cancel
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>
