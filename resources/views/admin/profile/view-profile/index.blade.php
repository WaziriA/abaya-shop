<div class="container">
    <div class="row d-flex justify-content-center ">
        <div class="col-md-10 mt-5 pt-5 bg-light">
            <div class="row z-depth-3">
                <div class="col-sm-4 bg-info rounded-left">
  
                  <div class="card-block text-center text-white">
                     
                      <h2 class="font-weight-bold mt-4">{{ $user->name }}</h2>
                      <p>({{ $user->role }})</p>
                      <button type="button" class="btn btn-info btn-large" data-bs-toggle="modal" data-bs-target="#pictureOptionsModal">
                          <i class="far fa-edit fa-2x mb-4"></i>
                      </button>
                  </div>
                  
                
                
                </div>
                <div class="col-sm-8 bg-white rounded-right">
                    <h3 class="mt-3 text-dark text-center">Information</h3>
                    <hr class="badge-primary mt-0 w-25 mx-auto">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="font-weight-bold">Email:</p>
                            <h6 class="text-muted">{{ $user->email }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="font-weight-bold">Phone:</p>
                            <h6 class="text-muted">{{ $user->phone_no }}</h6>
                        </div>
                        <div class="col-sm-6 mt-4">
                            <p class="font-weight-bold">Gender:</p>
                            <h6 class="text-muted">{{ ucfirst($user->gender) }}</h6>
                        </div>
                        
                        
                        
                        
                        <div class="col-sm-6 mt-4">
                            <p class="font-weight-bold">Street:</p>
                            <h6 class="text-muted">{{ $user->country }}</h6>
                        </div>
                        <div class="col-sm-6 mt-4">
                          <p class="font-weight-bold">Role:</p>
                          <h6 class="text-muted">{{ $user->role }}</h6>
                      </div>
                      <div class="row d-flex justify-content-center text-center mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                          Edit Profile
                        </button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  @include('dash-pages/profile/updateprofile')
  
  <!-- Modal for picture options -->
  <div class="modal fade" id="pictureOptionsModal" tabindex="-1" aria-labelledby="pictureOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="pictureOptionsModalLabel">Profile Picture Options</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($picture)
                    <p>You already have a profile photo. What would you like to do?</p>
                    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updatePictureModal">Update photo</a>
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Remove photo</button>
                    </form>
                @else
                    <p>You don't have a profile picture yet. Please upload one.</p>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPictureModal">Upload Picture</a>
                @endif
            </div>
        </div>
    </div>
  </div>
  
  <!-- Modal for uploading a picture -->
  <div class="modal fade" id="uploadPictureModal" tabindex="-1" aria-labelledby="uploadPictureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="uploadPictureModalLabel">Upload Profile Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Choose Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                
            </form>
        </div>
    </div>
  </div>
  
  <!-- Modal for updating a picture -->
  <div class="modal fade" id="updatePictureModal" tabindex="-1" aria-labelledby="updatePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updatePictureModalLabel">Update Profile Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Choose New Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  
  
  
  <style>
     .modal-dialog-scrollable {
       max-height: 100vh; /* Adjust based on your needs */
       margin: 1.75rem auto;
     }
   
     .modal-body {
       overflow-y: auto; /* Adds vertical scrolling */
     }
   </style>
  
  @include('dash-pages/profile/uploadimage')