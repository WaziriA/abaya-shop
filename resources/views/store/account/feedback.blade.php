<!-- In your view where you list orders -->



<!-- Feedback Modal -->
<div class="modal fade" id="FeedbackModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="FeedbackModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FeedbackModalLabel{{ $order->id }}">Leave Feedback for Order #{{ $order->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <div class="modal-body">
                    

                    <div class="form-group">
                        <label for="comment">Your Feedback</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>
