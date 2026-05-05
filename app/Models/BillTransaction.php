<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillTransaction extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'bill_transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'txn',
        'category',
        'consumer_number',
        'status',
        'bbps_ref',
    ];

    public const STATUS_SELECT = [
        'pending'  => 'Pending',
        'success'  => 'Success',
        'failed'   => 'Failed',
        'refunded' => 'Refunded',
    ];

    public const CATEGORY_SELECT = [
        'electricity' => 'Electricity',
        'water'       => 'Water',
        'gas'         => 'Gas',
        'broadband'   => 'Broadband',
    ];

    protected $fillable = [
        'customer_id',
        'txn',
        'category',
        'biller_name',
        'consumer_number',
        'amount',
        'status',
        'bbps_ref',
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
