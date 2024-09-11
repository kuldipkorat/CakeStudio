<?php
session_start(); // Start session to handle success/error messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cake Studio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('../partials/header.php'); ?>

    <section class="container bg-white py-10">
        <div class=" mx-auto px-4">

            <!-- Page Title -->
            <h2 class="text-4xl font-bold text-indigo-600 mb-4">Contact Us</h2>
            <p class="text-lg text-gray-700 mb-6">
                Have any questions? Feel free to reach out to us using the form below or give us a call. We're always happy to help!
            </p>

            <!-- Feedback Messages (Success/Error) -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <form action="../src/controller/submit_contact.php" method="POST" class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md" >
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md" >
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-lg font-semibold text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" class="w-full p-3 border border-gray-300 rounded-md"s></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Submit</button>
            </form>

            <!-- Contact Info -->
            <!-- <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-800">Get in Touch</h3>
                <p class="text-lg text-gray-700 mt-2"><i class="fas fa-phone-alt"></i> +1 (555) 123-4567</p>
                <p class="text-lg text-gray-700 mt-2"><i class="fas fa-envelope"></i> contact@cakestudio.com</p>
                <p class="text-lg text-gray-700 mt-2"><i class="fas fa-map-marker-alt"></i> 123 Cake Street, Bakery Town, USA</p>
            </div> -->
        </div>
    </section>

    <!-- Footer -->
    <?php include('../partials/footer.php'); ?>
</body>
</html>
