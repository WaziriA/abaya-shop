@extends('admin.layout')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi Miss, welcome</h4>
                        <p class="mb-0">List of All Products Reviews</p>
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
                            <h4 class="card-title">All Products Reviews From Customers</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Product Photo</th>
                                            <th>Product Name</th>
                                            <th>Customer Name (User Name)</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reviews as $review)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $review->product->image) }}"
                                                        style="height:50px; width:50px; object-fit:cover;"
                                                        alt="{{ $review->product->name ?? 'N/A' }}">
                                                </td>
                                                <td>{{ $review->product->name ?? 'N/A' }}</td>
                                                <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                                                <td>
                                                    @switch($review->rating)
                                                        @case(1)
                                                            Poor
                                                            @break
                                                        @case(2)
                                                            Fair
                                                            @break
                                                        @case(3)
                                                            Good
                                                            @break
                                                        @case(4)
                                                            Very Good
                                                            @break
                                                        @case(5)
                                                            Excellent
                                                            @break
                                                        @default
                                                            N/A
                                                    @endswitch
                                                </td>
                            
                                                <td>{{ $review->comment }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm text-white"><i class="fa fa-eye"></i></button>
                                                    <button class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No reviews found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Product Photo</th>
                                            <th>Product Name</th>
                                            <th>Customer Name (User Name)</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
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
@endsection
