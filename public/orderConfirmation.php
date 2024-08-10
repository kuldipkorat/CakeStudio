<?php
require_once '../src/controller/OrderController.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$orderController = new OrderController();

// Retrieve order summary
$order_id = $_SESSION['order_id']; // Assuming order_id is set in session after placing the order
unset($_SESSION['order_id']); // Clear the session order_id after displaying it once

if (!$order_id) {
    echo "No order found.";
    exit;
}

$order = $orderController->getOrderSummary($order_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-indigo-600 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Cake Studio</h1>
        </div>
    </header>
    <div class="container mx-auto my-10 p-6">
        <h2 class="text-3xl font-bold text-center text-green-600">Order Placed Successfully!</h2>
        <p class="text-center text-lg mt-4">Thank you for your purchase! Your order has been placed successfully. You will receive a confirmation email shortly.</p>
        <div class="mt-8 text-center">
            <h3 class="text-2xl font-semibold">Order Summary</h3>
            <ul class="mt-4">
                <?php foreach ($order['items'] as $item): ?>
                    <li class="my-2">
                        <span class="font-semibold"><?php echo $item['name']; ?></span>
                        - Quantity: <?php echo $item['quantity']; ?>
                        - Price: $<?php echo number_format($item['price'], 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="mt-4 font-bold">Total Amount: $<?php echo number_format($order['total_amount'], 2); ?></p>
        </div>
        <div class="mt-8 text-center">
            <a href="index.php" class="bg-indigo-500 text-white py-2 px-4 rounded">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
