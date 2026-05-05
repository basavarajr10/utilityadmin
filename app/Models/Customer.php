<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Customer extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'customers';

    protected $appends = [
        'profile_photo',
    ];

    protected $dates = [
        'last_login',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const KYC_STATUS_SELECT = [
        'not_submitted' => 'Not Submitted',
        'pending'       => 'Pending',
        'approved'      => 'Approved',
        'rejected'      => 'Rejected',
    ];

    public static $searchable = [
        'profile_photo',
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'wallet_balance',
        'kyc_status',
        'referral_code',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'wallet_balance',
        'kyc_status',
        'is_active',
        'device_token',
        'referral_code',
        'last_login',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function customerKycRequests()
    {
        return $this->hasMany(KycRequest::class, 'customer_id', 'id');
    }

    public function customerMobileRecharges()
    {
        return $this->hasMany(MobileRecharge::class, 'customer_id', 'id');
    }

    public function customerDthRecharges()
    {
        return $this->hasMany(DthRecharge::class, 'customer_id', 'id');
    }

    public function customerBillTransactions()
    {
        return $this->hasMany(BillTransaction::class, 'customer_id', 'id');
    }

    public function customerBusBookings()
    {
        return $this->hasMany(BusBooking::class, 'customer_id', 'id');
    }

    public function customerWalletTopups()
    {
        return $this->hasMany(WalletTopup::class, 'customer_id', 'id');
    }

    public function customerWithdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class, 'customer_id', 'id');
    }

    public function customerTransactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id', 'id');
    }

    public function getProfilePhotoAttribute()
    {
        $file = $this->getMedia('profile_photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getLastLoginAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
