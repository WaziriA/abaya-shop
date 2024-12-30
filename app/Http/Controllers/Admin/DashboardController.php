<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\OrderProduct;



class DashboardController extends Controller
{
    //
    public function index(){
        $currentMonth = Carbon::now()->month;

    // Count Staff
    $staffCount = User::where('role', 'staff')->count();

    // Count Customers
    $customerCount = User::where('role', 'customer')->count();

    // Count Subscribers
    $subscriberCount = Subscriber::count();

    // Count Orders (specific month)
    $orderCount = Order::whereMonth('created_at', $currentMonth)->count();

     // Sum of order amounts by currency for the current month
     $currencies = ['USD', 'AED', 'EURO', 'GBP'];
     $orderSums = [];
     foreach ($currencies as $currency) {
         $orderSums[$currency] = Order::where('currency', $currency)
             ->whereMonth('created_at', $currentMonth)
             ->sum('amount'); // Ensure the 'price' column is used for summation
     }

     // Data for the chart
    $chartData = [];
    foreach ($currencies as $currency) {
        $monthlyData = Order::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('currency', $currency)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$currency][$i] = $monthlyData[$i] ?? 0;
        }
    }


    //Recent Sales
    $recentSales = Order::with(['user', 'products', 'shipping', 'feedbacks.user'])
        ->where('status', 'paid')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        //Recent Customer
        $recentCustomers = User::where('role', 'customer')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

     // Fetch the top 5 most sold products by counting the occurrences in the 'order_product' pivot table
     $topProducts = Product::select('products.id', 
                               'products.name', 
                               'products.sku', 
                               'products.image', 
                               'products.price_usd', 
                               'products.category_id', 
                               'categories.name as category_name',  // Get category name
                               DB::raw('SUM(order_product.quantity) as total_quantity'))  // Calculate total quantity sold
    ->join('order_product', 'products.id', '=', 'order_product.product_id')
    ->join('categories', 'products.category_id', '=', 'categories.id')  // Join with categories to get category name
    ->groupBy('products.id', 'products.name', 'products.sku', 'products.image', 'products.price_usd', 'products.category_id', 'categories.name')
    ->orderByDesc('total_quantity')  // Order by total quantity sold in descending order
    ->limit(5)  // Limit to top 5 products
    ->get();

    //Subscribes
    $recentSubscribers = Subscriber::orderBy('created_at', 'desc')->limit(5)->get();

    //Low Stocks
    $lowStockProducts = Product::where('stock', '<', 6)->get();


        return view('admin/dashboard', compact(
        'staffCount',
        'customerCount',
        'subscriberCount',
        'orderCount',
        'orderSums',
        'chartData',
        'recentSales',
        'recentCustomers',
        'topProducts',
        'recentSubscribers',
        'lowStockProducts'
         ));
    }
}
