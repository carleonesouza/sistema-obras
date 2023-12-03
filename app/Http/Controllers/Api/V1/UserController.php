<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
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
        
        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {

            return UserResource::collection(User::all());

        } else {
            return response()->json('Não autorizado', 403);
        }
        
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

        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {

            $new_user = User::create([
                'nome' => $request->nome,
                'instituicao_setor' => $request->instituicao_setor,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'tipo_usuario' => $request->tipo_usuario,
                'senha' => Hash::make($request->senha),
            ]);

        } else {
            return response()->json('Não autorizado', 403);
        }

        return UserResource::make($new_user);
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
            return response()->json(['User not found'], 404);
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
            
            $user = Auth::user();            
            
            $sended_user = User::find($request->id);

            if ($user->hasRole('ADMIN') && $sended_user) {

                $sended_user->update($request->all());
                
                return UserResource::make($sended_user);

            }else{

                return response()->json('Não autorizado', 403);
            }
           
            return throw ValidationException::withMessages(['Não foi possível atualizar o Usuário']);;
           
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating user: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json(['Falha ao Atualizar usuário: '.$e->getMessage()], 500);
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
            return response()->json(['Usuario não encontrado!'], 404);
        }
    
      
    
        return response()->noContent();
    }
    
}
