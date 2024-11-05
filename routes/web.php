<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ShopController;
use App\Http\Controllers\Store\ContactController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\CheckOutController;
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


//Countries
Route::get('/countries', [CountryController::class, 'getCountries']);


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegistrationController::class, 'register'])->name('register');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/add-to-cart/{productId}', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/remove-from-cart', [HomeController::class, 'removeFromCart'])->name('cart.remove');


Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

//cart
Route::get('/Cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/removeProduc-from-cart', [CartController::class, 'removeProductFromCart'])->name('cart.removeProduct');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');


//Check Out
Route::get('/check-out', [CheckOutController::class, 'index'])->name('check-out.index');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

Route::get('/product-details', [ProductController::class, 'index'])->name('product.index');

Route::get('/admin/dashboard/home', [DashboardController::class, 'index'])->name('dashboard.index');

//CMS
Route::get('/admin/dashboard/CMS/home', [IndexController::class, 'index'])->name('cms.index');
Route::post('/admin/dashboard/CMS/home/add', [IndexController::class, 'store'])->name('cms.store');
Route::post('/admin/dashboard/CMS/home/update/{id}', [IndexController::class, 'update'])->name('cms.update');
Route::delete('/admin/dashboard/CMS/home/soft-delete/{id}', [IndexController::class, 'softDelete'])->name('carousel.softDelete');
Route::delete('/admin/dashboard/CMS/home/hard-delete/{id}', [IndexController::class, 'hardDelete'])->name('carousel.hardDelete');
Route::get('/admin/dashboard/CMS/home/trashed', [IndexController::class, 'trashedItems'])->name('carousel.trashed');
Route::post('/carousel/restore/{id}', [IndexController::class, 'restore'])->name('carousel.restore');
Route::post('/admin/add', [UserController::class, 'store'])->name('home.store');


//All Users
Route::get('/admin/dashboard/users/index', [UserController::class, 'index'])->name('user.index');
//Route::post('/admin/dashboard/users/add', [UserController::class, 'store'])->name('users.store');
//Route::post('/admin/dashboard/users/add', [UserController::class, 'store'])->name('admin.storeUser');
Route::post('/admin/dashboard/users/update/{id}', [UserController::class, 'update'])->name('admin-users.update');
Route::post('/admin/dashboard/users/soft-delete/{id}', [UserController::class, 'softDelete'])->name('admin-users.softDelete');
Route::post('/admin/dashboard/users/hard-delete/{id}', [UserController::class, 'hardDelete'])->name('admin-users.hardDelete');
Route::get('/admin/dashboard/users/Trash', [UserController::class, 'showTrashed'])->name('admin-users.showTrash');
Route::post('/admin/dashboard/users/restore/{id}', [UserController::class, 'restore'])->name('admin-users.restore');

//Subscribers
Route::get('/admin/dashboard/users/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
Route::post('/admin/dashboard/users/add', [SubscriberController::class, 'store'])->name('subscribers.store');


//Owners
Route::get('/admin/dashboard/users/owners', [OwnerController::class, 'index'])->name('owner.index');
Route::get('/admin/dashboard/users/staffs', [OwnerController::class, 'showStaffs'])->name('showStaffs.index');

//Customer 
Route::get('/admin/dashboard/users/customers', [CustomerController::class, 'index'])->name('customer.index');

//Products
Route::get('/admin/dashboard/inventory/products', [AdminProductController::class, 'index'])->name('admin-product.index');
Route::post('products/add', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::post('/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
 // Soft delete
 Route::delete('/soft-delete/{id}', [AdminProductController::class, 'softDelete'])->name('products.softDelete');

 // Hard delete (force delete)
 Route::delete('/force-delete/{id}', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');

 // Restore deleted product
 Route::patch('/restore/{id}', [AdminProductController::class, 'restore'])->name('products.restore');
//SoftDelete
Route::delete('/soft-delete/{id}', [AdminProductController::class, 'softDelete'])->name('products.softDelete');

 // View deleted items
 Route::get('/admin/dashboard/inventory/products/deleted', [AdminProductController::class, 'deletedItems'])->name('products.deleted');


//Category
Route::get('/admin/dashboard/inventory/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/admin/dashboard/inventory/category/add', [CategoryController::class, 'store'])->name('category.store');


//This is for Order
Route::get('/admin/dashboard/order/view', [OrderController::class, 'index'])->name('order.index');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('placeOrder');
Route::get('/paypal-success', [OrderController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal-cancel', [OrderController::class, 'paypalCancel'])->name('paypal.cancel');



//Offline Order
Route::get('/admin/dashboard/order/offline-order', [OfflineOrderController::class, 'index'])->name('offline-order.index');
Route::get('/admin/dashboard/order/offline-order/complete', [OfflineOrderController::class, 'completeOrders'])->name('complete-order.index');
Route::get('/admin/dashboard/order/offline-order/in-transit', [OfflineOrderController::class, 'transitOrders'])->name('transit-order.index');
Route::get('/admin/dashboard/order/offline-order/pending', [OfflineOrderController::class, 'pendingOrders'])->name('pending-order.index');

//Stocks Level
route::get('/admin/dashboard/inventory/stocks', [StockLevelController::class, 'index'])->name('stock.index');
Route::post('/product/{id}/update-stock', [StockLevelController::class, 'updateStock'])->name('product.updateStock');

//Category
Route::post('/admin/categories/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/admin/categories/soft-delete/{id}', [CategoryController::class, 'softDelete'])->name('category.softDelete');
Route::delete('/admin/categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('category.forceDelete');
Route::get('/admin/categories/deleted', [CategoryController::class, 'deletedCategories'])->name('category.deleted');


//Profile
route::get('/admin/dashboard/userdetails/profile', [ProfileController::class, 'index'])->name('profile.index');

//Coupon
route::get('/admin/dashboard/coupon', [CouponController::class, 'index'])->name('coupon.index');
Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
Route::get('/coupons/show/{id}', [CouponController::class, 'show'])->name('admin.coupons.show');
Route::put('/coupons/update/{id}', [CouponController::class, 'update'])->name('admin.coupons.update');
Route::delete('/admin/coupons/{id}/delete', [CouponController::class, 'softDelete'])->name('coupons.softDelete');
Route::get('admin/coupons/trashed', [CouponController::class, 'trashed'])->name('coupons.trashed');
Route::post('admin/coupons/restore/{id}', [CouponController::class, 'restore'])->name('coupons.restore');
Route::get('/coupons/expired', [CouponController::class, 'expiredCoupons'])->name('coupons.expired');
