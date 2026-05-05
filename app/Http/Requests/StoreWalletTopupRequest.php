<?php

namespace App\Http\Requests;

use App\Models\WalletTopup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWalletTopupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_topup_create');
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
            'amount' => [
                'string',
                'required',
            ],
            'gateway_ref' => [
                'string',
                'nullable',
            ],
        ];
    }
}
