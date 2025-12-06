<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/AdminClass.php';

$db = new DbConnector();
$conn = $db->getConnection();

// Initialize Admin
$admin = new Admin($conn);

// Update order status using manageOrder
if (isset($_POST['updateStatus'])) {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['status'];
    
    // Validate inputs
    if (empty($orderId) || empty($newStatus)) {
        $errorMessage = "Invalid order ID or status provided.";
    } else {
        $result = $admin->manageOrder('update_status', $orderId, $newStatus);
        if ($result) {
            $successMessage = "Order #" . str_pad($orderId, 5, '0', STR_PAD_LEFT) . " status updated to '" . $newStatus . "' successfully!";
        } else {
            $errorMessage = "Failed to update order status. Please check if the order exists and try again.";
        }
    }
}

// Get all orders with details (
$orders = $admin->manageOrder('view_all');

// Status options
$statusOptions = ['Pending', 'Confirmed', 'Out for Delivery', 'Delivered'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        .container {
            background: white; padding: 25px; margin-top: 20px; border-radius: 8px;
        }
        main {
            flex: 1 0 auto;
        }
        .container { background: white; padding: 25px; margin-top: 20px; border-radius: 8px; }
        .order-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-confirmed { background-color: #17a2b8; color: white; }
        .status-out-for-delivery { background-color: #fd7e14; color: white; }
        .status-delivered { background-color: #28a745; color: white; }
        .order-details { font-size: 0.9em; }
        .filter-section { 
            background-color: #f8fff8; 
            border: 2px solid #28a745; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 5px; 
        }
        .order-items {
            font-size: 0.85em;
            max-height: 100px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            padding: 8px;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        .action-buttons .btn {
            margin-right: 8px;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>
    <?php include './admin_header.php'; ?>

     <main>
     <div class="container">
        <a href="dashbord.php" class="btn btn-success mb-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        
        <h2 class="order-title">
            <i class="bi bi-cart-check"></i> Order Management
        </h2>

        <?php if (isset($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <?php if (isset($errorMessage)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <!-- Filter Section -->
        <div class="filter-section">
            <h5>Filter Orders</h5>
            <div class="row">
                <div class="col-md-4">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <?php foreach ($statusOptions as $status) { ?>
                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" onclick="clearFilters()">Clear</button>
                </div>
            </div>
        </div>

        <!-- Orders Summary -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="text-warning"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'Pending'; })); ?></h5>
                        <small>Pending</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="text-info"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'Confirmed'; })); ?></h5>
                        <small>Confirmed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="text-warning"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'Out for Delivery'; })); ?></h5>
                        <small>Out for Delivery</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="text-success"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'Delivered'; })); ?></h5>
                        <small>Delivered</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="text-primary"><?php echo count($orders); ?></h5>
                        <small>Total Orders</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <h3 class="mb-3 text-success">All Orders</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="ordersTable">
                <thead class="table-success">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Items</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)) { ?>
                        <tr>
                            <td colspan="7" class="text-center">No orders found</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><strong>#<?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></strong></td>
                                <td>
                                    <div class="order-details">
                                        <strong><?php echo $order['username']; ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="order-items">
                                        <?php 
                                        $items = $admin->manageOrder('view_one', $order['order_id']);
                                        if (!empty($items)) {
                                            foreach ($items as $item) {
                                                echo htmlspecialchars($item['product_name']) . ' (Qty: ' . $item['quantity'] . ', Rs.' . number_format($item['unit_price'], 2) . ')<br>';
                                            }
                                        } else {
                                            echo '<small class="text-muted">No items found</small>';
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td>
                                <td>
                                    <strong>Rs.<?php echo number_format($order['total_price'], 2); ?></strong>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-primary" 
                                                onclick="showStatusModal(<?php echo $order['order_id']; ?>, '<?php echo $order['status']; ?>')">
                                            <i class="bi bi-pencil"></i> Update
                                        </button>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </main>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="orderId" id="modalOrderId">
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-select" name="status" id="modalStatus" required>
                                <?php foreach ($statusOptions as $status) { ?>
                                    <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="updateStatus" class="btn btn-success">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Status options in order
        const statusOptions = ['Pending', 'Confirmed', 'Out for Delivery', 'Delivered'];

        function showStatusModal(orderId, currentStatus) {
            document.getElementById('modalOrderId').value = orderId;

            // Filter status options so only next statuses are shown
            const modalStatus = document.getElementById('modalStatus');
            modalStatus.innerHTML = '';
            let startIndex = statusOptions.indexOf(currentStatus);
            // If current status is not found, show all
            if (startIndex === -1) startIndex = 0;
            // Always allow current and next statuses, but not previous
            for (let i = startIndex; i < statusOptions.length; i++) {
                const opt = document.createElement('option');
                opt.value = statusOptions[i];
                opt.textContent = statusOptions[i];
                if (statusOptions[i] === currentStatus) opt.selected = true;
                modalStatus.appendChild(opt);
            }
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        }

        function clearFilters() {
            document.getElementById('statusFilter').value = '';
            filterTable();
        }

        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const table = document.getElementById('ordersTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let row of rows) {
                let showRow = true;
                const cells = row.getElementsByTagName('td');
                
                if (cells.length < 7) continue;
                
                const status = cells[5].textContent.toLowerCase().trim();
                
                if (statusFilter && !status.includes(statusFilter)) {
                    showRow = false;
                }
                
                row.style.display = showRow ? '' : 'none';
            }
        }

        //status filter
        document.getElementById('statusFilter').addEventListener('change', filterTable);
    </script>

    <?php include './admin_footer.php'; ?>
</body>
</html>