<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTopup extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'wallet_topups';

    public static $searchable = [
        'txn',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const METHOD_SELECT = [
        'upi'        => 'Upi',
        'card'       => 'Card',
        'netbanking' => 'NetBanking',
    ];

    public const STATUS_SELECT = [
        'pending' => 'Pending',
        'success' => 'Success',
        'failed'  => 'Failed',
    ];

    protected $fillable = [
        'customer_id',
        'txn',
        'amount',
        'method',
        'gateway_ref',
        'status',
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
