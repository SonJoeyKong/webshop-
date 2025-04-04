let cart = JSON.parse(localStorage.getItem("cart")) || [];
let cartItems = document.getElementById("cart-items");

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
}

function increaseQuantity(productName) {
    const quantitySpan = document.querySelector(`#quantity-${productName}`);
    let currentQuantity = parseInt(quantitySpan.textContent);
    quantitySpan.textContent = currentQuantity + 1;

    // Update quantity in localStorage
    const product = cart.find(item => item.name === productName);
    if (product) {
        product.quantity = (product.quantity || 1) + 1;
        localStorage.setItem("cart", JSON.stringify(cart));
    }
}

function decreaseQuantity(productName) {
    const quantitySpan = document.querySelector(`#quantity-${productName}`);
    let currentQuantity = parseInt(quantitySpan.textContent);
    if (currentQuantity > 0) {
        quantitySpan.textContent = currentQuantity - 1;

        // Update quantity in localStorage
        const product = cart.find(item => item.name === productName);
        if (product) {
            product.quantity = Math.max((product.quantity || 1) - 1, 0);
            localStorage.setItem("cart", JSON.stringify(cart));
        }
    }
}