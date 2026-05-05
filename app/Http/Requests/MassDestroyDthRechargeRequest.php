<?php

namespace App\Http\Requests;

use App\Models\DthRecharge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDthRechargeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dth_recharge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dth_recharges,id',
        ];
    }
}
