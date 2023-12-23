<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NaturezaEmpreendimentos\StoreNaturezaEmpreendimentoRequest;
use App\Http\Requests\NaturezaEmpreendimentos\UpdateNaturezaEmpreendimentoRequest;
use App\Http\Resources\NaturezaEmpreendimentoResource;
use App\Models\NaturezaEmpreendimento;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NaturezaEmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Natureza Empreendimento', 'date' => Carbon::now()->toDateTimeString()]);
        return NaturezaEmpreendimentoResource::collection(NaturezaEmpreendimento::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNaturezaEmpreendimentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNaturezaEmpreendimentoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Natureza Empreendimento', 'date' => Carbon::now()->toDateTimeString()]);

            $natureza = NaturezaEmpreendimento::create($request->validated());

            return NaturezaEmpreendimentoResource::make($natureza);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Natureza Empreendimento: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Natureza Empreendimento: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NaturezaEmpreendimento  $naturezaEmpreendimento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $natureza = NaturezaEmpreendimento::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Natureza Empreendimento pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$natureza) {
            return response()->json('Natureza Empreendimento não Encontrada', 404);
        }
        return new NaturezaEmpreendimentoResource($natureza);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNaturezaEmpreendimentoRequest  $request
     * @param  \App\Models\NaturezaEmpreendimento  $naturezaEmpreendimento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNaturezaEmpreendimentoRequest $request, NaturezaEmpreendimento $naturezaEmpreendimento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NaturezaEmpreendimento  $naturezaEmpreendimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(NaturezaEmpreendimento $naturezaEmpreendimento)
    {
        //
    }
}
