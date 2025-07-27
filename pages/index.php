<?php
include '../includes/dbconnect.php'; 
include '../classes/CategoryClass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suwoda HerbHub - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container-fluid px-0 mb-4" style="margin-top: 10px;">
        <div id="banner" class="p-5 text-center bg-dark bg-opacity-50 text-white position-relative rounded-4 mx-3" 
             style="background-size: cover; background-position: center; min-height: 400px; transition: background-image 1s ease;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="../assets/images/Logo.jpg" alt="Logo" 
                             class="rounded-circle mb-3 border border-white border-4 shadow"
                             style="height: 120px; width: 120px; object-fit: cover;">
                        <h1 class="display-1 fw-bold mb-3" style="font-size: 4rem; text-shadow: 3px 3px 6px rgba(0,0,0,0.9);">
                            Welcome to Suwoda HerbHub
                        </h1>
                        <p class="lead fw-bold mb-4 fs-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                            Discover the best Ayurvedic and indigenous herbal products crafted with care.
                        </p>
                        <a href="#categories" class="btn btn-success btn-lg rounded-pill px-4 py-3">
                            Explore Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 800px;">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-4">
                    <h2 class="display-6 fw-bold text-success mb-3">About Suwoda HerbHub</h2>
                    <div class="mx-auto" style="width: 60px; height: 2px; background: linear-gradient(90deg, #198754, #20c997);"></div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <h5 class="text-success mb-3">Our Vision</h5>
                    <p class="text-muted mb-0">
                        To become Sri Lanka's most trusted online platform
                        for natural wellness by delivering high-quality Ayurvedic and 
                        indigenous herbal products to every home.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <h5 class="text-success mb-3">Our Mission</h5>
                    <p class="text-muted mb-0">
                        To promote a healthy lifestyle through the power of 
                        traditional medicine, offering authentic, 
                        affordable, and accessible herbal products.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-patch-check text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Quality Assured</h6>
                    <small class="text-muted">100% authentic products</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-truck text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Fast Delivery</h6>
                    <small class="text-muted">Island-wide shipping</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Secure Shopping</h6>
                    <small class="text-muted">Safe & trusted</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Affordable Prices</h6>
                    <small class="text-muted">Best value for money</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-headset text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">24/7 Support</h6>
                    <small class="text-muted">Always here to help</small>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-award text-success fs-4"></i>
                    </div>
                    <h6 class="text-success mb-2 fw-bold">Expert Approved</h6>
                    <small class="text-muted">Ayurvedic specialists</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
<div id="categories" class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center text-success mb-5 display-6 fw-bold">Featured Herbal Categories</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <?php
        $categories = Category::getAllCategories($conn);
        if (!empty($categories)) {
            foreach ($categories as $category) {
        ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img src="../uploads/<?php echo $category['image']; ?>" 
                             class="card-img-top" 
                             alt="<?php echo ($category['name']); ?>"
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title text-success fw-bold mb-3">
                                <?php echo($category['name']); ?>
                            </h5>
                            <div class="mt-auto">
                
                                <a href="products.php?category_id=<?php echo $category['category_id']; ?>" 
                                   class="btn btn-outline-success btn-sm rounded-pill px-3">
                                   View More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="col-12"><p class="text-danger text-center fs-5">No categories found.</p></div>';
        }
        ?>
    </div>
</div>

<!-- js for welcome banner-->
    <script>
        const images = [
            '../assets/images/welcome 1.jpg',
            '../assets/images/welcome 2.jpg',
            '../assets/images/welcome 3.jpg'
        ];
        let current = 0;
        const banner = document.getElementById('banner');

        function changeBg() {
            banner.style.backgroundImage = `url('${images[current]}')`;
            current = (current + 1) % images.length;
        }

        changeBg();
        setInterval(changeBg, 4000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/footer.php'; ?>
</body>