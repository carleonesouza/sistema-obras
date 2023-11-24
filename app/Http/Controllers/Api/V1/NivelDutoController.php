<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NivelDuto\StoreNivelDutoRequest;
use App\Http\Requests\NivelDuto\UpdateNivelDutoRequest;
use App\Http\Resources\NivelDutoResource;
use App\Models\NivelDuto;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NivelDutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Nivel Duto']);
        return NivelDutoResource::collection(NivelDuto::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNivelDutoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNivelDutoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Nivel Duto']);
            $estrutura = NivelDuto::create($request->validated());
            return NivelDutoResource::make($estrutura);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Nivel Duto: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Nivel Duto: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NivelDuto  $nivelDuto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nivel_duto = NivelDuto::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Nivel Duto pelo ID']);

        if (!$nivel_duto) {
            return response()->json('Nivel Duto não Encontrada', 404);
        }
        return new NivelDuto($nivel_duto);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNivelDutoRequest  $request
     * @param  \App\Models\NivelDuto  $nivelDuto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNivelDutoRequest $request, NivelDuto $nivelDuto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NivelDuto  $nivelDuto
     * @return \Illuminate\Http\Response
     */
    public function destroy(NivelDuto $nivelDuto)
    {
        //
    }
}
