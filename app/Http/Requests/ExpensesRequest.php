<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'nullable',
            'new_category' => 'nullable|string|max:100',
            'payment_mode' => 'nullable|required_if:type,expense|in:pix,cartao',
            'type' => 'required|in:income,expense',
            'is_installment' => 'boolean',
            'total_installments' => 'nullable|required_if:is_installment,true|integer|min:2'
        ];
    }
}
