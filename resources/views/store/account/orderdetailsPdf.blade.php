<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }
        .product-item {
            flex: 0 0 calc(16.66% - 15px);
            text-align: center;
        }
        .product-item img {
            width: 150px;
            height: 120px;
            margin-bottom: 10px;
        }

        /* Styling for the entire footer container */
.footer-container {
    display: flex;
    justify-content: space-between;  /* Align items in a row with space between */
    align-items: center;            /* Vertically center the items */
    flex-wrap: wrap;                /* Allow wrapping of items if needed */
    padding: 20px;
}

/* Styling for each footer item */
.footer-item {
    flex: 1;                         /* Distribute space evenly */
    padding: 10px;
}

/* Custom styling for the logo section */
.footer-item.logo {
    text-align: center;             /* Center the logo */
}

/* Custom styling for the contact section */
.footer-item.contact {
    text-align: right;              /* Align contact information to the right */
}

/* Add some margin to the top of the icons */
.footer-item.contact p {
    margin: 5px 0;
}

/* Optional: Styling for icons to make them consistent */
.footer-item.contact i {
    margin-right: 8px;
}


    </style>
</head>
<body>
    {{--<h1>
        <img src="{{ public_path('material/img/logo/logo.jpg') }}" style="height:40px; width:160px" alt="logo img">
        The Sadah Abaya Online Shop
    </h1>--}}

    <div class="footer-container">
        <div class="footer-item">
            Sadah celebrates modesty, elegance, and practicality by creating timeless, comfortable abayas.
        </div>
        <div class="footer-item logo">
            <h1>
                <img src="{{ public_path('material/img/logo/logo.jpg') }}" style="height:80px; width:160px" alt="logo img">
            </h1>
        </div>
        <div class="footer-item contact">
            <p><i class="fa fa-envelope"></i>Thesadahabaya@gmail.com</p>
            <p><i class="fa fa-phone"></i>: +971 56 282 2338</p>
            <p><i class="fa fa-instagram"></i>: Thesadahabaya</p>
        </div>
    </div>
    

    

  <b> <hr style="color: blue"></b>
    <hr style="color: blue">

    <h5 style="color: blue">Order Details</h5>
    <p><strong>Order ID:</strong> {{ $order->id ?? 'N/A' }}</p>
    <p><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>

    <div class="product-container">
        @foreach ($order->products as $product)
            <div class="product-item">
                <img src="{{ public_path('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="mb-4">{{ $product->name }} (Quantity: {{ $product->pivot->quantity }})</div>
            </div>
        @endforeach
    </div>

    <p><strong>Total Product Quantity:</strong> {{ $order->products->sum(fn($product) => $product->pivot->quantity) }}</p>
    <p><strong>Status:</strong> {{ $order->status ?? 'N/A' }}</p>
    <p><strong>Amount:</strong> {{ $order->amount ?? 'N/A' }} {{ $order->currency }}</p>
    <p><strong>Payment ID:</strong> {{ $order->payment_id ?? 'N/A' }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
    <p><strong>Shipping Status:</strong> {{ $order->shipping_status ?? 'N/A' }}</p>

    <h5 style="color: blue">Shipping Details</h5>
    <p><strong>Country:</strong> {{ $order->shipping->country->country_name ?? 'N/A' }}</p>
    <p><strong>Town:</strong> {{ $order->shipping->town ?? 'N/A' }}</p>
    <p><strong>District:</strong> {{ $order->shipping->district ?? 'N/A' }}</p>
    <p><strong>Street:</strong> {{ $order->shipping->street ?? 'N/A' }}</p>
    <p><strong>Zip Code:</strong> {{ $order->shipping->zip_code ?? 'N/A' }}</p>
    <p><strong>Note:</strong> {{ $order->shipping->note ?? 'N/A' }}</p>

    <h5 style="color: blue">Additional Shipping Information</h5>
    <p><strong>Shipping Agent Name:</strong> {{ $order->shipping->transpoter->transpoter_name ?? 'N/A' }}</p>
    <p><strong>Shipment Method Option:</strong> {{ $order->shipping->shipmentMethod->method_name ?? 'N/A' }}</p>
    <p><strong>Delivery Country:</strong> {{ $order->shipping->country->country_name ?? 'N/A' }}</p>
    <p><strong>Shipping Cost:</strong> ${{ $order->shipping_cost }}</p>
</body>
</html>
