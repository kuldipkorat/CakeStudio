<?php
// Include your database connection
include('../src/config/db.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Output the products as a JavaScript array
echo "const products = [";
while($row = $result->fetch_assoc()) {
    echo "{";
    echo "id: " . $row['id'] . ",";
    echo "name: '" . $row['name'] . "',";
    echo "description: '" . $row['description'] . "',";
    echo "price: " . $row['price'] . ",";
    echo "image: '" . $row['image'] . "',";
    echo "category: '" . $row['category'] . "',";
    echo "quantity: " . $row['quantity'];
    echo "},";
}
echo "];";
?>
