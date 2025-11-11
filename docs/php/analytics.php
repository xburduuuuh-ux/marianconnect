<?php
/**
 * MARIANCONNECT - Website Analytics
 * St. Mary's College of Catbalogan
 * 
 * This file handles website analytics tracking and reporting
 */

require_once 'config.php';

// Set JSON response header
header('Content-Type: application/json');

// Get request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle different actions
switch ($action) {
    case 'track':
        track_visit();
        break;
    case 'stats':
        get_statistics();
        break;
    case 'popular':
        get_popular_pages();
        break;
    case 'daily':
        get_daily_stats();
        break;
    case 'monthly':
        get_monthly_stats();
        break;
    case 'recent':
        get_recent_visits();
        break;
    default:
        get_dashboard();
        break;
}

/**
 * Track a page visit
 */
function track_visit() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Get visitor information
    $page_url = isset($data['page_url']) ? sanitize_input($data['page_url']) : '';
    $page_title = isset($data['page_title']) ? sanitize_input($data['page_title']) : '';
    $referrer = isset($_SERVER['HTTP_REFERER']) ? sanitize_input($_SERVER['HTTP_REFERER']) : 'Direct';
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $visit_date = date('Y-m-d');
    $visit_time = date('H:i:s');
    
    // Insert analytics data
    $sql = "INSERT INTO analytics 
            (page_url, page_title, referrer, visitor_ip, user_agent, visit_date, visit_time) 
            VALUES 
            ('$page_url', '$page_title', '$referrer', '$visitor_ip', '$user_agent', '$visit_date', '$visit_time')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Visit tracked successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to track visit: ' . mysqli_error($conn)]);
    }
}

/**
 * Get overall statistics
 */
function get_statistics() {
    global $conn;
    
    // Total visits
    $total_visits_query = "SELECT COUNT(*) as total FROM analytics";
    $total_visits = mysqli_fetch_assoc(mysqli_query($conn, $total_visits_query))['total'];
    
    // Unique visitors
    $unique_visitors_query = "SELECT COUNT(DISTINCT visitor_ip) as unique_count FROM analytics";
    $unique_visitors = mysqli_fetch_assoc(mysqli_query($conn, $unique_visitors_query))['unique_count'];
    
    // Today's visits
    $today = date('Y-m-d');
    $today_visits_query = "SELECT COUNT(*) as today_count FROM analytics WHERE visit_date = '$today'";
    $today_visits = mysqli_fetch_assoc(mysqli_query($conn, $today_visits_query))['today_count'];
    
    // This week's visits
    $week_start = date('Y-m-d', strtotime('monday this week'));
    $week_visits_query = "SELECT COUNT(*) as week_count FROM analytics WHERE visit_date >= '$week_start'";
    $week_visits = mysqli_fetch_assoc(mysqli_query($conn, $week_visits_query))['week_count'];
    
    // This month's visits
    $month_start = date('Y-m-01');
    $month_visits_query = "SELECT COUNT(*) as month_count FROM analytics WHERE visit_date >= '$month_start'";
    $month_visits = mysqli_fetch_assoc(mysqli_query($conn, $month_visits_query))['month_count'];
    
    // Most visited page
    $popular_page_query = "SELECT page_url, page_title, COUNT(*) as visit_count 
                           FROM analytics 
                           GROUP BY page_url, page_title 
                           ORDER BY visit_count DESC 
                           LIMIT 1";
    $popular_page_result = mysqli_query($conn, $popular_page_query);
    $popular_page = mysqli_fetch_assoc($popular_page_result);
    
    // Top referrers
    $referrers_query = "SELECT referrer, COUNT(*) as count 
                        FROM analytics 
                        WHERE referrer != 'Direct'
                        GROUP BY referrer 
                        ORDER BY count DESC 
                        LIMIT 5";
    $referrers_result = mysqli_query($conn, $referrers_query);
    $top_referrers = [];
    while ($row = mysqli_fetch_assoc($referrers_result)) {
        $top_referrers[] = $row;
    }
    
    echo json_encode([
        'total_visits' => $total_visits,
        'unique_visitors' => $unique_visitors,
        'today_visits' => $today_visits,
        'week_visits' => $week_visits,
        'month_visits' => $month_visits,
        'popular_page' => $popular_page,
        'top_referrers' => $top_referrers
    ]);
}

/**
 * Get popular pages
 */
function get_popular_pages() {
    global $conn;
    
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    
    $sql = "SELECT 
                page_url,
                page_title,
                COUNT(*) as visit_count,
                COUNT(DISTINCT visitor_ip) as unique_visitors,
                MAX(visit_date) as last_visit
            FROM analytics
            GROUP BY page_url, page_title
            ORDER BY visit_count DESC
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    $pages = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pages[] = $row;
        }
        echo json_encode($pages);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Get daily statistics for the last 30 days
 */
function get_daily_stats() {
    global $conn;
    
    $days = isset($_GET['days']) ? intval($_GET['days']) : 30;
    
    $sql = "SELECT 
                visit_date,
                COUNT(*) as visits,
                COUNT(DISTINCT visitor_ip) as unique_visitors
            FROM analytics
            WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL $days DAY)
            GROUP BY visit_date
            ORDER BY visit_date ASC";
    
    $result = mysqli_query($conn, $sql);
    $daily_stats = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daily_stats[] = [
                'date' => $row['visit_date'],
                'visits' => intval($row['visits']),
                'unique_visitors' => intval($row['unique_visitors'])
            ];
        }
        echo json_encode($daily_stats);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Get monthly statistics
 */
function get_monthly_stats() {
    global $conn;
    
    $months = isset($_GET['months']) ? intval($_GET['months']) : 12;
    
    $sql = "SELECT 
                DATE_FORMAT(visit_date, '%Y-%m') as month,
                COUNT(*) as visits,
                COUNT(DISTINCT visitor_ip) as unique_visitors
            FROM analytics
            WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL $months MONTH)
            GROUP BY month
            ORDER BY month ASC";
    
    $result = mysqli_query($conn, $sql);
    $monthly_stats = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $monthly_stats[] = [
                'month' => $row['month'],
                'visits' => intval($row['visits']),
                'unique_visitors' => intval($row['unique_visitors'])
            ];
        }
        echo json_encode($monthly_stats);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Get recent visits
 */
function get_recent_visits() {
    global $conn;
    
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    
    $sql = "SELECT 
                page_url,
                page_title,
                referrer,
                visitor_ip,
                visit_date,
                visit_time,
                created_at
            FROM analytics
            ORDER BY created_at DESC
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    $recent_visits = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Mask IP for privacy (show only first 3 octets)
            $ip_parts = explode('.', $row['visitor_ip']);
            $row['visitor_ip_masked'] = $ip_parts[0] . '.' . $ip_parts[1] . '.' . $ip_parts[2] . '.xxx';
            unset($row['visitor_ip']);
            
            $recent_visits[] = $row;
        }
        echo json_encode($recent_visits);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}

/**
 * Get analytics dashboard data
 */
function get_dashboard() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    $dashboard_data = [];
    
    // Overall stats
    $stats_query = "SELECT 
                        COUNT(*) as total_visits,
                        COUNT(DISTINCT visitor_ip) as unique_visitors,
                        COUNT(DISTINCT visit_date) as days_tracked
                    FROM analytics";
    $stats_result = mysqli_query($conn, $stats_query);
    $dashboard_data['overall'] = mysqli_fetch_assoc($stats_result);
    
    // Today's stats
    $today = date('Y-m-d');
    $today_query = "SELECT 
                        COUNT(*) as visits,
                        COUNT(DISTINCT visitor_ip) as unique_visitors
                    FROM analytics 
                    WHERE visit_date = '$today'";
    $today_result = mysqli_query($conn, $today_query);
    $dashboard_data['today'] = mysqli_fetch_assoc($today_result);
    
    // Top 5 pages
    $top_pages_query = "SELECT 
                            page_title,
                            page_url,
                            COUNT(*) as visits
                        FROM analytics
                        GROUP BY page_url, page_title
                        ORDER BY visits DESC
                        LIMIT 5";
    $top_pages_result = mysqli_query($conn, $top_pages_query);
    $dashboard_data['top_pages'] = [];
    while ($row = mysqli_fetch_assoc($top_pages_result)) {
        $dashboard_data['top_pages'][] = $row;
    }
    
    // Last 7 days trend
    $trend_query = "SELECT 
                        visit_date,
                        COUNT(*) as visits
                    FROM analytics
                    WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY visit_date
                    ORDER BY visit_date ASC";
    $trend_result = mysqli_query($conn, $trend_query);
    $dashboard_data['weekly_trend'] = [];
    while ($row = mysqli_fetch_assoc($trend_result)) {
        $dashboard_data['weekly_trend'][] = $row;
    }
    
    // Hourly distribution (today)
    $hourly_query = "SELECT 
                        HOUR(visit_time) as hour,
                        COUNT(*) as visits
                    FROM analytics
                    WHERE visit_date = '$today'
                    GROUP BY hour
                    ORDER BY hour ASC";
    $hourly_result = mysqli_query($conn, $hourly_query);
    $dashboard_data['hourly_distribution'] = [];
    while ($row = mysqli_fetch_assoc($hourly_result)) {
        $dashboard_data['hourly_distribution'][] = $row;
    }
    
    // Top referrers
    $referrers_query = "SELECT 
                            referrer,
                            COUNT(*) as visits
                        FROM analytics
                        WHERE referrer != 'Direct'
                        GROUP BY referrer
                        ORDER BY visits DESC
                        LIMIT 5";
    $referrers_result = mysqli_query($conn, $referrers_query);
    $dashboard_data['top_referrers'] = [];
    while ($row = mysqli_fetch_assoc($referrers_result)) {
        $dashboard_data['top_referrers'][] = $row;
    }
    
    echo json_encode($dashboard_data);
}

/**
 * Get browser statistics (from user agent)
 */
function get_browser_stats() {
    global $conn;
    
    $sql = "SELECT user_agent FROM analytics";
    $result = mysqli_query($conn, $sql);
    
    $browsers = [
        'Chrome' => 0,
        'Firefox' => 0,
        'Safari' => 0,
        'Edge' => 0,
        'Opera' => 0,
        'Other' => 0
    ];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $ua = $row['user_agent'];
        if (stripos($ua, 'Chrome') !== false && stripos($ua, 'Edge') === false) {
            $browsers['Chrome']++;
        } elseif (stripos($ua, 'Firefox') !== false) {
            $browsers['Firefox']++;
        } elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) {
            $browsers['Safari']++;
        } elseif (stripos($ua, 'Edge') !== false) {
            $browsers['Edge']++;
        } elseif (stripos($ua, 'Opera') !== false || stripos($ua, 'OPR') !== false) {
            $browsers['Opera']++;
        } else {
            $browsers['Other']++;
        }
    }
    
    echo json_encode($browsers);
}

/**
 * Clear old analytics data (optional - for maintenance)
 */
function clean_old_data() {
    global $conn;
    
    // Check if admin is logged in
    if (!is_admin_logged_in()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    
    // Delete data older than 1 year
    $sql = "DELETE FROM analytics WHERE visit_date < DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
    
    if (mysqli_query($conn, $sql)) {
        $deleted_rows = mysqli_affected_rows($conn);
        echo json_encode([
            'success' => true,
            'message' => "$deleted_rows old records deleted",
            'deleted_rows' => $deleted_rows
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to clean data: ' . mysqli_error($conn)]);
    }
}

// Close database connection
mysqli_close($conn);
?>
