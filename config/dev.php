<?php
// Development environment settings
define('DEBUG_MODE', true);
define('ERROR_REPORTING', E_ALL);
define('DISPLAY_ERRORS', true);

// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'cms_dev');
define('DB_USER', 'cms_dev');
define('DB_PASS', 'Akshay@9977');

// Site settings
define('SITE_URL', 'http://localhost:8000');
define('SITE_TITLE', 'CMS Development');
define('UPLOAD_PATH', __DIR__ . '/../uploads');
define('UPLOAD_URL', SITE_URL . '/uploads');

// Session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production

// Error handling
if (DEBUG_MODE) {
    error_reporting(ERROR_REPORTING);
    ini_set('display_errors', DISPLAY_ERRORS);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Development-specific functions
function debug($data) {
    if (DEBUG_MODE) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

function logError($message, $context = []) {
    if (DEBUG_MODE) {
        $log = date('Y-m-d H:i:s') . " - " . $message . "\n";
        if (!empty($context)) {
            $log .= "Context: " . print_r($context, true) . "\n";
        }
        error_log($log, 3, __DIR__ . '/../logs/error.log');
    }
} 