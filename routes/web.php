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

// Fallback for Railway Symlink Issues: Serve storage files directly via PHP if Nginx can't find the symlink
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    
    abort(404);
})->where('path', '.*');
