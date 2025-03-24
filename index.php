<?php
require_once 'config/config.php';

// Get the current page from URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$path = str_replace($base_path, '', $request_uri);
$path = strtok($path, '?'); // Remove query string
$path = rtrim($path, '/'); // Remove trailing slash

// Set default page
if (empty($path)) {
    $path = '/';
}

// Get page data from database
try {
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? AND status = 'published'");
    $stmt->execute([ltrim($path, '/')]);
    $page = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($page) {
        $page_title = $page['title'];
        $meta_description = $page['meta_description'];
        $meta_keywords = $page['meta_keywords'];
        $content = $page['content'];
        $current_page = $page['slug'];
    } else {
        // Check if it's a service page
        if (strpos($path, '/services/') === 0) {
            $service_slug = substr($path, 10); // Remove '/services/'
            $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? AND status = 'published'");
            $stmt->execute([$service_slug]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($service) {
                $page_title = $service['title'];
                $meta_description = $service['description'];
                $content = $service['content'];
                $current_page = 'services';
                $page_script = 'service-detail.js';
            } else {
                header("HTTP/1.0 404 Not Found");
                $page_title = '404 - Page Not Found';
                $content = '<div class="absoftz-error-page"><h1>404</h1><p>Page not found</p><a href="' . SITE_URL . '">Back to Home</a></div>';
                $current_page = '404';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            $page_title = '404 - Page Not Found';
            $content = '<div class="absoftz-error-page"><h1>404</h1><p>Page not found</p><a href="' . SITE_URL . '">Back to Home</a></div>';
            $current_page = '404';
        }
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Include header
require_once 'includes/header.php';
?>

<!-- Page Content -->
<div class="absoftz-page-content">
    <?php echo $content; ?>
</div>

<?php
// Include footer
require_once 'includes/footer.php';
?> 