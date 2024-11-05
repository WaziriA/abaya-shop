<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('home.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row d-flex">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name here" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email here" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country">
                                </div>
                            </div>
                            <div class="row mt-4">

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ex: +255</span>
                                        </div>
                                        <input type="text" name="phone_no" class="form-control" placeholder="Phone no">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ex: +255</span>
                                        </div>
                                        <input type="text" name="phone_no2" class="form-control" placeholder="Phone no 2">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="photo">Image</label>
                                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                                </div>

                                <div class="col-md-6">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="owner">Owner</option>
                                        <option value="staff">Staff</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


