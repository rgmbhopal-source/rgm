<?php
/**
 * Database Configuration File
 * Copy this file to config.php and update with your database credentials
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'business_solutions');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'Business Solutions');
define('APP_URL', 'http://localhost');
define('ADMIN_EMAIL', 'admin@businesssolutions.com');

// Email Configuration (if using SMTP)
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'noreply@businesssolutions.com');
define('SMTP_PASS', 'your-password');
define('SMTP_FROM', 'noreply@businesssolutions.com');
define('SMTP_FROM_NAME', 'Business Solutions');

// Security Configuration
define('ENABLE_CSRF', true);
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// Development/Production Mode
define('ENVIRONMENT', 'development'); // development or production

// Error Reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/logs/error.log');
}

// Timezone
date_default_timezone_set('America/New_York');

// Create PDO Connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    if (ENVIRONMENT === 'development') {
        die("Database Connection Failed: " . $e->getMessage());
    } else {
        die("Database connection error. Please contact support.");
    }
}

// Helper Functions

/**
 * Sanitize input data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (ENABLE_CSRF) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    return '';
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    if (!ENABLE_CSRF) {
        return true;
    }
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Send JSON response
 */
function json_response($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Check if user is admin
 */
function is_admin() {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}

/**
 * Require admin authentication
 */
function require_admin() {
    if (!is_admin()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Log error to file
 */
function log_error($message) {
    $log_dir = __DIR__ . '/logs';
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_file = $log_dir . '/app_' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message" . PHP_EOL;
    
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

/**
 * Send email notification
 */
function send_notification($to, $subject, $message) {
    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM . ">\r\n";
    $headers .= "Reply-To: " . SMTP_FROM . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    return mail($to, $subject, $message, $headers);
}
?>
