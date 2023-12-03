<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bitolas\StoreBitolaRequest;
use App\Http\Requests\Bitolas\UpdateBitolaRequest;
use App\Http\Resources\BitolaResource;
use App\Models\Bitola;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BitolaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Bitolas']);
        return BitolaResource::collection(Bitola::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBitolaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBitolaRequest $request)
    {
        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Bitola']);

            $bitola = Bitola::create($request->validated());

            return BitolaResource::make($bitola);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Bitola: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Bitola: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bitola  $bitola
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bitola = Bitola::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Bitola pelo ID']);

        if (!$bitola) {
            return response()->json('Bitola não Encontrada', 404);
        }
        return new BitolaResource($bitola);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBitolaRequest  $request
     * @param  \App\Models\Bitola  $bitola
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBitolaRequest $request, Bitola $bitola)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bitola  $bitola
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bitola $bitola)
    {
        //
    }
}
