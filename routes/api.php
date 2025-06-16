<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 Route::get('categories', [CategoryController::class,'index'])->name('api.v1.categories.index');
 Route::post('categories', [CategoryController::class,'store'])->name('api.v1.categories.store');
 Route::get('categories/{category}', [CategoryController::class,'show'])->name('api.v1.categories.show');
