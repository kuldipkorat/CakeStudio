<?php
$orderId = $_GET['order_id']; // Get the order ID from the query string
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
<h1>Thank you for your order!</h1>
<p>Your order number is: <?php echo htmlspecialchars($orderId); ?></p>
<a href="dashboard.php">Continue Shopping</a>
</body>
</html>
