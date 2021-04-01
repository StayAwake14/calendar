<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
Route::post('/calendar/month/{id}', [CalendarController::class, 'show'])->name('calendar.show');

Route::get('/absence', [AbsencesController::class, 'absences'])->name('absence');
Route::post('/absence', [AbsencesController::class, 'add'])->name('absence.add');

Route::get('/reason', [ReasonsController::class, 'reasons'])->name('reason');
Route::post('/reason', [ReasonsController::class, 'add'])->name('reason.add');

Route::get('login', [UserAuthController::class, 'login']);
Route::get('register', [UserAuthController::class, 'register']);
Route::post('create', [UserAuthController::class, 'create'])->name('auth.create');
Route::post('check', [UserAuthController::class, 'check'])->name('auth.check');
Route::get('profile', [UserAuthController::class, 'profile'])->name('profile');
Route::get('/profile/month/{id}', [UserAuthController::class, 'show'])->name('profile.show');
Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');
