@extends('layouts.app')
@section('title', 'Staff Performance')

@section('content')
<style>
:root{--y1:#F7DF79;--y2:#FBEFBC;--yd:#c9a800;--yk:#a07800;}

/* Header */
.pg-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;gap:16px;flex-wrap:wrap;}
.pg-title{font-size:1.45rem;font-weight:800;color:#18181b;letter-spacing:-.02em;margin:0 0 4px;}
.pg-sub{font-size:.85rem;color:#71717a;margin:0;}

/* Sort buttons */
.sort-bar{display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;}
.sort-btn{padding:7px 16px;border:1.5px solid #E8EAED;background:#fff;border-radius:99px;cursor:pointer;font-size:.8rem;font-weight:700;font-family:'Outfit',sans-serif;color:#5C6370;transition:.18s;}
.sort-btn:hover{border-color:var(--yd);color:var(--yk);}
.sort-btn.active{background:var(--y2);border-color:var(--yd);color:var(--yk);}

/* Grid */
.perf-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;}

/* Card */
.perf-card{background:#fff;border:1.5px solid #E8EAED;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.05);transition:.2s;}
.perf-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.08);border-color:#D8DBE0;}

/* Card head */
.perf-head{padding:16px 18px;background:#F4F5F7;border-bottom:1.5px solid #E8EAED;display:flex;align-items:center;gap:12px;}
.perf-avatar{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,var(--y1),var(--yd));display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#18181b;flex-shrink:0;}
.perf-name{font-size:.92rem;font-weight:800;color:#18181b;margin:0 0 2px;}
.perf-pos{font-size:.72rem;color:#8A909A;margin:0;font-weight:600;}

/* Card body */
.perf-body{padding:14px 18px;}
.perf-stat{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #F0F2F5;font-size:.83rem;}
.perf-stat:last-of-type{border-bottom:none;}
.perf-stat-label{color:#64748b;display:flex;align-items:center;gap:6px;}
.perf-stat-val{font-weight:800;color:#18181b;}
.perf-stat-val.yellow{color:var(--yk);}

/* Rank badge */
.rank-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:.7rem;font-weight:700;background:var(--y2);color:var(--yk);border:1px solid var(--y1);}

/* No data */
.no-data{font-size:.82rem;color:#a1a1aa;padding:8px 0;}

/* View link */
.view-link{display:block;margin-top:12px;padding:8px;text-align:center;text-decoration:none;color:#3C4048;font-size:.78rem;font-weight:700;background:#F4F5F7;border-radius:9px;transition:.15s;}
.view-link:hover{background:#E8EAED;color:#18181b;}

/* Empty */
.empty-state{text-align:center;padding:70px 20px;background:#fff;border-radius:16px;border:2px dashed #E8EAED;}
.empty-state p{color:#a1a1aa;font-size:.9rem;margin-top:12px;}
</style>

<div class="pg-header">
    <div>
        <div class="pg-title">Staff Performance</div>
        <div class="pg-sub">Track upsell performance, conversion rates &amp; revenue metrics</div>
    </div>
</div>

<div class="sort-bar">
    <button class="sort-btn active" onclick="sortBy('upsells',this)">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        Most Upsells
    </button>
    <button class="sort-btn" onclick="sortBy('revenue',this)">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px;"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        Revenue
    </button>
    <button class="sort-btn" onclick="sortBy('conversion',this)">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Conversion Rate
    </button>
</div>

@if($staff->count())
<div class="perf-grid" id="perfGrid">
    @foreach($staff as $member)
    <div class="perf-card"
         data-upsells="{{ $member->upsellPerformance->total_upsells ?? 0 }}"
         data-revenue="{{ $member->upsellPerformance->upsell_revenue ?? 0 }}"
         data-conversion="{{ $member->upsellPerformance->conversion_rate ?? 0 }}">

        <div class="perf-head">
            <div class="perf-avatar">{{ strtoupper(substr($member->name,0,1)) }}</div>
            <div>
                <div class="perf-name">{{ $member->name }}</div>
                <div class="perf-pos">{{ $member->role->name ?? 'General Staff' }}</div>
            </div>
        </div>

        <div class="perf-body">
            @if($member->upsellPerformance)
                <div class="perf-stat">
                    <span class="perf-stat-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                        Total Upsells
                    </span>
                    <span class="perf-stat-val yellow">{{ $member->upsellPerformance->total_upsells }}</span>
                </div>
                <div class="perf-stat">
                    <span class="perf-stat-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        Upsell Revenue
                    </span>
                    <span class="perf-stat-val">PKR {{ number_format($member->upsellPerformance->upsell_revenue, 0) }}</span>
                </div>
                <div class="perf-stat">
                    <span class="perf-stat-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Conversion Rate
                    </span>
                    <span class="perf-stat-val yellow">{{ $member->upsellPerformance->conversion_rate }}%</span>
                </div>
                <div class="perf-stat">
                    <span class="perf-stat-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        Avg Upsell Value
                    </span>
                    <span class="perf-stat-val">PKR {{ number_format($member->upsellPerformance->average_upsell_value, 0) }}</span>
                </div>
                <div style="margin-top:10px;padding-top:10px;border-top:1px solid #F0F2F5;">
                    <span class="rank-badge">
                        <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Top Performer
                    </span>
                </div>
            @else
                <div class="no-data">No performance data recorded yet.</div>
            @endif

            <a href="{{ route('staff.show', $member) }}" class="view-link">View Full Profile</a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <svg width="48" height="48" fill="none" stroke="#a1a1aa" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto;display:block;"><polyline points="21 8 21 21 3 21 3 10"/><path d="M23 3H1v5h22z"/><path d="M10 12v9M14 12v9"/></svg>
    <p>No staff performance data available yet</p>
</div>
@endif

<script>
function sortBy(metric, btn) {
    document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const grid = document.getElementById('perfGrid');
    if (!grid) return;
    const cards = Array.from(grid.children);
    cards.sort((a, b) => {
        const aVal = parseFloat(a.dataset[metric]) || 0;
        const bVal = parseFloat(b.dataset[metric]) || 0;
        return bVal - aVal;
    });
    grid.innerHTML = '';
    cards.forEach(c => grid.appendChild(c));
}
</script>
@endsection
