function updateProductSize(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const selectedSize = selectedOption.getAttribute('data-size');

    document.getElementById('product_size_input').value = selectedSize;
}

function increaseQuantity(productId, maxStock) {
    var input = document.getElementById('quantity-input-' + productId);
    var currentValue = parseInt(input.value) || 1;

    if (currentValue < maxStock) {
        input.value = currentValue + 1;
    } else {
        input.value = maxStock; // Kalau lebih, kunci ke max
    }
}

function decreaseQuantity(productId) {
    var input = document.getElementById('quantity-input-' + productId);
    var currentValue = parseInt(input.value) || 1;

    if (currentValue > 1) {
        input.value = currentValue - 1;
    } else {
        input.value = 1; // Tidak boleh kurang dari 1
    }
}
