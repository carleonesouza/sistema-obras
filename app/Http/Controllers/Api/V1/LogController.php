<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use SplFileObject;

class LogController extends Controller
{
    public function index()
    {
        $logData = []; // Array para armazenar os dados do log
    
        // Abre o arquivo de log
        $file = new SplFileObject(storage_path('logs/user_activity.log'));
    
        // Lê o arquivo linha por linha
        while (!$file->eof()) {
            $line = $file->fgets();
            
            // Encontra a posição inicial do JSON na linha
            $jsonStartPos = strpos($line, '{');
            
            // Verifica se encontrou um JSON
            if ($jsonStartPos !== false) {
                // Extrai a parte JSON da linha
                $jsonPart = substr($line, $jsonStartPos);
                $jsonPart = rtrim($jsonPart); // Remove a quebra de linha no final
    
                // Tenta decodificar o JSON e adiciona ao array se for bem-sucedido
                $decodedJson = json_decode($jsonPart, true);
                if ($decodedJson !== null) {
                    $logData[] = $decodedJson;
                }
            }
        }
    
        return response()->json($logData);
    }
    
}
