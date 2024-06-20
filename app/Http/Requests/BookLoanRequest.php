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
}
