<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CommentController;

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

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Routes pour les utilisateurs authentifiés
Route::middleware('auth:sanctum')->group(function () {
    // Routes accessibles par le rôle 'user'
    Route::middleware('role:user|super admin')->group(function () {
        Route::get('/user/profile', [UserController::class, 'profile'])->middleware('permission:view own profile');
        Route::put('/user/profile', [UserController::class, 'updateProfile'])->middleware('permission:edit own profile');
        Route::delete('/user/profile', [UserController::class, 'deleteProfile'])->middleware('permission:delete own profile');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/user/profile', [UserController::class, 'profile'])->middleware('permission:view own profile');
        Route::put('/user/profile', [UserController::class, 'updateProfile'])->middleware('permission:edit own profile');   
        Route::get('/users', [UserController::class, 'index'])->middleware('permission:view users');
        Route::post('/users', [UserController::class, 'store'])->middleware('permission:create users');
        Route::get('/users/{id}', [UserController::class, 'show'])->middleware('permission:view users');
        Route::put('/users/{id}', [UserController::class, 'update'])->middleware('permission:edit users');
        Route::delete('/users/{id}', [UserController::class, 'delete'])->middleware('permission:delete users');
        Route::get('/role/{user_id}', [UserController::class, 'adminAssignRole'])->middleware('permission:manage users');
    });

    // Routes spécifiques au super administrateur
    Route::middleware('role:super admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->middleware('permission:view users');
        Route::post('/users', [UserController::class, 'store'])->middleware('permission:create users');
        Route::get('/users/{id}', [UserController::class, 'show'])->middleware('permission:view users');
        Route::put('/admin/role/{user_id}', [UserController::class, 'SuperAssignRole'])->middleware('permission:assign roles');
        Route::delete('/admin/{user_id}', [UserController::class, 'destroy'])->middleware('permission:delete users');
        Route::put('/admin/{user_id}', [UserController::class, 'SuperUpdate'])->middleware('permission:edit users');
    });

        // Routes pour les modérateurs
    Route::middleware('role:moderator')->group(function () {
        Route::get('/moderator/users', [UserController::class, 'index'])->middleware('permission:view users');
        Route::get('/moderator/users/{id}', [UserController::class, 'show'])->middleware('permission:view users');
    });

    // Routes pour les auteurs
    Route::middleware('role:author')->group(function () {
        Route::get('/author/users', [UserController::class, 'index'])->middleware('permission:view users');
        Route::get('/author/users/{id}', [UserController::class, 'show'])->middleware('permission:view users');
    });



    // Routes liées à la création, modification et suppression d'articles pour tout les utilisateurs

});