@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Trashed Agents</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trushed</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                </ol>
            </div>
        </div>
<div class="row d-flex justify-content-between">
    <!-- table-->
    <div class="col-lg-12">
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
                            @foreach ($trashedTransporters as $transpoter)
                                
                            
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $transpoter->transpoter_name  }}</td>
                                
                                
                                <td>
                                    <button class="btn btn-primary fa fa-undo" onclick="confirmRestore({{ $transpoter->id }})"></button>

                                   <!-- Restore Form -->
                                   <form id="restore-form-{{ $transpoter->id }}" action="{{ route('transporters.restore', $transpoter->id) }}" method="POST" style="display: none;">
                                       @csrf
                                    @method('POST')
                                    </form>
                                   

                                    <!-- Permanent Delete Button -->
                                    <button class="btn btn-danger fa fa-trash text-white" onclick="confirmAgentHardDelete({{ $transpoter->id }})" title="Delete permanently"></button>
                                    
                                  
                                    
                                    <!-- Form for Permanent Delete -->
                                    <form id="hard-delete-form-{{ $transpoter->id }}" action="{{ route('transpoter.forceDelete', $transpoter->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                          
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

</div>

</div>
</div>
@endsection
