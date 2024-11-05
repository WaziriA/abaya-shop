<!-- Large Size -->
<div class="modal fade" id="CmsEditModalCenter{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="#CmsEditModalCenterLabel{{ $item->name }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="CmsEditModalCenterLabel{{ $item->name }}">Update Carousel Item</h4>
            </div>
            <form action="{{ route('cms.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body">
                                    
                                  <div>
                                        <div class="row mb-2">
                                          <div class="col-md-6">
                                            <label for="up">Caption 1 (Title)</label>
                                            <input type="text" name="up" class="form-control" >
                                          </div>
                                        
                                          <div class="col-md-6">
                                            <label for="middle">Caption 2 (Subtitlee)</label>
                                            <input type="text" name="middle" class="form-control" >
                                          </div>
                                        </div>
                                        
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                               <label for="description">Description</label>
                                               <textarea name="description" class="form-control" rows="3" ></textarea>
                                            </div>
                                        
                                            <div class="col-md-6">
                                               <label for="photo">Upload Photo</label>
                                               <input type="file" name="photo" id="photoInput" class="form-control" >
                                             
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <img id="preview" src="" alt="Image Preview" style="display: none; margin-top: 10px; width: 400px; height:300px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('photoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview');
                img.src = e.target.result;
                img.style.display = 'block'; // Show the image
            };
            reader.readAsDataURL(file);
        } else {
            // Hide the image if no file is selected
            document.getElementById('preview').style.display = 'none';
        }
    });
</script>

<!--
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the uploaded file
        const reader = new FileReader(); // Create a FileReader object

        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result; // Set the image source to the uploaded file
            imagePreview.style.display = 'block'; // Show the image
        };

        if (file) {
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    });
</script>-->