<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sadah Abaya | Register</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('material/img/logo.jpg')}}">
    <!-- plugins:css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
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
                </div>
            
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
  
                    <form class="pt-3" method="POST" action="{{ route('register') }}" id="RegisterForm" enctype="multipart/form-data">
                        @csrf
    
                     
                        <div class=" col-md-12 mb-2" >
                            <label for="name" class="form-label">Name:</label>
                            <input type="name" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
    
                        <div class="col-md-12 mb-2">
                            <div class="form-group" class="form-label">
                                <label for="gender">Gender:</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Others</option>
                                </select>
                            </div>
                        </div>
                    
                    
                    
                    <div class="row d-flex justify-content-between mb-4">
                        <div class="col-md-6 mb-2"> 
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>
    
                        <div class="col-md-6 mb-2">
                            <label for="country">Country:</label>
                            <input type="text" class="form-control" name="country" placeholder="Enter your Country">
                        </div>
                    </div>
    
                        
                    <div class="row d-flex justify-content-between">
                            <div class="col-md-6 mb-2">
                                <div class="input-group mb-3">
                                    
                                    <input type="number" name="phone_no" class="form-control" placeholder="Enter your Mobile Number">
                                </div>
                            </div>
    
                            <div class="col-md-6 mb-2">
                                <div class="input-group mb-3">
    
                                    
                                    <input type="number" name="phone_no2" class="form-control" placeholder="Enter your Mobile Number">
                                </div>
                            </div>
                        
                        </div>
                     
                     <div class="row d-flex justify-content-between">
                        <div class="col-md-6 mb-2" >
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>
    
                            <div class="col-md-6 mb-2">
                                <label for="password_confirmation">Confirm Password:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" class="form-control" accept="image/*">
                            </div>
    
                        </div>      
                    
                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                      </div>
                    </form>

                      <div class="col-12">
                        <p class="small mb-0">Already have an account? <a href="{{ route('login')}}">Log in</a></p>
                      </div>
                    
  
                  </div>
                </div>
  
            </div>
        </div>
  
              </div>
            </div>
          </div>
  
        </section>
  
      </div>
  </main>
</body>
</html>