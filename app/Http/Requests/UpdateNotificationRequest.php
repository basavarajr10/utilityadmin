<?php

namespace App\Http\Requests;

use App\Models\Notification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('notification_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'message' => [
                'string',
                'required',
            ],
            'channel' => [
                'required',
            ],
            'phone_number' => [
                'string',
                'nullable',
            ],
            'sent_count' => [
                'string',
                'nullable',
            ],
            'delivered_count' => [
                'string',
                'nullable',
            ],
            'sent_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
