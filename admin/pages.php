<?php
require_once '../config/config.php';
requireLogin();

// Handle page deletion
if (isset($_POST['delete']) && isset($_POST['page_id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM pages WHERE id = ?");
        $stmt->execute([$_POST['page_id']]);
    } catch(PDOException $e) {
        $error = "Error deleting page: " . $e->getMessage();
    }
}

// Get all pages
try {
    $stmt = $pdo->query("SELECT * FROM pages ORDER BY created_at DESC");
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pages - <?php echo $site_title; ?> Admin</title>
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
        .page-list {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .page-item {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .page-item:last-child {
            border-bottom: none;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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
                            <a class="nav-link" href="index.php">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="pages.php">
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
                    <h1 class="h2">Manage Pages</h1>
                    <a href="page-edit.php" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Page
                    </a>
                </div>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="page-list">
                    <?php foreach ($pages as $page): ?>
                    <div class="page-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1"><?php echo $page['title']; ?></h5>
                                <small class="text-muted">
                                    Slug: <?php echo $page['slug']; ?> | 
                                    Status: <span class="badge badge-<?php echo $page['status'] === 'published' ? 'success' : 'warning'; ?>"><?php echo ucfirst($page['status']); ?></span> |
                                    Last updated: <?php echo date('M d, Y H:i', strtotime($page['updated_at'])); ?>
                                </small>
                            </div>
                            <div>
                                <a href="page-edit.php?id=<?php echo $page['id']; ?>" class="btn btn-sm btn-primary btn-action">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                    <input type="hidden" name="page_id" value="<?php echo $page['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-sm btn-danger btn-action">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>
    
    <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
</body>
</html> 