<?php

use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProductController;
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
Route::apiResource('products/{id}', ProductController::class)->except([
    'index','store'
])->whereNumber('id');

Route::get('sizes', [SizeController::class, 'index']);
Route::post('sizes', [SizeController::class, 'store']);
Route::get('sizes/{id}', [SizeController::class, 'show'])->whereNumber('id');
Route::put('sizes/{id}', [SizeController::class, 'update'])->whereNumber('id');
Route::delete('sizes/{id}', [SizeController::class, 'destroy'])->whereNumber('id');