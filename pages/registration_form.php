<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Register - Suwoda Herbhub</title>
   
     <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />
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
      }
    </style>
  </head>

<?php
include '../includes/header.php';
?>

  <body>
    <div class="center-container">
      <div class="form-border">
        <h2 class="mb-3 text-center">User Registration</h2>
        <form>
          <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Enter your name"
              required
            />
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Email address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              placeholder="Enter your email"
              required
            />
          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Enter your password"
              required
            />
          </div>
          <div class="mb-2">
            <label for="address" class="form-label">Address</label>
            <textarea
              class="form-control"
              id="address"
              rows="2"
              placeholder="Enter your address"
              required
            ></textarea>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input
              type="tel"
              class="form-control"
              id="phone"
              placeholder="Enter your phone number"
              required
            />
          </div>
          <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
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
