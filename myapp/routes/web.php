<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItemController;
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

Route::get('/', function () {
    return view('react');
});

// Admin Authentication Routes (no middleware)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (with middleware)
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.getcategories');
    Route::post('/admin/category/store', [CategoryController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin.categories.delete');
    Route::post('/admin/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('admin.categories.update');
    Route::get('/admin/categories/search', [CategoryController::class, 'searchCategory'])->name('admin.categories.search');

    Route::get('/admin/items', [ItemController::class, 'adminIndex'])->name('admin.items.index');
    Route::get('/admin/items/create', [ItemController::class, 'createItems'])->name('admin.items.create');
    Route::post('/admin/items/store', [ItemController::class, 'storeItem'])->name('admin.items.store');
    Route::get('/admin/items/edit/{id}', [ItemController::class, 'editItem'])->name('admin.items.edit');
    Route::match(['post', 'put'], '/admin/items/update/{id}', [ItemController::class, 'updateItem'])->name('admin.items.update');
    Route::get('/admin/items/delete/{id}', [ItemController::class, 'deleteItem'])->name('admin.items.delete');
    Route::get('/admin/items/show/{id}', [ItemController::class, 'getItem'])->name('admin.items.show');
    Route::get('/admin/items/search', [ItemController::class, 'searchItem'])->name('admin.items.search');

// Image management routes
    Route::post('/admin/images/store', [ImageController::class, 'store'])->name('admin.images.store');
    Route::post('/admin/images/link-to-item', [ImageController::class, 'updateItemId'])->name('admin.images.link');
    Route::get('/admin/items/{id}/images', [ImageController::class, 'getItemImages'])->name('admin.items.images');
    Route::delete('/admin/images/{id}', [ImageController::class, 'destroy'])->name('admin.images.destroy');
// Fallback for environments where DELETE might be blocked by client/proxy
    Route::post('/admin/images/{id}/delete', [ImageController::class, 'destroy'])->name('admin.images.postDestroy');

});

// Fallback: serve files from storage/app/public without requiring a symlink
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (! file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');