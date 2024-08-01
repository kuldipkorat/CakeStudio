<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Studio Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Cake Studio</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../src/controller/logout.php" class="text-white hover:text-indigo-200 px-3">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white hover:text-indigo-200 px-3">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero relative flex items-center justify-center text-center py-20">
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
                <img src="path-to-your-icon1.png" alt="100% Veg" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">100% Veg</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="path-to-your-icon2.png" alt="Eggless Cakes" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Eggless Cakes</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="path-to-your-icon3.png" alt="Fresh Products" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Fresh Products</p>
            </div>
            <div class="policy-card p-4 rounded-lg text-center shadow-lg">
                <img src="path-to-your-icon4.png" alt="Variety" class="mx-auto mb-4" />
                <p class="text-lg font-semibold">Wide Variety</p>
            </div>
        </div>
    </section>

    <!-- Product Showcase -->
    <section class="container mx-auto my-10 p-6" id="productSection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="productCards">
            <!-- Product cards will be inserted here by JavaScript -->
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

    <!-- Include product data and script to generate product cards -->
    <script src="../public/js/product.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productCards = document.getElementById('productCards');

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card', 'bg-white', 'rounded-lg', 'shadow-lg', 'p-4');
                productCard.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" class="rounded mb-4" />
                    <h3 class="text-xl font-semibold mb-2">${product.name}</h3>
                    <p class="text-gray-700 mb-2">${product.description}</p>
                    <p class="text-indigo-500 font-bold mb-4">$${product.price.toFixed(2)}</p>
                    <a href="productDetail.php?id=${product.id}" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                `;
                productCards.appendChild(productCard);
            });
        });

        // Smooth scroll to products section
        document.getElementById('scrollToProducts').addEventListener('click', () => {
            document.querySelector('#productSection').scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</body>

</html>
