<?php

require_once 'GuestUser.php';

class RegisteredUser extends GuestUser {
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $phone;
    private $address;

    public function __construct($name = "", $email = "", $password = "", $phone = "", $address = "") {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->address = $address;
    }

    public static function login($conn, $email, $password) {
        if (!$conn) {
            return ['success' => false, 'message' => 'Database connection failed'];
        }

        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_address'] = $user['address'];
                
                return [
                    'success' => true,
                    'user' => $user,
                    'message' => 'Login successful'
                ];
            }
        }
        return ['success' => false, 'message' => 'Invalid email or password'];
    }

    public function addToCart($conn, $user_id, $product_id, $qty) {
        // Check if product already exists in cart
        $check_query = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing quantity
            $row = $result->fetch_assoc();
            $new_qty = $row['quantity'] + $qty;
            $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $new_qty, $row['id']);
            return $update_stmt->execute();
        } else {
            // Insert new item
            $query = "INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $user_id, $product_id, $qty);
            return $stmt->execute();
        }
    }

    public function getCartItems($conn, $user_id) {
        $query = "SELECT c.*, p.name, p.price, p.image 
                  FROM cart c 
                  JOIN products p ON c.product_id = p.product_id 
                  WHERE c.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function removeFromCart($conn, $user_id, $product_id) {
        $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $product_id);
        return $stmt->execute();
    }

    public function placeOrder($conn, $user_id, $total_amount) {
        $conn->begin_transaction();
        
        try {
            // Insert order
            $order_query = "INSERT INTO `order` (user_id, order_date, status, total_amount)
                           VALUES (?, NOW(), 'pending', ?)";
            $order_stmt = $conn->prepare($order_query);
            $order_stmt->bind_param("id", $user_id, $total_amount);
            $order_stmt->execute();
            
            $order_id = $conn->insert_id;
            
            // Get cart items
            $cart_items = $this->getCartItems($conn, $user_id);
            
            // Insert order items
            foreach ($cart_items as $item) {
                $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price)
                              VALUES (?, ?, ?, ?)";
                $item_stmt = $conn->prepare($item_query);
                $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
                $item_stmt->execute();
            }
            
            // Clear cart
            $clear_query = "DELETE FROM cart WHERE user_id = ?";
            $clear_stmt = $conn->prepare($clear_query);
            $clear_stmt->bind_param("i", $user_id);
            $clear_stmt->execute();
            
            $conn->commit();
            return $order_id;
            
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }

    public function trackOrders($conn, $user_id) {
        $query = "SELECT o.*, COUNT(oi.id) as item_count 
                  FROM `order` o 
                  LEFT JOIN order_items oi ON o.order_id = oi.order_id 
                  WHERE o.user_id = ? 
                  GROUP BY o.order_id 
                  ORDER BY o.order_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function writeReview($conn, $user_id, $product_id, $rating, $comment) {
        // Check if user has already reviewed this product
        $check_query = "SELECT id FROM review WHERE user_id = ? AND product_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        
        if ($check_stmt->get_result()->num_rows > 0) {
            return "You have already reviewed this product";
        }
        
        $query = "INSERT INTO review (user_id, product_id, rating, comment, review_date)
                  VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $comment);
        return $stmt->execute();
    }

    public static function resetPassword($conn, $email, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE user SET password = ?, updated_at = NOW() WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed, $email);
        return $stmt->execute();
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }

    public static function getProfile($conn, $user_id) {
        $query = "SELECT user_id, name, email, phone, address, created_at FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($conn, $user_id, $name, $email, $phone, $address) {
        $query = "UPDATE user SET name = ?, email = ?, phone = ?, address = ?, updated_at = NOW() WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);
        return $stmt->execute();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>