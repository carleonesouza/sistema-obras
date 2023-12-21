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
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        Log::channel('user_activity')->info('User action', [
            'user' => Auth::user()->email,
            'Listou' => 'Obra'
        ]);

        $user = Auth::user();

        // Retrieve itemsPerPage from request, set default to 15 if not provided
        $itemsPerPage = $request->input('itemsPerPage', 10);

        // Optional: Validate or limit itemsPerPage to prevent unreasonable values
        $itemsPerPage = max(1, min($itemsPerPage, 100)); // Ensures it's between 1 and 100

        if ($user->hasRole('ADMIN')) {
            // Eager load 'produtos' and 'municipios' relationships and paginate
            $obras = Obra::with(['produtos', 'municipios'])->paginate($itemsPerPage);
        } else {
            // Eager load 'produtos' and 'municipios' relationships, filter by user, and paginate
            $obras = Obra::with(['produtos', 'municipios'])->where('user', $user->id)->paginate($itemsPerPage);
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

            return response()->json(['message'=> 'Falha ao Criar Obra: ' . $e->getMessage()], 500);
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
            return response()->json(['message'=>'Obra não Encontrada'], 404);
        }

        return ObraResource::make($obra);
    }

    public function search(Request $request)
    {
        // Validate the search term
        $validatedData = $request->validate([
            'term' => 'required|string|max:255', // Adjust validation rules as needed
        ]);
        $searchTerm = $validatedData['term'];
    
        $user = Auth::user();
        
        Log::channel('user_activity')->info('User action', [
            'user' => $user->email,
            'Listou' => 'Obra'
        ]);
    
        // Use Eloquent's when() method for conditional clauses
        $query = Obra::when($user->hasRole('ADMIN'), function ($query) use ($searchTerm) {
            return $query->where('tipo', 'LIKE', "%{$searchTerm}%");
        }, function ($query) use ($user, $searchTerm) {
            return $query->where('user', $user->id)
                         ->where('tipo', 'LIKE', "%{$searchTerm}%")
                         ->with(['produtos', 'municipios']);
        });
    
        // Consider adding pagination
        $items = $query->paginate(15); // Or any number that suits your application
    
        return ObraResource::collection($items);
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

            $data = $request->except(['id', 'produtos', 'municipios']);
            $obra->update($data);

            // Update 'produtos' relationship if 'produtos' is provided
            if ($request->has('produtos')) {
                $obra->produtos()->attach($request->produtos);
            }

            if ($request->has('municipios')) {
                foreach ($request->input('municipios') as $municipioData) {

                    if (!$municipioData['municipio_id']) {

                        $municipio = Municipio::create($municipioData);
                        $obra->municipios()->attach($municipio->id);
                    } else {
                        $obra->municipios()->sync([$municipioData]);
                    }
                }
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

    public function removeMunicipio($id, UpdateObraRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', [
                'user' => Auth::user()->email,
                'Removeu' => 'Municipio da Obra pelo ID'
            ]);

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                $obra = Obra::with('municipios')->find($id);
            } else {
                $obra = Obra::with('municipios')->where('user', $user->id)->where('id', $id)->first();
            }

            if (!$obra) {
                return response()->json('Obra não encontrada', 404);
            }

            if (!$obra->municipios->isEmpty()) {

                $obra->municipios()->detach($request->id);

                return response()->json(['message' => 'Município removido com Sucesso!'], 201);
            } else {
                return response()->json(['message' => 'ID(s) de Município não fornecido(s) ou inválido(s)!'], 400);
            }
        } catch (Exception $e) {
            return response()->json('Falha ao remover município da Obra: ' . $e->getMessage(), 500);
        }
    }


    public function removeProduto($id, UpdateObraRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', [
                'user' => Auth::user()->email,
                'Removeu' => 'Produto da Obra pelo ID'
            ]);

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                $obra = Obra::with('produtos')->find($id);
            } else {
                $obra = Obra::with('produtos')->where('user', $user->id)->where('id', $id)->first();
            }

            if (!$obra) {
                return response()->json('Obra não encontrada', 404);
            }

            if (!$obra->produtos->isEmpty()) {
                $obra->produtos()->detach($request->id);
                return response()->json(['message' => 'Produto removido com Sucesso!'], 201);
            } else {
                return response()->json(['message' => 'Não foi possível remover o Produto, Produto não encontrado na Obra!'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error Deleting Produto from Obra: ' . $e->getMessage());
            return response()->json('Falha ao remover produto da Obra: ' . $e->getMessage(), 500);
        }
    }
}
