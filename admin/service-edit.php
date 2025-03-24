<?php
require_once '../config/config.php';
requireLogin();

$service = [
    'id' => null,
    'title' => '',
    'slug' => '',
    'description' => '',
    'content' => '',
    'image' => '',
    'meta_description' => '',
    'meta_keywords' => '',
    'status' => 'draft'
];

$error = '';
$success = '';

// Get service data if editing
if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$service) {
            header('Location: services.php');
            exit();
        }
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $description = $_POST['description'] ?? '';
    $content = $_POST['content'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $meta_keywords = $_POST['meta_keywords'] ?? '';
    $status = $_POST['status'] ?? 'draft';
    
    if (empty($title)) {
        $error = 'Title is required.';
    } else {
        try {
            if (empty($slug)) {
                $slug = generateSlug($title);
            }
            
            // Handle image upload
            $image = $service['image']; // Keep existing image by default
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = UPLOAD_PATH . '/services/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array($file_extension, $allowed_extensions)) {
                    throw new Exception('Invalid file type. Only JPG, PNG and GIF files are allowed.');
                }
                
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    // Delete old image if exists
                    if ($service['image'] && file_exists($upload_dir . $service['image'])) {
                        unlink($upload_dir . $service['image']);
                    }
                    $image = $new_filename;
                } else {
                    throw new Exception('Failed to upload image.');
                }
            }
            
            if ($service['id']) {
                // Update existing service
                $stmt = $pdo->prepare("
                    UPDATE services 
                    SET title = ?, slug = ?, description = ?, content = ?, image = ?, meta_description = ?, meta_keywords = ?, status = ?
                    WHERE id = ?
                ");
                $stmt->execute([$title, $slug, $description, $content, $image, $meta_description, $meta_keywords, $status, $service['id']]);
            } else {
                // Create new service
                $stmt = $pdo->prepare("
                    INSERT INTO services (title, slug, description, content, image, meta_description, meta_keywords, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$title, $slug, $description, $content, $image, $meta_description, $meta_keywords, $status]);
            }
            
            $success = 'Service saved successfully.';
            
            // Redirect after successful save
            header('Location: services.php');
            exit();
        } catch(Exception $e) {
            $error = "Error saving service: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $service['id'] ? 'Edit' : 'Add New'; ?> Service - <?php echo $site_title; ?> Admin</title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/summernote.min.css">
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
        .service-form {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 1rem;
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
                            <a class="nav-link" href="pages.php">
                                <i class="fa fa-file"></i> Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="services.php">
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
                    <h1 class="h2"><?php echo $service['id'] ? 'Edit' : 'Add New'; ?> Service</h1>
                    <a href="services.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Services
                    </a>
                </div>
                
                <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <div class="service-form">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($service['slug']); ?>">
                            <small class="form-text text-muted">Leave empty to auto-generate from title.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Short Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($service['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10"><?php echo htmlspecialchars($service['content']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            <?php if ($service['image']): ?>
                            <div>
                                <img src="<?php echo UPLOAD_URL . '/services/' . $service['image']; ?>" alt="Current image" class="preview-image">
                            </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Recommended size: 800x600 pixels. Max file size: 2MB.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="2"><?php echo htmlspecialchars($service['meta_description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($service['meta_keywords']); ?>">
                            <small class="form-text text-muted">Comma-separated keywords.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" <?php echo $service['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $service['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Service</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    
    <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote editor
            $('#content').summernote({
                height: 400
            });
            
            // Auto-generate slug from title
            $('#title').on('input', function() {
                if ($('#slug').val() === '') {
                    var title = $(this).val();
                    var slug = title.toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)/g, '');
                    $('#slug').val(slug);
                }
            });
            
            // Preview image before upload
            $('#image').change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.preview-image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html> 