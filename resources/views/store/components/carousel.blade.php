 <!-- Start slider -->
 <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            @if($carousels->isNotEmpty())
                @foreach($carousels as $carousel)
                    <li>
                        <div class="seq-model">
                            <img data-seq src="{{ asset('storage/' . $carousel->photo) }}" alt="Slide Image" style="width:1920px; height:700px;"/>
                        </div>
                        <div class="seq-title">
                            <span data-seq>{{ $carousel->up }}</span>                
                            <h2 data-seq>{{ $carousel->middle }}</h2>                
                            <p data-seq>{{ $carousel->description }}</p>
                            <a data-seq href="{{ route('shop.index') }}" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                        </div>
                    </li>
                @endforeach
            @else
                <!-- Default slide items -->
                <li>
                    <div class="seq-model">
                        <img data-seq src="{{ asset('material/img/slider/abaya.jpg')}}" alt="Men slide img" />
                    </div>
                    <div class="seq-title">
                        <span data-seq>Save Up to 75% Off</span>                
                        <h2 data-seq>Women Abaya Collection</h2>                
                        <p data-seq>Flash Sale Alert! Score Trendy Outfits with Discounts Up to 40%!"</p>
                        <a data-seq href="{{ route('shop.index')}}" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                    </div>
                </li>
                <li>
                    <div class="seq-model">
                        <img data-seq src="{{ asset('material/img/slider/abaya2.jpg')}}" alt="Wristwatch slide img" />
                    </div>
                    <div class="seq-title">
                        <span data-seq>Save Up to 40% Off</span>                
                        <h2 data-seq>Upgrade Your Wardrobe</h2>                
                        <p data-seq>New Looks for Less! Grab 20% Off on All Clothing Purchases Today.</p>
                        <a data-seq href="{{ route('shop.index')}}" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                    </div>
                </li>
            @endif
        </ul>
        
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>