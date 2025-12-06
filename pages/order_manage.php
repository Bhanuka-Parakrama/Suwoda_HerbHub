<?php
session_start();
require_once '../classes/orderClass.php';
require_once '../includes/dbconnect.php';

// Check admin login (customize as needed)
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit();
}

$dbConnector = new DbConnector();
$order = new Order($dbConnector);

// Get orderId from GET or POST
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : (isset($_POST['order_id']) ? $_POST['order_id'] : null);
$orderItems = [];
if ($orderId) {
    $orderItems = $order->getOrderDetails($orderId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Manage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4">Order Details</h2>
    <?php if ($orderId && $orderItems): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Reviewed</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>Rs. <?php echo number_format($item['unit_price'], 2); ?></td>
                    <td><?php echo ($item['has_review'] ? 'Yes' : 'No'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($orderId): ?>
        <div class="alert alert-warning">No items found for this order.</div>
    <?php else: ?>
        <form method="get" class="mb-4">
            <div class="input-group">
                <input type="number" name="order_id" class="form-control" placeholder="Enter Order ID" required>
                <button type="submit" class="btn btn-primary">Show Items</button>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
