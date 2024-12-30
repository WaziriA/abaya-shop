<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ShopController;
use App\Http\Controllers\Store\ContactController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\WishListController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\ProductDetailController;
use App\Http\Controllers\Store\CheckOutController;
use App\Http\Controllers\Store\CustomerprofileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OfflineOrderController;
use App\Http\Controllers\Admin\StockLevelController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\TranspoterController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserActivityController;
use Spatie\Browsershot\Browsershot;

Route::get('/export-pdf/{order}', function ($orderId) {
    // Fetch the order using the order ID
    $order = App\Models\Order::findOrFail($orderId);

    // Render the modal content as an HTML view
    $html = view('store/account/orderdetailsPdf', compact('order'))->render();

    // Generate the PDF
    Browsershot::html($html)
        ->format('A4')
        ->save(public_path('order-details-' . $order->id . '.pdf'));

    return response()->download(public_path('order-details-' . $order->id . '.pdf'));
})->name('export.pdf');

//Countries
Route::get('/countries', [CountryController::class, 'getCountries']);

Route::get('test', [UserController::class, 'testDeviceInfo'])->name('test');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.index');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
//get related data
Route::post('/get-related-data', [CartController::class, 'getRelatedData']);

//Forget Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

//Reset Password
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::get('register', [RegistrationController::class, 'showRegistrationForm'])->name('register.index');
Route::post('register', [RegistrationController::class, 'register'])->name('register');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/add-to-cart/{productId}', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/remove-from-cart', [HomeController::class, 'removeFromCart'])->name('cart.remove');

//
Route::post('/subscribe', [SubscriberController::class, 'CustomerSubscription'])->name('subscriber.store');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');




//cart
Route::get('/Cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/removeProduc-from-cart', [CartController::class, 'removeProductFromCart'])->name('cart.removeProduct');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/calculate-shipping-cost', [CartController::class, 'calculateShippingCost'])->name('cart.calculateShippingCost');


//Check Out
Route::get('/check-out', [CheckOutController::class, 'index'])->name('check-out.index');
//Route::get('/get-agent-details/{transpoter_id}', [CheckOutController::class, 'getAgentDetails'])->name('getAgentDetails');
Route::get('/get-shipment-methods', [CheckOutController::class, 'getShipmentMethods'])->name('getShipmentMethods');
Route::get('/get-destination-countries', [CheckOutController::class, 'getDestinationCountries'])->name('getDestinationCountries');
Route::get('/calculate-shipping-cost', [CheckOutController::class, 'calculateShippingCost'])->name('calculateShippingCost');


Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contacts/add', [ContactController::class, 'store'])->name('contacts.store');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');


Route::get('/product-details', [ProductController::class, 'index'])->name('product.index');

Route::get('/product-details/Single-product', [ProductDetailController::class, 'index'])->name('product-detail.index');
Route::get('/product-detail/{id}', [ProductDetailController::class, 'show'])->name('single-detail.index');
Route::post('/products/{product}/reviews', [ProductDetailController::class, 'store'])->name('reviews.store');



Route::middleware('auth')->group(function () {

    //For store
    Route::get('/wish-list', [WishListController::class, 'index'])->name('wish-list.index');
    Route::delete('/wishlist/{id}', [WishListController::class, 'destroy'])->name('wishlist.remove');
    Route::post('/wishlist/add/{productId}', [WishListController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/customer/profile', [CustomerprofileController::class, 'index'])->name('customer-profile.index');
    Route::post('/feedback', [CustomerprofileController::class, 'store'])->name('feedback.store');
    
    //For Admin
    // Dashboard Home
    Route::get('/admin/dashboard/home', [DashboardController::class, 'index'])->name('dashboard.index');

    // CMS
    Route::get('/admin/dashboard/CMS/home', [IndexController::class, 'index'])->name('cms.index');
    Route::post('/admin/dashboard/CMS/home/add', [IndexController::class, 'store'])->name('cms.store');
    Route::post('/admin/dashboard/CMS/home/update/{id}', [IndexController::class, 'update'])->name('cms.update');
    Route::delete('/admin/dashboard/CMS/home/soft-delete/{id}', [IndexController::class, 'softDelete'])->name('carousel.softDelete');
    Route::delete('/admin/dashboard/CMS/home/hard-delete/{id}', [IndexController::class, 'hardDelete'])->name('carousel.hardDelete');
    Route::get('/admin/dashboard/CMS/home/trashed', [IndexController::class, 'trashedItems'])->name('carousel.trashed');
    Route::post('/carousel/restore/{id}', [IndexController::class, 'restore'])->name('carousel.restore');
    Route::post('/admin/add', [UserController::class, 'store'])->name('home.store');

    // Users
    Route::get('/admin/dashboard/users/index', [UserController::class, 'index'])->name('user.index');
    Route::post('/admin/dashboard/users/update/{id}', [UserController::class, 'update'])->name('admin-users.update');
    Route::post('/admin/dashboard/users/soft-delete/{id}', [UserController::class, 'softDelete'])->name('admin-users.softDelete');
    Route::post('/admin/dashboard/users/hard-delete/{id}', [UserController::class, 'hardDelete'])->name('admin-users.hardDelete');
    Route::get('/admin/dashboard/users/Trash', [UserController::class, 'showTrashed'])->name('admin-users.showTrash');
    Route::post('/admin/dashboard/users/restore/{id}', [UserController::class, 'restore'])->name('admin-users.restore');

    //UserActivities
    Route::get('/admin/dashboard/users/activies', [UserActivityController::class, 'index'])->name('user-activity.index');
    Route::get('/user/{id}/activities/{month}', [UserActivityController::class, 'showDetails'])->name('user.activities.details');
    
    // Subscribers
    Route::get('/admin/dashboard/users/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::post('/admin/dashboard/users/add', [SubscriberController::class, 'store'])->name('subscribers.store');
    

    // Owners
    Route::get('/admin/dashboard/users/owners', [OwnerController::class, 'index'])->name('owner.index');
    Route::get('/admin/dashboard/users/staffs', [OwnerController::class, 'showStaffs'])->name('showStaffs.index');

    // Customer
    Route::get('/admin/dashboard/users/customers', [CustomerController::class, 'index'])->name('customer.index');

    // Products
    Route::get('/admin/dashboard/inventory/products', [AdminProductController::class, 'index'])->name('admin-product.index');
    Route::post('products/add', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::post('/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/soft-delete/{id}', [AdminProductController::class, 'softDelete'])->name('products.softDelete');
    Route::delete('/force-delete/{id}', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');
    Route::patch('/restore/{id}', [AdminProductController::class, 'restore'])->name('products.restore');
    Route::get('/admin/dashboard/inventory/products/deleted', [AdminProductController::class, 'deletedItems'])->name('products.deleted');
    Route::get('/products/reviews', [AdminProductController::class, 'getReviews'])->name('admin.reviews');

    // Category
    Route::get('/admin/dashboard/inventory/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/admin/dashboard/inventory/category/add', [CategoryController::class, 'store'])->name('category.store');
    
    // Order
    Route::get('/admin/dashboard/order/view', [OrderController::class, 'index'])->name('order.index');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('placeOrder');
    Route::get('/paypal-success', [OrderController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal-cancel', [OrderController::class, 'paypalCancel'])->name('paypal.cancel');
    Route::post('/orders/{id}/update-shipping-status', [OrderController::class, 'updateShippingStatus'])->name('orders.updateShippingStatus');
    Route::get('/orders/{id}/view', [OrderController::class, 'viewOrderDetails'])->name('orders.view');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/hard-delete/{id}', [OrderController::class, 'hardDelete'])->name('orders.hardDelete');
//Sripe
    Route::post('/stripe/intent', [OrderController::class, 'handleCreditCardPayment']);
    Route::get('/stripe/success', [OrderController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('/stripe/cancel', [OrderController::class, 'stripeCancel'])->name('stripe.cancel');

    //ApplePay
    // Routes for Apple Pay
   Route::get('/app-pay/handle-payment', [OrderController::class, 'handleAppPayPayment'])->name('app-pay.handle');
   Route::get('/app-pay/success', [OrderController::class, 'AppPaySuccess'])->name('app-pay.success');
   Route::get('/app-pay/cancel', [OrderController::class, 'AppPayCancel'])->name('app-pay.cancel');
   Route::get('/order/{order}/pdf', [OrderController::class, 'generatePDF'])->name('order.pdf');
   Route::get('/order/Feedback/', [OrderController::class, 'getFeedback'])->name('order.feedback');


    // Offline Order
    Route::get('/admin/dashboard/order/offline-order', [OfflineOrderController::class, 'index'])->name('offline-order.index');
    Route::get('/admin/dashboard/order/offline-order/complete', [OfflineOrderController::class, 'completeOrders'])->name('complete-order.index');
    Route::get('/admin/dashboard/order/offline-order/in-transit', [OfflineOrderController::class, 'transitOrders'])->name('transit-order.index');
    Route::get('/admin/dashboard/order/offline-order/pending', [OfflineOrderController::class, 'pendingOrders'])->name('pending-order.index');

    // Stocks Level
    Route::get('/admin/dashboard/inventory/stocks', [StockLevelController::class, 'index'])->name('stock.index');
    Route::post('/product/{id}/update-stock', [StockLevelController::class, 'updateStock'])->name('product.updateStock');

    // Category
    Route::post('/admin/categories/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/admin/categories/soft-delete/{id}', [CategoryController::class, 'softDelete'])->name('category.softDelete');
    Route::delete('/admin/categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('category.forceDelete');
    Route::get('/admin/categories/deleted', [CategoryController::class, 'deletedCategories'])->name('category.deleted');

    // Profile
    Route::get('/admin/dashboard/userdetails/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password.form');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    
    // Coupon
    Route::get('/admin/dashboard/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/show/{id}', [CouponController::class, 'show'])->name('admin.coupons.show');
    Route::put('/coupons/update/{id}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/{id}/delete', [CouponController::class, 'softDelete'])->name('coupons.softDelete');
    Route::get('admin/coupons/trashed', [CouponController::class, 'trashed'])->name('coupons.trashed');
    Route::post('admin/coupons/restore/{id}', [CouponController::class, 'restore'])->name('coupons.restore');
    Route::get('/coupons/expired', [CouponController::class, 'expiredCoupons'])->name('coupons.expired');

    // Shipping agent
    Route::get('/admin/dashboard/Shipping-Costs', [AgentController::class, 'index'])->name('cost.index');
    Route::post('/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('/{id}/update', [AgentController::class, 'update'])->name('agent.update');
    Route::delete('/{id}/destroy', [AgentController::class, 'destroy'])->name('agent.destroy');
    Route::delete('/{id}/forceDelete', [AgentController::class, 'forceDelete'])->name('forceDelete');
    Route::get('/trashed', [AgentController::class, 'trashed'])->name('agent.trashed');
    Route::post('/{id}/restore', [AgentController::class, 'restore'])->name('agents.restore');

    // Transpoter
    Route::get('/admin/dashboard/Shipping-Agents', [TranspoterController::class, 'index'])->name('transpoter.index');
    Route::post('/transpoter', [TranspoterController::class, 'store'])->name('transpoter.store');
    Route::post('/transpoter/{id}', [TranspoterController::class, 'update'])->name('transpoter.update');
    Route::delete('/transpoter/{id}', [TranspoterController::class, 'destroy'])->name('transpoter.destroy');
    Route::delete('/transpoter/{id}/force', [TranspoterController::class, 'forceDelete'])->name('transpoter.forceDelete');
    Route::get('/transporters/trashed', [TranspoterController::class, 'trashed'])->name('transporters.trashed');
    Route::post('/transporters/restore/{id}', [TranspoterController::class, 'restore'])->name('transporters.restore');
    Route::post('/shipment-method/store', [TranspoterController::class, 'storeShipmentMethod'])->name('shipment-method.store');
    Route::get('/shipment-method/{id}/edit', [TranspoterController::class, 'editShipment'])->name('shipment.edit');
    Route::post('/shipment-method/{id}/update', [TranspoterController::class, 'updateShipmentMethod'])->name('shipment.update');
    Route::delete('/shipment-method/{id}/delete', [TranspoterController::class, 'deleteShipmentMethod'])->name('shipment.delete');
    Route::prefix('admin')->group(function() {
        // Delete shipment method
        Route::delete('/shipment-method/{id}', [TranspoterController::class, 'deleteShipmentMethod'])->name('shipmentMethod.delete');
    
        // Store a new destination country
        Route::post('/destination-country', [TranspoterController::class, 'storeDestinationCountry'])->name('storeDestinationCountry');
    
        // Update an existing destination country
        Route::post('/destination-country/{id}', [TranspoterController::class, 'updateDestinationCountry'])->name('updateDestinationCountry');
    
        // Delete a destination country
        Route::delete('/destination-country/{id}', [TranspoterController::class, 'deleteDestinationCountry'])->name('deleteDestinationCountry');
    });

    //Testimonial
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

    // Show form to create a new testimonial
    Route::get('testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('testimonials/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});
