<?php
/**
 * MARIANCONNECT - Database Configuration
 * St. Mary's College of Catbalogan
 * 
 * This file contains database connection settings
 * Make sure to update these values according to your XAMPP setup
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'marianconnect_db');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Timezone setting
date_default_timezone_set('Asia/Manila');

/**
 * Function to sanitize input data
 */
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

/**
 * Function to format date
 */
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Function to check if user is admin (simple authentication)
 * In production, implement proper session-based authentication
 */
function is_admin_logged_in() {
    session_start();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Function to admin login
 */
function admin_login($password) {
    // Simple password check (In production, use hashed passwords)
    $admin_password = 'admin123';
    
    if ($password === $admin_password) {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_login_time'] = time();
        return true;
    }
    return false;
}

/**
 * Function to admin logout
 */
function admin_logout() {
    session_start();
    session_unset();
    session_destroy();
}
