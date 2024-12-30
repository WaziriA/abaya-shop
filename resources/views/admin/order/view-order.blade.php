<!-- Modal -->
<div class="modal fade" id="ViewOrderModalCenter{{ $order->id }}" tabindex="-1" role="dialog"
    aria-labelledby="ViewOrderModalCenterTitle{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewOrderModalCenterTitle{{ $order->id }}">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 480px; overflow:auto;" id="orderDetails">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-grid d-flex justify-content-between">
                            <div class="col-4">
                                welcome
                            </div>
                            <div class="col-4">
                                <h1><img src="{{ asset('material/img/logo/logo.jpg') }}"
                                        style="height:80px; width:160px" alt="logo img"> </h1>
                            </div>
                            <div class="col-4">
                                welcome
                            </div>
                        </div>
                        <hr>
                        <h5>Order Details</h5>
                        <p><strong>Order ID:</strong> {{ $order->id ?? 'N/A' }}</p>
                        <p><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                        <h6>Products</h6>
                        <div class="product-container" style="display: flex; flex-wrap: wrap; gap: 25px;">
                            @foreach ($order->products as $product)
                                <div class="product-item" style="flex: 0 0 calc(16.66% - 15px); text-align: center;">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        style="width: 150px; height: 120px; margin-bottom: 10px;">
                                    <div class="mb-4">{{ $product->name }} (Quantity: {{ $product->pivot->quantity }})
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p><strong>Total Product Quantity:</strong>
                            {{ $order->products->sum(function ($product) {return $product->pivot->quantity;}) }}</p>
                        <p><strong>Status:</strong> {{ $order->status ?? 'N/A' }}</p>
                        <p><strong>Amount:</strong> {{ $order->amount ?? 'N/A' }} {{ $order->currency }}</p>
                        <p><strong>Payment ID:</strong> {{ $order->payment_id ?? 'N/A' }}</p>
                        <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                        <p><strong>Shipping Status:</strong> {{ $order->shipping_status ?? 'N/A' }}</p>
                        <h5>Shipping Details</h5>
                        <p><strong>Country:</strong> {{ $order->shipping->country->country_name ?? 'N/A' }}</p>
                        <p><strong>Town:</strong> {{ $order->shipping->town ?? 'N/A' }}</p>
                        <p><strong>District:</strong> {{ $order->shipping->district ?? 'N/A' }}</p>
                        <p><strong>Street:</strong> {{ $order->shipping->street ?? 'N/A' }}</p>
                        <p><strong>Zip Code:</strong> {{ $order->shipping->zip_code ?? 'N/A' }}</p>
                        <p><strong>Note:</strong> {{ $order->shipping->note ?? 'N/A' }}</p>
                        <h5>Additional Shipping Information</h5>
                        <p><strong>Shipping Agent Name:</strong>
                            {{ $order->shipping->transpoter->transpoter_name ?? 'N/A' }}</p>
                        <p><strong>Shipment Method Option:</strong>
                            {{ $order->shipping->shipmentMethod->method_name ?? 'N/A' }}</p>
                        <p><strong>Delivery Country:</strong> {{ $order->shipping->country->country_name ?? 'N/A' }}
                        </p>
                        <p><strong>Shipping Cost: </strong>${{ $order->shipping_cost }}</p>
                        <h5>Feedback</h5>
                        <div>
                            @if ($order->feedbacks->isEmpty())
                                <p>No feedback provided for this order.</p>
                            @else
                                @foreach ($order->feedbacks as $feedback)
                                    <div class="feedback-item"
                                        style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                                        
                                        <p><strong>Comment:</strong> {{ $feedback->comment }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary" target="_blank">Print</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.getElementById('printBtn').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // Get the modal content to print
        const orderDetails = document.getElementById('orderDetails').innerHTML;

        // Add the order details to the PDF
        doc.html(orderDetails, {
            callback: function(doc) {
                doc.save('order-details.pdf');
            },
            margin: [10, 10, 10, 10],
            x: 10,
            y: 10,
        });
    });
</script>
