<?php

namespace App\Http\Requests\Admin\Authority;

use Illuminate\Foundation\Http\FormRequest;

class AuthorityShowRequest extends FormRequest
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
            'authority_id' => ['required', 'exists:authorities,id'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['authority_id' => $this->route('authority_id')]);
    }
}
