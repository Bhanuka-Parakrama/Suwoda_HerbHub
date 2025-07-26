<?php

include '../src/PHPMailer.php';
include '../src/SMTP.php';
include '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class GuestUser {
    // guest user properties
    public $guest_id;
    public $session_id;
    public $language;

    // constructor
    function __construct($language = "en") {
        $this->language = $language;
        $this->session_id = session_id();
    }

    // browse products function
    function browseProducts($conn) {
        $sql = "SELECT * FROM products WHERE status = 'active'";
        return $conn->query($sql);
    }

    // search products function
    function searchProducts($conn, $keyword) {
        $sql = "SELECT * FROM product WHERE product_name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
        return $conn->query($sql);
    }

    // read blogs function
    function readBlogs($conn) {
        $sql = "SELECT * FROM blogs WHERE status = 'published'";
        return $conn->query($sql);
    }

    // herbal dictionary function
    function useHerbalDictionary($conn) {
        $sql = "SELECT * FROM herbs";
        return $conn->query($sql);
    }

    // select language function
    function selectLanguage($lang) {
        $_SESSION['lang'] = $lang;
        $this->language = $lang;
    }

    // view product details function
    function viewProductDetails($conn, $product_id) {
        $sql = "SELECT * FROM products WHERE product_id = $product_id AND status = 'active'";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    // register user function
    function registerUser($conn, $name, $email, $password, $phone, $address) {
        // check if email exists
        $check_sql = "SELECT * FROM user WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            return "Email already exists.";
        }

        // validate password
        if (!$this->validatePassword($password)) {
            return "Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        // insert user
        $sql = "INSERT INTO user (name, email, password, phone, address, status, verification_token) VALUES ('$name', '$email', '$hashed_password', '$phone', '$address', 'inactive', '$token')";
        
        if ($conn->query($sql)) {
            // send verification email
            if ($this->sendVerificationEmail($email, $token, $name)) {
                return true;
            } else {
                return "Failed to send verification email.";
            }
        } else {
            return "Registration failed. Please try again.";
        }
    }

    // validate password function
    function validatePassword($password) {
        if (strlen($password) >= 8) {
            if (preg_match('/[A-Z]/', $password) && 
                preg_match('/[a-z]/', $password) && 
                preg_match('/[0-9]/', $password) && 
                preg_match('/[@$!%*?&]/', $password)) {
                return true;
            }
        }
        return false;
    }

    // send verification email function
    function sendVerificationEmail($email, $token, $name) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'suwodaherbhub@gmail.com';
        $mail->Password = 'pqni ogho wkzf kyho';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPDebug = 0;

        $mail->setFrom('suwodaherbhub@gmail.com', 'Suwoda HerbHub');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - Suwoda HerbHub';
        
        $baseURL = $this->getBaseURL();
        $verificationLink = $baseURL . "/pages/verify.php?token=" . $token;
        
        $mail->Body = $this->getEmailTemplate($name, $verificationLink);
        $mail->AltBody = "Dear $name, Welcome to Suwoda HerbHub! Please verify your email by clicking this link: $verificationLink";

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    // get base URL function
    function getBaseURL() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname(dirname($_SERVER['SCRIPT_NAME']));
        return $protocol . '://' . $host . $path;
    }

    // get email template function
    function getEmailTemplate($name, $verificationLink) {
        $template = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Email Verification</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h1 style='color: white; margin: 0; font-size: 28px;'>Welcome to Suwoda HerbHub!</h1>
            </div>
            
            <div style='background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; border: 1px solid #ddd;'>
                <h2 style='color: #333; margin-top: 0;'>Hello $name!</h2>
                
                <p>Thank you for registering with Suwoda HerbHub. To complete your registration and activate your account, please verify your email address.</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='$verificationLink' 
                       style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; font-size: 16px;'>
                        Verify My Email
                    </a>
                </div>
                
                <p><strong>Important:</strong> This verification link will expire in 24 hours for security reasons.</p>
                
                <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
                <p style='background: #f0f0f0; padding: 10px; border-radius: 5px; word-break: break-all; font-size: 14px;'>$verificationLink</p>
                
                <hr style='border: none; border-top: 1px solid #ddd; margin: 30px 0;'>
                
                <p style='font-size: 14px; color: #666;'>
                    If you didn't create an account with Suwoda HerbHub, please ignore this email.
                </p>
                
                <div style='text-align: center; margin-top: 20px;'>
                    <p style='margin: 0; color: #666;'>Best regards,<br><strong>Suwoda HerbHub Team</strong></p>
                </div>
            </div>
        </body>
        </html>";
        
        return $template;
    }

    // resend verification email function
    function resendVerificationEmail($conn, $email) {
        $sql = "SELECT name, verification_token FROM user WHERE email = '$email' AND status = 'inactive'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if ($this->sendVerificationEmail($email, $user['verification_token'], $user['name'])) {
                return "Verification email sent successfully!";
            } else {
                return "Failed to send verification email.";
            }
        } else {
            return "No inactive account found with this email address.";
        }
    }

    // get all categories function
    function getCategories($conn) {
        $sql = "SELECT * FROM category ORDER BY category_id DESC";
        return $conn->query($sql);
    }

    // get products by category function
    function getProductsByCategory($conn, $category_id) {
        $sql = "SELECT * FROM product WHERE category_id = $category_id";
        return $conn->query($sql);
    }

    // get featured products function
    function getFeaturedProducts($conn) {
        $sql = "SELECT * FROM product WHERE featured = 1 LIMIT 6";
        return $conn->query($sql);
    }

    // get single blog function
    function getBlogDetails($conn, $blog_id) {
        $sql = "SELECT * FROM blog WHERE blog_id = $blog_id";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    // contact us function
    function sendContactMessage($conn, $name, $email, $subject, $message) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message, created_date) VALUES ('$name', '$email', '$subject', '$message', NOW())";
        return $conn->query($sql) ? true : false;
    }

    // newsletter subscription function
    function subscribeNewsletter($conn, $email) {
        $check_sql = "SELECT * FROM newsletter WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            return "Email already subscribed.";
        }
        
        $sql = "INSERT INTO newsletter (email, subscribed_date) VALUES ('$email', NOW())";
        return $conn->query($sql) ? "Successfully subscribed!" : "Subscription failed.";
    }
}

?>