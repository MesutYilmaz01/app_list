<?php

namespace App\Http\Requests\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListUpdateeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'header' => ['required','max:100'],
            'description' => ['required','max:500'],
            'status' => ['in:0,1'],
            'is_public' => ['in:0,1'],
        ];
    }
}
