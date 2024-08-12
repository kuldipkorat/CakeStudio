<?php
session_start();
require_once '../config/db.php'; // Adjust the path to your database connection file

if (isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = 1; // Default quantity for now

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update product in cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        // Fetch product details from the database
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    // Update cart count in session
    $_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
