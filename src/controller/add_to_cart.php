<?php
session_start();

// Include your database connection
include('../config/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get product ID from POST request
$product_id = $_POST['product_id'];
$quantity = 1; // Default quantity when adding to cart

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If the product is already in the cart, increase the quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Otherwise, add the product to the cart
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['image']
        ];
    }

    // Update the cart count in the session
    $_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

    echo json_encode(['success' => true, 'cartCount' => $_SESSION['cart_count']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
}
?>
