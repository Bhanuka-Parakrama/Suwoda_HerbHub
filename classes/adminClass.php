<?php

class Admin {
    private $admin_id;
    private $name;
    private $email;
    private $password;

    public function __construct($name = "", $email = "", $password = "") {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function login($conn, $email, $password) {
        $query = "SELECT * FROM admin WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error); // ✅ helpful debug
        }

        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_email'] = $admin['email'];
            return true;
        } else {
            return false;
        }
    }

    
    // Logout
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

  

    
    //categories management

    public function getAllCategories($conn) {
        $query = "SELECT * FROM category ORDER BY category_id DESC";
        $result = $conn->query($query);
        return $result;
    }


    public function updateCategory($conn, $category_id, $newName) {
        $query = "UPDATE category SET name = ? WHERE category_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $newName, $category_id);
        return $stmt->execute();
    }

    public function deleteCategory($conn, $category_id) {
        $query = "DELETE FROM category WHERE category_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $category_id);
        return $stmt->execute();
    }

 
    //product management
public function addProduct($conn, $product_name, $name, $price, $quantity, $imagePath, $description) {
        $stmt = $conn->prepare("SELECT category_id FROM category WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($category_id);
        $stmt->fetch();
        $stmt->close();

        $query = "INSERT INTO product (product_name, category_id, price, quantity, image, description)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siddss", $product_name, $category_id, $price, $quantity, $imagePath, $description);
        return $stmt->execute();
    }

    public static function getProducts($conn) {
        $query = "SELECT p.*, c.name FROM product p JOIN category c ON p.category_id = c.category_id";
        return $conn->query($query);
    }

    public function deleteProduct($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateProduct($conn, $id, $product_name, $category_name, $price, $quantity, $imagePath, $description) {
        $stmt = $conn->prepare("SELECT category_id FROM category WHERE name = ?");
        $stmt->bind_param("s", $category_name); // Fix: change $name to $category_name
        $stmt->execute();
        $stmt->bind_result($category_id);
        $stmt->fetch();
        $stmt->close();

        $query = "UPDATE product SET product_name=?, category_id=?, price=?, quantity=?, image=?, description=? WHERE product_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siddssi", $product_name, $category_id, $price, $quantity, $imagePath, $description, $id);
        return $stmt->execute();
    }

    public static function getCategories($conn) {
        return $conn->query("SELECT * FROM category");
    }

   

    //user management

    public function getAllUsers($conn) {
        $query = "SELECT * FROM user WHERE user_type = 'registered'";
        $result = $conn->query($query);
        return $result;
    }

    public function updateOrderStatus($conn, $order_id, $status) {
        $query = "UPDATE `order` SET status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $order_id);
        return $stmt->execute();
    }


    //blog management

    public function addBlog($conn, $title, $content, $imagePath) {
        $query = "INSERT INTO blog (title, content, image, published_date) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $content, $imagePath);
        return $stmt->execute();
    }

    public static function viewBlogs($conn) {
        $query = "SELECT * FROM blog ORDER BY published_date DESC";
        $result = $conn->query($query);
        $blogs = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $blogs[] = $row;
            }
        }
        return $blogs;
    }

    public function deleteBlog($conn, $blog_id) {
        $query = "DELETE FROM blog WHERE blog_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $blog_id);
        return $stmt->execute();
    }




    //herb management
    public function addHerb($conn, $name, $sci_name, $uses, $image) {
        $query = "INSERT INTO herb (name, scientific_name, uses, image)
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $sci_name, $uses, $image);
        return $stmt->execute();
    }

    public function addDiscount($conn, $product_id, $percent, $start_date, $end_date) {
        $query = "INSERT INTO discount (product_id, discount_percent, start_date, end_date)
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idss", $product_id, $percent, $start_date, $end_date);
        return $stmt->execute();
    }

    // Generate Monthly Sales Report
    public function getMonthlySalesReport($conn, $month, $year) {
        $query = "SELECT * FROM `order` WHERE MONTH(order_date) = ? AND YEAR(order_date) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
