@extends('admin.layout')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your Home Testimonial CMS dashboard</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Testimonial</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Content</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Testimonials</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary mb-4 waves-effect m-r-20" style="float:left" data-toggle="modal" data-target="#AddTestimoniaModal">Add</button>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Specialization</th>
                                        <th>Company</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($testimonials as $testimonial)
                                    <tr>
                                        <td>
                                            @if($testimonial->image && file_exists(public_path('storage/' . $testimonial->image)))
                                                <img src="{{ asset('storage/' . $testimonial->image) }}" width="50" alt="Image">
                                            @else
                                                <img src="{{ asset('assets/images/avatar/1.png') }}" width="50" alt="Default Image">
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->name }}</td>
                                        <td>{{ $testimonial->description }}</td>
                                        <td>{{ $testimonial->specialization }}</td>
                                        <td>{{ $testimonial->company }}</td>
                                        <td>
                                            <button  class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#EditModal{{ $testimonial->id }}"></button>
                                            
                                            <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger fa fa-trash" onclick="return confirm('Are you sure?')"></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('admin.testimonial.update', ['testimonial'=>$testimonial])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.testimonial.add-modal')
@endsection
