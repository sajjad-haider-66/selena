<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TalkAnimationController;
use App\Http\Controllers\DailyReadinessController;
use App\Http\Controllers\PlanController;

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
    Route::resource('plan', PlanController::class);
    Route::resource('checklist', CheckListController::class);
    Route::delete('/event/destory/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::delete('/audit/destory/{id}', [AuditController::class, 'destroy'])->name('audit.destroy');
    Route::delete('/talk/destory/{id}', [TalkAnimationController::class, 'destroy'])->name('talk.destroy');
    Route::delete('/daily_readiness/destory/{id}', [DailyReadinessController::class, 'destroy'])->name('daily_readniness.destroy');
    Route::delete('/checklist/destory/{id}', [CheckListController::class, 'destroy'])->name('checklist.destroy');
    Route::get('fetch/notification', [DailyReadinessController::class, 'Notification'])->name('fetch.notification');
    Route::post('/talk/{id}/materials', [TalkAnimationController::class, 'uploadMaterials'])->name('talk_animation.materials');
    Route::post('/talk/{id}/attendance', [TalkAnimationController::class, 'markAttendance'])->name('talk_animation.attendance');
    Route::post('/talk/{id}/attendance/qr', [TalkAnimationController::class, 'markAttendanceQR'])->name('talk_animation.attendance.qr');
    Route::post('/talk/{id}/feedback', [TalkAnimationController::class, 'submitFeedback'])->name('talk_animation.feedback');
    Route::post('/talk/{id}/archive', [TalkAnimationController::class, 'archive'])->name('talk_animation.archive');
});
// KEY : MULTIPERMISSION ends

require __DIR__.'/auth.php';
