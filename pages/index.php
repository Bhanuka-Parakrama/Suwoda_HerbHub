<?php
// Include necessary files
require_once '../includes/dbconnect.php'; // $conn = new mysqli(...)
require_once '../classes/CategoryClass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/styles.css">
</head>

<?php include '../includes/header.php';?>

<body>
<!-- Welcome Banner -->
<div class="container-fluid px-0 mb-4" style="margin-top: 10px;">
  <div id="welcomeBanner" class="p-5 text-center bg-dark bg-opacity-50 text-white position-relative"
       style="background-size: cover; background-position: center; background-repeat: no-repeat; transition: background-image 1s ease-in-out; min-height: 400px; border-radius: 20px; margin: 0 15px; overflow: hidden;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <img src="../assets/images/Logo.jpg" alt="Suwoda HerbHub Logo" class="mb-3"
               style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 0 15px rgba(0,0,0,0.3);">
          <h1 class="display-1 fw-bold" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.9); font-size: 4rem; letter-spacing: 2px;">
            Welcome to Suwoda HerbHub</h1>
          <p class="lead fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8); color: #f8f9fa; font-size: 1.5rem;">
            Discover the best Ayurvedic and indigenous herbal products crafted with care.</p>
          <a href="#categoryDetails" class="btn btn-success btn-lg mt-3" style="border-radius: 30px; padding: 12px 30px;">Explore Category</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container" style="max-width: 800px;">
<div class="row">
  <div class="col-12">
    <div class="text-center mb-2">
      <h2 class="display-6 fw-bold text-success mb-1">
        🌿 About Suwoda HerbHub
      </h2>
      <div class="mx-auto" style="width: 60px; height: 2px; background: linear-gradient(90deg, #198754, #20c997); border-radius: 2px;"></div>
    </div>
  </div>
</div>

<div class="row mb-2">
  <div class="col-md-6 mb-2">
    <div class="p-3 bg-white rounded-3 shadow-sm h-100">
      <h5 class="text-success mb-2">
        <i class="fas fa-eye text-primary me-2"></i>
        Our Vision
      </h5>
      <p class="text-muted mb-0 small">
        To become <strong class="text-success">Sri Lanka's most trusted online platform</strong> for natural wellness by delivering high-quality Ayurvedic and indigenous herbal products to every home.
      </p>
    </div>
  </div>
  
  <div class="col-md-6 mb-2">
    <div class="p-3 bg-white rounded-3 shadow-sm h-100">
      <h5 class="text-success mb-2">
        <i class="fas fa-bullseye text-warning me-2"></i>
        Our Mission
      </h5>
      <p class="text-muted mb-0 small">
        To promote a healthy lifestyle through the power of <strong class="text-success">traditional medicine</strong>, offering authentic, affordable, and accessible herbal products while educating people on the benefits of natural healing.
      </p>
    </div>
  </div>
</div>

<div class="row g-2">
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-patch-check text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">Quality Assured</h6>
      <small class="text-muted">100% authentic products</small>
    </div>
  </div>
  
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-truck text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">Fast Delivery</h6>
      <small class="text-muted">Island-wide shipping</small>
    </div>
  </div>
  
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-shield-check text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">Secure Shopping</h6>
      <small class="text-muted">Safe & trusted</small>
    </div>
  </div>
  
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-currency-dollar text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">Affordable Prices</h6>
      <small class="text-muted">Best value for money</small>
    </div>
  </div>
  
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-headset text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">24/7 Support</h6>
      <small class="text-muted">Always here to help</small>
    </div>
  </div>
  
  <div class="col-lg-4 col-md-6">
    <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
      <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
        <i class="bi bi-award text-success fs-5"></i>
      </div>
      <h6 class="text-success mb-2">Expert Approved</h6>
      <small class="text-muted">Ayurvedic specialists</small>
    </div>
  </div>
</div>
</div>

<!-- Categories Section -->
<div class="container mt-5">
  <h2 class="text-center text-success mb-4">🌿 Featured Herbal Categories</h2>
  <div class="row">
    <?php
    // Get all categories
    $categories = Category::getAllCategories($conn);

    if (!empty($categories)):
      foreach ($categories as $cat): ?>
        <div class="col-md-3 mb-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="../uploads/<?php echo htmlspecialchars($cat['image']); ?>" 
                 class="card-img-top" 
                 alt="<?php echo htmlspecialchars($cat['name']); ?>" 
                 style="height: 250px; object-fit: cover;">
            <div class="card-body text-center d-flex flex-column">
              <h5 class="card-title text-success"><?php echo htmlspecialchars($cat['name']); ?></h5>
              <div class="mt-auto">
                <a href="products.php" class= "btn btn-outline-success btn-sm">
                  <i class="bi bi-eye me-1"></i>View More
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach;
    else: ?>
      <p class="text-danger text-center">No categories found.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Scripts -->
<script>
  const images = [
    '../assets/images/welcome 1.jpg',
    '../assets/images/welcome 2.jpg',
    '../assets/images/welcome 3.jpg',
  ];
  let currentImageIndex = 0;
  const banner = document.getElementById('welcomeBanner');

  function changeBackgroundImage() {
    banner.style.backgroundImage = `url('${images[currentImageIndex]}')`;
    currentImageIndex = (currentImageIndex + 1) % images.length;
  }

  changeBackgroundImage();
  setInterval(changeBackgroundImage, 4000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include '../includes/footer.php'; ?>
</html>
