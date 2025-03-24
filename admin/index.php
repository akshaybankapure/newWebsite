<?php
require_once '../config/config.php';
requireLogin();

// Get statistics
try {
    // Pages count
    $stmt = $pdo->query("SELECT COUNT(*) FROM pages");
    $pages_count = $stmt->fetchColumn();
    
    // Services count
    $stmt = $pdo->query("SELECT COUNT(*) FROM services");
    $services_count = $stmt->fetchColumn();
    
    // Projects count
    $stmt = $pdo->query("SELECT COUNT(*) FROM projects");
    $projects_count = $stmt->fetchColumn();
    
    // Publications count
    $stmt = $pdo->query("SELECT COUNT(*) FROM publications");
    $publications_count = $stmt->fetchColumn();
    
    // Recent activities
    $stmt = $pdo->query("
        (SELECT 'page' as type, title, updated_at FROM pages ORDER BY updated_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'service' as type, title, updated_at FROM services ORDER BY updated_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'project' as type, title, updated_at FROM projects ORDER BY updated_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'publication' as type, title, updated_at FROM publications ORDER BY updated_at DESC LIMIT 5)
        ORDER BY updated_at DESC LIMIT 10
    ");
    $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo $site_title; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/font-awesome.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #fff;
            padding: 0.5rem 1rem;
        }
        .sidebar .nav-link:hover {
            color: #007bff;
        }
        .sidebar .nav-link.active {
            color: #007bff;
        }
        .main-content {
            padding-top: 48px;
        }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .stat-card i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #007bff;
        }
        .activity-list {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .activity-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php echo $site_title; ?> Admin</a>
            <div class="d-flex">
                <span class="navbar-text mr-3">
                    Welcome, <?php echo $_SESSION['username']; ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages.php">
                                <i class="fa fa-file"></i> Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">
                                <i class="fa fa-cogs"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="projects.php">
                                <i class="fa fa-briefcase"></i> Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="publications.php">
                                <i class="fa fa-book"></i> Publications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">
                                <i class="fa fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                
                <!-- Statistics -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fa fa-file"></i>
                            <h3><?php echo $pages_count; ?></h3>
                            <p>Pages</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fa fa-cogs"></i>
                            <h3><?php echo $services_count; ?></h3>
                            <p>Services</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fa fa-briefcase"></i>
                            <h3><?php echo $projects_count; ?></h3>
                            <p>Projects</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fa fa-book"></i>
                            <h3><?php echo $publications_count; ?></h3>
                            <p>Publications</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activities -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="activity-list">
                            <h3>Recent Activities</h3>
                            <?php foreach ($recent_activities as $activity): ?>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fa fa-<?php echo $activity['type'] === 'page' ? 'file' : ($activity['type'] === 'service' ? 'cogs' : ($activity['type'] === 'project' ? 'briefcase' : 'book')); ?>"></i>
                                        <?php echo ucfirst($activity['type']); ?>: <?php echo $activity['title']; ?>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo date('M d, Y H:i', strtotime($activity['updated_at'])); ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
</body>
</html> 