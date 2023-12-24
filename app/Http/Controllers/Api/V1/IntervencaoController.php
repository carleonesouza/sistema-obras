<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intervencao\StoreIntervencaoRequest;
use App\Http\Requests\Intervencao\UpdateIntervencaoRequest;
use App\Http\Resources\IntervencaoResource;
use App\Models\Intervencao;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IntervencaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Intervencao', 'date' => Carbon::now()->toDateTimeString()]);

        $itemsPerPage = $request->input('itemsPerPage', 10);

        $itemsPerPage = max(1, min($itemsPerPage, 100));

        $intervencoes = Intervencao::paginate($itemsPerPage);

        return IntervencaoResource::collection($intervencoes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIntervencaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntervencaoRequest $request)
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {

                Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Intervencao', 'date' => Carbon::now()->toDateTimeString()]);
                $intervecao = Intervencao::create($request->validated());
                
            } else {
                return response()->json('Não Autorizado', 401);
            }
            return IntervencaoResource::make($intervecao);
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error criar Intervencao: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json(['message' => 'Falha ao criar Intervencao: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $intervecao = Intervencao::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Intervencao pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$intervecao) {
            return response()->json(['message' => 'Intervencao não Encontrada'], 404);
        }
        return new IntervencaoResource($intervecao);
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
            'action' => 'Procurou Intervenção',
            'date' => Carbon::now()->toDateTimeString()
        ]);

        // Perform the search query
        $items = Intervencao::where('descricao', 'LIKE', "%{$searchTerm}%")
            ->paginate(15);

        // Return the paginated results as a resource collection
        return IntervencaoResource::collection($items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIntervencaoRequest  $request
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIntervencaoRequest $request)
    {
        try {
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Atualizou Intervenções pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                $intervecao = Intervencao::find($request->id);
            } else {
                return response()->json('Não Autorizado', 401);
            }

            if ($intervecao) {
                $intervecao->update($request->all());

                return IntervencaoResource::make($intervecao);
            } else {

                return response()->json('Intervenções not found', 404);
            }
        } catch (Exception $e) {
            Log::error('Error updating Intervenções: ' . $e->getMessage());
            return response()->json('Falha ao atualizar Intervenções: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intervencao  $intervencao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intervencao $intervencao)
    {
        //
    }

    public function intervencaoBySetor($setor)
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Intervenções pelo Setor', 'date' => Carbon::now()->toDateTimeString()]);

        $intervencoes = Intervencao::where('setor', $setor)->get();

        return IntervencaoResource::collection($intervencoes);
    }
}
