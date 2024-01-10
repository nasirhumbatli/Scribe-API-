<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
//Route::get('categories/{category}', [CategoryController::class, 'show'])->name('category.show');
//Route::post('categories', [CategoryController::class, 'store'])->name('category.store');
//Route::put('categories/{category}', [CategoryController::class, 'update'])->name('category.update');
//Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::apiResource('categories', CategoryController::class);

Route::get('products', [ProductController::class, 'index'])->name('product.index');
