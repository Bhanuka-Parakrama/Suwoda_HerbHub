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
                    <a class="nav-link active" href="../pages/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/index.php#products">
                        Categories
                    </a>         
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/blogs.php">Blog</a> <!-- Link to Blog -->
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/dictionary.php">Herbal Dictionary</a>
                </li>
               
            </ul>
            <div class="navbar-nav ms-auto align-items-center d-none d-lg-flex">
                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-warning d-flex align-items-center fw-bold shadow" type="submit">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </form>
                <a href="../pages/login_form.php" class="nav-link text-white me-3 d-flex align-items-center">
                    <i class="bi bi-person me-1"></i> Login
                </a>
                <a href="../pages/cart.php" class="nav-link text-white d-flex align-items-center position-relative">
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