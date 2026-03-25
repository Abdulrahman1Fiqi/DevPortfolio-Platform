<?php

use App\Http\Controllers\Developer\DashboardController;
use App\Http\Controllers\Developer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/portfolio/{username}', function ($username) {
    
})->name('portfolio.show');



// Developer routes

Route::middleware(['auth','role:developer'])
        ->prefix('dashboard')
        ->name('developer.')
        ->group(function(){

    Route::get('/',[DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/profile',[ProfileController::class,'edit'])
        ->name('profile.edit');

    Route::post('/profile',[ProfileController::class,'update'])
        ->name('profile.update');

    // Toggle published status
    Route::patch('/portfolio/toggle-publish',[ProfileController::class,'togglePublish'])
        ->name('portfolio.toggle-publish');
});



// Recruiter routes

Route::middleware(['auth','role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function(){

    Route::get('/dashboard',function(){
        return view('recruiter.dashboard');
    })->name('dashboard');

});



// Admin routes

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){

    Route::get('/dashboard',function(){
        return view('admin.dashboard');
    })->name('dashboard');

});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
