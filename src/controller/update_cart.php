<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['product_id']) && isset($_POST['delta'])) {
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);
    $delta = intval($_POST['delta']);

    // Fetch the current quantity
    $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $delta;

        if ($newQuantity > 0) {
            // Update the quantity
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $newQuantity, $row['id']);
        } else {
            // Remove the item if the quantity is zero or less
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $stmt->bind_param("i", $row['id']);
        }

        $stmt->execute();
    }

    // Redirect back to the cart page or wherever you want
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
