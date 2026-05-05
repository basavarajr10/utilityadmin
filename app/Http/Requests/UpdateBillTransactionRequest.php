<?php

namespace App\Http\Requests;

use App\Models\BillTransaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBillTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bill_transaction_edit');
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
            'biller_name' => [
                'string',
                'required',
            ],
            'consumer_number' => [
                'string',
                'required',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'bbps_ref' => [
                'string',
                'nullable',
            ],
        ];
    }
}
