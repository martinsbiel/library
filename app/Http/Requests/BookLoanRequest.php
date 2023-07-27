<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'target_date' => 'required|date',
            'user_id' => 'required|numeric',
            'book_id' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'target_date.required' => 'O campo devolução é obrigatório.',
            'target_date.date' => 'O campo devolução deve conter uma data válida.',
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.numeric' => 'O campo usuário deve conter um valor numérico.',
            'book_id.required' => 'O campo livro é obrigatório.',
            'book_id.numeric' => 'O campo livro deve conter um valor numérico.',
        ];
    }
}
