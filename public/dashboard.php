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

function getLimitedProducts($products, $category, $limit = 4)
{
    $filteredProducts = array_filter($products, function ($product) use ($category) {
        return $product['category'] === $category;
    });

    return array_slice($filteredProducts, 0, $limit);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Studio Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMaTfWsDx5h5OSzPn1kaEMpXVNPJ5d1s6Au6niH" crossorigin="anonymous">
    <style>
        .container {
            max-width: 1200px;
        }

        /* .hero {
    background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../public/images/cake5.jpg') center/cover no-repeat;
    color: white;
    min-height: 60vh;
    width: 100vw; /* Make sure it takes the full width */
    /* position: relative;
    margin-left: calc(-50vw + 50%); 
    margin-right: calc(-50vw + 50%);
}  */

        .hero-content {
            z-index: 10;
            max-width: 600px;
        }

        .hero h2 {
            font-size: 3rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.125rem;
            /* color: rgba(255, 255, 255, 0.9); */
        }

        .hero button {
            border-color: #53a8b6;
        }
        .hero button:hover {
            background-color: #53a8b6;
            border-color: white;
            color: white;
        }

        .hero-image img {
            object-fit: contain; 
            max-width: 100%;
            height: 500px;
            /* border-radius: 1rem;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); */
        }


        .policy-card {
            /* background: linear-gradient(135deg, #53a8b6 0%, #bbe4e9 100%); */
            border-color: #53a8b6;
            color:black;
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

        .button-color {
            /* background-color: #53a8b6; */
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }
        .button-color:hover {
            background-color: #53a8b6;
            /* background-color: white; */
            border-color: white;
            color: white;
        }
    </style>
</head>

<body class=" ">
    <?php include '../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero relative flex items-center justify-between text-center py-20 z-10" style="font-family: 'Roboto', sans-serif;" >
    <div class="hero-content relative z-10 p-8 w-full lg:w-1/2 text-left lg:ml-32 lg:mr-0 mx-auto">
        <h2 class="text-5xl font-bold mb-4 text-black">Welcome to Cake Studio</h2>
        <p class="text-lg mb-6 text-black">Delicious, fresh, and eggless cakes just for you!</p>
        <button id="scrollToProducts" class="bg-white transition-all duration-300 text-black py-3 px-6 rounded-full shadow-lg border-2">Shop Now</button>
    </div>
    <div class="hero-image w-full lg:w-1/2 hidden lg:block mr-20">
        <img src="../public/images/hero-image.png" alt="Hero Cake Image" class="w-full h-72 object-cover">
    </div>
</section>

    <!-- Studio Policies -->
    <section class="container mx-auto my-10 p-6" style="font-family: 'Roboto', sans-serif;">
        <!-- <h2 class="text-2xl font-bold text-center mb-6">Why Choose Us?</h2> -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="product-card policy-card p-4 rounded-lg text-center shadow-lg border-2">
                <i class="fas fa-leaf text-4xl text-green-500 mb-4"></i>
                <p class="text-lg font-semibold">100% Veg</p>
            </div>
            <div class="product-card policy-card p-4 rounded-lg text-center shadow-lg border-2">
                 <i class="fas fa-egg text-4xl text-yellow-500 mb-4"></i> 
                <p class="text-lg font-semibold">Eggless Cakes</p>
            </div>
            <div class="product-card policy-card p-4 rounded-lg text-center shadow-lg border-2">
                <i class="fas fa-apple-alt text-4xl text-red-500 mb-4"></i>
                <p class="text-lg font-semibold">Fresh Products</p>
            </div>
            <div class="product-card policy-card p-4 rounded-lg text-center shadow-lg border-2">
                <i class="fas fa-th-large text-4xl text-blue-500 mb-4"></i>
                <p class="text-lg font-semibold">Wide Variety</p>
            </div>
        </div>
    </section>

    <!-- Product Showcase Sections -->
    <section class="container mx-auto my-10 p-6 " id="productSection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Cake Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6    ">
            <?php foreach (getLimitedProducts($products, 'cake') as $product): ?>
                <div class="product-card bg-white rounded-lg shadow-lg p-4">
                    <a href="productDetail.php?id=<?php echo $product['id']; ?>">
                        <img src="../public/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4 w-full h-56 object-cover" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-800 mb-2 h-12"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-black font-bold mb-4 text-xl">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="button-color border-2 py-2 px-4 rounded-full block text-center">Buy Now</a>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-6">
        <a href="cakes.php" class="button-color border-2 py-3 px-6 rounded-full inline-block">Show More</a>
    </div>
    </section>

    <section class="container mx-auto my-10 p-6" id="brownieSection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Brownie Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach (getLimitedProducts($products, 'brownie') as $product): ?>
                <div class="product-card bg-white rounded-lg shadow-lg p-4">
                    <a href="productDetail.php?id=<?php echo $product['id']; ?>">
                        <img src="../public/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4 w-full h-56 object-cover" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-700 mb-2 h-12"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-black font-bold mb-4 text-xl">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="button-color border-2 py-2 px-4 rounded-full block text-center">Buy Now</a>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-6">
        <a href="brownies.php" class="button-color border-2 py-3 px-6 rounded-full inline-block">Show More</a>
    </div>
    </section>

    <section class="container mx-auto my-10 p-6" id="pastrySection">
        <h2 class="text-2xl font-bold text-center mb-6">Our Pastry Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach (getLimitedProducts($products, 'pastry') as $product): ?>
                <div class="product-card bg-white rounded-lg shadow-lg p-4">
                    <a href="productDetail.php?id=<?php echo $product['id']; ?>">
                        <img src="../public/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded mb-4 w-full h-56 object-cover" />
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-700 mb-2 h-12"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="text-black font-bold mb-4 text-xl">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" class="button-color border-2 py-2 px-4 rounded-full block text-center">Buy Now</a>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-6">
        <a href="pastries.php" class="button-color border-2 py-3 px-6 rounded-full inline-block">Show More</a>
    </div>
    </section>

    <!-- Footer -->
    <?php include '../partials/footer.php'; ?>

    <script src="../public/js/cart.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     const dropdownButton = document.querySelector('button.relative.z-10');
        //     const dropdownMenu = dropdownButton.nextElementSibling;

        //     dropdownButton.addEventListener('click', () => {
        //         dropdownMenu.classList.toggle('hidden');
        //     });

        //     document.addEventListener('click', (e) => {
        //         if (!dropdownButton.contains(e.target)) {
        //             dropdownMenu.classList.add('hidden');
        //         }
        //     });
        // });

        // Smooth scroll to products section
        document.getElementById('scrollToProducts').addEventListener('click', () => {
            document.querySelector('#productSection').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>