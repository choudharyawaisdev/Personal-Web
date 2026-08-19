<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'devtasoft_portfolio');
if (!defined('DB_PASS')) define('DB_PASS', 'devtasoft_portfolio');
if (!defined('DB_NAME')) define('DB_NAME', 'devtasoft_portfolio');

$pdo = null;
$db_error = null;

try {
    $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
    // Connect to MySQL server first (without DB name) to see if server is online
    $pdo_init = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Check if database exists
    $stmt = $pdo_init->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
    $stmt->execute([DB_NAME]);
    if ($stmt->fetch()) {
        // Database exists, connect directly to it
        $pdo = new PDO($dsn . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } else {
        $db_error = "Database '" . DB_NAME . "' does not exist. Please run setup.php to create it.";
    }
} catch (PDOException $e) {
    $db_error = "Connection failed: " . $e->getMessage();
}

// Security Helper: CSRF Token Generator and Validator
function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

// Security Helper: Input Sanitization
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
?>
