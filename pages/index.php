<?php
require_once '../classes/CategoryClass.php';
require_once '../classes/GuestUser.php';
require_once '../classes/RegisterUser.php';

//CREATE DATABASE CONNECTION
$dbConnector = new DbConnector();
$conn = $dbConnector->getConnection();

//USE GET ALL CATEGORIES FUNCTION

$categories = Category::getAllCategories($conn);

//USE PRODUCT RECOMMENDATION FUNCTION
$userProducts = [];
if (RegisteredUser::isLoggedIn()) {
    $user_id = $_SESSION['user_id'];
    $registeredUser = new RegisteredUser();
    $userProducts = $registeredUser->getUserCategories($user_id, 5);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suwoda HerbHub - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <!-- Additional CSS for category cards -->
    <style>
        .category-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .hover-effect {
            transition: all 0.3s ease;
        }
        
        .hover-effect:hover {
            background-color: #198754 !important;
            color: white !important;
            border-color: #198754 !important;
        }
    </style>


</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container-fluid px-0 mb-4" style="margin-top: 10px;">
        <div id="banner" class="p-5 text-center bg-dark bg-opacity-50 text-white position-relative rounded-4 mx-3" 
             style="background-size: cover; background-position: center; min-height: 400px; transition: background-image 1s ease;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="../assets/images/Logo.jpg" alt="Logo" 
                             class="rounded-circle mb-3 border border-white border-4 shadow"
                             style="height: 120px; width: 120px; object-fit: cover;">
                        <h1 class="display-1 fw-bold mb-3" style="font-size: 4rem; text-shadow: 3px 3px 6px rgba(0,0,0,0.9);">
                            Welcome to Suwoda HerbHub
                        </h1>
                        <p class="lead fw-bold mb-4 fs-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                            Explore the best Ayurvedic and indigenous herbal products made for your wellness.
                        </p>
                        <a href="#categories" class="btn btn-success btn-lg rounded-pill px-4 py-3">
                            Explore Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 800px;">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-4">
                    <h2 class="display-6 fw-bold text-success mb-3">About Suwoda HerbHub</h2>
                    <div class="mx-auto" style="width: 60px; height: 2px; background: linear-gradient(90deg, #198754, #20c997);"></div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <h5 class="text-success mb-3">Our Vision</h5>
                    <p class="text-muted mb-0">
                        To become Sri Lanka's most trusted online platform
                        for natural wellness by delivering high-quality Ayurvedic and 
                        indigenous herbal products to every home.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <h5 class="text-success mb-3">Our Mission</h5>
                    <p class="text-muted mb-0">
                        To promote a healthy lifestyle through the power of 
                        traditional medicine, offering authentic, 
                        affordable, and accessible herbal products.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-patch-check text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Quality Assured</h6>
                    <small class="text-muted">100% authentic products</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-truck text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Fast Delivery</h6>
                    <small class="text-muted">Island-wide delivery service</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Secure Shopping</h6>
                    <small class="text-muted">Safe & trusted</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Affordable Prices</h6>
                    <small class="text-muted">Best value for money</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-headset text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">24/7 Support</h6>
                    <small class="text-muted">Always here to help</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-award text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Expert Approved</h6>
                    <small class="text-muted">Ayurvedic specialists</small>
                </div>
            </div>
        </div>
    </div>


    <!-- Personalized Products Section -->
    <?php if (!empty($userProducts)) { ?>
    <div class="container mt-5 mb-5">
        <h2 class="text-center text-success mb-5 display-6 fw-bold">Products Recommended For You</h2>
        <div class="row justify-content-center">
            <?php foreach ($userProducts as $product) {
                $productName = isset($product['product_name']) ? htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') : (isset($product['name']) ? htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') : 'Unknown Product');
                $productImage = isset($product['image']) ? htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') : 'placeholder.jpg';
                $productId = isset($product['product_id']) ? intval($product['product_id']) : 0;
                $productDescription = isset($product['description']) ? htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') : '';
                $categoryName = isset($product['category_name']) ? htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8') : '';
                $price = isset($product['price']) ? number_format($product['price'], 2) : 'N/A';
                $quantity = isset($product['quantity']) ? intval($product['quantity']) : 0;
                $isInStock = $quantity > 0;
                require_once '../classes/productClass.php';
                $productObj = new Product($productId);
                $dbConnector = new DbConnector();
                $conn = $dbConnector->getConnection();
                $ratingData = $productObj->getAverageRating($conn, $productId);
                $reviews = Product::getProductReviews($conn, $productId);
                $averageRating = $ratingData['average_rating'];
                $totalReviews = $ratingData['total_reviews'];
               
                if ($productId > 0) {
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card shadow-sm border-0 rounded-3">
                    <img src="../uploads/<?php echo $productImage; ?>"
                        class="card-img-top product-image"
                        alt="<?php echo $productName; ?>"
                        onerror="this.src='../assets/images/placeholder.jpg';">
                    <div class="card-body">
                        <h5 class="product-title text-success fw-bold mb-2"><?php echo $productName; ?></h5>
                        <div class="product-description text-muted mb-2" style="font-size: 0.97em;">
                            <?php echo nl2br($productDescription); ?>
                        </div>
                        <?php if (!empty($benefits)) { ?>
                        <ul class="mb-2 ps-3" style="font-size: 0.95em;">
                            <?php 
                            // Show unique benefits only once per product
                            $shown = [];
                            foreach ($benefits as $benefit) {
                                $clean = htmlspecialchars($benefit);
                                if ($clean && !in_array($clean, $shown)) {
                                    echo '<li class="mb-1">' . $clean . '</li>';
                                    $shown[] = $clean;
                                }
                            }
                            ?>
                        </ul>
                        <?php } ?>
                        <p class="category-info mb-2" style="font-size: 0.95em;">
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
                            <span class="price-badge fw-bold bg-warning px-2 py-1 rounded">Price: Rs. <?php echo $price; ?></span>
                        </p>
                        <?php if($isInStock) { ?>
                            <p class="stock-info text-success">In Stock (<?php echo $quantity; ?> available)</p>
                            <form method="POST" action="cart.php" class="d-flex align-items-center gap-2 mb-2">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $quantity; ?>" class="form-control form-control-sm" style="width: 70px;" required>
                                <button type="submit" name="add_to_cart" class="btn btn-success btn-sm product-btn add-to-cart-btn">Add to Cart</button>
                            </form>
                            <form method="POST" action="checkout.php" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="buy_now" value="1">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $quantity; ?>" class="form-control form-control-sm" style="width: 70px;" required>
                                <button type="submit" class="btn btn-warning btn-sm">Buy Now</button>
                            </form>
                        <?php } else { ?>
                            <p class="stock-info text-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</p>
                            <button class="btn btn-secondary btn-sm w-100 product-btn" disabled>
                                <i class="bi bi-ban me-1"></i>Out of Stock
                            </button>
                        <?php } ?>
                     

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
                                <!-- Individual Reviews -->
                                <hr>
                                <?php if (!empty($reviews)) {
                                    foreach ($reviews as $review) {
                                        $reviewer = isset($review['name']) ? htmlspecialchars($review['name'], ENT_QUOTES, 'UTF-8') : 'Anonymous';
                                        $reviewText = isset($review['review_text']) ? htmlspecialchars($review['review_text'], ENT_QUOTES, 'UTF-8') : '';
                                        $reviewRating = isset($review['rating']) ? intval($review['rating']) : 0;
                                ?>
                                <div class="mb-3">
                                    <strong><?php echo $reviewer; ?></strong>
                                    <span class="ms-2">
                                        <?php for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $reviewRating ? '<i class="bi bi-star-fill text-warning"></i>' : '<i class="bi bi-star text-secondary"></i>';
                                        } ?>
                                    </span>
                                    <p class="mb-1"><?php echo $reviewText; ?></p>
                                </div>
                                <?php }
                                } else {
                                    echo '<p class="text-muted">No reviews yet.</p>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            } ?>
        </div>
    </div>
    <?php } ?>

    <!-- Categories-->
    <div id="categories" class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center text-success mb-5 display-6 fw-bold">OUR CATEGORIES</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
            try {
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        // Sanitize output for security
                        $categoryName = htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8');
                        $categoryImage = htmlspecialchars($category['image'], ENT_QUOTES, 'UTF-8');
                        $categoryId = intval($category['category_id']);
                        $categoryDescription = isset($category['description']) ? htmlspecialchars($category['description'], ENT_QUOTES, 'UTF-8') : '';
            ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-3 category-card">
                                <div class="position-relative">
                                    <img src="../uploads/<?php echo $categoryImage; ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo $categoryName; ?>"
                                         style="height: 250px; object-fit: cover;"
                                         onerror="this.src='../assets/images/placeholder.jpg';">
                                </div>
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title text-success fw-bold mb-3">
                                        <?php echo $categoryName; ?>
                                    </h5>
                                    <?php if (!empty($categoryDescription)) { ?>
                                        <p class="card-text text-muted small mb-3 flex-grow-1">
                                            <?php echo substr($categoryDescription, 0, 100) . (strlen($categoryDescription) > 100 ? '...' : ''); ?>
                                        </p>
                                    <?php } ?>
                                    <div class="mt-auto">
                                        <a href="products.php?category_id=<?php echo $categoryId; ?>" 
                                           class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 hover-effect">
                                           View Products
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo '<div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-exclamation-circle text-warning display-4 mb-3"></i>
                                <p class="text-muted fs-5">No categories found.</p>
                                <p class="text-muted">Categories will appear here once they are added to the system.</p>
                            </div>
                          </div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12">
                        <div class="alert alert-danger text-center" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Error loading categories. Please try again later.
                        </div>
                      </div>';
                error_log("Category loading error: " . $e->getMessage());
            }
            ?>
        </div>
    </div>


    <!-- js for welcome banner-->
    <script>
        const images = [
            '../assets/images/welcome 1.jpg',
            '../assets/images/welcome 2.jpg',
            '../assets/images/welcome 3.jpg'
        ];
        let current = 0;
        const banner = document.getElementById('banner');

        function changeBg() {
            banner.style.backgroundImage = `url('${images[current]}')`;
            current = (current + 1) % images.length;
        }

        changeBg();
        setInterval(changeBg, 4000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>