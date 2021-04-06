<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\LeadersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\ManageController;

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
Route::get('/calendar/month/{id}/year/{id2}', [CalendarController::class, 'show'])->name('calendar.show');

Route::get('/absence', [AbsencesController::class, 'absences'])->name('absence');
Route::post('/absence', [AbsencesController::class, 'add'])->name('absence.add');

Route::get('/verify', [AbsencesController::class, 'toVerify'])->name('verify');
Route::put('/verify/approve/absence/{id}', [AbsencesController::class, 'accept'])->name('verify.accept');

Route::get('/reason', [ReasonsController::class, 'reasons'])->name('reason');
Route::post('/reason', [ReasonsController::class, 'add'])->name('reason.add');

Route::get('/team', [TeamsController::class, 'teams'])->name('team');
Route::post('/team', [TeamsController::class, 'add'])->name('team.add');

Route::get('/leader', [LeadersController::class, 'leaders'])->name('leader');
Route::post('/leader', [LeadersController::class, 'add'])->name('leader.add');

Route::get('/manage', [ManageController::class, 'manage'])->name('manage');
Route::put('/manage/edit/{id}', [ManageController::class, 'edit'])->name('manage.edit');

Route::get('login', [UserAuthController::class, 'login']);
Route::get('register', [UserAuthController::class, 'register'])->name('register');
Route::post('create', [UserAuthController::class, 'create'])->name('auth.create');
Route::post('check', [UserAuthController::class, 'check'])->name('auth.check');
Route::get('profile', [UserAuthController::class, 'profile'])->name('profile');
Route::get('/profile/month/{id}', [UserAuthController::class, 'show'])->name('profile.show');
Route::get('/profile/month/{id}/year/{year}', [UserAuthController::class, 'show'])->name('profile.show2');
Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');
