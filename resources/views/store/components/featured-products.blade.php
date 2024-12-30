


<!-- Featured Product Start -->
<div class="featured-product d-none d-md-block">
    <div class="container">
        <div class="section-header">
            <h3 style="font-family: nabi;">Featured Product</h3>
            <p style="font-family: nabi;">
                Discover our premium collection of Abayas, designed for style and comfort. Perfectly tailored with
                intricate details, they offer a blend of tradition and modernity for every occasion.
        </div>
        <div class="row align-items-center  "><!--product-slider product-slider-4-->
            @if ($products->isNotEmpty())
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 mt-3">
                        <div class="product-item">
                            <div class="product-image">
                                <a href="{{ route('single-detail.index', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        style="width: 300px; height: 320px;">
                                </a>
                                <div class="product-action">
                                    <form id="add-to-cart-form-{{ $product->id }}"
                                        data-url="{{ route('cart.add', $product->id) }}" style="display: none;">
                                        @csrf
                                    </form>
                                    <form id="add-to-wishlist-form-{{ $product->id }}"
                                        action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});"
                                        id="add-to-cart-button-{{ $product->id }}">
                                        <i class="fa fa-cart-plus"></i>
                                        <span class="spinner" style="display: none; margin-left: 5px;">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                        <i class="fa fa-heart"></i> 
                                    </a>
                                    <a href="#" data-toggle="modal"
                                        data-target="#QuickViewModal{{ $product->id }}">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>

                            </div>

                            <div class="product-content">
                                <div class="title">
                                    <a
                                        href="{{ route('single-detail.index', $product->id) }}" style="font-family: nabi;">{{ $product->name }}</a>
                                </div>
                                <div class="ratting">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <div class="price">
                                    {{ $currency }} {{ number_format($product->price, 2) }}
                                    @if ($product->availability_status === 'sale')
                                        <span>${{ number_format($product->original_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('store.components.product-modal', ['product' => $product])
                @endforeach
            @else
                <div class="col-12">
                    <h3 style="font-family: nabi;">No products found</h3>
                </div>
            @endif
        </div>

    </div>
</div>
<!-- Featured Product End -->

<!-- Product Container for Small Screens -->
<div class="container d-block d-md-none mt-4">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 d-flex mb-3">
                <div class="product-card w-100">
                    <div class="d-flex justify-content-between p-2">
                        <div>
                            <div class="discount-badge">
                                <span
                                    class="aa-badge {{ $product->status === 'sold-out' ? 'aa-sold-out' : 'aa-sale' }}">
                                    {{ $product->status === 'sold-out' ? 'Sold Out!' : 'SALE!' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="wishlist-icon">❤️</div>
                        </div>
                    </div>
                    <a href="{{ route('single-detail.index', ['id' => $product->id]) }}"> <img
                            src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                            alt="{{ $product->name }}" style="width: 200px; height:150px"></a>
                    <div class="product-details p-2">
                        <a href="{{ route('single-detail.index', ['id' => $product->id]) }}">
                            <h4 class="product-orders mb-1">{{ $product->name }} </h4>
                        </a>
                        <h5 class="mb-1">${{ number_format($product->price, 2) }}</h5>
                        <p class="product-orders mb-1">{{ $product->orders->count() }} orders</p>
                        <p class="product-rating mb-0">★ {{ $product->rating }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
