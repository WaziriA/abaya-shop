<!-- Start header section -->
<header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <!-- start header top left -->
              <div class="aa-header-top-left">
                <!-- start language -->
             <!--   <div class="aa-language">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <img src="img/flag/english.jpg" alt="english flag">ENGLISH
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><img src="img/flag/french.jpg" alt="">FRENCH</a></li>
                      <li><a href="#"><img src="img/flag/english.jpg" alt="">ENGLISH</a></li>
                    </ul>
                  </div>
                </div>-->
                <!-- / language -->

                <!-- start currency -->
                <div class="aa-currency">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <i class="fa fa-usd"></i>USD
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><i class="fa fa-euro"></i>EURO</a></li>
                      <li><a href="#"><i class="fa fa-jpy"></i>YEN</a></li>
                    </ul>
                  </div>
                </div>
                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>00-62-658-658</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  @guest
                  <li><a href="#" data-toggle="modal" data-target="#RegisterModal">Register</a></li>
                  @endguest
                  
                  @auth
                      
                  
                  <li><a href="#" >My Account</a></li>
                  @endauth

                  <li class="hidden-xs"><a href="wishlist.html">Wishlist</a></li>
                  <li class="hidden-xs"><a href="{{ route('cart.index')}}">My Cart</a></li>
                  <li class="hidden-xs"><a href="{{ route('check-out.index')}}">Checkout</a></li>
                  @auth
                  <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            Log-out
                        </a>
                    </form>
                </li>
                
                  @endauth
                      
                  @guest
                  <li><a href="" data-toggle="modal" data-target="#LoginModal">Login</a></li>
                  @endguest
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
              <!--  <a href="index.html">
                  <span class="fa fa-shopping-cart"></span>
                  <p>daily<strong>Shop</strong> <span>Your Shopping Partner</span></p>
                </a>-->
                <!-- img based logo -->
                <a href="#"><img src="{{ asset('material/img/logo/logo.jpg')}}" style="height:80px; width:160px" alt="logo img"></a> 
              </div>
              <!-- / logo  -->
               <!-- cart box -->
               <div class="aa-cartbox">
                <a class="aa-cart-link" href="#">
                    <span class="fa fa-shopping-basket"></span>
                    <span class="aa-cart-title">SHOPPING CART</span>
                    <span id="cart-count" class="aa-cart-notify">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </a>
                <div class="aa-cartbox-summary">
                    <ul id="cart-items-list">
                        @php $total = 0; @endphp
                        @foreach (session('cart', []) as $id => $item)
                            <li data-id="{{ $id }}">
                                <a class="aa-cartbox-img" href="#"><img src="{{ asset('storage/' . $item['image']) }}" alt="img"></a>
                                <div class="aa-cartbox-info">
                                    <h4><a href="#">{{ $item['name'] }}</a></h4>
                                    <p>{{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</p>
                                </div>
                                <a class="aa-remove-product" href="javascript:void(0);" onclick="removeFromCart({{ $id }})"><span class="fa fa-times"></span></a>
                            </li>
                            @php $total += $item['quantity'] * $item['price']; @endphp
                        @endforeach
                        <li>
                            <span class="aa-cartbox-total-title">Total</span>
                            <span id="cart-total" class="aa-cartbox-total-price">${{ number_format($total, 2) }}</span>
                        </li>
                    </ul>
                    <a class="aa-cartbox-checkout aa-primary-btn" href="{{ route('cart.index')}}">View Cart</a>
                </div>
            </div>
            
            <script>
                function removeFromCart(productId) {
                    $.ajax({
                        url: "{{ route('cart.remove') }}",
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
            </script>
            
            
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="">
                  <input type="text" name="" id="" placeholder="Search here ex. 'man' ">
                  <button type="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->             
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  @include('store/components/modal-login')
  @include('store/components/modal-register')