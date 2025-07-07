<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products - Suwoda HerbHub</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
  </head>

  <?php
  include '../includes/header.php';
  ?>

  <body>
<div class="container mt-5">
  <div class="row row-cols-1 row-cols-md-3 g-4 mb-3">
    <div class="col">
      <div class="card h-100">
        <img
          src="https://via.placeholder.com/286x180?text=Herbal+Oils"
          class="card-img-top"
          alt="Herbal Oils"
        />
        <div class="card-body">
          <h5 class="card-title">Herbal Oils</h5>
          <p class="card-text">Neem oil, Coconut oil, Sandalwood oil</p>
          <p class="card-text"><strong>Price: LKR 1200</strong></p>
          <div class="mb-3">
            <label for="qty1" class="form-label">Quantity</label>
            <input type="number" id="qty1" class="form-control" value="1" min="1" style="max-width: 100px" />
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm flex-fill">Add to Cart</button>
            <button class="btn btn-success btn-sm flex-fill">Buy Now</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100">
        <img
          src="https://via.placeholder.com/286x180?text=Ayurvedic+Teas"
          class="card-img-top"
          alt="Ayurvedic Teas"
        />
        <div class="card-body">
          <h5 class="card-title">Ayurvedic Teas</h5>
          <p class="card-text">Ginger tea, Detox tea, Coriander tea</p>
          <p class="card-text"><strong>Price: LKR 800</strong></p>
          <div class="mb-3">
            <label for="qty2" class="form-label">Quantity</label>
            <input type="number" id="qty2" class="form-control" value="1" min="1" style="max-width: 100px" />
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm flex-fill">Add to Cart</button>
            <button class="btn btn-success btn-sm flex-fill">Buy Now</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100">
        <img
          src="https://via.placeholder.com/286x180?text=Herbal+Powders"
          class="card-img-top"
          alt="Herbal Powders & Capsules"
        />
        <div class="card-body">
          <h5 class="card-title">Herbal Powders & Capsules</h5>
          <p class="card-text">Triphala powder, Ashwagandha capsules</p>
          <p class="card-text"><strong>Price: LKR 1500</strong></p>
          <div class="mb-3">
            <label for="qty3" class="form-label">Quantity</label>
            <input type="number" id="qty3" class="form-control" value="1" min="1" style="max-width: 100px" />
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm flex-fill">Add to Cart</button>
            <button class="btn btn-success btn-sm flex-fill">Buy Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Repeat the same structure for other rows/cards as needed, just increment qty id -->
</div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

<?php
include '../includes/footer.php';
?>
