<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Cart - Suwoda HerbHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<?php
include '../includes/header.php';
?>

<body class="bg-light">
  <div style="height: 70px"></div>
  
  <!-- Removed vertical centering flex container, replaced with padding -->
  <div class="py-5">
    <div class="container" id="cart-container" style="max-width: 1000px">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th></th>
                      <th>Product</th>
                      <th class="text-end">Price</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-end">Subtotal</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id="cart-row">
                      <td>
                        <img src="https://via.placeholder.com/60" alt="" class="rounded" width="60" height="60" />
                      </td>
                      <td>
                        <div class="fw-semibold">Product Name</div>
                        <div class="text-muted small">Brief product description here.</div>
                      </td>
                      <td class="text-end" id="item-price">$24.99</td>
                      <td class="text-center">
                        <div class="input-group input-group-sm justify-content-center" style="max-width: 110px; margin: auto">
                          <button class="btn btn-outline-success" type="button" onclick="changeQty(-1)">
                            <i class="bi bi-dash"></i>
                          </button>
                          <input type="number" class="form-control text-center" id="qty" value="2" min="1" style="max-width: 40px" onchange="updateCart()" />
                          <button class="btn btn-outline-success" type="button" onclick="changeQty(1)">
                            <i class="bi bi-plus"></i>
                          </button>
                        </div>
                      </td>
                      <td class="text-end" id="item-subtotal">$49.98</td>
                      <td>
                        <button class="btn btn-link text-danger" onclick="removeItem()">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="text-center mb-3">
            <button class="btn btn-outline-success" onclick="continueShopping()">
              <i class="bi bi-arrow-left"></i> Continue Shopping
            </button>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title border-bottom pb-2 mb-3">Order Summary</h5>
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span id="summary-subtotal">$49.98</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping:</span>
                <span id="shipping">$5.99</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Discount:</span>
                <span id="discount">-$0.00</span>
              </div>
              <div class="d-flex justify-content-between border-top pt-2 fw-bold">
                <span>Total:</span>
                <span id="total">$55.97</span>
              </div>
              <button class="btn btn-success w-100 mt-3" onclick="checkout()">
                <i class="bi bi-credit-card"></i> Proceed to Checkout
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container d-none" id="empty-cart">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="alert alert-info text-center my-5">
            <i class="bi bi-cart-x fs-1"></i>
            <div class="fw-bold mt-2">Your cart is empty</div>
            <button class="btn btn-success mt-3" onclick="continueShopping()">
              <i class="bi bi-shop"></i> Shop Now
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div style="height: 70px"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"> </script>
  <script src="../assets/index.js"></script>
</body>
</html>

<?php
include '../includes/footer.php';
?>
