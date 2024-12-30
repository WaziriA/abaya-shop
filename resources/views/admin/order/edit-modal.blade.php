<!-- Modal -->
<div class="modal fade" id="UpdateOrderModalCenter{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="UpdateOrderModalCenterTitle{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateOrderModalCenterTitle{{ $order->id }}">Update Order stocks Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                   <div class="card">
                    <div class="card-body">
                        <form action="{{ route('orders.updateShippingStatus', $order->id) }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <select name="shipping_status" class="form-control" required>
                                        <option value="">Select Shipping Status</option>
                                        <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->shipping_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipping" {{ $order->shipping_status == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                        <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-sm mt-4">Update Shipping Status</button>
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