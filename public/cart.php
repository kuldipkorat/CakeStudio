<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Cake Studio</title>
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
        .cart-summary {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .quantity-btn {
            padding: 0 10px;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
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
    <div class="container mx-auto my-10 p-6 content flex flex-col lg:flex-row" id="cartContainer">
        <div class="lg:w-2/3 w-full">
            <h2 class="text-3xl font-bold mb-6 text-center">Shopping Cart</h2>
            <div id="cartItems" class="flex flex-col">
                <!-- Cart items will be inserted here by JavaScript -->
            </div>
            <div class="text-center mt-6">
                <a href="dashboard.php" class="text-indigo-500 hover:underline">Back to Products</a>
            </div>
        </div>
            <!-- <div class="lg:w-1/3 w-full cart-summary ml-0 lg:ml-6 mt-6 lg:mt-0 hidden" id="cartSummary">
                <h2 class="text-2xl font-bold mb-4">Cart Summary</h2>
                <p class="text-xl">Product Count: <span id="productCount">0</span></p>
                <p class="text-xl">Total Quantity: <span id="totalQuantity">0</span></p>
                <p class="text-xl">Discount: <span id="discount">0</span>%</p>
                <p class="text-xl font-bold mt-4">Total Amount: $<span id="totalAmount">0.00</span></p>
            </div> -->
        <div class="lg:w-1/3 w-full cart-summary ml-0 lg:ml-6 mt-6 lg:mt-0 hidden" id="cartSummary">
    <h2 class="text-2xl font-bold mb-4">Cart Summary</h2>
    <p class="text-xl">Product Count: <span id="productCount">0</span></p>
    <p class="text-xl">Total Quantity: <span id="totalQuantity">0</span></p>
    <p class="text-xl">Discount: <span id="discount">0</span>%</p>
    <p class="text-xl font-bold mt-4">Total Amount: $<span id="totalAmount">0.00</span></p>
    <a href="checkout.php" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center mt-6">Buy Now</a>
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

    <!-- Include script for cart functionality -->
    <script src="../public/js/cart.js"></script>
    <script>
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsContainer = document.getElementById('cartItems');
            const cartSummary = document.getElementById('cartSummary');
            const productCountElement = document.getElementById('productCount');
            const totalQuantityElement = document.getElementById('totalQuantity');
            const discountElement = document.getElementById('discount');
            const totalAmountElement = document.getElementById('totalAmount');
            
            cartItemsContainer.innerHTML = '';
            let totalAmount = 0;
            let totalQuantity = 0;
            
            cart.forEach(product => {
                const productTotal = product.price * product.quantity;
                totalAmount += productTotal;
                totalQuantity += product.quantity;
                
                cartItemsContainer.innerHTML += `
                    <div class="flex items-center justify-between p-4 bg-white shadow-md rounded mb-4">
                        <div class="flex items-center">
                            <img src="${product.image}" alt="${product.name}" class="w-24 h-24 object-cover rounded mr-4">
                            <div>
                                <h3 class="text-xl font-bold">${product.name}</h3>
                                <p class="text-gray-700">Price: $${product.price.toFixed(2)}</p>
                                <p class="text-gray-700">Quantity: 
                                    <button class="quantity-btn" onclick="updateQuantity(${product.id}, -1)">-</button>
                                    <span class="mx-2">${product.quantity}</span>
                                    <button class="quantity-btn" onclick="updateQuantity(${product.id}, 1)">+</button>
                                </p>
                                <p class="text-gray-700">Total: $${productTotal.toFixed(2)}</p>
                            </div>
                        </div>
                        <button class="text-red-500" onclick="removeFromCart(${product.id})">Remove</button>
                    </div>
                `;
            });

            if (cart.length > 0) {
                cartSummary.classList.remove('hidden');
                const discount = totalQuantity > 10 ? 10 : 0; // Example discount rule
                const discountedTotal = totalAmount - (totalAmount * discount / 100);

                productCountElement.textContent = cart.length;
                totalQuantityElement.textContent = totalQuantity;
                discountElement.textContent = discount;
                totalAmountElement.textContent = discountedTotal.toFixed(2);
            } else {
                cartSummary.classList.add('hidden');
            }
        }

        function updateQuantity(productId, change) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const product = cart.find(p => p.id == productId);

            if (product) {
                product.quantity += change;
                if (product.quantity <= 0) {
                    cart = cart.filter(p => p.id != productId);
                }
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeFromCart(productId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(p => p.id != productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>
</html>
