<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Expense;

class ExpensesRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->route('expense') !== null) {
            abort_unless(Expense::where('user_id', $this->user()->id)->whereKey($this->route('expense'))->exists(), 404);
        }

        return true;
    }
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
            'category_id' => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'new' && (! is_scalar($value) || ! ctype_digit((string) $value) || ! \App\Models\Category::where('user_id', $this->user()->id)->where('type', $this->input('type'))->whereKey($value)->exists())) {
                    $fail('Escolha uma categoria válida para o tipo da movimentação.');
                }
            }],
            'new_category' => 'nullable|required_if:category_id,new|string|max:100',
            'payment_mode' => 'nullable|required_if:type,expense|in:pix,cartao',
            'type' => 'required|in:income,expense',
            'is_installment' => 'boolean',
            'total_installments' => 'nullable|required_if:is_installment,true|integer|min:2'
        ];
    }
}
