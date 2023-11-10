<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TipoUsuario;
use App\Http\Requests\StoreTipoUsuarioRequest;
use App\Http\Requests\UpdateTipoUsuarioRequest;
use App\Http\Resources\TipoUsuarioResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Listar Tipo Usuário']);
        return TipoUsuarioResource::collection(TipoUsuario::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTipoUsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoUsuarioRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criou Tipo Usuário']);
        $tipoUsuario = TipoUsuario::create($request->validated());
        return TipoUsuarioResource::make($tipoUsuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoUsuario  $tipoUsuario
     * @return \Illuminate\Http\Response
     */
    public function show(TipoUsuario $tipoUsuario)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Tipo Usuário pelo ID']);
        return TipoUsuarioResource::make($tipoUsuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoUsuarioRequest  $request
     * @param  \App\Models\TipoUsuario  $tipoUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoUsuarioRequest $request, TipoUsuario $tipoUsuario)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Tipo Usuário pelo ID']);
        $tipoUsuario->update($request->validated());
        return TipoUsuarioResource::make($tipoUsuario);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoUsuario  $tipoUsuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoUsuario $tipoUsuario)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletou Tipo Usuário pelo ID']);
        $tipoUsuario->delete();
        return response()->noContent();
    }
}
