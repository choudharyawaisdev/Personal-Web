<?php
require_once __DIR__ . '/../includes/db.php';

// If already logged in, skip login page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// Generate CSRF token
$csrf_token = get_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $token_received = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!$email || !$password) {
        $error = "Please enter both email and password.";
    } elseif (!verify_csrf_token($token_received)) {
        $error = "Security validation failed. Please try again.";
    } else {
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Password matches, log user in
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_id'] = $user['id'];
                    
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Database offline. Check setup.php.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Portfolio CMS</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B0B0F;
            color: #FFFFFF;
        }
        h1, h2 {
            font-family: 'Outfit', sans-serif;
        }
        .glass-card {
            background: rgba(22, 22, 29, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 106, 0, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .accent-glow {
            box-shadow: 0 0 40px rgba(255, 106, 0, 0.25);
        }
        .btn-accent {
            background: linear-gradient(135deg, #FF6A00 0%, #E04D00 100%);
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.4);
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            box-shadow: 0 6px 20px rgba(255, 106, 0, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-neutral-900 via-darkbg to-darkbg">
    <div class="w-full max-w-md glass-card rounded-2xl p-8 accent-glow relative">
        <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-transparent via-accent to-transparent"></div>

        <div class="text-center mb-8">
            <div class="inline-flex w-12 h-12 rounded-xl bg-gradient-to-br from-accent to-orange-600 items-center justify-center font-bold text-xl text-white shadow-lg shadow-orange-600/30 mb-4">AQ</div>
            <h1 class="text-2xl font-extrabold text-white">Admin Portal</h1>
            <p class="text-neutral-400 text-xs mt-1">Authenticate to manage portfolio settings & content</p>
        </div>

        <?php if ($error): ?>
            <div class="p-3 mb-5 rounded-lg text-xs bg-rose-950/80 text-rose-300 border border-rose-500/30">
                ✖ <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-neutral-500"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" required placeholder="chawaisdev92@gmail.com" 
                           class="w-full pl-10 pr-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:outline-none focus:border-accent transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-neutral-500"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" required placeholder="••••••••" 
                           class="w-full pl-10 pr-4 py-3 bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:outline-none focus:border-accent transition">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 btn-accent text-white font-semibold rounded-lg text-sm tracking-wide">
                    Login securely <i class="fa-solid fa-right-to-bracket ml-2 text-xs"></i>
                </button>
            </div>
        </form>

        <div class="mt-6 border-t border-neutral-800/80 pt-4 text-center">
            <a href="../index.php" class="text-xs text-neutral-500 hover:text-neutral-300 no-underline transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Main Site
            </a>
        </div>
    </div>
</body>
</html>
