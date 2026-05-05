<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_type');
            $table->string('commission_pct');
            $table->string('min_commission');
            $table->string('max_commission');
            $table->string('flat_charge')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
