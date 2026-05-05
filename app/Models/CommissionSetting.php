<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionSetting extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'commission_settings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_type',
        'commission_pct',
        'min_commission',
        'max_commission',
        'flat_charge',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const SERVICE_TYPE_SELECT = [
        'mobile_recharge' => 'Mobile Recharge',
        'dth'             => 'Dth',
        'electricity'     => 'Electricity',
        'water'           => 'Water',
        'gas'             => 'Gas',
        'broadband'       => 'Broadband',
        'bus'             => 'Bus',
        'dmt'             => 'DMT (Money Transfer)',
        'bank_payout'     => 'Bank Payout',
        'upi_payout'      => 'UPI Payout',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
