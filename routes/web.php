<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LawyerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web,lawyer'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/articles', [ArticleController::class, 'showArticles'])->name('showArticles');
    Route::get('/articles/{id}', [ArticleController::class, 'showDetail'])->name('showArticleDetail');
    Route::get('/lawyers/{id}', [LawyerController::class, 'getLawyer'])->name('getLawyer');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

});

Route::middleware(['auth:lawyer'])->group(function () {
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('lawyer/myappointments', [AppointmentController::class, 'getLawyerAppointments'])->name('lawyer.appointments');
    Route::put('lawyer/myappointments/{userId}/{lawyerId}/{newStatus}', [AppointmentController::class, 'updateAppointmentStatus'])->name('updateAppointmentStatus');
    Route::delete('/lawyer/delete-lawyer', [AuthController::class, 'deleteLawyer'])->name('lawyer.deleteAccount');

});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/lawyers/booking/{id}', [LawyerController::class, 'getLawyerBookingPage'])->name('getLawyerBooking');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/update-rating-review/{userId}/{lawyerId}', [AppointmentController::class, 'updateRatingReview'])->name('updateRatingReview');
    Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comment/{id}', [CommentController::class, 'delete'])->name('comments.delete');
    Route::delete('/delete-user', [AuthController::class, 'deleteUser'])->name('user.deleteAccount');

});
    
// user auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('login-process', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('register-process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('lawyers', [LawyerController::class, 'getLawyers'])->name('getLawyers');
Route::get('myappointments', [AppointmentController::class, 'getUserAppointments'])->name('user.appointments');
Route::post('/changePassword', [AuthController::class, 'changePasswordUser'])->name('changePassword');

// lawyer auth
Route::prefix('lawyer')->name('lawyer.')->group(function () {
    Route::get('login', [AuthController::class, 'loginLawyer'])->name('login');
    Route::get('register', [AuthController::class, 'registerLawyer'])->name('register');
    Route::post('login-process', [AuthController::class, 'loginProcessLawyer'])->name('login.process');
    Route::post('register-process', [AuthController::class, 'registerProcessLawyer'])->name('register.process');
    Route::post('changePassword', [AuthController::class, 'changePasswordLawyer'])->name('changePassword');
});

Route::get('locale/{lang}', [LanguageController::class, 'change'])->name('changeLang');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
