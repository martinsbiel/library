<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'author' => 'max:255',
            'status' => 'boolean',
            'genre_id' => 'numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.max' => 'O campo nome pode conter no máximo 255 caracteres.',
            'author.max' => 'O campo autor pode conter no máximo 255 caracteres.',
            'status.boolean' => 'O campo status precisa conter um valor booleano, 0 para disponível e 1 para emprestado.',
            'genre_id.numeric' => 'O campo gênero precisa conter um valor numérico.'
        ];
    }
}
