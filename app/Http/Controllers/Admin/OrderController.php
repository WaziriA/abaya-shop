<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Product;
use App\Models\Feedback;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserActivities;
use App\Notifications\NotifyCustomer;
use App\Notifications\NotifyOwner;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Mpdf\Mpdf;
use Exception;

class OrderController extends Controller
{
    private $paypal;

    public function __construct()
    {
        $this->paypal = new PayPalClient;
        $this->paypal->setApiCredentials(config('paypal'));
        $accessToken = $this->paypal->getAccessToken(); // Get the access token
        $this->paypal->setAccessToken($accessToken); // Set the access token
    }

    public function index()
{
    $orders = Order::with(['user', 'products', 'shipping', 'feedbacks.user'])->get();

    return view('admin.order.index', compact('orders'));
}


public function placeOrder(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login.index')->with('error', 'Please log in or register to proceed.');
    }

    $currency = session('currency', 'USD');

    $request->validate([
        'transpoter_id' => 'nullable|integer|exists:transpoters,id',
        'shipment_method_id' => 'nullable|integer|exists:shipment_methods,id',
        'country_id' => 'nullable|integer|exists:destination_countries,id',
        'town' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'street' => 'nullable|string|max:255',
        'zip_code' => 'nullable|string|max:10',
        'note' => 'nullable|string|max:255',
        'payment_method' => 'required|string',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('checkout')->with('error', 'Your cart is empty.');
    }

    $subtotal = 0;
    foreach ($cart as $productId => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $subtotal += $itemTotal;
    }

    $shipping_cost = session()->get('shipping_cost', 0); // Retrieve the shipping cost from session
    $total = $subtotal + $shipping_cost;

    // Store all order details in session
    session(['order_details' => [
        'user_id' => auth()->id(),
        'amount' => $total,
        'currency' => $currency, // Add the currency
        'shipping_cost' => $shipping_cost,
        'shipping_details' => $request->only([
            'transpoter_id', 
            'shipment_method_id', 
            'country_id', 
            'town', 
            'district', 
            'street', 
            'zip_code', 
            'note'
        ]),
        'products' => $cart,
    ]]);

    // Redirect to appropriate payment handler based on payment method
    $paymentMethod = $request->input('payment_method');

    switch ($paymentMethod) {
        case 'paypal':
            return $this->createPayPalOrder($total, $currency);
        case 'credit_card':
            return $this->handleCreditCardPayment($total, $currency);
        case 'samsungpay':
            return $this->handleSamsungPayPayment($total);
        case 'apppay':
            return $this->handleAppPayPayment($total);
        case 'cod':
            return $this->handleCashOnDelivery();
        default:
            return redirect()->back()->with('error', 'Invalid payment method selected.');
    }
}
/*public function placeOrder(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login.index')->with('error', 'Please log in or register to proceed.');
    }

    $request->validate([
        'transpoter_id' => 'nullable|integer|exists:transpoters,id',
        'shipment_method_id' => 'nullable|integer|exists:shipment_methods,id',
        'country_id' => 'nullable|integer|exists:destination_countries,id',
        'town' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'street' => 'nullable|string|max:255',
        'zip_code' => 'nullable|string|max:10',
        'note' => 'nullable|string|max:255',
        'payment_method' => 'required|string',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('checkout')->with('error', 'Your cart is empty.');
    }

    $subtotal = 0;
    foreach ($cart as $productId => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $subtotal += $itemTotal;
    }

    $shipping_cost = session()->get('shipping_cost', 0); // Retrieve the shipping cost from session
    $total = $subtotal + $shipping_cost;

    // Store all order details, including shipping_cost, in session
    session(['order_details' => [
        'user_id' => auth()->id(),
        'amount' => $total,
        'shipping_cost' => $shipping_cost, // Include shipping cost here
        'shipping_details' => $request->only([
            'transpoter_id', 
            'shipment_method_id', 
            'country_id', 
            'town', 
            'district', 
            'street', 
            'zip_code', 
            'note'
        ]),
        'products' => $cart,
    ]]);

    // Proceed with PayPal integration
    return $this->createPayPalOrder($total);
}*/



    protected function createPayPalOrder($total, $currency)
    {
        $orderData = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => $currency, //"USD",
                    "value" => number_format($total, 2, '.', ''), // Use $total directly
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success')
            ]
        ];
    
        $response = $this->paypal->createOrder($orderData);
    
        if (isset($response['status']) && $response['status'] === 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->back()->with('error', 'Payment creation failed.');
        }
    }
    

    public function paypalSuccess(Request $request)
    {
        $orderId = $request->query('token');
        $captureResponse = $this->paypal->capturePaymentOrder($orderId);
    
        if (isset($captureResponse['status']) && $captureResponse['status'] === 'COMPLETED') {
            $orderDetails = session()->get('order_details');
            if ($orderDetails) {
                // Create the order, including shipping cost in the amount
                $order = Order::create([
                    'user_id' => $orderDetails['user_id'],
                    'status' => 'paid',
                    'amount' => $orderDetails['amount'],
                    'currency' => $orderDetails['currency'] ?? 'USD', // Include the currency
                    'shipping_cost' => $orderDetails['shipping_cost'], // Store shipping cost
                    'payment_id' => $captureResponse['id'],
                    'payment_method' => 'paypal',
                    'shipping_status' => 'pending',
                    'product_id' => key($orderDetails['products']),
                    'quantity' => $orderDetails['products'][key($orderDetails['products'])]['quantity'],
                ]);
    
                $productId = $order->product_id;
                $quantityOrdered = $order->quantity;
                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $quantityOrdered;
                    if ($product->stock < 1) {
                        $product->availability_status = 'out-of-stock';
                    }
                    $product->save();
                }
    
                // Create Shipping Details
                $shipping = Shipping::create(array_merge(['order_id' => $order->id], $orderDetails['shipping_details']));
    
                // Prepare notification data
            $user = $order->user; // Assuming the `user` relationship is defined in the Order model
            $notificationData = [
                'title' => 'New Order Created',
                'message' => 'A new order has been successfully created with user: ' . $user->name . ' and email: ' . $user->email,
                'details' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'order_id' => $order->id,
                ],
            ];

            // Get device and browser details
            $detect = new \Detection\MobileDetect;
            $userAgent = $request->header('User-Agent');

            $notificationDetails = [
                'id' => Str::uuid(),
                'type' => UserActivities::class,
                'notifiable_type' => get_class($user),
                'notifiable_id' => $user->id,
                'user_id' => auth()->id(), // Get the currently logged-in user
                'data' => json_encode($notificationData),
                'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
                'os' => $this->getOS($userAgent),
                'browser' => $this->getBrowser($userAgent),
                'brand' => $this->getDeviceBrand($userAgent),
                'user_agent' => $userAgent,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Manually insert the notification into the table
            DB::table('notifications')->insert($notificationDetails);

                // Clear session data
                session()->forget('order_details');
                session()->forget('cart');
    
                return redirect()->route('home.index')->with('success', 'Payment successful');
            } else {
                return redirect()->route('check-out.index')->with('error', 'Order details not found in session.');
            }
        } else {
            return redirect()->route('check-out.index')->with('error', 'Payment failed');
        }
    }
    

    public function paypalCancel()
    {
        return redirect()->route('check-out.index')->with('error', 'Payment canceled');
    }


    public function handleCreditCardPayment($total, $currency)
{
    Stripe::setApiKey(config('stripe.stripe_sk'));

    try {
        // Create the Stripe checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => 'Pay Your Products', // You can change this to dynamic product info
                        ],
                        'unit_amount' => $total * 100, // Amount in cents
                    ],
                    'quantity' => 1, // You can change this based on the user's order
                ],
            ],
            'mode' => 'payment',
            //'success_url' => route('stripe.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        
        // Redirect the user to Stripe Checkout page
        return redirect()->away($session->url);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        return redirect()->route('check-out.index')->with('error', 'Error initiating payment: ' . $e->getMessage());
    }
}

public function stripeSuccess(Request $request)
{
    \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));

    //dd($request->query('session_id'));
    // Retrieve the session ID from the query string
    $sessionId = $request->query('session_id');
    if (!$sessionId) {
        return redirect()->route('check-out.index')->with('error', 'Session ID missing.');
    }

    try {
        // Retrieve the session
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        
        // Retrieve the payment intent ID from the session
        $paymentIntentId = $session->payment_intent;
        if (!$paymentIntentId) {
            return redirect()->route('check-out.index')->with('error', 'Payment Intent ID missing.');
        }

        // Retrieve the payment intent
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        
        if ($paymentIntent->status === 'succeeded') {
            $orderDetails = session()->get('order_details');
            if ($orderDetails) {
                // Create the order
                $order = Order::create([
                    'user_id' => $orderDetails['user_id'],
                    'status' => 'paid',
                    'amount' => $orderDetails['amount'],
                    'currency' => $orderDetails['currency'] ?? 'USD', // Include the currency
                    'shipping_cost' => $orderDetails['shipping_cost'],
                    'payment_id' => $paymentIntent->id,
                    'payment_method' => 'stripe',
                    'shipping_status' => 'pending',
                    'product_id' => key($orderDetails['products']),
                    'quantity' => $orderDetails['products'][key($orderDetails['products'])]['quantity'],
                ]);

                 // Attach products to the pivot table with quantities and prices
                foreach ($orderDetails['products'] as $productId => $productDetails) {
                    $order->products()->attach($productId, [
                        'quantity' => $productDetails['quantity'],
                        'price' => $productDetails['price'],
                    ]);

                // Handle product stock and shipping as usual
                $productId = $order->product_id;
                $quantityOrdered = $order->quantity;
                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $quantityOrdered;
                    if ($product->stock < 1) {
                        $product->availability_status = 'out-of-stock';
                    }
                    $product->save();
                }
            }
                // Create Shipping Details
                $shipping = Shipping::create(array_merge(['order_id' => $order->id], $orderDetails['shipping_details']));

                 // Prepare notification data
                 $user = $order->user; // Assuming the `user` relationship is defined in the Order model
                 $notificationData = [
                     'title' => 'New Order Placed',
                     'message' => 'A new order has been successfully placed by user: ' . $user->name . ' and email: ' . $user->email,
                     'details' => [
                         'user_id' => $user->id,
                         'email' => $user->email,
                         'order_id' => $order->id,
                     ],
                 ];
 
                 // Get device and browser details
                 $detect = new \Detection\MobileDetect;
                 $userAgent = $request->header('User-Agent');
 
                 $notificationDetails = [
                     'id' => Str::uuid(),
                     'type' => UserActivities::class,
                     'notifiable_type' => get_class($user),
                     'notifiable_id' => $user->id,
                     'user_id' => auth()->id(), // Get the currently logged-in user
                     'data' => json_encode($notificationData),
                     'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
                     'os' => $this->getOS($userAgent),
                     'browser' => $this->getBrowser($userAgent),
                     'brand' => $this->getDeviceBrand($userAgent),
                     'user_agent' => $userAgent,
                     'created_at' => now(),
                     'updated_at' => now(),
                 ];
 
                 // Manually insert the notification into the table
                 DB::table('notifications')->insert($notificationDetails);

                  // Retrieve the owner(s)
        $owners = User::where('role', 'owner')->get(); // Fetch all owners, if there are multiple

        // Notify all owners about the order
        foreach ($owners as $owner) {
            $owner->notify(new NotifyOwner($order, $shipping, $order->user));
        }

        // Notify the customer (user who placed the order)
        $customer = $order->user; // User who placed the order
        $customer->notify(new NotifyCustomer($order, $shipping));
 
                // Clear session data
                session()->forget('order_details');
                session()->forget('cart');

                return redirect()->route('home.index')->with('success', 'Payment successful');
            } else {
                return redirect()->route('check-out.index')->with('error', 'Order details not found in session.');
            }
        } else {
            return redirect()->route('check-out.index')->with('error', 'Payment was not successful.');
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        return redirect()->route('check-out.index')->with('error', 'Error retrieving payment intent: ' . $e->getMessage());
    }
}


public function stripeCancel()
{
    return redirect()->route('check-out.index')->with('error', 'Payment canceled');
}


public function handleAppPayPayment($total, $currency)
{
    \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));

    try {
        // Create the Stripe checkout session for Apple Pay
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['apple_pay'], // Supports Apple Pay
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => 'Pay Your Products', // You can make this dynamic
                        ],
                        'unit_amount' => $total * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('app-pay.success') . '?session_id={CHECKOUT_SESSION_ID}', // Success URL
            'cancel_url' => route('app-pay.cancel'), // Cancel URL
        ]);

        // Redirect the user to Stripe Checkout page
        return redirect()->away($session->url);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        return redirect()->route('check-out.index')->with('error', 'Error initiating payment: ' . $e->getMessage());
    }
}

public function AppPaySuccess(Request $request)
{
    \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));

    // Retrieve the session ID from the query string
    $sessionId = $request->query('session_id');
    if (!$sessionId) {
        return redirect()->route('check-out.index')->with('error', 'Session ID missing.');
    }

    try {
        // Retrieve the session
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Retrieve the payment intent
        $paymentIntentId = $session->payment_intent;
        if (!$paymentIntentId) {
            return redirect()->route('check-out.index')->with('error', 'Payment Intent ID missing.');
        }

        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        // Handle successful payment
        if ($paymentIntent->status === 'succeeded') {
            $orderDetails = session()->get('order_details');
            if ($orderDetails) {
                // Create an order record
                $order = Order::create([
                    'user_id' => $orderDetails['user_id'],
                    'status' => 'paid',
                    'amount' => $orderDetails['amount'],
                    'currency' => $orderDetails['currency'] ?? 'USD',
                    'shipping_cost' => $orderDetails['shipping_cost'],
                    'payment_id' => $paymentIntent->id,
                    'payment_method' => 'apple_pay',
                    'shipping_status' => 'pending',
                    'product_id' => key($orderDetails['products']),
                    'quantity' => $orderDetails['products'][key($orderDetails['products'])]['quantity'],
                ]);

                // Update product stock
                $productId = $order->product_id;
                $quantityOrdered = $order->quantity;
                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $quantityOrdered;
                    $product->availability_status = $product->stock < 1 ? 'out-of-stock' : $product->availability_status;
                    $product->save();
                }

                // Create shipping details
                Shipping::create(array_merge(['order_id' => $order->id], $orderDetails['shipping_details']));

                // Clear session data
                session()->forget('order_details');
                session()->forget('cart');

                return redirect()->route('home.index')->with('success', 'Payment successful');
            } else {
                return redirect()->route('check-out.index')->with('error', 'Order details not found in session.');
            }
        } else {
            return redirect()->route('check-out.index')->with('error', 'Payment was not successful.');
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        return redirect()->route('check-out.index')->with('error', 'Error retrieving payment intent: ' . $e->getMessage());
    }
}

public function AppPayCancel()
{
    return redirect()->route('check-out.index')->with('error', 'Payment canceled');
}


    public function updateShippingStatus(Request $request, $id)
{
    // Validate the request to ensure `shipping_status` is provided
    $request->validate([
        'shipping_status' => 'required|in:pending,processing,shipping,delivered',
    ]);

    // Find the order by ID
    $order = Order::findOrFail($id);

    // Update the shipping_status
    $order->shipping_status = $request->input('shipping_status');
    $order->save();

    return redirect()->back()->with('success', 'Shipping status updated successfully.');
}

public function viewOrderDetails($id)
{
    // Retrieve the order and its shipping information using Eloquent relationships
    $order = Order::with(['user', 'product', 'shipping'])->findOrFail($id);
    
    return response()->json([
        'order' => $order
    ]);
}

public function hardDelete($id)
{
    // Find the order by its ID
    $order = Order::findOrFail($id);

    // Permanently delete the order
    $order->delete();

    // Redirect with a success message
    return redirect()->back()->with('success', 'Order permanently deleted!');
}

/*public function show($id)
{
    // Fetch the order along with its shipping details
    $order = Order::with(['user', 'product', 'shipping'])->find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    return response()->json(['order' => $order]);
}*/


public function getFeedback(){
    $feedbacks = Feedback::with(['order.products', 'user'])->paginate(10);
    return view('admin.order.feedback', compact('feedbacks'));
}

private function getOS($userAgent)
{
    if (preg_match('/windows nt/i', $userAgent)) return 'Windows';
    if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'Mac OS';
    if (preg_match('/linux/i', $userAgent)) return 'Linux';
    if (preg_match('/android/i', $userAgent)) return 'Android';
    if (preg_match('/iphone|ipad|ipod/i', $userAgent)) return 'iOS';
    return 'Unknown OS';
}

private function getBrowser($userAgent)
{
    if (preg_match('/firefox/i', $userAgent)) return 'Firefox';
    if (preg_match('/chrome/i', $userAgent)) return 'Chrome';
    if (preg_match('/safari/i', $userAgent)) return 'Safari';
    if (preg_match('/msie|trident/i', $userAgent)) return 'Internet Explorer';
    if (preg_match('/opera|opr/i', $userAgent)) return 'Opera';
    return 'Unknown Browser';
}

private function getDeviceBrand($userAgent)
{
    $brands = [
        'Samsung' => '/samsung/i',
        'Apple' => '/iphone|ipad|ipod|macintosh/i',
        'Huawei' => '/huawei/i',
        'Xiaomi' => '/xiaomi/i',
        'Oppo' => '/oppo/i',
        'Vivo' => '/vivo/i',
        'Google' => '/pixel/i',
        'OnePlus' => '/oneplus/i',
        'Sony' => '/sony/i',
        'Nokia' => '/nokia/i',
        'LG' => '/lg/i',
        'HTC' => '/htc/i',
        'Tecno' => '/tecno/i',
        'Infinix' => '/infinix/i',
        'HP' => '/hp|hewlett-packard|pavilion/i',  // Improved pattern for HP
        'Dell' => '/dell/i',
        'Lenovo' => '/lenovo/i',
        'Acer' => '/acer/i',
        'Asus' => '/asus/i',
        'Toshiba' => '/toshiba/i',
        'Microsoft' => '/microsoft/i',
        'Razer' => '/razer/i',
        'Alienware' => '/alienware/i', // For gaming computers
    ];

    foreach ($brands as $brand => $pattern) {
        if (preg_match($pattern, $userAgent)) {
            return $brand;
        }
    }

    return 'Unknown Brand';
}


public function generatePDF($orderId)
{
    // Retrieve the order by ID
    $order = Order::with(['user', 'products', 'shipping', 'shipping.country', 'shipping.transpoter', 'shipping.shipmentMethod'])->findOrFail($orderId);

    // Pass data to the view for rendering
    $pdf = PDF::loadView('admin.order.pdf', compact('order'));

    // Return the generated PDF as a response
    return $pdf->download('order-details-' . $order->id . '.pdf');
}
}
