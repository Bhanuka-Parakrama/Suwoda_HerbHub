<?php
include '../includes/dbconnect.php';

$sql = "SELECT * FROM blog ORDER BY published_date DESC";
$blogs = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container" style="padding: 10px 0; margin-top: 10px;">
        <h2 class="display-6 fw-bold text-success mb-3 text-center">Blog Posts</h2>
        <div class="row flex-column">
            <?php
            if ($blogs->num_rows > 0) {
                while($blog = $blogs->fetch_assoc()) {
            ?>
                <div class="col-12 mb-5">
                    <div class="card h-100 shadow-sm border-success">
                        <img src="<?php echo $blog['image']; ?>" class="card-img-top rounded-top" alt="Blog Image" style="height: 700px; object-fit: cover;">
                        <div class="card-body bg-light">
                            <h5 class="card-title text-success"><?php echo $blog['title']; ?></h5>
                            <p class="card-text">
                                <?php echo $blog['content']; ?>
                            </p>
                            <p class="card-text text-muted">
                                <span class="badge bg-success"><?php echo $blog['published_date']; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p class="text-center text-muted">No blogs found.</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>