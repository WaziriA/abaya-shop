<!-- popular section -->
<section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#popular" data-toggle="tab">Popular</a></li>
                <li><a href="#featured" data-toggle="tab">Trending</a></li>
                <li><a href="#latest" data-toggle="tab">Latest</a></li>                    
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men popular category -->
                <div class="tab-pane fade in active" id="popular">
                  <ul class="aa-product-catg aa-popular-slider">
                    @if($popularProducts->isNotEmpty())
                        @foreach($popularProducts as $product)
                            <li>
                                <figure>
                                    <a class="aa-product-img" href="#"><img src="{{ asset('storage/' . $product->image) }}" style="width:250px; height:300px;" alt="{{ $product->title }} image"></a>
                                    <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="#">{{ $product->title }}</a></h4>
                                        <span class="aa-product-price">${{ $product->price }}</span>
                                        @if($product->discount_price)
                                            <span class="aa-product-price"><del>${{ $product->discount_price }}</del></span>
                                        @endif
                                    </figcaption>
                                </figure>
                                <div class="aa-product-hvr-content">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                    <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                                </div>
                                <!-- Product Badge -->
                                <span class="aa-badge {{ $product->status === 'sold-out' ? 'aa-sold-out' : 'aa-sale' }}">
                                    {{ $product->status === 'sold-out' ? 'Sold Out!' : 'SALE!' }}
                                </span>
                            </li>
                        @endforeach
                    @else
                        <li>No popular products found.</li>
                    @endif
                </ul>
                  <a class="aa-browse-btn" href="{{ route('shop.index')}}">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / popular product category -->
                
                <!-- start featured product category -->
                <div class="tab-pane fade" id="featured">
                  <ul class="aa-product-catg aa-featured-slider">
                    @if($trendingProducts->isNotEmpty())
                        @foreach($trendingProducts as $product)
                            <li>
                                <figure>
                                    <a class="aa-product-img" href="#"><img src="{{ asset('storage/' . $product->image) }}" style="width:250px; height:300px;" alt="{{ $product->title }} image"></a>
                                    <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="#">{{ $product->title }}</a></h4>
                                        <span class="aa-product-price">${{ $product->price }}</span>
                                        @if($product->discount_price)
                                            <span class="aa-product-price"><del>${{ $product->discount_price }}</del></span>
                                        @endif
                                    </figcaption>
                                </figure>
                                <div class="aa-product-hvr-content">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                    <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                                </div>
                                <!-- Product Badge -->
                                <span class="aa-badge {{ $product->status === 'sold-out' ? 'aa-sold-out' : 'aa-hot' }}">
                                    {{ $product->status === 'sold-out' ? 'Sold Out!' : 'HOT!' }}
                                </span>
                            </li>
                        @endforeach
                    @else
                        <h2 class="text-dark">No trending products found.</h2>
                    @endif
                </ul>                                                                          
                 
                  <a class="aa-browse-btn" href="{{ route('shop.index')}}">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / featured product category -->



                <!-- start latest product category -->
                <div class="tab-pane fade" id="latest">
                  <ul class="aa-product-catg aa-latest-slider">
                    @if($newProducts->isNotEmpty())
                        @foreach($newProducts as $product)
                            <li>
                                <figure>
                                    <a class="aa-product-img" href="#"><img src="{{ asset('storage/' . $product->image) }}" style="width:250px; height:300px;" alt="{{ $product->name }} img"></a>
                                    <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="#">{{ $product->name }}</a></h4>
                                        <span class="aa-product-price">${{ number_format($product->price, 2) }}</span>
                                        @if($product->availability_status === 'sale')
                                            <span class="aa-product-price"><del>${{ number_format($product->original_price, 2) }}</del></span>
                                        @endif
                                    </figcaption>
                                </figure>
                                <div class="aa-product-hvr-content">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                    <a href="#" data-toggle="modal" data-target="#quick-view-modal" data-toggle="tooltip" data-placement="top" title="Quick View"><span class="fa fa-search"></span></a>
                                </div>
                                @if($product->stock > 0)
                                    <span class="aa-badge aa-sale">{{ $product->availability_status }}</span>
                                @else
                                    <span class="aa-badge aa-sold-out">Sold Out</span>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li>No products found.</li>
                    @endif
                </ul>
                
                   <a class="aa-browse-btn" href="{{ route('shop.index')}}">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                </div>
                <!-- / latest product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
    @include('store/components/product-modal', ['product'=> $product])
  </section>