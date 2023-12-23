<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StoreStatusRequest;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Listou Status', 'date' => Carbon::now()->toDateTimeString()]);
        return StatusResource::collection(Status::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request)
    {
        try{
            Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Criou Status', 'date' => Carbon::now()->toDateTimeString()]);
            $status = Status::create($request->validated());
            return StatusResource::make($status);
            
        }catch (Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Error updating Status: ' . $e->getMessage());
    
            // Return an error response or handle the error as needed.
            return response()->json('Falha ao atualizar Status: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = Status::find($id);

        Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Consultou Status pelo ID', 'date' => Carbon::now()->toDateTimeString()]);

        if (!$status) {
            return response()->json('Status não Encontrada', 404);
        }
        return new Status($status);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
