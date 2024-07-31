<?php
session_start();
include '../config/db.php';

if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect to the dashboard
    header('Location: ../../public/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill out all fields.';
        header('Location: ../../public/login.php');
        exit();
    } 
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                
                // Redirect to the dashboard
                header('Location: ../../public/dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Invalid email or password.';
            }
        } else {
            $_SESSION['error'] = 'No user found with this email.';
        }

        $stmt->close();
        $conn->close();

    // Redirect back to the login page with error
    header('Location: ../../public/login.php');
    exit();
}
?>
