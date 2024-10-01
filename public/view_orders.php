<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require '../src/config/db.php';

// Fetch orders and order items
$query = "
    SELECT o.id AS order_id, o.total_amount, o.created_at, u.name AS customer_name, 
           p.name AS product_name, p.image, oi.quantity, oi.price, a.city
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_items oi ON oi.order_id = o.id
    JOIN products p ON oi.product_id = p.id
    JOIN addresses a ON o.address_id = a.id
    ORDER BY o.created_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 50px;
            height: auto;
        }

        .order-total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>

    <section class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-4">All Orders</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>City</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Product Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentOrderId = null;
                $totalAmount = 0; // Initialize the total for each order

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        // Check if we're on a new order
                        if ($currentOrderId !== $row['order_id']):
                            // If we're moving to a new order, display the total for the previous order
                            if ($currentOrderId !== null): ?>
                                <tr class="order-total-row">
                                    <td colspan="7" style="text-align:right;">Order Total:</td>
                                    <td>$<?php echo number_format($totalAmount, 2); ?></td>
                                </tr>
                            <?php
                            endif;

                            // Reset the total amount for the new order
                            $totalAmount = 0;
                            $currentOrderId = $row['order_id'];
                            ?>
                            <!-- Display new order ID and customer details -->
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td colspan="4"></td>
                            </tr>
                        <?php endif; ?>

                        <!-- Display product details within the same order -->
                        <tr>
                            <td></td> <!-- Empty cell for order ID -->
                            <td></td> <!-- Empty cell for order date -->
                            <td></td> <!-- Empty cell for customer -->
                            <td></td> <!-- Empty cell for city -->
                            <td>
                                <img src="../public/images/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                <?php echo $row['product_name']; ?>
                            </td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                        </tr>

                    <?php
                    // Add the product's total price to the order total
                    $totalAmount += $row['price'] * $row['quantity'];

                    endwhile;
                    ?>

                    <!-- Display total for the last order -->
                    <tr class="order-total-row">
                        <td colspan="7" style="text-align:right;">Order Total:</td>
                        <td>$<?php echo number_format($totalAmount, 2); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

</body>
</html>
