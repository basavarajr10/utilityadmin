<aside class="main-sidebar">

    {{-- Logo --}}
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Utility App" onerror="this.style.display='none'">
        <div class="brand-text">Utility App <span>Admin Panel</span></div>
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">
                        <i class="fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Users --}}
                <p class="menu-section-label">Users</p>

                @can('customer_access')
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <p>{{ trans('cruds.customer.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('kyc_request_access')
                <li class="nav-item">
                    <a href="{{ route('admin.kyc-requests.index') }}" class="nav-link {{ request()->is('admin/kyc-requests*') ? 'active' : '' }}">
                        <i class="fas fa-id-card"></i>
                        <p>{{ trans('cruds.kycRequest.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Transactions --}}
                <p class="menu-section-label">Transactions</p>

                @can('transaction_access')
                <li class="nav-item">
                    <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}">
                        <i class="fas fa-arrow-right-arrow-left"></i>
                        <p>{{ trans('cruds.transaction.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('wallet_topup_access')
                <li class="nav-item">
                    <a href="{{ route('admin.wallet-topups.index') }}" class="nav-link {{ request()->is('admin/wallet-topups*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i>
                        <p>{{ trans('cruds.walletTopup.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('withdrawal_request_access')
                <li class="nav-item">
                    <a href="{{ route('admin.withdrawal-requests.index') }}" class="nav-link {{ request()->is('admin/withdrawal-requests*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-transfer"></i>
                        <p>{{ trans('cruds.withdrawalRequest.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Services --}}
                <p class="menu-section-label">Services</p>

                @can('mobile_recharge_access')
                <li class="nav-item">
                    <a href="{{ route('admin.mobile-recharges.index') }}" class="nav-link {{ request()->is('admin/mobile-recharges*') ? 'active' : '' }}">
                        <i class="fas fa-mobile-screen"></i>
                        <p>{{ trans('cruds.mobileRecharge.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('dth_recharge_access')
                <li class="nav-item">
                    <a href="{{ route('admin.dth-recharges.index') }}" class="nav-link {{ request()->is('admin/dth-recharges*') ? 'active' : '' }}">
                        <i class="fas fa-satellite-dish"></i>
                        <p>{{ trans('cruds.dthRecharge.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('bill_transaction_access')
                <li class="nav-item">
                    <a href="{{ route('admin.bill-transactions.index') }}" class="nav-link {{ request()->is('admin/bill-transactions*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>{{ trans('cruds.billTransaction.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('bus_booking_access')
                <li class="nav-item">
                    <a href="{{ route('admin.bus-bookings.index') }}" class="nav-link {{ request()->is('admin/bus-bookings*') ? 'active' : '' }}">
                        <i class="fas fa-bus"></i>
                        <p>{{ trans('cruds.busBooking.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Config --}}
                <p class="menu-section-label">Config</p>

                @can('commission_setting_access')
                <li class="nav-item">
                    <a href="{{ route('admin.commission-settings.index') }}" class="nav-link {{ request()->is('admin/commission-settings*') ? 'active' : '' }}">
                        <i class="fas fa-percent"></i>
                        <p>{{ trans('cruds.commissionSetting.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('user_alert_access')
                <li class="nav-item">
                    <a href="{{ route('admin.user-alerts.index') }}" class="nav-link {{ request()->is('admin/user-alerts*') ? 'active' : '' }}">
                        <i class="fas fa-triangle-exclamation"></i>
                        <p>{{ trans('cruds.userAlert.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('notification_access')
                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->is('admin/notifications*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i>
                        <p>{{ trans('cruds.notification.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('app_setting_access')
                <li class="nav-item">
                    <a href="{{ route('admin.app-settings.index') }}" class="nav-link {{ request()->is('admin/app-settings*') ? 'active' : '' }}">
                        <i class="fas fa-gear"></i>
                        <p>{{ trans('cruds.appSetting.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- System --}}
                <p class="menu-section-label">System</p>

                @can('user_management_access')
                <li class="nav-item has-treeview {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') || request()->is('admin/audit-logs*') ? 'menu-open' : '' }}">
                    <a class="nav-link {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') || request()->is('admin/audit-logs*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-users-cog"></i>
                        <p>{{ trans('cruds.userManagement.title') }} <i class="fas fa-angle-left right" style="font-size:0.75rem;margin-left:auto;"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="fas fa-user"></i><p>{{ trans('cruds.user.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase"></i><p>{{ trans('cruds.role.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('permission_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                                <i class="fas fa-unlock-alt"></i><p>{{ trans('cruds.permission.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('audit_log_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.audit-logs.index') }}" class="nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt"></i><p>{{ trans('cruds.auditLog.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('admin.systemCalendar') }}" class="nav-link {{ request()->is('admin/system-calendar*') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        <p>{{ trans('global.systemCalendar') }}</p>
                    </a>
                </li>

                @php($unread = \App\Models\QaTopic::unreadCount())
                <li class="nav-item">
                    <a href="{{ route('admin.messenger.index') }}" class="nav-link {{ request()->is('admin/messenger*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <p>{{ trans('global.messages') }} @if($unread > 0)<strong style="margin-left:4px;">({{ $unread }})</strong>@endif</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    {{-- Logout footer --}}
    <div class="sidebar-footer">
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
            <a class="nav-link {{ request()->is('profile/password*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}" style="display:flex;align-items:center;gap:12px;padding:10px 18px;border-radius:10px;color:rgba(255,255,255,0.65);font-size:0.875rem;font-weight:500;text-decoration:none;transition:all 0.3s;margin-bottom:2px;">
                <i class="fas fa-user-circle" style="width:18px;font-size:1rem;"></i>
                <span>Profile</span>
            </a>
            @endcan
        @endif
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
           style="display:flex;align-items:center;gap:12px;padding:10px 18px;border-radius:10px;color:#f87171;font-size:0.875rem;font-weight:500;text-decoration:none;transition:all 0.3s;"
           onmouseover="this.style.background='rgba(248,113,113,0.1)'" onmouseout="this.style.background='transparent'">
            <i class="fas fa-power-off" style="width:18px;font-size:1rem;"></i>
            <span>{{ trans('global.logout') }}</span>
        </a>
    </div>

</aside>
