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

// Routes publiques pour voir les posts et commentaires
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);

// Routes pour les utilisateurs authentifiés
Route::middleware('auth:sanctum')->group(function () {
    // Routes pour tous les utilisateurs authentifiés
    Route::middleware('role:user')->group(function () {
        // Profile routes
        Route::get('/user/profile', [UserController::class, 'profile'])
            ->middleware('permission:view own profile');
        Route::put('/user/profile', [UserController::class, 'updateProfile'])
            ->middleware('permission:edit own profile');
        Route::delete('/user/profile', [UserController::class, 'deleteProfile'])
            ->middleware('permission:delete own profile');

        // Commentaires routes
        Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
            ->middleware('permission:create comment');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
            ->middleware('permission:delete comment');
    });

    // Routes pour les auteurs
    Route::middleware('role:author')->group(function () {
        Route::post('/posts', [PostController::class, 'store'])
            ->middleware('permission:create post');
        Route::put('/posts/{post}', [PostController::class, 'update'])
            ->middleware('permission:edit post');
        Route::post('/posts/{post}/publish', [PostController::class, 'publish'])
            ->middleware('permission:publish post');
    });

    // Routes pour les modérateurs
    Route::middleware('role:moderator')->group(function () {
        Route::put('/posts/{post}', [PostController::class, 'update'])
            ->middleware('permission:edit post');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])
            ->middleware('permission:delete post');
        Route::put('/posts/{post}/state', [PostController::class, 'changeState'])
            ->middleware('permission:change post state');
        Route::delete('/comments/{comment}', [CommentController::class, 'moderatorDestroy'])
            ->middleware('permission:delete comment');
    });

    // Routes pour les administrateurs
    Route::middleware('role:admin')->group(function () {
        // Gestion des utilisateurs
        Route::get('/users', [UserController::class, 'index'])
            ->middleware('permission:view users');
        Route::post('/users', [UserController::class, 'store'])
            ->middleware('permission:create users');
        Route::get('/users/{id}', [UserController::class, 'show'])
            ->middleware('permission:view users');
        Route::put('/users/{id}', [UserController::class, 'update'])
            ->middleware('permission:edit users');
        Route::delete('/users/{id}', [UserController::class, 'delete'])
            ->middleware('permission:delete users');
        Route::put('/users/{user_id}/role', [UserController::class, 'adminAssignRole'])
            ->middleware('permission:manage users');
        
        // Gestion des posts
        Route::post('/posts', [PostController::class, 'store'])
            ->middleware('permission:create post');
        Route::put('/posts/{post}', [PostController::class, 'update'])
            ->middleware('permission:edit post');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])
            ->middleware('permission:delete post');
    });

    // Routes pour le super admin
    Route::middleware('role:super admin')->group(function () {
        // Gestion avancée des utilisateurs
        Route::put('/admin/role/{user_id}', [UserController::class, 'SuperAssignRole'])
            ->middleware('permission:assign roles');
        Route::delete('/admin/{user_id}', [UserController::class, 'destroy'])
            ->middleware('permission:delete users');
        Route::put('/admin/{user_id}', [UserController::class, 'SuperUpdate'])
            ->middleware('permission:edit users');
        
        // Le super admin hérite de toutes les autres permissions via le système de rôles
    });
});