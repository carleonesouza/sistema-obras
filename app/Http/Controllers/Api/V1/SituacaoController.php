<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Situacao\StoreSituacaoRequest;
use App\Http\Requests\Situacao\UpdateSituacaoRequest;
use App\Http\Resources\SituacaoResource;
use App\Models\Situacao;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SituacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Situacao']);
        return SituacaoResource::collection(Situacao::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSituacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSituacaoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Situacao']);
            $situacao = Situacao::create($request->validated());
            return SituacaoResource::make($situacao);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Situacao: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Situacao: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $situacao = Situacao::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Sitaucao pelo ID']);

        if (!$situacao) {
            return response()->json('Situacao não Encontrada', 404);
        }
        return new SituacaoResource($situacao);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSituacaoRequest  $request
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSituacaoRequest $request, Situacao $situacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Situacao $situacao)
    {
        //
    }
}
