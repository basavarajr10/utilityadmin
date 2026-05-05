<?php

namespace App\Http\Requests;

use App\Models\WalletTopup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWalletTopupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('wallet_topup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:wallet_topups,id',
        ];
    }
}
