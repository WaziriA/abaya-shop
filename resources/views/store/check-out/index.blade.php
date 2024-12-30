@extends('store.layout')
@section('content')


 <!-- / Cart view section -->

 <!-- Breadcrumb Start -->
 <div class="breadcrumb-wrap">
  <div class="container">
      <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('shop.index')}}">Products</a></li>
          <li class="breadcrumb-item active">Checkout</li>
      </ul>
  </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Start -->
<div class="checkout">
  <div class="container"> 
    <form action="{{ route('placeOrder') }}" method="POST">
        @csrf
      <div class="row">
          <div class="col-md-7">
              <div class="billing-address">
                  <h2>Shipping Address</h2>
                  <div class="row">
                      <div class="col-md-6">
                        <label for="agent_name">Shipping Agent</label>
                                <select name="transpoter_id" id="agent_name" class="form-control custom-select">
                                  <option value="">Choose Shipping Agent</option>
                                @foreach($transpoters as $transpoter)
                                   <option value="{{ $transpoter->id }}">{{ $transpoter->transpoter_name }}</option>
                                @endforeach
                                </select>
                      </div>
                      <div class="col-md-6">
                        <label for="shipment_method">Shipment Method</label>
                        <select name="shipment_method_id" id="shipment_method" class="form-control custom-select">
                            <option value="">Choose Shipment Method</option>
                        </select>
                      </div>
                      <div class="col-md-12">
                        <label for="country">Delivery Country</label>
                        <select name="country_id" id="country" class="form-control">
                           <option value="">Choose Delivery Country</option>
                        </select>
                      </div>
                      
                      
                    
                      <div class="col-md-6">
                          <label>City</label>
                          <input type="text" name="town" class="form-control" placeholder="City / Town*">
                      </div>
                      <div class="col-md-6">
                          <label>District</label>
                          <input type="text" name="district" class="form-control" placeholder="District*" >
                      </div>
                      <div class="col-md-6">
                        <label>Street</label>
                        <input type="text" name="street" class="form-control" placeholder="Street*" >
                    </div>
                      
                      <div class="col-md-6">
                          <label>ZIP Code</label>
                          <input class="form-control" type="text" placeholder="ZIP Code">
                      </div>

                      <div class="col-md-12">
                        <label>Description About your Order(option)</label>
                        <textarea cols="8" rows="3" name="note" class="form-control" placeholder="Add Some Explanation About Your Order(Option)"></textarea>
                    </div>
                    <!--
                      -->
                  </div>
              </div>
          </div>
          <div class="col-md-5">
              <div class="checkout-summary">
                  <h2>Cart Total</h2>
                  <div class="checkout-content">
                    <h3>Products</h3>
                    @php
                       $subtotal = 0; // Initialize subtotal
                    @endphp
                    @foreach($cart as $productId => $item)
                    @php
                        $itemTotal = $item['price'] * $item['quantity']; // Calculate total for each item
                        $subtotal += $itemTotal; // Add to subtotal
                       @endphp
                      
                      <p>{{ $item['name'] }} <strong>x {{ $item['quantity'] }}</strong><span>{{ $currency }} {{ number_format($itemTotal, 2) }}</span></p>
                      @endforeach
                      <p class="sub-total">Sub Total<span>{{ $currency }} {{ number_format($subtotal, 2) }}</span></p>
                      <p class="ship-cost">Shipping Cost<span id="shipping-cost" >{{ $currency }} {{ number_format(session('shipping_cost', 0), 2) }}</span></p>
                      <h4>Grand Total<span id="cart-total">{{ $currency }} {{ number_format(session('cart_total'), 2) }}</span></h4>
                  </div>
              </div>

             
              
               <!-- Payment Methods Section -->
          <div class="checkout-payment">
            <h2>Payment Methods</h2>
            <div class="payment-methods">
              @php
                $paymentMethods = [
                  ['id' => 'paypal', 'label' => 'Paypal'],
                  ['id' => 'credit_card', 'label' => 'Credit/Debit Card'],
                 /* ['id' => 'samsung_pay', 'label' => 'SamsungPay'],
                  ['id' => 'app_pay', 'label' => 'AppPay'],
                  ['id' => 'cod', 'label' => 'Cash on Delivery'],*/
                ];
              @endphp

              @foreach($paymentMethods as $method)
                <div class="payment-method">
                  <div class="custom-control custom-radio">
                    <input 
                      type="radio" 
                      class="custom-control-input" 
                      id="payment-{{ $method['id'] }}" 
                      name="payment_method" 
                      value="{{ $method['id'] }}" 
                      required 
                    />
                    <label class="custom-control-label" for="payment-{{ $method['id'] }}">{{ $method['label'] }}</label>
                  </div>

                  <div class="payment-content" id="payment-{{ $method['id'] }}-show">
                    @if ($method['id'] == 'credit_card')
                        <div class="stripe-payment-form">
                            <label for="card-element">Credit or debit card</label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>
                    @else
                        <p>Additional information about {{ $method['label'] }} can go here.</p>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
            <div class="checkout-btn">
              <button type="submit">Place Order</button>
            </div>
          </div>
          </div>
      </div>
    </form>
  </div>
</div>

<!-- Checkout End -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Set your publishable key here
    const stripe = Stripe('your-publishable-key'); // Replace with your Stripe publishable key
    const elements = stripe.elements();

    // Create an instance of the card Element
    const card = elements.create('card');
    
    // Add an instance of the card Element to the DOM
    card.mount('#card-element');

    // Handle form submission
    const form = document.querySelector('form');
    const placeOrderButton = document.getElementById('place-order-btn');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        // Only handle Stripe payment if selected
        if (paymentMethod === 'credit_card') {
            const { token, error } = await stripe.createToken(card);

            if (error) {
                // Display error in the form
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // Send token to your server
                // Use AJAX or form submission to send the token
                handlePaymentToken(token.id);
            }
        } else {
            // Handle other payment methods (like PayPal, COD, etc.)
            form.submit();
        }
    });

    function handlePaymentToken(token) {
        // Send the token to your server for processing
        fetch('/process-stripe-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ stripeToken: token }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/stripe-success'; // Redirect on success
            } else {
                alert('Payment failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment failed');
        });
    }
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
</script>
@endsection
