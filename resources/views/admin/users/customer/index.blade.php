@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">List of All Customers</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Customers</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-between d-flex">
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#example1ModalCenter">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone No</th>
                                        <th>Country</th>
                                        <th>Subscription</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $user)
        <tr>
            <td>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                @else
                    <img src="{{ asset('assets/Images/avatar/1.png') }}" alt="Default Photo" style="width: 50px; height: 50px; border-radius: 50%;">
                @endif
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_no }}</td>
            <td>{{ $user->country }}</td>
            <td>Not Yet</td>
            <td>
                @if (is_null($user->deleted_at))
                    <span class="badge badge-success badge-pill text-white">Active</span>
                @else
                    <span class="badge badge-danger badge-pill text-white">Disabled</span>
                @endif
            </td>
            
            <td>
                <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#UserUpdateModalCenter{{ $user->id }}"></button>
                
                <!-- Soft Delete Button with SweetAlert -->
                <button class="btn btn-warning fa fa-archive text-white" onclick="confirmSoftDelete({{ $user->id }})"></button>
                
                <!-- Hard Delete Button with SweetAlert -->
                <button class="btn btn-danger fa fa-trash text-white" onclick="confirmHardDelete({{ $user->id }})"></button>

                <!-- Soft Delete Form -->
                <form id="soft-delete-form-{{ $user->id }}" action="{{ route('admin-users.softDelete', $user->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <!-- Hard Delete Form -->
                <form id="hard-delete-form-{{ $user->id }}" action="{{ route('admin-users.hardDelete', $user->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </td>
        </tr>
        @include('admin/users/update-modal', ['user' =>$user])
        @endforeach
                                   
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone No</th>
                                        <th>Country</th>
                                        <th>Subscription</th>
                                        <th>Status</th>
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
@include('admin.users.customer.modal')
@endsection