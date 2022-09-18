<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\AdminAddBooking;
use App\Http\Livewire\Admin\AdminBookings;
use App\Http\Livewire\Admin\AdminClients;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\AdminDrivers;
use App\Http\Livewire\Admin\AdminSettings;
use App\Http\Livewire\Admin\AdminVehicles;
use App\Http\Livewire\Client\ClientDashboard;
use App\Http\Livewire\Client\ClientSettings;
use App\Http\Livewire\User\UserDashboard;
use App\Http\Livewire\User\UserSettings;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['prefix'=>'admin','as'=>'admin.', 'middleware'=>['isAdmin','auth']], function (){
    $routeArr = [
        'dashboard'=>AdminDashboard::class,'settings'=>AdminSettings::class, 'clients'=>AdminClients::class,
        'drivers'=>AdminDrivers::class,'vehicles'=>AdminVehicles::class, 'booking-list'=> AdminBookings::class,
        'add-booking'=> AdminAddBooking::class,
    ];
    foreach ($routeArr as $uri=> $data){
        Route::get($uri,$data )->name($uri);
    }
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth']], function (){
    Route::get('dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('settings', UserSettings::class)->name('user.settings');
});

Route::group(['prefix'=>'client', 'middleware'=>['isClient','auth']], function (){
    Route::get('dashboard', ClientDashboard::class)->name('client.dashboard');
    Route::get('settings', ClientSettings::class)->name('client.settings');
});
