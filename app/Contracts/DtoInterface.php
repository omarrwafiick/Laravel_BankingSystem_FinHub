<?php 
namespace App\Contracts;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Foundation\Http\FormRequest; 

interface DtoInterface{
    public static function fromRequestToDto(FormRequest $request): self;
    public static function fromModelToDto(Model $model): self; 
    public function toArray(Model $model): array;
}