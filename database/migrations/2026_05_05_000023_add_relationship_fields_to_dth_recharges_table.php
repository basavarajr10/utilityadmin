<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDthRechargesTable extends Migration
{
    public function up()
    {
        Schema::table('dth_recharges', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'customer_fk_10811275')->references('id')->on('customers');
        });
    }
}
