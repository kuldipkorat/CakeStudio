<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 4px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold cursor-pointer">
                <a href="dashboard.php">Cake Studio</a>
            </h1>
        </div>
    </header>

    <!-- Address Form Section -->
    <div class="container mx-auto my-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-bold mb-6 text-center">Delivery Address</h2>
        <form id="addressForm" class="space-y-6">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Full Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg" placeholder="Your Full Name">
                <p id="nameError" class="error-message hidden">Name is required.</p>
            </div>

            <!-- Mobile Number Field -->
            <div>
                <label for="mobile" class="block text-lg font-medium text-gray-700">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg" placeholder="Your Mobile Number">
                <p id="mobileError" class="error-message hidden">Valid mobile number is required.</p>
            </div>

            <!-- Address Lines Field -->
            <div>
                <label for="address" class="block text-lg font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" rows="4" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg" placeholder="Your Address"></textarea>
                <p id="addressError" class="error-message hidden">Address is required.</p>
            </div>

            <!-- Place Order Button -->
            <button type="submit" class="w-full bg-indigo-500 text-white py-3 rounded-lg font-semibold">Place Order</button>
        </form>
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

    <!-- Validation Script -->
    <script>
        document.getElementById('addressForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(function(el) {
                el.classList.add('hidden');
            });

            // Input fields
            const name = document.getElementById('name').value.trim();
            const mobile = document.getElementById('mobile').value.trim();
            const address = document.getElementById('address').value.trim();

            let isValid = true;

            // Name validation
            if (name === '') {
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            }

            // Mobile number validation (basic pattern: 10 digits)
            const mobilePattern = /^[0-9]{10}$/;
            if (!mobilePattern.test(mobile)) {
                document.getElementById('mobileError').classList.remove('hidden');
                isValid = false;
            }

            // Address validation
            if (address === '') {
                document.getElementById('addressError').classList.remove('hidden');
                isValid = false;
            }

            // If the form is valid, proceed to submit the form or navigate to the next step
            if (isValid) {
                // Optionally, you can redirect to a success or order summary page
                window.location.href = "orderConfirmation.php";
            }
        });
    </script>
</body>
</html>
