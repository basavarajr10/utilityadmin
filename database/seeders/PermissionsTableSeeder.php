<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'customer_create',
            ],
            [
                'id'    => 24,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 25,
                'title' => 'customer_show',
            ],
            [
                'id'    => 26,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 27,
                'title' => 'customer_access',
            ],
            [
                'id'    => 28,
                'title' => 'kyc_request_create',
            ],
            [
                'id'    => 29,
                'title' => 'kyc_request_edit',
            ],
            [
                'id'    => 30,
                'title' => 'kyc_request_show',
            ],
            [
                'id'    => 31,
                'title' => 'kyc_request_delete',
            ],
            [
                'id'    => 32,
                'title' => 'kyc_request_access',
            ],
            [
                'id'    => 33,
                'title' => 'mobile_recharge_create',
            ],
            [
                'id'    => 34,
                'title' => 'mobile_recharge_edit',
            ],
            [
                'id'    => 35,
                'title' => 'mobile_recharge_show',
            ],
            [
                'id'    => 36,
                'title' => 'mobile_recharge_delete',
            ],
            [
                'id'    => 37,
                'title' => 'mobile_recharge_access',
            ],
            [
                'id'    => 38,
                'title' => 'dth_recharge_create',
            ],
            [
                'id'    => 39,
                'title' => 'dth_recharge_edit',
            ],
            [
                'id'    => 40,
                'title' => 'dth_recharge_show',
            ],
            [
                'id'    => 41,
                'title' => 'dth_recharge_delete',
            ],
            [
                'id'    => 42,
                'title' => 'dth_recharge_access',
            ],
            [
                'id'    => 43,
                'title' => 'bill_transaction_create',
            ],
            [
                'id'    => 44,
                'title' => 'bill_transaction_edit',
            ],
            [
                'id'    => 45,
                'title' => 'bill_transaction_show',
            ],
            [
                'id'    => 46,
                'title' => 'bill_transaction_delete',
            ],
            [
                'id'    => 47,
                'title' => 'bill_transaction_access',
            ],
            [
                'id'    => 48,
                'title' => 'bus_booking_create',
            ],
            [
                'id'    => 49,
                'title' => 'bus_booking_edit',
            ],
            [
                'id'    => 50,
                'title' => 'bus_booking_show',
            ],
            [
                'id'    => 51,
                'title' => 'bus_booking_delete',
            ],
            [
                'id'    => 52,
                'title' => 'bus_booking_access',
            ],
            [
                'id'    => 53,
                'title' => 'wallet_topup_create',
            ],
            [
                'id'    => 54,
                'title' => 'wallet_topup_edit',
            ],
            [
                'id'    => 55,
                'title' => 'wallet_topup_show',
            ],
            [
                'id'    => 56,
                'title' => 'wallet_topup_delete',
            ],
            [
                'id'    => 57,
                'title' => 'wallet_topup_access',
            ],
            [
                'id'    => 58,
                'title' => 'withdrawal_request_create',
            ],
            [
                'id'    => 59,
                'title' => 'withdrawal_request_edit',
            ],
            [
                'id'    => 60,
                'title' => 'withdrawal_request_show',
            ],
            [
                'id'    => 61,
                'title' => 'withdrawal_request_delete',
            ],
            [
                'id'    => 62,
                'title' => 'withdrawal_request_access',
            ],
            [
                'id'    => 63,
                'title' => 'transaction_create',
            ],
            [
                'id'    => 64,
                'title' => 'transaction_edit',
            ],
            [
                'id'    => 65,
                'title' => 'transaction_show',
            ],
            [
                'id'    => 66,
                'title' => 'transaction_delete',
            ],
            [
                'id'    => 67,
                'title' => 'transaction_access',
            ],
            [
                'id'    => 68,
                'title' => 'commission_setting_create',
            ],
            [
                'id'    => 69,
                'title' => 'commission_setting_edit',
            ],
            [
                'id'    => 70,
                'title' => 'commission_setting_show',
            ],
            [
                'id'    => 71,
                'title' => 'commission_setting_delete',
            ],
            [
                'id'    => 72,
                'title' => 'commission_setting_access',
            ],
            [
                'id'    => 73,
                'title' => 'notification_create',
            ],
            [
                'id'    => 74,
                'title' => 'notification_edit',
            ],
            [
                'id'    => 75,
                'title' => 'notification_show',
            ],
            [
                'id'    => 76,
                'title' => 'notification_delete',
            ],
            [
                'id'    => 77,
                'title' => 'notification_access',
            ],
            [
                'id'    => 78,
                'title' => 'app_setting_create',
            ],
            [
                'id'    => 79,
                'title' => 'app_setting_edit',
            ],
            [
                'id'    => 80,
                'title' => 'app_setting_show',
            ],
            [
                'id'    => 81,
                'title' => 'app_setting_delete',
            ],
            [
                'id'    => 82,
                'title' => 'app_setting_access',
            ],
            [
                'id'    => 83,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
