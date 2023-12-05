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

class EmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => 'Empreendimentos']);

        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {

            $empreendimentos = Empreendimento::all();
        } else {
            $empreendimentos = Empreendimento::where('user', $user->id)->get();
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

        try{
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Empreendimento']);

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
            'status' =>$request->status
        ]);

        return EmpreendimentoResource::make($empreendimento);
            
        }catch(Exception $e) {
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


        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Empreendimento pelo ID']);

        if (!$empreendimento) {
            return response()->json('Empreendimento não Encontrada', 404);
        }

        return new EmpreendimentoResource($empreendimento);
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
            Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Atualizou' => 'Empreendimento pelo ID']);

            $user = Auth::user();

            if ($user->hasRole('ADMIN')) {
                $empreendimento = Empreendimento::find($request->id);
            } else {

                $empreendimento = Empreendimento::where('user', $user->id)->get();
            }

            if ($empreendimento) {

                $empreendimento->update($request->all());

                return EmpreendimentoResource::make($empreendimento);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Empreendimento: ' . $e->getMessage());

            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Empreendimento: ' . $e->getMessage(), 500);
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
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Deletou' => 'Empreendimento pelo ID']);
        // Attempt to find the empreendimento by ID.
        $empreendimento::where('id', $request->id)->delete();

        if (!$empreendimento) {
            // Empreendimento with the specified ID was not found.
            return response()->json('Empreendimento não encontrada!', 404);
        }

        return response()->noContent();
    }

    public function empreendimentoBySetor($setor)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listou' => ' Empreendimentos']);

        $empreendimentos = Empreendimento::where('setor', $setor)->get();
        
        return EmpreendimentoResource::collection($empreendimentos);

    }
}
