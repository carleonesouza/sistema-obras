<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoInfraestruturaRequest;
use App\Http\Requests\TipoInfraestrutura\UpdateTipoInfraestruturaRequest;
use App\Http\Resources\TipoInfraestruturaResource;
use App\Models\TipoInfraestrutura;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoInfraestruturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Tipo Infraestrutura']);
        return TipoInfraestruturaResource::collection(TipoInfraestrutura::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TipoInfraestrutura $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoInfraestruturaRequest $request)
    {

        try {
            
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Tipo Infraestrutura']);
            $tipoInfra = TipoInfraestrutura::create($request->validated());
            return TipoInfraestruturaResource::make($tipoInfra);

        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Tipo Infraestrutura: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Tipo Infraestrutura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoInfra = TipoInfraestrutura::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Tipo Infraestrutura pelo ID']);

        if (!$tipoInfra) {
            return response()->json('Tipo Infraestrutura não Encontrada', 404);
        }
        return new TipoInfraestruturaResource($tipoInfra);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoInfraestruturaRequest  $request
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoInfraestruturaRequest $request, TipoInfraestrutura $tipoInfraestrutura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoInfraestrutura $tipoInfraestrutura)
    {
        //
    }
}
