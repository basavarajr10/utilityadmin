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

class KycRequest extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'kyc_requests';

    public static $searchable = [
        'aadhaar_number',
        'pan_number',
    ];

    protected $appends = [
        'selfie',
        'aadhaar_doc',
        'pan_doc',
    ];

    protected $dates = [
        'reviewed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'pending'  => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    public const DOC_STATUS_SELECT = [
        'pending'  => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    protected $fillable = [
        'customer_id',
        'aadhaar_number',
        'pan_number',
        'aadhaar_front',
        'aadhaar_front_status',
        'aadhaar_front_note',
        'aadhaar_back',
        'aadhaar_back_status',
        'aadhaar_back_note',
        'pan_image',
        'pan_image_status',
        'pan_image_note',
        'selfie',
        'selfie_status',
        'selfie_note',
        'status',
        'reviewer_note',
        'reviewed_at',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getSelfieAttribute()
    {
        $file = $this->getMedia('selfie')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
            return $file;
        }

        $filename = $this->attributes['selfie'] ?? null;
        if ($filename) {
            $url = config('app.url') . '/storage/kyc/' . $filename;
            $obj = new \stdClass();
            $obj->url       = $url;
            $obj->thumbnail = $url;
            $obj->preview   = $url;
            $obj->file_name = $filename;
            return $obj;
        }

        return null;
    }

    public function getAadhaarDocAttribute()
    {
        $files = $this->getMedia('aadhaar_doc');
        if ($files->isNotEmpty()) {
            $files->each(function ($item) {
                $item->url       = $item->getUrl();
                $item->thumbnail = $item->getUrl('thumb');
                $item->preview   = $item->getUrl('preview');
            });
            return $files;
        }

        $results = collect();
        foreach (['aadhaar_front', 'aadhaar_back'] as $col) {
            $filename = $this->attributes[$col] ?? null;
            if ($filename) {
                $url = config('app.url') . '/storage/kyc/' . $filename;
                $obj = new \stdClass();
                $obj->url       = $url;
                $obj->thumbnail = $url;
                $obj->preview   = $url;
                $obj->file_name = $filename;
                $results->push($obj);
            }
        }
        return $results;
    }

    public function getPanDocAttribute()
    {
        $files = $this->getMedia('pan_doc');
        if ($files->isNotEmpty()) {
            $files->each(function ($item) {
                $item->url       = $item->getUrl();
                $item->thumbnail = $item->getUrl('thumb');
                $item->preview   = $item->getUrl('preview');
            });
            return $files;
        }

        $results = collect();
        $filename = $this->attributes['pan_image'] ?? null;
        if ($filename) {
            $url = config('app.url') . '/storage/kyc/' . $filename;
            $obj = new \stdClass();
            $obj->url       = $url;
            $obj->thumbnail = $url;
            $obj->preview   = $url;
            $obj->file_name = $filename;
            $results->push($obj);
        }
        return $results;
    }

    public function getReviewedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setReviewedAtAttribute($value)
    {
        $this->attributes['reviewed_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
