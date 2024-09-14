<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeCategoryListRequest extends FormRequest
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
            'symbol' => ['string'],
            'name' => ['string'],
            'description' => ['string'],
            'sortDir' => ['string'],
            'sortColumn' => ['string'],
            'page' => ['required', 'numeric', 'min:0'],
            'pageSize' => ['required', 'numeric', 'min:1'],
            'languageId' => ['required', 'numeric', 'min:1']
        ];
    }
}
