<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>

    {{-- Core deps --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #002970;
            --primary-dark: #001a4d;
            --accent: #00baf2;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --sidebar-width: 260px;
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --bg: #F8FAFC;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif !important;
            background: var(--bg) !important;
            color: var(--text-dark) !important;
            margin: 0;
        }

        /* ── Sidebar ── */
        .main-sidebar {
            position: fixed !important;
            left: 0; top: 0;
            width: var(--sidebar-width) !important;
            height: 100vh !important;
            min-height: 100vh !important;
            background: var(--primary) !important;
            border: none !important;
            box-shadow: none !important;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
        }

        .brand-link {
            padding: 20px 18px !important;
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            text-decoration: none !important;
            background: transparent !important;
        }

        .brand-link img {
            height: 36px;
            object-fit: contain;
            background: white;
            border-radius: 6px;
            padding: 2px;
        }

        .brand-text {
            font-size: 0.9rem !important;
            font-weight: 800 !important;
            color: var(--white) !important;
            line-height: 1.2 !important;
        }

        .brand-text span {
            font-size: 0.68rem;
            color: var(--accent);
            font-weight: 500;
            display: block;
        }

        .sidebar {
            padding: 10px !important;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background: transparent !important;
        }

        .sidebar::-webkit-scrollbar { width: 0; }

        .menu-section-label {
            display: block !important;
            padding: 16px 18px 6px !important;
            font-size: 0.62rem !important;
            text-transform: uppercase !important;
            letter-spacing: 1.5px !important;
            color: rgba(255,255,255,0.35) !important;
            font-weight: 800 !important;
            font-family: 'Inter', sans-serif !important;
            line-height: 1 !important;
        }

        .nav-sidebar .nav-item { margin-bottom: 2px; display: block !important; }

        .nav-sidebar .nav-link {
            display: flex !important;
            align-items: center !important;
            padding: 10px 18px !important;
            color: rgba(255,255,255,0.65) !important;
            border-radius: 10px !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            transition: var(--transition) !important;
            gap: 12px !important;
            text-decoration: none !important;
            background: transparent !important;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08) !important;
            color: var(--white) !important;
        }

        .nav-sidebar .nav-link.active {
            background: var(--accent) !important;
            color: var(--primary) !important;
            font-weight: 700 !important;
        }

        .nav-sidebar .nav-link.active i { color: var(--primary) !important; }

        .nav-sidebar .nav-link i {
            width: 18px !important;
            font-size: 1rem !important;
            margin-right: 0 !important;
            flex-shrink: 0;
        }

        .nav-sidebar .nav-link p {
            margin: 0 !important;
            flex: 1;
            line-height: 1 !important;
        }

        /* Treeview sub-menu */
        .nav-treeview {
            display: none;
            padding-left: 10px !important;
        }

        .menu-open > .nav-treeview {
            display: block !important;
        }

        .nav-treeview .nav-item {
            display: block !important;
            width: 100% !important;
            float: none !important;
        }

        .nav-treeview .nav-link {
            font-size: 0.82rem !important;
            padding: 8px 14px !important;
            width: 100% !important;
            display: flex !important;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 10px;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }

        .sidebar-footer .nav-sidebar { padding: 0 !important; }

        .sidebar-footer .nav-link {
            color: rgba(255,255,255,0.65) !important;
        }

        .sidebar-footer .nav-link:hover {
            background: rgba(255,255,255,0.08) !important;
            color: var(--white) !important;
        }

        .sidebar-footer .nav-link.logout-link,
        .sidebar-footer .logout-link { color: #f87171 !important; }

        .sidebar-footer .logout-link:hover {
            background: rgba(248,113,113,0.1) !important;
            color: #f87171 !important;
        }

        /* ── Top Navbar ── */
        .main-header {
            position: sticky !important;
            top: 0 !important;
            left: var(--sidebar-width) !important;
            right: 0 !important;
            z-index: 999 !important;
            background: #fff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 0 32px !important;
            height: 64px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            box-shadow: none !important;
            margin-left: var(--sidebar-width) !important;
        }

        .navbar-nav { display: flex; align-items: center; flex-direction: row; }

        .nav-page-title h1 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            line-height: 1;
        }

        .nav-page-title p {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .nav-right-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-icon-btn {
            width: 38px; height: 38px;
            background: var(--bg);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            border: 1px solid #e2e8f0;
            position: relative;
            text-decoration: none;
        }

        .nav-icon-btn:hover { color: var(--primary); border-color: var(--primary); }

        .notif-dot {
            width: 8px; height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 6px; right: 6px;
        }

        .user-block {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px;
            background: var(--bg);
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            position: relative;
        }

        .user-avatar {
            width: 32px; height: 32px;
            background: var(--primary);
            color: var(--white);
            border-radius: 50%;
            display: grid; place-items: center;
            font-weight: 800; font-size: 0.72rem;
            flex-shrink: 0;
        }

        .user-info { line-height: 1.3; }
        .user-info strong { font-size: 0.8rem; font-weight: 700; color: var(--text-dark); display: block; }
        .user-info span { font-size: 0.68rem; color: var(--text-muted); }

        .user-dropdown {
            position: absolute; top: calc(100% + 8px); right: 0;
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 12px; box-shadow: 0 12px 32px rgba(0,0,0,0.1);
            min-width: 180px; padding: 6px;
            display: none; z-index: 9999;
        }

        .user-block:hover .user-dropdown { display: block; }

        .user-dropdown a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600; color: var(--text-dark);
            text-decoration: none; transition: background 0.2s;
        }

        .user-dropdown a:hover { background: var(--bg); }
        .user-dropdown a.logout-link { color: #ef4444; }
        .user-dropdown a.logout-link:hover { background: rgba(239,68,68,0.06); }
        .user-dropdown hr { margin: 4px 8px; border-color: #f1f5f9; }

        /* ── Content Wrapper ── */
        .content-wrapper {
            margin-left: var(--sidebar-width) !important;
            background: var(--bg) !important;
            min-height: calc(100vh - 64px) !important;
            padding: 28px 32px !important;
        }

        /* ── Footer ── */
        .main-footer {
            margin-left: var(--sidebar-width) !important;
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            padding: 14px 32px !important;
            font-size: 0.8rem !important;
            color: var(--text-muted) !important;
        }

        /* ── Alert / Flash messages ── */
        .alert-success {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.3);
            color: #065f46;
            border-radius: 10px;
            font-size: 0.85rem;
        }

        .alert-danger {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            color: #991b1b;
            border-radius: 10px;
            font-size: 0.85rem;
        }

        /* ── Create / Edit forms: 2-column grid ── */
        .card-body form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 24px;
        }

        /* Full-width: submit row, dropzone, textarea, checkbox, select2 multi */
        .card-body form .form-group:last-child,
        .card-body form .form-group:has(.dropzone),
        .card-body form .form-group:has(textarea),
        .card-body form .form-group:has(.form-check),
        .card-body form .form-group:has(.select2-container--open),
        .card-body form .form-group-full {
            grid-column: 1 / -1;
        }

        /* Input styling */
        .card-body .form-control {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.85rem !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 9px 12px !important;
            color: #1e293b !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .card-body .form-control:focus {
            border-color: #00baf2 !important;
            box-shadow: 0 0 0 3px rgba(0,186,242,0.1) !important;
            outline: none !important;
        }

        .card-body .form-control.is-invalid {
            border-color: #ef4444 !important;
        }

        .card-body label {
            font-size: 0.78rem !important;
            font-weight: 700 !important;
            color: #374151 !important;
            margin-bottom: 5px !important;
            display: block;
        }

        .card-body label.required::after {
            content: ' *';
            color: #ef4444;
        }

        .card-body .help-block {
            font-size: 0.72rem !important;
            color: #94a3b8 !important;
        }

        .card-body .text-danger {
            font-size: 0.75rem !important;
        }

        /* ── Toggle Switch (replaces checkbox) ── */
        .form-check { display: flex; align-items: center; gap: 12px; padding: 0 !important; }

        .form-check-input[type="checkbox"] {
            appearance: none !important;
            -webkit-appearance: none !important;
            width: 44px !important;
            height: 24px !important;
            background: #cbd5e1 !important;
            border-radius: 34px !important;
            position: relative !important;
            cursor: pointer !important;
            transition: background 0.3s !important;
            flex-shrink: 0 !important;
            border: none !important;
            outline: none !important;
            margin: 0 !important;
        }

        .form-check-input[type="checkbox"]::before {
            content: '' !important;
            position: absolute !important;
            width: 18px !important;
            height: 18px !important;
            background: #fff !important;
            border-radius: 50% !important;
            top: 3px !important;
            left: 3px !important;
            transition: transform 0.3s !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
        }

        .form-check-input[type="checkbox"]:checked {
            background: #00baf2 !important;
        }

        .form-check-input[type="checkbox"]:checked::before {
            transform: translateX(20px) !important;
        }

        .form-check-label {
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            cursor: pointer !important;
            margin: 0 !important;
        }

        /* Save button */
        .card-body form .btn[type="submit"],
        .card-body form button[type="submit"] {
            background: linear-gradient(135deg, #002970, #0057b8) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 28px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
        }

        .card-body form .btn[type="submit"]:hover,
        .card-body form button[type="submit"]:hover {
            opacity: 0.9 !important;
        }

        /* ── Data / Content Cards ── */
        .card {
            border-radius: var(--radius) !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
        }

        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            font-weight: 700 !important;
            color: var(--primary) !important;
            font-family: 'Inter', sans-serif !important;
            border-radius: var(--radius) var(--radius) 0 0 !important;
        }

        /* ── Tables ── */
        table th {
            background: #f8fafc;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        table td { font-size: 0.85rem; font-weight: 500; }

        /* Badge */
        .badge { font-family: 'Inter', sans-serif !important; }

        /* ── DataTable buttons ── */
        .dataTables_wrapper .btn {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            border: none !important;
            line-height: 1.4 !important;
        }

        .dataTables_wrapper .btn-primary   { background: #002970 !important; color: #fff !important; border: none !important; }
        .dataTables_wrapper .btn-primary:hover { background: #001a4d !important; color: #fff !important; }
        .dataTables_wrapper .btn-default   { background: #f1f5f9 !important; color: #1e293b !important; border: 1px solid #e2e8f0 !important; }
        .dataTables_wrapper .btn-default:hover { background: #e2e8f0 !important; }
        .dataTables_wrapper .btn-danger    { background: #ef4444 !important; color: #fff !important; border: none !important; }
        .dataTables_wrapper .btn-danger:hover  { background: #dc2626 !important; }

        .dt-buttons { display: flex !important; flex-wrap: wrap !important; gap: 5px !important; }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.8rem !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
            outline: none !important;
            color: #1e293b !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #00baf2 !important;
            box-shadow: 0 0 0 3px rgba(0,186,242,0.1) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.8rem !important;
            color: #64748b !important;
        }

        .paginate_button.current, .paginate_button.current:hover {
            background: #002970 !important;
            border-color: #002970 !important;
            color: #fff !important;
        }

        /* Add button in card header */
        .card-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .btn-add-record {
            background: linear-gradient(135deg, #002970, #0057b8) !important;
            color: #fff !important;
            padding: 7px 16px !important;
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            font-family: 'Inter', sans-serif !important;
            border: none !important;
            white-space: nowrap;
        }

        .btn-add-record:hover { color: #fff !important; opacity: 0.9; }

        /* Buttons */
        .btn-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
        }

        .btn-primary:hover {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        /* Action buttons in datatables — uniform size */
        .btn-xs {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 5px 0 !important;
            border-radius: 6px !important;
            width: 80px !important;
            display: inline-block !important;
            text-align: center !important;
            line-height: 1.4 !important;
            border: none !important;
            cursor: pointer !important;
        }
        .btn-xs.btn-primary { background: #002970 !important; color: #fff !important; }
        .btn-xs.btn-primary:hover { background: #001a4d !important; color: #fff !important; }
        .btn-xs.btn-info    { background: #0ea5e9 !important; color: #fff !important; }
        .btn-xs.btn-info:hover { background: #0284c7 !important; color: #fff !important; }
        .btn-xs.btn-danger  { background: #ef4444 !important; color: #fff !important; }
        .btn-xs.btn-danger:hover { background: #dc2626 !important; color: #fff !important; }

        /* Sidebar collapse (AdminLTE pushmenu) */
        .sidebar-collapse .main-sidebar { width: 70px !important; }
        .sidebar-collapse .brand-text,
        .sidebar-collapse .nav-link p,
        .sidebar-collapse .menu-section-label { display: none !important; }
        .sidebar-collapse .main-header,
        .sidebar-collapse .content-wrapper,
        .sidebar-collapse .main-footer { margin-left: 70px !important; }
        .sidebar-collapse .brand-link { justify-content: center; }
        .sidebar-collapse .nav-link { justify-content: center; padding: 10px !important; }
        .sidebar-collapse .nav-link i { margin: 0 !important; }

        /* Wrapper */
        .wrapper { display: block !important; }
    </style>

    @yield('styles')
</head>

<body class="sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- ── Top Navbar ── --}}
    <nav class="main-header navbar">
        <div class="nav-page-title">
            @php
                $segments = array_values(array_filter(explode('/', request()->path())));
                $last = end($segments);
                if (in_array($last, ['create', 'edit', 'show'])) {
                    // find the nearest non-numeric, non-action parent segment
                    $module = '';
                    foreach (array_reverse($segments) as $seg) {
                        if (!in_array($seg, ['create','edit','show']) && !is_numeric($seg) && $seg !== 'admin') {
                            $module = ucwords(str_replace(['-','_'], ' ', $seg));
                            break;
                        }
                    }
                    $pageTitle = ucwords($last) . ' ' . $module;
                } else {
                    $pageTitle = ucwords(str_replace(['-','_'], ' ', $last));
                }
            @endphp
            <h1>@yield('page-title', $pageTitle)</h1>
            <p>{{ date('l, d F Y') }}</p>
        </div>

        <div class="nav-right-group">
            {{-- Notifications --}}
            @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
            <div class="nav-icon-btn notifications-menu" data-toggle="dropdown" style="cursor:pointer;">
                <i class="fas fa-bell"></i>
                @if($alertsCount > 0)
                    <span class="notif-dot"></span>
                @endif
                <div class="dropdown-menu dropdown-menu-right" style="border-radius:12px;border:1px solid #e2e8f0;box-shadow:0 12px 32px rgba(0,0,0,0.1);min-width:280px;padding:8px;">
                    @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(10)->orderBy('created_at','ASC')->get()->reverse()) > 0)
                        @foreach($alerts as $alert)
                            <a class="dropdown-item" href="{{ $alert->alert_link ?: '#' }}" style="border-radius:8px;font-size:0.82rem;padding:9px 14px;" target="_blank" rel="noopener">
                                @if($alert->pivot->read === 0)<strong>@endif
                                {{ $alert->alert_text }}
                                @if($alert->pivot->read === 0)</strong>@endif
                            </a>
                        @endforeach
                    @else
                        <p style="text-align:center;padding:14px;color:var(--text-muted);font-size:0.82rem;margin:0;">{{ trans('global.no_alerts') }}</p>
                    @endif
                </div>
            </div>

            {{-- User block --}}
            <div class="user-block">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                <div class="user-info">
                    <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                    <span>{{ auth()->user()->roles->first()->title ?? 'Administrator' }}</span>
                </div>
                <div class="user-dropdown">
                    @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                            <a href="{{ route('profile.password.edit') }}"><i class="fas fa-key"></i> Change Password</a>
                        @endcan
                    @endif
                    <hr>
                    <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="fas fa-power-off"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Sidebar ── --}}
    @include('partials.menu')

    {{-- ── Content ── --}}
    <div class="content-wrapper">
        @if(session('message'))
            <div class="alert alert-success mb-4" role="alert">{{ session('message') }}</div>
        @endif
        @if($errors->count() > 0)
            <div class="alert alert-danger mb-4">
                <ul class="list-unstyled mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} Utility App.</strong> All rights reserved.
        <span class="float-right">v3.0.0</span>
    </footer>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>

{{-- AdminLTE treeview / pushmenu (jQuery must load first) --}}
<script>
$(function() {
    // Treeview toggle
    $('[data-widget="treeview"]').each(function() {
        var $tree = $(this);
        $tree.on('click', '.nav-link', function(e) {
            var $link = $(this);
            var $sub = $link.next('.nav-treeview');
            if (!$sub.length) return;
            e.preventDefault();
            var $parent = $link.closest('.nav-item');
            if ($parent.hasClass('menu-open')) {
                $sub.slideUp(250, function() { $parent.removeClass('menu-open'); });
            } else {
                // close siblings
                $tree.find('.menu-open > .nav-treeview').slideUp(250);
                $tree.find('.menu-open').removeClass('menu-open');
                $sub.slideDown(250, function() { $parent.addClass('menu-open'); });
            }
        });
    });
});
</script>

<script>
$(function () {
    // Mark alerts read
    $(".notifications-menu").on('click', function () {
        $('.notif-dot').hide();
        $.get('/admin/user-alerts/read');
    });

    // DataTables config
    let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
    let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
    let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
    let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
    let printButtonTrans = '{{ trans('global.datatables.print') }}'
    let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
    let selectAllButtonTrans = '{{ trans('global.select_all') }}'
    let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

    let languages = { 'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json' };

    $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
    $.extend(true, $.fn.dataTable.defaults, {
        language: { url: languages['{{ app()->getLocale() }}'] },
        columnDefs: [
            { orderable: false, className: 'select-checkbox', targets: 0 },
            { orderable: false, searchable: false, targets: -1 }
        ],
        select: { style: 'multi+shift', selector: 'td:first-child' },
        order: [], scrollX: true, pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [
            { extend: 'selectAll', className: 'btn-primary', text: selectAllButtonTrans, exportOptions: { columns: ':visible' }, action: function(e, dt) { e.preventDefault(); dt.rows().deselect(); dt.rows({ search: 'applied' }).select(); } },
            { extend: 'selectNone', className: 'btn-primary', text: selectNoneButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'copy', className: 'btn-default', text: copyButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'csv', className: 'btn-default', text: csvButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'excel', className: 'btn-default', text: excelButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'pdf', className: 'btn-default', text: pdfButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'print', className: 'btn-default', text: printButtonTrans, exportOptions: { columns: ':visible' } },
            { extend: 'colvis', className: 'btn-default', text: colvisButtonTrans, exportOptions: { columns: ':visible' } }
        ]
    });
    $.fn.dataTable.ext.classes.sPageButton = '';

    // Global search (select2)
    $('.searchable-field').select2({
        minimumInputLength: 3,
        ajax: {
            url: '{{ route("admin.globalSearch") }}',
            dataType: 'json', type: 'GET', delay: 200,
            data: function(term) { return { search: term }; },
            results: function(data) { return { data }; }
        },
        escapeMarkup: function(markup) { return markup; },
        templateResult: formatItem,
        templateSelection: formatItemSelection,
        placeholder: '{{ trans('global.search') }}...',
        language: {
            inputTooShort: function(args) { return '{{ trans('global.search_input_too_short') }}'.replace(':count', args.minimum - args.input.length); },
            errorLoading: function() { return '{{ trans('global.results_could_not_be_loaded') }}'; },
            searching: function() { return '{{ trans('global.searching') }}'; },
            noResults: function() { return '{{ trans('global.no_results') }}'; }
        }
    });

    function formatItem(item) {
        if (item.loading) return '{{ trans('global.searching') }}...';
        var markup = "<div class='searchable-link' href='" + item.url + "'>";
        markup += "<div class='searchable-title'>" + item.model + "</div>";
        $.each(item.fields, function(key, field) {
            markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
        });
        markup += "</div>";
        return markup;
    }

    function formatItemSelection(item) {
        if (!item.model) return '{{ trans('global.search') }}...';
        return item.model;
    }

    $(document).delegate('.searchable-link', 'click', function() {
        window.location = $(this).attr('href');
    });
});
</script>

@yield('scripts')
</body>
</html>
