<?php

namespace App\Http\Requests\Common\Dislike;

use Illuminate\Foundation\Http\FormRequest;

class DislikeUserListRequest extends FormRequest
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
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_list_id' => $this->route('user_list_id')]);
    }
}
