<?php

namespace App\Http\Requests\User\UserAuthority;

use Illuminate\Foundation\Http\FormRequest;

class UserAuthorityCreateRequest extends FormRequest
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
            'owner_user_id' => ['required', 'exists:users,id'],
            'authorized_user_id' => ['required', 'exists:users,id', 'different:owner_user_id'],
            'user_list_id' => ['required', 'exists:user_lists,id'],
            'authority_id' => ['required', 'exists:authorities,id'],
        ];
    }
}
