<!-- Large Size -->
<div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModaltModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="RegisterModalLabel">Register</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
               <div class="modal-body" style="max-height: 480px; overflow:auto;">
                <form method="POST" action="{{ route('register') }}" id="RegisterForm" enctype="multipart/form-data">
                    @csrf

                 <div class="row mb-3"  style="margin-bottom: 10px;">
                    <div class=" col-md-6" style="margin-bottom: 10px">
                        <label for="name" class="form-label">Name:</label>
                        <input type="name" name="name" id="name" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Others</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3"  style="margin-bottom: 10px;">
                    <div class="col-md-6" style="margin-bottom: 10px">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="col-md-6">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control" name="country">
                    </div>
                </div>

                    <div class="row mb-3"  style="margin-bottom: 10px;">

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label for="phone_no">Phone No:</label>
                                <input type="text" name="phone_no" class="form-control" placeholder="Phone no">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">

                                <label for="phone_no2">Phone No:</label>
                                <input type="text" name="phone_no2" class="form-control" placeholder="Phone no 2">
                            </div>
                        </div>
                    </div>

                 <div class="row mb-3"   style="margin-bottom: 10px;">

                    <div class="col-md-6" style="margin-bottom: 10px">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                        <div class="col-md-6">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" accept="image/*">
                        </div>

                    
                </div>
                    
                <div class="row mb-3" style="margin-bottom: 10px;">
                    <div class="col-md-6">
                        <label for="photo">Image(Optional)</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    </div>
                </div>

                    <div class="d-flex justify-content-center mt-4" style="align-content: center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
            
                
                <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        
    </div>
  </div>
</div>