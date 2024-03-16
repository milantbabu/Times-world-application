<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticateUser');

Route::middleware(['auth'])->group(function () {

	Route::get('products', [ProductController::class, 'index'])->name('products');
	Route::get('product/create', [ProductController::class, 'create'])->name('createProduct');
	Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('editProduct');
	Route::post('product/store', [ProductController::class, 'store'])->name('storeProduct');
	Route::get('product/{id}/show', [ProductController::class, 'show'])->name('showProduct');
	Route::delete('product/delete', [ProductController::class, 'delete'])->name('deleteProduct');

	Route::get('profile', [LoginController::class, 'profile'])->name('profile');
	Route::post('profile/store', [LoginController::class, 'store'])->name('storeProfile');
	Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});