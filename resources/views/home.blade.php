@extends('layouts.admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', now()->format('l, d F Y'))

@section('styles')
<style>
    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        padding: 18px 22px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,0.08); }

    .stat-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px; font-size: 1rem;
    }

    .stat-title { font-size: 0.7rem; color: #64748b; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-value { font-size: 1.5rem; font-weight: 800; color: #002970; }
    .stat-sub { font-size: 0.68rem; margin-top: 4px; font-weight: 600; }
    .up { color: #10b981; }
    .down { color: #ef4444; }

    /* ── Data Card ── */
    .data-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .card-head {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-head h3 { font-size: 1rem; font-weight: 700; color: #002970; margin: 0; }

    .card-head select {
        padding: 6px 12px; border-radius: 8px;
        border: 1px solid #e2e8f0; font-size: 0.8rem; font-weight: 600;
        color: #1e293b; background: #fff; cursor: pointer; outline: none;
        font-family: 'Inter', sans-serif;
    }

    .card-head a {
        font-size: 0.8rem; font-weight: 700; color: #00baf2;
        text-decoration: none; transition: color 0.2s;
    }

    .card-head a:hover { color: #002970; }

    /* ── Tables ── */
    .data-card table { width: 100%; border-collapse: collapse; }
    .data-card th {
        text-align: left; background: #f8fafc;
        padding: 13px 24px; font-size: 0.68rem;
        text-transform: uppercase; color: #64748b;
        font-weight: 800; letter-spacing: 0.5px;
    }
    .data-card td {
        padding: 13px 24px; border-bottom: 1px solid #f1f5f9;
        font-size: 0.83rem; font-weight: 500; color: #1e293b;
        vertical-align: middle;
    }
    .data-card tr:hover td { background: #fafafa; }
    .data-card tr:last-child td { border-bottom: none; }

    /* ── Badges ── */
    .badge-success { background: rgba(16,185,129,0.12); color: #065f46; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
    .badge-pending { background: rgba(245,158,11,0.12); color: #92400e; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
    .badge-failed  { background: rgba(239,68,68,0.1);  color: #991b1b; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }

    /* ── Quick Actions ── */
    .quick-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; padding: 18px 24px; }
    .quick-btn { display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; color: #002970; transition: all 0.3s; }
    .quick-btn .qicon { width: 42px; height: 42px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.3s; }
    .quick-btn span { font-size: 0.72rem; font-weight: 700; }
    .quick-btn:hover .qicon { background: #002970; color: #fff; transform: translateY(-3px); }

    /* ── Service Breakdown ── */
    .service-row { display: flex; align-items: center; gap: 14px; padding: 11px 24px; }
    .service-label { flex: 1; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    .service-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .service-bar-wrap { flex: 2; height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden; }
    .service-bar { height: 100%; border-radius: 10px; }
    .service-pct { width: 40px; font-size: 0.8rem; font-weight: 700; text-align: right; color: #64748b; }

    /* ── Bottom grid ── */
    .bottom-grid { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; margin-top: 24px; }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .quick-grid { grid-template-columns: repeat(3, 1fr); }
        .bottom-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(0,41,112,0.08);">
            <i class="fas fa-users" style="color:#002970;"></i>
        </div>
        <div class="stat-title">Total Users</div>
        <div class="stat-value">12,480</div>
        <div class="stat-sub up"><i class="fas fa-arrow-up"></i> +320 this week</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(0,186,242,0.1);">
            <i class="fas fa-arrow-right-arrow-left" style="color:#00baf2;"></i>
        </div>
        <div class="stat-title">Today's Transactions</div>
        <div class="stat-value">1,842</div>
        <div class="stat-sub up"><i class="fas fa-arrow-up"></i> +12% vs yesterday</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,0.1);">
            <i class="fas fa-indian-rupee-sign" style="color:#10b981;"></i>
        </div>
        <div class="stat-title">Revenue This Month</div>
        <div class="stat-value">₹8.4L</div>
        <div class="stat-sub up"><i class="fas fa-arrow-up"></i> +18% vs last month</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,0.08);">
            <i class="fas fa-circle-xmark" style="color:#ef4444;"></i>
        </div>
        <div class="stat-title">Failed Transactions</div>
        <div class="stat-value">43</div>
        <div class="stat-sub down"><i class="fas fa-arrow-down"></i> -5% today</div>
    </div>
</div>

{{-- Chart + Quick Actions --}}
<div class="data-card mb-0" style="margin-bottom:24px;">
    <div class="card-head">
        <h3>Transaction Volume</h3>
        <select id="chartRange">
            <option>Last 7 Days</option>
            <option>Last 30 Days</option>
            <option>Last 6 Months</option>
        </select>
    </div>
    <div style="padding:20px;height:280px;">
        <canvas id="txnChart"></canvas>
    </div>
</div>

<div class="data-card" style="margin-bottom:24px;">
    <div class="card-head"><h3>Quick Actions</h3></div>
    <div class="quick-grid">
        <a href="{{ route('admin.customers.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-user-plus"></i></div><span>Add User</span></a>
        <a href="{{ route('admin.notifications.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-paper-plane"></i></div><span>Send Notify</span></a>
        <a href="{{ route('admin.commission-settings.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-percent"></i></div><span>Commission</span></a>
        <a href="{{ route('admin.transactions.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-file-export"></i></div><span>Transactions</span></a>
        <a href="{{ route('admin.audit-logs.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-file-alt"></i></div><span>Audit Logs</span></a>
        <a href="{{ route('admin.app-settings.index') }}" class="quick-btn"><div class="qicon"><i class="fas fa-gear"></i></div><span>Settings</span></a>
    </div>
</div>

{{-- Recent Transactions + Service Breakdown --}}
<div class="bottom-grid">

    <div class="data-card">
        <div class="card-head">
            <h3>Recent Transactions</h3>
            <a href="{{ route('admin.transactions.index') }}">View All</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Ravi Kumar</strong><br><small style="color:#64748b;">+91 98765 43210</small></td>
                    <td>Mobile Recharge</td>
                    <td>₹299</td>
                    <td><span class="badge-success">Success</span></td>
                    <td>2 min ago</td>
                </tr>
                <tr>
                    <td><strong>Priya S.</strong><br><small style="color:#64748b;">+91 87654 32109</small></td>
                    <td>Electricity Bill</td>
                    <td>₹1,450</td>
                    <td><span class="badge-success">Success</span></td>
                    <td>8 min ago</td>
                </tr>
                <tr>
                    <td><strong>Arjun M.</strong><br><small style="color:#64748b;">+91 76543 21098</small></td>
                    <td>Bus Booking</td>
                    <td>₹680</td>
                    <td><span class="badge-pending">Pending</span></td>
                    <td>15 min ago</td>
                </tr>
                <tr>
                    <td><strong>Sneha R.</strong><br><small style="color:#64748b;">+91 65432 10987</small></td>
                    <td>DTH Recharge</td>
                    <td>₹399</td>
                    <td><span class="badge-failed">Failed</span></td>
                    <td>22 min ago</td>
                </tr>
                <tr>
                    <td><strong>Vikram D.</strong><br><small style="color:#64748b;">+91 54321 09876</small></td>
                    <td>Gas Bill</td>
                    <td>₹850</td>
                    <td><span class="badge-success">Success</span></td>
                    <td>35 min ago</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="data-card">
        <div class="card-head"><h3>Service Breakdown</h3></div>
        <div style="padding:8px 0;">
            <div class="service-row">
                <div class="service-label"><div class="service-dot" style="background:#002970;"></div>Mobile Recharge</div>
                <div class="service-bar-wrap"><div class="service-bar" style="width:68%;background:#002970;"></div></div>
                <div class="service-pct">68%</div>
            </div>
            <div class="service-row">
                <div class="service-label"><div class="service-dot" style="background:#00baf2;"></div>Bill Payments</div>
                <div class="service-bar-wrap"><div class="service-bar" style="width:52%;background:#00baf2;"></div></div>
                <div class="service-pct">52%</div>
            </div>
            <div class="service-row">
                <div class="service-label"><div class="service-dot" style="background:#10b981;"></div>Bus Booking</div>
                <div class="service-bar-wrap"><div class="service-bar" style="width:34%;background:#10b981;"></div></div>
                <div class="service-pct">34%</div>
            </div>
            <div class="service-row">
                <div class="service-label"><div class="service-dot" style="background:#f59e0b;"></div>DTH Recharge</div>
                <div class="service-bar-wrap"><div class="service-bar" style="width:24%;background:#f59e0b;"></div></div>
                <div class="service-pct">24%</div>
            </div>
            <div class="service-row">
                <div class="service-label"><div class="service-dot" style="background:#8b5cf6;"></div>Wallet Load</div>
                <div class="service-bar-wrap"><div class="service-bar" style="width:18%;background:#8b5cf6;"></div></div>
                <div class="service-pct">18%</div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('txnChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
            {
                label: 'Recharges',
                data: [420, 580, 390, 720, 650, 890, 760],
                borderColor: '#002970', backgroundColor: 'rgba(0,41,112,0.05)',
                fill: true, tension: 0.4, borderWidth: 2,
                pointBackgroundColor: '#002970', pointRadius: 4
            },
            {
                label: 'Bills',
                data: [210, 340, 280, 410, 380, 520, 460],
                borderColor: '#00baf2', backgroundColor: 'rgba(0,186,242,0.05)',
                fill: true, tension: 0.4, borderWidth: 2,
                pointBackgroundColor: '#00baf2', pointRadius: 4
            },
            {
                label: 'Bus',
                data: [80, 120, 95, 180, 160, 240, 200],
                borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.05)',
                fill: true, tension: 0.4, borderWidth: 2,
                pointBackgroundColor: '#10b981', pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { font: { size: 11, family: 'Inter' }, boxWidth: 10, padding: 16 } }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});
</script>
@endsection
