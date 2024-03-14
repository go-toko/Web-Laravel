@section('forscript')
    <script>
        // Inisialisasi cart
        let cart = [];

        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', addToCart);
        });

        function addToCart(event) {
            const productId = event.currentTarget.dataset.id;
            const productName = event.currentTarget.dataset.name;
            const productImage = event.currentTarget.dataset.image;
            const productQuantity = event.currentTarget.dataset.quantity;
            const productPrice = parseFloat(event.currentTarget.dataset.price);

            const existingProduct = cart.find(item => item.id === productId);

            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                const newProduct = {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    productQuantity,
                    quantity: 1
                };
                cart.push(newProduct);
            }

            renderCart();
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);

            renderCart();
        }

        function removeAllCart(){
            cart = [];

            renderCart();
        }

        function calculateCartTotal() {
            let totalItems = 0;
            let tax = 0;
            let totalPrice = 0;

            for (const product of cart) {
                totalItems += product.quantity;
                tax += product.price * product.quantity * 0.1;
                totalPrice += product.price * product.quantity + tax;
            }

            return {
                totalItems,
                tax,
                totalPrice
            };
        }


        function renderCart() {
            const cartContainer = document.querySelector('.product-table');
            cartContainer.innerHTML = '';

            for (const product of cart) {
                const liCart = document.createElement('li');
                liCart.innerHTML = `
                    <div class="productimg">
                        <div class="productimgs">
                        <img src="${product.image}" alt="img">
                        </div>
                        <div class="productcontet">
                        <h4>${product.name}</h4>
                        <div class="productlinkset">
                            <h5>${product.id}</h5>
                        </div>
                        <div class="increment-decrement">
                            <div class="input-groups">
                            <input type="button" value="-" class="button-minus dec button" data-id="${product.id}">
                            <input type="text" name="child" value="${product.quantity}" class="quantity-field">
                            <input type="button" value="+" class="button-plus inc button" data-id="${product.id}">
                            </div>
                        </div>
                        </div>
                    </div>
                `;

                const liPrice = document.createElement('li');
                liPrice.innerHTML = `
                    <li>${product.price}</li>
                `;

                const deleteButton = document.createElement('a');
                deleteButton.href = 'javascript:void(0);';
                deleteButton.classList.add('confirm-text');
                deleteButton.innerHTML = '<img src="{{ URL::asset('/assets/img/icons/delete-2.svg') }}" alt="img">';
                deleteButton.addEventListener('click', () => removeFromCart(product.id));

                const listItem = document.createElement('ul');
                listItem.classList.add('product-lists')
                listItem.appendChild(liCart);
                listItem.appendChild(liPrice);
                listItem.appendChild(deleteButton);
                cartContainer.appendChild(listItem);
            }

            const {
                totalItems,
                tax,
                totalPrice
            } = calculateCartTotal();

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('subtotal').textContent = totalPrice.toFixed(2);
            document.getElementById('total').textContent = totalPrice.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('checkout').textContent = totalPrice.toFixed(2);

            const incrementButtons = document.querySelectorAll('.button-plus');
            const decrementButtons = document.querySelectorAll('.button-minus');
            const quantityInputs = document.querySelectorAll('.quantity-field');

            incrementButtons.forEach(button => {
                button.addEventListener('click', increaseQuantity);
            });

            decrementButtons.forEach(button => {
                button.addEventListener('click', decreaseQuantity);
            });

            quantityInputs.forEach(input => {
                input.addEventListener('change', changeQuantity);
            });
        }

        function increaseQuantity(event) {
            const productId = event.target.getAttribute('data-id');
            const quantityInput = event.target.parentNode.querySelector('.quantity-field');
            let quantity = parseInt(quantityInput.value);
            quantity += 1;
            quantityInput.value = quantity;

            updateCartQuantity(productId, quantity);
        }

        function decreaseQuantity(event) {
            const productId = event.target.getAttribute('data-id');
            const quantityInput = event.target.parentNode.querySelector('.quantity-field');
            let quantity = parseInt(quantityInput.value);
            if (quantity > 0) {
                quantity -= 1;
                quantityInput.value = quantity;

                updateCartQuantity(productId, quantity);
            }
        }

        function changeQuantity(event) {
            const productId = event.target.getAttribute('data-id');
            const quantityInput = event.target;
            let quantity = parseInt(quantityInput.value);
            if (quantity >= 0) {
                updateCartQuantity(productId, quantity);
            }
        }

        function updateCartQuantity(productId, quantity) {
            const product = cart.find(item => item.id === productId);
            if (product) {
                product.quantity = quantity;

                renderCart();
            }
        }

        function sendData() {
            $.ajax({
                url: "{{ route('owner.sales.pos.store') }}",
                method: 'POST',
                data: JSON.stringify(cart),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 0) {
                        // enable button
                        submit.disabled = false;

                        // remove thing that has been added in html
                        var buttonText = submit.innerText.slice(0, -3);
                        submit.innerText = buttonText;
                        spinSpan.remove();

                        // add warning to html
                        $.each(data.error, function(prefix, val) {
                            var inputElem = $('input[name="' + prefix + '"]');
                            inputElem.addClass('is-invalid');
                            inputElem.next('.invalid-feedback').text(val[0]);
                        });
                        toastr.error(data.msg, 'Error')
                    } else {

                        toastr.success(data.msg, 'Success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000)
                    }
                }
            });
        }

        renderCart();
    </script>

    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    <!-- Wizard JS -->
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
@endsection
