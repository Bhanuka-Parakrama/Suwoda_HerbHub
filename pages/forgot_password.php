<?php
session_start();
include '../includes/dbconnect.php';
include '../classes/GuestUser.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (!$email) {
        $error = "Please enter your email address.";
    } else {
        $guest = new GuestUser();
        $result = $guest->sendPasswordResetEmail($conn, $email);
        
        if ($result === true) {
            $message = "Password reset link has been sent to your email address.";
        } else {
            $error = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - HerbHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .forgot-password-form {
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.1);
            margin-top: 50px;
        }
         
        .form-control:focus {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }
        
        .text-success {
            color: #28a745 !important;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #f8f9fa 100%);
            min-height: 100vh;
        }
        
        .info-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<?php include '../includes/header.php'; ?>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="forgot-password-form">
                <a href="login_form.php" class="btn btn-success mb-3">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Login
                </a>
                <div class="text-center mb-4">
                    <h2 class="text-success">
                        <i class="bi bi-key me-2"></i>Forgot Password
                    </h2>
                    <p class="text-muted">Enter your email to reset your password</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Enter your registered email" required 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
                        </div>
                    </div>

                    <div class="info-text mb-4">
                        <i class="bi bi-info-circle me-1"></i>
                        We will send you a password reset link to your email address. Please check your inbox and spam folder.
                    </div>

                    <button type="submit" class="btn btn-success w-100 mb-3">
                        <i class="bi bi-envelope-arrow-up me-2"></i>Send Reset Link
                    </button>
                </form>

                <div class="text-center">
                    <p class="mb-2">
                        Remember your password? 
                        <a href="login_form.php" class="text-success text-decoration-none fw-bold">
                            Login here
                        </a>
                    </p>
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="registration_form.php" class="text-success text-decoration-none">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-5"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

<?php include '../includes/footer.php'; ?>
</html>