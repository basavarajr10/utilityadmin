<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTopupsTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_topups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txn');
            $table->string('amount');
            $table->string('method')->nullable();
            $table->string('gateway_ref')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
