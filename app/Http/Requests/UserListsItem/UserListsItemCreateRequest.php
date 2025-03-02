<?php

namespace App\Http\Requests\UserListsItem;

use Illuminate\Foundation\Http\FormRequest;

class UserListsItemCreateRequest extends FormRequest
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
            'user_list_id' => ['required', 'exists:user_lists,id'],
            'header' => ['required','max:100'],
            'description' => ['required','max:500'],
            'status' => ['in:0,1'],
        ];
    }
}
