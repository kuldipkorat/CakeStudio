<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['product_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);

    // Delete the item from the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();

    // Redirect back to the cart page or wherever you want
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
