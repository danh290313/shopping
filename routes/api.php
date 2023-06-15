<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\UserController;
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

Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update'])->whereNumber('id');
Route::get('products/{id}', [ProductController::class, 'show'])->whereNumber('id');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->whereNumber('id');
Route::put('products/restore_all', [ProductController::class, 'restoreAll']);
Route::post('products/add_tags', [ProductController::class, 'addTags']);

// Route::apiResource('products', ProductController::class)->only([
//     'show'
// ])->where(['id'=>'numeric']);

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{id}', [OrderController::class, 'update'])->whereNumber('id');

Route::get('users', [UserController::class, 'index']);

Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::put('tags/{id}', [TagController::class, 'update'])->whereNumber('id');
Route::get('tags/{id}', [TagController::class, 'show'])->whereNumber('id');
Route::delete('tags/{id}', [TagController::class, 'destroy'])->whereNumber('id');

Route::get('colors', [ColorController::class, 'index']);
Route::post('colors', [ColorController::class, 'store']);
Route::put('colors/{id}', [ColorController::class, 'update'])->whereNumber('id');
Route::get('colors/{id}', [ColorController::class, 'show'])->whereNumber('id');
Route::delete('colors/{id}', [ColorController::class, 'destroy'])->whereNumber('id');


Route::get('sizes', [SizeController::class, 'index']);
Route::post('sizes', [SizeController::class, 'store']);
Route::get('sizes/{id}', [SizeController::class, 'show'])->whereNumber('id');
Route::put('sizes/{id}', [SizeController::class, 'update'])->whereNumber('id');
Route::delete('sizes/{id}', [SizeController::class, 'destroy'])->whereNumber('id');