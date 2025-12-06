<?php

class Admin {
    // admin properties
    public $admin_id;
    public $name;
    public $email;
    public $password;
    private $conn;

    // constructor
    public function __construct($conn, $name = "", $email = "", $password = "") {
        $this->conn = $conn;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    //ADMIN LOGING FUNCTION
    public function adminLogin($email, $password) {
        $sql = "SELECT * FROM admin WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':password' => $password]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_email'] = $admin['email'];
            return true;
        } else {
            return false;
        }
    }
    
    //ADMIN LOGOUT FUNCTION
   public function adminLogout() {
        session_start();
        session_destroy();
    }

     //CATEGORY MANAGEMENT (SWITCH TO categoryClass.php FOR ACTUAL OPERATIONS)
     public function manageCategory($action, ...$params) {
            require_once __DIR__ . '/categoryClass.php';
            $categoryManager = new Category();
            switch ($action) {
                case 'get':
                    if (isset($params[0])) {
                        // Get single category
                        return $categoryManager->getAllCategories($this->conn, $params[0]);
                    } else {
                        // Get all categories
                        return Category::getAllCategories($this->conn);
                    }
                case 'add':
                    return $categoryManager->addCategory($this->conn, ...$params);
                case 'update':
                    throw new Exception('Category update not supported');
                case 'delete':
                    return $categoryManager->removeCategory($this->conn, $params[0]);
                default:
                    throw new Exception('Unknown action');
            }
        }

    // PRODUCT MANAGEMENT (SWITCH TO productClass.php FOR ACTUAL OPERATIONS)
    public function manageProduct($action, ...$params) {
        require_once __DIR__ . '/productClass.php';
        $productManager = new Product();
        switch ($action) {
            case 'get':
                return Product::getAllProducts($this->conn);
            case 'add':
                return $productManager->addProduct($this->conn, ...$params);
            case 'update':
                return $productManager->editProduct($this->conn, ...$params);
            case 'delete':
                return $productManager->removeProduct($this->conn, $params[0]);
            default:
                throw new Exception('Unknown action');
        }
    }

    // BLOG MANAGEMENT (SWITCH TO blogClass.php FOR ACTUAL OPERATIONS)
    public function manageBlog($action, ...$params) {
        require_once __DIR__ . '/blogClass.php';
        $blogManager = new Blog();
        switch ($action) {
            case 'get':
                return $blogManager->getBlogs($this->conn, $params[0] ?? null);
            case 'add':
                return $blogManager->addBlog($this->conn, ...$params);
            case 'delete':
                return $blogManager->deleteBlog($this->conn, $params[0]);
            default:
                throw new Exception('Unknown action');
        }
    }

    // HERB MANAGEMENT (DICTIONARY) (SWITCH TO herbClass.php FOR ACTUAL OPERATIONS)
    public function manageHerb($action, ...$params) {
        require_once __DIR__ . '/herbClass.php';
        $herbManager = new Herb();
        switch ($action) {
            case 'get':
                return $herbManager->getHerbs($params[0] ?? null);
            case 'add':
                return $herbManager->addHerb(...$params);
            case 'update':
                return $herbManager->updateHerb(...$params);
            case 'delete':
                return $herbManager->deleteHerb($params[0]);
            case 'getImage':
                return $herbManager->getHerbImage($params[0]);
            default:
                throw new Exception('Unknown action');
        }
    }

     // DISCOUNT MANAGEMENT (SWITCH TO discountClass.php FOR ACTUAL OPERATIONS)
    public function manageDiscount($action, ...$params) {
        require_once __DIR__ . '/discountClass.php';
        $discountManager = new Discount();
        if ($action === 'add') {
            // Params: product_id, discount_percentage, start_date, end_date
            return $discountManager->makeDiscount($this->conn, ...$params);
        } else {
            throw new Exception('Only add action');
        }
    }

    // ORDER MANAGEMENT (SWITCH TO orderClass.php FOR ACTUAL OPERATIONS)
    public function manageOrder($action, ...$params) {
        require_once __DIR__ . '/orderClass.php';
        $order = new Order();
        switch ($action) {
            case 'view_all':
                return $order->getOrderDetails();
            case 'view_one':
                if (isset($params[0])) {
                    return $order->getOrderDetails($params[0]);
                }
                break;
            case 'update_status':
                if (isset($params[0], $params[1])) {
                    return $order->updateOrderStatus($params[0], $params[1]);
                }
                break;
            case 'update': // Add backward compatibility
                if (isset($params[0], $params[1])) {
                    return $order->updateOrderStatus($params[0], $params[1]);
                }
                break;
            default:
                error_log("Unknown order action: " . $action);
                return null;
        }
    }


    //USER MANAGEMENT
    //View users 
    public function viewUser($conn, $user_id) {
        $stmt = $conn->prepare("SELECT name, email, address, phone FROM user WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // REVIEW MANAGEMENT
    // View all reviews
    public function viewReviews($conn, $product_id = null) {
        $sql = "SELECT r.review_id, r.rating, r.comment, r.review_date,
                   u.name as reviewer_name, p.product_name
            FROM review r 
            JOIN user u ON r.user_id = u.user_id 
            JOIN product p ON r.product_id = p.product_id";
        if ($product_id) {
            $sql .= " WHERE r.product_id = :product_id";
        }
        $sql .= " ORDER BY r.review_date DESC";
        $stmt = $conn->prepare($sql);
        if ($product_id) {
            $stmt->execute([':product_id' => $product_id]);
        } else {
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get product rating 
    public function getProductRatings($conn, $product_id = null) {
        $sql = "SELECT p.product_name, p.product_id,
               AVG(r.rating) as average_rating,
               COUNT(r.review_id) as total_reviews
            FROM product p
            LEFT JOIN review r ON p.product_id = r.product_id";
        if ($product_id) {
            $sql .= " WHERE p.product_id = :product_id";
        }
        $sql .= " GROUP BY p.product_id, p.product_name
              ORDER BY average_rating DESC";
        $stmt = $conn->prepare($sql);
        if ($product_id) {
            $stmt->execute([':product_id' => $product_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Delete review
    public function deleteReview($conn, $review_id) {
        $sql = "DELETE FROM review WHERE review_id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $review_id]);
    }

   
}


