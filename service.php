<?php
require_once 'config/config.php';

// Get service slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: services.php');
    exit();
}

// Get service data
try {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        header('Location: services.php');
        exit();
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Set page title and meta information
$page_title = $service['title'] . " - " . $site_title;
$meta_description = $service['meta_description'] ?: $service['description'];
$meta_keywords = $service['meta_keywords'];

// Include header
include 'includes/header.php';
?>

<!-- Service Detail Hero -->
<section class="service-detail-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4"><?php echo htmlspecialchars($service['title']); ?></h1>
                <p class="lead mb-5"><?php echo htmlspecialchars($service['description']); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Service Detail Content -->
<section class="service-detail-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if ($service['image']): ?>
                <div class="service-image mb-4">
                    <img src="<?php echo UPLOAD_URL . '/services/' . $service['image']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($service['title']); ?>">
                </div>
                <?php endif; ?>
                
                <div class="service-content">
                    <?php echo $service['content']; ?>
                </div>
                
                <!-- Related Services -->
                <?php
                try {
                    $stmt = $pdo->prepare("
                        SELECT * FROM services 
                        WHERE id != ? AND status = 'published' 
                        ORDER BY created_at DESC 
                        LIMIT 3
                    ");
                    $stmt->execute([$service['id']]);
                    $related_services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if ($related_services):
                ?>
                <div class="related-services mt-5">
                    <h3 class="mb-4">Related Services</h3>
                    <div class="row">
                        <?php foreach ($related_services as $related): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if ($related['image']): ?>
                                <img src="<?php echo UPLOAD_URL . '/services/' . $related['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related['title']); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($related['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($related['description']); ?></p>
                                    <a href="service.php?slug=<?php echo $related['slug']; ?>" class="btn btn-outline-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
                    endif;
                } catch(PDOException $e) {
                    // Silently handle error
                }
                ?>
                
                <!-- Call to Action -->
                <div class="cta-section mt-5 text-center">
                    <h3 class="mb-4">Ready to Get Started?</h3>
                    <p class="lead mb-4">Contact us today to discuss how we can help you with <?php echo htmlspecialchars($service['title']); ?>.</p>
                    <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?> 