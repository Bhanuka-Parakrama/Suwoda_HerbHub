<?php
session_start();
include '../includes/dbconnect.php';
include '../classes/GuestUser.php';

$guest = new GuestUser();
$keyword = '';
$results = [];

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $searchResults = $guest->searchProducts($conn, $keyword);
    
    if ($searchResults && $searchResults->num_rows > 0) {
        while ($row = $searchResults->fetch_assoc()) {
            $results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - HerbHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
       
        
        .product-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .product-card:hover {
            border-color: #28a745;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15);
            transform: translateY(-5px);
        }
        
        .product-image {
            height: 200px;
            object-fit: cover;
            border-radius: 13px 13px 0 0;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
       
    </style>
</head>

<?php include '../includes/header.php'; ?>

<body>
    <div class="mb-4"></div>
    <div class="container">
        <?php if (isset($_SESSION['user_id']) && count($results) > 0): ?>
            <div class="row">
                <?php foreach ($results as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card product-card">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 class="card-img-top"
                                 style="height:auto; max-height:400px; object-fit:contain; border-radius:13px 13px 0 0;"
                                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                </h5>
                                <p class="card-text flex-grow-1">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                                <div class="mb-3">
                                    LKR <?php echo number_format($product['price'], 2); ?>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" 
                                            onclick="addToCart(<?php echo $product['product_id']; ?>)">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>
                                    <button class="btn btn-warning" 
                                            onclick="buyNow(<?php echo $product['product_id']; ?>)">
                                            Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <i class="bi bi-search" style="font-size: 4rem; color: #dee2e6;"></i>
                <h3 class="mt-3">No Products Found</h3>
            </div>
        <?php endif; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

<?php include '../includes/footer.php'; ?>
</html>