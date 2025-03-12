<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Member;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Role-based route for user 1 (admin)
Route::middleware(['auth',  RoleMiddleware::class . ':1'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('admin.dashboard');
    
    Route::get('/members', [Member::class, 'index'])->name('members.index');

    Route::put('/update-role', [Member::class, 'updateRole'])->name('update.role');

    Route::put('/update-expired/{id}', [Member::class, 'updateExpiredDate'])->name('update.expired_date');

    Route::delete('/members/{id}', [Member::class, 'destroy'])->name('members.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () { return view('home'); })->name('user.home');

    Route::get('/profile', function () { return view('profile'); })->name('profile');

    Route::get('/print', function () { return view('print'); })->name('print');

    Route::put('/update-basic', [Member::class, 'basic_update'])->name('update.basic');

    Route::put('/update-additional', [Member::class, 'additional_update'])->name('update.additional');
    
    Route::delete('/suicide', [ProfileController::class, 'destroy'])->name('self.destroy');

    Route::get('/print', function () { return view('print'); })->name('print');
});