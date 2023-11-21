<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empreendimentos\DeleteEmpreendimentoRequest;
use App\Http\Requests\Empreendimentos\StoreEmpreendimentoRequest;
use App\Http\Requests\Empreendimentos\UpdateEmpreendimentoRequest;
use App\Models\Empreendimento;
use App\Http\Resources\EmpreendimentoResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class EmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Empreendimentos']);
        return EmpreendimentoResource::collection(Empreendimento::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmpreendimentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmpreendimentoRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Empreendimento']);
        $empreendimento = Empreendimento::create($request->validated());
        return EmpreendimentoResource::make($empreendimento);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empreendimento = Empreendimento::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Empreendimento pelo ID']);

        if (!$empreendimento) {
            return response()->json('Empreendimento não Encontrada', 404);
        }
        return new EmpreendimentoResource($empreendimento);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmpreendimentoRequest  $request
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpreendimentoRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Atualizou' => 'Empreendimento pelo ID']);

        
            $$empreendimento = Empreendimento::find($request->id);

            if($$empreendimento){
                $$empreendimento->update($request->all());
                return EmpreendimentoResource::make($iniciativa);
            }
           
           
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Empreendimento: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Empreendimento: '.$e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteEmpreendimentoRequest $request, Empreendimento $empreendimento)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Deletou' => 'Empreendimento pelo ID']);
         // Attempt to find the empreendimento by ID.
         $empreendimento::where('id', $request->id)->delete();
    
         if (!$empreendimento) {
             // Empreendimento with the specified ID was not found.
             return response()->json('Empreendimento não encontrada!', 404);
         }
         
         return response()->noContent();
    }
}
