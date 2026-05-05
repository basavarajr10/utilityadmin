<?php

namespace App\Http\Requests;

use App\Models\MobileRecharge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMobileRechargeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mobile_recharge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mobile_recharges,id',
        ];
    }
}
