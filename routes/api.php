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
use App\Http\Controllers\Api\TablesController;
use App\Http\Controllers\Api\OrderController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('catalog', [CatalogController::class, 'index']);
Route::get('catalog/nav', [CatalogController::class, 'nav']);
Route::get('/test', [\App\Http\Controllers\Api\TestController::class,'index']);
Route::get('/r-keeper-menu', [RKeeperMenu::class, 'index']);
Route::get('/get-open-tables', [TablesController::class, 'getOpenTables']);
Route::post('/save-order', [OrderController::class, 'saveOrder']);
