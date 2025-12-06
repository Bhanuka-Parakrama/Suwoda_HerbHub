<?php
session_start();
require_once '../classes/cartClass.php';

// Check user logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user = new Cart();
$user_id = $_SESSION['user_id'];

//USE GET CART ITEMS FUNCTION
$cartItems = $user->getCartItems($user_id);

//USE UPDATE CART QUANTITY FUNCTION
if (isset($_POST['update_quantity']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user->updateCartQuantity($user_id, $product_id, $quantity);
    header('Location: cart.php'); 
    exit();
}

//USE REMOVE FROM CART FUNCTION
if (isset($_POST['remove_item']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if ($user->removeFromCart($user_id, $product_id)) {
        header('Location: cart.php'); 
        exit();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .product-image {
            height: 150px;
            object-fit: contain;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-5">
        <h2 class="display-6 fw-bold text-success mb-4 text-center">
            <i class="bi bi-cart3 me-2"></i>Your Shopping Cart
        </h2>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted display-1 mb-4"></i>
                <h4 class="text-muted">Your cart is empty</h4>
                <p class="text-muted mb-4">Add some products to get started!</p>
                <a href="products.php" class="btn btn-success btn-lg">
                    <i class="bi bi-shop me-2"></i>Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <?php $total = 0; ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <?php foreach ($cartItems as $item): ?>
                        <?php 
                        $subtotal = (isset($item['price']) ? $item['price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 1);
                        $total += $subtotal;
                        $productName = isset($item['product_name']) ? htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Product';
                        $productImage = htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                        $productId = intval($item['product_id']);
                        $price = floatval($item['price']);
                        $quantity = intval($item['quantity']);
                        ?>
                        <div class="card shadow-sm border-0 rounded-3 mb-3 hover-shadow">
                            <div class="card-body">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-3">
                                        <img src="../uploads/<?php echo $productImage; ?>" 
                                             class="product-image rounded bg-light p-2 w-100" 
                                             alt="<?php echo $productName; ?>"
                                             onerror="this.src='../assets/images/placeholder.jpg';">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h5 class="text-success fw-bold mb-2"><?php echo $productName; ?></h5>
                                        <span class="badge bg-warning text-dark">Rs. <?php echo number_format($price, 2); ?></span>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity(<?php echo $productId; ?>)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantity" class="form-control text-center" 
                                                       value="<?php echo $quantity; ?>" min="1" max="100"
                                                       style="width: 60px"
                                                       onchange="updateQuantity(<?php echo $productId; ?>, this.value)">
                                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity(<?php echo $productId; ?>)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <h6 class="text-success mb-0">Rs. <?php echo number_format($subtotal, 2); ?></h6>
                                        <small class="text-muted">Subtotal</small>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                            <button type="submit" name="remove_item" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to remove this item?')"
                                                    title="Remove item">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end mt-2">
                                        <form method="POST" action="checkout.php">
                                            <input type="hidden" name="buy_now" value="1">
                                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">Buy Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h4 class="text-success mb-4">
                                <i class="bi bi-receipt me-2"></i>Order Summary
                            </h4>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span>Items (<?php echo count($cartItems); ?>):</span>
                                <span>Rs. <?php echo number_format($total, 2); ?></span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total:</strong>
                                <strong class="text-success fs-5">Rs. <?php echo number_format($total, 2); ?></strong>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <form method="POST" action="checkout.php">
                                    <button type="submit" class="btn btn-warning btn-lg w-100">
                                        <i class="bi bi-credit-card me-2"></i>Buy All Now
                                    </button>
                                </form>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-auto">
        <?php include '../includes/footer.php'; ?>
    </div>

    <script>
        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                alert('Quantity must be at least 1');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="product_id" value="${productId}">
                <input type="hidden" name="quantity" value="${quantity}">
                <input type="hidden" name="update_quantity" value="1">
            `;
            document.body.appendChild(form);
            form.submit();
        }
        
        function increaseQuantity(productId) {
            const input = document.querySelector(`input[name="quantity"][form*="${productId}"], input[name="quantity"]`);
            const currentValue = parseInt(input.value);
            updateQuantity(productId, currentValue + 1);
        }
        
        function decreaseQuantity(productId) {
            const input = document.querySelector(`input[name="quantity"][form*="${productId}"], input[name="quantity"]`);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                updateQuantity(productId, currentValue - 1);
            }
        }
        
        function proceedToCheckout() {
            window.location.href = 'checkout.php';
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>



