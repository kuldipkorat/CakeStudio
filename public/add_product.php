<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require '../src/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form inputs
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];  
    $quantity = $_POST['quantity'];

    // Handle image upload
    $image = NULL;
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../public/images/";
        $target_file = $target_dir . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Sorry, there was an error uploading the file.";
            header('Location: add_product.php');
            exit;
        }
    }

    // Insert product into the database
    $sql = "INSERT INTO products (name, description, price, image, category, quantity) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssdssi', $name, $description, $price, $image, $category, $quantity);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Product added successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }

    header('Location: add_product.php');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Cake Studio Admin</title>
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

        .submit-button {
            background-color: #53a8b6;
            color: white;
        }

        .submit-button:hover {
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>

    <section class="bg-white py-10">
        <div class="container mx-auto px-4">

            <!-- Page Title -->
            <h2 class="text-color text-4xl font-bold mb-4">Add New Product</h2>
            <p class="text-lg text-gray-700 mb-6">
                Use the form below to add a new product to the Cake Studio store.
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

            <!-- Add Product Form -->
            <form action="add_product.php" method="POST" enctype="multipart/form-data" class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">Product Name</label>
                    <input type="text" id="name" name="name" class="input-border rounded-full w-full p-3 border" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-lg font-semibold text-gray-700 mb-2">Product Description</label>
                    <textarea id="description" name="description" rows="6" class="input-border rounded-lg w-full p-3 border" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-lg font-semibold text-gray-700 mb-2">Price</label>
                    <input type="number" step="0.01" id="price" name="price" class="input-border rounded-full w-full p-3 border" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-lg font-semibold text-gray-700 mb-2">Category</label>
                    <select id="category" name="category" class="input-border rounded-full w-full p-3 border" required>
                        <option value="cake">Cake</option>
                        <option value="pastry">Pastry</option>
                        <option value="brownie">Brownie</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-lg font-semibold text-gray-700 mb-2">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="input-border rounded-full w-full p-3 border" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Product Image</label>
                    <input type="file" id="image" name="image" class="input-border rounded-lg w-full p-3 border" accept="image/*">
                </div>
                <button type="submit" class="submit-button text-white px-4 py-2 rounded border">Add Product</button>
            </form>
        </div>
    </section>

</body>
</html>
