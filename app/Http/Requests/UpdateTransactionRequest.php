<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transaction_edit');
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
            'type' => [
                'required',
            ],
            'reference' => [
                'string',
                'nullable',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'commission_earned' => [
                'string',
                'nullable',
            ],
        ];
    }
}
