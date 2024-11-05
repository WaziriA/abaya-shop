<!-- Modal -->
<div class="modal fade" id="AddSubscriberModel" tabindex="-1" role="dialog" aria-labelledby="AddSubscriberModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddSubscriberModel">Update Product stocks Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                   <div class="card">
                    <div class="card-body">
                        <form action="{{ route('subscribers.store')}}" method="POST">
                            @csrf
                            
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Subscriber name here" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" class="form-control" placeholder="Enter subscriber email here" required>
                                    
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm mt-4">Add Subscriber</button>
                        </form>
                    </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
                    
                </div>
            
        </div>
    </div>
</div>