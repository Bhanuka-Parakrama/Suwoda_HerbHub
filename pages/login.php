<?php 
session_start(); 
require_once '../includes/dbconnect.php'; 
require_once '../classes/RegisterUser.php'; 

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    require_once '../includes/dbconnect.php';
    require_once '../classes/adminClass.php';
    $db = new DbConnector();
    $conn = $db->getConnection();
    $admin = new Admin($conn);

    //admin login using Admin class
    if ($admin->adminLogin($email, $password)) {
        header('Location: ../admin/dashbord.php');
        exit();
    }

    //user login using RegisteredUser class
    $registeredUser = new RegisteredUser();
    $loginResult = $registeredUser->login($email, $password);
    if ($loginResult['success']) {
        header("Location: user_profile.php");
        exit();
    } else {
        $loginError = $loginResult['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Suwoda HerbHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .user-login-form {
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
    </style>
</head>

<?php include '../includes/header.php'; ?>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="user-login-form">
                <a href="index.php" class="btn btn-success mb-3">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Home
                </a>
                <div class="text-center mb-4">
                    <h2 class="text-success">
                        <i class="bi bi-person-check me-2"></i>User Login
                    </h2>
                    <p class="text-muted">Please enter your credentials to access your account</p>
                </div>

                <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo($loginError); ?>
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
                                   placeholder="Enter your email" required 
                                   value="<?php echo($_POST['email'] ?? ''); ?>" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter your password" required />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login to Account
                    </button>
                </form>

                <div class="text-center">
                    <p class="mb-2">
                        Don't have an account? 
                        <a href="registration.php" class="text-success text-decoration-none fw-bold">
                            Register here
                        </a>
                    </p>
                    <p class="mb-0">
                        <a href="forgot_password.php" class="text-success text-decoration-none">
                            <i class="bi bi-question-circle me-1"></i>Forgot Password?
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-5"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

<?php include '../includes/footer.php'; ?>
</html>