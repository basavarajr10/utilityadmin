<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bus_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('booking');
            $table->string('source');
            $table->string('destination');
            $table->datetime('travel_date');
            $table->string('seats');
            $table->string('passenger_details')->nullable();
            $table->string('amount');
            $table->string('status')->nullable();
            $table->string('api_ref')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
