<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CommonUserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Usuário pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

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
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Atualizou Usuário pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

            $user = User::find($request->id);

            if ($user) {
                $data = $request->all();

                // Check if the request contains a password
                if ($request->has('senha')) {
                    $request->validate([
                        'senha_atual' => 'required',
                        'senha' => 'required|string|min:8|confirmed',
                    ]);

                    if (!Hash::check($request->senha_atual, $user->senha)) {
                        return response()->json(['message' => 'A senha atual não enviada nao está correta'], 403);
                    }

                    // Hash the new password and update separately
                    $user->senha = Hash::make($request->senha);
                    unset($data['senha']); // Remove the password from data to prevent mass assignment
                }

                // Remove 'id' from the data array
                $data = Arr::except($data, ['id']);

                // Update the user data
                $user->fill($data)->save();
                return UserResource::make($user);
            }

            throw ValidationException::withMessages(['message' => 'Não foi possível atualizar o Usuário']);
        } catch (Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['Falha ao Atualizar usuário: ' . $e->getMessage()], 500);
        }
    }
}
