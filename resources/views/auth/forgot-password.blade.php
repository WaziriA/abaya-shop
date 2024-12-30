<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TheSadah Abaya || Reset Password </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('authAssets/assets/style.css') }}">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
</head>
<body>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            @include('auth/flash-message')
                            <div class="d-flex justify-content-center py-4">
                                <img src="{{ asset('material/img/logo.jpg') }}" alt="" style="height: 100px; width: 220px">
                            </div>
                        </div>

                        <div class="pt-4 pb-2">
                            <!-- Display flash message for success -->
                           {{-- <div class="col-md-12 col-sm-10">
                                @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                                </div>
                                @endif
                              
                                @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                                </div>
                                @endif
                              </div>--}}

                            <h4>Forgot Your Password?</h4>
                            <p class="font-weight-light">Enter your email address below to receive a new password.</p>

                            <!-- Show email error if any -->
                            @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @endif

                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Send New Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- End Content Wrapper -->
        </div><!-- End Page Body Wrapper -->
    </div><!-- End Container Scroller -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
