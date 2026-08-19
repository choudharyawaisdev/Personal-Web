<?php
// Centralized Admin Authentication Guard
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || empty($_SESSION['admin_id'])) {
    // Clear any invalid or partial session data
    unset($_SESSION['admin_logged_in'], $_SESSION['admin_id'], $_SESSION['admin_email'], $_SESSION['admin_username']);
    header("Location: login.php");
    exit;
}
