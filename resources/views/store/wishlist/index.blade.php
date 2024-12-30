@extends('store.layout')
@section('content')
{{--<section id="cart-view">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="cart-view-area">
            <div class="cart-view-table aa-wishlist-table">
              <form action="">
                <div class="table-responsive">
                  @if (empty($wishlistItems))
                       <p>No products added to your wishlist.</p>
                   @else
                   <table class="table">
                     <thead>
                       <tr>
                         <th></th>
                         <th></th>
                         <th>Product</th>
                         <th>Price</th>
                         <th>Stock Status</th>
                         <th></th>
                       </tr>
                     </thead>
                     <tbody>
                       @foreach ($wishlistItems as $item)
                       <tr>
                         <td><a class="remove" href="{{ route('wishlist.remove', $item->id) }}"><fa class="fa fa-close"></fa></a></td>
                         <td><a href="#"><img src="{{ $item->product->image }}" alt="img"></a></td>
                         <td><a class="aa-cart-title" href="#">{{ $item->product->name }}</a></td>
                         <td>${{ number_format($item->product->price, 2) }}</td>
                         <td>{{ $item->product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                         <td><a href="{{ route('cart.add', $item->product->id) }}" class="aa-add-to-cart-btn">Add To Cart</a></td>
                       </tr>
                       @endforeach                     
                     </tbody>
                   </table>
                   @endif
                 </div>
              </form>             
            </div>
          </div>
        </div>
      </div>
    </div>
</section>--}}

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
  <div class="container">
      <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Products</a></li>
          <li class="breadcrumb-item active">Wishlist</li>
      </ul>
  </div>
</div>
<!-- Breadcrumb End -->


<!-- Wishlist Start -->
<div class="cart-page">
  <div class="container">
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                          <tr>
                              <th>Image</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Add to Cart</th>
                              <th>Remove</th>
                          </tr>
                      </thead>
                      <tbody class="align-middle">
                          @forelse ($wishlistItems as $item)
                              <tr>
                                  <td>
                                      <a href="{{ route('single-detail.index', $item->product->id ?? '#') }}">
                                          <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 80px; height: 80px;">
                                      </a>
                                  </td>
                                  <td>
                                      <a href="{{ route('single-detail.index', $item->product->id ?? '#') }}">
                                          {{ $item->product->name }}
                                      </a>
                                  </td>
                                  <td>
                                    {{ $currency }} {{ number_format($item->product->price ?? 0, 2) }}
                                </td>
                                  <td>
                                    <form id="add-to-cart-form-{{ $item->product->id }}"
                                      data-url="{{ route('cart.add', $item->product->id) }}" style="display: none;">
                                      @csrf
                                  </form>

                                      <a href="javascript:void(0);" onclick="addToCart({{ $item->product->id }});"
                                        id="add-to-cart-button-{{ $item->product->id }}">
                                        <i class="fa fa-cart-plus"></i>
                                        <span class="spinner" style="display: none; margin-left: 5px;">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </span>
                                    </a>
                                  </td>
                                  <td>
                                      <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger">
                                              <i class="fa fa-trash"></i>
                                          </button>
                                      </form>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="5" class="text-center">Your wishlist is empty!</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- Wishlist End -->

@endsection
