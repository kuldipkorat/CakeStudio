const products = [
  {
    id: 1,
    name: "Chocolate Cake",
    description: "Delicious chocolate cake.",
    price: 25.0,
    image: "",
    category: "cake",
    quantity:100
  },
  {
    id: 2,
    name: "Vanilla Cake",
    description: "Tasty vanilla cake.",
    price: 20.0,
    image: "",
    category: "cake",
    quantity:100
  },
  {
    id: 3,
    name: "Classic Brownie",
    description: "Rich chocolate brownie.",
    price: 15.0,
    image: "",
    category: "brownie",
    quantity:100

  },
  {
    id: 4,
    name: "Walnut Brownie",
    description: "Brownie with walnuts.",
    price: 18.0,
    image: "",
    category: "brownie",
    quantity:100

  },
  {
    id: 5,
    name: "Strawberry Pastry",
    description: "Fresh strawberry pastry.",
    price: 12.0,
    image: "",
    category: "pastry",
    quantity:100

  },
  {
    id: 6,
    name: "Chocolate Pastry",
    description: "Delicious chocolate pastry.",
    price: 14.0,
    image: "",
    category: "pastry",
    quantity:100

  },
  // Add more products as needed
];
// Function to get URL parameters
function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  const results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Function to add product to cart
function addToCart(productId) {
  const product = products.find(p => p.id == productId);
  if (!product) {
      alert('Product not found');
      return;
  }

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../src/controller/add_to_cart.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
      if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
              alert('Product added to cart successfully!');
              document.getElementById('cartCount').innerText = response.cartCount;
          } else {
              alert(response.message);
          }
      }
  };
  const data = `product_id=${product.id}&name=${encodeURIComponent(product.name)}&price=${product.price}&quantity=1`;
  xhr.send(data);
}

// On document ready, load the product details
document.addEventListener('DOMContentLoaded', () => {
  const productId = getUrlParameter('id');
  const product = products.find(p => p.id == productId);

  if (product) {
      document.getElementById('productDetail').innerHTML = `
          <div class="md:w-1/2 p-4">
              <img src="${product.image}" alt="${product.name}" class="w-full h-auto max-w-md mx-auto rounded mb-4">
          </div>
          <div class="md:w-1/2 p-4">
              <h2 class="text-3xl font-bold mb-4">${product.name}</h2>
              <p class="text-gray-700 mb-4">${product.description}</p>
              <p class="text-indigo-500 text-2xl font-bold mb-6">$${product.price.toFixed(2)}</p>
              <button class="bg-indigo-500 text-white py-2 px-4 rounded" onclick="addToCart(${product.id})">Add to Cart</button>
          </div>
      `;
  } else {
      document.getElementById('productDetail').innerHTML = `
          <p class="text-red-500 text-lg">Product not found.</p>
      `;
  }
});