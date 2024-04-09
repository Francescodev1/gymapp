<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rotte per le "Prenotazioni"
Route::get('/bookings', [BookingController::class, 'index'])->middleware(['auth'])->name('bookings.index');

// Route::middleware(['is_admin'])->group(function () {
//     Route::get('activities/create', 'ActivityController@create')->name('activities.create');
//     Route::post('activities', 'ActivityController@store')->name('activities.store');
//     Route::get('activities/{activity}/edit', 'ActivityController@edit')->name('activities.edit');
//     Route::patch('activities/{activity}', 'ActivityController@update')->name('activities.update');
//     Route::delete('activities/{activity}', 'ActivityController@destroy')->name('activities.destroy');
// });

// web.php
Route::get('/activities/list', [ActivityController::class, 'list'])->name('activities.list');

Route::middleware(['is_admin'])->group(function () {
 Route::resource('activities', ActivityController::class); 


});


Route::post('/bookings/{booking}/changeStatus', [BookingController::class, 'changeStatus'])->name('bookings.changeStatus');
// routes/web.php
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store'); 
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');



require __DIR__.'/auth.php';
