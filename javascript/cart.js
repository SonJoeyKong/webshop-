function increaseQuantity(productId, price) {
    let quantitySpan = document.getElementById("quantity-" + productId);
    let quantity = parseInt(quantitySpan.textContent) + 1;
    quantitySpan.textContent = quantity;

    updateLocalStorage(productId, quantity, price);
}

function decreaseQuantity(productId, price) {
    let quantitySpan = document.getElementById("quantity-" + productId);
    let quantity = parseInt(quantitySpan.textContent);

    if (quantity > 0) {
        quantity--;
        quantitySpan.textContent = quantity;
        updateLocalStorage(productId, quantity, price);
    }
}

function updateLocalStorage(productId, quantity, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    if (quantity > 0) {
        cart[productId] = {
            quantity: quantity,
            price: price
        };
    } else {
        delete cart[productId];
    }

    localStorage.setItem('cart', JSON.stringify(cart));
}
