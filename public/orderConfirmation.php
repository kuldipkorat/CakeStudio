<?php
session_start();

// Example data for the order confirmation (In a real scenario, this would be retrieved from a database or session)
$orderNumber = rand(100000, 999999); // Random order number for demonstration
$cartItems = [
    [
        'name' => 'Chocolate Cake',
        'quantity' => 2,
        'price' => 20.00,
        'image' => 'https://via.placeholder.com/100'
    ],
    [
        'name' => 'Vanilla Cake',
        'quantity' => 1,
        'price' => 15.00,
        'image' => 'https://via.placeholder.com/100'
    ]
];

// Calculate total amount
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .order-summary {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

    <!-- Order Confirmation Section -->
    <div class="container mx-auto my-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-4xl font-bold mb-6 text-center text-green-600">Thank You for Your Order!</h2>
        <p class="text-center text-xl mb-8">Your order has been placed successfully. Below is a summary of your purchase.</p>

        <div class="order-summary mb-8">
            <h3 class="text-2xl font-bold mb-4">Order Summary</h3>
            <p class="text-lg mb-4"><strong>Order Number:</strong> #<?php echo $orderNumber; ?></p>

            <!-- Items List -->
            <div class="space-y-4">
                <?php foreach ($cartItems as $item): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg">
                        <div class="flex items-center">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-24 h-24 object-cover rounded mr-4">
                            <div>
                                <h3 class="text-xl font-bold"><?php echo $item['name']; ?></h3>
                                <p class="text-gray-700">Quantity: <?php echo $item['quantity']; ?></p>
                                <p class="text-gray-700">Price: $<?php echo number_format($item['price'], 2); ?></p>
                            </div>
                        </div>
                        <p class="text-xl font-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Total Amount -->
            <div class="text-right mt-6">
                <p class="text-xl font-bold">Total Amount: $<?php echo number_format($totalAmount, 2); ?></p>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="text-center">
            <a href="dashboard.php" class="bg-indigo-500 text-white py-3 px-6 rounded-lg font-semibold mr-4">Continue Shopping</a>
            <a href="orderDetails.php?order=<?php echo $orderNumber; ?>" class="bg-gray-700 text-white py-3 px-6 rounded-lg font-semibold">View Order Details</a>
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
