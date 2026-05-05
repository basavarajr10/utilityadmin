<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('bill_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txn');
            $table->string('category')->nullable();
            $table->string('biller_name');
            $table->string('consumer_number');
            $table->string('amount');
            $table->string('status')->nullable();
            $table->string('bbps_ref')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
