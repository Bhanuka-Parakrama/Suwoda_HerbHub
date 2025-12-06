<?php

require_once '../includes/dbconnect.php';

class Order {
   
    private $order_id;
    private $user_id;
    private $order_date;
    private $total_amount;
    private $status;
    private $db;

    public function __construct($order_id = null) {
        $this->order_id = $order_id;
        $this->db = new DbConnector();
    }


     //PLACE ORDER FUNCTION
     
    public function placeOrder($user_id, $items, $total_price) {
        try {
            $conn = $this->db->getConnection();
            $status = 'Pending';
            
            // Insert into orders table
            $sql_order = "INSERT INTO `orders` (user_id, order_date, total_price, status) VALUES (?, NOW(), ?, ?)";
            $stmt_order = $conn->prepare($sql_order);
            $stmt_order->execute([$user_id, $total_price, $status]);
            $order_id = $conn->lastInsertId();
            
            // Insert item into order_item table
            foreach ($items as $item) {
                $sql_item = "INSERT INTO order_item (order_id, product_id, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?)";
                $subtotal = $item['price'] * $item['quantity'];
                $stmt_item = $conn->prepare($sql_item);
                $stmt_item->execute([$order_id, $item['product_id'], $item['quantity'], $item['price'], $subtotal]);
            }
            
            return $order_id;
        } catch (PDOException $e) {
            error_log('Place order error: ' . $e->getMessage());
            return false;
        }
    }


    //CREATE CHECKOUT SESSION FUNCTION

    public function createCheckoutSession($user_id, $items_data = null) {
    require_once '../vendor/autoload.php';
    require_once __DIR__ . '/cartClass.php';
        
        $stripe_secret_key = "sk_test_51RzKMFRPJVMjUHNE55n8jReVRr5q0goXk0j6CA6VJ4B48UPvRMVPrMmsa5Ect5lNPRbqYfI8sPQktVAoE9kccmjE00SrLyUwjE";
        \Stripe\Stripe::setApiKey($stripe_secret_key);
        
        $line_items = [];
        $total_amount = 0;
        $order_items = [];
        $conn = $this->db->getConnection();
        
    // Check single product purchase or full cart purchase
    if ($items_data) {
            // Single product purchase
            $product_id = (int)$items_data['product_id'];
            $quantity = (int)$items_data['quantity'];
            
            $sql = "SELECT product_name, price, original_price, quantity,
                (SELECT discount_percentage FROM discount WHERE product_id = ? AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY discount_id DESC LIMIT 1) AS discount_percentage
                FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$product_id, $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new Exception("Product not found.");
            }

            $item_name = $product['product_name'];
            $base_price = !empty($product['original_price']) ? (float)$product['original_price'] : (float)$product['price'];
            $available_quantity = (int)$product['quantity'];
            $discount_percent = $product['discount_percentage'];
            if ($discount_percent) {
                $item_price = $base_price * (1 - $discount_percent / 100);
            } else {
                $item_price = $base_price;
            }

            if ($quantity < 1 || $quantity > $available_quantity) {
                throw new Exception("Invalid quantity selected. Only $available_quantity available.");
            }

            $line_items[] = [
                'price_data' => [
                    'currency' => 'lkr',
                    'product_data' => ['name' => $item_name],
                    'unit_amount' => round($item_price * 100),
                ],
                'quantity' => $quantity,
            ];

            $total_amount = $item_price * $quantity;
            $order_items[] = ['product_id' => $product_id, 'quantity' => $quantity, 'price' => $item_price];
            
        } else {
            // Full cart purchase
            $cart = new Cart();
            $cartItems = $cart->getCartItems($user_id);
            if (empty($cartItems)) {
                throw new Exception("Your cart is empty.");
            }
            foreach ($cartItems as $item) {
                $product_id = (int)$item['product_id'];
                $quantity = (int)$item['quantity'];
                // Fetch product details and discount just like Buy Now
                $sql = "SELECT product_name, price, original_price, quantity,
                    (SELECT discount_percentage FROM discount WHERE product_id = ? AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY discount_id DESC LIMIT 1) AS discount_percentage
                    FROM product WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$product_id, $product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$product) {
                    throw new Exception("Product not found (ID: $product_id).");
                }
                $item_name = $product['product_name'];
                $base_price = !empty($product['original_price']) ? (float)$product['original_price'] : (float)$product['price'];
                $available_quantity = (int)$product['quantity'];
                $discount_percent = $product['discount_percentage'];
                if ($discount_percent) {
                    $item_price = $base_price * (1 - $discount_percent / 100);
                } else {
                    $item_price = $base_price;
                }
                if ($quantity < 1 || $quantity > $available_quantity) {
                    throw new Exception("Invalid quantity selected for $item_name. Only $available_quantity available.");
                }
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => ['name' => $item_name],
                        'unit_amount' => round($item_price * 100),
                    ],
                    'quantity' => $quantity,
                ];
                $total_amount += $item_price * $quantity;
                $order_items[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $item_price
                ];
            }
            
        }
        
        // Check minimum order amount
        $minimumLKR = 120;
        if ($total_amount < $minimumLKR) {
            throw new Exception("Minimum order amount for card payments is {$minimumLKR} LKR. Please increase quantity or choose another product.");
        }
        
        //PLACE ORDER
        $this->placeOrder($user_id, $order_items, $total_amount);
        
        // Create Stripe checkout session
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'http://localhost/Suwoda_HerbHub%20-%2006/pages/user_profile.php',
            'cancel_url' => 'http://localhost/phpcode/Suwoda_HerbHub/pages/cancel.php',
        ]);
        
        return $checkout_session;
    }


    //WRITE REVIEWS FUNCTION
      public function writeReviews($userId, $productId, $rating, $comment) {
        try {
            // Check if review already exists
            $checkSql = "SELECT review_id FROM review WHERE user_id = ? AND product_id = ?";
            $checkStmt = $this->db->getConnection()->prepare($checkSql);
            $checkStmt->execute([$userId, $productId]);
            
            if ($checkStmt->fetch()) {
                return ['success' => false, 'message' => 'You have already reviewed this product.', 'type' => 'warning'];
            }
            
            $insertSql = "INSERT INTO review (user_id, product_id, rating, comment, review_date) VALUES (?, ?, ?, ?, NOW())";
            $insertStmt = $this->db->getConnection()->prepare($insertSql);
            
            if ($insertStmt->execute([$userId, $productId, $rating, $comment])) {
                return ['success' => true, 'message' => 'Review submitted successfully!', 'type' => 'success'];
            } else {
                return ['success' => false, 'message' => 'Failed to submit review.', 'type' => 'danger'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error submitting review: ' . $e->getMessage(), 'type' => 'danger'];
        }
    }


    //TRACK ORDERS FUNCTION
    public function trackOrders($user_id) {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT o.order_id, o.order_date, o.status, o.total_price, 
                         COUNT(oi.order_item_id) as item_count,
                         GROUP_CONCAT(p.product_name SEPARATOR ', ') as product_names
                  FROM orders o
                  LEFT JOIN order_item oi ON o.order_id = oi.order_id
                  LEFT JOIN product p ON oi.product_id = p.product_id
                  WHERE o.user_id = ?
                  GROUP BY o.order_id, o.order_date, o.status, o.total_price
                  ORDER BY o.order_date DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Track orders error: ' . $e->getMessage());
            echo '<tr><td colspan="6" class="text-danger">SQL Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
            return [];
        }
    }


     // ORDER MANAGEMENT FUNCTIONS - ADMIN
     // Get order details (admin-style, with items and user info)
    public function getOrderDetails($orderId = null) {
        try {
            $conn = $this->db->getConnection();
            // Get user_id if available in session
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $sql = "SELECT 
                        o.order_id,
                        u.name as username,
                        o.order_date,
                        o.total_price,
                        o.status,
                        p.product_id,
                        p.product_name,
                        oi.quantity,
                        oi.unit_price,
                        (
                            SELECT COUNT(*) FROM review r WHERE r.product_id = p.product_id AND r.user_id = u.user_id
                        ) as has_review
                    FROM `orders` o
                    LEFT JOIN user u ON o.user_id = u.user_id
                    LEFT JOIN order_item oi ON o.order_id = oi.order_id
                    LEFT JOIN product p ON oi.product_id = p.product_id";
            if ($orderId) {
                $sql .= " WHERE o.order_id = :order_id";
            }
            $sql .= " ORDER BY o.order_date DESC";
            $stmt = $conn->prepare($sql);
            if ($orderId) {
                $stmt->execute([':order_id' => $orderId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            error_log("Error fetching order details: " . $e->getMessage());
            return false;
        }
    }

    // Update order status
    public function updateOrderStatus($orderId, $newStatus) {
        try {
            $conn = $this->db->getConnection();
            
            // Validate inputs
            if (empty($orderId) || empty($newStatus)) {
                error_log('Update order status error: Missing order ID or status');
                return false;
            }
            
            // Check if order exists first
            $checkSql = "SELECT order_id FROM orders WHERE order_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute([$orderId]);
            
            if (!$checkStmt->fetch()) {
                error_log('Update order status error: Order ID ' . $orderId . ' not found');
                return false;
            }
            
            // Update the order status
            $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$newStatus, $orderId]);
            
            if ($result && $stmt->rowCount() > 0) {
                error_log('Order status updated successfully: Order ' . $orderId . ' to ' . $newStatus);
                return true;
            } else {
                error_log('Update order status error: No rows affected for Order ID ' . $orderId);
                return false;
            }
        } catch (PDOException $e) {
            error_log('Update order status error: ' . $e->getMessage());
            return false;
        }
    }

  
} 
?>