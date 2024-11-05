@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Categories</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
                </ol>
            </div>
        </div>
<div class="row d-flex justify-content-between">
    <!-- table-->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Categories</h4>
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Number of Products</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                
                            
                            <tr>
                                <td>{{ $item->name  }}</td>
                                <td>{{ $item->description  }}</td>
                                <td>{{ $item->products_count }}</td>
                                
                                <td>
                                    <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#UpdateCategoryModalCenter{{ $item->id }}"></button>
                                    <!-- Button for deleting -->
                                    <button class="btn btn-danger fa fa-trash text-white" onclick="confirmDelete({{ $item->id }})"></button>

<!-- Form to handle the delete request (it will be submitted via JavaScript) -->
<form id="delete-form-{{ $item->id }}" action="{{ route('category.forceDelete', $item->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

                                </td>
                            </tr>
                            @include('admin/category/update-modal')
                            @endforeach
                           
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Number of Products</th>
                                
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
            <h4 class="card-title">Add Category</h4>
            
        </div>
        <div class="card-body">
            <div id="accordion-two" class="accordion accordion-bordered">
                <div class="accordion__item">
                    <div class="accordion__header" data-toggle="collapse" data-target="#bordered_collapseOne"> <span class="accordion__header--text">Click here to show or hide the form</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div id="bordered_collapseOne" class="collapse accordion__body show" data-parent="#accordion-two">
                        <div class="accordion__body--text">
                           <form action="{{ route('category.store')}}" method="POST">
                            @csrf
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control mb-4" required>

                            <label for="description">Description:</label>
                            <input type="text" name="description" id="description" class="form-control mb-4" required>

                            <button class="btn btn-primary btn-sm" type="submit">Add</button>
                           </form>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div><!--End Of-->
</div>

</div>
</div>
@endsection
