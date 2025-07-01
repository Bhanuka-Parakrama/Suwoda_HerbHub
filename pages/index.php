<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Suwoda HerbHub</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
  />

</head>
<?php
include '../includes/header.php';
?>
<body>

  <!-- Welcome Banner -->
  <div class="container my-5">
    <div class="p-5 text-center bg-success bg-opacity-75 text-white rounded shadow">
      <h1 class="display-4 fw-bold">Welcome to Suwoda HerbHub</h1>
      <p class="lead">Discover the best Ayurvedic and indigenous herbal products crafted with care.</p>
      <a href="#products" class="btn btn-light btn-lg mt-3">Explore Products</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mt-4 content-box" id="products">
    <h2 class="text-center mb-5">Our Herbal Product Categories</h2>
    <div class="row g-4">
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/oils3.jpeg" alt="Herbal oils" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Herbal Oils</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/ayurvedic tea.jpg" alt="Ayurvedic teas" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Ayurvedic Teas</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/herbal powders.jpg" alt="Herbal Powders" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Herbal Powders & Capsules</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/soaps&skincare.jpg" alt="Soaps & Skincare" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Soaps & Skincare</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/balms.jpg" alt="Pain Relief Balms & Creams" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Pain Relief Balms & Creams</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/wellness.jpg" alt="Wellness Tonics & Syrups" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Wellness Tonics & Syrups</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/hair care.jpg" alt="Hair Care" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Hair Care</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/baby care.jpeg" alt="Baby Care" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Baby Care</h5>
            <a href="#" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"
  ></script>
</body>
</html>

<?php
include '../includes/footer.php';
?>
