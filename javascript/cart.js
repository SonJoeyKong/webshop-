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

function deleteProduct(productId) {
    console.log("Deleting product with ID:", productId);

    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    if (cart[productId]) {
        delete cart[productId];
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
    }

    let productElement = document.getElementById("product-" + productId);
    if (productElement) {
        productElement.remove();
        location.reload();
    }
}

function updateLocalStorage(productId, quantity, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    const imageElement = document.querySelector(`img[alt='${productId}']`);
    const image = imageElement ? imageElement.getAttribute('src').split('/').pop() : '';

    if (quantity > 0) {
        cart[productId] = {
            quantity: quantity,
            price: price,
            image: image,
            name: productId
        };
    } else {
        delete cart[productId];
    }

    localStorage.setItem('cart', JSON.stringify(cart));
}
