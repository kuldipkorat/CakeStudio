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

$errors = []; // Array to hold error messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $house_no = trim($_POST['house_no']);
    $address_line1 = trim($_POST['address_line1']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $pin_code = trim($_POST['pin_code']);

    // Validate the input data
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }
    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors['mobile'] = "Mobile number must be 10 digits.";
    }
    if (empty($house_no)) {
        $errors['house_no'] = "House number is required.";
    }
    if (empty($address_line1)) {
        $errors['address_line1'] = "Address line 1 is required.";
    }
    if (empty($city)) {
        $errors['city'] = "City is required.";
    }
    if (empty($state)) {
        $errors['state'] = "State is required.";
    }
    if (empty($pin_code)) {
        $errors['pin_code'] = "Pin code is required.";
    } elseif (!preg_match('/^[0-9]{6}$/', $pin_code)) {
        $errors['pin_code'] = "Pin code must be 6 digits.";
    }

    // If no errors, insert the new address into the database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO addresses (user_id, name, mobile, house_no, address_line1, city, state, pin_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $userId, $name, $mobile, $house_no, $address_line1, $city, $state, $pin_code);
        $stmt->execute();

        // Redirect to order confirmation page
        header("Location: order_confirmation.php");
        exit;
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
    <style>
        .container {
            max-width: 1200px;
        }
        .input-border {
            border-color: gray;
        }

        .input-border:focus {
            border-color: #53a8b6;
            outline: none;
        }

        .home-button {
            background-color: #53a8b6;
            border-color: white;
            color: white;
        }

        .home-button:hover {
            background-color: white;
            color: black;
            border-color: #53a8b6;
        }
    </style>
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="container mx-auto my-10 p-6">
        <!-- <h2 class="text-3xl text-center underline font-bold mb-6">Checkout</h2> -->

        <!-- Display error messages -->
        <!-- <?php if (!empty($errors)): ?>
            <div class="mb-6">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?> -->

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
                            <button type="submit" class="home-button text-white py-2 px-4 border rounded mt-2">Deliver to this Address</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr class="my-6">
        <?php endif; ?>

        <h3 class="text-2xl font-bold mb-4">Add a New Address</h3>

        <form action="" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="input-border w-full border rounded-full px-3 py-2 <?php echo isset($errors['name']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($name ?? ''); ?>">
                <?php if (isset($errors['name'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['name']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="mobile" class="block text-gray-700">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['mobile']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($mobile ?? ''); ?>">
                <?php if (isset($errors['mobile'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['mobile']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="house_no" class="block text-gray-700">House No</label>
                <input type="text" id="house_no" name="house_no" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['house_no']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($house_no ?? ''); ?>">
                <?php if (isset($errors['house_no'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['house_no']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="address_line1" class="block text-gray-700">Address Line 1</label>
                <input type="text" id="address_line1" name="address_line1" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['address_line1']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($address_line1 ?? ''); ?>">
                <?php if (isset($errors['address_line1'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['address_line1']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700">City</label>
                <input type="text" id="city" name="city" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['city']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($city ?? ''); ?>">
                <?php if (isset($errors['city'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['city']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700">State</label>
                <input type="text" id="state" name="state" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['state']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($state ?? ''); ?>">
                <?php if (isset($errors['state'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['state']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="pin_code" class="block text-gray-700">Pin Code</label>
                <input type="text" id="pin_code" name="pin_code" class="input-border rounded-full w-full border px-3 py-2 <?php echo isset($errors['pin_code']) ? 'border-red-500' : ''; ?>" value="<?php echo htmlspecialchars($pin_code ?? ''); ?>">
                <?php if (isset($errors['pin_code'])): ?>
                    <p class="text-red-500 text-sm"><?php echo $errors['pin_code']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <button type="submit" class="home-button border text-white py-2 px-4 rounded">Add Address</button>
            </div>
        </form> 
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>