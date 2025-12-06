<?php
require_once '../includes/dbconnect.php';

//USE DB CONNECTOR CLASS TO CONNECT DATABASE
$dbConnector = new DbConnector();
$conn = $dbConnector->getConnection();

$message = '';
$error = '';
$success = false;

$token = $_GET['token'] ?? '';

if ($token) {
    //check token exists and valid
    $stmt = $conn->prepare("SELECT user_id, name, email FROM user WHERE verification_token = ? AND status = 'inactive'");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Update user status to active and clear the token
        $update = $conn->prepare("UPDATE user SET status = 'active', verification_token = NULL WHERE verification_token = ?");
        
        if ($update->execute([$token])) {
            $success = true;
            $message = "Your account has been successfully verified!";
            
            // Set session and redirect to category selection
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: category_select.php');
            exit;
        } else {
            $error = "Failed to verify account. Please try again or contact support.";
        }
    } else {
        $error = "Invalid or expired verification token. The link may have already been used.";
    }
} else {
    $error = "No verification token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Suwoda HerbHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .center-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-card {
            border-radius: 12px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .error-icon {
            color: #dc3545;
            font-size: 4rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<?php include '../includes/header.php'; ?>

<body>
    <div class="center-container">
        <div class="verification-card">
            <?php if ($success): ?>
                <div class="success-icon">✓</div>
                <h2 class="text-success mb-3">Email Verified Successfully!</h2>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <p class="text-muted mb-4">Welcome to Suwoda HerbHub! Your account is now active.</p>
                <div class="mt-4">
                    <a href="login.php" class="btn btn-success btn-lg">Login Now</a>
                </div>
            <?php else: ?>
                <div class="error-icon">✗</div>
                <h2 class="text-danger mb-3">Verification Failed</h2>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <div class="mt-4">
                    <a href="registration.php" class="btn btn-secondary me-2">Register Again</a>
                    <a href="login.php" class="btn btn-success">Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

<?php include '../includes/footer.php'; ?>
</html>