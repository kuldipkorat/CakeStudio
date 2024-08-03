function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.length; // Count the number of distinct products
    document.getElementById('cartCount').textContent = cartCount;
}

document.addEventListener('DOMContentLoaded', updateCartCount);
