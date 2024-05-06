<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSoccerPlayerRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'skill_level' => [
                'sometimes',
                'integer',
                'between:1,5'
            ],
            'goalkeeper' => [
                'sometimes',
                'boolean'
            ],
            'confirmed' => [
                'sometimes',
                'boolean'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'skill_level.integer' => 'O nível de habilidade deve ser um número inteiro.',
            'skill_level.between' => 'O nível de habilidade deve estar entre 1 e 5.',
            'goalkeeper.boolean' => 'A indicação de goleiro deve ser verdadeira ou falsa.',
            'confirmed.boolean' => 'A indicação se o jogador confirmou deve ser verdadeira ou falsa.',
        ];
    }
}
