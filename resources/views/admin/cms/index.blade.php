@extends('admin.layout')
@section('content')


<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your Carousel CMS  dashboard </p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Carousel</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Content</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Responsive Table</h4>
                    </div>
                    
                    <div class="card-body">
                        <button class="btn btn-primary mb-4 waves-effect m-r-20" style="float:left" data-toggle="modal" data-target="#AddModal">Add</button>
                        <div class="table-responsive">
                            <table id="example" >
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Caption 1 </th>
                                        <th>Caption 2</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carouselItems as $item)
                                        
                                    
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                                        </td>
                                        <td>{{$item->up}}</td>
                                        <td>{{$item->middle}} </td>
                                       
                                        <td>{{$item->description}}</td>
                                        <td>
                                            <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#CmsEditModalCenter{{ $item->id }}"></button>
                                            
                                           <!-- Soft Delete Button with SweetAlert -->
                                           <button class="btn btn-warning fa fa-archive text-white" onclick="softDeleteConfirmation({{ $item->id }})"></button>
    
                                            <!-- Hard Delete Button with SweetAlert -->
                                            <button class="btn btn-danger fa fa-trash text-white" onclick="hardDeleteConfirmation({{ $item->id }})"></button>

                                              <!-- Soft Delete Form -->
                                               <form id="soft-delete-form-{{ $item->id }}" action="{{ route('carousel.softDelete', $item->id) }}" method="POST" style="display: none;">
                                                  @csrf
                                                  @method('DELETE')
                                                </form>

                                             <!-- Hard Delete Form -->
                                                  <form id="hard-delete-form-{{ $item->id }}" action="{{ route('carousel.hardDelete', $item->id) }}" method="POST" style="display: none;">
                                                   @csrf
                                                   @method('DELETE')
                                                </form>
                                        </td>
                                        
                                        
                                    </tr>
                                    @include('admin/cms/edit-modal', ['item'=>$item])
                                    @endforeach
                                
                                   
                                </tbody>
                                <tfoot>
                                    <th>Image</th>
                                    <th>Caption 1 1</th>
                                    <th>Caption 2</th>
                                    <th>Description</th>
                                    <th>Action</th>  
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@include('admin/cms/add-modal')


@endsection