@extends('store.layout')
@section('content')
    @include('store.product-components.banner')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Products</a></li>
                <li class="breadcrumb-item active">product details</li>
            </ul>
        </div>
    </div>
    @include('store.product-components.product-details')
@endsection