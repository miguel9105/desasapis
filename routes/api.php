<?php

// Importación de controladores necesarios para las rutas
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PublicationController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


// Ruta para obtener el usuario autenticado, requiere autenticación
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rutas de roles
Route::get('roles', [RoleController::class, 'index'])->name('api.v1.roles.index');// Obtener todos los roles
Route::post('roles', [RoleController::class, 'store'])->name('api.v1.roles.store');// Crear un nuevo rol
Route::get('roles/{role}', [RoleController::class, 'show'])->name('api.v1.roles.show');// Obtener un rol específico

// Rutas de usuarios
Route::get('users', [UserController::class, 'index'])->name('api.v1.users.index');// Obtener todos los usuarios
Route::post('users', [UserController::class, 'store'])->name('api.v1.users.store');// Crear un nuevo usuario
Route::get('users/{user}', [UserController::class, 'show'])->name('api.v1.users.show');// Obtener un usuario específico

// Rutas de categorías
Route::get('categories', [CategoryController::class,'index'])->name('api.v1.categories.index');// Obtener todas las categorías
Route::post('categories', [CategoryController::class,'store'])->name('api.v1.categories.store');// Crear una nueva categoría
Route::get('categories/{category}', [CategoryController::class,'show'])->name('api.v1.categories.show');// Obtener una categoría específica

// Rutas de publicaciones
Route::Resource('publications', PublicationController::class)->names('api.v1.publications');// Rutas RESTful para publicaciones
Route::resource('messages',MessageController::class);// Rutas RESTful para mensajes

