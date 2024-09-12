<?php
session_start();
require_once '../src/config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Check if an address ID is submitted or if a new address is added
if (!isset($_POST['address_id'])) {
    header("Location: checkout.php");
    exit;
}

$addressId = $_POST['address_id'];

// Fetch the selected address from the database
$stmt = $conn->prepare("SELECT * FROM addresses WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $addressId, $userId);
$stmt->execute();
$addressResult = $stmt->get_result();

if ($addressResult->num_rows === 0) {
    header("Location: checkout.php");
    exit;
}

$address = $addressResult->fetch_assoc();

// Fetch cart items for the current user
$stmt = $conn->prepare("
    SELECT c.id, c.product_id, c.quantity, p.price,c.weight
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$cartResult = $stmt->get_result();

if ($cartResult->num_rows === 0) {
    header("Location: checkout.php");
    exit;
}

$totalAmount = 0;
$orderItems = [];

while ($row = $cartResult->fetch_assoc()) {
    $orderItems[] = $row;
    $totalAmount += $row['price'] * $row['quantity'];
}

// Insert the order into the orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, address_id, total_amount) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $userId, $addressId, $totalAmount);
$stmt->execute();
$orderId = $stmt->insert_id; // Get the order ID for the order items

// Insert each cart item into the order_items table, including the weight
// Insert each cart item into the order_items table, including the weight
foreach ($orderItems as $item) {
    // If the weight is null or empty, bind NULL instead of a string/decimal value
    if (empty($item['weight'])) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, weight) VALUES (?, ?, ?, ?, NULL)");
        $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
    } else {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidd", $orderId, $item['product_id'], $item['quantity'], $item['price'], $item['weight']);
    }
    $stmt->execute();
}


// Clear the cart for the user
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
// Update session cart count to 0 after clearing the cart
$_SESSION['cart_count'] = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
                .button-color {
            /* background-color: #53a8b6; */
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }
        .button-color:hover {
            background-color: #53a8b6;
            /* background-color: white; */
            border-color: white;
            color: white;
        }
    </style>
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="container mx-auto my-10 p-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Thank You for Your Order!</h2>
        <p class="text-lg mb-4">Your order has been placed successfully.</p>
        <p class="text-md mb-6">Your order ID is <strong><?php echo $orderId; ?></strong></p>
        <p class="text-md mb-6">We will deliver to the following address:</p>
        <p><strong><?php echo htmlspecialchars($address['name']); ?></strong></p>
        <p><?php echo htmlspecialchars($address['house_no']); ?>, <?php echo htmlspecialchars($address['address_line1']); ?></p>
        <p><?php echo htmlspecialchars($address['city']); ?>, <?php echo htmlspecialchars($address['state']); ?> - <?php echo htmlspecialchars($address['pin_code']); ?></p>
        <p>Mobile: <?php echo htmlspecialchars($address['mobile']); ?></p>

        <a href="dashboard.php" class="button-color text-white py-2 px-4 rounded mt-8">Continue Shopping</a>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>