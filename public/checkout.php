<?php
require_once '../src/controller/OrderController.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$orderController = new OrderController();

// Assuming total_amount is calculated from the cart items
$total_amount = 100.00; // Example amount
$order_id = $orderController->placeOrder($user_id, $total_amount);

// Store the order_id in session to show on the confirmation page
$_SESSION['order_id'] = $order_id;

// Redirect to order confirmation page
header('Location: orderConfirmation.php');
exit;
