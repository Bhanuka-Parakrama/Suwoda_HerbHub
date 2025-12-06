<?php 
// Handle logout BEFORE any output
session_start();
require_once '../classes/RegisterUser.php';
require_once '../classes/orderClass.php';
require_once '../includes/dbconnect.php';

// Check if user is logged in ---> FUNCTION  HAS CALLED IN HEADER.PHP
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}


$dbConnector = new DbConnector();
$conn = $dbConnector->getConnection();
$order = new Order($dbConnector);

// Fetch user details
$user_id = $_SESSION['user_id'];

$sql = "SELECT name, phone, address FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}
$name = $user['name'];
$phone = $user['phone'];
$address = $user['address'];

// Handle profile update
$profileMessage = '';
if (isset($_POST['update_profile'])) {
    $new_name = $_POST['name'];
    $new_phone = $_POST['phone'];
    $new_address = $_POST['address'];
    // Sri Lankan phone number validation: starts with 0, 10 digits, next digit 7, 1, 2, 3, 4, 5, 6, 8, or 9
    if (!preg_match('/^(0[1-9][0-9]{8})$/', $new_phone)) {
        $profileMessage = '<div class="alert alert-danger">Invalid phone number format. Please enter a valid Sri Lankan phone number (e.g., 0771234567).</div>';
    } else {
        $registerUser = new RegisteredUser();
        $result = $registerUser->updateProfile($user_id, $new_name, $new_phone, $new_address);
        if ($result === true) {
            $profileMessage = '<div class="alert alert-success">Profile updated successfully.</div>';
            $name = $new_name;
            $phone = $new_phone;
            $address = $new_address;
        } else {
            $profileMessage = '<div class="alert alert-danger">Failed to update profile.<br>' . htmlspecialchars($result) . '</div>';
        }
    }
}

// Handle review submission
$showReviewModal = false;
$selectedOrderId = null;
$reviewMessage = '';
$orderProducts = [];

if (isset($_POST['write_review'])) {
    $selectedOrderId = $_POST['order_id'];
    $showReviewModal = true;
    // Use getOrderDetails to get products for this order
    $orderProducts = $order->getOrderDetails($selectedOrderId);
}


if (isset($_POST['submit_review'])) {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    
    if ($product_id && $rating && $comment) {
        //USE WRITE REVIEWS FUNCTION
        $result = $order->writeReviews($user_id, $product_id, $rating, $comment);
        
        $reviewMessage = '<div class="alert alert-' . $result['type'] . '">' . $result['message'] . '</div>';
        
        // If failed validation, keep modal open
        if (!$result['success'] && isset($_POST['order_id'])) {
            $showReviewModal = true;
            $selectedOrderId = $_POST['order_id'];
            $orderProducts = $order->getOrderDetails($selectedOrderId);
        }
    } else {
    $reviewMessage = '<div class="alert alert-danger">Please fill in all fields.</div>';
    $showReviewModal = true;
    $selectedOrderId = $_POST['order_id'];
    $orderProducts = $order->getOrderDetails($selectedOrderId);
    }
}

//USE LOGOUT FUNCTION 
if (isset($_GET['logout'])) {
    RegisteredUser::logout();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
    .rating-btn.active {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
        color: #000 !important;
    }
    </style>
  </head>

  <?php include '../includes/header.php'; ?>

  <body style="background-color: #d4f8e8">
    <div class="container my-5 p-4 bg-white rounded-4 shadow">
      
      <?php if ($reviewMessage): ?>
        <?php echo $reviewMessage; ?>
      <?php endif; ?>
      

            <?php if ($profileMessage): ?>
                <?php echo $profileMessage; ?>
            <?php endif; ?>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <div
                        class="rounded-circle bg-secondary me-3"
                        style="width: 80px; height: 80px"
                    ></div>
                    <div>
                        <h1 class="h3 mb-0">Your Account</h1>
                                                <div id="profileDetails">
                                                    <p class="mb-1"><strong>Name:</strong> <span id="displayName"><?php echo htmlspecialchars($name); ?></span></p>
                                                    <p class="mb-1"><strong>Phone:</strong> <span id="displayPhone"><?php echo htmlspecialchars($phone); ?></span></p>
                                                    <p class="mb-1"><strong>Address:</strong> <span id="displayAddress"><?php echo htmlspecialchars($address); ?></span></p>
                                                    <button type="button" id="editBtn" class="btn btn-warning mt-2">Edit</button>
                                                </div>
                                                <form method="POST" class="mb-2" id="profileForm" style="display:none;">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label"><strong>Name:</strong></label>
                                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="phone" class="form-label"><strong>Phone:</strong></label>
                                                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="address" class="form-label"><strong>Address:</strong></label>
                                                        <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($address); ?>" required>
                                                    </div>
                                                    <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                                                    <button type="button" id="cancelBtn" class="btn btn-secondary ms-2">Cancel</button>
                                                </form>
                                                <script>
                                                    document.getElementById('editBtn').onclick = function() {
                                                        document.getElementById('profileDetails').style.display = 'none';
                                                        document.getElementById('profileForm').style.display = 'block';
                                                    };
                                                    document.getElementById('cancelBtn').onclick = function() {
                                                        document.getElementById('profileForm').style.display = 'none';
                                                        document.getElementById('profileDetails').style.display = 'block';
                                                    };
                                                </script>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="../pages/cart.php" class="btn btn-success">Go to Cart</a>
                </div>
            </div>

      <div class="mt-4">
        <h2 class="h4">My Orders</h2>
        <div class="table-responsive">
          <table class="table align-middle mt-3">
            <thead class="table-light">
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Items</th>
        <th>Item Names</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php

        //USE TRACK ORDERS FUNCTION
        $orders = $order->trackOrders($user_id);

        if (empty($orders)) {
            echo '<tr><td colspan="6" class="text-center text-danger">No orders found for your account.</td></tr>';
        }
        foreach ($orders as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
            <td><?php echo $order['item_count']; ?></td>
            <td>
                <small>
                    <?php echo nl2br(htmlspecialchars(str_replace(', ', "\n", $order['product_names']))); ?>
                </small>
            </td>
            <td>Rs. <?php echo number_format($order['total_price'], 2); ?></td>
            <td>
                <?php
                $status = strtolower($order['status']);
                $badgeClass = 'bg-warning';
                if ($status == 'pending') $badgeClass = 'bg-warning';
                elseif ($status == 'confirmed') $badgeClass = 'bg-info';
                elseif ($status == 'out for delivery') $badgeClass = 'bg-primary';
                elseif ($status == 'delivered') $badgeClass = 'bg-success';
                ?>
                <span class="badge <?php echo $badgeClass; ?>">
                    <?php echo htmlspecialchars($order['status']); ?>
                </span>
            </td>
            <td>
                <?php if ($status == 'delivered'): ?>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        <button type="submit" name="write_review" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-star"></i> Write Review
                        </button>
                    </form>
                <?php else: ?>
                    <small class="text-muted">Review available after delivery (Current: <?php echo htmlspecialchars($order['status']); ?>)</small>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
      </div>

<!-- Review Popup-->
<?php if ($showReviewModal): ?>
<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
    <div class="bg-white rounded shadow-lg" style="width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
            <h3 class="mb-0">Write a Review</h3>
            <form method="POST" style="display: inline;">
                <button type="submit" class="btn-close" aria-label="Close"></button>
            </form>
        </div>
        <div class="p-4">
            <form method="POST">
                <input type="hidden" name="order_id" value="<?php echo $selectedOrderId; ?>">
                
                <div class="mb-3">
                    <label for="productSelect" class="form-label fw-bold">Select Product:</label>
                    <select id="productSelect" name="product_id" required class="form-select">
                        <option value="">Choose a product...</option>
                        <?php foreach ($orderProducts as $product): ?>
                            <option value="<?php echo $product['product_id']; ?>" 
                                    <?php echo ($product['has_review'] == 1) ? 'disabled' : ''; ?>>
                                <?php echo htmlspecialchars($product['product_name']) . ' - Rs.' . number_format($product['unit_price'], 2); ?>
                                <?php echo ($product['has_review'] == 1) ? ' (Already reviewed)' : ''; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Rating:</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <label class="btn btn-outline-warning rating-btn" onclick="selectRating(<?php echo $i; ?>)">
                                <input type="radio" name="rating" value="<?php echo $i; ?>" required class="d-none">
                                <?php echo $i; ?> ★
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="comment" class="form-label fw-bold">Comment:</label>
                    <textarea id="comment" name="comment" rows="4" required class="form-control"
                              placeholder="Share your experience with this product..."></textarea>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-secondary">Cancel</button>
                    <button type="submit" name="submit_review" class="btn btn-success">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

    </div>


   <script>
    function selectRating(rating) {
        document.querySelectorAll('.rating-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        event.currentTarget.classList.add('active');
        event.currentTarget.querySelector('input[type="radio"]').checked = true;
    }
    </script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     
  </body>

<?php include '../includes/footer.php';?>

</html>
