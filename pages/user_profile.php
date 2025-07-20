<?php 
// Handle logout BEFORE any output
session_start();
require_once '../classes/RegisterUser.php';

if (isset($_GET['logout'])) {
    $user = new RegisteredUser();
    RegisteredUser::logout();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  </head>

  <?php include '../includes/header.php'; ?>

  <body style="background-color: #d4f8e8">
    <div class="container my-5 p-4 bg-white rounded-4 shadow">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
          <div
            class="rounded-circle bg-secondary me-3"
            style="width: 80px; height: 80px"
          ></div>
          <div>
            <h1 class="h3 mb-0">Your Profile</h1>
          </div>
        </div>
        <div class="d-flex gap-2">
          <a href="#cart" class="btn btn-success">Go to Cart</a>
          <a href="?logout=true" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </div>
      </div>

      <div class="mt-4">
        <h2 class="h4">My Orders</h2>
        <div class="table-responsive">
          <table class="table align-middle mt-3">
            <thead class="table-light">
              <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Items</th>
                <th>Status</th>
                <th>Review</th>
                <th>Tracking</th>
              </tr>
            </thead>
            <tbody>
              <!-- Example Past Order -->
              <tr>
                <td>#1001</td>
                <td>2025-06-20</td>
                <td>Wireless Mouse, USB-C Cable</td>
                <td><span class="badge bg-success">Delivered</span></td>
                <td>
                  <button
                    class="btn btn-success btn-sm"
                    onclick="toggleReview('review1')"
                  >
                    Add Review
                  </button>
                  <form class="review-form mt-2" id="review1">
                    <textarea
                      class="form-control mb-2"
                      placeholder="Write your review..."
                    ></textarea>
                    <button type="submit" class="btn btn-success btn-sm">
                      Submit
                    </button>
                  </form>
                </td>
                <td>
                  <span class="text-success">Delivered on 2025-06-22</span
                  ><br />
                  <a href="#" class="link-success text-decoration-underline"
                    >View Details</a
                  >
                </td>
              </tr>
              <!-- Example Present Order -->
              <tr>
                <td>#1002</td>
                <td>2025-07-03</td>
                <td>Bluetooth Headphones</td>
                <td><span class="badge bg-primary">Delivering</span></td>
                <td></td>
                <td>
                  <div class="progress mb-1" style="height: 8px">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 80%"
                      aria-valuenow="80"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  <small>Out for delivery - Expected by 2025-07-05</small><br />
                  <a href="#" class="link-success text-decoration-underline"
                    >Track Package</a
                  >
                </td>
              </tr>
              <tr>
                <td>#1003</td>
                <td>2025-07-04</td>
                <td>Smart Watch</td>
                <td><span class="badge bg-info text-dark">Dispatched</span></td>
                <td></td>
                <td>
                  <div class="progress mb-1" style="height: 8px">
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      style="width: 50%"
                      aria-valuenow="50"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  <small>Dispatched from warehouse</small><br />
                  <a href="#" class="link-info text-decoration-underline"
                    >Track Package</a
                  >
                </td>
              </tr>
              <tr>
                <td>#1004</td>
                <td>2025-07-05</td>
                <td>Fitness Band</td>
                <td><span class="badge bg-warning text-dark">Packing</span></td>
                <td></td>
                <td>
                  <div class="progress mb-1" style="height: 8px">
                    <div
                      class="progress-bar bg-warning"
                      role="progressbar"
                      style="width: 20%"
                      aria-valuenow="20"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  <small>Packing order</small><br />
                  <a href="#" class="link-warning text-decoration-underline"
                    >Track Package</a
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
      function toggleReview(id) {
        var form = document.getElementById(id);
        if (form.style.display === "block") {
          form.style.display = "none";
        } else {
          form.style.display = "block";
        }
      }
      // Prevent form submission (demo only)
      document.querySelectorAll(".review-form").forEach((form) => {
        form.addEventListener("submit", function (e) {
          e.preventDefault();
          alert("Review submitted!");
          form.style.display = "none";
        });
      });
    </script>
  </body>

<?php include '../includes/footer.php';?>

</html>
