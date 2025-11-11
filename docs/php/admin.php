<?php
/**
 * MARIANCONNECT - Admin Authentication
 * St. Mary's College of Catbalogan
 * 
 * This file handles admin login, logout, and session management
 */

require_once 'config.php';

// Set JSON response header
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle different actions
switch ($action) {
    case 'login':
        handle_login();
        break;
    case 'logout':
        handle_logout();
        break;
    case 'check':
        check_session();
        break;
    case 'change_password':
        change_password();
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}

/**
 * Handle admin login
 */
function handle_login() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Username and password required']);
        return;
    }
    
    $username = sanitize_input($data['username']);
    $password = $data['password']; // Don't sanitize password
    
    // Query admin user
    $sql = "SELECT * FROM admin_users WHERE username = '$username' AND is_active = TRUE";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        // In production, use password_verify() with hashed passwords
        // For now, simple comparison
        if ($password === $admin['password']) {
            // Start session
            session_start();
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['login_time'] = time();
            
            // Update last login time
            $admin_id = $admin['id'];
            $update_sql = "UPDATE admin_users SET last_login = NOW() WHERE id = $admin_id";
            mysqli_query($conn, $update_sql);
            
            // Log login activity
            log_activity($admin['id'], 'login', 'Admin logged in');
            
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'admin' => [
                    'id' => $admin['id'],
                    'username' => $admin['username'],
                    'name' => $admin['full_name'],
                    'email' => $admin['email']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid password']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Admin user not found']);
    }
}

/**
 * Handle admin logout
 */
function handle_logout() {
    session_start();
    
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
        log_activity($admin_id, 'logout', 'Admin logged out');
    }
    
    // Destroy session
    session_unset();
    session_destroy();
    
    echo json_encode([
        'success' => true,
        'message' => 'Logout successful'
    ]);
}

/**
 * Check if admin session is active
 */
function check_session() {
    session_start();
    
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        // Check if session is not expired (24 hours)
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 86400)) {
            // Session expired
            session_unset();
            session_destroy();
            echo json_encode([
                'authenticated' => false,
                'message' => 'Session expired'
            ]);
        } else {
            echo json_encode([
                'authenticated' => true,
                'admin' => [
                    'id' => $_SESSION['admin_id'],
                    'username' => $_SESSION['admin_username'],
                    'name' => $_SESSION['admin_name']
                ]
            ]);
        }
    } else {
        echo json_encode([
            'authenticated' => false
        ]);
    }
}

/**
 * Change admin password
 */
function change_password() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['current_password']) || !isset($data['new_password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Current password and new password required']);
        return;
    }
    
    session_start();
    $admin_id = $_SESSION['admin_id'];
    $current_password = $data['current_password'];
    $new_password = $data['new_password'];
    
    // Verify current password
    $sql = "SELECT password FROM admin_users WHERE id = $admin_id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        if ($current_password === $admin['password']) {
            // Update password (In production, hash the password)
            $update_sql = "UPDATE admin_users SET password = '$new_password' WHERE id = $admin_id";
            
            if (mysqli_query($conn, $update_sql)) {
                log_activity($admin_id, 'password_change', 'Password changed successfully');
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Password changed successfully'
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update password']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Current password is incorrect']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Admin not found']);
    }
}

/**
 * Log admin activity
 */
function log_activity($admin_id, $action, $description) {
    global $conn;
    
    $admin_id = intval($admin_id);
    $action = sanitize_input($action);
    $description = sanitize_input($description);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $sql = "INSERT INTO admin_activity_log (admin_id, action, description, ip_address, user_agent) 
            VALUES ($admin_id, '$action', '$description', '$ip_address', '$user_agent')";
    
    mysqli_query($conn, $sql);
}

/**
 * Get admin activity logs
 */
function get_activity_logs($admin_id = null, $limit = 50) {
    global $conn;
    
    $where = $admin_id ? "WHERE admin_id = " . intval($admin_id) : "";
    $limit = intval($limit);
    
    $sql = "SELECT l.*, u.username, u.full_name 
            FROM admin_activity_log l
            LEFT JOIN admin_users u ON l.admin_id = u.id
            $where
            ORDER BY l.created_at DESC
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    $logs = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = $row;
        }
    }
    
    return $logs;
}

// Close database connection
mysqli_close($conn);
?>
