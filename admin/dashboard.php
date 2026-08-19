<?php
require_once __DIR__ . '/auth_check.php';

// Counts and Stats
$project_count = 0;
$blog_count = 0;
$message_count = 0;
$unread_msg_count = 0;
$recent_messages = [];

if ($pdo) {
    try {
        $project_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $blog_count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
        $message_count = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
        $unread_msg_count = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'unread'")->fetchColumn();
        
        $stmt_msg = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 5");
        $recent_messages = $stmt_msg->fetchAll();
    } catch (PDOException $e) {
        // Handle gracefully
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard | Awais Qarni</title>
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
                <a href="dashboard.php" class="admin-sidebar-link active">
                    <i class="fa-solid fa-chart-pie text-sm"></i> Dashboard
                </a>
                <a href="projects.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-briefcase text-sm"></i> Projects CRUD
                </a>
                <a href="blogs.php" class="admin-sidebar-link">
                    <i class="fa-solid fa-newspaper text-sm"></i> Blogs CRUD
                </a>
                <a href="messages.php" class="admin-sidebar-link relative">
                    <i class="fa-solid fa-envelope text-sm"></i> Inbox
                    <?php if ($unread_msg_count > 0): ?>
                        <span class="absolute right-4 bg-accent text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?php echo $unread_msg_count; ?></span>
                    <?php endif; ?>
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

        <!-- Main Dashboard Viewport -->
        <main class="flex-grow p-6 md:p-10">
            <!-- Header row -->
            <header class="flex items-center justify-between mb-8 pb-6 border-b border-neutral-900/60">
                <div>
                    <h1 class="text-3xl font-extrabold font-outfit m-0">Dashboard</h1>
                    <p class="text-neutral-400 text-xs mt-1">Hello, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? $_SESSION['admin_email'] ?? 'Admin'); ?>. Welcome back.</p>
                </div>
                <!-- Mini mobile logout link -->
                <div class="flex items-center gap-4 md:hidden">
                    <a href="logout.php" class="text-rose-400 text-sm no-underline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </header>

            <!-- Quick Statistics Cards -->
            <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <div class="glass-card p-6 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider block mb-1">Total Projects</span>
                        <span class="text-3xl font-extrabold font-outfit text-white"><?php echo $project_count; ?></span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-accent/10 border border-accent/20 flex items-center justify-center text-accent text-xl">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>

                <div class="glass-card p-6 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider block mb-1">Total Blogs</span>
                        <span class="text-3xl font-extrabold font-outfit text-white"><?php echo $blog_count; ?></span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-xl">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                </div>

                <div class="glass-card p-6 flex items-center justify-between relative">
                    <div>
                        <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider block mb-1">Inbox Messages</span>
                        <span class="text-3xl font-extrabold font-outfit text-white">
                            <?php echo $message_count; ?>
                            <?php if ($unread_msg_count > 0): ?>
                                <span class="text-xs text-accent font-semibold ml-1.5">(<?php echo $unread_msg_count; ?> unread)</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-xl">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>
            </section>

            <!-- Quick Navigation Shortcuts (Mobile / Utility fallback) -->
            <section class="md:hidden glass-card p-6 mb-8 grid grid-cols-2 gap-3">
                <a href="projects.php" class="p-3 bg-neutral-900/60 rounded-xl text-xs font-bold text-center border border-neutral-800 no-underline text-white block">
                    <i class="fa-solid fa-briefcase text-accent text-lg mb-1 block"></i> Projects
                </a>
                <a href="blogs.php" class="p-3 bg-neutral-900/60 rounded-xl text-xs font-bold text-center border border-neutral-800 no-underline text-white block">
                    <i class="fa-solid fa-newspaper text-blue-400 text-lg mb-1 block"></i> Blogs
                </a>
                <a href="messages.php" class="p-3 bg-neutral-900/60 rounded-xl text-xs font-bold text-center border border-neutral-800 no-underline text-white block">
                    <i class="fa-solid fa-envelope text-emerald-400 text-lg mb-1 block"></i> Inbox
                </a>
                <a href="settings.php" class="p-3 bg-neutral-900/60 rounded-xl text-xs font-bold text-center border border-neutral-800 no-underline text-white block">
                    <i class="fa-solid fa-sliders text-neutral-400 text-lg mb-1 block"></i> Settings
                </a>
            </section>

            <!-- Recent Messages List -->
            <section class="glass-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-neutral-900/60">
                    <h2 class="text-xl font-bold font-outfit text-white m-0">Recent Inbox Messages</h2>
                    <a href="messages.php" class="text-xs text-accent font-semibold hover:underline no-underline">See All Inbox</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle text-sm border-0 m-0">
                        <thead>
                            <tr class="border-b border-neutral-900 text-neutral-500 uppercase tracking-wider text-xs">
                                <th class="py-3 px-4 border-0">Sender</th>
                                <th class="py-3 px-4 border-0">Email</th>
                                <th class="py-3 px-4 border-0">Snippet</th>
                                <th class="py-3 px-4 border-0">Status</th>
                                <th class="py-3 px-4 border-0 text-end">Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_messages)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-neutral-500 py-10">No messages received yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_messages as $msg): ?>
                                    <tr class="border-b border-neutral-900/40 hover:bg-neutral-900/30">
                                        <td class="py-3.5 px-4 font-bold text-white"><?php echo htmlspecialchars($msg['name']); ?></td>
                                        <td class="py-3.5 px-4 text-neutral-400"><?php echo htmlspecialchars($msg['email']); ?></td>
                                        <td class="py-3.5 px-4 text-neutral-400 max-w-xs truncate">
                                            <?php echo htmlspecialchars($msg['message']); ?>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <?php if ($msg['status'] === 'unread'): ?>
                                                <span class="px-2 py-0.5 text-[10px] font-bold bg-accent/25 text-accent rounded border border-accent/20">UNREAD</span>
                                            <?php else: ?>
                                                <span class="px-2 py-0.5 text-[10px] font-bold bg-neutral-800 text-neutral-500 rounded">READ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-neutral-500 text-end"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

</body>
</html>
