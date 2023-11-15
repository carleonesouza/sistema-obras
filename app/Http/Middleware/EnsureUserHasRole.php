<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,  $role)
    {
        $user = request()->user();

        Log::channel('user_activity')->info('User action', ['user' => $user->email, 'Perfil' => $role]);

        if (!auth()->user() || !$user->hasRole($role)) {

            return response()->json('Desculpe, você não pode acessar esse recurso', 403);
        }
        return $next($request);
    }
}
