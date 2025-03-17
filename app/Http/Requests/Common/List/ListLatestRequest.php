<?php

namespace App\Http\Requests\Common\List;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ListLatestRequest extends FormRequest
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
            'start_date' => 'date|date_format:Y-m-d',
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
            $this->merge(['per_page' => 20]);
        }
        $this->merge(['start_date' => (string)Carbon::today()->toDateString()]);
        $this->merge(['order_by' => 'created_at']);
        $this->merge(['limit' => 20]);
    }
}
