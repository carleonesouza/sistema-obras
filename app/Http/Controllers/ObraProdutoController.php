<?php

namespace App\Http\Controllers;

use App\Models\ObraProduto;
use App\Http\Requests\StoreObraProdutoRequest;
use App\Http\Requests\UpdateObraProdutoRequest;

class ObraProdutoController extends Controller
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
     * @param  \App\Http\Requests\StoreObraProdutoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObraProdutoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObraProduto  $obraProduto
     * @return \Illuminate\Http\Response
     */
    public function show(ObraProduto $obraProduto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObraProduto  $obraProduto
     * @return \Illuminate\Http\Response
     */
    public function edit(ObraProduto $obraProduto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObraProdutoRequest  $request
     * @param  \App\Models\ObraProduto  $obraProduto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObraProdutoRequest $request, ObraProduto $obraProduto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObraProduto  $obraProduto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObraProduto $obraProduto)
    {
        //
    }
}
