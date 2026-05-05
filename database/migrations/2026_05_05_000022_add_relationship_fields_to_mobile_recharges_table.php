<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMobileRechargesTable extends Migration
{
    public function up()
    {
        Schema::table('mobile_recharges', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'customer_fk_10811262')->references('id')->on('customers');
        });
    }
}
