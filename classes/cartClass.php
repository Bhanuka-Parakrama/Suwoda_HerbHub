<?php

require_once '../includes/dbconnect.php';

class Cart {
    private $cart_id;
    private $product_id;
    private $user_id;
    private $quantity;
    private $db;
    
    public function __construct($cart_id = null, $product_id = null, $user_id = null, $quantity = 0) {
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->quantity = $quantity;
        $this->db = new DbConnector();
    }


    //ADD TO CART FUNCTION

    public static function addToCart($conn, $userId, $productId) {
        // Check it already in cart
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        if ($stmt->rowCount() > 0) {
            return false;
        }
        // Insert into cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        if ($stmt->execute([$userId, $productId])) {
            return true;
        } else {
            error_log("Add to cart failed: " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }



    //GET CART ITEMS FUNCTION

        public function getCartItems($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.product_name, p.price, p.image,
            (SELECT discount_percentage FROM discount WHERE product_id = p.product_id AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY discount_id DESC LIMIT 1) AS discount_percentage,
            (SELECT start_date FROM discount WHERE product_id = p.product_id AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY discount_id DESC LIMIT 1) AS discount_start,
            (SELECT end_date FROM discount WHERE product_id = p.product_id AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY discount_id DESC LIMIT 1) AS discount_end
            FROM cart c
            JOIN product p ON c.product_id = p.product_id
            WHERE c.user_id = ?");
        $stmt->execute([$user_id]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Calculate discounted price if discount is active
            if ($row['discount_percentage']) {
                $row['discounted_price'] = $row['price'] - ($row['price'] * $row['discount_percentage'] / 100);
            } else {
                $row['discounted_price'] = $row['price'];
            }
            $items[] = $row;
        }
        return $items;
    }



    //UPDATE CART QUANTITY FUNCTION
     public function updateCartQuantity($user_id, $product_id, $quantity) {
        try {
            $conn = $this->db->getConnection();
            if ($quantity < 1) {
                $quantity = 1;
            }
            $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$quantity, $user_id, $product_id]);
        } catch (PDOException $e) {
            error_log('Update cart quantity error: ' . $e->getMessage());
            return false;
        }
    }

    

    //REMOVE FROM CART FUNCTION

    public function removeFromCart($user_id, $product_id) {
        try {
            $conn = $this->db->getConnection();
            $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$user_id, $product_id]);
        } catch (PDOException $e) {
            error_log('Remove from cart error: ' . $e->getMessage());
            return false;
        }
    }
}

?>