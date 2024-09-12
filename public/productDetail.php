<?php
session_start();
require_once '../src/config/db.php'; // Adjust the path to your database connection file

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details from the database
$product = null;
if ($productId > 0) {
    // Modify the SQL query to include 'category'
    $stmt = $conn->prepare("SELECT id, name, description, price, image, category FROM products WHERE id = ?");
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
        .container {
            max-width: 1200px;
        }
        .content {
            flex: 1;
        }
        .key-points ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .key-points li {
            margin-bottom: 8px;
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
                    <img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full max-w-md mx-auto rounded-3xl mb-4">
                </div>
                <div class="md:w-1/2 p-4">
                    <h2 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <!-- Product Price -->
                    <p class="text-indigo-500 text-2xl font-bold mb-6">$<?php echo number_format($product['price'], 2); ?></p>

                    <!-- Key Points Section -->
                    <div class="key-points mb-6">
                        <h3 class="text-lg font-semibold mb-3">Key Features:</h3>
                        <ul class="text-gray-700">
                            <li>Made with 100% organic ingredients</li>
                            <li>Eggless and 100% vegetarian</li>
                            <li>Freshly baked daily</li>
                            <li>Customizable for special occasions</li>
                            <li>Available in multiple sizes</li>
                        </ul>
                    </div>

                    <!-- Display Weight Dropdown only if the category is 'cake' -->
                    <form action="../src/controller/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        
                        <?php if (strtolower($product['category']) === 'cake'): ?>
                            <div class="mb-4">
                                <label for="weight" class="block text-lg font-medium text-gray-700 mb-2">Select Weight</label>
                                <select id="weight" name="weight" class="block border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="" disabled selected>Select weight</option>
                                    <option value="0.5kg">0.5 kg</option>
                                    <option value="1kg">1 kg</option>
                                    <option value="2kg">2 kg</option>
                                    <option value="3kg">3 kg</option>
                                </select>
                            </div>
                            
                            <?php endif; ?>
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
