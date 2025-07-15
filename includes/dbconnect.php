<?php

    $conn = mysqli_connect('localhost', 'root', '', 'suwoda', 3307);

    if(mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error());
    }else {
         echo "Database connection successful.";
    }   
?>
S