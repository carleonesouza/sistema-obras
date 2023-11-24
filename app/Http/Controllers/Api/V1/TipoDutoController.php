<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoDuto\StoreTipoDutoRequest;
use App\Http\Requests\TipoDuto\UpdateTipoDutoRequest;
use App\Http\Resources\TipoDutoResource;
use App\Models\TipoDuto;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoDutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Tipo Duto']);
        return TipoDutoResource::collection(TipoDuto::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTipoDutoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoDutoRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Tipo Duto']);
            $duto = TipoDuto::create($request->validated());
            return TipoDutoResource::make($duto);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Tipo Duto: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Tipo Duto: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoDuto  $tipoDuto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $duto = TipoDuto::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Tipo Duto pelo ID']);

        if (!$duto) {
            return response()->json('Tipo Duto não Encontrada', 404);
        }
        return new TipoDuto($duto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoDutoRequest  $request
     * @param  \App\Models\TipoDuto  $tipoDuto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoDutoRequest $request, TipoDuto $tipoDuto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDuto  $tipoDuto
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDuto $tipoDuto)
    {
        //
    }
}
