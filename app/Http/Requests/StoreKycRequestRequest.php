<?php

namespace App\Http\Requests;

use App\Models\KycRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreKycRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kyc_request_create');
    }

    public function rules()
    {
        return [
            'aadhaar_number' => [
                'string',
                'nullable',
            ],
            'pan_number' => [
                'string',
                'nullable',
            ],
            'aadhaar_doc' => [
                'array',
            ],
            'pan_doc' => [
                'array',
            ],
            'reviewed_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
