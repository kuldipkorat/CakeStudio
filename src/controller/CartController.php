<?php
session_start();
include_once '../config/db.php';

class CartController {

    // Function to add an item to the cart
    public function addToCart($userId, $productId, $quantity = 1) {
        global $conn;

        // Check database connection
        if ($conn->connect_error) {
            return ['success' => false, 'message' => 'Database connection failed'];
        }

        // Prepare SQL statement
        $sql = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare SQL statement'];
        }

        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Item already in cart, update quantity
            $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return ['success' => false, 'message' => 'Failed to prepare update SQL statement'];
            }
            $stmt->bind_param('iii', $quantity, $userId, $productId);
        } else {
            // Add new item to cart
            $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return ['success' => false, 'message' => 'Failed to prepare insert SQL statement'];
            }
            $stmt->bind_param('iii', $userId, $productId, $quantity);
        }

        if (!$stmt->execute()) {
            return ['success' => false, 'message' => 'Failed to execute SQL statement'];
        }

        // Update the session cart count
        $cartCount = $this->getCartCount($userId);
        $_SESSION['cart_count'] = $cartCount;

        return ['success' => true, 'cart_count' => $cartCount];
    }

    // Function to update cart item quantity
    public function updateCartItem($userId, $productId, $quantity) {
        global $conn;

        if ($quantity <= 0) {
            return $this->removeFromCart($userId, $productId);
        }

        $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare SQL statement'];
        }

        $stmt->bind_param('iii', $quantity, $userId, $productId);
        if (!$stmt->execute()) {
            return ['success' => false, 'message' => 'Failed to update cart item'];
        }

        // Update the session cart count
        $cartCount = $this->getCartCount($userId);
        $_SESSION['cart_count'] = $cartCount;

        return ['success' => true, 'cart_count' => $cartCount];
    }

    // Function to remove an item from the cart
    public function removeFromCart($userId, $productId) {
        global $conn;

        $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare SQL statement'];
        }

        $stmt->bind_param('ii', $userId, $productId);
        if (!$stmt->execute()) {
            return ['success' => false, 'message' => 'Failed to remove item from cart'];
        }

        // Update the session cart count
        $cartCount = $this->getCartCount($userId);
        $_SESSION['cart_count'] = $cartCount;

        return ['success' => true, 'cart_count' => $cartCount];
    }

    // Function to get the total cart count
    public function getCartCount($userId) {
        global $conn;

        $sql = "SELECT SUM(quantity) as cart_count FROM cart_items WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return 0;
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['cart_count'] ? $row['cart_count'] : 0;
    }

    // Function to get all cart items
    public function getCartItems($userId) {
        global $conn;

        $sql = "SELECT ci.product_id, ci.quantity, p.name, p.price 
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
}

// Create CartController instance
$cartController = new CartController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in.'
        ]);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $action = $_POST['action'] ?? null;
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    switch ($action) {
        case 'add':
            $response = $cartController->addToCart($userId, $productId, $quantity);
            break;
        case 'update':
            $response = $cartController->updateCartItem($userId, $productId, $quantity);
            break;
        case 'remove':
            $response = $cartController->removeFromCart($userId, $productId);
            break;
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
            break;
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Ensure no further output is sent
}
?>
