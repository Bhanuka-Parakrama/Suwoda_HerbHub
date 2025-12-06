<?php
require_once '../classes/productClass.php';
require_once '../classes/cartClass.php';
require_once '../classes/discountClass.php';
require_once '../classes/categoryClass.php';
require_once '../includes/dbconnect.php';

// Restore original price for products with expired discounts
$db = new DbConnector();
$conn = $db->getConnection();
$discount = new Discount();
$stmt = $conn->query("SELECT product_id FROM product WHERE original_price IS NOT NULL");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $discount->restorePriceIfExpired($conn, $row['product_id']);
}
session_start();


$category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? $_GET['category_id'] : null;

// Get all categories for the dropdown
try {
    $db = new DbConnector();
    $conn = $db->getConnection();
    $categories = Category::getAllCategories($conn);
} catch (Exception $e) {
    $categories = [];
    error_log("Category loading error: " . $e->getMessage());
}

//USE GET ALL PRODUCTS FUNCTION
try {
    $db = new DbConnector();
    $conn = $db->getConnection();
    $result = Product::getAllProducts($conn);
    
    $products = [];
    if ($result) {
        if (is_array($result)) {
            foreach ($result as $row) {
                if ($category_id === null || $row['category_id'] == $category_id) {
                    $products[] = $row;
                }
            }
        } else {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($category_id === null || $row['category_id'] == $category_id) {
                    $products[] = $row;
                }
            }
        }
    }
} catch (Exception $e) {
    $products = [];
    error_log("Product loading error: " . $e->getMessage());
}


$addToCartMsg = null;

//USE ADD TO CART FUNCTION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'], $_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $addToCartMsg = "Please log in first to add items to cart";
        header('Location: login.php');
        exit;
    }
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);
    try {
        $db = new DbConnector();
        $conn = $db->getConnection();
        $result = Cart::addToCart($conn, $userId, $productId);
        if ($result) {
            $addToCartMsg = "Product added to cart!";
        } else {
            $addToCartMsg = "Failed to add to cart.";
        }
    } catch (Exception $e) {
        $addToCartMsg = "Server error.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products - Suwoda HerbHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .product-card .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .product-description {
            flex-grow: 1;
            margin-bottom: 1rem;
            line-height: 1.6;
            font-size: 0.9rem;
        
        }
        
        .product-actions {
            margin-top: auto;
            padding-top: 1rem;
        }
        
        .product-image {
            height: 280px; /* Adjusted height */
            width: 100%;
            object-fit: contain;
            object-position: center;
            background-color: #f8f9fa;
            padding: 10px;
        }
        
        .price-badge {
            background-color: #ffc107;
            color: #000;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: bold;
        }
        
        .price-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .current-price {
            background: linear-gradient(45deg, #28a745, #20c997);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        
        .original-price {
            position: relative;
            animation: strikethrough 0.8s ease-in-out;
        }
        
        .savings-info {
            background-color: #d4edda;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            border-left: 3px solid #28a745;
        }
        
        @keyframes strikethrough {
            0% { text-decoration: none; }
            50% { text-decoration: line-through; text-decoration-color: transparent; }
            100% { text-decoration: line-through; text-decoration-color: #dc3545; }
        }
        
        .discount-badge {
            animation: pulse 2s infinite;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .product-title {
            color: #198754;
            font-weight: bold;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
        
        .category-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .stock-info {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .product-btn {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .product-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .rating-stars {
            color: #ff3d07ff;
            font-size: 0.9rem;
        }
        
        .rating-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .review-section {
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 0.75rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        
        .review-item {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .review-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .reviewer-name {
            font-weight: 600;
            color: #495057;
        }
        
        .review-date {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .view-reviews-btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .modal-review-item {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
        }
        
        .modal-reviewer-name {
            font-weight: 600;
            color: #495057;
            font-size: 1rem;
        }
        
        .modal-review-rating {
            color: #ffc107;
            font-size: 1.1rem;
        }
        
        .modal-review-text {
            color: #343a40;
            line-height: 1.6;
            margin: 0.75rem 0;
        }
        
        .modal-review-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .modal-product-title {
            color: #198754;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .modal-rating-summary {
            background-color: #e8f5e8;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-rating-summary .rating-stars {
            font-size: 1.5rem;
            color: #ffc107;
        }

        .category-filter {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .category-filter h4 {
            color: #198754;
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container min-vh-100 d-flex flex-column" style="margin-top: 50px;">
        <h2 class="display-6 fw-bold text-success mb-4 text-center">Our Products</h2>
        
        <!-- Category Filter Section -->
        <div class="category-filter">
            <form method="GET" action="products.php" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="category_select" class="form-label fw-semibold">
                        <i class="bi bi-tag-fill me-1"></i>Filter by Categories:
                    </label>
                    <select name="category_id" id="category_select" class="form-select category-dropdown">
                        <option value="">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>" 
                                        <?php echo ($category_id == $category['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
        
        <?php if ($addToCartMsg): ?>
            <div class="alert alert-success text-center fw-bold" style="font-size:1.1rem;">
                <?php echo htmlspecialchars($addToCartMsg); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <?php
            try {
                if (!empty($products)) {
                    foreach($products as $product) {
                        // Sanitize output for security
                        $productName = htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8');
                        $productDescription = htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8');
                        $categoryName = htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8');
                        $productImage = htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8');
                        $productId = intval($product['product_id']);
                        $price = floatval($product['price']);
                        $quantity = intval($product['quantity']);
                        $isInStock = $quantity > 0;

                        // Get active discount for this product
                        $discountInfo = null;
                        $today = date('Y-m-d');
                        $sql = "SELECT * FROM discount WHERE product_id = ? AND start_date <= ? AND end_date >= ? ORDER BY discount_id DESC LIMIT 1";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->execute([$productId, $today, $today]);
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($result) {
                                $discountInfo = $result;
                            }
                        }

                        //USE GET RATING AND REVIEWS FUNCTION
                        $productObj = new Product($productId);
                        $ratingData = $productObj->getAverageRating($conn, $productId);
                        $reviews = $productObj->getProductReviews($conn, $productId);
                        
                        $averageRating = $ratingData['average_rating'];
                        $totalReviews = $ratingData['total_reviews'];
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card shadow-sm border-0 rounded-3">
                        <img src="../uploads/<?php echo $productImage; ?>" 
                             class="card-img-top product-image" 
                             alt="<?php echo $productName; ?>"
                             onerror="this.src='../assets/images/placeholder.jpg';">
                        
                        <div class="card-body">
                            <h5 class="product-title"><?php echo $productName; ?></h5>
                            
                            <div class="product-description text-muted">
                                <?php echo nl2br($productDescription); ?>
                            </div>
                            
                            <p class="category-info">
                                <i class="bi bi-tag me-1"></i>Category: <?php echo $categoryName; ?>
                            </p>

                            <!-- Rating-->
                            <?php if ($totalReviews > 0): ?>
                                <div class="rating-info d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="rating-stars">
                                            <?php 
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $averageRating) {
                                                    echo '<i class="bi bi-star-fill"></i>';
                                                } elseif ($i - 0.5 <= $averageRating) {
                                                    echo '<i class="bi bi-star-half"></i>';
                                                } else {
                                                    echo '<i class="bi bi-star"></i>';
                                                }
                                            }
                                            ?>
                                        </span>
                                        <span class="ms-1"><?php echo $averageRating; ?>/5 (<?php echo $totalReviews; ?> review<?php echo $totalReviews != 1 ? 's' : ''; ?>)</span>
                                    </div>
                                    <button type="button" class="btn btn-warning view-reviews-btn" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo $productId; ?>">
                                        <i class="bi bi-eye me-1"></i>View Reviews
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="rating-info mb-2">
                                    <span class="text-muted">No reviews yet</span>
                                </div>
                            <?php endif; ?>
                            

                            <p class="card-text mb-2">
                                <?php 
                                    // Get original price from database
                                    $originalPrice = !empty($product['original_price']) ? floatval($product['original_price']) : $price;
                                    
                                    if ($discountInfo): 
                                        $discountPercent = floatval($discountInfo['discount_percentage']);
                                        $discountedPrice = $originalPrice * (1 - $discountPercent / 100);
                                ?>
                                    <div class="mb-2">
                                        <span class="badge bg-danger fs-6 mb-2 discount-badge">🔥 <?php echo $discountPercent; ?>% OFF</span>
                                    </div>
                                    <div class="price-section">
                                        <span class="current-price" style="color:#28a745; font-size:1.3em; font-weight:bold;">Rs. <?php echo number_format($discountedPrice, 2); ?></span>
                                        <span class="original-price ms-2" style="color:#dc3545; font-size:1.1em; font-weight:500; text-decoration:line-through; text-decoration-color:#dc3545; text-decoration-thickness:2px;">Rs. <?php echo number_format($originalPrice, 2); ?></span>
                                    </div>
                                    <div class="savings-info mt-1">
                                        <small class="text-success fw-bold">💰 You Save: Rs. <?php echo number_format($originalPrice - $discountedPrice, 2); ?></small>
                                    </div>
                                <?php else: ?>
                                    <div class="price-section">
                                        <span class="price-badge">Rs. <?php echo number_format($price, 2); ?></span>
                                        <?php if (!empty($product['original_price']) && $product['original_price'] != $price): ?>
                                            <span class="ms-2" style="color:#dc3545; font-size:0.95em; text-decoration:line-through; text-decoration-color:#dc3545; text-decoration-thickness:2px;">Rs. <?php echo number_format($originalPrice, 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </p>

                            <div class="product-actions">
                                <?php if($isInStock) { ?>
                                    <p class="stock-info text-success">
                                        </i>In Stock (<?php echo $quantity; ?> available)
                                    </p>
                                    <form method="POST" action="" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $quantity; ?>" class="form-control form-control-sm" style="width: 70px;" required>
                                        <button type="submit" name="add_to_cart" class="btn btn-success btn-sm product-btn add-to-cart-btn">
                                            Add to Cart
                                        </button>
                                    </form>
                                    <form method="POST" action="checkout.php" class="d-flex align-items-center gap-2 mt-1">
                                        <input type="hidden" name="buy_now" value="1">
                                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $quantity; ?>" class="form-control form-control-sm" style="width: 70px;" required>
                                        <button type="submit" class="btn btn-warning btn-sm">Buy Now</button>
                                    </form>
                                <?php } else { ?>
                                    <p class="stock-info text-danger">
                                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                                    </p>
                                    <button class="btn btn-secondary btn-sm w-100 product-btn" disabled>
                                        <i class="bi bi-ban me-1"></i>Out of Stock
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews as pop up message -->
                <div class="modal fade" id="reviewModal<?php echo $productId; ?>" tabindex="-1" aria-labelledby="reviewModalLabel<?php echo $productId; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="reviewModalLabel<?php echo $productId; ?>">
                                    <i class="bi bi-chat-left-text me-2"></i>Reviews for <?php echo $productName; ?>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Rating Summary -->
                                <div class="modal-rating-summary">
                                    <h4 class="modal-product-title"><?php echo $productName; ?></h4>
                                    <div class="rating-stars mb-2">
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $averageRating) {
                                                echo '<i class="bi bi-star-fill"></i>';
                                            } elseif ($i - 0.5 <= $averageRating) {
                                                echo '<i class="bi bi-star-half"></i>';
                                            } else {
                                                echo '<i class="bi bi-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <h3 class="text-success"><?php echo $averageRating; ?>/5</h3>
                                    <p class="mb-0">Based on <?php echo $totalReviews; ?> review<?php echo $totalReviews != 1 ? 's' : ''; ?></p>
                                </div>

                                <!-- All Reviews -->
                                <h6 class="mb-3"><i class="bi bi-list-ul me-1"></i>All Reviews:</h6>
                                <?php if (!empty($reviews) && count($reviews) > 0): ?>
                                    <?php foreach ($reviews as $review): ?>
                                        <div class="modal-review-item">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="modal-reviewer-name"><?php echo htmlspecialchars($review['name'], ENT_QUOTES, 'UTF-8'); ?></span>

                                            </div>
                                            <?php if (!empty($review['comment'])): ?>
                                                <p class="modal-review-text"><?php echo nl2br(htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                                            <?php else: ?>
                                                <p class="modal-review-text text-muted"><em>No written review provided.</em></p>
                                            <?php endif; ?>
                                            <small class="modal-review-date">
                                                <i class="bi bi-calendar3 me-1"></i><?php echo date('F j, Y \a\t g:i A', strtotime($review['review_date'])); ?>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="bi bi-chat-left-text text-muted display-6 mb-3"></i>
                                        <p class="text-muted">No reviews available for this product yet.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    }
                } else {
                    echo '<div class="col-12 text-center">';
                    echo '<div class="py-5">';
                    echo '<i class="bi bi-exclamation-circle text-warning display-4 mb-3"></i>';
                    echo '<h4>No products available</h4>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12">';
                echo '<div class="alert alert-danger text-center" role="alert">';
                echo '<i class="bi bi-exclamation-triangle me-2"></i>';
                echo 'Error loading products. Please try again later.';
                echo '</div>';
                echo '</div>';
                error_log("Product display error: " . $e->getMessage());
            }
            ?>
        </div>
    </div>

    <div class="mt-auto">
        <?php include '../includes/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-submit form when category is selected
        document.getElementById('category_select').addEventListener('change', function() {
            if (this.value !== '') {
                this.form.submit();
            }
        });
        
        // Add smooth scroll animation for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('category_id')) {
                // Smooth scroll to products section after category filter
                setTimeout(() => {
                    document.querySelector('.row').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 100);
            }
        });
    </script>
</body>
</html>