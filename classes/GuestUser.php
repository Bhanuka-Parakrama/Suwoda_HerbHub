<?php

require_once __DIR__ . '/../src/PHPMailer.php';
require_once __DIR__ . '/../src/SMTP.php';
require_once __DIR__ . '/../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class GuestUser {
    public function browseProducts($conn) {
        $query = "SELECT * FROM products WHERE status = 'active'";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchProducts($conn, $keyword) {
        $search = "%" . $conn->real_escape_string($keyword) . "%";
        $query = "SELECT * FROM product WHERE (product_name LIKE ? OR description LIKE ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
        try {
            // Start transaction
            $conn->begin_transaction();

            // Check if email already exists
            $check_stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                $conn->rollback();
                return "Email already exists.";
            }

            // Validate password strength
            if (!$this->validatePassword($password)) {
                $conn->rollback();
                return "Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.";
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(32));

            // Insert user
            $stmt = $conn->prepare("INSERT INTO user (name, email, password, phone, address, status, verification_token) VALUES (?, ?, ?, ?, ?, 'inactive', ?)");
            $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $address, $token);

            if ($stmt->execute()) {
                // Send verification email
                $emailResult = $this->sendVerificationEmail($email, $token, $name);
                if ($emailResult !== true) {
                    $conn->rollback();
                    return $emailResult;
                }
                
                $conn->commit();
                return true;
            } else {
                $conn->rollback();
                return "Registration failed. Please try again.";
            }
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Registration error: " . $e->getMessage());
            return "Registration failed. Please try again.";
        }
    }

    private function validatePassword($password) {
        // At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    private function sendVerificationEmail($email, $token, $name) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'suwodaherbhub@gmail.com';
            $mail->Password = 'pqni ogho wkzf kyho'; // Consider using environment variables
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Turn off debug output for production
            $mail->SMTPDebug = 0;

            // Recipients
            $mail->setFrom('suwodaherbhub@gmail.com', 'Suwoda HerbHub');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - Suwoda HerbHub';
            
            // Get the base URL dynamically
            $baseURL = $this->getBaseURL();
            $verificationLink = $baseURL . "/pages/verify.php?token=" . $token;
            
            $mail->Body = $this->getEmailTemplate($name, $verificationLink);
            $mail->AltBody = "Dear $name,\n\nWelcome to Suwoda HerbHub! Please verify your email by clicking this link: $verificationLink\n\nIf you can't click the link, copy and paste it into your browser.\n\nBest regards,\nSuwoda HerbHub Team";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return "Failed to send verification email. Please try again or contact support.";
        }
    }

    private function getBaseURL() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname(dirname($_SERVER['SCRIPT_NAME'])); // Go up two levels from current script
        return $protocol . '://' . $host . $path;
    }

    private function getEmailTemplate($name, $verificationLink) {
        return "
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
                <h2 style='color: #333; margin-top: 0;'>Hello " . htmlspecialchars($name) . "!</h2>
                
                <p>Thank you for registering with Suwoda HerbHub. To complete your registration and activate your account, please verify your email address.</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . htmlspecialchars($verificationLink) . "' 
                       style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; font-size: 16px;'>
                        Verify My Email
                    </a>
                </div>
                
                <p><strong>Important:</strong> This verification link will expire in 24 hours for security reasons.</p>
                
                <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
                <p style='background: #f0f0f0; padding: 10px; border-radius: 5px; word-break: break-all; font-size: 14px;'>" . htmlspecialchars($verificationLink) . "</p>
                
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
    }

    // Method to resend verification email
    public function resendVerificationEmail($conn, $email) {
        $stmt = $conn->prepare("SELECT name, verification_token FROM user WHERE email = ? AND status = 'inactive'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $emailResult = $this->sendVerificationEmail($email, $user['verification_token'], $user['name']);
            return $emailResult === true ? "Verification email sent successfully!" : $emailResult;
        } else {
            return "No inactive account found with this email address.";
        }
    }
}
?>