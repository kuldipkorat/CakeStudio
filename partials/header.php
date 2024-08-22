<header class="bg-indigo-600 text-white p-4 shadow-md z-20 relative">
    <div class="container mx-auto flex justify-between items-center">
        <a href="../public/dashboard.php">
            <h1 class="text-3xl font-bold">Cake Studio</h1>
        </a>
        <nav class="flex items-center">
            <!-- Shopping Cart -->
            <a href="cart.php" class="relative text-white hover:text-indigo-200 px-3">
                <i class="fa fa-shopping-cart text-2xl"></i>
                <span id="cartCount" class="absolute -top-1 -right-2 bg-red-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                    <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
                </span>
            </a>
            
            <!-- Categories Dropdown -->
            <div class="relative">
                <button id="dropdownButton" class="relative z-10 block bg-indigo-500 text-white focus:outline-none px-3 py-2 rounded">
                    Categories <i class="fa fa-caret-down"></i>
                </button>
                <div id="dropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden">
                    <a href="cakes.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Cakes</a>
                    <a href="brownies.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Brownies</a>
                    <a href="pastries.php" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Pastries</a>
                </div>
            </div>

            <!-- New Links for About Us and Contact Us -->
            <a href="about.php" class="text-white hover:text-indigo-200 px-3">About Us</a>
            <a href="contact.php" class="text-white hover:text-indigo-200 px-3">Contact Us</a>

            <!-- User Login/Logout -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../src/controller/logout.php" class="text-white hover:text-indigo-200 px-3">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-white hover:text-indigo-200 px-3">Login</a>
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
