document.addEventListener('DOMContentLoaded', function () {
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');

    addToCartForms.forEach(form => {
        form.querySelector('.add-to-cart').addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const formData = new FormData(form);

            fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart successfully!');
                    // Optionally, update cart count dynamically here
                } else {
                    alert('Product already in cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
