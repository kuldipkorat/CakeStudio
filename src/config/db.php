<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "cake_studio";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
