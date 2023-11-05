<?php

use App\Http\Controllers\Api\V1\TipoUsuarioController;
use App\Http\Controllers\Api\V1\UsuarioController;
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
Route::prefix('v1')->group(function(){
    Route::apiResource('/tipo-usuarios', TipoUsuarioController::class);
    Route::apiResource('/usuarios', UsuarioController::class);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
