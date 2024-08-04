<?php
session_start();
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
<body class="">
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold cursor-pointer">
                <a href="dashboard.php">Cake Studio</a>
            </h1>
            <nav class="flex items-center">
            <a href="cart.php" class="relative text-white hover:text-indigo-200 px-3">
                <i class="fa fa-shopping-cart text-2xl"></i>
                <span id="cartCount" class="absolute -top-1 -right-2 bg-red-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
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
        <div id="productDetail" class="flex flex-col md:flex-row">
            <!-- Product Details will be inserted here by JavaScript -->
        </div>
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

    <!-- Include product data and script for displaying product details -->
    <script src="../public/js/product.js"></script>
    <script src="../public/js/cart.js"></script>
    <script>
        // Function to get URL parameters
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        document.addEventListener('DOMContentLoaded', () => {
            const productId = getUrlParameter('id');
            const product = products.find(p => p.id == productId);

            if (product) {
                document.getElementById('productDetail').innerHTML = `
                    <div class="md:w-1/2 p-4">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-auto max-w-md mx-auto rounded mb-4">
                    </div>
                    <div class="md:w-1/2 p-4">
                        <h2 class="text-3xl font-bold mb-4">${product.name}</h2>
                        <p class="text-gray-700 mb-4">${product.description}</p>
                        <p class="text-indigo-500 text-2xl font-bold mb-6">$${product.price.toFixed(2)}</p>
                        <button class="bg-indigo-500 text-white py-2 px-4 rounded" onclick="addToCart(${product.id})">Add to Cart</button>
                    </div>
                `;
            } else {
                document.getElementById('productDetail').innerHTML = `
                    <p class="text-red-500 text-lg">Product not found.</p>
                `;
            }
        });

        function addToCart(productId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const product = products.find(p => p.id == productId);
            const existingProduct = cart.find(p => p.id == productId);

            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                product.quantity = 1;
                cart.push(product);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Product added to cart');
        }
    </script>
</body>
</html>
