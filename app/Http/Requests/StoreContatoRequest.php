<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'pessoa_id' => 'required|exists:pessoas,id',
            'country_code' => 'required|string|max:10',
            'number' => [
                'required',
                'string',
                'regex:/^[0-9]{9}$/',
                Rule::unique('contatos')->where(function ($query) {
                    return $query->where('country_code', $this->country_code);
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'pessoa_id.required' => 'A pessoa é obrigatória.',
            'pessoa_id.exists' => 'Pessoa não encontrada.',
            'country_code.required' => 'O código do país é obrigatório.',
            'number.required' => 'O número é obrigatório.',
            'number.regex' => 'O número deve ter exatamente 9 dígitos.',
            'number.unique' => 'Este número já existe para este país.'
        ];
    }
}
