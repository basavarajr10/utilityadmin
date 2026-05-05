<?php

namespace App\Http\Requests;

use App\Models\CommissionSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCommissionSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('commission_setting_edit');
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
