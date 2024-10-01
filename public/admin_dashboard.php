<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../public/admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
    <style>
        .container {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>
            <h1 class="container mx-auto text-3xl font-bold text-center w-full mt-44">Welcome, <?php echo $_SESSION['admin_name']; ?></h1>
    <!-- <ul>
        <li><a href="../public/add_product.php">Add Product</a></li>
        <li><a href="../public/view_orders.php">View Orders</a></li>
        <li><a href="../public/admin_logout.php">Logout</a></li>
    </ul> -->
</body>

</html>