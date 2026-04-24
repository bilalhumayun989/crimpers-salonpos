@extends('layouts.app')
@section('title', $staff->name . ' - Shifts')

@section('content')
<style>
.shifts-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.staff-info h2{font-size:1.1rem;font-weight:700;color:#1e293b;margin:0;}
.staff-info p{font-size:.85rem;color:#94a3b8;margin:3px 0 0;}
.btn-add{padding:8px 16px;background:#22c55e;color:#fff;border:none;border-radius:10px;text-decoration:none;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;display:inline-block;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:repeat(5,1fr);gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:repeat(5,1fr);gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.shift-badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;background:#f0fdf4;color:#16a34a;}

.empty-msg{text-align:center;padding:40px 20px;color:#94a3b8;font-size:.9rem;}
</style>

<div class="shifts-header">
    <div class="staff-info">
        <h2>{{ $staff->name }} - Shifts</h2>
        <p>{{ $staff->position }}</p>
    </div>
    <a href="{{ route('staff.create-shift', $staff) }}" class="btn-add">+ Schedule Shift</a>
</div>

@if($shifts->count())
<div class="table-wrap">
    <div class="table-head">
        <span>Date</span>
        <span>Type</span>
        <span>Time</span>
        <span>Duration</span>
        <span>Notes</span>
    </div>
    @foreach($shifts as $shift)
    <div class="table-row">
        <span>{{ $shift->shift_date->format('M d, Y') }}</span>
        <span>
            <span class="shift-badge">{{ ucfirst(str_replace('_', ' ', $shift->shift_type)) }}</span>
        </span>
        <span style="font-size:.85rem;color:#64748b;">{{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }}</span>
        <span style="font-weight:600;">{{ floor(($shift->end_time->diffInMinutes($shift->start_time) - $shift->break_duration) / 60) }}h</span>
        <span style="font-size:.8rem;color:#94a3b8;">{{ $shift->notes ?? '—' }}</span>
    </div>
    @endforeach
</div>

{{ $shifts->links() }}
@else
<div class="empty-msg">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;opacity:.3;"><path d="M8 7V3m8 4V3m-9 8h10m2 10H4a2 2 0 01-2-2V7a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2z"/></svg>
    No shifts scheduled yet
</div>
@endif
@endsection
