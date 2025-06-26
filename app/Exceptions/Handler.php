<?php

namespace App\Exceptions;
use App\Traits\ApiResponseTraits; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler; 
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response ;

class Handler extends ExceptionHandler{
    use ApiResponseTraits;

    public function render($request, Throwable $e){
        if($request->expectsJson()){  
            $status_code  = Response::HTTP_INTERNAL_SERVER_ERROR;
            $exception = app()->isLocal() ? $e->getMessage() : null;

            if($e instanceof ValidationException){ 
                $status_code = Response::HTTP_BAD_REQUEST;
                return $this->apiResponse([
                    'message' => "Validation failed",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code,
                    'errors'=> $e->errors()
                ],  $status_code);
            } 
            if($e instanceof QueryException){
                return $this->apiResponse([
                    'message' => "Couldn't execute query",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code 
                ],  $status_code);
            }

            if($e instanceof UniqueConstraintViolationException){
                $status_code = Response::HTTP_BAD_REQUEST;
                return $this->apiResponse([
                    'message' => "Duplicate entry was found",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code 
                ],  $status_code);
            }

            if($e instanceof ModelNotFoundException){
                $status_code  = Response::HTTP_NOT_FOUND;
                return $this->apiResponse([
                    'message' => "Resource/s was not found",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code 
                ],  $status_code);
            }

            if($e instanceof \Exception){ 
                return $this->apiResponse([
                    'message' => "Can't handle request at the moment please try again",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code 
                ],  $status_code);
            }

            if($e instanceof \Error){ 
                return $this->apiResponse([
                    'message' => "An unknown error was occured",
                    'success' => false,
                    'exception' => $exception,
                    'error_code' =>  $status_code 
                ],  $status_code);
            }
        }
        return parent::render($request, $e);
    }
}