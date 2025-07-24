<?php
include '../includes/dbconnect.php';

$sql = "SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.category_id ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products - Suwoda HerbHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container" style="margin-top: 50px;">
        <h2 class="display-6 fw-bold text-success mb-3 text-center">Our Products</h2>
        
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <div class="card" style="height: 100%;">
                        <?php if($row['image'] != '') { ?>
                            <img src="<?php echo $row['image']; ?>" class="card-img-top" style="height: 300px; object-fit: cover;">
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" style="height: 300px; object-fit: cover;">
                        <?php } ?>
                        
                        <div class="card-body">
                            <h5 class="card-title text-success"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text">
                                <span>Category: <?php echo $row['category_name']; ?></span>
                            </p>
                            <p class="card-text">
                                <strong class="bg-warning">Price: LKR <?php echo $row['price']; ?></strong>
                            </p>
                            <?php if($row['quantity'] > 0) { ?>
                                <p class="text-success">In Stock (<?php echo $row['quantity']; ?> available)</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success btn-sm flex-fill" onclick="(<?php echo $row['product_id']; ?>)">
                                        Add to Cart
                                    </button>
                                    <button class="btn btn-warning btn-sm flex-fill" onclick="(<?php echo $row['product_id']; ?>)">
                                        Buy Now
                                    </button>
                                </div>
                            <?php } else { ?>
                                <p class="text-danger">Out of Stock</p>
                                <button class="btn btn-secondary btn-sm w-100" disabled>Out of Stock</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div style="text-align: center;">';
                echo '<h4>No products available</h4>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    
  <?php include '../includes/footer.php'; ?>
</body>
</html>