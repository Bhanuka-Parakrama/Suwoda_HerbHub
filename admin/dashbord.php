<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header with Logo -->
    <header class="bg-success text-white py-3 mb-4 position-relative">
        <img src="../assets/images/Logo.jpg" alt="Logo"
             style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%; position: absolute; left: 48px; top: 50%; transform: translateY(-50%); border: 3px solid #fff;">
        <h1 class="mb-0 text-center" style="margin:0; font-size:2.5rem;">
            <i class="bi bi-speedometer2 me-2"></i>Suwoda Admin Panel
        </h1>
    </header>

    <!-- Main Content -->
    <main class="container flex-grow-1">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-center">
                <h2 class="mb-4 text-center"><i class="bi bi-person-circle me-2"></i>Welcome to the Admin Panel</h2>
            </div>
        </div>
        <div class="row g-4 mb-3">
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='category_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-tags me-2"></i>Manage Categories
                </button>
            </div>
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='product_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-box-seam me-2"></i>Manage Products
                </button>
            </div>
            
        </div>
        <div class="row g-4 mb-3">
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='user_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-people me-2"></i>Manage Users
                </button>
            </div>
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='order_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-bag-check me-2"></i>Manage Orders
                </button>
            </div>
        </div>
        <div class="row g-4 mb-3">
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='dictionary_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-book me-2"></i>Manage Dictionary
                </button>
            </div>
            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='blog_manage.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-journal-plus me-2"></i>Manage Blogs
                </button>
            </div>
        </div>
        <div class="row g-4 mb-3">
            <div class="col-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='sales_report.php'" class="btn btn-success btn-lg" style="width:400px; height:70px;">
                    <i class="bi bi-bar-chart-line me-2"></i>Reports
                </button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <button type="button" onclick="location.href='admin_logout.php'" class="btn btn-outline-danger px-4 py-2 fw-bold" style="width:180px; height:45px;">Log out</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-success text-center text-white py-3 mt-auto">
        &copy; 2025 Suwoda Admin Panel. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>