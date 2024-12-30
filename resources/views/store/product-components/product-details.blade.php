<!-- Product Detail Start -->
<div class="product-detail">
    <div class="container">

        <div class="row">

            <div class="col-lg-9">
                <div class="row align-items-center product-detail-top">
                    <div class="col-md-5">
                        <div class="product-slider-single">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                style="width: 400px; height:400px">
                            <!--<img src="img/product-2.png" alt="Product Image">
                          <img src="img/product-3.png" alt="Product Image">-->
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="product-content">
                            <div class="title">
                                <h2>{{ $product->name }}</h2>
                            </div>
                            <div class="ratting">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price">{{ $currency }} {{ $product->price }}</div>
                            <div class="details">
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!--<div class="quantity">
                              <h4>Quantity:</h4>
                              <div class="qty">
                                  <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                  <input type="text" value="1">
                                  <button class="btn-plus"><i class="fa fa-plus"></i></button>
                              </div>
                          </div>-->
                            <div class="action">

                                <form id="add-to-cart-form-{{ $product->id }}"
                                    data-url="{{ route('cart.add', $product->id) }}" style="display: none;">
                                    @csrf
                                </form>
                                <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});"
                                    id="add-to-cart-button-{{ $product->id }}">
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
                                <a href="javascript:void(0);"
                                    onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                    <i class="fa fa-heart"></i>
                                </a>
                                {{-- <a href="#"><i class="fa fa-search"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row product-detail-bottom">
                    <div class="col-lg-12">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#reviews">Reviews
                                    ({{ $reviewCount }})</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="description" class="container tab-pane active"><br>
                                <h4>Product description</h4>
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>
                            <div id="specification" class="container tab-pane fade"><br>
                                <h4>Product specification</h4>
                                <ul>
                                    <li>color: {{ $product->color }}</li>
                                    <li>Size: {{ $product->size }}</li>
                                    <li>Brand: {{ $product->brand }}</li>
                                    <li>Category: {{ $product->category->name }}</li>
                                </ul>
                            </div>

                            <div id="reviews" class="container tab-pane fade"><br>
                                @foreach ($reviews as $review)
                                    <div class="reviews-submitted">
                                        <div class="reviewer">{{ $review->user->name ?? 'N/A' }} -
                                            <span>{{ $review->created_at->format('d M Y') }}
                                        </div>
                                        <div class="ratting">
                                            <!-- Check if the review has a rating -->
                                            @if ($review->rating)
                                                <!-- If rated, display stars based on the rating -->
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $review->rating >= $i ? 'filled' : '' }}"></i>
                                                @endfor
                                            @else
                                                <!-- If not rated, display empty stars -->
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star-o"></i>
                                                @endfor
                                            @endif
                                        </div>
                                        <p>
                                        <p>{{ $review->comment }}</p>
                                        </p>
                                    </div>
                                @endforeach

                                <div class="reviews-submit">
                                    <h4>Give your Review:</h4>
                                    <!-- <div class="ratting">
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>-->
                                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="row form">
                                            <!-- Name -->
                                            @auth
                                                <div class="col-sm-6">
                                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                                        readonly placeholder="Name">
                                                </div>

                                                <!-- Email -->
                                                <div class="col-sm-6">
                                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                                        readonly placeholder="Email">
                                                </div>
                                            @endauth
                                            <!-- Review -->
                                            <div class="col-sm-12">
                                                <textarea name="comment" placeholder="Write your review here..." required></textarea>
                                            </div>

                                            <!-- Rating -->
                                            <div class="col-sm-12">
                                                <select name="rating" class="form-control custom-select" required>
                                                    <option value="" disabled selected>Select Rating</option>
                                                    <option value="1">1 - Poor</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="3">3 - Good</option>
                                                    <option value="4">4 - Very Good</option>
                                                    <option value="5">5 - Excellent</option>
                                                </select>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-sm-12">
                                                <button type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="section-header">
                        <h3>Related Products</h3>
                        <p>
                            Discover our premium collection of Abayas, designed for style and comfort. Perfectly
                            tailored with intricate details, they offer a blend of tradition and modernity for every
                            occasion.
                        </p>
                    </div>
                </div>

                <div class="row align-items-center product-slider product-slider-3">
                    @foreach ($relatedProducts as $product)
                        <div class="col-lg-3">
                            <div class="product-item">
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                            style=" height: 322px;">
                                    </a>
                                    <div class="product-action">
                                        <form id="add-to-cart-form-{{ $product->id }}"
                                            data-url="{{ route('cart.add', $product->id) }}" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});"
                                            id="add-to-cart-button-{{ $product->id }}">
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
                                        <a href="javascript:void(0);"
                                            onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        <a href="#" data-toggle="modal"
                                            data-target="#QuickViewModal{{ $product->id }}">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="title"><a href="#">{{ $product->name }}</a></div>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="price">{{ $product->price }} <span>$25</span></div>
                                </div>
                            </div>
                        </div>
                        @include('store.components.product-modal', ['product' => $product])
                    @endforeach

                    <!-- <div class="col-lg-3">
                      <div class="product-item">
                          <div class="product-image">
                              <a href="product-detail.html">
                                  <img src="img/product-2.png" alt="Product Image">
                              </a>
                              <div class="product-action">
                                  <a href="#"><i class="fa fa-cart-plus"></i></a>
                                  <a href="#"><i class="fa fa-heart"></i></a>
                                  <a href="#"><i class="fa fa-search"></i></a>
                              </div>
                          </div>
                          <div class="product-content">
                              <div class="title"><a href="#">Phasellus Gravida</a></div>
                              <div class="ratting">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                              <div class="price">$22 <span>$25</span></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3">
                      <div class="product-item">
                          <div class="product-image">
                              <a href="product-detail.html">
                                  <img src="img/product-3.png" alt="Product Image">
                              </a>
                              <div class="product-action">
                                  <a href="#"><i class="fa fa-cart-plus"></i></a>
                                  <a href="#"><i class="fa fa-heart"></i></a>
                                  <a href="#"><i class="fa fa-search"></i></a>
                              </div>
                          </div>
                          <div class="product-content">
                              <div class="title"><a href="#">Phasellus Gravida</a></div>
                              <div class="ratting">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                              <div class="price">$22 <span>$25</span></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3">
                      <div class="product-item">
                          <div class="product-image">
                              <a href="product-detail.html">
                                  <img src="img/product-4.png" alt="Product Image">
                              </a>
                              <div class="product-action">
                                  <a href="#"><i class="fa fa-cart-plus"></i></a>
                                  <a href="#"><i class="fa fa-heart"></i></a>
                                  <a href="#"><i class="fa fa-search"></i></a>
                              </div>
                          </div>
                          <div class="product-content">
                              <div class="title"><a href="#">Phasellus Gravida</a></div>
                              <div class="ratting">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                              <div class="price">$22 <span>$25</span></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3">
                      <div class="product-item">
                          <div class="product-image">
                              <a href="product-detail.html">
                                  <img src="img/product-5.png" alt="Product Image">
                              </a>
                              <div class="product-action">
                                  <a href="#"><i class="fa fa-cart-plus"></i></a>
                                  <a href="#"><i class="fa fa-heart"></i></a>
                                  <a href="#"><i class="fa fa-search"></i></a>
                              </div>
                          </div>
                          <div class="product-content">
                              <div class="title"><a href="#">Phasellus Gravida</a></div>
                              <div class="ratting">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                              <div class="price">$22 <span>$25</span></div>
                          </div>
                      </div>
                  </div>-->
                </div>
            </div>

            <div class="col-lg-3">
                <div class="sidebar-widget category">
                    <h2 class="title">Category</h2>
                    <ul>
                        @foreach ($categories as $item)
                            <li>
                                <a href="#">{{ $item->name }}</a>
                                <span>({{ $item->products_count }})</span> <!-- Use `products_count` -->
                            </li>
                        @endforeach
                    </ul>

                </div>

                <div class="sidebar-widget image">
                    <h2 class="title">Color Variants</h2>
                </div>
                <div class="sidebar-widget image product-slider product-slider-3 ">

                    @if ($colorVariantProducts->isEmpty())
                        <p>No data found</p>
                    @else
                        @foreach ($colorVariantProducts as $product)
                            <a href="{{ route('single-detail.index', ['id' => $product->id]) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="variant-image">
                            </a>
                        @endforeach
                    @endif
                </div>

                <!--<div class="sidebar-widget brands">
                    <h2 class="title">Our Brands</h2>
                    <ul>
                        <li><a href="#">Nulla </a><span>(45)</span></li>
                        <li><a href="#">Curabitur </a><span>(34)</span></li>
                        <li><a href="#">Nunc </a><span>(67)</span></li>
                        <li><a href="#">Ullamcorper</a><span>(74)</span></li>
                        <li><a href="#">Fusce </a><span>(89)</span></li>
                        <li><a href="#">Sagittis</a><span>(28)</span></li>
                    </ul>
                </div>

                <div class="sidebar-widget tag">
                    <h2 class="title">Tags Cloud</h2>
                    <a href="#">Lorem ipsum</a>
                    <a href="#">Vivamus</a>
                    <a href="#">Phasellus</a>
                    <a href="#">pulvinar</a>
                    <a href="#">Curabitur</a>
                    <a href="#">Fusce</a>
                    <a href="#">Sem quis</a>
                    <a href="#">Mollis metus</a>
                    <a href="#">Sit amet</a>
                    <a href="#">Vel posuere</a>
                    <a href="#">orci luctus</a>
                    <a href="#">Nam lorem</a>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!-- Product Detail End -->
