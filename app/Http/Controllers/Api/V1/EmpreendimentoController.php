<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empreendimentos\DeleteEmpreendimentoRequest;
use App\Http\Requests\Empreendimentos\StoreEmpreendimentoRequest;
use App\Http\Requests\Empreendimentos\UpdateEmpreendimentoRequest;
use App\Models\Empreendimento;
use App\Http\Resources\EmpreendimentoResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmpreendimentoController extends Controller
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
            'action' => 'Listou Empreendimentos',
            'date' => Carbon::now()->toDateTimeString() 
        ]);

        $user = Auth::user();

        // Retrieve itemsPerPage from request, set default to 15 if not provided
        $itemsPerPage = $request->input('itemsPerPage', 10);

        // Optional: Validate or limit itemsPerPage to prevent unreasonable values
        $itemsPerPage = max(1, min($itemsPerPage, 100)); // Ensures it's between 1 and 100

        if ($user->hasRole('ADMIN')) {
            // Eager load relationships if necessary and paginate
            $empreendimentos = Empreendimento::paginate($itemsPerPage);
        } else {
            // Eager load relationships if necessary, filter by user, and paginate
            $empreendimentos = Empreendimento::where('user', $user->id)->paginate($itemsPerPage);
        }

        return EmpreendimentoResource::collection($empreendimentos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmpreendimentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmpreendimentoRequest $request)
    {

        try {
            
            Log::channel('user_activity')->info('action', [
                'user' => Auth::user()->email, 
                'action' => 'Criou Empreendimento',
                'date' => Carbon::now()->toDateTimeString() 
            ]);

            $validated = $request->validated();

            if (!$validated['natureza_empreendimento']) {

                return response()->json(['message' => 'Bad Request'], 400);
            }

            $empreendimento = Empreendimento::create([
                'nome' => $request->nome,
                'responsavel' => $request->responsavel,
                'setor' => $request->setor,
                'natureza_empreendimento' => $request->natureza_empreendimento,
                'user' => $request->user,
                'status' => $request->status
            ]);

            return EmpreendimentoResource::make($empreendimento);
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating Empreendimento: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao criar Empreendimento: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empreendimento = Empreendimento::with('user')->find($id);


        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Empreendimento pelo ID',
        'date' => Carbon::now()->toDateTimeString() ]);

        if (!$empreendimento) {
            return response()->json(['message' => 'Empreendimento não Encontrado'], 404);
        }

        return new EmpreendimentoResource($empreendimento);
    }

    public function search(Request $request)
    {
        // Validate the search term
        $validatedData = $request->validate([
            'term' => 'required|string|max:255', // Adjust validation rules as needed
        ]);
        $searchTerm = $validatedData['term'];

        $user = Auth::user();

        Log::channel('user_activity')->info('action', [
            'user' => $user->email,
            'action' => 'Listou Empreendimento',
            'date' => Carbon::now()->toDateTimeString() 
        ]);

        // Use Eloquent's when() method for conditional clauses
        $query = Empreendimento::when($user->hasRole('ADMIN'), function ($query) use ($searchTerm) {
            return $query->where('nome', 'LIKE', "%{$searchTerm}%");
        }, function ($query) use ($user, $searchTerm) {
            return $query->where('user', $user->id)
                ->where('nome', 'LIKE', "%{$searchTerm}%");
        });

        // Consider adding pagination
        $items = $query->paginate(15); // Or any number that suits your application

        return EmpreendimentoResource::collection($items);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmpreendimentoRequest  $request
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpreendimentoRequest $request)
    {
        try {
            Log::channel('user_activity')->info('action', [
                'user' => Auth::user()->email, 
                'action' => 'Atualizou Empreendimento pelo ID',
                'date' => Carbon::now()->toDateTimeString() 
            ]);

            $user = Auth::user();
            
          

            if ($user->hasRole('ADMIN')) {
                $empreendimento = Empreendimento::find($request->id);
            } else {
                $empreendimento = Empreendimento::where('user', $user->id)
                                                ->where('id', $request->id)
                                                ->first();
            }
    
            if ($empreendimento) {
            
                $empreendimento->update($request->all());
    
                return EmpreendimentoResource::make($empreendimento);
            } else {
                // Handle the case where Empreendimento is not found
                return response()->json(['message' => 'Empreendimento not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error updating Empreendimento: ' . $e->getMessage());
            return response()->json(['message' => 'Falha ao atualizar Empreendimento: ' . $e->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empreendimento  $empreendimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteEmpreendimentoRequest $request, Empreendimento $empreendimento)
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Deletou Empreendimento pelo ID',
        'date' => Carbon::now()->toDateTimeString() ]);
        // Attempt to find the empreendimento by ID.
        $empreendimento::where('id', $request->id)->delete();

        if (!$empreendimento) {
            // Empreendimento with the specified ID was not found.
            return response()->json(['message' => 'Empreendimento não encontrado!'], 404);
        }

        return response()->noContent();
    }

    /**
     * Retrieves empreendimentos filtered by setor.
     * 
     * @param string $setor The sector to filter empreendimentos.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function empreendimentoBySetor($setor)
    {
        // Log user activity
        Log::channel('user_activity')->info('action', [
            'user' => Auth::user()->email,
            'action' => 'Listou Empreendimentos',
            'date' => Carbon::now()->toDateTimeString()
        ]);

        // Validate setor
        if (!is_string($setor) || empty($setor)) {
            return response()->json(['message' => 'Empreendimento não encontrado!'], 404);
        }

        $user = Auth::user();

        try {
            if ($user->hasRole('ADMIN')) {
                $empreendimentos = Empreendimento::where('setor', $setor)->get();
            } else {
                $empreendimentos = Empreendimento::where('user', $user->id)
                    ->where('setor', $setor)
                    ->get();
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Empreendimento não encontrado! '. $e->getMessage()], 404);
        }

        return EmpreendimentoResource::collection($empreendimentos);
    }
}
