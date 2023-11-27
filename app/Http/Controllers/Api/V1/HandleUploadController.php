<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleUploadController extends Controller
{
    public function store(Request $request)
    {
        // Validation can be uncommented if needed.
        // $request->validate([
        //     'documentosAdicionais' => 'required|file',
        //     'arquivoGeorreferenciado' => 'required|file',
        // ]);

        $files = ['documentosAdicionais', 'arquivoGeorreferenciado'];
        $uploadedFilePaths = [];

        foreach ($files as $fileKey) {
            $file = $request->file($fileKey);

            try {
                if ($file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('uploads', $filename, 'public');
                    $uploadedFilePaths[$fileKey] = $path;
                } else {
                    // Optional: Add logic here if a file is not uploaded.
                    // For example, you could add a message to the array indicating the file was not provided.
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
