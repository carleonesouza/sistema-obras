<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimNao\StoreSimNaoRequest;
use App\Http\Requests\SimNao\UpdateSimNaoRequest;
use App\Http\Resources\SimNaoResource;
use App\Models\SimNao;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SimNaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Sim Nao']);
        return SimNaoResource::collection(SimNao::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSimNaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSimNaoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Sim Nao']);
            $sim_nao = SimNao::create($request->validated());
            return SimNaoResource::make($sim_nao);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Sim Nao: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Sim Nao: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SimNao  $simNao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sim_nao = SimNao::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Sim Nao pelo ID']);

        if (!$sim_nao) {
            return response()->json('Tipo Estrutura não Sim Nao', 404);
        }
        return new SimNao($sim_nao);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSimNaoRequest  $request
     * @param  \App\Models\SimNao  $simNao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSimNaoRequest $request, SimNao $simNao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimNao  $simNao
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimNao $simNao)
    {
        //
    }
}
