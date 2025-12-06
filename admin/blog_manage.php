<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/adminClass.php';

$db = new DbConnector();
$conn = $db->getConnection();
$admin = new Admin($conn);

//USE ADD BLOG FUNCTION
if(isset($_POST['add_blog'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $image = "";
   
    if($_FILES['image']['name'] != ""){
        $filename = time() . "_" . $_FILES['image']['name']; 
        $upload_path = '../uploads/blogs/' . $filename;

        if (!file_exists('../uploads/blogs/')) {
            mkdir('../uploads/blogs/', 0777, true);
        }
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)){
            $image = $filename;
        }
    }
    
    //add
    if($admin->manageBlog('add', $title, $content, $image, $date)){
        $_SESSION['success_message'] = "Blog added successfully!";
        header('Location: blog_manage.php');
        exit();
    }
}

//USE DELETE BLOG FUNCTION
if(isset($_GET['delete'])){
    $blog_id = $_GET['delete'];
    
    $blog = $admin->manageBlog('get', $blog_id);
    if($blog && !empty($blog['image'])){
        $image_file = '../uploads/blogs/' . $blog['image'];
        if(file_exists($image_file)){
            unlink($image_file);
        }
    }
    
    //delete
    if($admin->manageBlog('delete', $blog_id)){
        echo "<script>alert('Blog deleted!'); window.location='blog_manage.php';</script>";
    }
}

//GET ALL BLOGSS

$blogs = $admin->manageBlog('get');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <style>
      .blog-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        .add-form { 
            border: 2px solid #28a745; 
            padding: 1.25rem; 
            margin-bottom: 2rem; 
            border-radius: .5rem; 
            background: #f8fff8; 
        }
        .blog-image { 
            width: 60px; 
            height: 60px; 
        }
        .no-image { 
            width: 60px; 
            height: 60px; 
            background: #e9fbe7; 
            border: 1px dashed #28a745; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: .3rem; 
            font-size: .8rem; 
            color: #6e806dff; 
        }
        .btn-back {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .fix-btn {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
            font-size: .7rem;
            padding: .2rem .5rem;
        }
        .table-success {
            background-color: #e9fbe7;
        }
        .text-success {
            color: #22c348ff !important;
        }
        .border-success {
            border-color: #28a745 !important;
        }
    </style>
</head>

<body>
    <?php include './admin_header.php'; ?>

<div class="container">
    <div class="main-container">
        <div class="mb-4"></div>
        <a href="dashbord.php" class="btn btn-success mb-2"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
        <h2 class="blog-title">Blog Management</h2>
        <?php
        if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <?php echo $_SESSION['success_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!--Blog Form -->
        <div class="add-form">
            <h4>Add New Blog Post</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Blog Title:</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter blog title" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Published Date:</label>
                        <input type="date" 
                               name="date" 
                               class="form-control" 
                               value="<?php echo date('Y-m-d'); ?>" 
                               min="<?php echo date('Y-m-d'); ?>" 
                               max="<?php echo date('Y-m-d'); ?>" 
                               required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Blog Content:</label>
                    <textarea name="content" class="form-control" rows="5" placeholder="Write your blog content here..." required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Blog Image:</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" name="add_blog" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Blog Post</button>
            </form>
        </div>

        <!-- Blog List -->
        <h3 class="mb-3 text-success">All Blog Posts</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Content</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($blogs) > 0): ?>
                        <?php foreach($blogs as $blog): ?>
                        <tr>
                            <td><?php echo $blog['blog_id']; ?></td>
                            <td><?php echo htmlspecialchars($blog['title']); ?>
                            <td>
                                <?php if(!empty($blog['image'])): ?>
                                    <?php
                                    $image_src = '';
                                    if(strpos($blog['image'], '../assets/images/uploads') === 0) {
                                        $image_src = $blog['image'];
                                    } else {
                                        $image_src = '../uploads/blogs/' . $blog['image'];
                                    }
                                    ?>
                                    <img src="<?php echo $image_src; ?>"
                                        class="blog-image"
                                         alt="Blog Image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="no-image" style="display:none;">
                                        No Image<br>
                                        <small><?php echo htmlspecialchars(basename($blog['image'])); ?></small>
                                    </div>
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $short_content = substr($blog['content'], 0, 100);
                                echo $short_content;
                                if(strlen($blog['content']) > 100) echo "<span class='text-success'>...</span>";
                                ?>
                            </td>
                            <td><span><?php echo date('M d, Y', strtotime($blog['published_date'])); ?></span></td>
                            <td>
                                <a href="?delete=<?php echo $blog['blog_id']; ?>" 
                                   class="btn btn-sm btn-danger mb-1" 
                                   onclick="return confirm('Are you sure you want to delete this blog?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No blog posts found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <?php include './admin_footer.php'; ?>
</body>
</html>