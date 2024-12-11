<?php
use Illuminate\Support\Facades\Route;
use App\Services\Cart;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\RegistrationController;
use App\Http\Controllers\Front\SessionsController;
use App\Http\Controllers\Front\UserProfileController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\SaveLaterController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UsersController;



/*  * Admin Routes  */
Route::prefix('admin')->group(function() {
    Route::middleware('auth:admin')->group(function() {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index']);

        // Products
        Route::resource('/products', ProductController::class);

        // Orders
        Route::resource('/orders', OrderController::class);
        Route::get('/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm');
        Route::get('/pending/{id}', [OrderController::class, 'pending'])->name('order.pending');
        Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('order.details');
        Route::get('/dashboard/sales', [DashboardController::class, 'getSalesData'])->name('dashboard.sales');



        // Users
        Route::resource('/users', UsersController::class);

        // Logout
        Route::get('/logout', [AdminUserController::class, 'logout']);
    });

    // Admin Login
    Route::get('/login', [AdminUserController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminUserController::class, 'store']);
});

/*  * Front Routes  */
Route::get('/', [HomeController::class, 'index']);

// User Registration
Route::get('/user/register', [RegistrationController::class, 'index']);
Route::post('/user/register', [RegistrationController::class, 'store']);

// User Login
Route::get('/user/login', [SessionsController::class, 'index']);
Route::post('/user/login', [SessionsController::class, 'store']);

// Logout
Route::get('/user/logout', [SessionsController::class, 'logout']);

Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
Route::get('/user/profile/order/{id}', [UserProfileController::class, 'show'])->name('user.profile.order');
Route::get('/user/order/{id}', [UserProfileController::class, 'show']);

// Cart
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store'])->name('cart');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/saveLater/{product}', [CartController::class, 'saveLater'])->name('cart.saveLater');

// Save for later
Route::delete('/saveLater/destroy/{product}', [SaveLaterController::class, 'destroy'])->name('saveLater.destroy');
Route::post('/cart/moveToCart/{product}', [SaveLaterController::class, 'moveToCart'])->name('moveToCart');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');

Route::get('empty', function(Cart $cart) {
    $cart->clear();
});




