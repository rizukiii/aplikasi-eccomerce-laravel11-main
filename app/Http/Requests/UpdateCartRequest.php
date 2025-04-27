<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            'products_id' => 'required|integer|exists:products,id',
            'coupon_code' => 'nullable|string|exists:promo_codes,code',
            'size' => 'required|string|exists:product_sizes,id',
            'quantity' => 'required|integer|min:1',
            'sub_total_amount' => 'required|numeric',
        ];
    }
}
