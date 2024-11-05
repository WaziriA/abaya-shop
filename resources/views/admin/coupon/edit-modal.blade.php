<!-- Modal -->
<div class="modal fade" id="EditCouponModalCenter{{ $coupon->id }}" tabindex="-1" role="dialog" aria-labelledby="EditCouponModalCenterTitle{{ $coupon->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="EditCouponModalCenterTitle{{ $coupon->id }}">Update Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <div class="form-group">
                        <label for="name">Coupon Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $coupon->name }}" >
                    </div>

                    <div class="form-group">
                        <label for="type">Coupon Type</label>
                        <select class="form-control" name="type" id="type" >
                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="discount_value">Discount Value</label>
                        <input type="number" class="form-control" name="discount_value" id="discount_value" value="{{ $coupon->discount_value }}" min="0" >
                    </div>

                    <div class="form-group">
                        <label for="expires_at">Expiry Date</label>
                        <input type="date" class="form-control" name="expires_at" id="expires_at" value="{{ $coupon->expires_at }}" >
                    </div>
                    <div class="form-group">
                        <label for="user_ids">Assign to Customers</label>
                        <select class="form-control" name="user_ids[]" id="user_ids" multiple style="max-height: 200px; overflow-y: auto;">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $coupon->users->contains($customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Select customers to assign this coupon.</small>
                    </div>
                    

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
