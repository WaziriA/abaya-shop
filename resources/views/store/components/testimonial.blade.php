<!-- Testimonial -->
<section id="aa-testimonial">  
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-testimonial-area">
            <ul class="aa-testimonial-slider">
              <!-- Check if there are any testimonials -->
              @if($testimonials->isEmpty())
              <li>
                <div class="aa-testimonial-single">
                <img class="aa-testimonial-img" src="{{asset('assets/images/avatar/1.png') }}" alt="testimonial img">
                  <span class="fa fa-quote-left aa-testimonial-quote"></span>
                  <p></p>
                  <div class="aa-testimonial-info">
                    <p></p>
                    <span></span>
                    <a href="#">No Testimonial</a>
                  </div>
                </div>
              </li>
              @else
                  <!-- Loop through the testimonials if available -->
                  @foreach($testimonials as $testimonial)
                      <li>
                          <div class="aa-testimonial-single">
                              <!-- Testimonial Image -->
                              <img class="aa-testimonial-img" 
                                   src="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : asset('assets/images/avatar/1.png') }}" 
                                   alt="testimonial img">
          
                              <!-- Quote Icon -->
                              <span class="fa fa-quote-left aa-testimonial-quote"></span>
          
                              <!-- Testimonial Description -->
                              <p>{{ $testimonial->description }}</p>
          
                              <!-- Testimonial Info -->
                              <div class="aa-testimonial-info">
                                  <!-- Testimonial Name -->
                                  <p>{{ $testimonial->name }}</p>
          
                                  <!-- Testimonial Specialization (optional) -->
                                  <span>{{ $testimonial->specialization ?? 'Specialization not provided' }}</span>
          
                                  <!-- Testimonial Company (optional) -->
                                  <a href="#">{{ $testimonial->company ?? 'Company not provided' }}</a>
                              </div>
                          </div>
                      </li>
                  @endforeach
              @endif
          </ul>
          
          </div>
        </div>
      </div>
    </div>

    
  </section>