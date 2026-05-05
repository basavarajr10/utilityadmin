@extends('layouts.admin')

@section('styles')
<style>
    .settings-layout { display: grid; grid-template-columns: 220px 1fr; gap: 24px; align-items: start; }

    .set-nav { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; position: sticky; top: 80px; }
    .set-nav-item { display: flex; align-items: center; gap: 12px; padding: 13px 18px; font-size: 0.85rem; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 1px solid #f1f5f9; transition: all 0.2s; }
    .set-nav-item:last-child { border-bottom: none; }
    .set-nav-item:hover { background: #f8fafc; color: #002970; }
    .set-nav-item.active { background: rgba(0,41,112,0.06); color: #002970; border-left: 3px solid #002970; }
    .set-nav-item i { width: 18px; font-size: 0.9rem; }

    .settings-panel { display: none; }
    .settings-panel.active { display: block; }

    .set-card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 20px; }
    .set-card-head { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #fafcff; display: flex; align-items: center; justify-content: space-between; }
    .set-card-head h3 { font-size: 1rem; font-weight: 800; color: #002970; margin: 0; display: flex; align-items: center; gap: 10px; }
    .set-card-body { padding: 24px; }

    .set-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }
    .set-form-group { margin-bottom: 18px; }
    .set-form-group label { display: block; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 8px; }
    .set-form-group input, .set-form-group select, .set-form-group textarea {
        width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.88rem; font-family: 'Inter', sans-serif; color: #1e293b;
        background: #f8fafc; outline: none; transition: all 0.3s;
    }
    .set-form-group input:focus, .set-form-group select:focus, .set-form-group textarea:focus {
        border-color: #00baf2; background: #fff; box-shadow: 0 0 0 3px rgba(0,186,242,0.1);
    }

    .switch-row { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid #f1f5f9; }
    .switch-row:last-of-type { border-bottom: none; }
    .switch-info h4 { font-size: 0.9rem; font-weight: 700; color: #1e293b; margin: 0 0 3px; }
    .switch-info p { font-size: 0.78rem; color: #64748b; margin: 0; }

    .toggle-switch { position: relative; display: inline-block; width: 48px; height: 26px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #cbd5e1; border-radius: 34px; transition: 0.3s; }
    .toggle-slider:before { position: absolute; content: ''; height: 20px; width: 20px; left: 3px; bottom: 3px; background: #fff; border-radius: 50%; transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    .toggle-switch input:checked + .toggle-slider { background: #00baf2; }
    .toggle-switch input:checked + .toggle-slider:before { transform: translateX(22px); }

    .btn-save-set { padding: 11px 28px; background: #002970; color: #fff; border: none; border-radius: 10px; font-size: 0.88rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; margin-top: 8px; }
    .btn-save-set:hover { background: #0057b8; transform: translateY(-1px); }

    .operator-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px,1fr)); gap: 12px; }
    .op-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.85rem; font-weight: 600; color: #1e293b; }

    .api-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 16px; }
    .api-card-head { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; }
    .api-card-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
    .api-card-title { font-size: 0.9rem; font-weight: 700; color: #002970; }
    .api-card-body { padding: 16px 20px; }
    .api-field { position: relative; margin-bottom: 12px; }
    .api-field label { font-size: 0.72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; display: block; margin-bottom: 6px; }
    .api-field input, .api-field textarea { width: 100%; padding: 9px 40px 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.82rem; font-family: 'Inter', monospace; color: #1e293b; background: #f8fafc; outline: none; }
    .api-field textarea { padding: 9px 12px; resize: vertical; min-height: 80px; }
    .api-field input:focus, .api-field textarea:focus { border-color: #00baf2; background: #fff; }
    .api-eye { position: absolute; right: 12px; bottom: 10px; cursor: pointer; color: #94a3b8; font-size: 0.85rem; }
    .api-status { display: inline-flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 50px; }
    .api-status.connected { background: rgba(16,185,129,0.1); color: #065f46; }
    .api-status.disconnected { background: rgba(239,68,68,0.1); color: #991b1b; }

    .flash-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #065f46; padding: 12px 18px; border-radius: 10px; font-size: 0.88rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="settings-layout">

    {{-- Side Nav --}}
    <div class="set-nav">
        <div class="set-nav-item active" onclick="showPanel('general',this)"><i class="fas fa-sliders"></i> General</div>
        <div class="set-nav-item" onclick="showPanel('wallet',this)"><i class="fas fa-wallet"></i> Wallet & Payouts</div>
        <div class="set-nav-item" onclick="showPanel('operators',this)"><i class="fas fa-tower-broadcast"></i> Operators</div>
        <div class="set-nav-item" onclick="showPanel('integrations',this)"><i class="fas fa-plug"></i> API Integrations</div>
        <div class="set-nav-item" onclick="showPanel('security',this)"><i class="fas fa-shield-halved"></i> Security</div>
    </div>

    <div>

        {{-- General --}}
        <div id="panel-general" class="settings-panel active">
            <form method="POST" action="{{ route('admin.app-settings.update') }}">
                @csrf
                @method('PUT')
                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-wrench" style="color:#f59e0b;"></i> Platform Maintenance</h3></div>
                    <div class="set-card-body">
                        <div class="switch-row">
                            <div class="switch-info"><h4>Maintenance Mode</h4><p>Take the platform offline for all users temporarily.</p></div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="settings[maintenance_mode]" value="1" {{ ($settings->get('general')?->firstWhere('key','maintenance_mode')?->value) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-gift" style="color:#10b981;"></i> Referral System</h3></div>
                    <div class="set-card-body">
                        <div class="set-form-row">
                            <div class="set-form-group">
                                <label>Referrer Bonus (₹)</label>
                                <input type="number" name="settings[referrer_bonus]" value="{{ $settings->get('general')?->firstWhere('key','referrer_bonus')?->value ?? 50 }}" placeholder="Amount credited to inviter">
                            </div>
                            <div class="set-form-group">
                                <label>Referee Bonus (₹)</label>
                                <input type="number" name="settings[referee_bonus]" value="{{ $settings->get('general')?->firstWhere('key','referee_bonus')?->value ?? 10 }}" placeholder="Amount credited to invited user">
                            </div>
                        </div>
                        <button type="submit" class="btn-save-set"><i class="fas fa-save"></i> Save General Settings</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Wallet --}}
        <div id="panel-wallet" class="settings-panel">
            <form method="POST" action="{{ route('admin.app-settings.update') }}">
                @csrf
                @method('PUT')
                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-arrow-up-from-bracket" style="color:#00baf2;"></i> Wallet Load Limits</h3></div>
                    <div class="set-card-body">
                        <div class="set-form-row">
                            <div class="set-form-group">
                                <label>Min Load Amount (₹)</label>
                                <input type="number" name="settings[min_topup]" value="{{ $settings->get('general')?->firstWhere('key','min_topup')?->value ?? 100 }}">
                            </div>
                            <div class="set-form-group">
                                <label>Max Load Amount (₹)</label>
                                <input type="number" name="settings[max_topup]" value="{{ $settings->get('general')?->firstWhere('key','max_topup')?->value ?? 10000 }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-money-bill-transfer" style="color:#7c3aed;"></i> Withdrawal Controls</h3></div>
                    <div class="set-card-body">
                        <div class="set-form-row">
                            <div class="set-form-group">
                                <label>Min Withdrawal (₹)</label>
                                <input type="number" name="settings[min_withdrawal]" value="{{ $settings->get('general')?->firstWhere('key','min_withdrawal')?->value ?? 500 }}">
                            </div>
                            <div class="set-form-group">
                                <label>Max Withdrawal Per Day (₹)</label>
                                <input type="number" name="settings[max_withdrawal]" value="{{ $settings->get('general')?->firstWhere('key','max_withdrawal')?->value ?? 25000 }}">
                            </div>
                        </div>
                        <button type="submit" class="btn-save-set"><i class="fas fa-save"></i> Save Wallet Settings</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Operators --}}
        <div id="panel-operators" class="settings-panel">
            <form method="POST" action="{{ route('admin.app-settings.update') }}">
                @csrf
                @method('PUT')
                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-mobile-screen" style="color:#2563eb;"></i> Mobile Operators</h3></div>
                    <div class="set-card-body">
                        <div class="operator-grid">
                            @foreach(['airtel_prepaid'=>'Airtel Prepaid','jio_prepaid'=>'Jio Prepaid','vi_prepaid'=>'Vi Prepaid','bsnl_prepaid'=>'BSNL Prepaid','airtel_postpaid'=>'Airtel Postpaid','jio_postpaid'=>'Jio Postpaid'] as $key => $label)
                            <div class="op-item">
                                <span>{{ $label }}</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="settings[{{ $key }}]" value="1" {{ ($settings->get('operators')?->firstWhere('key',$key)?->value ?? 1) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-satellite-dish" style="color:#ea580c;"></i> DTH Providers</h3></div>
                    <div class="set-card-body">
                        <div class="operator-grid">
                            @foreach(['tata_play'=>'Tata Play','dish_tv'=>'Dish TV','sun_direct'=>'Sun Direct','airtel_dth'=>'Airtel DTH','dd_free_dish'=>'DD Free Dish'] as $key => $label)
                            <div class="op-item">
                                <span>{{ $label }}</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="settings[{{ $key }}]" value="1" {{ ($settings->get('operators')?->firstWhere('key',$key)?->value ?? 1) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-save-set"><i class="fas fa-save"></i> Save Operator Settings</button>
            </form>
        </div>

        {{-- Integrations --}}
        <div id="panel-integrations" class="settings-panel">
            <form method="POST" action="{{ route('admin.app-settings.update') }}">
                @csrf
                @method('PUT')

                {{-- Razorpay --}}
                <div class="api-card">
                    <div class="api-card-head">
                        <div class="api-card-icon" style="background:#ede9fe;"><i class="fas fa-credit-card" style="color:#7c3aed;"></i></div>
                        <div><div class="api-card-title">Razorpay (Payments)</div></div>
                        <span class="api-status {{ $settings->get('razorpay')?->firstWhere('key','razorpay_key_id')?->value ? 'connected' : 'disconnected' }}" style="margin-left:auto;">
                            <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                            {{ $settings->get('razorpay')?->firstWhere('key','razorpay_key_id')?->value ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                    <div class="api-card-body">
                        <div class="set-form-row">
                            <div class="api-field">
                                <label>Key ID</label>
                                <input type="text" name="settings[razorpay_key_id]" value="{{ $settings->get('razorpay')?->firstWhere('key','razorpay_key_id')?->value ?? '' }}">
                                <span class="api-eye"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="api-field">
                                <label>Key Secret</label>
                                <input type="password" name="settings[razorpay_key_secret]" value="{{ $settings->get('razorpay')?->firstWhere('key','razorpay_key_secret')?->value ?? '' }}">
                                <span class="api-eye"><i class="fas fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cyrus Recharge --}}
                <div class="api-card">
                    <div class="api-card-head">
                        <div class="api-card-icon" style="background:#dbeafe;"><i class="fas fa-mobile-screen" style="color:#2563eb;"></i></div>
                        <div><div class="api-card-title">Cyrus Recharge</div></div>
                        <span class="api-status {{ $settings->get('cyrus')?->firstWhere('key','cyrus_member_id')?->value ? 'connected' : 'disconnected' }}" style="margin-left:auto;">
                            <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                            {{ $settings->get('cyrus')?->firstWhere('key','cyrus_member_id')?->value ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                    <div class="api-card-body">
                        <div class="set-form-row">
                            <div class="api-field">
                                <label>Member ID</label>
                                <input type="text" name="settings[cyrus_member_id]" value="{{ $settings->get('cyrus')?->firstWhere('key','cyrus_member_id')?->value ?? '' }}">
                            </div>
                            <div class="api-field">
                                <label>PIN</label>
                                <input type="password" name="settings[cyrus_pin]" value="{{ $settings->get('cyrus')?->firstWhere('key','cyrus_pin')?->value ?? '' }}">
                                <span class="api-eye"><i class="fas fa-eye"></i></span>
                            </div>
                        </div>
                        <div class="set-form-row">
                            <div class="api-field">
                                <label>API ID</label>
                                <input type="text" name="settings[cyrus_api_id]" value="{{ $settings->get('cyrus')?->firstWhere('key','cyrus_api_id')?->value ?? '' }}">
                            </div>
                            <div class="api-field">
                                <label>Password</label>
                                <input type="password" name="settings[cyrus_password]" value="{{ $settings->get('cyrus')?->firstWhere('key','cyrus_password')?->value ?? '' }}">
                                <span class="api-eye"><i class="fas fa-eye"></i></span>
                            </div>
                        </div>
                        <div class="api-field">
                            <label>Base URL</label>
                            <input type="text" name="settings[cyrus_base_url]" value="{{ $settings->get('cyrus')?->firstWhere('key','cyrus_base_url')?->value ?? 'https://cyrusrecharge.in' }}">
                        </div>
                    </div>
                </div>

                {{-- Firebase --}}
                <div class="api-card">
                    <div class="api-card-head">
                        <div class="api-card-icon" style="background:#fff7ed;"><i class="fas fa-bell" style="color:#ea580c;"></i></div>
                        <div><div class="api-card-title">Firebase (Push Notifications)</div></div>
                        <span class="api-status {{ $settings->get('firebase')?->firstWhere('key','firebase_project_id')?->value ? 'connected' : 'disconnected' }}" style="margin-left:auto;">
                            <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                            {{ $settings->get('firebase')?->firstWhere('key','firebase_project_id')?->value ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                    <div class="api-card-body">
                        <div class="set-form-row">
                            <div class="api-field">
                                <label>Project ID</label>
                                <input type="text" name="settings[firebase_project_id]" value="{{ $settings->get('firebase')?->firstWhere('key','firebase_project_id')?->value ?? '' }}">
                            </div>
                            <div class="api-field">
                                <label>Client Email</label>
                                <input type="text" name="settings[firebase_client_email]" value="{{ $settings->get('firebase')?->firstWhere('key','firebase_client_email')?->value ?? '' }}">
                            </div>
                        </div>
                        <div class="api-field">
                            <label>Private Key</label>
                            <textarea name="settings[firebase_private_key]" rows="4" placeholder="-----BEGIN PRIVATE KEY-----">{{ $settings->get('firebase')?->firstWhere('key','firebase_private_key')?->value ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- MSG91 --}}
                <div class="api-card">
                    <div class="api-card-head">
                        <div class="api-card-icon" style="background:#ffedd5;"><i class="fas fa-comment-dots" style="color:#ea580c;"></i></div>
                        <div><div class="api-card-title">MSG91 (OTP / SMS)</div></div>
                        <span class="api-status {{ $settings->get('msg91')?->firstWhere('key','msg91_auth_key')?->value ? 'connected' : 'disconnected' }}" style="margin-left:auto;">
                            <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                            {{ $settings->get('msg91')?->firstWhere('key','msg91_auth_key')?->value ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                    <div class="api-card-body">
                        <div class="set-form-row">
                            <div class="api-field">
                                <label>Auth Key</label>
                                <input type="text" name="settings[msg91_auth_key]" value="{{ $settings->get('msg91')?->firstWhere('key','msg91_auth_key')?->value ?? '' }}" placeholder="Enter MSG91 auth key">
                                <span class="api-eye"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="api-field">
                                <label>Sender ID</label>
                                <input type="text" name="settings[msg91_sender_id]" value="{{ $settings->get('msg91')?->firstWhere('key','msg91_sender_id')?->value ?? '' }}" placeholder="UTILTY">
                            </div>
                        </div>
                        <div class="api-field">
                            <label>Template ID</label>
                            <input type="text" name="settings[msg91_template_id]" value="{{ $settings->get('msg91')?->firstWhere('key','msg91_template_id')?->value ?? '' }}" placeholder="OTP template ID">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-save-set"><i class="fas fa-save"></i> Save API Settings</button>
            </form>
        </div>

        {{-- Security --}}
        <div id="panel-security" class="settings-panel">
            <form method="POST" action="{{ route('admin.app-settings.update') }}">
                @csrf
                @method('PUT')
                <div class="set-card">
                    <div class="set-card-head"><h3><i class="fas fa-shield-halved" style="color:#002970;"></i> Security Protocol</h3></div>
                    <div class="set-card-body">
                        <div class="switch-row">
                            <div class="switch-info"><h4>Two-Factor Authentication</h4><p>Require OTP verification for admin login.</p></div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="settings[two_factor_auth]" value="1" {{ ($settings->get('security')?->firstWhere('key','two_factor_auth')?->value) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="switch-info"><h4>Session Timeout</h4><p>Auto logout admin after inactivity.</p></div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="settings[session_timeout_enabled]" value="1" {{ ($settings->get('security')?->firstWhere('key','session_timeout_enabled')?->value) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="set-form-row" style="margin-top:16px;">
                            <div class="set-form-group">
                                <label>Session Timeout (minutes)</label>
                                <input type="number" name="settings[session_timeout]" value="{{ $settings->get('security')?->firstWhere('key','session_timeout')?->value ?? 30 }}">
                            </div>
                            <div class="set-form-group">
                                <label>Max Login Attempts</label>
                                <input type="number" name="settings[max_login_attempts]" value="{{ $settings->get('security')?->firstWhere('key','max_login_attempts')?->value ?? 5 }}">
                            </div>
                        </div>
                        <button type="submit" class="btn-save-set"><i class="fas fa-save"></i> Save Security Settings</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
function showPanel(id, el) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.set-nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('panel-' + id).classList.add('active');
    el.classList.add('active');
}

$(document).on('click', '.api-eye', function() {
    var input = $(this).siblings('input');
    input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    $(this).find('i').toggleClass('fa-eye fa-eye-slash');
});
</script>
@endsection
