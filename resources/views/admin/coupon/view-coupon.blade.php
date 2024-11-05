@extends('admin.layout')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi Miss, welcome</h4>
                    <p class="mb-0">Coupon</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Coupon {{ $coupon->name}}</h4>
                    </div>
                    
                    <div class="card-body">

<h1>Coupon Details</h1>
<p><strong>Name:</strong> {{ $coupon->name }}</p>
<p><strong>Code:</strong> {{ $coupon->code }}</p>
<p><strong>Type:</strong> {{ ucfirst($coupon->type) }}</p>
<p><strong>Discount:</strong> {{ $coupon->discount_value }}</p>
<p><strong>Expires At:</strong> {{ $coupon->expires_at}}</p>
<h3>Assigned Users</h3>
<ul>
    @if($coupon->users->isEmpty())
    <p>No users assigned to this coupon.</p>
@else
    <ul>
        @foreach($coupon->users as $user)
            <li>{{ $user->name }} - Used at: {{ $user->pivot->used_at ?? 'Not used yet' }}</li>
        @endforeach
    </ul>
@endif
</ul>

     
</div>
</div>
</div>
</div>
</div>
</div>
@endsection