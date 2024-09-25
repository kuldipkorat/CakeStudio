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
        .text-color {
            color: #53a8b6;
        }
        .input-border {
            border-color: gray;
        }

        .input-border:focus {
            border-color: #53a8b6;
            outline: none;
        }

        .home-button {
            background-color: #53a8b6;
            border-color: white;
            color: white;
        }

        .home-button:hover {
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('../partials/header.php'); ?>

    <section class="bg-white py-10">
        <div class="container mx-auto px-4">

            <!-- Page Title -->
            <h2 class="text-color text-4xl font-bold mb-4">Contact Us</h2>
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
            <form action="" method="" class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" id="name" name="name" class="input-border rounded-full w-full p-3 border" >
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" class="input-border rounded-full w-full p-3 border" >
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-lg font-semibold text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" class="input-border rounded-lg w-full p-3 border"></textarea>
                </div>
                <button type="submit" class="home-button text-white px-4 py-2 rounded border">Submit</button>
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
