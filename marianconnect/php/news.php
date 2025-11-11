<?php
/**
 * MARIANCONNECT - News Management API
 * St. Mary's College of Catbalogan
 * 
 * This file handles all news-related operations (CRUD)
 */

require_once 'config.php';

// Set JSON response header
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different request methods
switch ($method) {
    case 'GET':
        get_news();
        break;
    case 'POST':
        add_news();
        break;
    case 'PUT':
        update_news();
        break;
    case 'DELETE':
        delete_news();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

/**
 * Get all news or specific news by ID
 */
function get_news() {
    global $conn;
    
    $news_id = isset($_GET['id']) ? intval($_GET['id']) : null;
    
    if ($news_id) {
        // Get specific news
        $sql = "SELECT * FROM news WHERE id = $news_id";
    } else {
        // Get all news, ordered by date DESC
        $sql = "SELECT * FROM news ORDER BY date DESC";
    }
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $news = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $news[] = $row;
        }
        
        if ($news_id && count($news) > 0) {
            echo json_encode($news[0]);
        } else {
            echo json_encode($news);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Add new news
 */
function add_news() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (!isset($data['title']) || !isset($data['date']) || !isset($data['category']) || 
        !isset($data['excerpt']) || !isset($data['content'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }
    
    // Sanitize inputs
    $title = sanitize_input($data['title']);
    $date = sanitize_input($data['date']);
    $category = sanitize_input($data['category']);
    $excerpt = sanitize_input($data['excerpt']);
    $content = sanitize_input($data['content']);
    
    // Insert into database
    $sql = "INSERT INTO news (title, date, category, excerpt, content, created_at) 
            VALUES ('$title', '$date', '$category', '$excerpt', '$content', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        $new_id = mysqli_insert_id($conn);
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'News added successfully',
            'id' => $new_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Update existing news
 */
function update_news() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    // Get PUT data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'News ID is required']);
        return;
    }
    
    $id = intval($data['id']);
    
    // Build update query dynamically
    $updates = [];
    if (isset($data['title'])) {
        $title = sanitize_input($data['title']);
        $updates[] = "title = '$title'";
    }
    if (isset($data['date'])) {
        $date = sanitize_input($data['date']);
        $updates[] = "date = '$date'";
    }
    if (isset($data['category'])) {
        $category = sanitize_input($data['category']);
        $updates[] = "category = '$category'";
    }
    if (isset($data['excerpt'])) {
        $excerpt = sanitize_input($data['excerpt']);
        $updates[] = "excerpt = '$excerpt'";
    }
    if (isset($data['content'])) {
        $content = sanitize_input($data['content']);
        $updates[] = "content = '$content'";
    }
    
    if (empty($updates)) {
        http_response_code(400);
        echo json_encode(['error' => 'No fields to update']);
        return;
    }
    
    $updates[] = "updated_at = NOW()";
    $update_string = implode(', ', $updates);
    
    $sql = "UPDATE news SET $update_string WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'News updated successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No changes made or news not found'
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Delete news
 */
function delete_news() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    // Get DELETE data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'News ID is required']);
        return;
    }
    
    $id = intval($data['id']);
    
    $sql = "DELETE FROM news WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'News deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'News not found']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

// Close database connection
mysqli_close($conn);
?>
