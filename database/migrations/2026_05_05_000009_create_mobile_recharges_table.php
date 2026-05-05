<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileRechargesTable extends Migration
{
    public function up()
    {
        Schema::create('mobile_recharges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txn');
            $table->string('mobile_number');
            $table->string('operator');
            $table->string('circle')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('amount');
            $table->string('status')->nullable();
            $table->string('api_ref')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
