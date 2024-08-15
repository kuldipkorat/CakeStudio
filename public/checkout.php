<?php
session_start();
require_once '../src/config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$addresses = [];

// Fetch existing addresses from the database
$stmt = $conn->prepare("SELECT id, name, mobile, house_no, address_line1, city, state, pin_code FROM addresses WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $addresses[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $house_no = $_POST['house_no'];
    $address_line1 = $_POST['address_line1'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin_code = $_POST['pin_code'];

    // Validate the input data
    if ($name && $mobile && $house_no && $address_line1 && $city && $state && $pin_code) {
        // Insert the new address into the database
        $stmt = $conn->prepare("INSERT INTO addresses (user_id, name, mobile, house_no, address_line1, city, state, pin_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $userId, $name, $mobile, $house_no, $address_line1, $city, $state, $pin_code);
        $stmt->execute();
        
        // Redirect to order confirmation page or process the order further
        header("Location: order_confirmation.php"); // Redirect to an order confirmation page
        exit;
    } else {
        $error = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cake Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const mobile = document.getElementById('mobile').value.trim();
            const house_no = document.getElementById('house_no').value.trim();
            const address_line1 = document.getElementById('address_line1').value.trim();
            const city = document.getElementById('city').value.trim();
            const state = document.getElementById('state').value.trim();
            const pin_code = document.getElementById('pin_code').value.trim();
            let valid = true;

            // Simple validation
            if (!name || !mobile || !house_no || !address_line1 || !city || !state || !pin_code) {
                alert('Please fill in all the required fields.');
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container mx-auto my-10 p-6">
        <h2 class="text-3xl text-center underline font-bold mb-6">Checkout</h2>

        <?php if (!empty($addresses)): ?>
            <h3 class="text-2xl font-bold mb-4">Select an Existing Address</h3>
            <ul>
                <?php foreach ($addresses as $address): ?>
                    <li class="border p-4 mb-4">
                        <p><strong><?php echo htmlspecialchars($address['name']); ?></strong></p>
                        <p><?php echo htmlspecialchars($address['mobile']); ?></p>
                        <p><?php echo htmlspecialchars($address['house_no']); ?>, <?php echo htmlspecialchars($address['address_line1']); ?></p>
                        <p><?php echo htmlspecialchars($address['city']); ?>, <?php echo htmlspecialchars($address['state']); ?> - <?php echo htmlspecialchars($address['pin_code']); ?></p>
                        <form action="order_confirmation.php" method="POST">
                            <input type="hidden" name="address_id" value="<?php echo $address['id']; ?>">
                            <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded mt-2">Deliver to this Address</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr class="my-6">
        <?php endif; ?>

        <h3 class="text-2xl font-bold mb-4">Add a New Address</h3>

        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="mobile" class="block text-gray-700">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="house_no" class="block text-gray-700">House No</label>
                <input type="text" id="house_no" name="house_no" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="address_line1" class="block text-gray-700">Address Line 1</label>
                <input type="text" id="address_line1" name="address_line1" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700">City</label>
                <input type="text" id="city" name="city" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700">State</label>
                <input type="text" id="state" name="state" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="pin_code" class="block text-gray-700">Pin Code</label>
                <input type="text" id="pin_code" name="pin_code" class="w-full border px-3 py-2" required>
            </div>
            <div class="mb-6">
                <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded">Place Order</button>
            </div>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
