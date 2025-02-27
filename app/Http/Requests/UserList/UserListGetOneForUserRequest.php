<?php

namespace App\Http\Requests\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListGetOneForUserRequest extends FormRequest
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
            'list_id' => ['required','exists:user_lists,id'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['list_id' => $this->route('list_id')]);
    }
}
