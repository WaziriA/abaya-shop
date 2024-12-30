@extends('admin.layout')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-0">List of All Orders</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">View Orders</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Orders</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Product Photo</th>
                                            <th>Product Name</th>
                                            
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feedbacks as $feedback)
                                        <tr>
                                            <!-- Order ID -->
                                            <td>{{ $feedback->order->id ?? 'N/A' }}</td>
                                            
                                            <!-- Product Photo -->
                                            <td>
                                                @if($feedback->order->products->first()->image ?? false)
                                                <img src="{{ asset('storage/' . $feedback->order->products->first()->image) }}" 
                                                     alt="{{ $feedback->order->products->first()->name }}" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            
                                            <!-- Product Name -->
                                            <td>{{ $feedback->order->products->first()->name ?? 'N/A' }}</td>
                                            
                                            <!-- Rating -->
                                            
                                            
                                            <!-- Comment -->
                                            <td>{{ $feedback->comment }}</td>
                                            
                                            <!-- Action -->
                                            <td>
                                                <button class="btn btn-sm btn-primary">View</button>
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Product Photo</th>
                                            <th>Product Name</th>
                                            
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                

                            </div>
                            <div>{{ $feedbacks->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
