<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use App\Http\Requests\StoreSetorRequest;
use App\Http\Requests\UpdateSetorRequest;
use App\Http\Resources\SetorResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function show(Setor $setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Setor pelo ID']);
        return SetorResource::make($setor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSetorRequest  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetorRequest $request, Setor $setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Setor pelo ID']);
        $setor->update($request->validated());
        return SetorResource::make($setor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setor $setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletou Setor pelo ID']);
        $setor->delete();
        return response()->noContent();
    }
}
