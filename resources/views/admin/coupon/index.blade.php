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
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#AddCouponModalCenter">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Discount</th>
                                        <th>Expires At</th>
                                        <th>Assigned Users</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->name }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ ucfirst($coupon->type) }}</td>
                                            <td>{{ $coupon->discount_value }}</td>
                                            <td>{{ $coupon->expires_at }}</td>
                                            <td>{{ $coupon->users->count() }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.coupons.show', $coupon->id) }}"><i class="fa fa-eye  text-white"> </a>
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#EditCouponModalCenter{{ $coupon->id}}"><i class="fa fa-edit  text-white"></button>
                                                        <button class="btn btn-danger btn-sm" onclick="confirmCouponDelete({{ $coupon->id }})">
                                                            <i class="fa fa-trash text-white"></i>
                                                        </button>
                                                        
                                                        <!-- Delete form (hidden) -->
                                                        <form id="delete-form-{{ $coupon->id }}" action="{{ route('coupons.softDelete', $coupon->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                            </td>
                                        </tr>
                                        @include('admin/coupon/edit-modal', ['coupon'=> $coupon])
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Discount</th>
                                        <th>Expires At</th>
                                        <th>Assigned Users</th>
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
@include('admin/coupon/add-modal')




@endsection