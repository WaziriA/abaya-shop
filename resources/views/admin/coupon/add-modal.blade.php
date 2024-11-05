<!-- Modal -->
<div class="modal fade" id="AddCouponModalCenter" tabindex="-1" role="dialog" aria-labelledby="AddCouponModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddCouponModalCenterTitle">Create a Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                   <div class="card">
                    <div class="card-body">
                        <form action="{{ route('coupons.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Coupon Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="type" class="form-label">Coupon Type</label>
                                <select class="form-select" name="type" required>
                                    <option value="fixed">Fixed Amount</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                    
                            <div class="mb-3">
                                <label for="discount_value" class="form-label">Discount Value</label>
                                <input type="number" class="form-control" name="discount_value" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="expires_at" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" name="expires_at" required>
                            </div>
                    
                            <div class="mb-3">
                                <input type="checkbox" id="assign_users" onclick="toggleUserList()">
                                <label for="assign_users" class="form-label">Assign to Users</label>
                            </div>
                    
                            <div id="userList" style="display: none;">
                                <label for="users" class="form-label">Select Users</label>
                                <div>
                                    @foreach($customers as $customer)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{ $customer->id }}" id="user_{{ $customer->id }}">
                                            <label class="form-check-label" for="user_{{ $customer->id }}">
                                                {{ $customer->name }} ({{ $customer->email }}, {{ $customer->phone_no }}, {{ $customer->country }})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    
                            <button type="submit" class="btn btn-primary">Create Coupon</button>
                        </form>
                    </div>
                    
                    <script>
                        function toggleUserList() {
                            const userList = document.getElementById('userList');
                            const checkbox = document.getElementById('assign_users');
                            userList.style.display = checkbox.checked ? 'block' : 'none';
                        }
                    </script>
                    </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    
                </div>
            
        </div>
    </div>
</div>