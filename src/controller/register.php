<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || $password !== $confirm_password) {
        echo 'Please fill out all fields and make sure passwords match.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo 'Registration successful!';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();
}
?>
