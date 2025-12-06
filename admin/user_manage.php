<?php
require_once "../classes/adminClass.php";
require_once "../includes/dbconnect.php"; 

$db = new DbConnector();
$conn = $db->getConnection();

$admin = new Admin($conn);

//get all user ids
$user_ids = [];
$stmt = $conn->query("SELECT user_id FROM user");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $user_ids[] = $row['user_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        .container {
            background: white; 
            padding: 25px; 
            margin-top: 20px; 
            border-radius: 8px;
            flex: 1 0 auto;
        }
        .form-box { border: 2px solid #28a745; padding: 20px; margin-bottom: 25px; border-radius: 5px; background-color: #f8fff8; }
        .user-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        .footer {
            background: #21824b;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include './admin_header.php'; ?>
    <div class="container">
         <a href="dashbord.php" class="btn btn-success text-white mb-2"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
        <h2 class="user-title">User Management</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($user_ids as $user_id) {
                        $user = $admin->viewUser($conn, $user_id); //USE VIEW USER METHOD
                        if ($user) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['address']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <div class="footer">
        © 2025 Suwoda Admin Panel. All rights reserved.
    </div>
  </body>
</html>