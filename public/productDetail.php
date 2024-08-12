<?php
session_start();
require_once '../src/config/db.php'; // Adjust the path to your database connection file

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details from the database
$product = null;
if ($productId > 0) {
    $stmt = $conn->prepare("SELECT id, name, description, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold cursor-pointer">
                <a href="dashboard.php">Cake Studio</a>
            </h1>
            <nav class="flex items-center">
                <a href="cart.php" class="relative text-white hover:text-indigo-200 px-3">
                    <i class="fa fa-shopping-cart text-2xl"></i>
                    <span id="cartCount" class="absolute -top-1 -right-2 bg-red-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                        <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
                    </span>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <a href="../src/controller/logout.php" class="text-white hover:text-indigo-200 px-3">Logout</a>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <a href="login.php" class="text-white hover:text-indigo-200 px-3">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto my-10 p-6 content">
        <?php if ($product): ?>
            <div id="productDetail" class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-4">
                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-auto max-w-md mx-auto rounded mb-4">
                </div>
                <div class="md:w-1/2 p-4">
                    <h2 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="text-indigo-500 text-2xl font-bold mb-6">$<?php echo number_format($product['price'], 2); ?></p>
                    <form action="../src/controller/cartController.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <button type="submit" name="add_to_cart" class="bg-indigo-500 text-white py-2 px-4 rounded">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p class="text-red-500 text-lg">Product not found.</p>
        <?php endif; ?>
        <div class="text-center mt-6">
            <a href="dashboard.php" class="text-indigo-500 hover:underline">Back to Products</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; 2024 Cake Studio. All rights reserved.</p>
        <div class="mt-4">
            <p>Contact Us: 123-456-7890</p>
            <p>Visit Us: 123 Cake Street, Bakersville</p>
            <p>Email: info@cakestudio.com</p>
        </div>
        <p class="mt-4 text-gray-400 text-sm">About Cake Studio: We specialize in 100% vegetarian, eggless cakes made fresh with the finest ingredients. Our wide variety of cakes ensures that there's something for everyone.</p>
    </footer>
</body>
</html>
