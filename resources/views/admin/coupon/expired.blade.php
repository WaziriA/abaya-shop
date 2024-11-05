@extends('admin.layout')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">List of All Expired Coupon</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Expired</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Expired Coupon</h4>
                    </div>
                    
                    <div class="card-body">
                        
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
                                        <th>Used</th> <!-- New column -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiredCoupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->name }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ ucfirst($coupon->type) }}</td>
                                            <td>{{ $coupon->discount_value }}</td>
                                            <td>{{ $coupon->expires_at }}</td>
                                            <td>{{ $coupon->users->count() }}</td>
                                            <td>{{ $coupon->usedBy->count() }}</td> <!-- Display count of used users -->
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.coupons.show', $coupon->id) }}">
                                                    <i class="fa fa-eye text-white"></i>
                                                </a>
                                                
                                               
                                            </td>
                                        </tr>
                                        
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
                                        <th>Used</th> <!-- New column footer -->
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