<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Auth::loginUsingId(1);
Route::get('/', function () {
  return (auth()->check()) ? redirect(route('dashboard.index')) : redirect(route('login'));
})->name('home');

Route::middleware('guest')->group(function(){
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login', [AuthController::class, 'cekLogin'])->name('login.store');
});

Route::middleware('auth')->group(function(){
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('/dashboard', DashboardController::class)->name('dashboard.index');
  Route::resource('/user', UserController::class);


  Route::prefix('/profile')->group(function(){
    Route::get('/show', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/editdata', [ProfileController::class, 'editdata'])->name('profile.editdata');
    Route::post('/editdata', [ProfileController::class, 'storeEditData'])->name('profile.editdata.update');
    Route::get('/editfoto', [ProfileController::class, 'editfoto'])->name('profile.editfoto');
    Route::post('/editfoto', [ProfileController::class, 'storeEditFoto'])->name('profile.editfoto.update');
  });

});
