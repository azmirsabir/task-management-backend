<?php
  
  namespace App\Http\Requests;
  
  use Illuminate\Foundation\Http\FormRequest;

  class UserRegisterRequest extends FormRequest
  {
    public function rules(): array
    {
      return [
        'name'=>'required|string',
        'email'=>'required|email|unique:users',
        'password'=>'required|string|min:6'
      ];
    }
    
    public function authorize(): bool
    {
      return true;
    }
  }
