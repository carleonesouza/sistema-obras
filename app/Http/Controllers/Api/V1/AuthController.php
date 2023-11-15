<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['senha'], $user->senha)) {
            return [
                'message' => 'These credentials do not match our records.'
            ];
        }
        
        $user->load('tipoUsuario');

        Log::channel('user_activity')->info('User action', ['user' => $user->email, 'action' => 'Login']);

        return [
            'user' => $user,
            'tipo_usuario' => $user->tipoUsuario,
            'token' => $user->createToken($user->email)->plainTextToken
        ];
      

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
