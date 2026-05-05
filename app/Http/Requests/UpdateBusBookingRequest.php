<?php

namespace App\Http\Requests;

use App\Models\BusBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBusBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bus_booking_edit');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
            ],
            'booking' => [
                'string',
                'required',
            ],
            'source' => [
                'string',
                'required',
            ],
            'destination' => [
                'string',
                'required',
            ],
            'travel_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'seats' => [
                'string',
                'required',
            ],
            'passenger_details' => [
                'string',
                'nullable',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'api_ref' => [
                'string',
                'nullable',
            ],
        ];
    }
}
