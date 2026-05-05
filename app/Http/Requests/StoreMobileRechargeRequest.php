<?php

namespace App\Http\Requests;

use App\Models\MobileRecharge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMobileRechargeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mobile_recharge_create');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
            ],
            'txn' => [
                'string',
                'required',
            ],
            'mobile_number' => [
                'string',
                'required',
            ],
            'operator' => [
                'string',
                'required',
            ],
            'circle' => [
                'string',
                'nullable',
            ],
            'plan_name' => [
                'string',
                'nullable',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'api_ref' => [
                'string',
                'nullable',
            ],
        ];
    }
}
