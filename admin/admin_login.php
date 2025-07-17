<?php
session_start();
include '../classes/adminClass.php';
include '../includes/dbconnect.php'; 

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $admin = new Admin();

    if ($admin->login($conn, $email, $password)) {
        header("Location: dashbord.php");
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .admin-login-form {
            border: 2px solid #0d6efd;
            border-radius: 15px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.1);
            margin-top: 50px;
        }
        
        .btn-primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a58ca !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }
        
        .form-control:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="admin-login-form">
                <a href="../pages/index.php" class="btn btn-primary mb-3">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Home
                </a>
                <div class="text-center mb-4">
                    <h2 class="text-primary"><i class="bi bi-person-circle me-2"></i>Admin Login</h2>
                    <p class="text-muted">Please enter your email to access HerbHub Admin</p>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="admin_login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Enter your email" required 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter your password" required />
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>
</html>
