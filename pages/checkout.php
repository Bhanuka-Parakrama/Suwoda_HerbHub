<?php
session_start();
require_once '../classes/orderClass.php';
require_once '../classes/productClass.php';

// Check user logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
require_once '../includes/dbconnect.php';

$db = new DBConnector();
$conn = $db->getConnection();
$user = new Order();

try {
    if (isset($_POST['buy_now']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
       
        //USE CREATE CHECKOUT SESSION FUNCTION FROM ORDER CLASS
        //Single item purchase (Buy Now)
        $items_data = [
            'product_id' => $_POST['product_id'],
            'quantity' => $_POST['quantity']
        ];
        $checkout_session = $user->createCheckoutSession($user_id, $items_data);
        
        //USE UPDATE STOCK FUNCTION FROM PRODUCT CLASS
        //Reduce stock for the purchased item
        Product::updateStock($conn, $items_data['product_id'], $items_data['quantity']);
   
    } else {

        //Fully cart purchase
        $checkout_session = $user->createCheckoutSession($user_id);
        
        //Reduce stock for all items in the cart
        require_once '../classes/cartClass.php';
        $cart = new Cart();
        $cart_items = $cart->getCartItems($user_id);
        foreach ($cart_items as $item) {
            Product::updateStock($conn, $item['product_id'], $item['quantity']);
        }
    }
    
    http_response_code(303);
    header("Location: " . $checkout_session->url);
    exit();
    
} catch (Exception $e) {
    die($e->getMessage());
}



