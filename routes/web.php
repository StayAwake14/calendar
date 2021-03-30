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

Route::get('/calendar', [CalendarController::class, 'index']);
Route::get('/absence', [AbsencesController::class, 'absences']);
Route::post('/absence', [AbsencesController::class, 'add'])->name('absence.add');

Route::get('/reason', [ReasonsController::class, 'reasons']);
Route::post('/reason', [ReasonsController::class, 'add'])->name('reason.add');

Route::get('login', [UserAuthController::class, 'login']);
Route::get('register', [UserAuthController::class, 'register']);
Route::post('create', [UserAuthController::class, 'create'])->name('auth.create');
Route::post('check', [UserAuthController::class, 'check'])->name('auth.check');
Route::get('profile', [UserAuthController::class, 'profile']);
Route::get('logout', [UserAuthController::class, 'logout']);
