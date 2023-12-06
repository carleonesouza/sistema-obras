<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Obra\DeleteObraRequest;
use App\Http\Requests\Obra\StoreObraRequest;
use App\Http\Requests\Obra\UpdateObraRequest;
use App\Http\Resources\ObraResource;
use App\Models\Municipio;
use App\Models\Obra;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', [
            'user' => Auth::user()->email,
            'Listou' => 'Obra'
        ]);

        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {
            // Eager load 'produtos' relationship
            $obras = Obra::with(['produtos', 'municipios'])->get();
        } else {
            // Eager load 'produtos' relationship
            $obras = Obra::with(['produtos', 'municipios'])->where('user', $user->id)->get();
        }

        return ObraResource::collection($obras);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreObraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObraRequest $request)
    {

        DB::beginTransaction();

        try {
            Log::channel('user_activity')->info('User action', [
                'user' => Auth::user()->email,
                'Criou' => 'Obra'
            ]);


            // Create the Obra
            $obraData = $request->except(['produtos', 'municipios']); // Exclude product_ids from Obra data

            $obra = Obra::create($obraData);

            // Associate Products with the newly created Obra
            if ($request->has('produtos')) {

                $productIds = collect($request->input('produtos'))->pluck('produto_id');
                $obra->produtos()->attach($productIds);
            }

            if ($request->has('municipios')) {                

                foreach ($request->input('municipios') as $municipioData) {
                       
                    $municipio = Municipio::create($municipioData);
                    $obra->municipios()->attach($municipio->id);
                }
                
            }

            DB::commit();

            return ObraResource::make($obra);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating Obra: ' . $e->getMessage());

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
        Log::channel('user_activity')->info('User action', [
            'user' => Auth::user()->email,
            'Consultou' => 'Obra pelo ID'
        ]);

        // Eager load 'produtos' relationship
        $obra = Obra::with(['produtos', 'municipios'])->find($id);


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
            Log::channel('user_activity')->info('User action', [
                'user' => Auth::user()->email,
                'Atualizou' => 'Obra pelo ID'
            ]);

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                $obra = Obra::find($request->id);
            } else {
                $obra = Obra::where('user', $user->id)->where('id', $request->id)->first();
            }

            if (!$obra) {
                return response()->json('Obra não encontrada', 404);
            }

            $data = $request->except(['id', 'produtos', 'municipios']); // Exclude 'id' and 'product_ids'
            $obra->update($data);

            // Update 'produtos' relationship if 'product_ids' is provided
            if ($request->has('produtos')) {
                $obra->produtos()->sync($request->produtos);
            }

            if ($request->has('municipios')) {
                $obra->municipios()->sync($request->municipios);
            }

            return ObraResource::make($obra->load(['produtos', 'municipios']));
        } catch (Exception $e) {

            Log::error('Error updating Obra: ' . $e->getMessage());
            return response()->json('Falha ao atualizar Obra: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteObraRequest $request, Obra $obra)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Deletou' => 'Obra pelo ID']);
        // Attempt to find the empreendimento by ID.
        $obra::where('id', $request->id)->delete();

        if (!$obra) {
            // Empreendimento with the specified ID was not found.
            return response()->json('Obra não encontrada!', 404);
        }

        return response()->noContent();
    }
}
