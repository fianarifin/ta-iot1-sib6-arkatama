<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    return view('layouts.landing');
});

Route::get('/dashboard', function () {
    $data['title'] = 'Dashboard';
    $data['breadcrumbs'][]= [
        'title' => 'Dashboard' ,
        'url' => route('dashboard')
    ];
    return view('pages.dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/user', function () {
//     return view('pages.dashboard');
// })->name('user');

// Route::get('/led-control', function () {
//     return view('led-control');
// })->name('led-control');

// Route::get('/sensor', function () {
//     return view('layouts/sensor');
// })->name('sensor');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //user
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';
