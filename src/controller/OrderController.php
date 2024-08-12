<?php

include_once '../config/db.php';

class OrderController {

    public function placeOrder($userId, $address, $cartItems) {
        global $conn;

        // Start transaction
        $conn->begin_transaction();

        try {
            // Create new order
            $sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, 0, 'pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $orderId = $conn->insert_id;

            // Insert order items and calculate total price
            $totalPrice = 0;
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            foreach ($cartItems as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $stmt->bind_param('iiid', $orderId, $productId, $quantity, $price);
                $stmt->execute();
                $totalPrice += $price * $quantity;
            }

            // Update order with total price
            $sql = "UPDATE orders SET total_price = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('di', $totalPrice, $orderId);
            $stmt->execute();

            // Insert address
            $sql = "INSERT INTO addresses (user_id, order_id, address_line_1, address_line_2, city, state, postal_code, country) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iissssss', $userId, $orderId, $address['line1'], $address['line2'], $address['city'], 
                                              $address['state'], $address['postal_code'], $address['country']);
            $stmt->execute();

            // Clear cart after order
            $sql = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            return $orderId;

        } catch (Exception $e) {
            // Rollback transaction if anything fails
            $conn->rollback();
            throw $e;
        }
    }
}
?>
