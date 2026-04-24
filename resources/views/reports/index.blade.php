@extends('layouts.app')
@section('title', 'Reports & Analytics')

@section('content')
<style>
/* ── Header ── */
.rpt-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;flex-wrap:wrap;}
.rpt-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.rpt-sub{font-size:.85rem;color:#64748b;max-width:560px;line-height:1.6;}
.rpt-date{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:99px;font-size:.75rem;font-weight:600;color:#16a34a;white-space:nowrap;}

/* ── Stat cards ── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;}
.stat-card{background:#fff;border:1px solid #e8f5e9;border-radius:16px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,.04);position:relative;overflow:hidden;transition:box-shadow .2s;}
.stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);}
.stat-accent{position:absolute;top:0;left:0;right:0;height:3px;border-radius:16px 16px 0 0;}
.stat-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;}
.stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-badge{font-size:.68rem;font-weight:700;padding:3px 8px;border-radius:99px;}
.stat-badge.up{background:#dcfce7;color:#15803d;}
.stat-badge.down{background:#fee2e2;color:#b91c1c;}
.stat-badge.neutral{background:#f1f5f9;color:#64748b;}
.stat-val{font-size:1.65rem;font-weight:800;color:#0f172a;letter-spacing:-.03em;line-height:1;margin-bottom:5px;}
.stat-label{font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;}
.stat-note{font-size:.75rem;color:#94a3b8;line-height:1.4;}

/* ── Bottom grid ── */
.bottom-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px;}

/* ── Panel ── */
.panel{background:#fff;border:1px solid #e8f5e9;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,.04);overflow:hidden;}
.panel-head{padding:16px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;}
.panel-title{font-size:.9rem;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:8px;}
.panel-icon{width:26px;height:26px;border-radius:7px;display:flex;align-items:center;justify-content:center;}
.panel-count{font-size:.72rem;color:#94a3b8;font-weight:500;}
.panel-body{padding:0 20px;}

/* ── List rows ── */
.list-row{display:flex;align-items:center;justify-content:space-between;padding:11px 0;border-bottom:1px solid #f8fafc;}
.list-row:last-child{border-bottom:none;}
.list-rank{width:22px;height:22px;border-radius:6px;background:#f1f5f9;color:#94a3b8;font-size:.68rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:10px;}
.list-rank.top{background:#fef3c7;color:#92400e;}
.list-info{flex:1;min-width:0;}
.list-name{font-size:.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.list-sub{font-size:.72rem;color:#94a3b8;margin-top:1px;}
.list-val{font-size:.875rem;font-weight:700;color:#1e293b;text-align:right;flex-shrink:0;}
.list-val-sub{font-size:.7rem;color:#94a3b8;text-align:right;margin-top:1px;}

/* ── Bar chart ── */
.bar-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f8fafc;}
.bar-row:last-child{border-bottom:none;}
.bar-label{font-size:.78rem;font-weight:600;color:#374151;width:44px;flex-shrink:0;}
.bar-track{flex:1;height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.bar-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#22c55e,#16a34a);transition:width .4s ease;}
.bar-val{font-size:.75rem;font-weight:700;color:#16a34a;width:52px;text-align:right;flex-shrink:0;}

/* ── Metric row ── */
.metric-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;}
.metric-card{background:#fff;border:1px solid #e8f5e9;border-radius:14px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,.04);}
.metric-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;}
.metric-val{font-size:1.5rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.metric-label{font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;}
.metric-note{font-size:.75rem;color:#94a3b8;line-height:1.4;}

/* ── Empty ── */
.empty-msg{padding:28px;text-align:center;color:#cbd5e1;font-size:.82rem;}
</style>

{{-- Header --}}
<div class="rpt-header">
    <div>
        <div class="rpt-title">Reports &amp; Analytics</div>
        <div class="rpt-sub">Monitor revenue, service vs product performance, customer retention, busy hours, and profit margins.</div>
    </div>
    <div class="rpt-date">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Updated {{ now()->format('M j, Y') }}
    </div>
</div>

{{-- Stat cards row 1 --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#22c55e,#16a34a)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            @if($salesTrend !== null)
            <span class="stat-badge {{ $salesTrend >= 0 ? 'up' : 'down' }}">{{ $salesTrend >= 0 ? '+' : '' }}{{ $salesTrend }}% vs yesterday</span>
            @else
            <span class="stat-badge neutral">Today</span>
            @endif
        </div>
        <div class="stat-label">Today's Sales</div>
        <div class="stat-val">PKR {{ number_format($totalSalesToday, 2) }}</div>
        <div class="stat-note">{{ $transactionCountToday }} transactions today</div>
    </div>

    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#3b82f6,#6366f1)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <span class="stat-badge neutral">Services</span>
        </div>
        <div class="stat-label">Service Revenue Share</div>
        <div class="stat-val">{{ $serviceRevenueShare }}%</div>
        <div class="stat-note">PKR {{ number_format($serviceRevenue, 2) }} total service sales</div>
    </div>

    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#f59e0b,#f97316)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#fffbeb;color:#f59e0b;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="stat-badge neutral">Products</span>
        </div>
        <div class="stat-label">Product Revenue Share</div>
        <div class="stat-val">{{ $productRevenueShare }}%</div>
        <div class="stat-note">PKR {{ number_format($productRevenue, 2) }} total product sales</div>
    </div>

    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#8b5cf6,#a855f7)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#f5f3ff;color:#8b5cf6;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <span class="stat-badge up">Retention</span>
        </div>
        <div class="stat-label">Customer Retention</div>
        <div class="stat-val">{{ $retentionRate }}%</div>
        <div class="stat-note">{{ $returningCustomers }} returning of {{ $activeCustomers }} active</div>
    </div>

    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#22c55e,#16a34a)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <span class="stat-badge up">{{ $profitMargin }}% margin</span>
        </div>
        <div class="stat-label">Gross Profit</div>
        <div class="stat-val">PKR {{ number_format($grossProfit, 2) }}</div>
        <div class="stat-note">Estimated profit after COGS</div>
    </div>

    <div class="stat-card">
        <div class="stat-accent" style="background:linear-gradient(90deg,#ef4444,#f97316)"></div>
        <div class="stat-top">
            <div class="stat-icon" style="background:#fef2f2;color:#ef4444;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/></svg>
            </div>
            <span class="stat-badge down">Cost</span>
        </div>
        <div class="stat-label">Cost of Goods Sold</div>
        <div class="stat-val">PKR {{ number_format($totalCost, 2) }}</div>
        <div class="stat-note">Products PKR {{ number_format($directProductCost,2) }} · Supplies PKR {{ number_format($serviceSupplyCost,2) }}</div>
    </div>
</div>

{{-- Three panels --}}
<div class="bottom-grid">

    {{-- Top Services --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <div class="panel-icon" style="background:#f0fdf4;color:#22c55e;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                Top Services
            </div>
            <span class="panel-count">by revenue</span>
        </div>
        <div class="panel-body">
            @forelse($topServices as $i => $item)
            <div class="list-row">
                <div class="list-rank {{ $i === 0 ? 'top' : '' }}">{{ $i + 1 }}</div>
                <div class="list-info">
                    <div class="list-name">{{ $item['service']->name }}</div>
                    <div class="list-sub">{{ $item['quantity'] }} sold</div>
                </div>
                <div>
                    <div class="list-val" style="color:#16a34a;">PKR {{ number_format($item['revenue'], 2) }}</div>
                </div>
            </div>
            @empty
            <div class="empty-msg">No service sales data yet</div>
            @endforelse
        </div>
    </div>

    {{-- Busiest Hours --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <div class="panel-icon" style="background:#eff6ff;color:#3b82f6;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                Busiest Hours
            </div>
            <span class="panel-count">by revenue</span>
        </div>
        <div class="panel-body">
            @php $maxRev = $busyHours->max('revenue') ?: 1; @endphp
            @forelse($busyHours as $hour)
            <div class="bar-row">
                <div class="bar-label">{{ \Carbon\Carbon::createFromTime($hour->hour,0,0)->format('g A') }}</div>
                <div class="bar-track">
                    <div class="bar-fill" style="width:{{ round(($hour->revenue / $maxRev) * 100) }}%"></div>
                </div>
                <div class="bar-val">PKR {{ number_format($hour->revenue, 0) }}</div>
            </div>
            @empty
            <div class="empty-msg">No invoice activity yet</div>
            @endforelse
        </div>
    </div>

    {{-- Staff Performance --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <div class="panel-icon" style="background:#f5f3ff;color:#8b5cf6;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                Staff Performance
            </div>
            <span class="panel-count">upsell revenue</span>
        </div>
        <div class="panel-body">
            @forelse($staffPerformance as $i => $member)
            <div class="list-row">
                <div class="list-rank {{ $i === 0 ? 'top' : '' }}">{{ $i + 1 }}</div>
                <div class="list-info">
                    <div class="list-name">{{ $member->name }}</div>
                    <div class="list-sub">{{ $member->position }}</div>
                </div>
                <div>
                    <div class="list-val">PKR {{ number_format($member->upsellPerformance->upsell_revenue ?? 0, 2) }}</div>
                    <div class="list-val-sub">{{ $member->upsellPerformance->conversion_rate ?? 0 }}% conv.</div>
                </div>
            </div>
            @empty
            <div class="empty-msg">No staff performance records yet</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Metric cards --}}
<div class="metric-grid">
    <div class="metric-card">
        <div class="metric-icon" style="background:#f5f3ff;color:#8b5cf6;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="metric-label">Returning Customers</div>
        <div class="metric-val" style="color:#8b5cf6;">{{ $returningCustomers }}</div>
        <div class="metric-note">Customers with repeat visits in the last 30 days</div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#eff6ff;color:#3b82f6;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-8 0v2"/><circle cx="12" cy="7" r="4"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>
        </div>
        <div class="metric-label">New Customers (30d)</div>
        <div class="metric-val" style="color:#3b82f6;">{{ $newCustomers }}</div>
        <div class="metric-note">Customers with their first invoice this month</div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#f0fdf4;color:#22c55e;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        </div>
        <div class="metric-label">Total Revenue (All Time)</div>
        <div class="metric-val" style="color:#16a34a;">PKR {{ number_format($totalRevenue, 2) }}</div>
        <div class="metric-note">All-time net sales from invoices</div>
    </div>
</div>
@endsection
