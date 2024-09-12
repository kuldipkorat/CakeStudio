<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .dropdown:hover {
            background-color: #53a8b6;
        }
        .logo-text {
            color: #53a8b6;
        }
    </style>
</head>
<header class="text-black p-4 z-20 relative" style="font-family: 'Roboto', sans-serif;">
    <div class="container mx-auto flex justify-between items-center ">
        <a href="../public/dashboard.php">
            <div class="flex justify-center items-center ">
            <img src="../public/images/logo.png" alt="Cake Studio Logo" class="h-12 mr-3">
            <h1 class="text-3xl font-bold logo-text">Cake Studio</h1>
            </div>
        </a>
        <nav class="flex items-center">
            <!-- Shopping Cart -->
            <a href="cart.php" class="relative text-black px-3 space-x-11 -left-4">
                <i class="fa fa-shopping-cart text-2xl  space-x-3 -left-3"></i>
                <span id="cartCount" class="absolute -top-1 -right-2 -left-3 bg-red-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center space-x-3">
                    <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
                </span>
            </a>
            <!-- Categories Dropdown -->
            <div class="relative">
                <button id="dropdownButton" class="relative z-10 block text-black focus:outline-none px-3 py-2 rounded -left-1 ">
                    Categories <i class="fa fa-caret-down"></i>
                </button>
                <div id="dropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl py-2 hidden border-black">
                    <a href="cakes.php" class="block px-4 py-2 text-gray-800 dropdown hover:text-white">Cakes</a>
                    <a href="brownies.php" class="block px-4 py-2 text-gray-800 dropdown hover:text-white">Brownies</a>
                    <a href="pastries.php" class="block px-4 py-2 text-gray-800 dropdown hover:text-white">Pastries</a>
                </div>
            </div>

            <!-- New Links for About Us and Contact Us -->
            <a href="about.php" class="hover-color text-black  px-3 ">About Us</a>
            <a href="contact.php" class="hover-color text-black  px-3 ">Contact Us</a>

            <!-- User Login/Logout -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../src/controller/logout.php" class="button border-2 border-black text-black bg-blue-100 rounded-full px-4 py-2">Logout</a>
            <?php else: ?>
                <a href="login.php" class="button border-2 border-black text-black bg-blue-100 rounded-full px-4 py-2">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent the click from propagating to the document
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
<style>
    .hover-color:hover {
        color: #53a8b6;
    }

    .button {
        background-color: white;
        color: black;
        border-color: #53a8b6;
    }

    .button:hover {
        background-color: #53a8b6;
        border-color: white;
        color: white;
    }
</style>