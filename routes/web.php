<?php

use App\Http\Controllers\categoryController;
use App\Http\Controllers\imgController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/searchview', function () {
    return view('Global.Search');
});
Route::get('/login', function () {
    return view('AdminLogin');
});

Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::get('/create', [LoginController::class, 'create'])->name('create')->middleware('auth');
Route::get('/check', [LoginController::class, 'check'])->name('check');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/Search', [ItemsController::class, 'Search']);
Route::get('/createemail', [RegisterController::class, 'create']);
Route::get('/admin', [ItemsController::class, 'index']);
Route::get('/', [ItemsController::class, 'Home'])->name("Home");
Route::get('/contactus', [ItemsController::class, 'Contact']);
Route::get('/category/{id}/show', [ItemsController::class, 'Products']);
Route::post('/storeitem', [ItemsController::class, 'StoreItem'])->name('item.store');
Route::post('/storeimg', [imgController::class, 'store'])->name('img.store');
Route::post('/storecat', [categoryController::class, 'storecategory'])->name('category.store');
Route::get('/category{category}/edit', [categoryController::class, 'editCategory'])->name('categoryedit');
Route::get('/category{id}/Delete', [categoryController::class, 'deleteCategory'])->name('DeleteCategory');
Route::post('/category{category}/update', [categoryController::class, 'update'])->name('categoryupdate');

Route::get('/item{item}/edit', [itemsController::class, 'editItem'])->name('itemedit');
Route::post('/item{item}/update', [itemsController::class, 'update'])->name('itemupdate');
Route::get('/item{id}/delete', [itemsController::class, 'DeleteItem'])->name('DeleteItem');

Route::get('/img{img}/edit', [imgController::class, 'editImg'])->name('imageedit');
Route::post('/img{img}/update', [imgController::class, 'update'])->name('imgupdate');
Route::get('/img{id}/delete', [imgController::class, 'DeleteImage'])->name('DeleteImage');

Route::get('/view/{id}/item', [ItemsController::class, 'ViewItem'])->name('QuickView');
