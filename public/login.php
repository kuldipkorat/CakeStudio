<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // If logged in, redirect to the dashboard
    header('login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Studio Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .logo-color {
            color: #53a8b6;
        }

        .button-color {
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }

        .button-color:hover {
            background-color: #53a8b6;
            border-color: white;
            color: white;
        }

        .input-border {
            border-color: gray;
        }

        .input-border:focus {
            border-color: #53a8b6;
            outline: none;
        }

        .button-group {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .button-link {
            width: 45%;
            text-align: center;
            padding: 10px;
            border-radius: 9999px;
            font-weight: bold;
            border: 2px solid #53a8b6;
        }

        .button-link:hover {
            background-color: #53a8b6;
            color: white;
        }

        .active-button {
            background-color: #53a8b6;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div>
        <a href="dashboard.php">
            <div class="flex justify-center items-center ">
                <img class="h-24" src="../public/images/logo.png" alt="">
                <h1 class="logo-color text-4xl font-bold mb-5 mt-12 text-center">Cake Studio</h1>
            </div>
        </a>
    </div>

    <div class="container mx-auto max-w-md mt-10 p-5 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-5 text-center">User Login</h2>

        <!-- Button Group for User/Admin Login -->
        <div class="button-group">
            <a href="login.php" class="button-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active-button' : ''; ?>">User Login</a>
            <a href="admin_login.php" class="button-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin_login.php' ? 'active-button' : ''; ?>">Admin Login</a>
        </div>

        <!-- Error Message Display -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-500 text-center">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']); // Clear error after displaying
                ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" action="../src/controller/login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" autocomplete="off" class="input-border w-full px-3 py-2 border rounded-full ">
                <div id="emailError" class="text-red-500 text-sm"></div>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="input-border w-full px-3 py-2 border rounded-full">
                <div id="passwordError" class="text-red-500 text-sm"></div>
            </div>
            <button type="submit" class="mt-12 button-color w-full border-2 py-2 px-4 rounded-full block text-center">Login</button>
        </form>

        <div class="mt-4 text-center">
            <a href="register.php" class="text-indigo-500 hover:underline">Don't have an account? Register here</a>
        </div>
    </div>

    <script src="../public/js/validateLogin.js"></script>
</body>

</html>
