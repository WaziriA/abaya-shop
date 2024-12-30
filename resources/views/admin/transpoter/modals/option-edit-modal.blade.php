<!-- Modal -->
<div class="modal fade" id="UpdateShipmentModalCenter{{ $shipment->id }}" tabindex="-1" role="dialog" aria-labelledby="UpdateShipmentModalCenterTitle{{ $shipment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateShipmentModalCenterTitle{{ $shipment->id }}">Update category stocks Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                   <div class="card">
                    <div class="card-body">

                        <form action="{{ route('shipment.update', $shipment->id)}}" method="POST">
                            @csrf
                            
                            <div class="row d-flex justify-content-between">
                              <input type="text" id="method_name" name="method_name" class="form-control" placeholder="Enter Agent Name" required>
                              <button type="submit" class="btn btn-primary btn-sm ms-4">Update</button>
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