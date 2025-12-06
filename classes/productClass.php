<?php

require_once '../includes/dbconnect.php';

class Product {
    private $product_id;
    private $product_name;
    private $category_id;
    private $price;
    private $quantity;
    private $image;
    private $description;
    private $db;

    public function __construct($product_id = null) {
        $this->product_id = $product_id;
        $this->db = new DbConnector();
    }

    //GET ALL PRODUCTS FUNCTION - public 
    public static function getAllProducts($conn) {
        try {
            $sql = "SELECT p.*, c.name as category_name FROM product p LEFT JOIN category c ON p.category_id = c.category_id ORDER BY p.product_id DESC";
            $result = $conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting products: " . $e->getMessage());
            return [];
        }
    }


     //GET PRODUCT REVIEWS FUNCTION -- public
      public static function getProductReviews($conn, $product_id) {
        try {
            $sql = "SELECT r.*, u.name FROM review r 
                    LEFT JOIN user u ON r.user_id = u.user_id 
                    WHERE r.product_id = ? 
                    ORDER BY r.review_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$product_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting product reviews: " . $e->getMessage());
            return [];
        }
    }
    

    //GET AVERAGE RATING FUNCTION -- public
     public function getAverageRating($conn, $product_id = null) {
        try {
            $id = $product_id ?? $this->product_id;
            if (!$id) {
                return 0;
            }

            $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                    FROM review 
                    WHERE product_id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'average_rating' => round($result['avg_rating'], 1),
                'total_reviews' => $result['total_reviews']
            ];
        } catch (Exception $e) {
            error_log("Error getting average rating: " . $e->getMessage());
            return ['average_rating' => 0, 'total_reviews' => 0];
        }
    }


     //SEARCH PRODUCT FUNCTION -- public
     public function searchProducts($keyword) {
        $conn = $this->db->getConnection(); 
        $sql = "SELECT * FROM product WHERE product_name LIKE ? OR description LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = '%' . $keyword . '%';
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt;
    }


    //UPDATE STOCK FUNCTION 
    public static function updateStock($conn, $product_id, $quantity) {
        try {
            $sql = "UPDATE product SET quantity = quantity - ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([$quantity, $product_id]);
        } catch (Exception $e) {
            error_log("Error updating stock: " . $e->getMessage());
            return false;
        }
    }



    //PRODUCT MANAGEMENT FUNCTIONS 

    //Add new product -- admin
   public function addProduct($conn, $product_name, $category_name, $price, $quantity, $image, $description) {
        $cat_sql = "SELECT category_id FROM category WHERE name = :name";
        $cat_stmt = $conn->prepare($cat_sql);
        $cat_stmt->execute([':name' => $category_name]);
        $cat_row = $cat_stmt->fetch(PDO::FETCH_ASSOC);
        $category_id = $cat_row['category_id'];

        $sql = "INSERT INTO product (product_name, category_id, price, quantity, image, description) VALUES (:product_name, :category_id, :price, :quantity, :image, :description)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':product_name' => $product_name,
            ':category_id' => $category_id,
            ':price' => $price,
            ':quantity' => $quantity,
            ':image' => $image,
            ':description' => $description
        ]);
    }

    
    //Delete product -- admin
    function removeProduct($conn, $product_id) {
        $sql = "DELETE FROM product WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $product_id]);
    }

    //Update product -- admin
    function editProduct($conn, $product_id, $product_name, $category_name, $price, $quantity, $image, $description) {
        $cat_sql = "SELECT category_id FROM category WHERE name = :name";
        $cat_stmt = $conn->prepare($cat_sql);
        $cat_stmt->execute([':name' => $category_name]);
        $cat_row = $cat_stmt->fetch(PDO::FETCH_ASSOC);
        $category_id = $cat_row['category_id'];

        $sql = "UPDATE product SET product_name=:product_name, category_id=:category_id, price=:price, quantity=:quantity, image=:image, description=:description WHERE product_id=:product_id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':product_id' => $product_id,
            ':product_name' => $product_name,
            ':category_id' => $category_id,
            ':price' => $price,
            ':quantity' => $quantity,
            ':image' => $image,
            ':description' => $description
        ]);
    }


}
?>