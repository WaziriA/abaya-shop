<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sadah 1 Abaya :: Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.theme.default.min.css')}}">
    <link href="{{ asset('assets/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet')}}">
    <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/jquery-steps/css/jquery.steps.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
    <link href="{{ asset('assets/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
  
    
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css')}}">



</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">





@include('admin/dash-components.right-icon')
@include('admin/dash-components.right-sidebar')
@include('admin/dash-components.left-sidebar')

@yield('content')
<!-- Jquery Core Js --> 

  <!-- Required vendors -->
  <script src="{{ asset('assets/vendor/global/global.min.js')}}"></script>
  <script src="{{ asset('assets/js/quixnav-init.js')}}"></script>
  <script src="{{ asset('assets/js/custom.min.js')}}"></script>

  <script src="{{ asset('assets/vendor/jquery-steps/build/jquery.steps.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <!-- Form validate init -->
  <script src="{{ asset('assets/js/plugins-init/jquery.validate-init.js')}}"></script>



  <!-- Form step init -->
  <script src="{{ asset('assets/js/plugins-init/jquery-steps-init.js')}}"></script>

  <!-- Vectormap -->
  <script src="{{ asset('assets/vendor/raphael/raphael.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/morris/morris.min.js ')}}"></script>


  <script src="{{ asset('assets/vendor/circle-progress/circle-progress.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js')}}"></script>

  <script src="{{ asset('assets/vendor/gaugeJS/dist/gauge.min.js')}}"></script>

  <!--  flot-chart js -->
  <script src="{{ asset('assets/vendor/flot/jquery.flot.js')}}"></script>
  <script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js')}}"></script>

  <!-- Owl Carousel -->
  <script src="{{ asset('assets/vendor/owl-carousel/js/owl.carousel.min.js')}}"></script>

  <!-- Counter Up -->
  <script src="{{ asset('assets/vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/jqvmap/js/jquery.vmap.usa.js')}}"></script>
  <script src="{{ asset('assets/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>


  <script src="{{ asset('assets/js/dashboard/dashboard-1.js')}}"></script>

  <!-- Datatable -->
  <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins-init/datatables.init.js')}}"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
    
            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error("{{ $error }}", "Error ", {
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
                @endforeach
            @endif
        });
    </script>

    <!--For the Sweet Message for the products-->
    <script>
        // Attach click event listeners to delete buttons
        document.querySelectorAll('.sweet-alert1').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default form submission
                
                const form = this.closest('form'); // Get the closest form element
    
                // Set title and text based on the type of delete
                const isHardDelete = form.classList.contains('hard-delete-form');
                const title = isHardDelete ? "Are you sure to permanently delete?" : "Are you sure to move to trash?";
                const text = isHardDelete ? "You will not be able to recover this product!" : "You can restore it later if needed.";
    
                swal({
                    title: title,
                    text: text,
                    type: "warning",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "No, cancel it!",
                            value: null,
                            visible: true,
                            className: "btn-secondary",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Yes, delete it!",
                            value: true,
                            visible: true,
                            className: isHardDelete ? "btn-danger" : "btn-warning",
                            closeModal: false
                        }
                    }
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit(); // Submit the form if confirmed
                    } else {
                        swal("Cancelled", "Your product is safe!", "error");
                    }
                });
            });
        });
    </script>

<!-- This is the Sweet message for the category-->
    <script>
        function confirmDelete(id) {
            swal({
                title: "Are you sure to delete?",
                text: "You will not be able to recover this category!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "No, cancel it !!",
                        value: null,
                        visible: true,
                        className: "btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, delete it !!",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: false
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    // Submit the form
                    document.getElementById('delete-form-' + id).submit();
                } else {
                    swal("Cancelled", "Your category is safe!", "error");
                }
            });
        }
    </script>

    <!-- This is the Sweet message for the restoring the product-->
    <script>
        function confirmRestore(id) {
            swal({
                title: "Are you sure you want to restore this product?",
                text: "The product will be restored to its original state.",
                icon: "info",
                buttons: {
                    cancel: {
                        text: "No, cancel it!",
                        value: null,
                        visible: true,
                        className: "btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, restore it!",
                        value: true,
                        visible: true,
                        className: "btn-primary",
                        closeModal: false
                    }
                }
            }).then((willRestore) => {
                if (willRestore) {
                    // Submit the restore form
                    document.getElementById('restore-form-' + id).submit();
                } else {
                    swal("Cancelled", "The product was not restored.", "error");
                }
            });
        }
    
        function confirmDelete(id) {
            swal({
                title: "Are you sure you want to permanently delete this product?",
                text: "You will not be able to recover this product once deleted!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "No, cancel it!",
                        value: null,
                        visible: true,
                        className: "btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, delete it permanently!",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: false
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    // Submit the delete form
                    document.getElementById('delete-form-' + id).submit();
                } else {
                    swal("Cancelled", "The product was not deleted.", "error");
                }
            });
        }
    </script>

<script>
    function confirmSoftDelete(id) {
        swal({
            title: "Are you sure to soft delete?",
            text: "You can restore this user later.",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel it!",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, soft delete it!",
                    value: true,
                    visible: true,
                    className: "btn-warning",
                    closeModal: false
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                // Submit the soft delete form
                document.getElementById('soft-delete-form-' + id).submit();
            } else {
                swal("Cancelled", "The user remains active!", "info");
            }
        });
    }

    function confirmHardDelete(id) {
        swal({
            title: "Are you sure to permanently delete?",
            text: "This action cannot be undone!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel it!",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, delete it permanently!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: false
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                // Submit the hard delete form
                document.getElementById('hard-delete-form-' + id).submit();
            } else {
                swal("Cancelled", "The user is safe!", "info");
            }
        });
    }
</script>
<!--Restore the users-->
<script>
    function confirmRestore(id) {
        swal({
            title: "Are you sure to restore this user?",
            text: "The user will be restored to the active list!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel it !!",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, restore it !!",
                    value: true,
                    visible: true,
                    className: "btn-success",
                    closeModal: false
                }
            }
        }).then((willRestore) => {
            if (willRestore) {
                // Submit the restore form
                document.getElementById('restore-form-' + id).submit();
            } else {
                swal("Cancelled", "User restoration cancelled!", "error");
            }
        });
    }
</script>

<!--Sweet Alert For delete in Home Carousel Items-->

<script>
    function softDeleteConfirmation(id) {
        swal({
            title: "Are you sure?",
            text: "This will soft delete the item.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('soft-delete-form-' + id).submit();
            }
        });
    }

    function hardDeleteConfirmation(id) {
        swal({
            title: "Are you sure?",
            text: "This will permanently delete the item.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('hard-delete-form-' + id).submit();
            }
        });
    }
</script>

<!--Confirm Carousel Restore-->

<script>
    function confirmCarouselRestore(id) {
        swal({
            title: "Are you sure?",
            text: "This will restore the soft-deleted item.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willRestore) => {
            if (willRestore) {
                document.getElementById('restore-form-' + id).submit();
            }
        });
    }
</script>

<!--For deleting the coupon-->
<script>
    function confirmCouponDelete(id) {
        swal({
            title: "Are you sure you want to delete this coupon?",
            text: "This action will move the coupon to the trash.",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, keep it",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, delete it",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: false
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-form-' + id).submit();
            } else {
                swal("Cancelled", "The coupon was not deleted.", "error");
            }
        });
    }
</script>

<!--For coupon restore-->
<script>
    function confirmCouponRestore(id) {
        swal({
            title: "Are you sure you want to restore this coupon?",
            text: "This action will restore the coupon.",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel it!",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, restore it!",
                    value: true,
                    visible: true,
                    className: "btn-success",
                    closeModal: false
                }
            }
        }).then((willRestore) => {
            if (willRestore) {
                // Submit the restore form
                document.getElementById('restore-form-' + id).submit();
            } else {
                swal("Cancelled", "The coupon was not restored.", "error");
            }
        });
    }

    function confirmCouponDelete(id) {
        swal({
            title: "Are you sure you want to permanently delete this coupon?",
            text: "You will not be able to recover this coupon once deleted!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No, cancel it!",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, delete it permanently!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: false
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                // Submit the delete form
                document.getElementById('delete-form-' + id).submit();
            } else {
                swal("Cancelled", "The coupon was not deleted.", "error");
            }
        });
    }
</script>

</body>

</html>