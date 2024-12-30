@extends('store.layout')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index')}}">User</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="dashboard-nav" data-toggle="pill" href="#dashboard-tab" role="tab">Dashboard</a>
                        <a class="nav-link" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab">Orders</a>
                       <!-- <a class="nav-link" id="payment-nav" data-toggle="pill" href="#payment-tab" role="tab">Payment Method</a>-->
                        <a class="nav-link" id="address-nav" data-toggle="pill" href="#address-tab" role="tab">address</a>
                        <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab">Account Details</a>
                        <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                               
                            </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="dashboard-tab" role="tabpanel" aria-labelledby="dashboard-nav">
                            <h4>Dashboard</h4>
                            <p>
                               @include('store/account/dashboard')
                            </p> 
                        </div>
                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Shipping Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @foreach ($order->products->take(1) as $product)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; margin-right: 5px;">
                                                    @endforeach
                                                    @if ($order->products->count() > 1)
                                                        <i class="bi bi-three-dots" title="More products available" style="font-size: 24px; color: #007bff; cursor: pointer;"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach ($order->products->take(1) as $product)
                                                        <div>{{ $product->name }} (Qty: {{ $product->pivot->quantity }})</div>
                                                    @endforeach
                                                    @if ($order->products->count() > 1)
                                                        <span class="text-primary" style="cursor: pointer;" title="More products available">
                                                            View more...
                                                        </span>
                                                    @endif
                                                </td> <!-- Assuming 'name' exists in the Product model -->
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>{{ $order->amount }} {{ $order->currency }}</td>
                                                <td>{{ ucfirst($order->status) }}</td>
                                                <td>{{ ucfirst($order->shipping_status) }}</td>
                                                <td>
                                                    <div class="row d-flex justify-content-between">
                                                        <!-- Button to trigger the modal -->
                                                        <button class="fa fa-eye" title="View Order details" data-toggle="modal"
                                                        data-target="#CustomerViewOrderModalCenter{{ $order->id }}"></button>
                                                        <hr class="text-white">
                                                        <button class="fa fa-comments" title="Give Feedback and comments about this product" data-toggle="modal" data-target="#FeedbackModal{{ $order->id }}"></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('store.account.view-modal', ['order' => $order])
                                            @include('store.account.feedback', ['order' => $order])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-nav">
                            <h4>Payment Method</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum quam ac mi viverra dictum. In efficitur ipsum diam, at dignissim lorem tempor in. Vivamus tempor hendrerit finibus. Nulla tristique viverra nisl, sit amet bibendum ante suscipit non. Praesent in faucibus tellus, sed gravida lacus. Vivamus eu diam eros. Aliquam et sapien eget arcu rhoncus scelerisque.
                            </p> 
                        </div>
                        <div class="tab-pane fade" id="address-tab" role="tabpanel" aria-labelledby="address-nav">
                            <h4>Address</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Contact Details</h5>
                                    <p>{{ $user->email }}</p>
                                    <p>{{ $user->phone_no }}</p>
                                    
                                </div>
                                <div class="col-md-6">
                                    <h5>Shipping Address</h5>
                                    <p>{{ $user->country }}</p>
                                    <p>{{ $user->phone_no2 }}</p>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                            <h4>Account Details</h4>
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                            
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <input type="text" placeholder="First Name" name="name" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                            
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <input type="email" placeholder="Email" name="email" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                            
                                    <!-- Mobile -->
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Mobile" name="phone_no" value="{{ old('phone_no', Auth::user()->phone_no) }}">
                                    </div>
                            
                                    <!-- Alternate Mobile -->
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Alternate Mobile" name="phone_no2" value="{{ old('phone_no2', Auth::user()->phone_no2) }}">
                                    </div>
                            
                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <select name="gender" class="form-control custom-select">
                                            <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                            
                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Country" name="country" value="{{ old('country', Auth::user()->country) }}">
                                    </div>
                            
                                   
                            
                                    <!-- Photo Upload -->
                                    <div class="col-md-12">
                                        <input type="file" name="photo" accept="image/*">
                                    </div>
                            
                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit">Update Account</button>
                                        <br><br>
                                    </div>
                                </div>
                            </form>
                            
                            <h4>Password change</h4>
                            <form action="{{ route('profile.change-password') }}" method="POST">
                                @csrf
                            
                                <div class="row">
                                    <!-- Current Password -->
                                    <div class="col-md-12">
                                        <input type="password" name="current_password" placeholder="Current Password" required>
                                        @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                            
                                    <!-- New Password -->
                                    <div class="col-md-6">
                                        <input type="password" name="new_password" placeholder="New Password" required>
                                        @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                            
                                    <!-- Confirm New Password -->
                                    <div class="col-md-6">
                                        <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" required>
                                    </div>
                            
                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->
    
@endsection