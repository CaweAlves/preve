<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RecurringTransactionRequest extends FormRequest
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
            'category_id'  => ['required', 'integer', 'exists:categories,id'],
            'tag_id'       => ['nullable', 'integer', 'exists:tags,id'],
            'amount'       => ['required', 'numeric'],
            'type'         => ['required', 'in:income,expense'],
            'frequency'    => ['required', 'in:monthly,yearly'],
            'description'  => ['required', 'string', 'min:3'],
            'day_of_month' => ['required', 'integer', 'min:1', 'max:31'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after:start_date'],
        ];
    }
}
