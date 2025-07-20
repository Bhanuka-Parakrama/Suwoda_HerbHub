<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/GuestUser.php';

$guest = new GuestUser();

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $results = $guest->searchProducts($conn, $keyword);
} else {
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include '../includes/header.php'; ?>

<body>
    <div class="container mt-4">
        <h2>Search Results for "<?php echo htmlspecialchars($keyword); ?>"</h2>
        <div class="row">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p class="card-text"><?php echo $product['description']; ?></p>
                                <p class="card-text"><strong>LKR:</strong> <?php echo $product['price']; ?></p>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" onclick="addToCart(<?php echo $product['product_id']; ?>)">Add to Cart</button>
                                    <button class="btn btn-warning" onclick="buyNow(<?php echo $product['product_id']; ?>)">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function addToCart(productId) {
        // Check if user is logged in
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Please log in to add items to cart');
            window.location.href = '../auth/login.php';
            return;
        <?php endif; ?>
        
        fetch('../actions/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId + '&quantity=1'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to cart');
        });
    }

    function buyNow(productId) {
        // Check if user is logged in
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Please log in to purchase items');
            window.location.href = '../auth/login.php';
            return;
        <?php endif; ?>
        
        // Redirect to checkout with the specific product
        window.location.href = '../checkout/checkout.php?product_id=' + productId + '&quantity=1';
    }
    </script>
</body>

<?php '../includes/footer.php'; ?>

</html>
