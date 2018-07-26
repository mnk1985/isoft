<?php

namespace App\Http\Requests;

use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaction extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                function($attribute, $value, $fail) {
                    if ($value < Transaction::AMOUNT_MIN_VALUE) {
                        return $fail($attribute.' is invalid.');
                    }
                },
            ]
        ];
    }
}
