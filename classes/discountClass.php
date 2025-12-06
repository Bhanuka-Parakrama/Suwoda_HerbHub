<?php
class Discount {
    private $discount_id;
    private $product_id;
    private $discount_percentage;
    private $start_date;
    private $end_date;

    // Function to make a discount
    public function makeDiscount($conn, $product_id, $discount_percentage, $start_date, $end_date) {
        $this->product_id = $product_id;
        $this->discount_percentage = $discount_percentage;
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        // Get current price and original_price
        $stmt = $conn->prepare("SELECT price, original_price FROM product WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) return false;

        $current_price = floatval($product['price']);
        $original_price = $product['original_price'] !== null ? floatval($product['original_price']) : null;

        // Save original price if not already set
        if ($original_price === null) {
            $stmt = $conn->prepare("UPDATE product SET original_price = ? WHERE product_id = ?");
            $stmt->execute([$current_price, $product_id]);
            $original_price = $current_price; // Update our local variable
        }

        // Calculate discounted price based on original price
        $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

        // Update product price to discounted price
        $stmt = $conn->prepare("UPDATE product SET price = ? WHERE product_id = ?");
        $stmt->execute([$discounted_price, $product_id]);

        // Insert discount record
        $sql = "INSERT INTO discount (product_id, discount_percentage, start_date, end_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $result = $stmt->execute([$product_id, $discount_percentage, $start_date, $end_date]);
            return $result;
        } else {
            return false;
        }
    }

    // Restore product price if discount expired
    public function restorePriceIfExpired($conn, $product_id) {
        // Check if discount is expired
        $today = date('Y-m-d');
        $stmt = $conn->prepare("SELECT * FROM discount WHERE product_id = ? AND end_date >= ? ORDER BY discount_id DESC LIMIT 1");
        $stmt->execute([$product_id, $today]);
        $active_discount = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$active_discount) {
            // No active discount, restore original price
            $stmt = $conn->prepare("SELECT original_price FROM product WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product && $product['original_price'] !== null) {
                $stmt = $conn->prepare("UPDATE product SET price = original_price, original_price = NULL WHERE product_id = ?");
                $stmt->execute([$product_id]);
            }
        }
    }
}
