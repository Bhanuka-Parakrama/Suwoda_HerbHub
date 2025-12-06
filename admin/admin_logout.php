<?php

include '../includes/dbconnect.php';
include '../classes/adminClass.php';

$db = new DbConnector();
$conn = $db->getConnection();
$admin = new Admin($conn);
$admin->adminLogout(); //USE ADMIN LOGOUT

if (isset($_COOKIE['admin_logged_in'])) {
    setcookie('admin_logged_in', '', time() - 3600, '/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - HerbHub Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .logout-card {
            border: 2px solid #28a745;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.15);
        }
        .success-icon {
            font-size: 4rem;
        }
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #f8f9fa 100%);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-success text-white py-2 text-center">
        <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Admin</h4>
    </header>
    <div class="mb-4"></div>
    <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="card logout-card shadow-lg" style="width: 450px;">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill success-icon text-success"></i>
                    </div>
                    <h2 class="card-title text-success mb-3">
                        <i class="bi bi-door-open me-2"></i>Logout Successful
                    </h2>
                    <p class="card-text text-muted mb-4">
                        You have been successfully logged out from Suwoda HerbHub Admin Panel. 
                    </p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="../pages/index.php" class="btn btn-success">
                            <i class="bi bi-house-door me-2"></i>Return to Home Page
                        </a>
                        <a href="../pages/login.php" class="btn btn-outline-success">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Again
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-success text-white text-center py-2 mt-auto">
        &copy; 2025 Suwoda HerbHub. All rights reserved.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>