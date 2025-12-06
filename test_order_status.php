<?php
// Test script to verify order status update functionality
session_start();
require_once 'includes/dbconnect.php';
require_once 'classes/adminClass.php';
require_once 'classes/orderClass.php';

echo "<h2>Order Status Update Test</h2>";

$db = new DbConnector();
$conn = $db->getConnection();
$admin = new Admin($conn);

try {
    // Test 1: Get all orders to see what's available
    echo "<h3>Test 1: Getting all orders</h3>";
    $orders = $admin->manageOrder('view_all');
    
    if (empty($orders)) {
        echo "<p><strong>No orders found in the database.</strong></p>";
        echo "<p>To test order status updates, you need to have some orders in the system first.</p>";
    } else {
        echo "<p>Found " . count($orders) . " orders:</p>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Order ID</th><th>User</th><th>Current Status</th><th>Total Price</th><th>Order Date</th></tr>";
        
        $testOrderId = null;
        $testCurrentStatus = null;
        
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order['order_id'] . "</td>";
            echo "<td>" . htmlspecialchars($order['username']) . "</td>";
            echo "<td>" . htmlspecialchars($order['status']) . "</td>";
            echo "<td>Rs. " . number_format($order['total_price'], 2) . "</td>";
            echo "<td>" . $order['order_date'] . "</td>";
            echo "</tr>";
            
            // Store first order for testing
            if ($testOrderId === null) {
                $testOrderId = $order['order_id'];
                $testCurrentStatus = $order['status'];
            }
        }
        echo "</table>";
        
        // Test 2: Update order status
        if ($testOrderId !== null) {
            echo "<h3>Test 2: Testing order status update</h3>";
            echo "<p>Testing with Order ID: $testOrderId (Current Status: $testCurrentStatus)</p>";
            
            // Determine next status for testing
            $statusFlow = ['Pending', 'Confirmed', 'Out for Delivery', 'Delivered'];
            $currentIndex = array_search($testCurrentStatus, $statusFlow);
            
            if ($currentIndex !== false && $currentIndex < count($statusFlow) - 1) {
                $newStatus = $statusFlow[$currentIndex + 1];
            } else {
                $newStatus = 'Confirmed'; // Reset to confirmed if already delivered
            }
            
            echo "<p>Attempting to update status from '$testCurrentStatus' to '$newStatus'...</p>";
            
            // Test using manageOrder method
            $result = $admin->manageOrder('update_status', $testOrderId, $newStatus);
            
            if ($result) {
                echo "<p style='color: green;'><strong>✓ SUCCESS:</strong> Order status updated successfully!</p>";
                
                // Verify the update by getting the order again
                $updatedOrders = $admin->manageOrder('view_one', $testOrderId);
                if (!empty($updatedOrders)) {
                    $updatedStatus = $updatedOrders[0]['status'];
                    echo "<p>Verified: Order $testOrderId status is now: <strong>$updatedStatus</strong></p>";
                    
                    if ($updatedStatus === $newStatus) {
                        echo "<p style='color: green;'><strong>✓ VERIFICATION PASSED:</strong> Status correctly updated in database!</p>";
                    } else {
                        echo "<p style='color: red;'><strong>✗ VERIFICATION FAILED:</strong> Expected '$newStatus', but found '$updatedStatus'</p>";
                    }
                } else {
                    echo "<p style='color: orange;'><strong>⚠ WARNING:</strong> Could not retrieve updated order for verification</p>";
                }
            } else {
                echo "<p style='color: red;'><strong>✗ FAILED:</strong> Order status update failed!</p>";
                
                // Test direct method call for more details
                echo "<p>Testing direct orderClass method...</p>";
                $orderObj = new Order();
                $directResult = $orderObj->updateOrderStatus($testOrderId, $newStatus);
                
                if ($directResult) {
                    echo "<p style='color: green;'>Direct method call succeeded</p>";
                } else {
                    echo "<p style='color: red;'>Direct method call also failed</p>";
                }
            }
        }
    }
    
    // Test 3: Test both action names for compatibility
    echo "<h3>Test 3: Testing action name compatibility</h3>";
    if (isset($testOrderId)) {
        echo "<p>Testing 'update_status' action...</p>";
        $result1 = $admin->manageOrder('update_status', $testOrderId, 'Confirmed');
        echo $result1 ? "<p style='color: green;'>✓ 'update_status' works</p>" : "<p style='color: red;'>✗ 'update_status' failed</p>";
        
        echo "<p>Testing 'update' action (backward compatibility)...</p>";
        $result2 = $admin->manageOrder('update', $testOrderId, 'Pending');
        echo $result2 ? "<p style='color: green;'>✓ 'update' works</p>" : "<p style='color: red;'>✗ 'update' failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>ERROR:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h3>Test Summary</h3>";
echo "<p>This test verifies that:</p>";
echo "<ul>";
echo "<li>Orders can be retrieved from the database</li>";
echo "<li>Order status can be updated using the admin interface methods</li>";
echo "<li>Both 'update_status' and 'update' actions work for backward compatibility</li>";
echo "<li>Database changes are properly persisted</li>";
echo "</ul>";

echo "<p><a href='admin/order_manage.php'>Go to Order Management</a> | <a href='admin/dashbord.php'>Go to Admin Dashboard</a></p>";
?>