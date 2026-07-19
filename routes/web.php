<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableQrController;
use App\Livewire\Customer\MenuView;
use App\Livewire\Customer\Checkout;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/admin/login')->name('login');

// Download QR Code Meja (hanya yang sudah login/admin, tapi biar gampang kita taruh di middleware auth atau diluar jika urlnya diamankan via route model binding/gate, sementara kita buat di luar dengan middleware default Filament auth jika memungkinkan)
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/tables/{table}/qr', TableQrController::class)->name('table.qr.download');
});

// Tampilan Menu Pelanggan (Customer App)
Route::get('/menu/{slug}/{token?}', MenuView::class)->name('customer.menu');
Route::get('/checkout/{slug}/{token?}', Checkout::class)->name('customer.checkout');

// Payment Webhook (Midtrans Mock) - Exempt from CSRF
Route::post('/api/webhooks/midtrans', [\App\Http\Controllers\Api\PaymentWebhookController::class, 'midtrans'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

// Subscription Expired Page
Route::view('/subscription-expired', 'subscription-expired')->name('subscription.expired');

// Bulletproof route to serve images, bypassing any Nginx symlink interference
Route::get('/menu-image/{path}', function ($path) {
    $publicPath = storage_path('app/public/' . $path);
    $privatePath = storage_path('app/private/' . $path); 
    $legacyPath = storage_path('app/' . $path);
    
    if (file_exists($publicPath)) {
        return response()->file($publicPath);
    } elseif (file_exists($privatePath)) {
        return response()->file($privatePath);
    } elseif (file_exists($legacyPath)) {
        return response()->file($legacyPath);
    }
    
    abort(404);
})->where('path', '.*')->name('menu.image');
