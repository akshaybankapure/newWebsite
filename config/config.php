<?php
// Determine if we're in development mode
$is_dev = $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1';

// Load development settings if in development mode
if ($is_dev) {
    require_once __DIR__ . '/dev.php';
} else {
    // Production settings
    define('DEBUG_MODE', false);
    define('ERROR_REPORTING', 0);
    define('DISPLAY_ERRORS', false);
    
    // Database settings
    define('DB_HOST', 'your_production_host');
    define('DB_NAME', 'your_production_db');
    define('DB_USER', 'your_production_user');
    define('DB_PASS', 'your_production_password');
    
    // Site settings
    define('SITE_URL', 'https://your-production-domain.com');
    define('SITE_TITLE', 'Your Site Title');
    define('UPLOAD_PATH', __DIR__ . '/../uploads');
    define('UPLOAD_URL', SITE_URL . '/uploads');
}

// Database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    if (DEBUG_MODE) {
        die("Connection failed: " . $e->getMessage());
    } else {
        die("Connection failed. Please try again later.");
    }
}

// Helper functions
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

function generateSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

function getSetting($key) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['value'] : null;
    } catch(PDOException $e) {
        if (DEBUG_MODE) {
            logError("Error getting setting: " . $e->getMessage(), ['key' => $key]);
        }
        return null;
    }
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load site settings
$site_title = getSetting('site_title');
$site_description = getSetting('site_description');
$contact_email = getSetting('contact_email');
$contact_phone = getSetting('contact_phone');
$contact_address = getSetting('contact_address'); 