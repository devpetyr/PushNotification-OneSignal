<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send', [NotificationController::class, 'sendNotification'])->name('sendNotification');

Route::get('/player/{playerId}', [NotificationController::class, 'getUserDetails'])->name('getUserDetails');

Route::get('/device', [NotificationController::class, 'getDeviceType'])->name('getDeviceType');

Route::get('/player', [NotificationController::class, 'sendPlayer'])->name('sendPlayer');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

