<!-- Modal -->
<div class="modal fade" id="UpdateProductModalCenter{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="UpdateProductModalCenterTitle{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateProductModalCenterTitle{{ $product->id }}">Update Product Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            
                            <h4>Product Image</h4>
                                <div class="row d-flex justify-content-between mb-4">
                                    <div class="col-lg-4">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*" value="{{ old('image')}}">
                                    </div>
                                    <div class="col-lg-8">
                                        <img id="imagePreview" src="" alt="Image Preview" style="display: none; max-width: 100%; height: auto;" />
                                    </div>
                                </div>
                            
    
                                <h4>Basic Information</h4>
                                <div class="row mt-2 mb-4">
                                    <div class="col-md-6">
                                        <label for="sku">SKU</label>
                                        <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value=""></option>
                                            @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            
    
                                <h4>Product Details</h4>
                                <div class="row mt-2 mb-4">
                                    <div class="col-md-6">
                                        <label for="brand">Brand</label>
                                        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="color">Color</label>
                                        <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="size">Size</label>
                                        <input type="text" name="size" class="form-control" value="{{ old('size') }}">
                                    </div>
                                    
                                </div>
                            
                                <h4>Product Prices</h4>
                                <div class="row mt-2 mb-4">
                                    <div class="col-md-6">
                                        <label for="price_usd">Price(USD)</label>
                                        <input type="number" name="price_usd" class="form-control" value="{{ old('brand') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price_gbp">Price(GPB)</label>
                                        <input type="number" name="price_gbp" class="form-control" value="{{ old('color') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price_eur">Price(Euro)</label>
                                        <input type="number" name="price_eur" class="form-control" value="{{ old('size') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price_aed">Price(AED)</label>
                                        <input type="number" step="0.01" name="price_aed" class="form-control" value="{{ old('price') }}">
                                    </div>
                                </div>

                                <h4>Inventory & Location</h4>
                                <div class="row mt-2 mb-4">
                                    <div class="col-md-6">
                                        <label for="stock">Stock</label>
                                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="availability_status">Availability Status</label>
                                        <select name="availability_status" class="form-control">
                                            <option value="in-stock" {{ old('availability_status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                                            <option value="out-of-stock" {{ old('availability_status') == 'out-of-stock' ? 'selected' : '' }}>Out of Stock</option>
                                            <option value="low-stock" {{ old('availability_status') == 'low-stock' ? 'selected' : '' }}>Low Stock</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                                            <option value="trending" {{ old('status') == 'trending' ? 'selected' : '' }}>Trending</option>
                                            <option value="sold-out" {{ old('status') == 'sold-out' ? 'selected' : '' }}>Sold Out</option>
                                            <option value="sale" {{ old('status') == 'sale' ? 'selected' : '' }}>Sale</option>
                                            <option value="hot" {{ old('status') == 'hot' ? 'selected' : '' }}>Hot</option>
                                            <option value="popular" {{ old('status') == 'popular' ? 'selected' : '' }}>Popular</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                                    </div>
                                </div>
                            </section>
                        </div> 
                        <button type="submit" class="btn btn-primary mt-2">Save changes</button>
                    </form>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    
                </div>
            
        </div>
    </div>
</div>

