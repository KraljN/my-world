<?php

use Illuminate\Support\Facades\Log;

if(!function_exists('handleError')){
    function handleResponse($message, $statusCode, $type, $exceptionOrCreatedObject = null){
        if($statusCode == 500){
            Log::channel('errors')->error($exceptionOrCreatedObject->getMessage() . ' File: ' . $exceptionOrCreatedObject->getFile() . ' Line: '  . $exceptionOrCreatedObject->getLine());
        }
        $responseData=[
            'type' => $type,
            'message' => $message,
        ];
        if(in_array($statusCode, [200, 201])){
            $responseData['obj'] = $exceptionOrCreatedObject;
        }
        return response(
            json_encode($responseData),
            $statusCode
        );
    }
}
