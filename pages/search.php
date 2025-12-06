<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/productClass.php';
require_once '../classes/cartClass.php';

$keyword = '';
$results = [];
$message = '';
$error = '';
$addToCartMsg = null;

// Handle Add to Cart functionality
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
            $addToCartMsg = "Product already in cart or failed to add.";
        }
    } catch (Exception $e) {
        $addToCartMsg = "Server error.";
        error_log("Add to cart error: " . $e->getMessage());
    }
}

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    
    if (empty(trim($keyword))) {
        $error = "Please enter a search keyword.";
    } else {
        try {
            $guest = new Product();
            $searchResults = $guest->searchProducts($keyword); //USE SEARCH FUNCTION IN PRODUCT CLASS
            
            if ($searchResults) {
                $results = $searchResults->fetchAll(PDO::FETCH_ASSOC);
                
                if (empty($results)) {
                    $message = "No products found for '$keyword'.";
                } else {
                    $message = count($results) . " product(s) found for '$keyword'.";
                }
            }
        } catch (Exception $e) {
            $results = [];
            $error = "Search failed. Please try again.";
            error_log("Search error: " . $e->getMessage());
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
        <?php if ($addToCartMsg): ?>
            <div class="alert alert-success text-center fw-bold" style="font-size:1.1rem;">
                <?php echo htmlspecialchars($addToCartMsg); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (count($results) > 0): ?>
            <div class="row">
                <?php foreach ($results as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card product-card">
                            <?php
                            $img_src = '';
                            if (!empty($product['image'])) {
                                if (strpos($product['image'], '../assets/images/uploads') === 0) {
                                    $img_src = $product['image'];
                                } elseif (file_exists('../uploads/products/' . $product['image'])) {
                                    $img_src = '../uploads/products/' . $product['image'];
                                } elseif (file_exists('../uploads/blogs/' . $product['image'])) {
                                    $img_src = '../uploads/blogs/' . $product['image'];
                                } else {
                                    $img_src = $product['image'];
                                }
                            }
                            ?>
                            <?php if (!empty($img_src)): ?>
                                <img src="<?php echo $img_src; ?>"
                                     class="card-img-top"
                                     style="height:auto; max-height:400px; object-fit:contain; border-radius:13px 13px 0 0;"
                                     alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <?php else: ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                                    No Image
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                </h5>
                                <p class="card-text flex-grow-1">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                                <div class="mb-3">
                                    <span class="badge bg-success fs-6">LKR <?php echo number_format($product['price'], 2); ?></span>
                                </div>
                                
                                <?php
                                $quantity = isset($product['quantity']) ? intval($product['quantity']) : 0;
                                $isInStock = $quantity > 0;
                                ?>
                                
                                <?php if($isInStock): ?>
                                    <p class="text-success mb-2">
                                        <i class="bi bi-check-circle me-1"></i>In Stock (<?php echo $quantity; ?> available)
                                    </p>
                                    <div class="d-grid gap-2">
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <form method="POST" action="" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <button type="submit" name="add_to_cart" class="btn btn-success w-100">
                                                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-success w-100">
                                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <form method="POST" action="checkout.php" class="d-inline">
                                                <input type="hidden" name="buy_now" value="1">
                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-warning w-100">
                                                    <i class="bi bi-lightning-fill me-2"></i>Buy Now
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-warning w-100">
                                                <i class="bi bi-lightning-fill me-2"></i>Buy Now
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-danger mb-2">
                                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                                    </p>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="bi bi-ban me-1"></i>Out of Stock
                                        </button>
                                    </div>
                                <?php endif; ?>
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