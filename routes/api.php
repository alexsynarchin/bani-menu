<?php

use App\Http\Controllers\Api\CatalogController;
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
use App\Http\Controllers\Api\RKeeperMenu;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('catalog', [CatalogController::class, 'index']);
Route::get('catalog/nav', [CatalogController::class, 'nav']);
Route::get('/test', [\App\Http\Controllers\Api\TestController::class,'index']);
Route::get('/r-keeper-menu', [RKeeperMenu::class, 'index']);

