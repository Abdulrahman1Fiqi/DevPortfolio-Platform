<?php

use App\Http\Controllers\Developer\DashboardController;
use App\Http\Controllers\Developer\ProfileController;
use App\Http\Controllers\Developer\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\ProjectController;
use App\Http\Controllers\Developer\ExperienceController;

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

    //Projects
    Route::resource('projects',ProjectController::class)
            ->except(['show']);

    // Skills
    Route::resource('skills',SkillController::class)
            ->only(['index','store','destroy']);

    // Experience
    Route::resource('experience', ExperienceController::class)
            ->except(['show']);

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





require __DIR__.'/auth.php';
