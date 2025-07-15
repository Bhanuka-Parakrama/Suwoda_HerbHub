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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<?php
include '../includes/header.php';
?>
<body>

  <!-- Welcome Banner -->
  <div class="container my-5">
    <div id="welcomeBanner" class="p-5 text-center bg-dark bg-opacity-50 text-white rounded shadow" style="background-size: cover; background-position: center; background-repeat: no-repeat; transition: background-image 1s ease-in-out;">
      <img src="../assets/images/Logo.jpg" alt="Suwoda HerbHub Logo" class="mb-3" style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 0 15px rgba(0,0,0,0.3);">
      <h1 class="display-1 fw-bold" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.9); font-size: 4rem; letter-spacing: 2px;">Welcome to Suwoda HerbHub</h1>
      <p class="lead fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8); color: #f8f9fa; font-size: 1.5rem;">Discover the best Ayurvedic and indigenous herbal products crafted with care.</p>
      <a href="#products" class="btn btn-success btn-lg mt-3">Explore Products</a>
    </div>
  </div>

  <div class="container my-4" id="about">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="bg-gradient p-4 rounded-3 shadow position-relative overflow-hidden" style="background: linear-gradient(135deg, #e8f5e8 0%, #f8fff8 100%); border: 1px solid #198754;">
          
          <div class="position-absolute top-0 start-0 p-2">
            <i class="fas fa-leaf text-success opacity-25" style="font-size: 2rem;"></i>
          </div>
          <div class="position-absolute bottom-0 end-0 p-2">
            <i class="fas fa-seedling text-success opacity-25" style="font-size: 1.5rem;"></i>
          </div>
          
          <div class="text-center mb-4">
            <h2 class="display-6 fw-bold text-success mb-2">
              🌿 About Suwoda HerbHub
            </h2>
            <div class="mx-auto" style="width: 60px; height: 2px; background: linear-gradient(90deg, #198754, #20c997); border-radius: 2px;"></div>
          </div>
          
          <div class="row align-items-center">
            <div class="col-md-6 mb-3">
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
            
            <div class="col-md-6 mb-3">
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
          
          <div class="row mt-3">
            <div class="col-12">
              <div class="row g-2">
                <div class="col-md-4 col-sm-6">
                  <div class="text-center p-2 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 40px; height: 40px;">
                      <i class="bi bi-patch-check text-success fs-6"></i>
                    </div>
                    <h6 class="text-success mb-1 small">Quality Assured</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">100% authentic products</small>
                  </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                  <div class="text-center p-2 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 40px; height: 40px;">
                      <i class="bi bi-flower1 text-success fs-6"></i>
                    </div>
                    <h6 class="text-success mb-1 small">Natural Healing</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">Traditional remedies</small>
                  </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                  <div class="text-center p-2 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 40px; height: 40px;">
                      <i class="bi bi-grid-3x3-gap text-success fs-6"></i>
                    </div>
                    <h6 class="text-success mb-1 small">Wide Variety</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">Extensive product range</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mt-4 content-box" id="products">
    <h2 class="text-center mb-5">Our Herbal Product Categories</h2>
    <div class="row g-4">
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/herbal_oils.jpg" alt="Herbal oils" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Herbal Oils</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/ayurvedic tea.jpg" alt="Ayurvedic teas" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Ayurvedic Teas</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/herbal powders.jpg" alt="Herbal Powders" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Herbal Powders & Capsules</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/soap&skin.jpg" alt="Soaps & Skincare" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Soaps & Skincare</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/balms.jpg" alt="Pain Relief Balms & Creams" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Pain Relief Balms & Creams</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/syrup.jpg" alt="Wellness Tonics & Syrups" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Syrups</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/hair care.jpg" alt="Hair Care" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Hair Care</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow">
          <img src="../assets/images/baby_care.jpg" alt="Baby Care" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title">Baby Care</h5>
            <a href="products.php" class="btn btn-success mt-3">View more</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Blog and Dictionary Section -->
  <div class="container my-5" id="blog-dictionary">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="row g-4">
          <!-- Blog Section -->
          <div class="col-md-6">
            <div class="bg-gradient p-4 rounded-3 shadow text-center h-100" style="background: linear-gradient(135deg, #e8f5e8 0%, #f8fff8 100%); border: 1px solid #198754;">
              <h3 class="text-success mb-3">
                <i class="fas fa-blog text-success me-2"></i>
                Health Blog
              </h3>
              <p class="text-muted mb-3">
                Read useful tips and health guides from herbal experts. Stay updated with the latest insights on natural healing and wellness practices.
              </p>
              <div class="d-inline-block p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                <h6 class="text-success mb-2 fw-bold">
                  <i class="fas fa-newspaper me-2"></i>
                  Latest Articles
                </h6>
                <p class="text-muted mb-0 small">
                  <em>Expert insights on herbal remedies</em>
                </p>
              </div>
            </div>
          </div>
          
          <!-- Dictionary Section -->
          <div class="col-md-6">
            <div class="bg-gradient p-4 rounded-3 shadow text-center h-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #198754;">
              <h3 class="text-success mb-3">
                <i class="fas fa-book text-success me-2"></i>
                Herbal Dictionary
              </h3>
              <p class="text-muted mb-3">
                Learn about each herb and its unique benefits. Discover the traditional uses and properties of various medicinal plants.
              </p>
              <div class="d-inline-block p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                <h6 class="text-success mb-2 fw-bold">
                  <i class="fas fa-seedling me-2"></i>
                  Plant Knowledge
                </h6>
                <p class="text-muted mb-0 small">
                  <em>Traditional herb encyclopedia</em>
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Inspirational Quote -->
        <div class="text-center mt-4">
          <div class="d-inline-block p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
            <h5 class="text-success mb-2 fw-bold">
              <i class="fas fa-quote-left me-2"></i>
              Discover the Power of Nature
              <i class="fas fa-quote-right ms-2"></i>
            </h5>
            <p class="text-muted mb-0">
              <em>Live healthier, naturally with Suwoda HerbHub</em>
            </p>
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
  
  <script>
    // Welcome banner image slideshow
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
    
    // Set initial image
    changeBackgroundImage();
    
    // Change image every 3 seconds
    setInterval(changeBackgroundImage, 4000);
  </script>
</body>
</html>

<?php
include '../includes/footer.php';
?>
