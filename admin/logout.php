<?php
session_start();

// Destroy all session data
session_destroy();

// Clear all session cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Clear any admin-specific cookies
if (isset($_COOKIE['admin_logged_in'])) {
    setcookie('admin_logged_in', '', time() - 3600, '/');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Suwoda Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="card shadow-lg" style="width: 400px;">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="card-title text-primary mb-3">Logout Successful</h2>
                    <p class="card-text text-muted mb-4">
                        You have been successfully logged out from the admin panel.
                    </p>
                    <div class="mt-4">
                        <a href="../pages/index.php" class="btn btn-primary">
                            <i class="bi bi-house-door me-2"></i>Go to Home Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>