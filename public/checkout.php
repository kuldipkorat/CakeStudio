<?php
include_once '../src/controller/OrderController.php';
include_once '../src/controller/CartController.php';

$orderController = new OrderController();
$cartController = new CartController();

$userId = 1; // Replace with the actual logged-in user's ID
$cartItems = $cartController->getCartItems($userId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = [
        'line1' => $_POST['address_line_1'],
        'line2' => $_POST['address_line_2'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'postal_code' => $_POST['postal_code'],
        'country' => $_POST['country']
    ];

    $orderId = $orderController->placeOrder($userId, $address, $cartItems->fetch_all(MYSQLI_ASSOC));

    header("Location: order_confirmation.php?order_id=$orderId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
<h1>Checkout</h1>
<form method="post" action="checkout.php">
    <h2>Shipping Address</h2>
    <p><input type="text" name="address_line_1" placeholder="Address Line 1" required></p>
    <p><input type="text" name="address_line_2" placeholder="Address Line 2"></p>
    <p><input type="text" name="city" placeholder="City" required></p>
    <p><input type="text" name="state" placeholder="State" required></p>
    <p><input type="text" name="postal_code" placeholder="Postal Code" required></p>
    <p><input type="text" name="country" placeholder="Country" required></p>
    <button type="submit">Place Order</button>
</form>
</body>
</html>
