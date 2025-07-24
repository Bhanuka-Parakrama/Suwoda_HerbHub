<?php

class Admin {
    // admin properties
    public $admin_id;
    public $name;
    public $email;
    public $password;

    // constructor
    function __construct($name = "", $email = "", $password = "") {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    // admin login function
    function adminLogin($conn, $email, $password) {
        $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_email'] = $admin['email'];
            return true;
        } else {
            return false;
        }
    }
    
    // admin logout
    function adminLogout() {
        session_start();
        session_destroy();
    }

    // get all categories
    function getCategories($conn) {
        $sql = "SELECT * FROM category ORDER BY category_id DESC";
        return $conn->query($sql);
    }

    // add new category
    function addCategory($conn, $categoryName) {
        $sql = "INSERT INTO category (name) VALUES ('$categoryName')";
        return $conn->query($sql) ? true : false;
    }

    // update category
    function editCategory($conn, $category_id, $newName) {
        $sql = "UPDATE category SET name = '$newName' WHERE category_id = $category_id";
        return $conn->query($sql) ? true : false;
    }

    // delete category
    function removeCategory($conn, $category_id) {
        $sql = "DELETE FROM category WHERE category_id = $category_id";
        return $conn->query($sql) ? true : false;
    }

    // add new product
    function addNewProduct($conn, $product_name, $category_name, $price, $quantity, $image, $description) {
        // first get category id
        $cat_sql = "SELECT category_id FROM category WHERE name = '$category_name'";
        $cat_result = $conn->query($cat_sql);
        $cat_row = $cat_result->fetch_assoc();
        $category_id = $cat_row['category_id'];
        
        // then insert product
        $sql = "INSERT INTO product (product_name, category_id, price, quantity, image, description) VALUES ('$product_name', $category_id, $price, $quantity, '$image', '$description')";
        
        return $conn->query($sql) ? true : false;
    }

    // get all products
    function getAllProducts($conn) {
        $sql = "SELECT p.*, c.name FROM product p JOIN category c ON p.category_id = c.category_id";
        return $conn->query($sql);
    }

    // delete product
    function removeProduct($conn, $product_id) {
        $sql = "DELETE FROM product WHERE product_id = $product_id";
        return $conn->query($sql) ? true : false;
    }

    // update product
    function editProduct($conn, $product_id, $product_name, $category_name, $price, $quantity, $image, $description) {
        // get category id first
        $cat_sql = "SELECT category_id FROM category WHERE name = '$category_name'";
        $cat_result = $conn->query($cat_sql);
        $cat_row = $cat_result->fetch_assoc();
        $category_id = $cat_row['category_id'];
        
        // update product
        $sql = "UPDATE product SET product_name='$product_name', category_id=$category_id, price=$price, quantity=$quantity, image='$image', description='$description' WHERE product_id=$product_id";
        
        return $conn->query($sql) ? true : false;
    }

    // get all users
    function getAllUsers($conn) {
        $sql = "SELECT * FROM user WHERE user_type = 'registered'";
        return $conn->query($sql);
    }

    // update order status
    function changeOrderStatus($conn, $order_id, $status) {
        $sql = "UPDATE `order` SET status = '$status' WHERE order_id = $order_id";
        return $conn->query($sql) ? true : false;
    }
// Add blog - simple version
function addBlog($conn, $title, $content, $image, $date) {
    $sql = "INSERT INTO blog (title, content, image, published_date) VALUES ('$title', '$content', '$image', '$date')";
    return $conn->query($sql);
}

// Get all blogs - simple version  
function getBlogs($conn) {
    $sql = "SELECT * FROM blog ORDER BY published_date DESC";
    return $conn->query($sql);
}

// Delete blog - simple version
function deleteBlog($conn, $blog_id) {
    $sql = "DELETE FROM blog WHERE blog_id = $blog_id";
    return $conn->query($sql);
}

// Get single blog
function getBlog($conn, $blog_id) {
    $sql = "SELECT * FROM blog WHERE blog_id = $blog_id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}


    // add new herb
    function addNewHerb($conn, $name, $scientific_name, $uses, $image) {
        $sql = "INSERT INTO herb (name, scientific_name, uses, image) VALUES ('$name', '$scientific_name', '$uses', '$image')";
        return $conn->query($sql) ? true : false;
    }

    // add discount
    function addProductDiscount($conn, $product_id, $discount_percent, $start_date, $end_date) {
        $sql = "INSERT INTO discount (product_id, discount_percent, start_date, end_date) VALUES ($product_id, $discount_percent, '$start_date', '$end_date')";
        return $conn->query($sql) ? true : false;
    }

    // get monthly sales report
    function getSalesReport($conn, $month, $year) {
        $sql = "SELECT * FROM `order` WHERE MONTH(order_date) = $month AND YEAR(order_date) = $year";
        return $conn->query($sql);
    }

    // get total orders
    function getTotalOrders($conn) {
        $sql = "SELECT COUNT(*) as total FROM `order`";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // get total users
    function getTotalUsers($conn) {
        $sql = "SELECT COUNT(*) as total FROM user WHERE user_type = 'registered'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // get total products
    function getTotalProducts($conn) {
        $sql = "SELECT COUNT(*) as total FROM product";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}

?>