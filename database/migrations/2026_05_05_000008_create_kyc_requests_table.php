<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('kyc_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('status')->nullable();
            $table->longText('reviewer_note')->nullable();
            $table->datetime('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
