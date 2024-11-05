@extends('admin.layout')
@section('content')


<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your business dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">CMS</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Deleted Carousel</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Deleted Home Carousel Item</h4>
                    </div>
                    
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="example" >
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Caption 1 1</th>
                                        <th>Caption 2</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trashedItems as $item)
                                        
                                    
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                                        </td>
                                        <td>{{$item->up}}</td>
                                        <td>{{$item->middle}} </td>
                                       
                                        <td>{{$item->description}}</td>
                                        <td>
                                            <!-- Restore Button with SweetAlert -->
                                            <button class="btn btn-primary fa fa-undo text-white" onclick="confirmCarouselRestore({{ $item->id }})"></button>

                                             <!-- Restore Form -->
                                              <form id="restore-form-{{ $item->id }}" action="{{ route('carousel.restore', $item->id) }}" method="POST" style="display: none;">
                                                 @csrf
                                              </form>

                                             <!-- Hard Delete Button with SweetAlert -->
                                              <button class="btn btn-danger fa fa-trash text-white" onclick="hardDeleteConfirmation({{ $item->id }})"></button>

                                              

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



@endsection