<?php
include_once '../src/controller/CartController.php';
$cartController = new CartController();

// Assuming user is logged in and $userId is available
$userId = 1; // Replace with the actual logged-in user's ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $cartController->updateCartItem($userId, $_POST['product_id'], $_POST['quantity']);
    } elseif (isset($_POST['remove'])) {
        $cartController->removeFromCart($userId, $_POST['product_id']);
    }
}

$cartItems = $cartController->getCartItems($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
</head>
<body>
<h1>Your Cart</h1>
<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php while ($item = $cartItems->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td>
                <form method="post" action="cart.php">
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
            </td>
            <td><?php echo htmlspecialchars($item['price']); ?></td>
            <td>
                    <button type="submit" name="update" value="1">Update</button>
                    <button type="submit" name="remove" value="1">Remove</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
