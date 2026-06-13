<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/showroom', [ShowroomController::class, 'index'])->name('showroom');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Customer authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('products', [Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/invoice', [Admin\OrderController::class, 'generateInvoice'])->name('orders.invoice');

    // Invoices
    Route::get('invoices', [Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}', [Admin\InvoiceController::class, 'show'])->name('invoices.show');
    Route::patch('invoices/{invoice}/status', [Admin\InvoiceController::class, 'updateStatus'])->name('invoices.status');
    Route::get('invoices/{invoice}/download', [Admin\InvoiceController::class, 'download'])->name('invoices.download');

    // 3D Showroom
    Route::get('showroom', [Admin\ShowroomController::class, 'index'])->name('showroom.index');
    Route::post('showroom', [Admin\ShowroomController::class, 'store'])->name('showroom.store');
    Route::put('showroom/{showroomModel}', [Admin\ShowroomController::class, 'update'])->name('showroom.update');
    Route::delete('showroom/{showroomModel}', [Admin\ShowroomController::class, 'destroy'])->name('showroom.destroy');

    // ERM - Employees
    Route::get('erm/employees', [Admin\EmployeeController::class, 'index'])->name('erm.employees.index');
    Route::post('erm/employees', [Admin\EmployeeController::class, 'store'])->name('erm.employees.store');
    Route::put('erm/employees/{employee}', [Admin\EmployeeController::class, 'update'])->name('erm.employees.update');
    Route::delete('erm/employees/{employee}', [Admin\EmployeeController::class, 'destroy'])->name('erm.employees.destroy');

    // ERM - Suppliers
    Route::get('erm/suppliers', [Admin\SupplierController::class, 'index'])->name('erm.suppliers.index');
    Route::post('erm/suppliers', [Admin\SupplierController::class, 'store'])->name('erm.suppliers.store');
    Route::put('erm/suppliers/{supplier}', [Admin\SupplierController::class, 'update'])->name('erm.suppliers.update');
    Route::delete('erm/suppliers/{supplier}', [Admin\SupplierController::class, 'destroy'])->name('erm.suppliers.destroy');

    // Customers
    Route::get('customers', [Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::patch('customers/{customer}/toggle', [Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggle');
});
