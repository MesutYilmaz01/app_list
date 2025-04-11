<?php

namespace App\Http\Requests\User\UserAuthority;

use Illuminate\Foundation\Http\FormRequest;

class UserAuthorityDeleteRequest extends FormRequest
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
            'user_authority_id' => ['required', 'exists:user_authorities,id'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_authority_id' => $this->route('user_authority_id')]);
    }
}
