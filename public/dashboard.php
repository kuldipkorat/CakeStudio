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
    <title>Cake Studio Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }

        .hero {
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            color: white;
        }

        .hero-content {
            backdrop-filter: blur(5px);
        }

        .policy-card {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }

        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            z-index: 20;
        }

        .hero-content {
            z-index: 10;
        }
    </style>
</head>

<body class=" ">
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 shadow-md z-20 relative">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Cake Studio</h1>
            <nav class="flex items-center">
                <a href="cart.php" class="relative text-white hover:text-indigo-200 px-3">
                    <i class="fa fa-shopping-cart text-2xl"></i>
                    <span id="cartCount" class="absolute -top-1 -right-2 bg-red-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
                </a>
                <div class="relative">
                    <button class="relative z-10 block bg-indigo-500 text-white focus:outline-none px-3 py-2 rounded">
                        Categories <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden">
                        <a href="cakes.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Cakes</a>
                        <a href="brownies.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Brownies</a>
                        <a href="pastries.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Pastries</a>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../src/controller/logout.php" class="text-white hover:text-indigo-200 px-3">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white hover:text-indigo-200 px-3">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero relative flex items-center justify-center text-center py-20 z-10">
        <div class="absolute inset-0 bg-opacity-50"></div>
        <div class="hero-content relative z-10 p-8">
            <h2 class="text-4xl font-bold mb-4">Welcome to Cake Studio</h2>
            <p class="text-lg mb-6">Delicious, fresh, and eggless cakes just for you!</p>
            <button id="scrollToProducts" class="bg-indigo-500 text-white py-2 px-4 rounded">Shop Now</button>
        </div>
    </section>

    <!-- Studio Policies -->
    <section class="container mx-auto my-10 p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="" alt="100% Veg" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">100% Veg</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="" alt="Eggless Cakes" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Eggless Cakes</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="" alt="Fresh Products" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Fresh Products</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="" alt="Variety" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Wide Variety</p>
            </div>
        </div>
    </section>

    <!-- Product Showcase Sections -->
    <section class="container mx-auto my-10 p-6" id="productSection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Cake Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $product): ?>
                <?php if ($product['category'] === 'cake'): ?>
                    <div class="product-card bg-white rounded-lg shadow-lg p-4">
                        <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-indigo-500 font-bold mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container mx-auto my-10 p-6" id="brownieSection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Brownie Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $product): ?>
                <?php if ($product['category'] === 'brownie'): ?>
                    <div class="product-card bg-white rounded-lg shadow-lg p-4">
                        <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-indigo-500 font-bold mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container mx-auto my-10 p-6" id="pastrySection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Pastry Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $product): ?>
                <?php if ($product['category'] === 'pastry'): ?>
                    <div class="product-card bg-white rounded-lg shadow-lg p-4">
                        <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-indigo-500 font-bold mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
        <p>&copy; 2024 Cake Studio. All rights reserved.</p>
        <div class="mt-4">
            <p>Contact Us: 123-456-7890</p>
            <p>Visit Us: 123 Cake Street, Bakersville</p>
            <p>Email: info@cakestudio.com</p>
        </div>
        <p class="mt-4 text-gray-400 text-sm">About Cake Studio: We specialize in 100% vegetarian, eggless cakes made fresh with the finest ingredients. Our wide variety of cakes ensures that there's something for everyone.</p>
    </footer>

    <script src="../public/js/cart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButton = document.querySelector('button.relative.z-10');
            const dropdownMenu = dropdownButton.nextElementSibling;

            dropdownButton.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });

        // Smooth scroll to products section
        document.getElementById('scrollToProducts').addEventListener('click', () => {
            document.querySelector('#productSection').scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</body>
</html>
