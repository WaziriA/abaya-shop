<!-- Subscribe section -->
{{--<section id="aa-subscribe">
  <div class="container">
      <div class="row">
          <div class="col-md-12">
              <div class="aa-subscribe-area">
                <h5>Stay Updated with Our Latest News!</h5>
                <p>Subscribe to our newsletter and be the first to know about exclusive offers, exciting updates, and more. Join our community today!</p>
                

                  <!-- Form to subscribe -->
                  <form action="{{ route('subscriber.store') }}" method="POST" class="aa-subscribe-form">
                      @csrf <!-- CSRF token for security -->
                      
                      <div class="row d-flex justify-content-between">
                        <!-- Name input -->
                        <div class="input-container">
                            <input type="text" name="name" id="name" placeholder="Enter your Name" required>
                        </div>
                    
                        <!-- Email input -->
                        <div class="input-container">
                            <input type="email" name="email"  placeholder="Enter your Email" required>
                        </div>
                      
                      
                        <!-- Subscribe button -->
                        <div class="input-container">
                            <input type="submit" value="Subscribe">
                        </div>
                    </div>
                    
                  </form>

                  
              </div>
          </div>
      </div>
  </div>
  
<style>
    /* Custom CSS */
.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 5px; /* Reduce gap between input fields */
}

.input-container {
    flex-grow: 1;
    max-width: 30%;
}

input[type="text"], 
input[type="email"], 
input[type="submit"] {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Media query for small screens */
@media (max-width: 760px) {
    .row {
        flex-direction: column; /* Stack input fields vertically on small screens */
    }

    .input-container {
        max-width: 100%; /* Allow full width on small screens */
    }

    input[type="submit"] {
        display: block;
        width: 100%; /* Make submit button full width */
    }
}

</style>


</section>--}}

<!-- Newsletter Start -->
<div class="newsletter">
    <div class="container">
        <div class="section-header">
            <h3>Stay Updated with Our Latest News!r</h3>
            <p>
                Subscribe to our newsletter and be the first to know about exclusive offers, exciting updates, and more. Join our community today!
            </p>
        </div>
        <div class="form"> 

        <!-- Form to subscribe -->
          <form action="{{ route('subscriber.store') }}" method="POST" class="aa-subscribe-form">
            @csrf <!-- CSRF token for security -->
            <div class="row d-grid d-md-flex d-block justify-content-between">
                        <!-- Name input -->
                        <div class="input-container">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your Name" required>
                        </div>
                    
                        <!-- Email input -->
                        <div class="input-container">
                            <input type="email" name="email" class="form-control" placeholder="Enter your Email" required>
                        </div>
                      
                      
                        <!-- Subscribe button -->
                        <div class="mt-4">
                            <input type="submit" class="btn btn-peimary text-white" value="Subscribe">
                        </div>
                </div>
          </form>
        </div>
    </div>
</div>
<!-- Newsletter End -->