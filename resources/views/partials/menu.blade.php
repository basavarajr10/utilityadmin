<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li>
                    <select class="searchable-field form-control">

                    </select>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('customer_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.customers.index") }}" class="nav-link {{ request()->is("admin/customers") || request()->is("admin/customers/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.customer.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('kyc_request_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.kyc-requests.index") }}" class="nav-link {{ request()->is("admin/kyc-requests") || request()->is("admin/kyc-requests/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-keyboard">

                            </i>
                            <p>
                                {{ trans('cruds.kycRequest.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('mobile_recharge_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.mobile-recharges.index") }}" class="nav-link {{ request()->is("admin/mobile-recharges") || request()->is("admin/mobile-recharges/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-mobile">

                            </i>
                            <p>
                                {{ trans('cruds.mobileRecharge.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('dth_recharge_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.dth-recharges.index") }}" class="nav-link {{ request()->is("admin/dth-recharges") || request()->is("admin/dth-recharges/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-tv">

                            </i>
                            <p>
                                {{ trans('cruds.dthRecharge.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('bill_transaction_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.bill-transactions.index") }}" class="nav-link {{ request()->is("admin/bill-transactions") || request()->is("admin/bill-transactions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-money-bill-alt">

                            </i>
                            <p>
                                {{ trans('cruds.billTransaction.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('bus_booking_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.bus-bookings.index") }}" class="nav-link {{ request()->is("admin/bus-bookings") || request()->is("admin/bus-bookings/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bus-alt">

                            </i>
                            <p>
                                {{ trans('cruds.busBooking.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('wallet_topup_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.wallet-topups.index") }}" class="nav-link {{ request()->is("admin/wallet-topups") || request()->is("admin/wallet-topups/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-wallet">

                            </i>
                            <p>
                                {{ trans('cruds.walletTopup.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('withdrawal_request_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.withdrawal-requests.index") }}" class="nav-link {{ request()->is("admin/withdrawal-requests") || request()->is("admin/withdrawal-requests/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-window-maximize">

                            </i>
                            <p>
                                {{ trans('cruds.withdrawalRequest.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('transaction_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.transactions.index") }}" class="nav-link {{ request()->is("admin/transactions") || request()->is("admin/transactions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-language">

                            </i>
                            <p>
                                {{ trans('cruds.transaction.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('commission_setting_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.commission-settings.index") }}" class="nav-link {{ request()->is("admin/commission-settings") || request()->is("admin/commission-settings/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-american-sign-language-interpreting">

                            </i>
                            <p>
                                {{ trans('cruds.commissionSetting.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('notification_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.notifications.index") }}" class="nav-link {{ request()->is("admin/notifications") || request()->is("admin/notifications/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.notification.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('app_setting_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.app-settings.index") }}" class="nav-link {{ request()->is("admin/app-settings") || request()->is("admin/app-settings/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.appSetting.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.userAlert.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @php($unread = \App\Models\QaTopic::unreadCount())
                    <li class="nav-item">
                        <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                            <i class="fa-fw fa fa-envelope nav-icon">

                            </i>
                            <p>{{ trans('global.messages') }}</p>
                            @if($unread > 0)
                                <strong>( {{ $unread }} )</strong>
                            @endif

                        </a>
                    </li>
                    @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                    <i class="fa-fw fas fa-key nav-icon">
                                    </i>
                                    <p>
                                        {{ trans('global.change_password') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <p>
                                <i class="fas fa-fw fa-sign-out-alt nav-icon">

                                </i>
                                <p>{{ trans('global.logout') }}</p>
                            </p>
                        </a>
                    </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>