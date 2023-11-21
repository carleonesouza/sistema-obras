<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produto\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Listar' => 'Produtos']);
        return ProdutoResource::collection(Produto::all());
    }

    public function store(ProdutoRequest $request)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Criou' => 'Produto']);
        $produto = Produto::create($request->validated());
        return ProdutoResource::make($produto);
    }

    public function show($id)
    {
        Log::channel('user_activity')->info('User action', ['user' => Auth::user()->email, 'Consultou' => 'Produto pelo ID']);

        $produto = Produto::find($id);
    
        if (!$produto) {
            return response()->json('Produto não Encontrado', 404);
        }
    
        return ProdutoResource::make($produto);
    }

}
