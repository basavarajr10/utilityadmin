@extends('layouts.admin')

@section('styles')
<style>
    .stats-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:24px; }
    .stat-card-h { background:#fff; padding:20px 22px; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.03); display:flex; align-items:center; gap:16px; transition:all 0.3s; }
    .stat-card-h:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,0.07); }
    .stat-icon-h { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .stat-title-h { font-size:0.7rem; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:4px; }
    .stat-value-h { font-size:1.4rem; font-weight:800; color:#002970; }
    .stat-sub-h { font-size:0.7rem; color:#64748b; margin-top:2px; }

    .info-banner { background:linear-gradient(135deg,rgba(0,41,112,0.05),rgba(0,186,242,0.06)); border:1px solid rgba(0,186,242,0.2); border-radius:12px; padding:14px 20px; display:flex; align-items:center; gap:12px; margin-bottom:24px; }
    .info-banner i { color:#00baf2; font-size:1rem; }
    .info-banner span { font-size:0.84rem; color:#002970; font-weight:500; }

    .commission-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
    .commission-card { background:#fff; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.03); overflow:hidden; }
    .commission-card-head { padding:18px 22px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:12px; }
    .commission-card-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0; }
    .commission-card-title { font-size:0.95rem; font-weight:700; color:#002970; }
    .commission-card-sub { font-size:0.72rem; color:#64748b; margin-top:2px; }
    .commission-card-body { padding:20px 22px; }
    .field-row { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:16px; }
    .field-group label { font-size:0.7rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px; display:block; margin-bottom:6px; }
    .field-input-wrap { position:relative; }
    .field-input-wrap input { width:100%; padding:10px 36px 10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; font-weight:700; font-family:'Inter',sans-serif; color:#002970; background:#f8fafc; outline:none; transition:all 0.3s; }
    .field-input-wrap input:focus { border-color:#00baf2; background:#fff; box-shadow:0 0 0 3px rgba(0,186,242,0.1); }
    .field-suffix { position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:0.8rem; font-weight:700; color:#64748b; }
    .save-row { display:flex; justify-content:space-between; align-items:center; margin-top:8px; }
    .btn-save { padding:8px 20px; background:#002970; color:#fff; border:none; border-radius:8px; font-size:0.82rem; font-weight:700; font-family:'Inter',sans-serif; cursor:pointer; display:flex; align-items:center; gap:7px; transition:all 0.2s; }
    .btn-save:hover { background:#0057b8; }
    .active-toggle { display:flex; align-items:center; gap:8px; font-size:0.78rem; font-weight:600; color:#64748b; }
    .toggle-sm { position:relative; display:inline-block; width:36px; height:20px; }
    .toggle-sm input { opacity:0; width:0; height:0; }
    .slider-sm { position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#cbd5e1; border-radius:34px; transition:0.3s; }
    .slider-sm:before { position:absolute; content:''; height:14px; width:14px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:0.3s; }
    .toggle-sm input:checked + .slider-sm { background:#10b981; }
    .toggle-sm input:checked + .slider-sm:before { transform:translateX(16px); }

    .flash-success { background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:#065f46; padding:12px 18px; border-radius:10px; font-size:0.88rem; font-weight:600; margin-bottom:20px; display:flex; align-items:center; gap:10px; }

</style>
@endsection

@section('content')

@if(session('success'))
<div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="stats-strip">
    <div class="stat-card-h">
        <div class="stat-icon-h" style="background:rgba(0,41,112,0.08);"><i class="fas fa-indian-rupee-sign" style="color:#002970;"></i></div>
        <div>
            <div class="stat-title-h">Commission Earned Today</div>
            <div class="stat-value-h">₹{{ number_format($todayCommission, 2) }}</div>
            <div class="stat-sub-h">Across all services</div>
        </div>
    </div>
    <div class="stat-card-h">
        <div class="stat-icon-h" style="background:rgba(16,185,129,0.1);"><i class="fas fa-mobile-screen" style="color:#10b981;"></i></div>
        <div>
            <div class="stat-title-h">Active Services</div>
            <div class="stat-value-h">{{ $commissions->where('is_active', true)->count() }}</div>
            <div class="stat-sub-h">of {{ $commissions->count() }} configured</div>
        </div>
    </div>
    <div class="stat-card-h">
        <div class="stat-icon-h" style="background:rgba(0,186,242,0.1);"><i class="fas fa-percent" style="color:#00baf2;"></i></div>
        <div>
            <div class="stat-title-h">Avg Commission %</div>
            <div class="stat-value-h">{{ $commissions->count() ? number_format($commissions->avg('commission_pct'), 2) : '0.00' }}%</div>
            <div class="stat-sub-h">Across configured services</div>
        </div>
    </div>
    <div class="stat-card-h">
        <div class="stat-icon-h" style="background:rgba(124,58,237,0.08);"><i class="fas fa-sliders" style="color:#7c3aed;"></i></div>
        <div>
            <div class="stat-title-h">Total Configured</div>
            <div class="stat-value-h">{{ $commissions->count() }}</div>
            <div class="stat-sub-h">Commission rules</div>
        </div>
    </div>
</div>

<div class="info-banner">
    <i class="fas fa-circle-info"></i>
    <span>Commission changes take effect immediately on the next transaction. Review carefully before saving.</span>
</div>

<div class="commission-grid">

    {{-- Mobile Recharge --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="mobile_recharge">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#eff6ff;"><i class="fas fa-mobile-screen" style="color:#2563eb;"></i></div>
                <div><div class="commission-card-title">Mobile Recharge</div><div class="commission-card-sub">Prepaid & Postpaid via Cyrus Recharge</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['mobile_recharge']->commission_pct ?? '2.5' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['mobile_recharge']->min_commission ?? '2' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['mobile_recharge']->max_commission ?? '50' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['mobile_recharge']->flat_charge ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['mobile_recharge']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- DTH Recharge --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="dth">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#fff7ed;"><i class="fas fa-satellite-dish" style="color:#ea580c;"></i></div>
                <div><div class="commission-card-title">DTH Recharge</div><div class="commission-card-sub">Tata Play, Sun Direct, Dish TV via Cyrus Recharge</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['dth']->commission_pct ?? '2.0' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['dth']->min_commission ?? '2' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['dth']->max_commission ?? '40' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['dth']->flat_charge ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['dth']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- Bill Payments --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="electricity">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#f0fdf4;"><i class="fas fa-file-invoice" style="color:#16a34a;"></i></div>
                <div><div class="commission-card-title">Bill Payments</div><div class="commission-card-sub">Electricity, Gas, Water via Cyrus Recharge</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['electricity']->commission_pct ?? '1.0' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['electricity']->min_commission ?? '5' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['electricity']->max_commission ?? '100' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['electricity']->flat_charge ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['electricity']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- Bus Booking --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="bus">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#f5f3ff;"><i class="fas fa-bus" style="color:#7c3aed;"></i></div>
                <div><div class="commission-card-title">Bus Booking</div><div class="commission-card-sub">All routes via Cyrus Recharge</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['bus']->commission_pct ?? '0' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Flat / Seat (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['bus']->min_commission ?? '25' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['bus']->max_commission ?? '200' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['bus']->flat_charge ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['bus']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- DMT (Money Transfer) --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="dmt">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#ecfeff;"><i class="fas fa-arrow-right-arrow-left" style="color:#0891b2;"></i></div>
                <div><div class="commission-card-title">DMT (Money Transfer)</div><div class="commission-card-sub">Domestic money transfer via Cyrus Recharge</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['dmt']->commission_pct ?? '0.5' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['dmt']->min_commission ?? '5' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['dmt']->max_commission ?? '500' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['dmt']->flat_charge ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['dmt']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- Bank Payout --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="bank_payout">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#f0fdf4;"><i class="fas fa-building-columns" style="color:#059669;"></i></div>
                <div><div class="commission-card-title">Bank Payout</div><div class="commission-card-sub">IMPS/NEFT/RTGS withdrawal payouts</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['bank_payout']->commission_pct ?? '0' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['bank_payout']->min_commission ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['bank_payout']->max_commission ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['bank_payout']->flat_charge ?? '10' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['bank_payout']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

    {{-- UPI Payout --}}
    <form method="POST" action="{{ route('admin.commission-settings.bulk-update') }}">
        @csrf @method('PUT')
        <input type="hidden" name="service_type" value="upi_payout">
        <div class="commission-card">
            <div class="commission-card-head">
                <div class="commission-card-icon" style="background:#f5f3ff;"><i class="fas fa-qrcode" style="color:#7c3aed;"></i></div>
                <div><div class="commission-card-title">UPI Payout</div><div class="commission-card-sub">Instant UPI withdrawal payouts</div></div>
            </div>
            <div class="commission-card-body">
                <div class="field-row">
                    <div class="field-group"><label>Commission %</label><div class="field-input-wrap"><input type="number" name="commission_pct" value="{{ $commissions['upi_payout']->commission_pct ?? '0' }}" min="0" max="10" step="0.01"><span class="field-suffix">%</span></div></div>
                    <div class="field-group"><label>Min Commission (₹)</label><div class="field-input-wrap"><input type="number" name="min_commission" value="{{ $commissions['upi_payout']->min_commission ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="field-row">
                    <div class="field-group"><label>Max Commission (₹)</label><div class="field-input-wrap"><input type="number" name="max_commission" value="{{ $commissions['upi_payout']->max_commission ?? '0' }}" min="0"><span class="field-suffix">₹</span></div></div>
                    <div class="field-group"><label>Flat Charge (₹)</label><div class="field-input-wrap"><input type="number" name="flat_charge" value="{{ $commissions['upi_payout']->flat_charge ?? '5' }}" min="0"><span class="field-suffix">₹</span></div></div>
                </div>
                <div class="save-row">
                    <div class="active-toggle">
                        <label class="toggle-sm"><input type="checkbox" name="is_active" value="1" {{ ($commissions['upi_payout']->is_active ?? true) ? 'checked' : '' }}><span class="slider-sm"></span></label>
                        Active
                    </div>
                    <button type="submit" class="btn-save"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('scripts')
@parent
<script>
$(function () {
    // no-op — forms submit natively
});
</script>
@endsection
