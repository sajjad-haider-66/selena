<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TalkAnimationController;
use App\Http\Controllers\DailyReadinessController;

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

// KEY : MULTIPERMISSION starts
Route::group(['middleware' => ['auth']], function() {
// Route::group(function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('talk_animation', TalkAnimationController::class);
    Route::resource('daily_readiness', DailyReadinessController::class);
    Route::resource('audit', AuditController::class);
    Route::resource('action', ActionController::class);
    Route::resource('event', EventController::class);
    Route::get('fetch/notification', [DailyReadinessController::class, 'Notification'])->name('fetch.notification');
});
// KEY : MULTIPERMISSION ends

require __DIR__.'/auth.php';
