<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sadah Abaya | Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('material/img/logo.jpg')}}">
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
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="row g-3 needs-validation" action="{{ route('login')}}" method="POST" id="loginForm">
                                @csrf
                                <div class="col-12">
                                    <label for="email" class="form-label">Email:</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">Please enter your email.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                    <div class="invalid-feedback">Please enter your password!</div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                            </form>
                            <div class="col-12 mt-4">
                                <p class="small mb-0">Don't have an account? <a href="{{ route('register.index')}}">Create an account</a></p>
                            </div>
                            <div class="d-flex justify-content-center py-4">
                                <div class="col-12 mt-2">
                                    <p class="small mb-0">forgot password? <a href="{{ route('password.request')}}" target="_blank">click here</a></p>
                                </div>
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
