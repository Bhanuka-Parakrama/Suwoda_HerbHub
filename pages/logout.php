<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the RegisterUser class
require_once '../classes/RegisterUser.php';

// Perform logout
RegisteredUser::logout();

// Redirect to homepage
header('Location: index.php');
exit();
?>