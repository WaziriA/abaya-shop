


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sadah Abaya - Online Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Bootstrap Ecommerce Template" name="keywords">
    <meta content="Bootstrap Ecommerce Template Free Download" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('material/img/logo.jpg') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nabi&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('new/lib/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('new/lib/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('new/css/style.css') }} " rel="stylesheet">

    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Container for the product grid */
        .product-container {
            padding: 20px;
            display: grid;
            gap: 16px;
        }

        /* Responsive grid layout */
        @media (max-width: 576px) {

            /* Small devices like mobile */
            .product-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 577px) and (max-width: 768px) {

            /* Tablets */
            .product-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 769px) {

            /* Large devices like desktops */
            .product-container {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Product card styling */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.03);
        }

        /* Product image styling */
        .product-card img {
            width: 100%;
            height: auto;
        }

        /* Product details */
        .product-details {
            padding: 10px;
        }

        .product-price {
            font-weight: bold;
            color: #e60000;
            margin-top: 5px;
        }

        .product-orders {
            color: #555;
            font-size: 0.9em;
        }

        .product-rating {
            color: #f39c12;
            font-size: 0.9em;
            margin-top: 5px;
        }

        /* Badge styling */
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: green;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8em;
            z-index: 2;
        }

        /* Add to Wishlist icon */
        /* Wishlist icon styling */
        .wishlist-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2em;
            cursor: pointer;
            z-index: 2;
            color: #333;
        }

        .wishlist-icon:hover {
            color: #e60000;
        }

        .spinner {
            display: inline-block;
            margin-left: 5px;
            font-size: 0.9em;
            color: #000;
            /* Adjust color to match your theme */
        }

        .wishlist-button {
            position: relative;
            color: #ff4d4f;
            cursor: pointer;
            text-decoration: none;
        }

        .wishlist-button .spinner,
        .wishlist-button .loading-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
            color: #ff4d4f;
        }

        .wishlist-button .spinner {
            font-size: 1rem;
        }

        .variant-image {
            width: 100px;
            height: 150px;
        }

        /* Responsive grid layout */
        @media (max-width: 576px) {

            .variant-image {
                width: 350px;
                height: 280px;
            }

        }

        /* Responsive grid layout */
        @media (max-width: 769px) {

            .variant-image {
                width: 250px;
                height: 180px;
            }
        }

        .filled {
            color: #f39c12;
            /* Gold color for filled stars */
        }

        .fa-star-o {
            color: #d3d3d3;
            /* Gray color for empty stars */
        }
    </style>

</head>

<body>

    @include('store.components.header')
    @include('store.components.menu')
    @yield('content')
    @include('store.components.footer')
    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('new/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('new/lib/slick/slick.min.js') }}"></script>


    <!-- Template Javascript -->
    <script src="{{ asset('new/js/main.js') }}"></script>

    <script src="{{ asset('assets/vendor/toastr/js/toastr.min.js') }}"></script>

    <!-- All init script -->
    <script src="{{ asset('assets/js/plugins-init/toastr-init.js') }}"></script>

    <!-- The Flash Message-->
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Success Message", {
                    timeOut: 5000,
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    preventDuplicates: true,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: false
                });
            @endif

            @if (session('error'))

                toastr.error("{{ session('error') }}", "Error Message", {
                    timeOut: 5000,
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    preventDuplicates: true,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: false
                });
            @endif
        });
    </script>


    <script>
        function addToCart(productId) {
            const formElement = document.getElementById(`add-to-cart-form-${productId}`);
            if (formElement.closest('[aria-hidden="true"]')) {
                console.warn('Cannot interact with hidden elements.');
                return;
            }

            const url = formElement.getAttribute('data-url');
            const button = document.getElementById(`add-to-cart-button-${productId}`);
            const spinner = button.querySelector('.spinner');

            // Show spinner and disable button
            spinner.style.display = 'inline';
            button.style.pointerEvents = 'none';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: productId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the cart count dynamically
                        const cartCountElement = document.getElementById('cart-item-count');
                        cartCountElement.textContent =
                            `(${data.cart_count})`; // Use data.cart_count returned from the server

                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: 'Item added to cart successfully!',
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to add item to cart.',
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                })
                .finally(() => {
                    // Hide spinner and enable button
                    spinner.style.display = 'none';
                    button.style.pointerEvents = 'auto';
                });
        }
    </script>

    <script>
        function addToWishlist(productId) {
            const button = document.querySelector(`#add-to-wishlist-button-${productId}`);
            if (!button) return;

            const url = button.getAttribute('data-url');
            const spinner = button.querySelector('.spinner');
            const loadingMessage = button.querySelector('.loading-message');
            const normalMessage = button.querySelector('.normal-message');

            // Show spinner and loading message, hide normal message
            if (spinner) spinner.style.display = 'inline';
            if (loadingMessage) loadingMessage.style.display = 'inline';
            if (normalMessage) normalMessage.style.display = 'none';
            button.disabled = true;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: 'Item added to wishlist successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message || 'Failed to add item to wishlist.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .finally(() => {
                    // Hide spinner and loading message, show normal message
                    if (spinner) spinner.style.display = 'none';
                    if (loadingMessage) loadingMessage.style.display = 'none';
                    if (normalMessage) normalMessage.style.display = 'inline';
                    button.disabled = false;
                });
        }
    </script>
</body>

</html>
