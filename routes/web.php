<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\WorkshopController as AdminWorkshopController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use App\Models\Registration;




Route::get('/payment/finish', [RegistrationController::class, 'paymentFinish'])->name('payment.finish');
Route::get('/payment/renew-token/{id}', [RegistrationController::class, 'renewToken'])->name('payment.renew');
// Tambahkan rute ini
Route::post('/payment/success-update', [RegistrationController::class, 'updatePaymentStatus']);
Route::post('/payment/simulate/{id}', [RegistrationController::class, 'simulatePaid'])->name('payment.simulate');
// Halaman Utama & Detail Workshop (Bisa diakses publik)
Route::get('/', [WorkshopController::class, 'index'])->name('home');
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshop/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');

// Route khusus User yang sudah login (Authenticated)
Route::middleware(['auth'])->group(function () {
    // Halaman Tiket Saya / Dashboard Peserta (Mengirim variabel $registrations dengan benar)
    Route::get('/tickets', function () {
        $registrations = Registration::where('user_id', Auth::id())->with('workshop')->latest()->get();
        return view('dashboard', compact('registrations'));
    })->name('registrations.index');

    // Proses Pendaftaran Workshop
    Route::post('/workshop/{workshop}/register', [RegistrationController::class, 'store'])->name('workshops.register');

    // TAMBAHKAN RUTE INI UNTUK DETAIL TIKET
    Route::get('/tickets/{registration}', [TicketController::class, 'show'])->name('tickets.show');
    // Route download PDF tiket
    Route::get('/tickets/{registration}/download', [TicketController::class, 'downloadPdf'])->name('tickets.download');

    // Profile Management (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route khusus Admin / Panitia
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('workshops', AdminWorkshopController::class);
    Route::resource('categories', CategoryController::class);
});

// Dashboard bawaan Breeze (Bisa diarahkan ke /tickets atau dibiarkan)
Route::get('/dashboard', function () {
    $registrations = Registration::where('user_id', Auth::id())->with('workshop')->latest()->get();
    return view('dashboard', compact('registrations'));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';