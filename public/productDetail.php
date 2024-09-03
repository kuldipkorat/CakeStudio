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
    <?php
    include '../partials/header.php';
    ?>

    <!-- Main Content -->
    <div class="container mx-auto my-10 p-6 content">
        <?php if ($product): ?>
            <div id="productDetail" class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-4">
                    <img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full max-w-md mx-auto rounded mb-4">
                </div>
                <div class="md:w-1/2 p-4">
                    <h2 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="text-indigo-500 text-2xl font-bold mb-6">$<?php echo number_format($product['price'], 2); ?></p>
                    <form action="../src/controller/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">

                        <!-- Weight Dropdown -->
                        <div class="mb-4">
                            <label for="weight" class="block text-lg font-medium text-gray-700 mb-2">Select Weight</label>
                            <select id="weight" name="weight" class="block  border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="" disabled selected>Select weight</option>
                                <option value="0.5kg">0.5 kg</option>
                                <option value="1kg">1 kg</option>
                                <option value="2kg">2 kg</option>
                                <option value="3kg">3 kg</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <input type="hidden" name="quantity" value="1"> <!-- Default quantity -->
                        <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded">Add to Cart</button>
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
    <?php include '../partials/footer.php'; ?>
</body>

</html>