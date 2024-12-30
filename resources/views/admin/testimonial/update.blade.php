<!-- Edit Modal -->
<div class="modal fade" id="EditModal{{ $testimonial->id }}" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel{{ $testimonial->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel{{ $testimonial->id }}">Edit Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 480px; overflow:auto;">
                    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $testimonial->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ $testimonial->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="specialization">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="{{ $testimonial->specialization }}">
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" name="company" class="form-control" value="{{ $testimonial->company }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($testimonial->image)
                            <img src="{{ asset('storage/' . $testimonial->image) }}" width="100" alt="Current Image">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                </div>
            
        </div>
    </div>
</div>
