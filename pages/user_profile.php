<?php 
// Handle logout BEFORE any output
session_start();
require_once '../classes/RegisterUser.php';
require_once '../includes/dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT name FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

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
            <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
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
              <!-- No rows, only headers -->
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
