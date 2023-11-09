<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Listar todos Usuários']);
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criou Usuário']);
        $request->validated();
        $user = User::create([
            'nome' => $request->nome,
            'instituicao_setor' => $request->instituicao_setor,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'tipo_usuario_id' => $request->tipo_usuario_id,
            'senha' => Hash::make($request->senha),
        ]);
        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Usuário pelo ID']);

        $user = User::find($userId);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Usuário pelo ID']);
            
            $user = User::find($request->id);

            if($user){
                $user->update($request->all());
                return UserResource::make($user);
            }
           
            return throw ValidationException::withMessages(['Não foi possível atualizar o Usuário']);;
           
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating user: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json(['message' => 'Failed to update user.'], 500);
        }
    }  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletar Usuário pelo ID']);
        
        // Attempt to find the user by ID.
        $user::where('id', $request->id)->delete();
    
        if (!$user) {
            // User with the specified ID was not found.
            return response()->json(['message' => $user], 404);
        }
    
      
    
        return response()->noContent();
    }
    
}
