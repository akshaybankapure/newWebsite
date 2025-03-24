<?php require_once 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?> - <?php echo isset($page_title) ? $page_title : $site_description; ?></title>
    <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : $site_description; ?>">
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : ''; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/assets/img/favicon.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/fancybox.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/main.css">
    
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    
    <!-- Cursor -->
    <div class="cursor"></div>
    
    <!-- Scrollbar Progress -->
    <div class="scrollbar-progress"></div>
</head>
<body>
    <!-- Header -->
    <header class="absoftz-header">
        <div class="absoftz-header-inner">
            <div class="absoftz-logo">
                <a href="<?php echo SITE_URL; ?>">
                    <img src="<?php echo SITE_URL; ?>/assets/img/logo.png" alt="<?php echo $site_title; ?>">
                </a>
                <a href="#" class="absoftz-back-to-top">
                    <i class="fa fa-arrow-up"></i>
                </a>
            </div>
            
            <!-- Menu -->
            <div class="absoftz-menu">
                <nav class="absoftz-main-menu">
                    <ul>
                        <li class="<?php echo $current_page === 'home' ? 'absoftz-active' : ''; ?>">
                            <a href="<?php echo SITE_URL; ?>">Home</a>
                        </li>
                        <li class="<?php echo $current_page === 'portfolio' ? 'absoftz-active' : ''; ?>">
                            <a href="<?php echo SITE_URL; ?>/portfolio">Portfolio</a>
                        </li>
                        <li class="<?php echo $current_page === 'services' ? 'absoftz-active' : ''; ?>">
                            <a href="<?php echo SITE_URL; ?>/services">Services</a>
                            <ul class="absoftz-submenu">
                                <?php
                                $stmt = $pdo->query("SELECT * FROM services WHERE status = 'published' ORDER BY order_number");
                                while ($service = $stmt->fetch()) {
                                    echo '<li><a href="' . SITE_URL . '/services/' . $service['slug'] . '">' . $service['title'] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="<?php echo $current_page === 'publication' ? 'absoftz-active' : ''; ?>">
                            <a href="<?php echo SITE_URL; ?>/publication">Publication</a>
                        </li>
                        <li class="<?php echo $current_page === 'contact' ? 'absoftz-active' : ''; ?>">
                            <a href="<?php echo SITE_URL; ?>/contact">Contact</a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Service Details -->
                <div class="absoftz-service-details">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'published' ORDER BY order_number");
                    while ($service = $stmt->fetch()) {
                        echo '<div class="absoftz-service-detail" data-service="' . $service['slug'] . '">';
                        echo '<h3>' . $service['title'] . '</h3>';
                        echo '<p>' . $service['description'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
                
                <!-- Contact Info -->
                <div class="absoftz-contact-info">
                    <h3>Contact Us</h3>
                    <p><i class="fa fa-map-marker"></i> <?php echo $contact_address; ?></p>
                    <p><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></p>
                    <p><i class="fa fa-envelope"></i> <?php echo $contact_email; ?></p>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main id="main-content"> 