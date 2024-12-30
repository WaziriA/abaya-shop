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
                            <h4 class="card-title">Personal Details</h4>
                        </div>

                        <div class="card-body">

                            <div class="container">
                                <div class="row d-flex justify-content-center ">
                                    <div class="col-md-10 mt-5 pt-5 bg-light">
                                        <div class="row z-depth-3">
                                            <div class="col-sm-4 bg-info rounded-left">
                                                <div class="card-block text-center text-white">


                                                    <!-- Display the current photo or default if not set -->
                                                    @if ($user->photo)
                                                        <img src="{{ asset('storage/' . $user->photo) }}"
                                                            alt="Profile Picture" class="img-fluid rounded-circle mb-3"
                                                            width="150">
                                                    @else
                                                        <img src="{{ asset('assets/images/avatar/1.png') }}"
                                                            alt="Profile Picture" class="img-fluid rounded-circle mb-3"
                                                            width="150">
                                                    @endif
                                                    <h2 class="font-weight-bold mt-4">{{ $user->name }}</h2>
                                                    <p>({{ $user->role }})</p>

                                                    <button type="button" class="btn btn-info btn-large"
                                                        data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                                        <i class="far fa-edit fa-2x mb-4"></i> Edit Profile
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-sm-8 bg-white rounded-right">
                                                <h3 class="mt-3 text-dark text-center">Information</h3>
                                                <hr class="badge-primary mt-0 w-25 mx-auto">
                                                <div class="row">
                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Email:</p>
                                                        <h6 class="text-muted">{{ $user->email }}</h6>
                                                    </div>
                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Phone:</p>
                                                        <h6 class="text-muted">{{ $user->phone_no }}</h6>
                                                    </div>

                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Phone(Option):</p>
                                                        <h6 class="text-muted">{{ $user->phone_no2 }}</h6>
                                                    </div>

                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Gender:</p>
                                                        <h6 class="text-muted">{{ ucfirst($user->gender) }}</h6>
                                                    </div>
                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Country:</p>
                                                        <h6 class="text-muted">{{ $user->country }}</h6>
                                                    </div>
                                                    <div class="col-sm-6 mt-4">
                                                        <p class="font-weight-bold">Role:</p>
                                                        <h6 class="text-muted">{{ $user->role }}</h6>
                                                    </div>
                                                </div>

                                                <div class="row d-flex justify-content-center text-center mt-4">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#editProfileModal">
                                                        Edit Profile
                                                    </button>
                                                </div>

                                                <!-- Modal for editing the profile -->
                                                <div class="modal fade" id="editProfileModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editProfileModalLabel">Edit
                                                                    Profile</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body"
                                                                style="max-height: 480px; overflow:auto;">
                                                                <form action="{{ route('profile.update') }}" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name"
                                                                            class="form-label">Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            value="{{ $user->name }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="form-label">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" name="email"
                                                                            value="{{ $user->email }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="phone_no" class="form-label">Phone
                                                                            1</label>
                                                                        <input type="text" class="form-control"
                                                                            id="phone_no" name="phone_no"
                                                                            value="{{ $user->phone_no }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="phone_no2" class="form-label">Phone
                                                                            2</label>
                                                                        <input type="text" class="form-control"
                                                                            id="phone_no2" name="phone_no2"
                                                                            value="{{ $user->phone_no2 }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="gender"
                                                                            class="form-label">Gender</label>
                                                                        <select class="form-control" id="gender"
                                                                            name="gender">
                                                                            <option value="male"
                                                                                {{ $user->gender === 'male' ? 'selected' : '' }}>
                                                                                Male</option>
                                                                            <option value="female"
                                                                                {{ $user->gender === 'female' ? 'selected' : '' }}>
                                                                                Female</option>
                                                                            <option value="other"
                                                                                {{ $user->gender === 'other' ? 'selected' : '' }}>
                                                                                Other</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="country"
                                                                            class="form-label">Country</label>
                                                                        <input type="text" class="form-control"
                                                                            id="country" name="country"
                                                                            value="{{ $user->country }}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="photo" class="form-label">Profile
                                                                            Picture</label>
                                                                        <input type="file" class="form-control"
                                                                            id="photo" name="photo"
                                                                            accept="image/*">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        Changes</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Cancel</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
