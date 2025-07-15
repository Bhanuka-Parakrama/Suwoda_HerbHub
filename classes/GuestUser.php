<?php

class GuestUser {
    public function browseProducts($conn) {
        $query = "SELECT * FROM products WHERE status = 'active'";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function readBlogs($conn) {
        $query = "SELECT * FROM blogs WHERE status = 'published'";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function useHerbalDictionary($conn) {
        $query = "SELECT * FROM herbs";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function selectLanguage($lang) {
        $_SESSION['lang'] = $lang;
    }

    public function viewProductDetails($conn, $product_id) {
        $query = "SELECT * FROM products WHERE product_id = ? AND status = 'active'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function registerUser($conn, $name, $email, $password, $phone, $address) {
        if (!$conn) {
            die("Database connection not available.");
        }

        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            return "Email already exists. Please use a different email.";
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO user (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return "Registration failed. Please try again.";
        }
    }

    public function loginUser($conn, $email, $password) {
        $stmt = $conn->prepare("SELECT user_id, name, email, password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify the password against the hash
            if (password_verify($password, $user['password'])) {
                // Password is correct
                return [
                    'success' => true,
                    'user_id' => $user['user_id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        
        return ['success' => false, 'message' => 'Invalid email or password'];
    }

}
?>