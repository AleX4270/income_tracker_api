<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'userId' => ['numeric'],
            'currencyId' => ['numeric'],
            'amountMin' => ['numeric', 'lt:amountMax'],
            'amountMax' => ['numeric', 'gt:amountMin'],
            'dateFrom' => ['date', 'before:dateTo'],
            'dateTo' => ['date', 'after:dateFrom'],
            'description' => ['string'],
            'sortDir' => ['string'],
            'sortColumn' => ['string'],
            'page' => ['numeric', 'min:0'],
            'pageSize' => ['numeric', 'min:0']
        ];
    }
}
