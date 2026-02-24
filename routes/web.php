<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User;
use App\Models\Place;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tickets = Ticket::where('is_active', true)
        ->where('name', 'Tiket Masuk')
        ->orderBy('id')
        ->limit(1)
        ->get();

    if ($tickets->isEmpty()) {
        $tickets = Ticket::where('is_active', true)->orderBy('id')->limit(1)->get();
    }

    $places = Place::where('is_active', true)->orderBy('name')->get();

    return view('index', compact('tickets', 'places'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/tiket', [User\TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tiket/order', [User\TicketController::class, 'order'])->name('tickets.order');
    Route::get('/tiket/payment/{code}', [User\TicketController::class, 'payment'])->name('tickets.payment');
    Route::post('/tiket/upload/{code}', [User\TicketController::class, 'uploadProof'])->name('tickets.upload');
    Route::get('/tiket/download/{code}', [User\TicketController::class, 'download'])->name('tickets.download');
    Route::get('/tiket/pdf/{itemId}', [User\TicketController::class, 'downloadPdf'])->name('tickets.pdf');
    Route::get('/tiket/riwayat', [User\TicketController::class, 'history'])->name('tickets.history');

    Route::get('/booking', [User\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/booking/store', [User\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/payment/{code}', [User\BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/booking/upload/{code}', [User\BookingController::class, 'uploadProof'])->name('bookings.upload');
    Route::get('/booking/status/{code}', [User\BookingController::class, 'status'])->name('bookings.status');
    Route::get('/booking/check-date', [User\BookingController::class, 'checkDate'])->name('bookings.checkDate');
    Route::get('/booking/riwayat', [User\BookingController::class, 'history'])->name('bookings.history');

    Route::get('/profil', [User\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [User\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tickets', Admin\TicketController::class)->except('show');

    Route::get('ticket-orders', [Admin\TicketOrderController::class, 'index'])->name('ticket-orders.index');
    Route::get('ticket-orders/{id}', [Admin\TicketOrderController::class, 'show'])->name('ticket-orders.show');
    Route::post('ticket-orders/{id}/confirm', [Admin\TicketOrderController::class, 'confirm'])->name('ticket-orders.confirm');
    Route::post('ticket-orders/{id}/reject', [Admin\TicketOrderController::class, 'reject'])->name('ticket-orders.reject');

    Route::get('bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}', [Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{id}/confirm', [Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{id}/reject', [Admin\BookingController::class, 'reject'])->name('bookings.reject');

    Route::resource('admins', Admin\AdminController::class)->except('show');

    Route::get('profil', [Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profil', [Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('check/ticket', [Admin\CheckController::class, 'ticketIndex'])->name('check.ticket');
    Route::post('check/ticket', [Admin\CheckController::class, 'checkTicket'])->name('check.ticket.check');
    Route::get('check/booking', [Admin\CheckController::class, 'bookingIndex'])->name('check.booking');
    Route::post('check/booking', [Admin\CheckController::class, 'checkBooking'])->name('check.booking.check');

    Route::resource('bank-accounts', Admin\BankAccountController::class)->except('show');
});