<?php
session_start();
require_once '../includes/dbconnect.php';

require_once '../classes/adminClass.php';
require_once '../classes/discountClass.php';


$db = new DbConnector();
$conn = $db->getConnection();
$admin = new Admin($conn);
$discount = new Discount();


//GET ALL PRODUCTS AND CATEGORIES
$products = $admin->manageProduct('get');
$categories = $admin->manageCategory('get');


// Handle discount form submission
if (isset($_POST['set_discount'])) {
    $product_id = $_POST['discount_product_id'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    // Validate dates are not in the past or today
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    if ($start_date < $tomorrow) {
        $_SESSION['error_msg'] = "Start date must be tomorrow or later!";
    } elseif ($end_date < $tomorrow) {
        $_SESSION['error_msg'] = "End date must be tomorrow or later!";
    } elseif ($end_date < $start_date) {
        $_SESSION['error_msg'] = "End date cannot be before start date!";
    } else {
        $result = $admin->manageDiscount('add', $product_id, $discount_percentage, $start_date, $end_date); //ADD DISCOUNT
        if ($result) {
            $_SESSION['success_msg'] = "Discount set successfully!";
        } else {
            $_SESSION['error_msg'] = "Failed to set discount!";
        }
    }
    header("Location: product_manage.php");
    exit();
}


//ADD PRODUCT
if (isset($_POST['add'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $desc = $_POST['description'];
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = '../uploads/products/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    $result = $admin->manageProduct('add', $name, $category, $price, $qty, $image, $desc);
    if ($result) {
        $_SESSION['success_msg'] = "Product added successfully!";
    } else {
        $_SESSION['error_msg'] = "Failed to add product!";
    }
    header("Location: product_manage.php");
    exit();
}

//UPDATE PRODUCT
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $desc = $_POST['description'];
    $image = $_POST['old_image'];
    if ($_FILES['image']['name'] != "") {
        $image = '../uploads/products/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    $admin->manageProduct('update', $id, $name, $category, $price, $qty, $image, $desc);
    $_SESSION['success_msg'] = "Product updated successfully!";
    header("Location: product_manage.php");
    exit();
}



//DELETE PRODUCT OR REVIEW
try {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        if ($admin->manageProduct('delete', $id)) { //PRODUCT
            $_SESSION['success_msg'] = "Product deleted successfully!";
        } else {
            $_SESSION['error_msg'] = "Failed to delete product!";
        }
        header("Location: product_manage.php");
        exit();
    }

    if (isset($_GET['delete_review'])) {
        $review_id = $_GET['delete_review'];
        if ($admin->deleteReview($conn, $review_id)) { //REVIEW
            $_SESSION['success_msg'] = "Review deleted successfully!";
        } else {
            $_SESSION['error_msg'] = "Failed to delete review!";
        }
        header("Location: product_manage.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error_msg'] = "Error occurred: " . $e->getMessage();
    header("Location: product_manage.php");
    exit();
} finally {
    if (isset($stmt)) {
        $stmt = null;
    }
}

// Display messages if any
$success_msg = isset($_SESSION['success_msg']) ? $_SESSION['success_msg'] : '';
$error_msg = isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : '';

// Clear messages after displaying
unset($_SESSION['success_msg']);
unset($_SESSION['error_msg']);


$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->execute([$edit_id]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .product-title { 
            color: #28a745; 
            border-bottom: 2px solid #28a745; 
            padding-bottom: 10px; 
            margin-bottom: 1rem;
        }
        .form-box { 
            border: 2px solid #28a745; 
            padding: 1.25rem; 
            margin-bottom: 2rem; 
            border-radius: .5rem; 
            background: #f8fff8; 
        }
        .product-image { 
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: .3rem;
            border: 1px solid #28a745;
        }
        .preview-image { 
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            margin-top: 10px; 
            border-radius: .3rem;
            border: 1px solid #28a745;
        }
        .btn-back {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .table-success, .table-info {
            background-color: #e9fbe7;
        }
        .text-success, .text-primary {
            color: #28a745 !important;
        }
        .border-success, .border-primary {
            border-color: #28a745 !important;
        }
    </style>
</head>

<body>
    <?php include './admin_header.php'; ?>

    <div class="container">
        <div class="main-container">
            <!-- Display success or error messages -->
            <?php if ($success_msg): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success_msg); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($error_msg): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error_msg); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="mb-4"></div>
            <a href="dashbord.php" class="btn btn-success text-white mb-2"><i class="bi bi-arrow-left"></i> Back to Dashbord</a>
            <h2 class="product-title">Product Management</h2>

            <div class="form-box">
                <h4><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h4>
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($edit_product) { ?>
                        <input type="hidden" name="id" value="<?php echo $edit_product['product_id']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $edit_product['image']; ?>">
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required
                                   value="<?php echo $edit_product ? $edit_product['product_name'] : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select</option>
                                <?php foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat['name']; ?>" <?php if ($edit_product && $edit_product['category_id'] == $cat['category_id']) echo 'selected'; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" required
                                   value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" required
                                   value="<?php echo $edit_product ? $edit_product['quantity'] : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <?php if ($edit_product && $edit_product['image']) { ?>
                            <img src="<?php echo $edit_product['image']; ?>" class="preview-image mt-2">
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"><?php echo $edit_product ? $edit_product['description'] : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <?php if ($edit_product) { ?>
                            <button type="submit" name="update" class="btn btn-warning">Update</button>
                            <a href="product_manage.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php } else { ?>
                            <button type="submit" name="add" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add  Product</button>
                        <?php } ?>
                    </div>
                </form>
            </div>

            <h3 class="mb-3 text-success">All Products</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th scope="col" width="5%">ID</th>
                            <th scope="col" width="15%">Name</th>
                            <th scope="col" width="10%">Category</th>
                            <th scope="col" width="10%">Price / Original</th>
                            <th scope="col" width="8%">Quantity</th>
                            <th scope="col" width="12%">Image</th>
                            <th scope="col" width="25%">Description</th>
                            <th scope="col" width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row): ?>
                            <?php 
                                // Restore price if discount expired
                                $discount->restorePriceIfExpired($conn, $row['product_id']);
                            ?>
                            <tr>
                            <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <?php 
                                // Get current and original price
                                $currentPrice = floatval($row['price']);
                                $originalPrice = !empty($row['original_price']) ? floatval($row['original_price']) : null;
                                
                                // Check for active discount
                                $today = date('Y-m-d');
                                $sql = "SELECT * FROM discount WHERE product_id = ? AND start_date <= ? AND end_date >= ? ORDER BY discount_id DESC LIMIT 1";
                                $stmt = $conn->prepare($sql);
                                $activeDiscount = null;
                                if ($stmt) {
                                    $stmt->execute([$row['product_id'], $today, $today]);
                                    $activeDiscount = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                
                                if ($activeDiscount && $originalPrice) {
                                    // Show discounted price and original price
                                    echo '<strong style="color:#28a745;">Rs. ' . number_format($currentPrice, 2) . '</strong><br>';
                                    echo '<small style="color:#dc3545; text-decoration: line-through;">Original: Rs. ' . number_format($originalPrice, 2) . '</small>';
                                } else if ($originalPrice && $originalPrice != $currentPrice) {
                                    // Show current price and original price (no active discount)
                                    echo '<strong>Rs. ' . number_format($currentPrice, 2) . '</strong><br>';
                                    echo '<small style="color:#6c757d;">Original: Rs. ' . number_format($originalPrice, 2) . '</small>';
                                } else {
                                    // Show only current price
                                    echo '<strong>Rs. ' . number_format($currentPrice, 2) . '</strong>';
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td>
                                <?php if (!empty($row['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>" style="width:80px;height:80px;object-fit:contain;border-radius:8px;">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <?php
                                // Show active discount for this product
                                $discountInfo = null;
                                $today = date('Y-m-d');
                                $sql = "SELECT * FROM discount WHERE product_id = ? AND start_date <= ? AND end_date >= ? ORDER BY discount_id DESC LIMIT 1";
                                $stmt = $conn->prepare($sql);
                                if ($stmt) {
                                    $stmt->execute([$row['product_id'], $today, $today]);
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($result) {
                                        $discountInfo = $result;
                                    }
                                }
                                if ($discountInfo):
                                    $discountPercent = floatval($discountInfo['discount_percentage']);
                                    $originalPrice = !empty($row['original_price']) ? floatval($row['original_price']) : floatval($row['price']);
                                    $discountedPrice = floatval($row['price']); // Current price is already discounted
                                ?>
                                    <div class="mb-1">
                                        <span class="badge bg-success">Active: <?php echo $discountPercent; ?>% OFF</span>
                                        <span class="badge bg-warning text-dark ms-1">Current: Rs. <?php echo number_format($discountedPrice, 2); ?></span>
                                    </div>
                                    <div class="text-muted" style="font-size:0.9em;">
                                        Original: Rs. <?php echo number_format($originalPrice, 2); ?><br>
                                        Valid: <?php echo date('M d', strtotime($discountInfo['start_date'])); ?> - <?php echo date('M d', strtotime($discountInfo['end_date'])); ?>
                                    </div>
                                <?php endif; ?>
                                                                <div class="d-flex">
                                                                        <a href="?edit=<?php echo $row['product_id']; ?>" 
                                                                             class="btn btn-sm btn-warning">Edit</a>
                                                                        <a href="?delete=<?php echo $row['product_id']; ?>" 
                                                                             class="btn btn-sm btn-danger ms-2" 
                                                                             onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                                                        <button type="button" class="btn btn-sm btn-success ms-2" data-bs-toggle="modal" data-bs-target="#discountModal<?php echo $row['product_id']; ?>">
                                                                                Set Discount
                                                                        </button>
                                                                </div>
                                                                <!-- Discount Modal -->
                                                                <div class="modal fade" id="discountModal<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="discountModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <form method="POST">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="discountModalLabel<?php echo $row['product_id']; ?>">Set Discount for <?php echo htmlspecialchars($row['product_name']); ?></h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="discount_product_id" value="<?php echo $row['product_id']; ?>">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Discount Percentage (%)</label>
                                                                                        <input type="number" class="form-control" name="discount_percentage" min="1" max="100" required>
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Start Date</label>
                                                                                        <input type="date" class="form-control" name="start_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">End Date</label>
                                                                                        <input type="date" class="form-control" name="end_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                    <button type="submit" name="set_discount" class="btn btn-success">Save Discount</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="bg-light">
                                <div class="px-3 py-2">
                                    <?php
                                    
                                    //USE GET PRODUCT RATINGS FUNCTION
                                    $ratings = $admin->getProductRatings($conn, $row['product_id']);
                                    if ($ratings): ?>
                                        <div class="rating-summary mb-2">
                                            <strong>Rating Summary:</strong>
                                            Average Rating: <?php echo number_format($ratings['average_rating'], 1); ?> ★ |
                                            Total Reviews: <?php echo $ratings['total_reviews']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    
                                    //USE VIEW REVIEWS FUNCTION
                                    $reviews = $admin->viewReviews($conn, $row['product_id']);
                                    
                                    if (!empty($reviews)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th scope="col" width="15%">
                                                            <i class="bi bi-person"></i> User
                                                        </th>
                                                        <th scope="col" width="15%">
                                                            <i class="bi bi-star-fill"></i> Rating
                                                        </th>
                                                        <th scope="col" width="40%">
                                                            <i class="bi bi-chat-text"></i> Comment
                                                        </th>
                                                        <th scope="col" width="15%">
                                                            <i class="bi bi-calendar"></i> Date
                                                        </th>
                                                        <th scope="col" width="15%">
                                                            <i class="bi bi-gear"></i> Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($reviews as $review): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($review['reviewer_name']); ?></td>
                                                        <td>
                                                            <?php 
                                                            for($i = 1; $i <= 5; $i++) {
                                                                echo $i <= $review['rating'] ? '★' : '☆';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($review['review_date'])); ?></td>
                                                        <td>
                                                            <a href="?delete_review=<?php echo $review['review_id']; ?>" 
                                                               class="btn btn-sm btn-danger"
                                                               onclick="return confirm('Are you sure you want to delete this review?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">No reviews yet for this product.</p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    <script>
    // Add validation for discount date fields
    document.addEventListener('DOMContentLoaded', function() {
        // Get all discount modals
        const discountModals = document.querySelectorAll('[id^="discountModal"]');
        
        discountModals.forEach(function(modal) {
            const startDateInput = modal.querySelector('input[name="start_date"]');
            const endDateInput = modal.querySelector('input[name="end_date"]');
            
            if (startDateInput && endDateInput) {
                // When start date changes, update end date minimum
                startDateInput.addEventListener('change', function() {
                    endDateInput.min = this.value;
                    // If end date is before start date, clear it
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = '';
                    }
                });
                
                // Validate end date is not before start date
                endDateInput.addEventListener('change', function() {
                    if (startDateInput.value && this.value < startDateInput.value) {
                        alert('End date cannot be before start date!');
                        this.value = '';
                    }
                });
            }
        });
    });
    </script>

<?php include './admin_footer.php'; ?>
</body>
</html>