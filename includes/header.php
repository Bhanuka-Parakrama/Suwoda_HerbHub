<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
     <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex flex-column align-items-center me-4" href="../pages/index.php">
            <img src="../assets/images/Logo.jpg" alt="Logo" style="width: 56px; height: 56px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3);">
            <span class="mt-1 text-center">Suwoda HerbHub</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="../pages/index.php">
                        <i class="bi bi-house-door me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/index.php#products">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Categories
                    </a>         
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/blogs.php">
                        <i class="bi bi-newspaper me-1"></i>Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/dictionary.php">
                        <i class="bi bi-book me-1"></i>Herbal Dictionary
                    </a>
                </li>
                
            </ul>
            
            <!-- Desktop Search & User Actions -->
            <div class="navbar-nav ms-auto align-items-center d-none d-lg-flex user-actions">
                <form class="d-flex me-3 search-form" role="search">
                    <input class="form-control me-2" type="search" placeholder="search your product" aria-label="Search">
                    <button class="btn btn-warning search-btn d-flex align-items-center fw-bold" type="submit">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </form>
                
                <a href="../pages/login_form.php" class="nav-link text-white me-3 d-flex align-items-center">
                    <i class="bi bi-person me-1"></i>Login
                </a>
                
                <a href="../pages/cart.php" class="nav-link text-white me-3 d-flex align-items-center position-relative">
                    <i class="bi bi-cart me-1"></i>Cart
                </a>
                
                <div class="translate-widget">
                    <div id="google_translate_element"></div>
                </div>
            </div>
            
            <!-- Mobile Search -->
            <div class="d-lg-none mobile-search">
                <form class="d-flex search-form" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search herbs..." aria-label="Search">
                    <button class="btn btn-warning search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Mobile User Actions -->
            <div class="d-lg-none mobile-actions">
                <div class="d-flex justify-content-around">
                    <a href="../pages/login_form.php" class="nav-link text-white d-flex flex-column align-items-center">
                        <i class="bi bi-person"></i>
                        <small>Login</small>
                    </a>
                    <a href="../pages/cart.php" class="nav-link text-white d-flex flex-column align-items-center position-relative">
                        <i class="bi bi-cart"></i>
                        <small>Cart</small>
                        <span class="cart-badge">3</span>
                    </a>
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-translate text-white"></i>
                        <div class="translate-widget mt-1">
                            <div id="google_translate_element_mobile"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Translate Section -->
<div class="translate-section text-end py-2" style="margin-top: 72px;">
    <div class="container-fluid">
        <div class="translate-widget d-inline-block">
            <div id="google_translate_element_main"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>

<script type="text/javascript">
  function googleTranslateElementInit() {
    // Desktop version
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,si,ta',
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
    
    // Mobile version
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,si,ta',
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element_mobile');
    
    // Main translate section
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,si,ta',
      layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
    }, 'google_translate_element_main');
  }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
// Add active class to current page
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if(link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});

// Search functionality
document.querySelector('.search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const searchTerm = this.querySelector('input').value;
    if(searchTerm.trim()) {
        // Add your search logic here
        console.log('Searching for:', searchTerm);
    }
});
</script>
</body>
</html>