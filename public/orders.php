<?php
session_start();
include('../src/config/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../src/controller/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's orders with product details
$query = "
    SELECT 
        o.id AS order_id, 
        o.total_amount, 
        o.created_at, 
        p.name AS product_name, 
        p.image AS product_image, 
        oi.price AS product_price, 
        oi.quantity
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php
    include '../partials/header.php';
    ?>
    <h1>My Orders</h1>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Product Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $currentOrderId = null;
            $grandTotal = 0; // Initialize the grand total
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    // Check if we're on a new order
                    if ($currentOrderId !== $row['order_id']):
                        if ($currentOrderId !== null): ?>
                            <!-- Closing previous order total row -->
                            <tr>
                                <td colspan="6" style="text-align:right;"><strong>Order Total:</strong></td>
                                <td>$<?php echo number_format($totalAmount, 2); ?></td>
                            </tr>
                        <?php endif;

                        // Reset the total amount for the new order
                        $totalAmount = 0;
                        $currentOrderId = $row['order_id'];
                        ?>
                        <!-- Order ID and Date -->
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                            <td colspan="5"></td>
                        </tr>
                    <?php endif; ?>

                    <!-- Product Details -->
                    <tr>
                        <td></td> <!-- Empty cell for order ID -->
                        <td></td> <!-- Empty cell for order Date -->
                        <td><img src="images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>"></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo number_format($row['product_price'], 2); ?></td>
                        <td>$<?php echo number_format($row['product_price'] * $row['quantity'], 2); ?></td> <!-- Product total -->
                    </tr>

                <?php
                    // Calculate the total amount for the order
                    $totalAmount += $row['product_price'] * $row['quantity'];
                    // Add to grand total
                    // $grandTotal += $row['product_price'] * $row['quantity'];
                endwhile;
                ?>
                <!-- Display total for the last order -->
                <tr>
                    <td colspan="6" style="text-align:right;"><strong>Order Total:</strong></td>
                    <td>$<?php echo number_format($totalAmount, 2); ?></td>
                </tr>
                <!-- Grand Total Row -->
                <!-- <tr>
                    <td colspan="6" style="text-align:right;"><strong>Grand Total:</strong></td>
                    <td><strong>$<?php echo number_format($grandTotal, 2); ?></strong></td>
                </tr> -->
            <?php else: ?>
                <tr>
                    <td colspan="7">You have no orders.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>