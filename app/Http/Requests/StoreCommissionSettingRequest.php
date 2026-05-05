<?php

namespace App\Http\Requests;

use App\Models\CommissionSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCommissionSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('commission_setting_create');
    }

    public function rules()
    {
        return [
            'service_type' => [
                'required',
            ],
            'commission_pct' => [
                'string',
                'required',
            ],
            'min_commission' => [
                'string',
                'required',
            ],
            'max_commission' => [
                'string',
                'required',
            ],
            'flat_charge' => [
                'string',
                'nullable',
            ],
        ];
    }
}
