<?php
require_once __DIR__ . '/auth_check.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = "";
$success = "";
$blog = null;

// CSRF token
$csrf_token = get_csrf_token();

// Fetch blog for Edit/Delete mode
if (($action === 'edit' || $action === 'delete') && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
        if (!$blog && $action !== 'delete') {
            header("Location: blogs.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Add / Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    $title = sanitize_input($_POST['title']);
    $slug = sanitize_input($_POST['slug']);
    $content = $_POST['content']; // HTML content from editor (will be sanitized partially or handled raw for rich-text)
    $token_received = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    // Standard slug formatting check
    $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(str_replace(' ', '-', $slug)));

    if (!verify_csrf_token($token_received)) {
        $error = "Security verification failed. Please try again.";
    } elseif (empty($title) || empty($slug) || empty($content)) {
        $error = "Title, Slug and Content fields are required.";
    } else {
        $image_name = $blog ? $blog['image'] : ''; // Default to old image
        
        // Handle Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_orig_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $file_ext = strtolower(pathinfo($file_orig_name, PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_exts)) {
                $error = "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
            } elseif ($file_size > 5 * 1024 * 1024) {
                $error = "File size exceeds limit of 5MB.";
            } else {
                $image_name = time() . '_blog_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                $upload_dir = __DIR__ . '/../uploads/projects/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                if (move_uploaded_file($file_tmp, $upload_dir . $image_name)) {
                    if ($action === 'edit' && !empty($blog['image']) && file_exists($upload_dir . $blog['image'])) {
                        @unlink($upload_dir . $blog['image']);
                    }
                } else {
                    $error = "Failed to upload image. Please check directory permissions.";
                }
            }
        } elseif ($action === 'add') {
            $error = "Please upload a featured image.";
        }

        // Save if no error
        if (empty($error)) {
            try {
                // Check for unique slug
                $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM blogs WHERE slug = ? AND id != ?");
                $check_stmt->execute([$slug, $blog ? $blog['id'] : 0]);
                if ($check_stmt->fetchColumn() > 0) {
                    $slug .= '-' . time(); // Append unique string
                }

                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, image) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$title, $slug, $content, $image_name]);
                    $_SESSION['flash_success'] = "Blog post published successfully!";
                    header("Location: blogs.php");
                    exit;
                } else {
                    $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, image = ? WHERE id = ?");
                    $stmt->execute([$title, $slug, $content, $image_name, $id]);
                    $_SESSION['flash_success'] = "Blog post updated successfully!";
                    header("Location: blogs.php");
                    exit;
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Handle Delete Action
if ($action === 'delete' && $blog) {
    $confirm = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';
    if ($confirm) {
        try {
            $upload_dir = __DIR__ . '/../uploads/projects/';
            if (!empty($blog['image']) && file_exists($upload_dir . $blog['image'])) {
                @unlink($upload_dir . $blog['image']);
            }
            $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = "Blog post deleted successfully!";
            header("Location: blogs.php");
            exit;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Flush success messages
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}

// Fetch all blogs for list view
$blogs = [];
if ($action === 'list') {
    try {
        $blogs = $pdo->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
    } catch (PDOException $e) {
        $error = "Error fetching blogs: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs Manager | Awais Qarni</title>
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
    <!-- Quill Rich Text Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            background-color: #1a1a24;
            border-color: rgba(255, 106, 0, 0.15) !important;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .ql-container.ql-snow {
            border-color: rgba(255, 106, 0, 0.15) !important;
            background-color: rgba(0, 0, 0, 0.15);
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            color: #FFFFFF;
            min-height: 200px;
        }
        .ql-snow .ql-stroke {
            stroke: #94A3B8;
        }
        .ql-snow .ql-fill {
            fill: #94A3B8;
        }
        .ql-snow .ql-picker {
            color: #94A3B8;
        }
    </style>
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
                <a href="blogs.php" class="admin-sidebar-link active">
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
                    <h1 class="text-3xl font-extrabold font-outfit m-0">Blogs Manager</h1>
                    <p class="text-neutral-400 text-xs mt-1">Write, format, and publish technological blogs</p>
                </div>
                <div class="flex gap-3">
                    <?php if ($action !== 'list'): ?>
                        <a href="blogs.php" class="px-4 py-2 rounded-lg text-xs font-bold text-neutral-400 bg-neutral-900 hover:bg-neutral-800 no-underline transition border border-neutral-800">
                            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to List
                        </a>
                    <?php else: ?>
                        <a href="blogs.php?action=add" class="px-4 py-2 rounded-lg text-xs font-bold text-white bg-accent hover:opacity-90 no-underline transition shadow-lg shadow-accent/20">
                            <i class="fa-solid fa-plus mr-1.5"></i> Create Post
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
                                    <th class="py-3 px-4 border-0">Slug</th>
                                    <th class="py-3 px-4 border-0">Date Published</th>
                                    <th class="py-3 px-4 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($blogs)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-neutral-500 py-10">No blogs published yet. Click Create Post to start!</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($blogs as $post): ?>
                                        <tr class="border-b border-neutral-900/40">
                                            <td class="py-3 px-4 border-0">
                                                <?php 
                                                $img_path = '../uploads/projects/' . $post['image'];
                                                if (!empty($post['image']) && file_exists($img_path)): 
                                                ?>
                                                    <img src="<?php echo $img_path; ?>" alt="" class="w-12 h-8 object-cover rounded border border-neutral-800">
                                                <?php else: ?>
                                                    <div class="w-12 h-8 bg-neutral-900 rounded flex items-center justify-center text-neutral-700"><i class="fa-regular fa-newspaper text-xs"></i></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-4 border-0 font-bold text-white"><?php echo htmlspecialchars($post['title']); ?></td>
                                            <td class="py-3 px-4 border-0 text-neutral-400 text-xs"><?php echo htmlspecialchars($post['slug']); ?></td>
                                            <td class="py-3 px-4 border-0 text-neutral-500"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                                            <td class="py-3 px-4 border-0 text-end">
                                                <div class="inline-flex gap-2">
                                                    <a href="blogs.php?action=edit&id=<?php echo $post['id']; ?>" class="w-8 h-8 rounded bg-neutral-900 border border-neutral-800 hover:border-accent flex items-center justify-center text-neutral-400 hover:text-accent transition no-underline" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="blogs.php?action=delete&id=<?php echo $post['id']; ?>" class="w-8 h-8 rounded bg-neutral-900 border border-neutral-800 hover:border-rose-500 flex items-center justify-center text-neutral-400 hover:text-rose-400 transition no-underline" title="Delete"><i class="fa-regular fa-trash-can"></i></a>
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
                <div class="glass-card p-6 md:p-8">
                    <h2 class="text-xl font-bold font-outfit text-white mb-6"><?php echo $action === 'add' ? 'Publish Blog Post' : 'Edit Blog Post'; ?></h2>
                    
                    <form id="blog-form" method="POST" action="blogs.php?action=<?php echo $action; ?><?php echo $action === 'edit' ? '&id='.$id : ''; ?>" enctype="multipart/form-data" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Blog Title</label>
                                <input type="text" id="blog-title" name="title" required value="<?php echo $blog ? htmlspecialchars($blog['title']) : ''; ?>" placeholder="Building Portfolios with PHP"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">SEO Friendly URL Slug</label>
                                <input type="text" id="blog-slug" name="slug" required value="<?php echo $blog ? htmlspecialchars($blog['slug']) : ''; ?>" placeholder="building-portfolios-php"
                                       class="w-full px-4 py-3 form-input-custom rounded-lg text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Blog Content (Rich Text Editor)</label>
                            <!-- Hidden textarea to pass content -->
                            <textarea name="content" id="blog-content-hidden" class="hidden"></textarea>
                            <!-- Quill editor -->
                            <div id="editor-container"><?php echo $blog ? $blog['content'] : ''; ?></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Featured Image</label>
                            <?php if ($blog && !empty($blog['image'])): ?>
                                <div class="mb-3 flex items-center gap-4">
                                    <img src="../uploads/projects/<?php echo $blog['image']; ?>" alt="" class="w-24 h-16 object-cover rounded border border-neutral-800">
                                    <span class="text-xs text-neutral-500">Current image on server</span>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" <?php echo $action === 'add' ? 'required' : ''; ?> accept="image/*"
                                   class="w-full px-4 py-3 bg-neutral-900 border border-neutral-850 rounded-lg text-sm focus:outline-none focus:border-accent text-white">
                            <span class="text-[10px] text-neutral-500 block mt-1">Accepts JPG, JPEG, PNG, GIF, WEBP up to 5MB</span>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <button type="submit" class="px-6 py-3 rounded-lg text-sm font-semibold text-white bg-accent hover:opacity-90 transition shadow-lg shadow-accent/10">
                                <?php echo $action === 'add' ? 'Publish Post' : 'Save Changes'; ?>
                            </button>
                            <a href="blogs.php" class="px-6 py-3 rounded-lg text-sm font-semibold text-neutral-400 bg-neutral-900 border border-neutral-800 hover:bg-neutral-800 transition no-underline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

            <?php elseif ($action === 'delete' && $blog): ?>
                <div class="glass-card p-6 md:p-8 max-w-md border-rose-500/30">
                    <h2 class="text-xl font-bold font-outfit text-rose-400 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Delete Post?
                    </h2>
                    <p class="text-neutral-400 text-sm leading-relaxed mb-6">
                        Are you sure you want to permanently delete the blog post <strong>"<?php echo htmlspecialchars($blog['title']); ?>"</strong>? This action cannot be undone.
                    </p>
                    <div class="flex gap-4">
                        <a href="blogs.php?action=delete&id=<?php echo $blog['id']; ?>&confirm=yes" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-white bg-rose-600 hover:bg-rose-500 no-underline transition text-center">
                            Yes, Confirm Delete
                        </a>
                        <a href="blogs.php" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-neutral-400 bg-neutral-900 border border-neutral-800 hover:bg-neutral-800 no-underline transition text-center">
                            No, Cancel
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Quill Rich Text Editor Script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Slug Auto-generation
            const titleInput = document.getElementById('blog-title');
            const slugInput = document.getElementById('blog-slug');
            
            if (titleInput && slugInput) {
                titleInput.addEventListener('keyup', () => {
                    // Convert title to lowercased slug
                    let text = titleInput.value.toLowerCase();
                    text = text.replace(/[^a-z0-9\s\-]/g, ''); // Remove special characters
                    text = text.replace(/\s+/g, '-');          // Convert spaces to hyphens
                    text = text.replace(/-+/g, '-');            // Remove duplicate hyphens
                    slugInput.value = text;
                });
            }

            // Quill Editor Setup
            const editorDiv = document.getElementById('editor-container');
            const hiddenTextarea = document.getElementById('blog-content-hidden');
            const blogForm = document.getElementById('blog-form');

            if (editorDiv && hiddenTextarea && blogForm) {
                const quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });

                // Sync Quill editor html content with hidden textarea on submit
                blogForm.addEventListener('submit', (e) => {
                    const editorHtml = quill.root.innerHTML;
                    if (quill.getText().trim().length === 0) {
                        alert('Blog content cannot be empty.');
                        e.preventDefault();
                        return;
                    }
                    hiddenTextarea.value = editorHtml;
                });
            }
        });
    </script>
</body>
</html>
