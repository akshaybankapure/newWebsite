<?php
require_once 'config/config.php';

// Get all published services
try {
    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'published' ORDER BY created_at DESC");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Set page title and meta information
$page_title = "Our Services - " . $site_title;
$meta_description = "Explore our comprehensive range of services designed to meet your needs.";
$meta_keywords = "services, solutions, professional services, business services";

// Include header
include 'includes/header.php';
?>

<!-- Services Hero Section -->
<section class="services-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">Our Services</h1>
                <p class="lead mb-5">Discover how we can help you achieve your goals with our comprehensive range of services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="services-grid py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($services as $service): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <?php if ($service['image']): ?>
                    <img src="<?php echo UPLOAD_URL . '/services/' . $service['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($service['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($service['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                        <a href="service.php?slug=<?php echo $service['slug']; ?>" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Ready to Get Started?</h2>
                <p class="lead mb-4">Contact us today to discuss how we can help you with your specific needs.</p>
                <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?> 