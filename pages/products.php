<?php
// Include necessary files
require_once '../includes/dbconnect.php';
require_once '../classes/productClass.php';

// Get all products from database
$products = Product::getAll($conn);
?>

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

  <?php include '../includes/header.php'; ?>

  <body>
    <div class="container mt-5">
      <h2 class="mb-4 text-center">Our Products</h2>
      
      <div class="row row-cols-1 row-cols-md-3 g-4 mb-3">
        <?php while ($product = $products->fetch_assoc()): ?>
          <div class="col">
            <div class="card h-100">
              <?php if ($product['image']): ?>
                <img
                  src="<?= str_replace('../uploads/', '../uploads/', $product['image']) ?>"
                  class="card-img-top"
                  alt="<?= htmlspecialchars($product['product_name']) ?>"
                  style="height: 400px; object-fit: cover;"
                />
              <?php else: ?>
                <img
                  src="https://via.placeholder.com/286x180?text=No+Image"
                  class="card-img-top"
                  alt="No Image"
                  style="height: 200px; object-fit: cover;"
                />
              <?php endif; ?>
              
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                <p class="card-text"><small class="text-muted">Category: <?= htmlspecialchars($product['category_name']) ?></small></p>
                <p class="card-text"><strong>Price: LKR <?= number_format($product['price'], 2) ?></strong></p>
                
                <?php if ($product['quantity'] > 0): ?>
                  <p class="card-text"><small class="text-success">In Stock (<?= $product['quantity'] ?> available)</small></p>
                  
                  <div class="mb-3 mt-auto">
                    <label for="qty<?= $product['product_id'] ?>" class="form-label">Quantity</label>
                    <input 
                      type="number" 
                      id="qty<?= $product['product_id'] ?>" 
                      class="form-control" 
                      value="1" 
                      min="1" 
                      max="<?= $product['quantity'] ?>"
                      style="max-width: 100px" 
                    />
                  </div>
                  
                  <div class="d-flex gap-2">
                    <button 
                      class="btn btn-success btn-sm flex-fill"
                      onclick="addToCart(<?= $product['product_id'] ?>)"
                    >
                      Add to Cart
                    </button>
                    <button 
                      class="btn btn-warning btn-sm flex-fill"
                      onclick="buyNow(<?= $product['product_id'] ?>)"
                    >
                      Buy Now
                    </button>
                  </div>
                <?php else: ?>
                  <p class="card-text"><small class="text-danger">Out of Stock</small></p>
                  <button class="btn btn-secondary btn-sm flex-fill mt-auto" disabled>
                    Out of Stock
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      
      <?php if ($products->num_rows == 0): ?>
        <div class="text-center">
          <h4>No products available at the moment.</h4>
          <p class="text-muted">Please check back later for new products.</p>
        </div>
      <?php endif; ?>
    </div>

    <script>
      function addToCart(productId) {
        const quantity = document.getElementById('qty' + productId).value;
        
        // Send AJAX request to add to cart
        fetch('../includes/add_to_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'product_id=' + productId + '&quantity=' + quantity
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Product added to cart successfully!');
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while adding to cart.');
        });
      }
      
      function buyNow(productId) {
        const quantity = document.getElementById('qty' + productId).value;
        // Redirect to checkout page with product details
        window.location.href = '../pages/checkout.php?product_id=' + productId + '&quantity=' + quantity;
      }
    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1ERo0BZlK"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

<?php include '../includes/footer.php'; ?>
