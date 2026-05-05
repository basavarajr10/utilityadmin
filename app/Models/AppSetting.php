<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use SoftDeletes;

    public $table = 'app_settings';

    protected $fillable = [
        'key',
        'value',
        'label',
        'group',
    ];
}
