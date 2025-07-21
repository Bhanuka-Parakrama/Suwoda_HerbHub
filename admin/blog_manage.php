<?php
session_start();
require_once '../includes/dbconnect.php'; // DB connection
require_once '../classes/adminClass.php';  // Blog class

$blogObj = new Admin();

// Add Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'], $_POST['createdDate'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $createdDate = $_POST['createdDate'];

    // Image upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../assets/images/uploads";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    $blogObj->addBlog($conn, $title, $content, $imagePath);
    header("Location: blog_manage.php");
    exit();
}

// Delete Blog
if (isset($_GET['delete'])) {
    $blogId = intval($_GET['delete']);
    $blogObj->deleteBlog($conn, $blogId);
    header("Location: blog_manage.php");
    exit();
}

// View Blogs
$blogs = Admin::viewBlogs($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Blog Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .form-section {
            border: 2px solid #0d6efd;
            border-radius: 15px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.1);
            margin-bottom: 30px;
        }
        img.thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="form-section">
            <a href="dashbord.php" class="btn btn-primary mb-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
            <h2 class="mb-4 text-primary"><i class="bi bi-journal-text me-2"></i>Blog Management</h2>
            <form id="blogForm" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Blog Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="title" required />
                </div>
                <div class="mb-3">
                    <label for="blogImage" class="form-label">Blog Image</label>
                    <input class="form-control" type="file" id="blogImage" name="image" accept="image/*" />
                </div>
                <div class="mb-3">
                    <label for="blogContent" class="form-label">Content</label>
                    <textarea class="form-control" id="blogContent" name="content" rows="3" placeholder="Enter blog content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="createdDate" class="form-label">Created Date</label>
                    <input type="date" class="form-control" id="createdDate" name="createdDate" required />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Blog</button>
                </div>
            </form>
        </div>

        <div class="table-section">
            <h4 class="mb-3">Blog List</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Blog ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Content</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($blogs)): ?>
                            <?php foreach ($blogs as $blog): ?>
                                <tr>
                                    <td><?= htmlspecialchars($blog['blog_id']) ?></td>
                                    <td><?= htmlspecialchars($blog['title']) ?></td>
                                    <td>
                                        <?php if (!empty($blog['image'])): ?>
                                            <img src="<?= htmlspecialchars($blog['image']) ?>" class="thumb" />
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($blog['content']) ?></td>
                                    <td><?= htmlspecialchars($blog['published_date']) ?></td>
                                    <td>
                                        <a href="?delete=<?= $blog['blog_id'] ?>" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this blog?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No blogs found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
