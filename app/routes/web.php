<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenController;

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
    return view('admin.home');
});
Route::get('login-admin',[AuthenController :: class,'loginAdmin'])->name('loginAdmin');
Route::get('register-admin',[AuthenController :: class,'registerAdmin'])->name('registerAdmin');
