@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Shipping Agents</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Shipping</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                </ol>
            </div>
        </div>

        <!--Agent Names-->
<div class="row d-flex justify-content-between">
    <!-- table-->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Agent names</h4>
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Names</th>
                                
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transpoters as $transpoter)
                                
                            
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $transpoter->transpoter_name  }}</td>
                                
                                
                                <td>
                                    <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#UpdateTranspoterModalCenter{{ $transpoter->id }}"></button>
                                    <button class="btn btn-warning fa fa-archive text-white" onclick="confirmAgentSoftDelete({{ $transpoter->id }})" title="Move to Trash"></button>

                                    <!-- Permanent Delete Button -->
                                    <button class="btn btn-danger fa fa-trash text-white" onclick="confirmAgentHardDelete({{ $transpoter->id }})" title="Delete permanently"></button>
                                    
                                    <!-- Form for Soft Delete -->
                                    <form id="soft-delete-form-{{ $transpoter->id }}" action="{{ route('transpoter.destroy', $transpoter->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    
                                    <!-- Form for Permanent Delete -->
                                    <form id="hard-delete-form-{{ $transpoter->id }}" action="{{ route('transpoter.forceDelete', $transpoter->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                            @include('admin/transpoter/update-modal')
                            @endforeach
                           
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                
                                
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!--Category Form-->
<div class="col-lg-4 ">
    <div class="card">
        <div class="card-header d-block">
            <h4 class="card-title">Add Agent</h4>
            
        </div>
        <div class="card-body">
            <div id="accordion-two" class="accordion accordion-bordered">
                <div class="accordion__item">
                    <div class="accordion__header" data-toggle="collapse" data-target="#bordered_collapseOne"> <span class="accordion__header--text">Click here to show or hide the form</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div id="bordered_collapseOne" class="collapse accordion__body show" data-parent="#accordion-two">
                        <div class="accordion__body--text">
                           <form action="{{ route('transpoter.store')}}" method="POST">
                            @csrf
                            <label for="name">Name:</label>
                            <input type="text" name="transpoter_name" id="transpoter_name" class="form-control mb-4" required>

                            

                            <button class="btn btn-primary btn-sm" type="submit">Add</button>
                           </form>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>
</div><!--End Of-->



<!-- Shipping Option -->
<div class="row d-flex justify-content-between">
    <!-- Table -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Shipping Options</h4>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Names</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipments as $shipment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $shipment->method_name }}</td>
                                <td>
                                    <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#UpdateShipmentModalCenter{{ $shipment->id }}"></button>
                                    

                                    <!-- Permanent Delete Button -->
                                    <button class="btn btn-danger fa fa-trash text-white" onclick="confirmAgentHardDelete({{ $shipment->id }})" title="Delete permanently"></button>
                                    
                                    
                                    
                                    <!-- Form for Permanent Delete -->
                                    <form id="hard-delete-form-{{ $shipment->id }}" action="{{ route('shipment.delete', $shipment->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @include('admin.transpoter.modals.option-edit-modal', ['shipment_id' => $shipment->id])
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Form -->
    <!-- Category Form -->
<div class="col-lg-4">
    <div class="card">
        <div class="card-header d-block">
            <h4 class="card-title">Add Shipping Option</h4>
        </div>
        <div class="card-body">
            <div id="accordion-two" class="accordion accordion-bordered">
                <div class="accordion__item">
                    <div class="accordion__header" data-toggle="collapse" data-target="#bordered_collapseOne">
                        <span class="accordion__header--text">Click here to show or hide the form</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div id="bordered_collapseOne" class="collapse accordion__body show" data-parent="#accordion-two">
                        <div class="accordion__body--text">
                            <!-- Form to Add Shipment Method -->
                            <form action="{{ route('shipment-method.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="transporter_name">Shipping Method Name:</label>
                                    <input type="text" name="method_name" id="method_name" class="form-control mb-4" required>
                                    @error('method_name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary btn-sm" type="submit">Add Shipping Option</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Of Category Form -->
<!-- End Of -->
</div><!-- End of Shipping -->


<!--Destination country-->
<div class="row d-flex justify-content-between">
    <!-- table-->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Delivery Countries</h4>
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="example" class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Names</th>
                                
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                                
                            
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $country->country_name  }}</td>
                                
                                
                                <td>
                                    <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#UpdatecountryModalCenter{{ $country->id }}"></button>
                                    

                                   <!-- Permanent Delete Button -->
                                    <button class="btn btn-danger fa fa-trash text-white" onclick="confirmAgentHardDelete({{ $country->id }})" title="Delete permanently"></button>

                                     <!-- Form for Permanent Delete -->
                                     <form id="hard-delete-form-{{ $country->id }}" action="{{ route('deleteDestinationCountry', $country->id) }}" method="POST" style="display: none;">
                                        @csrf
                                      @method('DELETE')
                                     </form>


                                </td>
                            </tr>
                            @include('admin.transpoter.modals.country-edit-modal', ['country_id' => $country->id])
                            @endforeach
                           
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                
                                
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!--Category Form-->
<div class="col-lg-4 ">
    <div class="card">
        <div class="card-header d-block">
            <h4 class="card-title">Add Delivery Country</h4>
            
        </div>
        <div class="card-body">
            <div id="accordion-two" class="accordion accordion-bordered">
                <div class="accordion__item">
                    <div class="accordion__header" data-toggle="collapse" data-target="#bordered_collapseOne"> <span class="accordion__header--text">Click here to show or hide the form</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div id="bordered_collapseOne" class="collapse accordion__body show" data-parent="#accordion-two">
                        <div class="accordion__body--text">
                           <form action="{{ route('storeDestinationCountry')}}" method="POST">
                            @csrf
                            <label for="name">Name:</label>
                            <input type="text" name="country_name" id="country_name" class="form-control mb-4" required>

                            

                            <button class="btn btn-primary btn-sm" type="submit">Add</button>
                           </form>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>
</div><!--End Of-->

</div>
</div>
@endsection
