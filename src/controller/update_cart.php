<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Cart not found']);
    exit;
}

$productId = $_POST['product_id'];
$delta = (int)$_POST['delta'];

// Check if the product is in the cart
if (isset($_SESSION['cart'][$productId])) {
    // Update quantity
    $_SESSION['cart'][$productId]['quantity'] += $delta;

    // Remove product from cart if quantity is 0 or less
    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
        unset($_SESSION['cart'][$productId]);
    }

    // Update session cart count
    $_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

    echo json_encode(['success' => true, 'cartCount' => $_SESSION['cart_count']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not in cart']);
}
