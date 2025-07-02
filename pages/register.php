<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Suwoda HerbHub</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../assets/styles.css" />
</head>
<?php
include '../includes/header.php';
?>

<body>

  <div class="container">
    <div class="login-box"> 
      <h3 class="text-center mb-4">Register at Suwoda</h3>
      <form action="register_process.php" method="POST">
        
        <div class="mb-3">
          <label for="name" class="form-label">Full Name:</label>
          <input type="text" id="name" name="name" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address:</label>
          <input type="email" id="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Address:</label>
          <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone Number:</label>
          <input type="tel" id="phone" name="phone" class="form-control" pattern="[0-9]{10,15}" 
                 title="Enter a valid phone number" required />
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Register</button>
        </div>
      </form>

      <p class="mt-3 text-center text-muted">
        Already have an account? <a href="loging.php">Login</a>
      </p>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
<?php
include '../includes/footer.php';
?>


