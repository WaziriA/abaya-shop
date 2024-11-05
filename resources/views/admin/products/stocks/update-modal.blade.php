<!-- Modal -->
<div class="modal fade" id="UpdateStockModalCenter{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="UpdateStockModalCenterTitle{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateStockModalCenterTitle{{ $product->id }}">Update Product stocks Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                   <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product.updateStock', $product->id) }}" method="POST">
                            @csrf
                            
                            <div class="d-flex justify-content-between">
                                <div class="col-md-8">
                                    <input type="number" name="stock" class="form-control" placeholder="Enter amount to add to stock" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-sm">Add Stocks</button>
                                </div>
                            </div>
                        </form>
                    </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    
                </div>
            
        </div>
    </div>
</div>