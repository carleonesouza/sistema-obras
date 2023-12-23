<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UFRequest;
use App\Http\Resources\UFResource;
use App\Models\UF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UFController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Estados', 'date' => Carbon::now()->toDateTimeString()]);
        return UFResource::collection(UF::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UFRequest $request)
    {

        try {
            
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Estado', 'date' => Carbon::now()->toDateTimeString()]);
            $tipoInfra = UF::create($request->validated());
            return UFResource::make($tipoInfra);

        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Estado: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Estado: ' . $e->getMessage(), 500);
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
        $uf = UF::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Estado pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$uf) {
            return response()->json('Estado não Encontrado', 404);
        }
        return new UFResource($uf);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoInfraestruturaRequest  $request
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
