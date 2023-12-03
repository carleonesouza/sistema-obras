<?php

namespace App\Http\Controllers;

use App\Models\ObraMunicipio;
use App\Http\Requests\StoreObraMunicipioRequest;
use App\Http\Requests\UpdateObraMunicipioRequest;

class ObraMunicipioController extends Controller
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
     * @param  \App\Http\Requests\StoreObraMunicipioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObraMunicipioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObraMunicipio  $obraMunicipio
     * @return \Illuminate\Http\Response
     */
    public function show(ObraMunicipio $obraMunicipio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObraMunicipio  $obraMunicipio
     * @return \Illuminate\Http\Response
     */
    public function edit(ObraMunicipio $obraMunicipio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObraMunicipioRequest  $request
     * @param  \App\Models\ObraMunicipio  $obraMunicipio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObraMunicipioRequest $request, ObraMunicipio $obraMunicipio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObraMunicipio  $obraMunicipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObraMunicipio $obraMunicipio)
    {
        //
    }
}
