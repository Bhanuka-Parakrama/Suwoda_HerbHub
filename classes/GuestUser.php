<?php

require_once '../includes/dbconnect.php';
require_once '../src/PHPMailer.php';
require_once '../src/SMTP.php';
require_once '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class GuestUser {
  
    private $guest_id;
    private $session_id;
    private $conn;

    // constructor
    public function __construct($guest_id = null) {
        $this->guest_id = $guest_id;
        $this->session_id = session_id();
        $db = new DbConnector();
        $this->conn = $db->getConnection();
    }


    //SELECT LANGUAGE FUNCTION
    public function selectLanguage($lang) {
        $_SESSION['lang'] = $lang;
    }


    //USER REGISTRATION FUNCTION

    public function userRegistration($name, $email, $password, $phone, $address) {
        // check if email exists
        $check_sql = "SELECT * FROM user WHERE email = ?";
        $check_stmt = $this->conn->prepare($check_sql);
        $check_stmt->execute([$email]);
        
        if ($check_stmt->rowCount() > 0) {
            return "Email already exists.";
        }

        // validate password
        if (!$this->validatePassword($password)) {
            return "Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        // insert user
        $sql = "INSERT INTO user (name, email, password, phone, address, status, verification_token) VALUES (?, ?, ?, ?, ?, 'inactive', ?)";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt->execute([$name, $email, $hashed_password, $phone, $address, $token])) {
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
    

    //VALIDATE PASSWORD FUNCTION
    private function validatePassword($password) {
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



    //SEND VERIFICATION EMAIL FUNCTION 

    private function sendVerificationEmail($email, $token, $name) { 
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
    private function getBaseURL() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname(dirname($_SERVER['SCRIPT_NAME']));
        return $protocol . '://' . $host . $path;
    }


    //Get email template
    private function getEmailTemplate($name, $verificationLink) {
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


    //SAVE USER CATEGORIES FUNCTION

    public function saveUserCategories($user_id, $category_ids) {
        // Remove previous selections
        $delete_sql = "DELETE FROM user_category WHERE user_id = ?";
        $delete_stmt = $this->conn->prepare($delete_sql);
        $delete_stmt->execute([$user_id]);

        // Insert new selections
        $insert_sql = "INSERT INTO user_category (user_id, category_id) VALUES (?, ?)";
        $insert_stmt = $this->conn->prepare($insert_sql);
        foreach ($category_ids as $cat_id) {
            $insert_stmt->execute([$user_id, $cat_id]);
        }
        return true;
    }

    //GET USERS PRODUCTS FUNCTION --- index pageno 
    public function getUserCategories($user_id, $limit = 5) {
        $limit = (int)$limit;
        $sql = "SELECT p.* FROM product p
                JOIN user_category uc ON p.category_id = uc.category_id
                WHERE uc.user_id = ?
                LIMIT $limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>