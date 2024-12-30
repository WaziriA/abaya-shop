@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Estimated Shipping  Costs</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Shipping Agents</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Costs</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Agent Costs</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-between d-flex">
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#AddAgentModalCenter">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Shipping Method</th>
                                        <th>Destination Country</th>
                                        <th>Value Range(from)</th>
                                        <th>Value Range(Untill)</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agents as $agent)
                                        
                                    
                                        <tr>
                                            <td>{{ $agent->transpoter->transpoter_name }}</td>
                                            <td>{{ $agent->shipment_method->method_name }}</td>
                                            <td>{{ $agent->destination_country->country_name }}</td>
                                            <td>{{ $agent->from }}</td>
                                            <td>{{ $agent->to }}</td>
                                            <td>{{ $agent->cost}}</td>
                                            
                                            <td>
                                                <div class="row d-flex">
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#EditAgentModalCenter{{ $agent->id}}"><i class="fa fa-edit  text-white"></button>

                                                        <!-- Soft Delete Button -->
              <button class="btn btn-warning btn-sm" onclick="confirmCostSofttDelete({{ $agent->id }})">
                      <i class="fa fa-trash text-white"></i>
             </button>

<!-- Delete form (hidden) for soft delete -->
<form id="delete-form-{{ $agent->id }}" action="{{ route('agent.destroy', $agent->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Hard Delete Button -->
<button class="btn btn-danger btn-sm" onclick="confirmCostHardtDelete({{ $agent->id }})">
    <i class="fa fa-trash text-white"></i>
</button>

<!-- Delete form (hidden) for hard delete -->
<form id="hard-delete-form-{{ $agent->id }}" action="{{ route('forceDelete', $agent->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
                                                    </div>
                                            </td>
                                        </tr>
                                        @include('admin/shipping-agent/edit-modal', ['agent'=> $agent])
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Shipping Method</th>
                                        <th>Destination Country</th>
                                        <th>Value Range(from)</th>
                                        <th>Value Range(Untill)</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin/shipping-agent/add-modal')
@endsection