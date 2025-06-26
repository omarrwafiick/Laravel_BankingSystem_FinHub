<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
 
 

trait ApiResponseTraits{
    private function parseData(array $data = [], int $statusCode = 200, array $headers = []){
        $responseStructure = [
            'success' => $data['success'] ?? false,
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null, 
        ];
        if(isset($data['errors'])){
            $responseStructure['errors'] = $data['errors'];
        }
        if(isset($data['status'])){
            $statusCode = $data['status'];
        } 
        if($data['success'] === false){
            if(isset($data['error_code'])){
                $responseStructure['error_code'] = $data['error_code'];
            }
            else{
                $responseStructure['error_code'] = 1;
            }
        }
        return ['content' => $responseStructure, 'statusCode' => $statusCode, 'headers'=> $headers];
    }
    
     public function apiResponse(array $data = [], int $statusCode = 200, array $headers){
        $result = $this->parseData($data, $statusCode, $headers);
        return response()->json($result['content'], $result['statusCode'], $result['headers']);
    }

    public function sendSuccess(mixed $data = [], string $message = ''){
        return $this->apiResponse(
            ['success'=> true, 'result'=> $data, 'message'=> $message]);
    }

    public function sendError(string $message = '', int $statusCode = 400, int $error_code = 1){
        return $this->apiResponse(
            ['success'=> false, 'error_code'=> $error_code, 'message'=> $message], $statusCode);
    }

    public function sendUnauthorized(string $message = 'Unauthorized access'){
        return $this->sendError($message, 401);
    }

    public function sendForbidden(string $message = 'Forbidden route'){
        return $this->sendError($message, 403);
    }

    public function sendValidationError(ValidationException $exception){
        return $this->apiResponse(
            ['success'=> false, 'errors'=> $exception->errors(), 'message'=> $exception->getMessage()], 400);
    } 
     
}