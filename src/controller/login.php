<?php
session_start();
include '../config/db.php';

if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect to the dashboard
    header('Location: ../dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo 'Please fill out all fields.';
    } else {
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
                header('Location: ../dashboard.php');
                exit();
            } else {
                echo 'Invalid email or password.';
            }
        } else {
            echo 'No user found with this email.';
        }

        $stmt->close();
    }
    $conn->close();
}
?>
