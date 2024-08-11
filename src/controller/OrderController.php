<?php
require_once __DIR__ . '/../config/db.php';

class OrderController {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function placeOrder($user_id, $total_amount) {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
        $stmt->bind_param("id", $user_id, $total_amount);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Move items from cart to order_items and then clear the cart
            $cartItems = $this->getCartItems($user_id);
            foreach ($cartItems as $item) {
                $this->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
            }

            // Clear the user's cart
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            return $order_id;
        } else {
            die("Order placement failed: " . $stmt->error);
        }
    }

    private function getCartItems($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    private function addOrderItem($order_id, $product_id, $quantity, $price) {
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt->execute();
    }

    public function getOrderSummary($order_id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        $stmt = $this->conn->prepare("SELECT oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return [
            'total_amount' => $order['total_amount'],
            'items' => $items
        ];
    }
}
?>
