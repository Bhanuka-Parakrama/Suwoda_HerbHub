<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head> 
<body>
    
<footer class="footer py-4 mt-0">
    <div class="container">
        <div class="row justify-content-center text-center">
          
            <div class="col-12 col-md-4 mb-4 footer-brand d-flex flex-column align-items-center">
                <h4 class="d-flex align-items-center justify-content-center w-100">
                    <img src="../assets/images/Logo.jpg" alt="HerbHub Logo">
                    Suwoda HerbHub
                </h4>
                <p class="mt-2">Your trusted source for herbal products and knowledge.</p>
                <div class="social-links mt-3">
                    <a href="#"><i class="bi bi-facebook me-1"></i> Facebook</a>
                    <a href="#"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
                    <a href="#"><i class="bi bi-instagram me-1"></i> Instagram</a>
                </div>
            </div>
        
            <div class="col-12 col-md-4 mb-4 d-flex flex-column align-items-center">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="../pages/index.php"><i class="bi bi-house-door me-1"></i> Home</a></li>
                    <li><a href="../pages/index.php#about"><i class="bi bi-info-circle me-1"></i> About Us</a></li>
                    <li><a href="../pages/index.php#products"><i class="bi bi-grid-3x3-gap me-1"></i> Categories</a></li>
                    <li><a href="../pages/products.php"><i class="bi bi-bag me-1"></i> Products</a></li>
                </ul>
            </div>
           
            <div class="col-12 col-md-4 mb-4 contact-info d-flex flex-column align-items-center">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-geo-alt-fill me-1"></i>Sri Lanka</li>
                    <li><i class="bi bi-telephone-fill me-1"></i>071-516 6450</li>
                    <li><i class="bi bi-envelope-fill me-1"></i>suwodaherbhub@gamil.com</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center small mt-3">
            &copy; <?php echo date('Y'); ?> Suwoda HerbHub. All rights reserved.
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    </body>
</html>