<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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

        try{
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();
            if (!$user || !Hash::check($validated['senha'], $user->senha)) {
                return response()->json(['message' => 'Credenciais invalidas !'], 401);
            }
            
            $user->load('tipoUsuario');
    
            Log::channel('user_activity')->info('User action', ['user' => $user->email, 'action' => 'Login']);
    
            return [
                'user' => $user,
                'tipo_usuario' => $user->tipoUsuario,
                'token' => $user->createToken($user->email)->plainTextToken
            ];

        }catch (Exception $e) {
            Log::error('Error in Login: ' . $e->getMessage());
            return response()->json('Credenciais inválidas: ' . $e->getMessage(), 401);
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
