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
  <style>
    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    .card-hover:hover {
      transform: scale(1.03);
      transition: 0.3s ease;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <?php include '../includes/header.php'; ?>

<div class="container py-5 mt-5">
  <h2 class="text-center mb-5 section-title text-dark" style="color: #333 !important; font-size: 2rem; margin-top: 2rem;">Our Latest Blog Posts</h2>
    <div class="d-flex flex-row gap-4 overflow-auto pb-4">
    <div class="card shadow card-hover" style="min-width: 300px;">
      <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+1" class="card-img-top" alt="Blog 1">
      <div class="card-body">
        <h5 class="card-title">Benefits of Herbal Teas</h5>
        <p class="card-text">Learn how herbal teas can improve your health and wellbeing...</p>
      </div>
    </div>

    <div class="card shadow card-hover" style="min-width: 300px;">
      <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+2" class="card-img-top" alt="Blog 2">
      <div class="card-body">
        <h5 class="card-title">Natural Skincare Tips</h5>
        <p class="card-text">Explore natural methods for glowing and healthy skin...</p>
      </div>
    </div>

    <div class="card shadow card-hover" style="min-width: 300px;">
      <img src="https://via.placeholder.com/600x200.png?text=Blog+Image+3" class="card-img-top" alt="Blog 3">
      <div class="card-body">
        <h5 class="card-title">Why Ayurvedic Medicine Matters</h5>
        <p class="card-text">Understand the importance of traditional healing methods...</p>
      </div>
    </div>
  </div>
</div>

  <?php include '../includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous">
  </script>

</body>
</html>
