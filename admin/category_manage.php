<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/AdminClass.php';

$db = new DbConnector();
$conn = $db->getConnection();


$admin = new Admin($conn);
$message = '';
$messageType = '';

// ADD CATEGORY
if (isset($_POST['addCategory'])) {
    $categoryName = trim($_POST['categoryName']);
    $imagePath = "";

    if (empty($categoryName)) {
        $message = "Category name is required!";
        $messageType = "danger";
    } else {
        if (!empty($_FILES['categoryImage']['name'])) {
            $uploadDir = '../uploads/categories/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (in_array($_FILES['categoryImage']['type'], $allowedTypes)) {
                $imageName = time() . '_' . $_FILES['categoryImage']['name'];
                $imagePath = $uploadDir . $imageName;
                if (move_uploaded_file($_FILES['categoryImage']['tmp_name'], $imagePath)) {
                    if ($admin->manageCategory('add', $categoryName, $imagePath)) {
                        $message = "Category added successfully!";
                        $messageType = "success";
                        header("Location: category_manage.php?message=" . urlencode($message) . "&type=" . $messageType);
                        exit();
                    } else {
                        $message = "Failed to add category!";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Failed to upload image!";
                    $messageType = "danger";
                }
            } else {
                $message = "Invalid image type! Please use JPG, JPEG or PNG.";
                $messageType = "danger";
            }
        } else {
            $message = "Category image is required!";
            $messageType = "danger";
        }
    }
}

// DELETE CATEGORY
if (isset($_GET['delete'])) {
    $categoryId = $_GET['delete'];
    if ($admin->manageCategory('delete', $categoryId)) {
        $message = "Category deleted successfully!";
        $messageType = "success";
    } else {
        $message = "Failed to delete category!";
        $messageType = "danger";
    }
    header("Location: category_manage.php?message=" . urlencode($message) . "&type=" . $messageType);
    exit();
}

// ...removed category update logic...

// GET ALL CATEGORIES
$categories = $admin->manageCategory('get');

$isEditing = false;
$editData = null;
// ...removed edit mode logic...
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .container { background: white; padding: 25px; margin-top: 20px; border-radius: 8px; }
        .form-box { border: 2px solid #28a745; padding: 20px; margin-bottom: 25px; border-radius: 5px; background-color: #f8fff8; }
        .category-image { width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px; }
        .preview-image { width: 100px; height: 100px; object-fit: cover; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .category-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        .alert { margin-bottom: 20px; }
        .image-preview-container { margin-top: 10px; }
        .loading { display: none; }
        .btn-delete { transition: all 0.3s; }
        .btn-delete:hover { background-color: #dc3545; border-color: #dc3545; color: white; }
    </style>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDelete(id) {
            return confirm('Are you sure you want to delete this category? This action cannot be undone.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    </script>
</head>

<body>
    <?php include './admin_header.php'; ?>

    <div class="container">
        <a href="dashbord.php" class="btn btn-success mb-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h2 class="category-title">Category Management</h2>

        <?php if (isset($_GET['message']) || !empty($message)): ?>
            <div class="alert alert-<?php echo isset($_GET['type']) ? $_GET['type'] : $messageType; ?> alert-dismissible fade show">
                <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="form-box">
            <h4>Add New Category</h4>
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="categoryName" required
                               placeholder="Enter category name">
                        <div class="invalid-feedback">
                            Please provide a category name.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" class="form-control" name="categoryImage" accept="image/jpeg,image/png,image/jpg"
                               onchange="previewImage(this);">
                        <div class="image-preview-container">
                            <img src="" class="preview-image" id="imagePreview" style="display: none;">
                        </div>
                        <small class="text-muted">Accepted formats: JPG, JPEG, PNG</small>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" name="addCategory" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Category
                    </button>
                </div>
            </form>
        </div>

        <h3 class="text-success mb-3">Categories</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                            <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                            <td>
                                <?php if (!empty($category['image'])) { ?>
                                    <img src="<?php echo htmlspecialchars($category['image']); ?>" class="category-image"
                                         alt="<?php echo htmlspecialchars($category['name']); ?>">
                                <?php } else { ?>
                                    <span class="text-muted"><i class="bi bi-image"></i> No Image</span>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <!-- Edit action removed -->
                                    <a href="?delete=<?php echo $category['category_id']; ?>" 
                                       class="btn btn-sm btn-danger btn-delete"
                                       onclick="return confirmDelete(<?php echo $category['category_id']; ?>)"
                                       title="Delete Category">
                                             Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <?php include './admin_footer.php'; ?>
</body>
</html>