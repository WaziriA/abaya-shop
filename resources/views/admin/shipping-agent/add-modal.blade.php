<!-- Large Size -->
<div class="modal fade" id="AddAgentModalCenter" tabindex="-1" role="dialog" aria-labelledby="AddAgentModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="AddAgentModalCenterLabel">Add Shipping Costs</h4>
            </div>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body">
<!-- Store Form: admin/shipping-agent/create.blade.php -->
<form action="{{ route('agent.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Transporter Selection -->
    <div class="form-group">
        <label for="transpoter_id">Transporter</label>
        <select name="transpoter_id" id="transpoter_id" class="form-control text-dark" required>
            <option value="">Select Shipping Agent</option>
            @foreach($transpoters as $transpoter)
                <option class="text-dark" value="{{ $transpoter->id }}" style="color: black;">{{ $transpoter->transpoter_name ?? 'NA'}}</option>
            @endforeach
        </select>
        
        @error('transpoter_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    
    <!-- Shipment Method -->
<div class="form-group">
    <label for="shipment_method_id">Shipment Method</label>
    <select name="shipment_method_id" id="shipment_method_id" class="form-control" required>
        <option value="">Select Shipment Method</option>
        @foreach($shipmentMethods as $method)
            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
        @endforeach
    </select>
    @error('shipment_method_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Destination Country -->
<div class="form-group">
    <label for="destination_country_id">Destination Country</label>
    <select name="destination_country_id" id="destination_country_id" class="form-control" required>
        <option value="">Select Destination Country</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
        @endforeach
    </select>
    @error('destination_country_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

    <!-- From Location -->
    <div class="form-group">
        <label for="from">From</label>
        <input type="number" name="from" id="from" class="form-control" required>
        @error('from')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- To Location -->
    <div class="form-group">
        <label for="to">To</label>
        <input type="number" name="to" id="to" class="form-control" required>
        @error('to')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Cost -->
    <div class="form-group">
        <label for="cost">Cost</label>
        <input type="number" step="0.01" name="cost" id="cost" class="form-control" required>
        @error('cost')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Add Shipping Cost</button>
    </div>
</form>

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