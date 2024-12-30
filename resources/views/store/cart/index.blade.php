@extends('store.layout')
@section('content')



<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index')}}">Products</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<div class="cart-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach($cart as $productId => $item)
                                <tr>
                                    <td>
                                        <a href="#">
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="Image">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#">{{ $item['name'] }}</a>
                                    </td>
                                    <td>{{ $currency }} {{ number_format($item['price'], 2) }}</td>
                                    <td>
                                        <div class="qty">
                                            <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                            <input type="text" name="quantities[{{ $productId }}]" value="{{ $item['quantity'] }}">
                                            <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>{{ $currency }} {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td>
                                        <button type="button" onclick="removeProductFromCart({{ $productId }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="coupon">
                   {{-- <form action="{{ route('cart.applyCoupon') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="agent_name">Shipping Agent</label>
                                <select name="transpoter_id" id="agent_name" class="form-control custom-select">
                                  <option value="">Choose Shipping Agent</option>
                                @foreach($transpoters as $transpoter)
                                   <option value="{{ $transpoter->id }}">{{ $transpoter->transpoter_name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="shipment_method">Shipment Method</label>
                                <select name="shipment_method_id" id="shipment_method" class="form-control">
                                    <option value="">Choose Shipment Method</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="country">Delivery Country</label>
                                <select name="country_id" id="country" class="form-control">
                                   <option value="">Choose Delivery Country</option>
                                </select>
                            </div>
                        </div>
                        <!--<input type="text" name="coupon_code" placeholder="Coupon Code" required>
                        <button type="submit">Apply Code</button>-->
                    </form>--}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="cart-summary">
                    <div class="cart-content">
                        <h3>Cart Summary</h3>
                        <p>Sub Total<span>{{ $currency }} {{ number_format($subtotal, 2) }}</span></p>
                       {{-- <p>Shipping Cost<span id="shipping-cost">{{ $currency }} {{ number_format(session('shipping_cost', 0), 2) }}</span></p>--}}
                        <h4>Grand Total<span id="cart-total">{{ $currency }} {{ number_format(session('cart_total'), 2) }}</span></h4>
                    </div>
                    <div class="cart-btn">
                        <button onclick="location.href='{{ route('cart.update') }}'">Update Cart</button>
                        <button onclick="location.href='{{ route('check-out.index') }}'">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateShippingCost() {
            var transpoter_id = $('#agent_name').val();
            var shipment_method_id = $('#shipment_method').val();
            var country_id = $('#country').val();

            if (transpoter_id && shipment_method_id && country_id) {
                $.ajax({
                    url: '/calculate-shipping-cost',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        transpoter_id: transpoter_id,
                        shipment_method_id: shipment_method_id,
                        country_id: country_id
                    },
                    success: function (response) {
                        if (response.success && response.shipping_cost !== undefined) {
                            var shippingCost = parseFloat(response.shipping_cost).toFixed(2);
                            $('#shipping-cost').text('' + shippingCost);

                            var subTotal = parseFloat('{{ $subtotal }}'); // Get Sub Total value
                            var grandTotal = subTotal + parseFloat(response.shipping_cost);

                            $('#cart-total').text('' + grandTotal.toFixed(2)); // Update Grand Total
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                            $('#shipping-cost').text('0.00');
                            $('#cart-total').text('' + parseFloat('{{ $subtotal }}').toFixed(2)); // Reset Grand Total to Sub Total
                        }
                    },
                    error: function () {
                        alert('An error occurred while calculating shipping cost.');
                    }
                });
            }
        }

        $('#agent_name, #shipment_method, #country').change(updateShippingCost);

        // Populate shipment method and country dynamically
        $('#agent_name').change(function () {
            var transpoter_id = $(this).val();
            if (transpoter_id) {
                $.ajax({
                    url: '/get-related-data',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        transpoter_id: transpoter_id
                    },
                    success: function (data) {
                        $('#shipment_method').empty().append('<option value="">Choose Shipment Method</option>');
                        $('#country').empty().append('<option value="">Choose Delivery Country</option>');

                        if (data.shipment_methods.length > 0) {
                            data.shipment_methods.forEach(function (method) {
                                $('#shipment_method').append('<option value="' + method.id + '">' + method.method_name + '</option>');
                            });
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                        }

                        if (data.countries.length > 0) {
                            data.countries.forEach(function (country) {
                                $('#country').append('<option value="' + country.id + '">' + country.country_name + '</option>');
                            });
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching related data.');
                    }
                });
            } else {
                $('#shipment_method').empty().append('<option value="">Choose Shipment Method</option>');
                $('#country').empty().append('<option value="">Choose Delivery Country</option>');
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateShippingCost() {
            var transpoter_id = $('#agent_name').val();
            var shipment_method_id = $('#shipment_method').val();
            var country_id = $('#country').val();

            if (transpoter_id && shipment_method_id && country_id) {
                $.ajax({
                    url: '/calculate-shipping-cost',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        transpoter_id: transpoter_id,
                        shipment_method_id: shipment_method_id,
                        country_id: country_id
                    },
                    success: function (response) {
                        if (response.success && response.shipping_cost !== undefined) {
                            var shippingCost = parseFloat(response.shipping_cost).toFixed(2);
                            $('#shipping-cost').text(shippingCost);

                            var subTotal = parseFloat('{{ $subtotal }}'); // Get Sub Total value
                            var grandTotal = subTotal + parseFloat(response.shipping_cost);

                            $('#cart-total').text(grandTotal.toFixed(2)); // Update Grand Total

                            // Update hidden input fields in checkout form
                            $('input[name="transpoter_id"]').val(transpoter_id);
                            $('input[name="shipment_method_id"]').val(shipment_method_id);
                            $('input[name="country_id"]').val(country_id);

                            // Update readonly fields for display
                            $('#agent_name_readonly').val($('#agent_name option:selected').text());
                            $('#shipment_method_readonly').val($('#shipment_method option:selected').text());
                            $('#country_readonly').val($('#country option:selected').text());
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                            $('#shipping-cost').text('0.00');
                            $('#cart-total').text('{{ $subtotal }}'); // Reset Grand Total to Sub Total
                        }
                    },
                    error: function () {
                        alert('An error occurred while calculating shipping cost.');
                    }
                });
            }
        }

        $('#agent_name, #shipment_method, #country').change(updateShippingCost);

        // Populate shipment method and country dynamically
        $('#agent_name').change(function () {
            var transpoter_id = $(this).val();
            if (transpoter_id) {
                $.ajax({
                    url: '/get-related-data',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        transpoter_id: transpoter_id
                    },
                    success: function (data) {
                        $('#shipment_method').empty().append('<option value="">Choose Shipment Method</option>');
                        $('#country').empty().append('<option value="">Choose Delivery Country</option>');

                        if (data.shipment_methods.length > 0) {
                            data.shipment_methods.forEach(function (method) {
                                $('#shipment_method').append('<option value="' + method.id + '">' + method.method_name + '</option>');
                            });
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                        }

                        if (data.countries.length > 0) {
                            data.countries.forEach(function (country) {
                                $('#country').append('<option value="' + country.id + '">' + country.country_name + '</option>');
                            });
                        } else {
                            alert('Not in the range, contact owner 0627370387.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching related data.');
                    }
                });
            } else {
                $('#shipment_method').empty().append('<option value="">Choose Shipment Method</option>');
                $('#country').empty().append('<option value="">Choose Delivery Country</option>');
            }
        });
    });
</script>--}}




<script>
    function removeProductFromCart(productId) {
        $.ajax({
            url: "{{ route('cart.removeProduct') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Update cart count and total
                    $('#cart-count').text(response.itemCount);
                    $('#cart-total').text('$' + response.total.toFixed(2));
                    // Remove item from the table row
                    $('tr[data-id="' + productId + '"]').remove();
                } else {
                    alert("Could not remove the item. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error removing item: ", error);
                alert("An error occurred. Please try again.");
            }
        });
    }
</script>


@endsection
