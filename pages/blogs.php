<?php
require_once '../includes/dbconnect.php';
require_once '../classes/blogClass.php';

$blogs = Blog::showDetail($conn);  // Get all blogs
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/styles.css" />
  <style>
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
    .card-hover:hover {
      transform: scale(1.03);
      transition: 0.3s ease;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <?php include '../includes/header.php'; ?>

  <div class="container py-5 mt-5">
    <h2 class="text-center mb-5 section-title text-dark" style="font-size: 2rem;">Our Latest Blog Posts</h2>
    <div class="d-flex flex-row gap-4 overflow-auto pb-4">

      <?php if ($blogs): ?>
        <?php foreach ($blogs as $blog): ?>
          <div class="card shadow card-hover" style="min-width: 300px;">
            <img src="<?php echo htmlspecialchars($blog['image']); ?>" class="card-img-top" alt="Blog Image">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars(substr($blog['content'], 0, 100)) . '...'; ?></p>
              <p class="card-text text-muted">
                <small>Published on: <?php echo htmlspecialchars($blog['published_date']); ?></small>
              </p>
              <a href="blog_detail.php?id=<?php echo $blog['blog_id']; ?>" class="btn btn-success">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No blogs found.</p>
      <?php endif; ?>

    </div>
  </div>

  <?php include '../includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
