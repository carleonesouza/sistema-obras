<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\Setors\UpdateSetorRequest;
use App\Models\Setor;
use Exception;
use App\Http\Requests\StoreSetorRequest;
use App\Http\Resources\SetorResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Listar Setor']);
        return SetorResource::collection(Setor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSetorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSetorRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criou Setor']);
        $tipoUsuario = Setor::create($request->validated());
        return SetorResource::make($tipoUsuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Setor pelo ID']);

        $setor = Setor::find($id);
    
        if (!$setor) {
            return response()->json('Setor não encontrado!', 404);
        }
    
        return SetorResource::make($setor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSetorRequest  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetorRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Setor pelo ID']);
            
            $setor = Setor::find($request->id);

            if($setor){
                $setor->update($request->all());
                return SetorResource::make($setor);
            }
           
            return throw ValidationException::withMessages(['Não foi possível atualizar o Setor']);;
           
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating user: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao Atualizar Setor.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request, Setor $setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletou Setor pelo ID']);
        // Attempt to find the user by ID.
        $setor::where('id', $request->id)->delete();
    
        if (!$setor) {
            // User with the specified ID was not found.
            return response()->json( 'Setor não encontrado!', 404);
        }
        
        return response()->noContent();
    }
}
