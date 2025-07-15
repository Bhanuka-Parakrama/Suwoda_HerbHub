<?php

    $conn = mysqli_connect('localhost', 'root', '', 'suwoda', 3307);

    if(mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>



<?php

/*



CREATE TABLE admin (
  admin_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);
*/