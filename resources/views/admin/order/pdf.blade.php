<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Sadah Online Shop :: Order Details</title>
    <style>
        body {
            font-family: 'Nabi', sans-serif;
        }

        h1,
        h5 {
            color: #4CAF50;
        }

        .product-item {
            margin-bottom: 15px;
        }

        .product-item img {
            width: 150px;
            height: 120px;
        }
    </style>
</head>

<body>

   
    <h1><img src="{{ asset('material/img/logo/logo.jpg') }}" style="height:80px; width:160px"
        alt="logo img"> The Sadah Abaya Online Shop </h1>
   
   <hr style="color: #4CAF50">
    <h1>Order Details</h1>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>

    <h5>Products</h5>
    <div class="product-container row">
        @foreach ($order->products as $product)
            <div class="product-item col-md-4 d-flex flex-column align-items-center text-center">
                <img src="{{ storage_path('app/public/' . $product->image) }}" alt="{{ $product->name }}"
                    class="img-fluid mb-2" style="max-width: 150px; height: auto;">
                <p>{{ $product->name }} (Quantity: {{ $product->pivot->quantity }})</p>
            </div>
        @endforeach
    </div>

    <p><strong>Total Product Quantity:</strong>
        {{ $order->products->sum(function ($product) {return $product->pivot->quantity;}) }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Amount:</strong> {{ $order->amount }} {{ $order->currency }}</p>
    <p><strong>Payment ID:</strong> {{ $order->payment_id }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    <p><strong>Shipping Status:</strong> {{ $order->shipping_status }}</p>

    <h5>Shipping Details</h5>
    <p><strong>Country:</strong> {{ $order->shipping->country->country_name }}</p>
    <p><strong>Town:</strong> {{ $order->shipping->town }}</p>
    <p><strong>District:</strong> {{ $order->shipping->district }}</p>
    <p><strong>Street:</strong> {{ $order->shipping->street }}</p>
    <p><strong>Zip Code:</strong> {{ $order->shipping->zip_code }}</p>
    <p><strong>Note:</strong> {{ $order->shipping->note }}</p>

    <h5>Additional Shipping Information</h5>
    <p><strong>Shipping Agent Name:</strong> {{ $order->shipping->transpoter->transpoter_name }}</p>
    <p><strong>Shipment Method Option:</strong> {{ $order->shipping->shipmentMethod->method_name }}</p>
    <p><strong>Delivery Country:</strong> {{ $order->shipping->country->country_name }}</p>
    <p><strong>Shipping Cost: </strong>${{ $order->shipping_cost }}</p>
</body>

</html>
