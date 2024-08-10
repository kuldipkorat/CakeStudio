<?php
require_once '../config/db.php';

class CartController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCartByUserId($user_id) {
        $query = "SELECT c.id, c.quantity, p.name, p.price, p.image 
                  FROM carts c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($user_id, $product_id, $quantity) {
        $query = "SELECT * FROM carts WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            $query = "UPDATE carts SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        } else {
            $query = "INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    public function removeItem($cart_id) {
        $query = "DELETE FROM carts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $cart_id);
        $stmt->execute();
    }

    public function clearCart($user_id) {
        $query = "DELETE FROM carts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
}
