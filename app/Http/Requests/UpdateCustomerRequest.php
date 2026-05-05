<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_edit');
    }

    public function rules()
    {
        return [
            'first_name' => [
                'string',
                'required',
            ],
            'last_name' => [
                'string',
                'required',
            ],
            'mobile_number' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
            'wallet_balance' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'referral_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
