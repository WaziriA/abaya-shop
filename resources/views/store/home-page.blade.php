@extends('store.layout')
@section('content')


@include('store.components.carousel')
@include('store.components.support')
@include('store.components.category')
@include('store.components.featured-products')
@include('store.shop-components.subscriber')
@include('store.components.popular')
{{--@include('store.components.banner')
@include('store.components.popular')
@include('store.components.support')
@include('store.components.testimonial')
@include('store.shop-components.subscriber')--}}

@endsection