
  
  <!-- Recent Product Start -->
<!-- Recent Product Start -->
<div class="recent-product ">
    <div class="container">
        <div class="section-header">
            <h3 style="font-family: nabi;">Recent Product</h3>
            <p style="font-family: nabi;">
                Explore our collection of stylish, high-quality clothing, designed for every occasion. From timeless basics to the latest trends, our pieces offer a perfect blend of comfort and elegance. Whether you're dressing for work, play, or relaxation, you'll find something that suits your style and lifestyle.
            </p>
        </div>
        <div class="row align-items-center product-slider product-slider-4">
            @foreach ($recentProducts as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-item">
                        <div class="product-image">
                            <a href="{{ route('single-detail.index', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"  style="width: ; height: 322px;">
                            </a>
                            <div class="product-action">
                                <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" id="add-to-cart-button-{{ $product->id }}">
                                    <i class="fa fa-cart-plus"></i>
                                    <span class="spinner" style="display: none; margin-left: 5px;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </span>
                                </a>
                                <form id="add-to-wishlist-form-{{ $product->id }}"
                                    action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a href="javascript:void(0);" onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                    <i class="fa fa-heart"></i> 
                                </a>
                                <a href="#" data-toggle="modal" data-target="#QuickViewModal{{ $product->id }}">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="title"><a href="{{ route('single-detail.index', $product->id) }}">{{ $product->name }}</a></div>
                            <div class="ratting">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $product->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            {{--<div class="price">{{ $currency }}  {{ number_format($product->price, 2) }} 
                                @if ($product->sale_price)
                                    <span>TSh {{ number_format($product->sale_price, 2) }}</span>
                                @endif
                            </div>--}}
                        </div>
                    </div>
                </div>
                @include('store.components.product-modal', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>
<!-- Recent Product End -->

<!-- Recent Product End -->

  




  