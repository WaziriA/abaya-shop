
<!-- Header Start -->
<div class="header">
  <div class="container">
      <nav class="navbar navbar-expand-md bg-dark navbar-dark">
          <a href="#" class="navbar-brand" style="font-family: nabi;">MENU</a>
          <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
              <div class="navbar-nav m-auto">
                  <a href="{{ route('home.index') }}" 
                     class="nav-item nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}" style="font-family: nabi;" >Home</a>

                  <a href="{{ route('shop.index') }}" 
                     class="nav-item nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}" style="font-family: nabi;">Products</a>

                  <a href="{{ route('cart.index') }}" 
                     class="nav-item nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" style="font-family: nabi;">Cart</a>

                  @auth
                  <a href="{{ route('wish-list.index') }}" 
                     class="nav-item nav-link {{ request()->routeIs('wish-list.index') ? 'active' : '' }}" style="font-family: nabi;">Wishlist</a>
                  @endauth
                  
                  <a href="{{ route('contact.index') }}" 
                     class="nav-item nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}" style="font-family: nabi;">Contact Us</a>
              </div>
          </div>
      </nav>
  </div>
</div>
<!-- Header End -->
