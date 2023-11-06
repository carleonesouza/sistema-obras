<?php

namespace App\Http\Controllers;

use App\Models\Iniciativa;
use App\Http\Requests\StoreIniciativaRequest;
use App\Http\Requests\UpdateIniciativaRequest;

class IniciativaController extends Controller
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
     * @param  \App\Http\Requests\StoreIniciativaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIniciativaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function show(Iniciativa $iniciativa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function edit(Iniciativa $iniciativa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIniciativaRequest  $request
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIniciativaRequest $request, Iniciativa $iniciativa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iniciativa $iniciativa)
    {
        //
    }
}
