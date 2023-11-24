<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intervencao\StoreIntervencaoRequest;
use App\Http\Requests\Intervencao\UpdateIntervencaoRequest;
use App\Http\Resources\IntervencaoResource;
use App\Models\Intervencao;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IntervencaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Intervencao']);
        return IntervencaoResource::collection(Intervencao::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIntervencaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntervencaoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Intervencao']);
            $intervecao = Intervencao::create($request->validated());
            return IntervencaoResource::make($intervecao);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Intervencao: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Intervencao: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $intervecao = Intervencao::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Intervencao pelo ID']);

        if (!$intervecao) {
            return response()->json('Intervencao não Encontrada', 404);
        }
        return new IntervencaoResource($intervecao);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIntervencaoRequest  $request
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIntervencaoRequest $request, Intervencao $intervencao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intervencao $intervencao)
    {
        //
    }
}
