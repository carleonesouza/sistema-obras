<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produto\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Carbon\Carbon;
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
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Produtos', 'date' => Carbon::now()->toDateTimeString()]);
        return ProdutoResource::collection(Produto::all());
    }

    public function store(ProdutoRequest $request)
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Produto', 'date' => Carbon::now()->toDateTimeString()]);
        $produto = Produto::create($request->validated());
        return ProdutoResource::make($produto);
    }

    public function show($id)
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Produto pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        $produto = Produto::find($id);
    
        if (!$produto) {
            return response()->json('Produto não Encontrado', 404);
        }
    
        return ProdutoResource::make($produto);
    }

}
