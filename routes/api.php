<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PublicationController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rutas de roles
 Route::get('roles', [RoleController::class, 'index'])->name('api.v1.roles.index');
Route::post('roles', [RoleController::class, 'store'])->name('api.v1.roles.store');
Route::get('roles/{role}', [RoleController::class, 'show'])->name('api.v1.roles.show');

Route::get('users', [UserController::class, 'index'])->name('api.v1.users.index');
Route::post('users', [UserController::class, 'store'])->name('api.v1.users.store');
Route::get('users/{user}', [UserController::class, 'show'])->name('api.v1.users.show');

 Route::get('categories', [CategoryController::class,'index'])->name('api.v1.categories.index');
 Route::post('categories', [CategoryController::class,'store'])->name('api.v1.categories.store');
 Route::get('categories/{category}', [CategoryController::class,'show'])->name('api.v1.categories.show');



 // Publications routes
Route::Resource('publications', PublicationController::class)->names('api.v1.publications');
 Route::resource('messages',MessageController::class);

