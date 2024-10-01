<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .logo-text {
            color: #53a8b6;
        }
    </style>
</head>
<header class="text-black p-4 z-20 relative" style="font-family: 'Roboto', sans-serif;">
    <div class="container mx-auto flex justify-between items-center ">
        <a href="admin_dashboard.php">
            <div class="flex justify-center items-center ">
                <img src="../public/images/logo.png" alt="Cake Studio Logo" class="h-12 mr-3">
                <h1 class="text-3xl font-bold logo-text">Admin Panel</h1>
            </div>
        </a>
        <nav class="flex items-center">
            <!-- Add Product -->
            <a href="../public/add_product.php" class="hover-color text-black px-3">Add Product</a>

            <!-- View Orders -->
            <a href="../public/view_orders.php" class="hover-color text-black px-3">View Orders</a>

            <!-- Admin Logout -->
            <?php if (isset($_SESSION['admin_id'])): ?>
                <a href="../public/admin_logout.php" class="button border-2 border-black text-black bg-blue-100 rounded-full px-4 py-2">Logout</a>
            <?php else: ?>
                <a href="../public/admin_login.php" class="button border-2 border-black text-black bg-blue-100 rounded-full px-4 py-2">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<style>
    .hover-color:hover {
        color: #53a8b6;
    }

    .button {
        background-color: white;
        color: black;
        border-color: #53a8b6;
    }

    .button:hover {
        background-color: #53a8b6;
        border-color: white;
        color: white;
    }
</style>
