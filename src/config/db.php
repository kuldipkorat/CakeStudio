<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cake_studio";

$conn = new mysqli($servername, $username, $password, $database,3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
