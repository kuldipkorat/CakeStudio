<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || $password !== $confirm_password) {
        $_SESSION['error'] = 'Please fill out all fields and make sure passwords match.';
        header('Location: ../../public/register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $stmt->execute();
        $_SESSION['success'] = 'Registration successful! Please log in.';
        header('Location: ../../public/login.php');
    } catch (mysqli_sql_exception $e) {
        // Error code for duplicate entry is 1062
        if ($e->getCode() == 1062) {
            $_SESSION['error'] = 'This email address is already registered. Please use a different email.';
        } else {
            $_SESSION['error'] = 'An error occurred. Please try again later.';
        }
        header('Location: ../../public/register.php');
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
