<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class HandleUploadController extends Controller
{
    public function store(Request $request)
    {
       
        $files = ['documentosAdicionais', 'arquivoGeorreferenciado'];
        $uploadedFilePaths = [];

        foreach ($files as $fileKey) {
            $file = $request->file($fileKey);

            try {
                if ($file) {
                    // Sanitize original file name and prepend timestamp
                    $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('arquivos', $filename, 'public');
                    $uploadedFilePaths[$fileKey] = Storage::url($path);
                    Log::channel('user_activity')->info('action', ['user' => Auth::user()->email, 'action' => 'Upload: '.$path, 'date' => Carbon::now()->toDateTimeString()]);
                } else {
                    $uploadedFilePaths[$fileKey] = 'File not provided';
                }
            } catch (Exception $e) {
                Log::error('Error uploading the file (' . $fileKey . '): ' . $e->getMessage());
                return response()->json('Falha ao fazer Upload do arquivo (' . $fileKey . '): ' . $e->getMessage(), 500);
            }
        }

        return response()->json($uploadedFilePaths);
    }
}
