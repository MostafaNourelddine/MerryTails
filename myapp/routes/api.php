<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Categories API
Route::get('/categories', function () {
    $categories = \App\Models\Category::all();
    return response()->json($categories);
});

// Items API with categories and images
Route::get('/items', function () {
    $items = \App\Models\Item::with(['category', 'images'])->get();
    return response()->json($items);
});

// Items by category
Route::get('/categories/{id}/items', function ($id) {
    $items = \App\Models\Item::with(['category', 'images'])
        ->where('category_id', $id)
        ->get();
    return response()->json($items);
});
