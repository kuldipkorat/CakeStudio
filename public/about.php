<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Cake Studio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }

        .text-color {
            color: #53a8b6;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('../partials/header.php'); ?>

    <!-- About Us Section -->
    <section class="h-screen bg-white py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-color text-4xl font-bold mb-4">About Cake Studio</h2>
            <p class="text-lg text-gray-700 mb-4">
                Cake Studio is your go-to place for delicious cakes, brownies, pastries, and more. We take pride in offering high-quality, freshly baked goods that satisfy all taste buds. Our team of expert bakers brings their passion for baking to life with every treat.
            </p>
            <p class="text-lg text-gray-700 mb-4">
                Founded in 2022, Cake Studio has quickly become a favorite spot for cake lovers. We offer custom cake services for all kinds of celebrations, including weddings, birthdays, and corporate events.
            </p>
            <p class="text-lg text-gray-700">
                Thank you for choosing Cake Studio. We’re here to sweeten your day!
            </p>
        </div>
    </section>

    <!-- Footer -->
    <?php include('../partials/footer.php'); ?>
</body>

</html>