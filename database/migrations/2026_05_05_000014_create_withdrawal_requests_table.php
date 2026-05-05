<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('upi')->nullable();
            $table->string('status')->nullable();
            $table->longText('admin_note')->nullable();
            $table->datetime('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
