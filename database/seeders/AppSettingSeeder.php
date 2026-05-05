<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Cyrus
            ['key' => 'cyrus_member_id',  'label' => 'Member ID',  'group' => 'cyrus',    'value' => ''],
            ['key' => 'cyrus_pin',         'label' => 'PIN',         'group' => 'cyrus',    'value' => ''],
            ['key' => 'cyrus_api_id',      'label' => 'API ID',      'group' => 'cyrus',    'value' => ''],
            ['key' => 'cyrus_password',    'label' => 'Password',    'group' => 'cyrus',    'value' => ''],
            ['key' => 'cyrus_base_url',    'label' => 'Base URL',    'group' => 'cyrus',    'value' => 'https://cyrusrecharge.in'],

            // Razorpay
            ['key' => 'razorpay_key_id',     'label' => 'Key ID',     'group' => 'razorpay', 'value' => ''],
            ['key' => 'razorpay_key_secret', 'label' => 'Key Secret', 'group' => 'razorpay', 'value' => ''],

            // Firebase
            ['key' => 'firebase_project_id',    'label' => 'Project ID',    'group' => 'firebase', 'value' => ''],
            ['key' => 'firebase_client_email',  'label' => 'Client Email',  'group' => 'firebase', 'value' => ''],
            ['key' => 'firebase_private_key',   'label' => 'Private Key',   'group' => 'firebase', 'value' => ''],

            // MSG91
            ['key' => 'msg91_auth_key',    'label' => 'Auth Key',    'group' => 'msg91', 'value' => ''],
            ['key' => 'msg91_sender_id',   'label' => 'Sender ID',   'group' => 'msg91', 'value' => ''],
            ['key' => 'msg91_template_id', 'label' => 'Template ID', 'group' => 'msg91', 'value' => ''],

            // General
            ['key' => 'maintenance_mode', 'label' => 'Maintenance Mode', 'group' => 'general', 'value' => '0'],
            ['key' => 'referrer_bonus',   'label' => 'Referrer Bonus',   'group' => 'general', 'value' => '50'],
            ['key' => 'referee_bonus',    'label' => 'Referee Bonus',    'group' => 'general', 'value' => '10'],
            ['key' => 'min_topup',        'label' => 'Min Top-up',       'group' => 'general', 'value' => '100'],
            ['key' => 'max_topup',        'label' => 'Max Top-up',       'group' => 'general', 'value' => '10000'],
            ['key' => 'min_withdrawal',   'label' => 'Min Withdrawal',   'group' => 'general', 'value' => '500'],
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
