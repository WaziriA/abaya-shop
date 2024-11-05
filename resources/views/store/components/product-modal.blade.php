<!-- Large Size -->
<div class="modal fade" id="QuickViewModal{{ $product->id}}" tabindex="-1" role="dialog" aria-labelledby="QuickViewModalModal{{ $product->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="QuickViewModalLabel{{ $product->id}}">Product Specifications</h4>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <div class="row">
                        
                        <!-- Modal view slider -->
                        <div class="col-md-6 col-sm-6 col-xs-12">                              
                          <div class="aa-product-view-slider">                                
                            <div class="simpleLens-gallery-container" id="demo-1">
                              <div class="simpleLens-container">
                                  <div class="simpleLens-big-image-container">
                                      <a class="simpleLens-lens-image" data-lens-image="{{ asset('material/img/view-slider/large/polo-shirt-1.png')}}">
                                        <img src="{{ asset('storage/' . $product->image) }}" style="width: 250px; height: 300px;" class="simpleLens-big-image" alt="{{ $product->name }}">
                                      </a>
                                  </div>
                              </div>
                          <!--    <div class="simpleLens-thumbnails-container">
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-1.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-1.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                                  </a>                                    
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-3.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-3.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                                  </a>

                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-4.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-4.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                                  </a>
                              </div>-->
                            </div>
                          </div>
                        </div>


                        <!-- Modal view content -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="aa-product-view-content">
                            <h3>{{ $product->name}}</h3>
                            <div class="aa-price-block">
                              <span class="aa-product-view-price">${{ $product->price}}</span>
                              <p class="aa-product-availability">
                                Availability: 
                                <span class="{{ $product->availability_status === 'in-stock' ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ ucfirst($product->availability_status) }}</strong>
                                </span>
                            </p>
                            </div>

                            <p>{{ $product->description}}</p>
                            
                            <h4>Choose Size</h4>
                            <div class="aa-prod-view-size">
                              <a href="#">S</a>
                              <a href="#">M</a>
                              <a href="#">L</a>
                              <a href="#">XL</a>
                              <a href="#">XXL</a>
                              <a href="#">XXXL</a>
                            </div>

                            <div class="aa-prod-quantity mt-2">
                              <form action="">
                                <select name="" id="">
                                  <option value="0" selected="1">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <option value="3">4</option>
                                  <option value="4">5</option>
                                  <option value="5">6</option>
                                </select>
                              </form>
                              <p class="aa-prod-category">
                                Category: <a href="#">{{ $product->category->name}}</a>
                              </p>
                            </div>
                            <div class="aa-prod-view-bottom">
                              <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                              <a href="#" class="aa-add-to-cart-btn">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            
        </div>
    </div>
</div>
