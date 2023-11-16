<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Iniciativas\DeleteIniciativaRequest;
use App\Http\Requests\Iniciativas\StoreIniciativaRequest;
use App\Http\Requests\Iniciativas\UpdateIniciativaRequest;
use App\Models\Iniciativa;
use App\Http\Resources\IniciativaResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IniciativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Listar Iniciativa']);
        return IniciativaResource::collection(Iniciativa::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIniciativaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIniciativaRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criou Iniciativa']);
        $iniciativa = Iniciativa::create($request->validated());
        return IniciativaResource::make($iniciativa);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Iniciativa pelo ID']);

        $iniciativa = Iniciativa::find($id);
    
        if (!$iniciativa) {
            return response()->json('Iniciativa não Encontrada', 404);
        }
    
        return IniciativaResource::make($iniciativa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIniciativaRequest  $request
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIniciativaRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Iniciativa pelo ID']);

        
            $iniciativa = Iniciativa::find($request->id);

            if($iniciativa){
                $iniciativa->update($request->all());
                return IniciativaResource::make($iniciativa);
            }
           
           
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating iniciativa: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar iniciativa: '.$e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteIniciativaRequest $request, Iniciativa $iniciativa)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletou Iniciativa pelo ID']);
         // Attempt to find the user by ID.
         $iniciativa::where('id', $request->id)->delete();
    
         if (!$iniciativa) {
             // User with the specified ID was not found.
             return response()->json('Iniciativa não encontrada!', 404);
         }
         
         return response()->noContent();
    }
}
