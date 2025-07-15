<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login - Suwoda HerbHub</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .center-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .form-border {
        border: 2px solid #198754;
        border-radius: 12px;
        padding: 18px 24px;
        background: #fff;
        box-shadow: 0 0 16px rgba(0, 0, 0, 0.1);
        max-width: 350px;
        width: 100%;
      }
      .form-label {
        font-size: 0.95rem;
      }
      .form-control {
        font-size: 0.95rem;
        padding: 6px 10px;
      }
      h3 {
        font-size: 1.4rem;
      }
    </style>
  </head>

<?php
include '../includes/dbconnect.php';
include '../classes/RegisterUser.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $result = RegisteredUser::login($conn, $email, $password);
        
        if ($result['success']) {
            $message = $result['message'];
            // Redirect to home page after successful login
            header("Location: ../index.php");
            exit();
        } else {
            $error = $result['message'];
        }
    } else {
        $error = "Email and password are required.";
    }
}

include '../includes/header.php';
?>

  <body>
    <div class="center-container">
      <div class="form-border">
        <h3 class="text-center mb-4">User Login</h3>
        
        <?php if (!empty($message)): ?>
          <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter email"
              value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
              required
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Password"
              required
            />
          </div>
          <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
        
        <div class="text-center mt-3">
          <p class="mb-0">Don't have an account? <a href="registration_form.php" class="text-decoration-none">Register here</a></p>
        </div>
        
        <div class="text-center mt-2">
          <p class="mb-0"><a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a></p>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

<?php
include '../includes/footer.php';
?>