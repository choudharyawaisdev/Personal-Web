<?php
require_once __DIR__ . '/../includes/db.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit;
