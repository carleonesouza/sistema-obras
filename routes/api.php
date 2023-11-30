<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmpreendimentoController;
use App\Http\Controllers\Api\V1\FuncaoEstruturaController;
use App\Http\Controllers\Api\V1\HandleUploadController;
use App\Http\Controllers\Api\V1\IniciativaController;
use App\Http\Controllers\Api\V1\IntervencaoController;
use App\Http\Controllers\Api\V1\NivelDutoController;
use App\Http\Controllers\Api\V1\ObraController;
use App\Http\Controllers\Api\V1\ProdutoController;
use App\Http\Controllers\Api\V1\SetorController;
use App\Http\Controllers\Api\V1\SimNaoController;
use App\Http\Controllers\Api\V1\SituacaoController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\TipoDutoController;
use App\Http\Controllers\Api\V1\TipoInfraestruturaController;
use App\Http\Controllers\Api\V1\TipoUsuarioController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UFController;
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

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes for ADMIN
Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/tipo-usuarios', TipoUsuarioController::class);
    Route::apiResource('/usuarios', UserController::class);
    Route::apiResource('/setores', SetorController::class);
    Route::apiResource('/iniciativas', IniciativaController::class);
    Route::apiResource('/empreendimentos', EmpreendimentoController::class);
    Route::apiResource('/produtos', ProdutoController::class);
    Route::apiResource('/tipos-infra', TipoInfraestruturaController::class);
    Route::apiResource('/obras', ObraController::class);
    Route::apiResource('/status', StatusController::class);
    Route::apiResource('/estados', UFController::class);
    Route::apiResource('/tipo-infras', TipoInfraestruturaController::class);
    Route::apiResource('/intervencoes', IntervencaoController::class);
    Route::apiResource('/situacoes', SituacaoController::class);
    Route::apiResource('/simnao', SimNaoController::class);
    Route::apiResource('/tipo-dutos', TipoDutoController::class);
    Route::apiResource('/funcao-estruturas', FuncaoEstruturaController::class);
    Route::apiResource('/nivel-dutos', NivelDutoController::class);
    Route::apiResource('/upload-file', HandleUploadController::class);    
});

// Protected routes for others
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/setores', SetorController::class);
    Route::apiResource('/iniciativas', IniciativaController::class);
    Route::apiResource('/empreendimentos', EmpreendimentoController::class);
    Route::apiResource('/produtos', ProdutoController::class);
    Route::apiResource('/tipos-infra', TipoInfraestruturaController::class);
    Route::apiResource('/obras', ObraController::class);
    Route::apiResource('/status', StatusController::class);
    Route::apiResource('/estados', UFController::class);
    Route::apiResource('/tipo-infras', TipoInfraestruturaController::class);
    Route::apiResource('/intervencoes', IntervencaoController::class);
    Route::apiResource('/situacoes', SituacaoController::class);
    Route::apiResource('/simnao', SimNaoController::class);
    Route::apiResource('/tipo-dutos', TipoDutoController::class);
    Route::apiResource('/funcao-estruturas', FuncaoEstruturaController::class);
    Route::apiResource('/nivel-dutos', NivelDutoController::class);
    Route::apiResource('/upload-file', HandleUploadController::class);    
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
