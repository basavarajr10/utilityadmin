<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DthRecharge extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'dth_recharges';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'pending'  => 'Pending',
        'success'  => 'Success',
        'failed'   => 'Failed',
        'refunded' => 'Refunded',
    ];

    protected $fillable = [
        'customer_id',
        'txn',
        'subscriber',
        'provider',
        'pack_name',
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
}
