
<div class="home-slider">
    <div class="main-slider">
        @if($carousels->isNotEmpty())
            @foreach($carousels as $carousel)
                <div class="main-slider-item">
                    <img src="{{ asset('storage/' . $carousel->photo) }}" alt="Carousel Image" style="width:1000px; height:450px;" />
                </div>
            @endforeach
        @else
            <div class="no-carousel-data">
                <p style="font-family: nabi;">No carousel data found. Please check back later!</p>
            </div>
        @endif
    </div>
</div>
<!-- Main Slider End -->
{{--
<div class="home-slider">
    <div class="main-slider">
        <div class="main-slider-item"><img src="{{ asset('new/img/slider-1.jpg')}}" alt="Slider Image" /></div>
        <div class="main-slider-item"><img src="{{ asset('new/img/slider-2.jpg')}}" alt="Slider Image" /></div>
        <div class="main-slider-item"><img src="{{ asset('new/img/slider-3.jpg')}}" alt="Slider Image" /></div>
    </div>
</div>--}}