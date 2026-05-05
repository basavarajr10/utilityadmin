<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Customers
    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');
    Route::post('customers/media', 'CustomersController@storeMedia')->name('customers.storeMedia');
    Route::post('customers/ckmedia', 'CustomersController@storeCKEditorImages')->name('customers.storeCKEditorImages');
    Route::resource('customers', 'CustomersController');

    // Kyc Requests
    Route::delete('kyc-requests/destroy', 'KycRequestsController@massDestroy')->name('kyc-requests.massDestroy');
    Route::post('kyc-requests/media', 'KycRequestsController@storeMedia')->name('kyc-requests.storeMedia');
    Route::post('kyc-requests/ckmedia', 'KycRequestsController@storeCKEditorImages')->name('kyc-requests.storeCKEditorImages');
    Route::resource('kyc-requests', 'KycRequestsController');

    // Mobile Recharges
    Route::delete('mobile-recharges/destroy', 'MobileRechargesController@massDestroy')->name('mobile-recharges.massDestroy');
    Route::resource('mobile-recharges', 'MobileRechargesController');

    // Dth Recharges
    Route::delete('dth-recharges/destroy', 'DthRechargesController@massDestroy')->name('dth-recharges.massDestroy');
    Route::resource('dth-recharges', 'DthRechargesController');

    // Bill Transactions
    Route::delete('bill-transactions/destroy', 'BillTransactionsController@massDestroy')->name('bill-transactions.massDestroy');
    Route::resource('bill-transactions', 'BillTransactionsController');

    // Bus Bookings
    Route::delete('bus-bookings/destroy', 'BusBookingsController@massDestroy')->name('bus-bookings.massDestroy');
    Route::resource('bus-bookings', 'BusBookingsController');

    // Wallet Topups
    Route::delete('wallet-topups/destroy', 'WalletTopupsController@massDestroy')->name('wallet-topups.massDestroy');
    Route::resource('wallet-topups', 'WalletTopupsController');

    // Withdrawal Requests
    Route::delete('withdrawal-requests/destroy', 'WithdrawalRequestsController@massDestroy')->name('withdrawal-requests.massDestroy');
    Route::post('withdrawal-requests/media', 'WithdrawalRequestsController@storeMedia')->name('withdrawal-requests.storeMedia');
    Route::post('withdrawal-requests/ckmedia', 'WithdrawalRequestsController@storeCKEditorImages')->name('withdrawal-requests.storeCKEditorImages');
    Route::resource('withdrawal-requests', 'WithdrawalRequestsController');

    // Transactions
    Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionsController');

    // Commission Settings
    Route::put('commission-settings/bulk-update', 'CommissionSettingsController@bulkUpdate')->name('commission-settings.bulk-update');
    Route::delete('commission-settings/destroy', 'CommissionSettingsController@massDestroy')->name('commission-settings.massDestroy');
    Route::resource('commission-settings', 'CommissionSettingsController');

    // Notifications
    Route::delete('notifications/destroy', 'NotificationsController@massDestroy')->name('notifications.massDestroy');
    Route::resource('notifications', 'NotificationsController');

    // App Settings
    Route::put('app-settings', 'AppSettingsController@update')->name('app-settings.update');
    Route::resource('app-settings', 'AppSettingsController', ['only' => ['index']]);

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
