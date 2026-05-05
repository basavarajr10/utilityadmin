<?php

namespace App\Http\Requests;

use App\Models\WalletTopup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalletTopupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_topup_edit');
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
