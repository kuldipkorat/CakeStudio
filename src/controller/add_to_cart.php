<?php
session_start();
require_once '../config/db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.php");
    exit;
}

if (isset($_POST['product_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']) ?? 1;

    // Check if the product is already in the cart
    $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the quantity if the product is already in the cart
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $newQuantity, $row['id']);
    } else {
        // Add the product to the cart if it's not already there
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
    }

    $stmt->execute();

    // Calculate the cart count based on the number of distinct products
    $cartResult = $conn->query("SELECT COUNT(*) as unique_product_count FROM cart WHERE user_id = $userId");
    $cartRow = $cartResult->fetch_assoc();
    $_SESSION['cart_count'] = $cartRow['unique_product_count'] ?? 0;

    // Redirect back to the product details page or wherever you want
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
