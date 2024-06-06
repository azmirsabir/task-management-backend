<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
        'title' => 'required|string|max:100',
        'description' => 'string|max:1000',
        'assigned_to' => 'integer|exists:users,id',
        'due_date' => 'nullable|date|after:now',
        'parent_id' => 'nullable|integer|exists:tasks,id',
      ];
    }
}
