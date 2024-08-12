<?php
session_start();
include 'header.php';
?>

<section class="container mx-auto my-10 p-6">
    <h2 class="text-2xl font-bold text-center mb-6">Our Brownie Products</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="brownieCards">
        <!-- Brownie product cards will be inserted here by JavaScript -->
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="../public/js/ product.js.php"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const brownieCards = document.getElementById('brownieCards');

        products.forEach(product => {
            if (product.category === 'brownie') {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card', 'bg-white', 'rounded-lg', 'shadow-lg', 'p-4');
                productCard.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" class="rounded mb-4" />
                    <h3 class="text-xl font-semibold mb-2">${product.name}</h3>
                    <p class="text-gray-700 mb-2">${product.description}</p>
                    <p class="text-indigo-500 font-bold mb-4">$${product.price.toFixed(2)}</p>
                    <a href="productDetail.php?id=${product.id}" class="bg-indigo-500 text-white py-2 px-4 rounded block text-center">Buy Now</a>
                `;
                brownieCards.appendChild(productCard);
            }
        });
    });
</script>
