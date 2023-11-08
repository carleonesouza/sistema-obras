<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criar Usuário']);
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
        
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultar Usuário pelo ID']);

        $user = User::find($userId);
        Log::info('User:', ['user' => $user]);
    
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
    public function update(UpdateUserRequest $request, User $user)
    {       
         Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualiar Usuário pelo ID']);

         $user->update($request->all());
         return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletar Usuário pelo ID']);
        $user->delete();
        return response()->noContent();
    }
}
