<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'txn',
        'type',
        'reference',
        'commission_earned',
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
        'type',
        'reference',
        'amount',
        'commission_earned',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'mobile_recharge' => 'Mobile Recharge',
        'dth'             => 'Dth',
        'bill_payment'    => 'Bill Payment',
        'bus_booking'     => 'Bus Booking',
        'wallet_topup'    => 'Wallet Topup',
        'withdrawal'      => 'Withdrawal',
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
