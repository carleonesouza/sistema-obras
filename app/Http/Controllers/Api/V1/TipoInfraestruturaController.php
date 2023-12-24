<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoInfraestruturaRequest;
use App\Http\Requests\TipoInfraestrutura\UpdateTipoInfraestruturaRequest;
use App\Http\Resources\TipoInfraestruturaResource;
use App\Models\TipoInfraestrutura;
use Carbon\Carbon;
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
        Log::channel('user_activity')->info('action', [
            'user' => Auth::user()->email, 
            'action' => 'Listou Tipo Infraestrutura',
            'date' => Carbon::now()->toDateTimeString()
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
            $user = Auth::user();
            
            if ($user->hasRole('ADMIN')) {
            
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Tipo Infraestrutura', 'date' => Carbon::now()->toDateTimeString()]);
            $tipoInfra = TipoInfraestrutura::create($request->validated());

            }else {
                // Handle the case where Empreendimento is not found
                return response()->json(['message' => 'Não Autorizado'], 401);
            }
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

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Tipo Infraestrutura pelo ID','date' => Carbon::now()->toDateTimeString()]);

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
        
        // Log the action
        Log::channel('user_activity')->info('action', [
            'user' => $user->email,
            'action' => 'Buscou Tipo Infraestutura',
            'date' => Carbon::now()->toDateTimeString()
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
    public function update(UpdateTipoInfraestruturaRequest $request)
    {
        try {
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Atualizou Tipo Infraestrutura pelo ID', 'date' => Carbon::now()->toDateTimeString()]);
    
            $user = Auth::user();
    
            if ($user->hasRole('ADMIN')) {
                $tipoInfra = TipoInfraestrutura::find($request->id);
            } else {
                return response()->json('Não Autorizado ', 401);
            }
    
            if ($tipoInfra) {
                $tipoInfra->update($request->all());
    
                return TipoInfraestruturaResource::make($tipoInfra);
            } else {
                // Handle the case where Iniciativa is not found
                return response()->json('Tipo Infraestrutura not found', 404);
            }
        } catch (Exception $e) {
            Log::error('Error updating Tipo Infraestrutura: ' . $e->getMessage());
            return response()->json('Falha ao atualizar Tipo Infraestrutura: ' . $e->getMessage(), 500);
        }
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
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Tipo Infraestrutura', 'date' => Carbon::now()->toDateTimeString()]);

        $infras = TipoInfraestrutura::where('setor', $setor)->get();
        
        return TipoInfraestruturaResource::collection($infras);

    }
}
