<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Municipios\StoreMunicipioRequest;
use App\Http\Requests\Municipios\UpdateMunicipioRequest;
use App\Models\Municipio;
use App\Http\Resources\MunicipioResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Municipios', 'date' => Carbon::now()->toDateTimeString()]);
        return MunicipioResource::collection(Municipio::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMunicipioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMunicipioRequest $request)
    {
        try{
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Municipio', 'date' => Carbon::now()->toDateTimeString()]);

            $request->validated();

            $municipio = Municipio::create(
                [
                    'nome' => $request->nome,
                    'uf' => $request->uf                    
                ]);
            return MunicipioResource::make($municipio);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error criar Municipio: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Municipio: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $municipio = Municipio::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Municipio pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$municipio) {
            return response()->json('Municipio não Encontrada', 404);
        }
        return new MunicipioResource($municipio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMunicipioRequest  $request
     * @param  \App\Models\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMunicipioRequest $request, Municipio $municipio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Municipio $municipio)
    {
        //
    }
}
