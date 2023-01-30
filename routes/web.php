<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\AdminAddBooking;
use App\Http\Livewire\Admin\AdminBookingReport;
use App\Http\Livewire\Admin\AdminBookings;
use App\Http\Livewire\Admin\AdminCash;
use App\Http\Livewire\Admin\AdminCashReport;
use App\Http\Livewire\Admin\AdminClients;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\AdminDrivers;
use App\Http\Livewire\Admin\AdminIncentive;
use App\Http\Livewire\Admin\AdminSettings;
use App\Http\Livewire\Admin\AdminTracking;
use App\Http\Livewire\Admin\AdminUpdateBooking;
use App\Http\Livewire\Admin\AdminVehicles;
use App\Http\Livewire\Admin\AdminViewBooking;
use App\Http\Livewire\Client\ClientAddBooking;
use App\Http\Livewire\Client\ClientBookingList;
use App\Http\Livewire\Client\ClientDashboard;
use App\Http\Livewire\Client\ClientSettings;
use App\Http\Livewire\Client\ClientTracking;
use App\Http\Livewire\Client\ClientUpdateBooking;
use App\Http\Livewire\Client\ClientViewBooking;
use App\Http\Livewire\User\UserDashboard;
use App\Http\Livewire\User\UserSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['prefix'=>'admin','as'=>'admin.', 'middleware'=>['isAdmin','auth','verified']], function (){
    $routeArr = [
        'dashboard'=>AdminDashboard::class,'settings'=>AdminSettings::class, 'clients'=>AdminClients::class,
        'drivers'=>AdminDrivers::class,'vehicles'=>AdminVehicles::class, 'booking-list'=> AdminBookings::class,
        'add-booking'=> AdminAddBooking::class,'incentives-&-expenses'=> AdminCash::class,
        'booking-report'=> AdminBookingReport::class, 'expenses-&-incentives'=>AdminCashReport::class,
        'incentive' => AdminIncentive::class

    ];
    foreach ($routeArr as $uri=> $data){
        Route::get($uri,$data )->name($uri);
    }
    Route::get('/ei-report', [AdminCashReport::class, 'report' ])->name('ei.report');
    Route::get('booking-report-report', [AdminBookingReport::class, 'rBooking' ])->name('report.report.bookings');
    Route::get('booking-details/{booking}', AdminViewBooking::class)->name('booking-details');
    Route::get('tracking/{booking}', AdminTracking::class)->name('tracking');
    Route::get('update-booking/{booking}', AdminUpdateBooking::class)->name('update.bookings');
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth']], function (){
    Route::get('dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('settings', UserSettings::class)->name('user.settings');
});

Route::group(['prefix'=>'client', 'middleware'=>['isClient','auth', 'verified']], function (){
    Route::get('dashboard', ClientDashboard::class)->name('client.dashboard');
    Route::get('booking-list', ClientBookingList::class)->name('client.booking-list');
    Route::get('request-booking', ClientAddBooking::class)->name('client.request-booking');
    Route::get('settings', ClientSettings::class)->name('client.settings');
    Route::get('booking-details/{booking}', ClientViewBooking::class)->name('client.booking-details');
    Route::get('update-booking/{booking}', ClientUpdateBooking::class)->name('client.update.bookings');
    Route::get('tracking/{booking}', ClientTracking::class)->name('client.tracking');
});
