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
                        <div class="row justify-content-between d-flex">
                         <!-- <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Add</button>-->
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Product Photo</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Quantity</th>
                                        <th>Phone No</th>
                                        <th>Payment Status</th>
                                        <th>Amount</th>
                                        <th>Payment ID</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Place</th>
                                        <th>Shipping Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>@if($order->product)
                                            <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" style="width: 50px;">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                        </td>
                                        <td>{{ $order->product ? $order->product->name : 'N/A' }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->user->phone_no }}</td>
                                        <td><span class="badge text-white badge-{{ $order->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</span></td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->payment_id ?? 'N/A'}}</td>
                                        <td>{{ ucfirst($order->payment_method) }}</td>
                                        <td>
                                            @if($order->shipping)
                                                {{ $order->shipping->country }}
                                             @else
                                                <span>No Shipping Info</span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($order->shipping_status) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between gap-3">
                                                <button class="btn btn-primary fa fa-eye text-white  me-2"></button>
                                                <button class="btn btn-success fa fa-edit text-white me-2"></button>
                                                <button class="btn btn-danger fa fa-trash text-white me-2"></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product Photo</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Quantity</th>
                                        <th>Phone No</th>
                                        <th>Payment Status</th>
                                        <th>Amount</th>
                                        <th>Payment ID</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Place</th>
                                        <th>Shipping Status</th>
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