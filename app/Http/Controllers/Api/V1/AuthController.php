<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request)
    {

        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();
            if (!$user || !Hash::check($validated['senha'], $user->senha)) {
                return response()->json(['message' => 'Credenciais inválidas !'], 401);
            }

            $user->load('tipoUsuario');

            Log::channel('user_activity')->info('User action', ['user' => $user->email, 'action' => 'Login']);

            return [
                'user' => $user,
                'tipo_usuario' => $user->tipoUsuario,
                'token' => $user->createToken($user->email)->plainTextToken
            ];
        } catch (Exception $e) {
            Log::error('Error in Login: ' . $e->getMessage());
            return response()->json(['message' => 'Credenciais inválidas: '] . $e->getMessage(), 401);
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
        try {
            $user = User::create([
                'nome' => $request->nome,
                'instituicao_setor' => $request->instituicao_setor,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'tipo_usuario' => $request->tipo_usuario,
                'senha' => Hash::make($request->senha),
            ]);
    
            $user->load('tipoUsuario');
            $token = $user->createToken($user->email)->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'tipo_usuario' => $user->tipoUsuario,
                'token' => $token
            ]);
        } catch (Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao cadastrar sua conta: ' . $e->getMessage()], 400);
        }
    }
   
    public function logout()
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Logout']);
        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }
}
