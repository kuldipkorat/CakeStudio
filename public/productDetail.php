<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-10 p-6 bg-white rounded shadow-lg">
        <div id="productDetail" class="flex flex-col md:flex-row">
            <!-- Product Details will be inserted here by JavaScript -->
        </div>
        <div class="text-center mt-6">
            <a href="dashboard.php" class="text-indigo-500 hover:underline">Back to Products</a>
        </div>
    </div>

    <!-- Include product data and script for displaying product details -->
    <script src="../public/js/product.js"></script>
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
                        <img src="${product.image}" alt="${product.name}" class="w-full rounded mb-4">
                    </div>
                    <div class="md:w-1/2 p-4">
                        <h2 class="text-3xl font-bold mb-4">${product.name}</h2>
                        <p class="text-gray-700 mb-4">${product.description}</p>
                        <p class="text-indigo-500 text-2xl font-bold mb-6">$${product.price.toFixed(2)}</p>
                        <button class="bg-indigo-500 text-white py-2 px-4 rounded">Add to Cart</button>
                    </div>
                `;
            } else {
                document.getElementById('productDetail').innerHTML = `
                    <p class="text-red-500 text-lg">Product not found.</p>
                `;
            }
        });
    </script>
</body>
</html>
