<?php
require_once __DIR__ . '/auth_check.php';

$error = "";
$success = "";
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle Mark Read / Unread / Delete Actions
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($action === 'read') {
        try {
            $stmt = $pdo->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = "Message marked as read.";
            header("Location: messages.php");
            exit;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } elseif ($action === 'unread') {
        try {
            $stmt = $pdo->prepare("UPDATE messages SET status = 'unread' WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_success'] = "Message marked as unread.";
            header("Location: messages.php");
            exit;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } elseif ($action === 'delete') {
        // Double check confirmation
        $confirm = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';
        if ($confirm) {
            try {
                $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
                $stmt->execute([$id]);
                $_SESSION['flash_success'] = "Message deleted successfully.";
                header("Location: messages.php");
                exit;
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Flush alerts
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}

// Fetch all messages
$messages = [];
try {
    $messages = $pdo->query("SELECT * FROM messages ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $error = "Error loading inbox: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages Inbox | Awais Qarni</title>
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
                <a href="messages.php" class="admin-sidebar-link active">
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
                    <h1 class="text-3xl font-extrabold font-outfit m-0">Contact Inbox</h1>
                    <p class="text-neutral-400 text-xs mt-1">Review user messages and portfolio inquiries</p>
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
            <?php if ($action === 'delete' && isset($_GET['id']) && !isset($_GET['confirm'])): ?>
                <div class="glass-card p-6 md:p-8 max-w-md border-rose-500/30 mb-8">
                    <h2 class="text-xl font-bold font-outfit text-rose-400 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-trash-can"></i> Delete Message?
                    </h2>
                    <p class="text-neutral-400 text-sm leading-relaxed mb-6">
                        Are you sure you want to delete this message? This action is permanent.
                    </p>
                    <div class="flex gap-4">
                        <a href="messages.php?action=delete&id=<?php echo $id; ?>&confirm=yes" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-white bg-rose-600 hover:bg-rose-500 no-underline transition text-center">
                            Delete
                        </a>
                        <a href="messages.php" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-neutral-400 bg-neutral-900 border border-neutral-800 no-underline transition text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <?php if (empty($messages)): ?>
                    <div class="glass-card p-8 text-center text-neutral-500">
                        <i class="fa-solid fa-tray text-5xl mb-4 text-neutral-700 block"></i>
                        No contact submissions received yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <div class="glass-card p-5 md:p-6 transition duration-200 <?php echo $msg['status'] === 'unread' ? 'border-accent/30 bg-accent/[0.02]' : 'border-neutral-900/60'; ?>">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-neutral-900/40">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-base font-bold font-outfit text-white m-0"><?php echo htmlspecialchars($msg['name']); ?></h3>
                                        <?php if ($msg['status'] === 'unread'): ?>
                                            <span class="px-2 py-0.5 text-[9px] font-bold bg-accent/25 text-accent rounded border border-accent/20">NEW</span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="text-xs text-neutral-400 hover:text-accent transition no-underline block mt-1">
                                        <i class="fa-regular fa-envelope mr-1"></i> <?php echo htmlspecialchars($msg['email']); ?>
                                    </a>
                                </div>
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="text-neutral-500"><i class="fa-regular fa-clock mr-1"></i> <?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></span>
                                    
                                    <div class="flex gap-2">
                                        <?php if ($msg['status'] === 'unread'): ?>
                                            <a href="messages.php?action=read&id=<?php echo $msg['id']; ?>" class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-850 hover:border-accent text-neutral-400 hover:text-white transition no-underline" title="Mark as Read">
                                                <i class="fa-solid fa-check text-xs"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="messages.php?action=unread&id=<?php echo $msg['id']; ?>" class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-850 hover:border-accent text-neutral-500 hover:text-white transition no-underline" title="Mark as Unread">
                                                <i class="fa-solid fa-envelope-open text-xs"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="messages.php?action=delete&id=<?php echo $msg['id']; ?>" class="px-2.5 py-1 rounded bg-neutral-900 border border-neutral-850 hover:border-rose-500 text-neutral-500 hover:text-rose-400 transition no-underline" title="Delete">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Message Content -->
                            <p class="text-sm text-neutral-300 leading-relaxed m-0 whitespace-pre-wrap"><?php echo htmlspecialchars($msg['message']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

</body>
</html>
