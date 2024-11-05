<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Product;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
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
    $orders = Order::with(['user', 'product', 'shipping'])->get();

    return view('admin/order/index', compact('orders'));
}

    public function placeOrder(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('check-out.index')->with('error', 'To proceed with this process, You have to log in first or register if you’re new');
        }
    
        // Validate request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'note' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
        ]);
    
        // Assuming cart data is stored in session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout')->with('error', 'Your cart is empty.');
        }
    
        $subtotal = 0;
        $productIds = [];
        foreach ($cart as $productId => $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            $productIds[] = $productId;
        }
    
        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax;
    
        // Store order details in session
        session(['order_details' => [
            'user_id' => auth()->id(),
            'amount' => $total,
            'shipping_details' => $request->only(['first_name', 'last_name', 'country', 'town', 'district', 'street', 'zip_code', 'note']),
            'products' => $cart,
        ]]);
    
        // PayPal Integration
        return $this->createPayPalOrder($total);
    }

    protected function createPayPalOrder($total)
    {
        $orderData = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
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
        $orderId = $request->query('token'); // Retrieve order ID from query string
        $captureResponse = $this->paypal->capturePaymentOrder($orderId);
    
        // Log the capture response for debugging
        \Log::info('Capture Response: ', $captureResponse);
    
        if (isset($captureResponse['status']) && $captureResponse['status'] === 'COMPLETED') {
            // Retrieve stored order details from session
            $orderDetails = session()->get('order_details');
            if ($orderDetails) {
                // Create the order in the database
                $order = Order::create([
                    'user_id' => $orderDetails['user_id'],
                    'status' => 'paid',
                    'amount' => $orderDetails['amount'],
                    'payment_id' => $captureResponse['id'],
                    'payment_method' => 'paypal',
                    'shipping_status' => 'pending',
                    'product_id' => key($orderDetails['products']), // Adjust as needed
                    'quantity' => $orderDetails['products'][key($orderDetails['products'])]['quantity'], // Adjust as needed
                ]);

                // Decrease the product stock
            $productId = $order->product_id;
            $quantityOrdered = $order->quantity;

            // Find the product and decrease stock
            $product = Product::find($productId);
            if ($product) {
                $product->stock -= $quantityOrdered;
                // Optionally, you can also update the availability status if needed
                if ($product->stock < 1) {
                    $product->availability_status = 'out-of-stock';
                }
                $product->save(); // Save the updated product
            }
    
                // Create Shipping Details
                Shipping::create(array_merge(['order_id' => $order->id], $orderDetails['shipping_details']));
    
                // Clear the session order details
                session()->forget('order_details');
                session()->forget('cart'); // Clear the cart from the session
    
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
}
