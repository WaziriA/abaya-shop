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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Products</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Deleted</a></li>
                </ol>
            </div>
        </div>
       
           {{--   <h1>Deleted Products</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deletedProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Restore</button>
                        </form>
                        <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this product?')">Delete Permanently</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>--}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Deleted Items</h4>
                </div>
                
                <div class="card-body">
                    <div class="row justify-content-between d-flex">
                      <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Add</button>
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
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stocks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deletedProducts as $product)
                                    <tr>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}" style="height:120px; width:110px;" alt="image">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->brand }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <!-- Restore Button -->
                                            <form id="restore-form-{{ $product->id }}" action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-primary" title="Restore the product" onclick="confirmRestore({{ $product->id }})">
                                                  <i class="fas fa-undo"></i>
                                                </button>
                                            </form>

                                            <!-- Permanently Delete Button -->
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.forceDelete', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                               <button type="button" class="btn btn-danger" title="Delete Permanently" onclick="confirmDelete({{ $product->id }})">
                                                   <i class="fas fa-trash"></i>
                                               </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SKU</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stocks</th>
                                    <th>Actions</th>
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
    </div>
</div>

@endsection