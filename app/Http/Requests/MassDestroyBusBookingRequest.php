<?php

namespace App\Http\Requests;

use App\Models\BusBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBusBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bus_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bus_bookings,id',
        ];
    }
}
