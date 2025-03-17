<?php

namespace App\Http\Requests\Admin\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListUpdateRequest extends FormRequest
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
            'list_id' => ['exists:user_lists,id'],
            'status' => ['in:0,1'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['list_id' => $this->route('list_id')]);
    }
}
