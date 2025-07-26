<?php
session_start();
include '../includes/dbconnect.php';
include '../classes/GuestUser.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if (!$name || !$email || !$password || !$phone || !$address) {
        $error = "All fields are required.";
    } else {
        $guest = new GuestUser();
        $result = $guest->registerUser($conn, $name, $email, $password, $phone, $address);

        if ($result === true) {
            $message = "Registration successful! Please check your email to verify your account.";
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
    <title>User Registration - HerbHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .registration-form {
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.1);
            margin-top: 30px;
            margin-bottom: 30px;
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
        
        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>

<?php include '../includes/header.php'; ?>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="registration-form">
                <a href="index.php" class="btn btn-success mb-3">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Home
                </a>
                <div class="text-center mb-4">
                    <h2 class="text-success">
                        <i class="bi bi-person-plus me-2"></i>User Registration
                    </h2>
                    <p class="text-muted">Create your HerbHub account to get started</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?php echo($message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Enter your full name" required
                                       value="<?php echo($_POST['name'] ?? ''); ?>" />
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
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
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Create a strong password" required
                                       minlength="8"
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                       title="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character" />
                            </div>
                            <div class="password-requirements mt-1">
                                <small>Must contain: uppercase, lowercase, number, and special character (@$!%*?&)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       placeholder="Enter your phone number" required
                                       value="<?php echo($_POST['phone'] ?? ''); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label">Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <textarea class="form-control" id="address" name="address" rows="3"
                                      placeholder="Enter your complete address" required><?php echo($_POST['address'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg mb-3">
                        <i class="bi bi-person-check me-2"></i>Create Account
                    </button>
                </form>

                <div class="text-center">
                    <p class="mb-0">
                        Already have an account? 
                        <a href="login.php" class="text-success text-decoration-none fw-bold">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

<?php include '../includes/footer.php'; ?>
</html>