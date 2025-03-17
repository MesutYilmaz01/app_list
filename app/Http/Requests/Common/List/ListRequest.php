<?php

namespace App\Http\Requests\Common\List;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'id' => 'integer|exists:user_lists,id',
            'category_id' => 'integer|exists:categories,id',
            'date' => 'date|date_format:Y-m-d',
            'before_date' => 'date|date_format:Y-m-d',
            'after_date' => 'date|date_format:Y-m-d',
            'starts_with' => 'string',
            'with_pagination' => 'boolean',
            'page' => 'integer|min:1',
            'per_page' => 'integer|max:100'
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('with_pagination')) {
            $this->merge(['with_pagination' => true]);
        }
        if (!$this->has('page')) {
            $this->merge(['page' => 1]);
        }
        if (!$this->has('per_page')) {
            $this->merge(['per_page' => 50]);
        }
    }
}
