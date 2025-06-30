<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        nav.navbar * { font-size: 0.9rem !important; }
        nav.navbar .navbar-brand span { font-size: 0.75rem !important; }
        nav.navbar .bi { font-size: 1rem !important; }
        .dropdown-menu .dropdown-item { font-size: 0.9rem !important; }
        #google_translate_element { padding: 4px 10px; }
        /* Increase font size for main nav tabs (before search bar) */
        .navbar-nav.me-auto > .nav-item > .nav-link,
        .navbar-nav.me-auto > .nav-item > .nav-link.dropdown-toggle {
            font-size: 1.15rem !important;
            font-weight: 500;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand d-flex flex-column align-items-center" href="#home">
            <img src="../assets/images/Logo.jpg" alt="Logo" style="width: 56px; height: 56px; object-fit: cover; border-radius: 50%;">
            <span class="mt-1 text-center">Suwoda HerbHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#products">All Products</a></li>
                        <li><a class="dropdown-item" href="#oils">Herbal Oils</a></li>
                        <li><a class="dropdown-item" href="#teas">Herbal Teas</a></li>
                        <li><a class="dropdown-item" href="#powders">Herbal Powders</a></li>
                        <li><a class="dropdown-item" href="#capsules">Capsules</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#dictionary">Herbal Dictionary</a>
                </li>
               
            </ul>
            <div class="navbar-nav ms-auto align-items-center d-none d-lg-flex">
                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-warning d-flex align-items-center fw-bold shadow" type="submit">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </form>
                <a href="#login" class="nav-link text-white me-3 d-flex align-items-center">
                    <i class="bi bi-person me-1"></i> Login
                </a>
                <a href="#cart" class="nav-link text-white d-flex align-items-center position-relative">
                    <i class="bi bi-cart me-1"></i> Cart
                </a>
                <div id="google_translate_element" class="ms-3"></div>
            </div>
        </div>
    </div>
</nav>
<div class="bg-light text-end" style="margin-top: 72px;">
    <div id="google_translate_element" class="me-3"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,si,ta',
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>