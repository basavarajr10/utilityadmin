<?php

namespace App\Http\Requests;

use App\Models\DthRecharge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDthRechargeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dth_recharge_create');
    }

    public function rules()
    {
        return [
            'txn' => [
                'string',
                'required',
            ],
            'subscriber' => [
                'string',
                'required',
            ],
            'provider' => [
                'string',
                'required',
            ],
            'pack_name' => [
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
