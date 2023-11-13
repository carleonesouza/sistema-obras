<?php

namespace App\Http\Controllers;

use App\Models\Empreendimento;
use App\Http\Requests\StoreEmpreendimentoRequest;
use App\Http\Requests\UpdateEmpreendimentoRequest;

class EmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmpreendimentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmpreendimentoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function show(Empreendimento $empreendimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Empreendimento $empreendimento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmpreendimentoRequest  $request
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpreendimentoRequest $request, Empreendimento $empreendimento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empreendimento $empreendimento)
    {
        //
    }
}
