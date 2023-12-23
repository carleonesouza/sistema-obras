<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuncaoEstrutura\StoreFuncaoEstruturaRequest;
use App\Http\Requests\FuncaoEstrutura\UpdateFuncaoEstruturaRequest;
use App\Http\Resources\FuncaoEstruturaResource;
use App\Models\FuncaoEstrutura;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FuncaoEstruturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Funcao Estrutura', 'date' => Carbon::now()->toDateTimeString()]);
        return FuncaoEstruturaResource::collection(FuncaoEstrutura::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFuncaoEstruturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFuncaoEstruturaRequest $request)
    {
        try{
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Funcao Estrutura', 'date' => Carbon::now()->toDateTimeString()]);
            $estrutura = FuncaoEstrutura::create($request->validated());
            return FuncaoEstruturaResource::make($estrutura);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Tipo Estrutura: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Tipo Estrutura: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FuncaoEstrutura  $funcaoEstrutura
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estrutura = FuncaoEstrutura::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'ConsultouTipo Estrutura pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$estrutura) {
            return response()->json('Tipo Estrutura não Encontrada', 404);
        }
        return new FuncaoEstrutura($estrutura);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFuncaoEstruturaRequest  $request
     * @param  \App\Models\FuncaoEstrutura  $funcaoEstrutura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFuncaoEstruturaRequest $request, FuncaoEstrutura $funcaoEstrutura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FuncaoEstrutura  $funcaoEstrutura
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuncaoEstrutura $funcaoEstrutura)
    {
        //
    }
}
