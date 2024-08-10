<?php
require_once '../config/db.php';
// require_once '../controller/CartController.php';

class OrderController {
    private $conn;
    private $cartController;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->cartController = new CartController();
    }

    public function placeOrder($user_id, $total_amount) {
        try {
            $this->conn->beginTransaction();

            // Insert order
            $query = "INSERT INTO orders (user_id, order_date, total_amount) VALUES (:user_id, NOW(), :total_amount)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':total_amount', $total_amount);
            $stmt->execute();

            $order_id = $this->conn->lastInsertId();

            // Insert order items
            $cart_items = $this->cartController->getCartByUserId($user_id);
            foreach ($cart_items as $item) {
                $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':product_id', $item['product_id']);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->execute();
            }

            // Clear cart
            $this->cartController->clearCart($user_id);

            $this->conn->commit();

            return $order_id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
