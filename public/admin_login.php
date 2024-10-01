<?php
session_start();
require '../src/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch admin from the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if admin exists and password matches
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header('Location: ../public/admin_dashboard.php');
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        <div class="flex justify-center items-center mt-12">
            <img class="h-24" src="../public/images/logo.png" alt="Admin Logo">
            <h1 class="logo-color text-4xl font-bold text-center">Admin Portal</h1>
        </div>
    </div>

    <div class="container mx-auto max-w-md mt-10 p-5 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-5 text-center">Admin Login</h2>

        <!-- Button Group for User/Admin Login -->
        <div class="button-group">
            <a href="login.php" class="button-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active-button' : ''; ?>">User Login</a>
            <a href="admin_login.php" class="button-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin_login.php' ? 'active-button' : ''; ?>">Admin Login</a>
        </div>

        <!-- Error Message Display -->
        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-500 text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" autocomplete="off" required
                    class="input-border w-full px-3 py-2 border rounded-full">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="input-border w-full px-3 py-2 border rounded-full">
            </div>
            <button type="submit" class="mt-12 button-color w-full border-2 py-2 px-4 rounded-full block text-center">Login</button>
        </form>
    </div>
</body>

</html>
