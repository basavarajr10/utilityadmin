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
            $table->string('selfie_status')->default('pending')->after('selfie');
            $table->string('aadhaar_front_status')->default('pending')->after('aadhaar_front');
            $table->string('aadhaar_back_status')->default('pending')->after('aadhaar_back');
            $table->string('pan_image_status')->default('pending')->after('pan_image');
            $table->text('selfie_note')->nullable()->after('selfie_status');
            $table->text('aadhaar_front_note')->nullable()->after('aadhaar_front_status');
            $table->text('aadhaar_back_note')->nullable()->after('aadhaar_back_status');
            $table->text('pan_image_note')->nullable()->after('pan_image_status');
        });
    }

    public function down(): void
    {
        Schema::table('kyc_requests', function (Blueprint $table) {
            $table->dropColumn([
                'selfie_status', 'aadhaar_front_status', 'aadhaar_back_status', 'pan_image_status',
                'selfie_note', 'aadhaar_front_note', 'aadhaar_back_note', 'pan_image_note',
            ]);
        });
    }
};
