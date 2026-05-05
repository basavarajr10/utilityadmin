<?php

namespace App\Http\Requests;

use App\Models\KycRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyKycRequestRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('kyc_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:kyc_requests,id',
        ];
    }
}
