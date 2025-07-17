<?php
include '../includes/dbconnect.php';
include '../classes/GuestUser.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name && $email && $password && $phone && $address) {
        $guest = new GuestUser();
        $result = $guest->registerUser($conn, $name, $email, $password, $phone, $address);

        if ($result === true) {
            $message = "Registration successful! You can now login.";
            // header("Location: login_form.php");
            // exit();
        } else {
            $error = $result;  // error message from registerUser method
        }
    } else {
        $error = "All fields are required.";
    }
}

include '../includes/header.php';
?>

<style>
  body,
  html {
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
  .form-control,
  textarea {
    font-size: 0.95rem;
    padding: 6px 10px;
  }
  h2 {
    font-size: 1.4rem;
    color: #0d6efd;
  }
  .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    transition: all 0.3s ease;
  }
  .btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
  }
</style>

<div class="center-container">
  <div class="form-border">
    <h2 class="mb-3 text-center">User Registration</h2>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-2">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          name="name"
          placeholder="Enter your name"
          value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
          required
        />
      </div>
      <div class="mb-2">
        <label for="email" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="Enter your email"
          value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
          required
        />
      </div>
      <div class="mb-2">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Enter your password"
          minlength="8"
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
          title="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character"
          required
        />
        <div class="form-text">
          <small>Password must be at least 8 characters with uppercase, lowercase, number, and special character.</small>
        </div>
      </div>
      <div class="mb-2">
        <label for="phone" class="form-label">Phone Number</label>
        <input
          type="tel"
          class="form-control"
          id="phone"
          name="phone"
          placeholder="Enter your phone number"
          value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
          required
        />
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea
          class="form-control"
          id="address"
          name="address"
          rows="2"
          placeholder="Enter your address"
          required
        ><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
      </div>
      <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <div class="text-center mt-3">
      <p class="mb-0">Already have an account? <a href="login_form.php" class="text-decoration-none text-primary">Login here</a></p>
    </div>
  </div>
</div>

<?php
include '../includes/footer.php';
?>
