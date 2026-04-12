<?php

use App\Http\Controllers\Developer\DashboardController;
use App\Http\Controllers\Developer\ProfileController;
use App\Http\Controllers\Developer\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\ProjectController;
use App\Http\Controllers\Developer\ExperienceController;
use App\Http\Controllers\Public\PortfolioController;
use App\Http\Controllers\Public\AnalyticsController as PublicAnalyticsController;
use App\Http\Controllers\Public\DeveloperDirectoryController;
use App\Http\Controllers\Recruiter\ConnectionController as RecruiterConnectionController;
use App\Http\Controllers\Developer\ConnectionController as DeveloperConnectionController; 
use App\Http\Controllers\Developer\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/portfolio/{username}', [PortfolioController::class, 'show'])
        ->name('portfolio.show');

Route::post('/analytics/track',[PublicAnalyticsController::class,'track'])
        ->name('analytics.track');

Route::get('/developers',[DeveloperDirectoryController::class,'index'])
        ->name('developers.index');

Route::post('/connections/{username}',[RecruiterConnectionController::class,'store'])
        ->middleware(['auth','role:recruiter'])
        ->name('connections.store');

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

    // Connections
    Route::get('/connections',[DeveloperConnectionController::class,'index'])
            ->name('connections.index');

    Route::patch('/connections/{connection}/accept',
                    [DeveloperConnectionController::class,'accept'])
            ->name('connections.accept');

    Route::patch('/connections/{connection}/decline',
                    [DeveloperConnectionController::class,'decline'])
            ->name('connections.decline');

    // Analytics
    Route::get('/analytics',[AnalyticsController::class, 'index'])
            ->name('analytics.index');

});



// Recruiter routes

Route::middleware(['auth','role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function(){

    Route::get('/dashboard',function(){
        return view('recruiter.dashboard');
    })->name('dashboard');

    // Connections
    Route::get('/connections',[RecruiterConnectionController::class,'index'])
            ->name('connections.index');

    Route::delete('/connections/{id}',[RecruiterConnectionController::class,'destroy'])
            ->name('connections.destroy');
});



// Admin routes

Route::middleware(['auth','role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function(){

    // Dashboard
    Route::get('/dashboard',[AdminDashboardController::class, 'index'])
        ->name('dashboard');

   // Users
   Route::get('/users',[AdminUserController::class,'index'])
        ->name('users.index');

   Route::get('/users/{user}',[AdminUserController::class,'show'])
        ->name('users.show');

   Route::patch('/users/{user}/suspend',[AdminUserController::class,'suspend'])
        ->name('users.suspend');

   Route::patch('/users/{user}/activate',[AdminUserController::class,'activate'])
        ->name('users.activate');

   Route::delete('/users/{user}',[AdminUserController::class,'destroy'])
        ->name('users.destroy');

   // Portfolios
   Route::get('/portfolios',[AdminPortfolioController::class, 'index'])
        ->name('portfolios.index');

   Route::patch('/portfolios/{portfolio}/unpublish',
                [AdminPortfolioController::class,'unpublish'])
        ->name('portfolios.unpublish');
});





require __DIR__.'/auth.php';
