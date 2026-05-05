<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('message');
            $table->string('channel');
            $table->string('audience')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('status')->nullable();
            $table->string('sent_count')->nullable();
            $table->string('delivered_count')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
