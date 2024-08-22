<?php

use App\Http\Controllers\Admin\Api\CategoryController;
use App\Http\Controllers\Admin\Api\ProductController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Laravue\JsonResponse;
use \App\Laravue\Acl;
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
use App\Http\Controllers\Admin\Api\AuthController;
use App\Http\Controllers\Admin\Api\UserController;
use App\Http\Controllers\Admin\Api\PermissionController;
use App\Http\Controllers\Admin\Api\BreadcrumbsController;
use App\Http\Controllers\Admin\Api\RKeeperController;
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/user/{id}/show', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/{id}/update', [UserController::class,'update']);
    Route::post('/user/{id}/change-password', [UserController::class,'changePassword']);
    Route::post('/user/{id}/delete', [UserController::class, 'destroy']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('/products', ProductController::class);
    Route::post('/synchronize-menu', [RKeeperController::class, 'synchronizeMenu']);



    Route::get('/breadcrumbs', [BreadcrumbsController::class, 'index']);

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');

});

