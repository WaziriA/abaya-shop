@extends('store.layout')
@section('content')
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Cart Page</h2>
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Cart</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Cart view section -->
<section id="cart-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-view-area">
                    <div class="cart-view-table">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($cart && count($cart) > 0)
                                            @foreach($cart as $productId => $item)
                                            <tr data-id="{{ $productId }}">
                                                <td>
                                                    <a class="aa-remove-product" href="javascript:void(0);" onclick="removeProductFromCart({{ $productId }})">
                                                        <span class="fa fa-times"></span>
                                                    </a>
                                                </td>
                                                <td><a href="#"><img src="{{ asset('storage/' . $item['image']) }}" alt="img"></a></td>
                                                <td><a class="aa-cart-title" href="#">{{ $item['name'] }}</a></td>
                                                <td>${{ number_format($item['price'], 2) }}</td>
                                                <td>
                                                    <input class="aa-cart-quantity" type="number" name="quantities[{{ $productId }}]" value="{{ $item['quantity'] }}">
                                                </td>
                                                <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" class="aa-cart-view-bottom">
                                                    <div class="aa-cart-coupon">
                                                        <input class="aa-coupon-code" type="text" name="code" placeholder="Coupon">
                                                        <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                                                    </div>
                                                    <input class="aa-cart-view-btn" type="submit" value="Update Cart">
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <p>No products added to the cart.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- Cart Total view -->
                        <div class="cart-view-total">
    <h4>Cart Totals</h4>
    <table class="aa-totals-table">
        <tbody>
            <tr>
                <th>Subtotal</th>
                <td>${{ number_format($subtotal, 2) }}</td>
            </tr>
            @if(session()->has('coupon'))
                <tr>
                    <th>Discount ({{ session('coupon.code') }})</th>
                    <td>-${{ number_format(session('coupon.discount'), 2) }}</td>
                </tr>
            @endif
            <tr>
                <th>Total</th>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('check-out.index') }}" class="aa-cart-view-btn">Proceed to Checkout</a>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Cart view section -->
{{--
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

                  // Remove item from the list
                  $('li[data-id="' + productId + '"]').remove();
              }
          }
      });
  }
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
