<?php
require_once '../classes/BlogClass.php';



$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$blogs = [];
$singleBlog = null;
$totalPages = 0;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$postsPerPage = 1;

try {
    $db = new DbConnector();
    $conn = $db->getConnection();
    if ($blogId > 0) {
        $singleBlog = (new Blog())->getBlogs($conn, $blogId); //USE GET BLOG FUNCTION
    } else {
        $allBlogs = (new Blog())->getBlogs($conn);
        $totalBlogs = count($allBlogs);
        $totalPages = ceil($totalBlogs / $postsPerPage);
        $offset = ($currentPage - 1) * $postsPerPage;
        $blogs = array_slice($allBlogs, $offset, $postsPerPage);
    }
} catch (Exception $e) {
    $blogs = [];
    $totalPages = 0;
    error_log("Blog loading error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog - Suwoda HerbHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .blog-card {
            height: auto;
            display: flex;
            flex-direction: column;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .blog-card .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .blog-content {
            flex-grow: 1;
            margin-bottom: 1rem;
            line-height: 1.6;
            font-size: 1rem;
        }
        
        .blog-image {
            max-height: 300px; 
            width: 100%;
            object-fit: contain;
            object-position: center;
            background-color: #f8f9fa;
            padding: 10px; 
        }
        
        .blog-title {
            color: #198754;
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.75rem;
            text-align: center;
        }
        
        .blog-date {
            background-color: #198754;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .blog-actions {
            margin-top: auto;
            padding-top: 1.5rem;
        }
        
        .blog-btn {
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .blog-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .blog-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .no-image-placeholder {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 500;
            min-height: 200px; 
        }
        
        .pagination-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .page-info {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .nav-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Additional styles for better image display */
        .image-container {
            border-bottom: 2px solid #e9ecef;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container min-vh-100 d-flex flex-column" style="margin-top: 50px;">
        <h2 class="display-6 fw-bold text-success mb-4 text-center">Blog Posts</h2>
        
        <div class="row justify-content-center">
            <?php
            try {
                if ($blogId > 0 && $singleBlog) {
                    // Show single blog post
                    $blogTitle = htmlspecialchars($singleBlog['title'], ENT_QUOTES, 'UTF-8');
                    $blogContent = htmlspecialchars($singleBlog['content'], ENT_QUOTES, 'UTF-8');
                    $blogDate = htmlspecialchars($singleBlog['published_date'], ENT_QUOTES, 'UTF-8');
                    $img_src = '';
                    if (!empty($singleBlog['image'])) {
                        $blogImage = htmlspecialchars($singleBlog['image'], ENT_QUOTES, 'UTF-8');
                        if (strpos($blogImage, '../assets/images/uploads') === 0) {
                            $img_src = $blogImage;
                        } else {
                            $img_src = '../uploads/blogs/' . $blogImage;
                        }
                    }
            ?>
                <div class="col-12">
                    <div class="card blog-card shadow-lg border-0 rounded-3">
                        <div class="image-container">
                            <?php if (!empty($img_src)): ?>
                                <img src="<?php echo $img_src; ?>" class="card-img-top blog-image" alt="<?php echo $blogTitle; ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="blog-image no-image-placeholder" style="display: none;">
                                    <i class="bi bi-image me-2"></i>No Image Available
                                </div>
                            <?php else: ?>
                                <div class="blog-image no-image-placeholder">
                                    <i class="bi bi-image me-2"></i>No Image Available
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body bg-light p-4">
                            <h3 class="blog-title"><?php echo $blogTitle; ?></h3>
                            <div class="text-center mb-3">
                                <span class="blog-date">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    <?php echo date('F j, Y', strtotime($blogDate)); ?>
                                </span>
                            </div>
                            <div class="blog-content text-dark">
                                <?php echo nl2br($blogContent); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                } elseif (!empty($blogs)) {
                    $blog = $blogs[0];
                    $blogTitle = htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8');
                    $blogContent = htmlspecialchars($blog['content'], ENT_QUOTES, 'UTF-8');
                    $blogDate = htmlspecialchars($blog['published_date'], ENT_QUOTES, 'UTF-8');
                    $blogId = intval($blog['blog_id']);
                    $img_src = '';
                    if (!empty($blog['image'])) {
                        $blogImage = htmlspecialchars($blog['image'], ENT_QUOTES, 'UTF-8');
                        if (strpos($blogImage, '../assets/images/uploads') === 0) {
                            $img_src = $blogImage;
                        } else {
                            $img_src = '../uploads/blogs/' . $blogImage;
                        }
                    }
            ?>
                <div class="col-12">
                    <div class="card blog-card shadow-lg border-0 rounded-3">
                        <div class="image-container">
                            <?php if (!empty($img_src)): ?>
                                <img src="<?php echo $img_src; ?>" class="card-img-top blog-image" alt="<?php echo $blogTitle; ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="blog-image no-image-placeholder" style="display: none;">
                                    <i class="bi bi-image me-2"></i>No Image Available
                                </div>
                            <?php else: ?>
                                <div class="blog-image no-image-placeholder">
                                    <i class="bi bi-image me-2"></i>No Image Available
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body bg-light p-4">
                            <h3 class="blog-title"><?php echo $blogTitle; ?></h3>
                            <div class="text-center mb-3">
                                <span class="blog-date">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    <?php echo date('F j, Y', strtotime($blogDate)); ?>
                                </span>
                            </div>
                            <div class="blog-content text-dark">
                                <?php echo nl2br($blogContent); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Page Navigation Controls -->
                    <div class="pagination-controls">
                        <button class="btn btn-outline-success nav-btn" <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?> onclick="window.location.href='?page=<?php echo $currentPage - 1; ?>'">
                            <i class="bi bi-chevron-left me-1"></i>Previous
                        </button>
                        <span class="page-info">Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>
                        <button class="btn btn-outline-success nav-btn" <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?> onclick="window.location.href='?page=<?php echo $currentPage + 1; ?>'">
                            Next<i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    </div>
                </div>
            <?php
                } else {
                    echo '<div class="col-12 text-center">';
                    echo '<div class="py-5">';
                    echo '<i class="bi bi-journal-x text-warning display-4 mb-3"></i>';
                    echo '<h4>No blog posts available</h4>';
                    echo '<p class="text-muted">Check back later for new content!</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12">';
                echo '<div class="alert alert-danger text-center" role="alert">';
                echo '<i class="bi bi-exclamation-triangle me-2"></i>';
                echo 'Error loading blog posts. Please try again later.';
                echo '</div>';
                echo '</div>';
                error_log("Blog display error: " . $e->getMessage());
            }
            ?>
        </div>
    </div>

    <div class="mt-auto">
        <?php include '../includes/footer.php'; ?>
    </div>

    <script>
        function readMore(blogId) {
            window.location.href = 'blog-detail.php?id=' + blogId;
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && <?php echo $currentPage; ?> > 1) {
                window.location.href = '?page=<?php echo $currentPage - 1; ?>';
            } else if (e.key === 'ArrowRight' && <?php echo $currentPage; ?> < <?php echo $totalPages; ?>) {
                window.location.href = '?page=<?php echo $currentPage + 1; ?>';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>