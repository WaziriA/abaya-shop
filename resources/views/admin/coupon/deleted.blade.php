@extends('admin.layout')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">Disabled Coupon</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Disabled</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Disabled Coupon</h4>
                    </div>
                    
                    <div class="card-body">
                        
                        <div class="table-responsive">
                        @if ($trashedCoupons->isEmpty())
                             <p>No trashed coupons found.</p>
                        @else
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
                @foreach ($trashedCoupons as $coupon)
                    <tr>
                        <td>{{ $coupon->name }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>{{ $coupon->discount_value }}</td>
                        <td>{{ $coupon->expires_at }}</td>
                        <td>{{ $coupon->users->count() }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="confirmCouponRestore({{ $coupon->id }})">
                                <i class="fa fa-undo"></i>
                            </button>
                            
                            <button class="btn btn-danger btn-sm" onclick="confirmCouponDelete({{ $coupon->id }})">
                                <i class="fa fa-trash text-white"></i>
                            </button>
                            
                            <!-- Delete form (hidden) -->
                            <form id="delete-form-{{ $coupon->id }}" action="{{ route('coupons.softDelete', $coupon->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <!-- Restore form (hidden) -->
                            <form id="restore-form-{{ $coupon->id }}" action="{{ route('coupons.restore', $coupon->id) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
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
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection