<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusBooking extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'bus_bookings';

    public static $searchable = [
        'source',
        'destination',
        'passenger_details',
    ];

    protected $dates = [
        'travel_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'pending'   => 'Pending',
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
        'refunded'  => 'Refunded',
    ];

    protected $fillable = [
        'customer_id',
        'booking',
        'source',
        'destination',
        'travel_date',
        'seats',
        'passenger_details',
        'amount',
        'status',
        'api_ref',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getTravelDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setTravelDateAttribute($value)
    {
        $this->attributes['travel_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
