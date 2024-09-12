<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header('Location: ../public/dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Studio Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .logo-color {
            color: #53a8b6;
        }
        .input-border {
            border-color: gray;
        }

        .input-border:focus {
            border-color: #53a8b6;
            outline: none;
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
    <div>
        <a href="dashboard.php">
            <div class="flex justify-center items-center ">
                <img class="h-24" src="../public/images/logo.png" alt="">
                <h1 class="logo-color text-4xl font-bold mb-5 mt-12 text-center">Cake studio</h1>
            </div>
        </a>
    </div>
    <div class="container mx-auto max-w-md mt-10 p-5 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-5 text-center">Register Here</h2>
        <!-- Display Error Message -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-500 text-center">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']); // Clear the error after displaying it
                ?>
            </div>
        <?php endif; ?>
        <form id="registrationForm" action="../src/controller/register.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" autocomplete="off" id="name" name="name"
                    class="input-border w-full px-3 py-2 border rounded-full">
                <div id="nameError" class="text-red-500 text-sm mt-1"></div>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class=" input-border w-full px-3 py-2 border rounded-full">
                <div id="emailError" class="text-red-500 text-sm mt-1"></div>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="input-border w-full px-3 py-2 border rounded-full">
                <div id="passwordError" class="text-red-500 text-sm mt-1"></div>
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password"
                    class="input-border w-full px-3 py-2 border rounded-full">
                <div id="confirmPasswordError" class="text-red-500 text-sm mt-1"></div>
            </div>
            <button type="submit"
                class="mt-12 button-color w-full border-2 py-2 px-4 rounded-full block text-center">Register</button>
        </form>
        <p class="text-center mt-4">Already have an account? <a href="login.php"
                class="text-indigo-500 hover:underline">Login here</a></p>
    </div>
    <script src="../public//js/validate.js"></script>
</body>

</html>