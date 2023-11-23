<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Http\Requests\StoreObraRequest;
use App\Http\Requests\UpdateObraRequest;
use App\Http\Resources\ObraResource;
use App\Models\Endereco;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Obra']);
        return ObraResource::collection(Obra::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreObraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObraRequest $request)
    {
       

        try {
            // echo "<pre>";

            // $values = $request->all();
            // //printf($keys);
            // print_r($values);
            // die;

            Log::channel('user_activity')->info('User action', [
                'user' => Auth::user()->email,
                'Criou' => 'Obra'
            ]);

            //$local = $this->fileUpload($request);
            //$request['documentosAdicionais'] = $local;

            $endereco = json_decode($request->input('endereco'), true);

            // Assuming $request['endereco'] contains all data for Endereco
            $ende = Endereco::create($endereco);

            // Add the endereco_id to the request data for Obra
            $obraData = $request->all();
            $obraData['endereco'] = $ende->id;

            $obra = Obra::create($obraData);

            return ObraResource::make($obra);
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Obra: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao Criar Obra: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => ' Obra pelo ID']);

        $obra = Obra::find($id);

        if (!$obra) {
            return response()->json('Obra não Encontrada', 404);
        }

        return ObraResource::make($obra);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function edit(Obra $obra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObraRequest  $request
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObraRequest $request, Obra $obra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obra $obra)
    {
        //
    }

    public function fileUpload($request)
    {
        // Validate the file
        // $validatedData = $request->validate([
        //     'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        // ]);

        // Check if the file is present in the request
        if ($request->hasFile('file')) {
            // Get the file from the request
            $file = $request->file('file');

            // Create a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the 'uploads' directory within the 'public' disk
            $path = $file->storeAs('uploads', $fileName, 'public');

            // Return the path
            return $path;
        }

        // Handle the case where no file is present
        return 'No file provided';
    }
}
