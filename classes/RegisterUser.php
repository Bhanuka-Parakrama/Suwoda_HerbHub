<?php

require_once '../classes/GuestUser.php'; 
require_once '../includes/dbconnect.php';

class RegisteredUser extends GuestUser {
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $phone;
    private $address;
    private $dbConnector;

    public function __construct($name = "", $email = "", $password = "", $phone = "", $address = "") {
        // Call parent constructor
        parent::__construct();
        
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->address = $address;
        $this->dbConnector = new DbConnector();
    }

      
    //LOGING FUNCTION

    public function login($email, $password) {
        try {
            $conn = $this->dbConnector->getConnection();
            
            $query = "SELECT * FROM user WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                error_log("Database password: " . $user['password']);
                error_log("Input password: " . $password);
                error_log("Plain text match: " . ($password === $user['password'] ? 'YES' : 'NO'));
                error_log("Hash verify: " . (password_verify($password, $user['password']) ? 'YES' : 'NO'));
                
                // hashed password verification
                if ($password === $user['password'] || password_verify($password, $user['password'])) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_phone'] = $user['phone'];
                    $_SESSION['user_address'] = $user['address'];
                    
                    // Redirect to home page after successful login
                    header('Location: ../pages/index.php');
                    exit();
                }
            } else {
                error_log("User not found with email: " . $email);
            }
            return ['success' => false, 'message' => 'Invalid email or password'];
            
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed. Please try again.'];
        }
    }

 
      //SAVE RATING FUNCTION

        public function saveRating($user_id, $rating) {
            try {
                $conn = $this->dbConnector->getConnection();
                // Ensure a ratings table exists: user_id, rating, created_at
                $query = "INSERT INTO user_ratings (user_id, rating, created_at) VALUES (?, ?, NOW())";
                $stmt = $conn->prepare($query);
                return $stmt->execute([$user_id, $rating]);
            } catch (PDOException $e) {
                error_log('Save rating error: ' . $e->getMessage());
                return false;
            }
        }


    //RESET PASSWORD FUNCTION

    public function resetPassword($email, $newPassword) {
        try {
            $conn = $this->dbConnector->getConnection();
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE user SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$hashed, $email]);
            if ($stmt->rowCount() === 0) {
                // No rows updated, email not found
                return ['success' => false, 'message' => 'Email address not found.'];
            }
            return ['success' => true, 'message' => 'Password reset successful.'];
        } catch (PDOException $e) {
            error_log('Reset password error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }



    //LOGOUT FUNCTION

    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        return true;
    }



    //UPDATE PROFILE FUNCTION
    
    public function updateProfile($user_id, $name, $phone, $address) {
        try {
            $conn = $this->dbConnector->getConnection();
            $query = "UPDATE user SET name = ?, phone = ?, address = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([$name, $phone, $address, $user_id]);
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                return $errorInfo[2]; // Return error message
            }
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    //CHECK IF USER IS LOGGED IN FUNCTION ---> HAS CALLED IN HEADER.PHP
    
    public static function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

 
}
?>