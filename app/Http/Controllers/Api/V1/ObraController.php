<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Obra\StoreObraRequest;
use App\Http\Requests\Obra\UpdateObraRequest;
use App\Http\Resources\ObraResource;
use App\Models\Obra;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
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

          

            // Add the endereco_id to the request data for Obra
            $obraData = $request->all();

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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObraRequest  $request
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObraRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Atualizou' => 'Obra pelo ID']);

        
            $obra = Obra::find($request->id);

            if($obra){
                $data = $request->all();
                    // Remove 'id' from the data array
                $data = Arr::except($data, ['id']);
                $obra->update($data);
               
            }
            return ObraResource::make($obra);
           
        } catch (Exception $e) {
            // Log the exception for Obra purposes.
            Log::error('Error updating Obra: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Obra: '.$e->getMessage(), 500);
        }
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

}
