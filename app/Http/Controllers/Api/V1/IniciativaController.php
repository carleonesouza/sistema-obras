<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Iniciativas\DeleteIniciativaRequest;
use App\Http\Requests\Iniciativas\StoreIniciativaRequest;
use App\Http\Requests\Iniciativas\UpdateIniciativaRequest;
use App\Models\Iniciativa;
use App\Http\Resources\IniciativaResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IniciativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Listar Iniciativa']);



        // Retrieve itemsPerPage from request, set default to 15 if not provided
        $itemsPerPage = $request->input('itemsPerPage', 10);

        // Optional: Validate or limit itemsPerPage to prevent unreasonable values
        $itemsPerPage = max(1, min($itemsPerPage, 100)); // Ensures it's between 1 and 100

        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {

            $iniciativas = Iniciativa::paginate($itemsPerPage);
        } else {

            $iniciativas = Iniciativa::where('user', $user->id)->paginate($itemsPerPage);
        }

        return IniciativaResource::collection($iniciativas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIniciativaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIniciativaRequest $request)
    {

        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Criou Iniciativa']);


            $iniciativa = Iniciativa::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'expectativa' => $request->expectativa,
                'instrumento' => $request->instrumento,
                'responsavel' => $request->responsavel,
                'setor' => $request->setor,
                'status' => $request->status,
                'user' => $request->user
            ]);

            return IniciativaResource::make($iniciativa);
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error creating iniciativa: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json(['message'=>'Falha ao cadastrar iniciativa: '. $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Consultou Iniciativa pelo ID']);

        $iniciativa = Iniciativa::find($id);

        if (!$iniciativa) {

            return response()->json(['message'=>'Iniciativa não Encontrada'], 404);
        }

        return IniciativaResource::make($iniciativa);
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
            'Listou' => 'Iniciativa'
        ]);
    
        // Use Eloquent's when() method for conditional clauses
        $query = Iniciativa::when($user->hasRole('ADMIN'), function ($query) use ($searchTerm) {
            return $query->where('nome', 'LIKE', "%{$searchTerm}%");
        }, function ($query) use ($user, $searchTerm) {
            return $query->where('user', $user->id)
                         ->where('nome', 'LIKE', "%{$searchTerm}%");
        });
    
        // Consider adding pagination
        $items = $query->paginate(15); // Or any number that suits your application
    
        return IniciativaResource::collection($items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIniciativaRequest  $request
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIniciativaRequest $request)
    {
        try {
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Atualizou Iniciativa pelo ID']);


            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {

                $iniciativa = Iniciativa::find($request->id);
            } else {

                $iniciativa = Iniciativa::where('user', $user->id)->get();
            }

            if ($iniciativa) {

                $iniciativa->update($request->all());

                return IniciativaResource::make($iniciativa);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating iniciativa: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar iniciativa: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteIniciativaRequest $request, Iniciativa $iniciativa)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'action' => 'Deletou Iniciativa pelo ID']);
        // Attempt to find the user by ID.
        $iniciativa::where('id', $request->id)->delete();

        if (!$iniciativa) {
            // User with the specified ID was not found.
            return response()->json('Iniciativa não encontrada!', 404);
        }

        return response()->noContent();
    }
}
