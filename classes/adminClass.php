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

    // Admin Login
    public static function login($conn, $email, $password) {
        $query = "SELECT * FROM user WHERE email = ? AND user_type = 'admin'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['admin_id'] = $admin['user_id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                return $admin;
            }
        }
        return false;
    }

    // Logout
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function addProduct($conn, $name, $category_id, $price, $desc, $image, $stock, $status) {
        $query = "INSERT INTO product (name, category_id, price, description, image, stock_quantity, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sidssis", $name, $category_id, $price, $desc, $image, $stock, $status);
        return $stmt->execute();
    }

    public function updateProduct($conn, $product_id, $name, $category_id, $price, $desc, $image, $stock, $status) {
        $query = "UPDATE product SET name=?, category_id=?, price=?, description=?, image=?, stock_quantity=?, status=?
                  WHERE product_id=?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sidssisi", $name, $category_id, $price, $desc, $image, $stock, $status, $product_id);
        return $stmt->execute();
    }

    public function deleteProduct($conn, $product_id) {
        $query = "DELETE FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        return $stmt->execute();
    }

    public function addCategory($conn, $name) {
        $query = "INSERT INTO category (name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $name);
        return $stmt->execute();
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

    public function addBlog($conn, $title, $content) {
        $query = "INSERT INTO blog (admin_id, title, content, published_date)
                  VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $_SESSION['admin_id'], $title, $content);
        return $stmt->execute();
    }

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
