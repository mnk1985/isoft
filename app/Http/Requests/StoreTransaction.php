<?php

namespace App\Http\Requests;

use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransaction extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: implement with policies
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
            'customerId' => ['required', 'integer'],
            'amount' => [
                'required',
                'numeric',
                function($attribute, $value, $fail) {
                    if ($value < Transaction::AMOUNT_MIN_VALUE) {
                        return $fail($attribute.' is invalid.');
                    }
                },
            ],
        ];
    }
}
