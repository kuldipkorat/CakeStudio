<?php
session_start();
require_once '../src/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$totalAmount = 0;

$stmt = $conn->prepare("
    SELECT c.id, c.product_id, c.quantity, c.weight, p.name, p.price, p.image 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="container mx-auto my-10 p-6">
        <h2 class="text-3xl font-bold mb-6">My Cart</h2>
        <?php if (empty($cartItems)): ?>
            <p class="mb-5">Your cart is empty.</p>
            <a href="dashboard.php" class="text-indigo-600 bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300">Continue Shopping</a>
        <?php else: ?>
            <table class="w-full text-left mb-6 border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4">Product</th>
                        <th class="py-2 px-4">Price</th>
                        <th class="py-2 px-4">Quantity</th>
                        <th class="py-2 px-4">Total</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <?php
                        $totalPrice = $item['price'] * $item['quantity'];
                        $totalAmount += $totalPrice;
                        ?>
                        <tr class="border-b">
                            <td class="py-2 px-4 flex items-center">
                                <a href="productDetail.php?id=<?php echo $item['product_id']; ?>">
                                    <img src="../public/images/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-16 h-16 object-cover mr-4">
                                </a>
                                <div>
                                    <a href="productDetail.php?id=<?php echo $item['product_id']; ?>">
                                        <p><?php echo htmlspecialchars($item['name']); ?></p>
                                    </a>
                                    <?php if (!empty($item['weight'])): ?>
                                        <p class="text-gray-500 text-sm">Weight: <?php echo htmlspecialchars($item['weight']); ?></p>
                                    <?php endif; ?>

                                </div>
                            </td>
                            <td class="py-2 px-4">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="py-2 px-4 flex items-center">
                                <button onclick="updateCart(<?php echo $item['product_id']; ?>, -1)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">-</button>
                                <span class="mx-2"><?php echo $item['quantity']; ?></span>
                                <button onclick="updateCart(<?php echo $item['product_id']; ?>, 1)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">+</button>
                            </td>
                            <td class="py-2 px-4">$<?php echo number_format($totalPrice, 2); ?></td>
                            <td class="py-2 px-4">
                                <button onclick="removeFromCart(<?php echo $item['product_id']; ?>)" class="text-red-600 hover:underline">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="flex justify-end mb-6">
                <div>
                    <h3 class="text-2xl font-bold">Order Summary</h3>
                    <p class="mt-2">Total Amount: <span class="font-semibold">$<?php echo number_format($totalAmount, 2); ?></span></p>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="dashboard.php" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300">Continue Shopping</a>
                <a href="checkout.php" class="bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../partials/footer.php'; ?>

    <script>
        function updateCart(productId, delta) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../src/controller/update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send(`product_id=${productId}&delta=${delta}`);
        }

        function removeFromCart(productId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../src/controller/remove_from_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    </script>
</body>

</html>