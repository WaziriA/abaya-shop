<!-- Modal -->
<div class="modal fade" id="CustomerViewOrderModalCenter{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="CustomerViewOrderModalCenterTitle{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CustomerViewOrderModalCenterTitle{{ $order->id }}">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 480px; overflow:auto;">
                <div class="card">
                    <div class="card-body">

                        
                            
                        <div class="row d-grid d-flex justify-content-between">
                            <div class="col-4">
                                Sadah celebrates modesty, elegance, and practicality by creating timeless, comfortable abayas. 
                            </div>
                            <div class="col-3">
                            <h1><img src="{{ asset('material/img/logo/logo.jpg') }}" style="height:80px; width:160px"
                                alt="logo img"> </h1>
                            </div>
                            <div class="col-5">
                                <p><i class="fa fa-envelope"></i>: Thesadahabaya@gmail.com</p>
                                <p><i class="fa fa-phone"></i>: +971 56 282 2338</p>
                                <p><i class="fa fa-instagram"></i>: Thesadahabaya</p>
                            </div>
                        </div>

                      <b> <hr></b>

                        <h5>Order Details</h5>
                        <p><strong>Order ID:</strong> {{ $order->id ?? 'N/A' }}</p>
                        <p><strong>User:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                        <div class="product-container" style="display: flex; flex-wrap: wrap; gap: 25px;">
                            @foreach ($order->products as $product)
                                <div class="product-item" style="flex: 0 0 calc(16.66% - 15px); text-align: center;">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 150px; height: 120px; margin-bottom: 10px;">
                                    <div class="mb-4">{{ $product->name }} (Quantity: {{ $product->pivot->quantity }})</div>
                                </div>
                            @endforeach
                        </div>

                        <p><strong>Total Product Quantity:</strong> {{ $order->products->sum(function($product) { return $product->pivot->quantity; }) }}</p>
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

                        <!-- Additional Information -->
                        <h5>Additional Shipping Information</h5>
                        <p><strong>Shipping Agent Name:</strong> {{ $order->shipping->transpoter->transpoter_name ?? 'N/A' }}</p>
                        <p><strong>Shipment Method Option:</strong> {{ $order->shipping->shipmentMethod->method_name ?? 'N/A' }}</p>
                        <p><strong>Delivery Country:</strong> {{ $order->shipping->country->country_name ?? 'N/A' }}</p>
                        <p><strong>Shipping Cost: </strong>${{ $order->shipping_cost }}</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ route('export.pdf', $order->id) }}" class="btn btn-primary">Export as PDF</a>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
