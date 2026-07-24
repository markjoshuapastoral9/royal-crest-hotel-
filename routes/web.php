<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\Admin\EmailBlastController;

use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Health check for Railway/monitoring
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String(),
        'app' => config('app.name'),
    ]);
});

// Temporary debug route - remove after fixing
Route::get('/debug-env', function () {
    return response()->json([
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'app_env' => config('app.env'),
        'app_url' => config('app.url'),
        'db_host' => config('database.connections.mysql.host'),
        'db_name' => config('database.connections.mysql.database'),
        'request_secure' => request()->isSecure(),
        'request_host' => request()->getHost(),
    ]);
});

// Temporary mail test route - remove after fixing
Route::get('/debug-mail', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test OTP mail from Railway at ' . now(), function ($msg) {
            $msg->to('markjoshuapastoral9@gmail.com')->subject('Railway Mail Test');
        });
        return response()->json(['status' => 'MAIL SENT OK', 'mailer' => config('mail.default')]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'MAIL FAILED', 'error' => $e->getMessage(), 'mailer' => config('mail.default')]);
    }
});
Route::get('/up', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String(),
        'app' => config('app.name'),
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// Packages
Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}/book', [App\Http\Controllers\PackageController::class, 'book'])->name('packages.book');
Route::get('/packages/{package}', [App\Http\Controllers\PackageController::class, 'show'])->name('packages.show');

// Dining
Route::get('/dining/restaurant', [App\Http\Controllers\DiningController::class, 'restaurant'])->name('dining.restaurant');
Route::get('/dining/menu', [App\Http\Controllers\DiningController::class, 'menu'])->name('dining.menu');
Route::get('/dining/private-dining', [App\Http\Controllers\DiningController::class, 'privateDining'])->name('dining.private');
Route::post('/dining/private-dining/reserve', [App\Http\Controllers\DiningController::class, 'storeReservation'])->name('dining.reservation.store');
Route::get('/dining/room-service', [App\Http\Controllers\DiningController::class, 'roomService'])->name('dining.room-service');

// Booking - check availability & apply promo (AJAX, no auth required)
Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check-availability');
Route::post('/booking/apply-promo', [BookingController::class, 'applyPromo'])->name('booking.apply-promo');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Booking
    Route::get('/booking/create/{room?}', [BookingController::class, 'create'])->name('booking.create');
    Route::get('/booking/calendar', [BookingController::class, 'calendar'])->name('booking.calendar');
    Route::get('/booking/{room}/booked-dates', [BookingController::class, 'bookedDates'])->name('booking.booked-dates');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/success/{booking}', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/receipt', [BookingController::class, 'downloadReceipt'])->name('booking.receipt');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/booking/{booking}/submit-payment', [BookingController::class, 'submitPayment'])->name('booking.submit-payment');

    // Customer Dashboard
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/bookings', [BookingController::class, 'myBookings'])->name('bookings');
        Route::get('/calendar', [BookingController::class, 'calendar'])->name('calendar');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [CustomerController::class, 'updatePassword'])->name('profile.password');
        Route::get('/invoice/{booking}', [CustomerController::class, 'downloadInvoice'])->name('invoice');
    });

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Temporary route to update capacities
    Route::get('/update-capacities', function () {
        $updated = \App\Models\Room::query()->update(['capacity' => 5]);
        return response()->json(['message' => "Updated {$updated} rooms capacity to 5"]);
    })->name('update-capacities');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/calendar', [AdminBookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/walk-in', [AdminBookingController::class, 'walkInForm'])->name('bookings.walk-in');
    Route::post('/bookings/walk-in', [AdminBookingController::class, 'walkInStore'])->name('bookings.walk-in.store');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/check-in', [AdminBookingController::class, 'checkIn'])->name('bookings.check-in');
    Route::post('/bookings/{booking}/check-out', [AdminBookingController::class, 'checkOut'])->name('bookings.check-out');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/invoice', [AdminBookingController::class, 'printInvoice'])->name('bookings.invoice');

    // Rooms
    Route::resource('rooms', AdminRoomController::class);
    Route::delete('/rooms/gallery/{gallery}', [AdminRoomController::class, 'deleteGallery'])->name('rooms.gallery.delete');

    // Room Types
    Route::get('/room-types', [RoomTypeController::class, 'index'])->name('room-types.index');
    Route::post('/room-types', [RoomTypeController::class, 'store'])->name('room-types.store');
    Route::put('/room-types/{roomType}', [RoomTypeController::class, 'update'])->name('room-types.update');
    Route::delete('/room-types/{roomType}', [RoomTypeController::class, 'destroy'])->name('room-types.destroy');

    // Amenities
    Route::get('/amenities', [AmenityController::class, 'index'])->name('amenities.index');
    Route::post('/amenities', [AmenityController::class, 'store'])->name('amenities.store');
    Route::put('/amenities/{amenity}', [AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('/amenities/{amenity}', [AmenityController::class, 'destroy'])->name('amenities.destroy');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');

    // Facilities
    Route::resource('facilities', FacilityController::class);

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/gallery/{gallery}/featured', [GalleryController::class, 'toggleFeatured'])->name('gallery.featured');

    // Promotions
    Route::resource('promotions', PromotionController::class);

    // Contacts
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // QR Check-in
    Route::get('/checkin/scan', [CheckInController::class, 'scan'])->name('checkin.scan');
    Route::post('/checkin/verify', [CheckInController::class, 'verify'])->name('checkin.verify');
    Route::post('/checkin/verify-booking', [CheckInController::class, 'verifyByBookingNumber'])->name('checkin.verify-booking');
    Route::post('/checkin/{booking}/checkin', [CheckInController::class, 'checkIn'])->name('checkin.do');

    // Email Blast
    Route::get('/email-blast', [EmailBlastController::class, 'index'])->name('email-blast.index');
    Route::post('/email-blast/send', [EmailBlastController::class, 'send'])->name('email-blast.send');
});

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function (string $locale) {
    $supported = ['en', 'fil', 'ja', 'ko', 'zh', 'es'];
    if (in_array($locale, $supported)) {
        session(['locale' => $locale]);
    }
    return redirect()->back()->withHeaders(['Vary' => 'Accept-Language']);
})->name('lang.switch');

// Breeze auth routes
require __DIR__.'/auth.php';

// Redirect /dashboard based on role (Breeze default)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');
