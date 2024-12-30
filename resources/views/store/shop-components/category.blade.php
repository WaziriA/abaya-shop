 <!-- product category -->
 {{-- <section id="aa-product-category"> 
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-left">
                <form action="" class="aa-sort-form">
                  <label for="">Sort by</label>
                  <select name="">
                    <option value="1" selected="Default">Default</option>
                    <option value="2">Name</option>
                    <option value="3">Price</option>
                    <option value="4">Date</option>
                  </select>
                </form>
                <form action="" class="aa-show-form">
                  <label for="">Show</label>
                  <select name="">
                    <option value="1" selected="12">12</option>
                    <option value="2">24</option>
                    <option value="3">36</option>
                  </select>
                </form>
              </div>
              <div class="aa-product-catg-head-right .aa-product-catg.list li ">
                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
              </div>
            </div>

            <div class="aa-product-catg-body">
               <ul class="aa-product-catg">
                  @if ($products->isNotEmpty())
                <!-- start single product item -->
                <!-- Loop through all products -->
                   @foreach ($products as $product)
                     <li>
                         <figure>
                             <!-- Product Image -->
                              <a class="aa-product-img" href="#"><img style="width:250px; height:300px;" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"></a>

                               <!-- Add to Cart Button -->
                                <form id="add-to-cart-form-{{ $product->id }}" data-url="{{ route('cart.add', $product->id) }}">
                                  @csrf
                                 <button type="button" class="aa-add-card-btn" onclick="addToCart({{ $product->id }})">
                                       <span class="fa fa-shopping-cart"></span>
                                       <span class="loading-message" style="display: none;"> Adding...</span> <!-- Loading message -->
                                       <span class="spinner" style="display: none;">⏳</span> <!-- Loading spinner -->
                                       <span class="normal-message">Add To Cart</span> <!-- Normal message -->
                                  </button>
        
                                 </form>

                           <figcaption>
                           <!-- Product Title -->
                                <h4 class="aa-product-title"><a href="#">{{ $product->name }}</a></h4>

                               <!-- Product Price -->
                                <span class="aa-product-price">${{ number_format($product->price, 2) }}</span>
            
                                <!-- Product Old Price (if any) -->
                                @if ($product->price != $product->original_price)
                                     <span class="aa-product-price"><del>${{ number_format($product->original_price, 2) }}</del></span>
                                 @endif

                                   <!-- Product Description -->
                                          <p class="aa-product-descrip">{{ Str::limit($product->description, 100) }}</p>
                            </figcaption>
                         </figure>                         

                            <div class="aa-product-hvr-content">
                                 <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                 <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                 <a href="#" data-toggle="modal" data-target="#QuickViewModal{{ $product->id}}" data-toggle="tooltip" data-placement="top" title="Quick View"><span class="fa fa-search"></span></a>                          
                           </div>

                                    <!-- Product Badge (Optional) -->
                                   @if ($product->status == 'new')
                                          <span class="aa-badge aa-sale" href="#">NEW!</span>
                                   @elseif($product->status == 'hot')
                                          <span class="aa-badge aa-hot" href="#">HOT</span>
                                   @endif
                      </li>
                            @include('store/components/product-modal', ['product'=> $product])
                            @endforeach
               </ul>
                      @else
                           <div><h3>No Product is Found</h3></div>
                           
                      @endif
              
            </div>

            
            <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div><!--End of Products components-->
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Category</h3>
              <ul class="aa-catg-nav">
                @foreach ($categories as $item)
                    
                
                <li><a href="#">{{$item->name}}</a></li>
                
                @endforeach
              </ul>
            </div>

            <!-- single sidebar 
            <div class="aa-sidebar-widget">
              <h3>Tags</h3>
              <div class="tag-cloud">
                <a href="#">Fashion</a>
                <a href="#">Ecommerce</a>
                <a href="#">Shop</a>
                <a href="#">Hand Bag</a>
                <a href="#">Laptop</a>
                <a href="#">Head Phone</a>
                <a href="#">Pen Drive</a>
              </div>
            </div>-->

            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Shop By Price</h3>              
              <!-- price range -->
              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <span id="skip-value-lower" class="example-val">30.00</span>
                 <span id="skip-value-upper" class="example-val">100.00</span>
                 <button class="aa-filter-btn" type="submit">Filter</button>
               </form>
              </div>              

            </div>

            <!-- single sidebar 
            <div class="aa-sidebar-widget">
              <h3>Shop By Color</h3>
              <div class="aa-color-tag">
                <a class="aa-color-green" href="#"></a>
                <a class="aa-color-yellow" href="#"></a>
                <a class="aa-color-pink" href="#"></a>
                <a class="aa-color-purple" href="#"></a>
                <a class="aa-color-blue" href="#"></a>
                <a class="aa-color-orange" href="#"></a>
                <a class="aa-color-gray" href="#"></a>
                <a class="aa-color-black" href="#"></a>
                <a class="aa-color-white" href="#"></a>
                <a class="aa-color-cyan" href="#"></a>
                <a class="aa-color-olive" href="#"></a>
                <a class="aa-color-orchid" href="#"></a>
              </div>                            
            </div>-->


            <!-- single sidebar -->
            <div class="aa-sidebar-widget mt-4">
              <h3>Recently Views</h3>
              <div class="aa-recently-views">
                <ul class="aa-cartbox">
                  @if ($latestProducts->isEmpty())
                      <li>No data found</li>
                  @else
                      @foreach ($latestProducts as $product)
                          <li>
                              <a href="#" data-toggle="modal" data-target="#QuickViewModal{{ $product->id}}" data-toggle="tooltip" data-placement="top" title="Quick View" class="aa-cartbox-img">
                                  <img alt="{{ $product->name }}" src="{{ asset('storage/' . $product->image) }}">
                              </a>
                              <div class="aa-cartbox-info">
                                  <h4><a href="#" data-toggle="modal" data-target="#QuickViewModal{{ $product->id}}" data-toggle="tooltip" data-placement="top" title="Quick View">{{ $product->name }}</a></h4>
                                  <p>1 x ${{ number_format($product->price, 2) }}</p>
                              </div>
                          </li>
                      @endforeach
                  @endif
              </ul>
              
              </div>                            
            </div>

            <!-- single sidebar -->
          <!--  <div class="aa-sidebar-widget">
              <h3>Top Rated Products</h3>
              <div class="aa-recently-views">
                <ul>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                   <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>                                      
                </ul>
              </div>                            
            </div>-->

          </aside>
        </div>
       
      </div>
    </div>
  </section> --}}
 <!-- / product category -->
 <!-- Product List Start -->
 <div class="product-view">
     <div class="container">
         <div class="row">
             <div class="col-md-9">
                 <div class="row">
                     <!-- Search and Sort -->
                     <div class="col-lg-12">
                         <div class="row">
                             <div class="col-md-8">
                                 <div class="product-search">
                                     <input type="text" placeholder="Search">
                                     <button><i class="fa fa-search"></i></button>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <div class="product-short">
                                     <div class="dropdown">
                                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">Product short
                                             by</a>
                                         <div class="dropdown-menu dropdown-menu-right">
                                             <a href="#" class="dropdown-item">Newest</a>
                                             <a href="#" class="dropdown-item">Popular</a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <!-- Products Grid -->
                     @foreach ($products as $product)
                         <div class="col-lg-4 d-none d-md-block">
                             <div class="product-item">
                                 <div class="product-image">
                                     <a href="{{ route('single-detail.index', $product->id) }}">
                                         <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                             style="height: 322px;  ">
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
                                     <div class="title"><a
                                             href="{{ route('single-detail.index', $product->id) }}">{{ $product->name }}</a>
                                     </div>
                                     <div class="ratting">
                                         @for ($i = 0; $i < 5; $i++)
                                             <i
                                                 class="fa fa-star {{ $i < $product->rating ? 'text-warning' : '' }}"></i>
                                         @endfor
                                     </div>
                                     <div class="price">{{ $currency }}
                                         {{ number_format($product->price, 2) }}</span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @include('store.components.product-modal', ['product' => $product])
                     @endforeach


                     <!-- Product Container for Small Screens -->
                     <div class="container d-block d-md-none mt-4">
                         <div class="row">
                             @foreach ($products as $product)
                                 <div class="col-6 d-flex mb-3">
                                     <div class="product-card w-100">
                                         <div class="d-flex justify-content-between p-2">
                                             <div>
                                              <div style="position: relative;">
                                                 <div class="discount-badge">
                                                     <span
                                                         class="aa-badge {{ $product->status === 'sold-out' ? 'aa-sold-out' : 'aa-sale' }}">
                                                         {{ $product->status === 'sold-out' ? 'Sold Out!' : 'SALE!' }}
                                                     </span>
                                                 </div>
                                             </div>
                                             <div>
                                                 <div class="wishlist-icon">
                                                  <form id="add-to-wishlist-form-{{ $product->id }}"
                                                    action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="javascript:void(0);" onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                                  click 
                                                </a>

                                              {{--   <form id="add-to-wishlist-form-{{ $product->id }}"
                                                  action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                  style="display: none;">
                                                  @csrf
                                             </form>
                                              <a href="javascript:void(0);"
                                                  onclick="document.getElementById('add-to-wishlist-form-{{ $product->id }}').submit();">
                                                  <i class="fa fa-heart"></i>
                                              </a>--}}

                                              </div>
                                             </div>
                                         </div>
                                         </div>
                                         <a href="{{ route('single-detail.index', ['id' => $product->id]) }}"> <img
                                                 src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                                                 alt="{{ $product->name }}" style="width: 230px; height:200px"></a>
                                         <div class="product-details p-2">
                                             <a href="{{ route('single-detail.index', ['id' => $product->id]) }}">
                                                 <h4 class="product-orders mb-1">{{ $product->name }} </h4>
                                             </a>
                                             <a href="{{ route('single-detail.index', ['id' => $product->id]) }}">
                                                 <h5 class="mb-1">{{ $currency }}
                                                     {{ number_format($product->price, 2) }}</h5>
                                                 <p class="product-orders mb-1">{{ $product->orders->count() }} orders
                                                 </p>
                                                 <p class="product-rating mb-0">★ {{ $product->rating }}</p>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                     <!-- Pagination -->
                     <div class="col-lg-12">
                         <nav aria-label="Page navigation example">
                             <ul class="pagination justify-content-center">
                                 {{ $products->links('pagination::bootstrap-4') }}
                             </ul>
                         </nav>
                     </div>
                 </div>
             </div>
             <div class="col-md-3">
                 <div class="sidebar-widget category">
                     <h2 class="title">Category</h2>
                     <ul>
                         @foreach ($categories as $item)
                             <li>
                                 <a href="#">{{ $item->name }}</a>

                             </li>
                         @endforeach
                     </ul>
                 </div>

                 <div class="sidebar-widget image ">
                     <h2 class="title">Featured Product</h2>
                 </div>
                 <div class="sidebar-widget image product-slider product-slider-3">
                     @foreach ($products as $product)
                         <a href="#">
                             <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                                 alt="{{ $product->name }}" style="height: 300px; width: 400px">
                         </a>
                     @endforeach
                 </div>

                 <!--   <div class="sidebar-widget brands">
                     <h2 class="title">Our Brands</h2>
                     <ul>
                         <li><a href="#">Nulla </a><span>(45)</span></li>
                         <li><a href="#">Curabitur </a><span>(34)</span></li>
                         <li><a href="#">Nunc </a><span>(67)</span></li>
                         <li><a href="#">Ullamcorper</a><span>(74)</span></li>
                         <li><a href="#">Fusce </a><span>(89)</span></li>
                         <li><a href="#">Sagittis</a><span>(28)</span></li>
                     </ul>
                 </div>-->

                 <!--  <div class="sidebar-widget tag">
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
 <!-- Product List End -->
