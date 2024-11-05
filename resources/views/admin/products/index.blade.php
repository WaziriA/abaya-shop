@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Products</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Table</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Products</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-between d-flex">
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#example1ModalCenter">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Stocks</th>
                                        <th>Availability</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>View Count</th>
                                        <th>Status</th>
                                        <th>Warehouse Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}" style="height:120px; width:110px;" alt="image">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->brand }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="{{ $product->availability_status == 'in-stock' ? 'text-success' : 'text-danger' }}">
                                            {{ ucfirst($product->availability_status) }}
                                        </td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>{{ $product->view_count }}</td>
                                        <td>{{ ucfirst($product->status) }}</td>
                                        <td>{{ $product->location }}</td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <button class="btn btn-success fa fa-edit text-white me-2" data-toggle="modal" data-target="#UpdateProductModalCenter{{ $product->id }}"></button>
                                        
                                                <!-- Soft Delete Button -->
                                                <form action="{{ route('products.softDelete', $product->id) }}" method="POST" class="d-inline soft-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning fa fa-trash text-white ms-2 sweet-alert1"  title="Soft Delete"></button>
                                                </form>
                                        
                                                <!-- Hard Delete Button -->
                                                <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" class="d-inline hard-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger fa fa-trash text-white ms-2 sweet-alert1"  title="Hard Delete"></button>
                                                </form>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    @include('admin/products/updateProduct-modal', ['product' => $product])
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Stocks</th>
                                        <th>Availability</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>View Count</th>
                                        <th>Status</th>
                                        <th>Warehouse Location</th>
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
@include('admin/products/modal')




@endsection