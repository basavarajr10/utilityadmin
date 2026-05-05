<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'notifications';

    public const AUDIENCE_SELECT = [
        'all'      => 'All',
        'specific' => 'Specific',
    ];

    protected $dates = [
        'sent_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'draft'  => 'Draft',
        'sent'   => 'Sent',
        'failed' => 'Failed',
    ];

    public const CHANNEL_SELECT = [
        'push'  => 'Push',
        'sms'   => 'Sms',
        'email' => 'Email',
        'all'   => 'All',
    ];

    protected $fillable = [
        'title',
        'message',
        'channel',
        'audience',
        'phone_number',
        'status',
        'sent_count',
        'delivered_count',
        'sent_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getSentAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setSentAtAttribute($value)
    {
        $this->attributes['sent_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
