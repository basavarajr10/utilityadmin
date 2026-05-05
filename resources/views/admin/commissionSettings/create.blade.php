@extends('layouts.admin')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.03); overflow:hidden; max-width:700px; }
    .form-card-head { padding:20px 28px; border-bottom:1px solid #f1f5f9; background:#fafcff; display:flex; align-items:center; gap:14px; }
    .form-card-head h3 { font-size:1.05rem; font-weight:800; color:#002970; margin:0; }
    .form-card-body { padding:28px; }
    .fc-group { margin-bottom:22px; }
    .fc-group label { display:block; font-size:0.75rem; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:8px; }
    .fc-group label .req { color:#ef4444; margin-left:2px; }
    .fc-group select, .fc-group input[type=text], .fc-group input[type=number] {
        width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px;
        font-size:0.9rem; font-family:'Inter',sans-serif; color:#1e293b;
        background:#f8fafc; outline:none; transition:all 0.3s;
    }
    .fc-group select:focus, .fc-group input:focus {
        border-color:#00baf2; background:#fff; box-shadow:0 0 0 3px rgba(0,186,242,0.1);
    }
    .fc-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .fc-error { font-size:0.78rem; color:#ef4444; margin-top:5px; display:block; }
    .fc-check-row { display:flex; align-items:center; gap:12px; padding:14px 18px; background:#f8fafc; border-radius:10px; border:1.5px solid #e2e8f0; }
    .fc-check-row input[type=checkbox] { width:18px; height:18px; accent-color:#002970; cursor:pointer; }
    .fc-check-row label { font-size:0.88rem; font-weight:600; color:#1e293b; margin:0; cursor:pointer; }
    .fc-actions { display:flex; align-items:center; gap:14px; margin-top:8px; }
    .btn-submit { padding:11px 28px; background:#002970; color:#fff; border:none; border-radius:10px; font-size:0.88rem; font-weight:700; font-family:'Inter',sans-serif; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s; }
    .btn-submit:hover { background:#0057b8; transform:translateY(-1px); }
    .btn-cancel { padding:11px 22px; background:#f1f5f9; color:#64748b; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s; }
    .btn-cancel:hover { background:#e2e8f0; color:#1e293b; }
</style>
@endsection

@section('content')

<div class="form-card">
    <div class="form-card-head">
        <div style="width:38px;height:38px;border-radius:10px;background:rgba(0,41,112,0.08);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-percent" style="color:#002970;"></i>
        </div>
        <h3>Add Commission Setting</h3>
    </div>
    <div class="form-card-body">
        <form method="POST" action="{{ route('admin.commission-settings.store') }}">
            @csrf

            <div class="fc-group">
                <label>Service Type <span class="req">*</span></label>
                <select name="service_type" required>
                    <option value disabled {{ old('service_type') === null ? 'selected' : '' }}>— Select service —</option>
                    @foreach(App\Models\CommissionSetting::SERVICE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('service_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('service_type')<span class="fc-error">{{ $message }}</span>@enderror
            </div>

            <div class="fc-row">
                <div class="fc-group">
                    <label>Commission % <span class="req">*</span></label>
                    <input type="number" name="commission_pct" value="{{ old('commission_pct') }}" min="0" max="100" step="0.01" placeholder="e.g. 2.5" required>
                    @error('commission_pct')<span class="fc-error">{{ $message }}</span>@enderror
                </div>
                <div class="fc-group">
                    <label>Flat Charge (₹)</label>
                    <input type="number" name="flat_charge" value="{{ old('flat_charge', '0') }}" min="0" step="0.01" placeholder="0">
                    @error('flat_charge')<span class="fc-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="fc-row">
                <div class="fc-group">
                    <label>Min Commission (₹) <span class="req">*</span></label>
                    <input type="number" name="min_commission" value="{{ old('min_commission') }}" min="0" step="0.01" placeholder="e.g. 2" required>
                    @error('min_commission')<span class="fc-error">{{ $message }}</span>@enderror
                </div>
                <div class="fc-group">
                    <label>Max Commission (₹) <span class="req">*</span></label>
                    <input type="number" name="max_commission" value="{{ old('max_commission') }}" min="0" step="0.01" placeholder="e.g. 50" required>
                    @error('max_commission')<span class="fc-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="fc-group">
                <div class="fc-check-row">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                    <label for="is_active">Active — enable this commission rule immediately</label>
                </div>
                @error('is_active')<span class="fc-error">{{ $message }}</span>@enderror
            </div>

            <div class="fc-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Commission</button>
                <a href="{{ route('admin.commission-settings.index') }}" class="btn-cancel"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
