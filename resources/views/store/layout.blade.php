<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sadah Abaya Shop | Home</title>
    
    <!-- Font awesome -->
    <link href="{{ asset('material/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset('material/css/bootstrap.css')}}" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="{{ asset('material/css/jquery.smartmenus.bootstrap.css')}}" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('material/css/jquery.simpleLens.css')}}">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('material/css/slick.css')}}">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('material/css/nouislider.css')}}">
    <!-- Theme color -->
    <link id="switcher" href="{{ asset('material/css/theme-color/default-theme.css')}}" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="{{ asset('material/css/sequence-theme.modern-slide-in.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css')}}">
    <link href="{{ asset('assets/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <!-- Main style sheet -->
    <link href="{{ asset('material/css/style.css')}}" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    .spinner {
    margin-left: 5px; /* Space between icon and spinner */
    font-size: 1.2em; /* Adjust size */
}

.loading-message {
    margin-left: 5px; /* Space between spinner and text */
    font-size: 1em; /* Adjust size */
    color: #333; /* Change color as needed */
}

  </style>

  </head>
  <body> 
 <!-- wpf loader Two -->
   <!-- <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Loading</span>
      </div>
    </div> -->
    <!-- / wpf loader Two -->       
  <!-- SCROLL TOP BUTTON -->
  <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->
  @include('store.components.header')
@include('store.components.menu')
    @yield('content')
  @include('store.components.footer')
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{ asset('material/js/bootstrap.js')}}"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="{{ asset('material/js/jquery.smartmenus.js')}}"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="{{ asset('material/js/jquery.smartmenus.bootstrap.js')}}"></script>  
  <!-- To Slider JS -->
  <script src="{{ asset('material/js/sequence.js')}}"></script>
  <script src="{{ asset('material/js/sequence-theme.modern-slide-in.js')}}"></script>  
  <!-- Product view slider -->
  <script type="text/javascript" src="{{ asset('material/js/jquery.simpleGallery.js')}}"></script>
  <script type="text/javascript" src="{{ asset('material/js/jquery.simpleLens.js')}}"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="{{ asset('material/js/slick.js')}}"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="{{ asset('material/js/nouislider.js')}}"></script>
  <!-- Custom js -->
  <script src="{{ asset('material/js/custom.js')}}"></script> 
  
      <!-- Toastr -->
      <script src="{{ asset('assets/vendor/toastr/js/toastr.min.js')}}"></script>

      <!-- All init script -->
      <script src="{{ asset('assets/js/plugins-init/toastr-init.js')}}"></script>
  <!-- The Flash Message-->
      <script>
        $(document).ready(function() {
            @if(session('success'))
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
    
            @if(session('error'))
                
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
    const url = document.getElementById(`add-to-cart-form-${productId}`).getAttribute('data-url');
    const button = document.querySelector(`#add-to-cart-form-${productId} .aa-add-card-btn`);
    const spinner = button.querySelector('.spinner');
    const loadingMessage = button.querySelector('.loading-message');
    const normalMessage = button.querySelector('.normal-message');

    // Show spinner and loading message, hide normal message
    spinner.style.display = 'inline'; // Show spinner
    loadingMessage.style.display = 'inline'; // Show loading message
    normalMessage.style.display = 'none'; // Hide normal message
    button.disabled = true; // Disable the button

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartCountElement = document.getElementById('cart-count');
            cartCountElement.textContent = parseInt(cartCountElement.textContent) + 1;

            // SweetAlert success message
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: 'Item added to cart successfully!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            // SweetAlert error message
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to add item to cart.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // SweetAlert error message
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
        spinner.style.display = 'none'; // Hide spinner
        loadingMessage.style.display = 'none'; // Hide loading message
        normalMessage.style.display = 'inline'; // Show normal message
        button.disabled = false; // Enable the button
    });
}



</script>

  </body>
</html>