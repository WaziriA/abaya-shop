@extends('store.layout')
@section('content')


    @include('store.shop-components.banner')
    <!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">product list</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->
    @include('store.shop-components.category')
    @include('store.shop-components.subscriber')
@endsection