<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kyc_requests', function (Blueprint $table) {
            $table->string('aadhaar_front')->nullable()->after('pan_number');
            $table->string('aadhaar_back')->nullable()->after('aadhaar_front');
            $table->string('pan_image')->nullable()->after('aadhaar_back');
            $table->string('selfie')->nullable()->after('pan_image');
        });
    }

    public function down(): void
    {
        Schema::table('kyc_requests', function (Blueprint $table) {
            $table->dropColumn(['aadhaar_front', 'aadhaar_back', 'pan_image', 'selfie']);
        });
    }
};
