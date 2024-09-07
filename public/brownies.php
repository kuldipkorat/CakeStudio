<?php
session_start();
require_once '../src/config/db.php';

// Fetch products from the database
$query = "SELECT id, name, description, price, category, image FROM products";
$result = $conn->query($query);
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Studio - Brownies</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include '../partials/header.php'; ?>

    <!-- Brownie Products Section -->
    <section class="container mx-auto my-10 p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Our Brownie Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $product): ?>
                <?php if ($product['category'] === 'brownie'): ?>
                    <div class="product-card bg-white rounded-lg shadow-lg p-4">
                        <a href="productDetail.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4 w-full h-60 object-cover" />
                            <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="text-indigo-500 font-bold mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="productDetail.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../partials/footer.php'; ?>

</body>
</html>
