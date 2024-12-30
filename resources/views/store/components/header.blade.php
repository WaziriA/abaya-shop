
@include('store/components/modal-login')
@include('store/components/modal-register')


<!-- Top Header Start -->
<div class="top-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="logo">
                    <a href="{{ route('home.index') }}">
                        <img src="{{ asset('material/img/logo/logo.jpg') }}" style="height:80px; width:160px"
                            alt="logo img">
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="search">
                    <input type="text" placeholder="Search">
                    <button><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="user">
                    @guest


                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-family: nabi;">My Account</a>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item" data-toggle="modal"
                                    data-target="#LoginModal" style="font-family: nabi;">Login</a>
                                <a href="#" class="dropdown-item" data-toggle="modal"
                                    data-target="#RegisterModal" style="font-family: nabi;">Register</a>
                            </div>
                        </div>
                    @endguest

                    @auth


                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-family: nabi;">Profile</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('customer-profile.index') }}" class="dropdown-item" style="font-family: nabi;">View Profile</a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="dropdown-item" style="font-family: nabi;">Logout</a>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                                  @csrf
                                     
                                  </form>
                            </div>
                        </div>
                    @endauth

                    <div class="cart">
                        <a href="{{ route('cart.index') }}">
                            <i class="fa fa-cart-plus"></i>
                            <span id="cart-item-count">({{ session('cart') ? count(session('cart')) : 0 }})</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Header End -->
