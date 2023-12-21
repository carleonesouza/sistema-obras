<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoInfraestruturaRequest;
use App\Http\Requests\TipoInfraestrutura\UpdateTipoInfraestruturaRequest;
use App\Http\Resources\TipoInfraestruturaResource;
use App\Models\TipoInfraestrutura;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoInfraestruturaController extends Controller
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
            'Listou' => 'Tipo Infraestrutura'
        ]);
    
        // Retrieve itemsPerPage from request, set default to 15 if not provided
        $itemsPerPage = $request->input('itemsPerPage', 15);
    
        // Optional: Validate or limit itemsPerPage to prevent unreasonable values
        $itemsPerPage = max(1, min($itemsPerPage, 100)); // Ensures it's between 1 and 100
    
        // Apply pagination
        $tiposInfraestrutura = TipoInfraestrutura::paginate($itemsPerPage);
    
        return TipoInfraestruturaResource::collection($tiposInfraestrutura);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TipoInfraestrutura $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoInfraestruturaRequest $request)
    {

        try {
            
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Tipo Infraestrutura']);
            $tipoInfra = TipoInfraestrutura::create($request->validated());
            return TipoInfraestruturaResource::make($tipoInfra);

        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Tipo Infraestrutura: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json(['message'=> 'Falha ao criar Tipo Infraestrutura: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoInfra = TipoInfraestrutura::find($id);

        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Tipo Infraestrutura pelo ID']);

        if (!$tipoInfra) {
            return response()->json(['message' => 'Tipo Infraestrutura não Encontrada!'], 404);
        }
        return new TipoInfraestruturaResource($tipoInfra);
    }

    public function search(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'term' => 'required|string|max:255',
        ]);
        $searchTerm = $validatedData['term'];
    
        // Retrieve the authenticated user
        $user = Auth::user();
        
        // Log the user action
        Log::channel('user_activity')->info('User action', [
            'user' => $user->email,
            'action' => 'Search',
            'searchTerm' => $searchTerm,
            'context' => 'TipoInfraestrutura'
        ]);
    
        // Perform the search query
        $items = TipoInfraestrutura::where('descricao', 'LIKE', "%{$searchTerm}%")
                                   ->paginate(15);
    
        // Return the paginated results as a resource collection
        return TipoInfraestruturaResource::collection($items);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoInfraestruturaRequest  $request
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoInfraestruturaRequest $request, TipoInfraestrutura $tipoInfraestrutura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoInfraestrutura  $tipoInfraestrutura
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoInfraestrutura $tipoInfraestrutura)
    {
        //
    }

    public function tipoInfraBySetor($setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => ' Tipo Infraestrutura']);

        $infras = TipoInfraestrutura::where('setor', $setor)->get();
        
        return TipoInfraestruturaResource::collection($infras);

    }
}
