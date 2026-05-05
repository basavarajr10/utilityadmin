<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number');
            $table->string('email');
            $table->integer('wallet_balance')->nullable();
            $table->string('kyc_status')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->string('device_token')->nullable();
            $table->string('referral_code')->nullable();
            $table->datetime('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
