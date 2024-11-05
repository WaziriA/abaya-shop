<!-- Large Size -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModaltModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="LoginModalLabel">login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
               <div class="modal-body" style="max-height: 480px; overflow:auto;">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="mb-3" style="margin-bottom: 10px">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3" style="margin-bottom: 10px">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <div class="d-flex justify-content-center mt-4" style="align-content: center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            
                
                <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        
    </div>
  </div>
</div>