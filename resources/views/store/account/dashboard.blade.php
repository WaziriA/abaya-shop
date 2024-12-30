<div class="content-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Personal Details</h4>
                    </div>

                    <div class="card-body">

                        <div class="container">
                            <div class="row d-flex justify-content-center ">
                                <div class="col-md-10   bg-light">
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
