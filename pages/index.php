<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<?php
include '../includes/header.php';
?>

<body>
    <!-- Welcome Banner -->
    <div class="container-fluid px-0 mb-4" style="margin-top: 10px;">
        <div id="welcomeBanner" class="p-5 text-center bg-dark bg-opacity-50 text-white position-relative" style="background-size: cover; background-position: center; background-repeat: no-repeat; transition: background-image 1s ease-in-out; min-height: 400px; border-radius: 20px; margin: 0 15px; overflow: hidden;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="../assets/images/Logo.jpg" alt="Suwoda HerbHub Logo" class="mb-3" style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 0 15px rgba(0,0,0,0.3);">
                        <h1 class="display-1 fw-bold" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.9); font-size: 4rem; letter-spacing: 2px;">Welcome to Suwoda HerbHub</h1>
                        <p class="lead fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8); color: #f8f9fa; font-size: 1.5rem;">Discover the best Ayurvedic and indigenous herbal products crafted with care.</p>
                        <a href="#products" class="btn btn-success btn-lg mt-3" style="border-radius: 30px; padding: 12px 30px;">Explore Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <div class="container my-5" id="about">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="bg-gradient p-4 rounded-3 shadow position-relative overflow-hidden" style="background: linear-gradient(135deg, #e8f5e8 0%, #f8fff8 100%); border: 1px solid #198754;">
          
          <div class="position-absolute top-0 start-0 p-2">
            <i class="fas fa-leaf text-success opacity-25" style="font-size: 2rem;"></i>
          </div>
          <div class="position-absolute bottom-0 end-0 p-2">
            <i class="fas fa-seedling text-success opacity-25" style="font-size: 1.5rem;"></i>
          </div>
          
          <div class="row">
            <div class="col-12">
              <div class="text-center mb-4">
                <h2 class="display-6 fw-bold text-success mb-2">
                  🌿 About Suwoda HerbHub
                </h2>
                <div class="mx-auto" style="width: 60px; height: 2px; background: linear-gradient(90deg, #198754, #20c997); border-radius: 2px;"></div>
              </div>
            </div>
          </div>
          
          <div class="row mb-4">
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
          
          <div class="row g-3">
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
      </div>
    </div>
  </div>


    <!-- Categories Section -->
    <section id="products" class="py-5 bg-light">
        <div class="container my-5" id="products">
            <div class="row">
                <div class="col-12">
                    <div class="text-center mb-5">
                        <h2 class="display-6 fw-bold text-dark mb-3">Our Herbal Product Categories</h2>
                        <div class="mx-auto bg-success" style="width: 80px; height: 3px; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/herbal_oils.jpg" alt="Herbal oils" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Herbal Oils</h5>
                            <p class="card-text text-muted small mb-3">Natural healing oils for wellness</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/ayurvedic tea.jpg" alt="Ayurvedic teas" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Ayurvedic Teas</h5>
                            <p class="card-text text-muted small mb-3">Traditional herbal tea blends</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/herbal powders.jpg" alt="Herbal Powders" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Herbal Powders</h5>
                            <p class="card-text text-muted small mb-3">Pure herbal powders & capsules</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/soap&skin.jpg" alt="Soaps & Skincare" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Soaps & Skincare</h5>
                            <p class="card-text text-muted small mb-3">Natural skincare products</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/balms.jpg" alt="Pain Relief Balms" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Pain Relief Balms</h5>
                            <p class="card-text text-muted small mb-3">Natural pain relief solutions</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/syrup.jpg" alt="Syrups" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Wellness Syrups</h5>
                            <p class="card-text text-muted small mb-3">Health tonics & syrups</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/hair care.jpg" alt="Hair Care" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Hair Care</h5>
                            <p class="card-text text-muted small mb-3">Natural hair care products</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0" style="transition: transform 0.3s ease;">
                        <img src="../assets/images/baby_care.jpg" alt="Baby Care" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success mb-2">Baby Care</h5>
                            <p class="card-text text-muted small mb-3">Gentle and safe products for babies</p>
                            <a href="products.php" class="btn btn-success btn-sm">View more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    
    changeBackgroundImage();
    setInterval(changeBackgroundImage, 4000);

    // Add hover effect to product cards
    document.querySelectorAll('.card').forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
      });
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
      });
    });
  </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include '../includes/footer.php';
?>
</html>