<?php

namespace App\Http\Requests\Common\ArtificialIntelligence;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ArtificialIntelligenceShowRequest extends FormRequest
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
            'date' => ['required', Rule::in(['tarihin','son 10 yılın', 'son 5 yılın', 'tüm zamanların'])],
            'type' =>  ['required', Rule::in(['en iyi','en kötü', 'ortalama', 'en sıradışı', 'en vasat'])],
            'count' => ['required', 'max:50'],
            'category' =>  ['required', Rule::in(['büyü','isekai', 'doğaüstü', 'romantik'])],
            'subject' =>  ['required', Rule::in(['anime','film', 'dizi', 'kitap'])],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['date' => $this->query()['date']]);
        $this->merge(['type' => $this->query()['type']]);
        $this->merge(['count' => $this->query()['count']]);
        $this->merge(['category' => $this->query()['category']]);
        $this->merge(['subject' => $this->query()['subject']]);
    }
}
