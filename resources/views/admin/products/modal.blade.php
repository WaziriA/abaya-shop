<!-- Modal -->
<div class="modal fade" id="example1ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <form id="step-form-horizontal" class="step-form-horizontal" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                    <div>
                        <!-- Section 1: Image -->
<h4>Product Image</h4>
<section>
    <p class="text-primary"> Fill all details in these section</p>
    <div class="row d-flex justify-content-between">
        <div class="col-lg-4">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control" required accept="image/*">
        </div>
        <div class="col-md-4">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value=""></option>
                @foreach ($categories as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
                
            </select>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <img id="imagePreview" src="" alt="Image Preview" style="display: none; max-width: 100%; height: auto;" />
        </div>
    </div>
</section>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the uploaded file
        const reader = new FileReader(); // Create a FileReader object

        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result; // Set the image source to the uploaded file
            imagePreview.style.display = 'block'; // Show the image
        };

        if (file) {
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    });
</script>


                        <!-- Section 2: SKU, Category, Name, Description -->
                        <h4>Basic Information & Prices</h4>
                        <section>
                            <p class="text-primary"> Fill all details in these section</p>
                            <div class="row">
                                
                                
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="price_usd">Price(USD)</label>
                                    <input type="number" name="price_usd" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="price_gbp">Price(GBP)</label>
                                    <input type="number" name="price_gbp" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="price_eur">Price(Euro)</label>
                                    <input type="number" name="price_eur" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="price_aed">Price(AED)</label>
                                    <input type="number" name="price_aed" class="form-control" required>
                                </div>
                            </div>
                        </section>

                        <!-- Section 3: Brand, Color, Size, Price -->
                        <h4>Product Details</h4>
                        <section>
                            <p class="text-primary"> Fill all details in these section</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="color">Color</label>
                                    <input type="text" name="color" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="size">Size</label>
                                    <input type="text" name="size" class="form-control" required>
                                </div>
                               <!-- <div class="col-md-6">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>-->
                            </div>
                        </section>

                        <!-- Section 4: Stock, Availability Status, Status, Location -->
                        <h4>Inventory & Location</h4>
                        <section>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="stock">Stock</label>
                                    <input type="number" name="stock" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="availability_status">Availability Status</label>
                                    <select name="availability_status" class="form-control" required>
                                        <option value="in-stock">In Stock</option>
                                        <option value="out-of-stock">Out of Stock</option>
                                        <option value="low-stock">Low Stock</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="new">New</option>
                                        <option value="trending">Trending</option>
                                        <option value="sold-out">Sold Out</option>
                                        <option value="sale">Sale</option>
                                        <option value="hot">Hot</option>
                                        <option value="pupular">Popular</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="location">Location</label>
                                    <input type="text" name="location" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4" id="toastr-success-top-right" >Add Product</button>
                        </section>
                        <!-- Section 4: Stock, Availability Status, Status, Location 
                        <h4>Inventory & Location</h4>
                        <section>
                            last section
                        </section>-->
                    </div> 
                    
                </form>
                </div>
                <!--<button type="button" class="btn btn-dark mb-2 " id="toastr-success-top-right">Top
                    Right</button>-->
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    
                </div>
            
        </div>
    </div>
</div>


