<?php
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-5 section-title">Our Latest Blog Posts</h2>

    <!-- Blog Post 1 -->
    <div class="card mb-4 shadow card-hover">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+1" class="img-fluid rounded-start" alt="Blog 1">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Benefits of Herbal Teas</h5>
            <p class="card-text">Learn how herbal teas can improve your health and wellbeing. Discover the top herbal teas and how they can help with digestion, sleep, and immunity.</p>
            <a href="#" class="btn btn-success btn-custom">Read More</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Blog Post 2 -->
    <div class="card mb-4 shadow card-hover">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+2" class="img-fluid rounded-start" alt="Blog 2">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Natural Skincare Tips</h5>
            <p class="card-text">Explore natural methods for glowing and healthy skin using Ayurvedic ingredients. Say goodbye to harsh chemicals and try natural face packs, oils, and scrubs.</p>
            <a href="#" class="btn btn-success btn-custom">Read More</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Blog Post 3 -->
    <div class="card mb-4 shadow card-hover">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+3" class="img-fluid rounded-start" alt="Blog 3">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Why Ayurvedic Medicine Matters</h5>
            <p class="card-text">Understand the importance of traditional healing methods. Learn how Ayurveda offers long-term relief without side effects and promotes a balanced lifestyle.</p>
            <a href="#" class="btn btn-success btn-custom">Read More</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous">
  </script>
</body>
</html>

<?php
include '../includes/footer.php';
?>
