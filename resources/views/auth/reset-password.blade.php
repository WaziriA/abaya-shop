<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sadah Abaya | Reset Password</title>
    <!-- plugins:css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('authAssets/assets/style.css')}}">
    <!-- End layout styles -->
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
                            <img src="{{ asset('material/img/logo.jpg')}}" alt="" style="height: 100px; width: 220px">
                            </div>
                        </div><!-- End Logo -->

                        <div class="pt-4 pb-2">
                            <!-- Show email error if any -->
                            @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                                
                            @endif

                            <!-- Show password error if any -->
                            @if ($errors->has('password'))
                                <div class="text-danger">{{ $errors->first('password') }}</div>
                            @endif
                            <h4>Hello! Let's get started</h4>
                            <h6 class="font-weight-light">Put Your new Password here.</h6>
                            
                                <form action="{{ route('password.update') }}" class="row g-3 needs-validation" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="password">New Password:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                    </div>
                                </form>
                            </div>
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
