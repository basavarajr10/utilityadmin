<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDthRechargesTable extends Migration
{
    public function up()
    {
        Schema::create('dth_recharges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txn');
            $table->string('subscriber');
            $table->string('provider');
            $table->string('pack_name')->nullable();
            $table->string('amount');
            $table->string('status')->nullable();
            $table->string('api_ref')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
