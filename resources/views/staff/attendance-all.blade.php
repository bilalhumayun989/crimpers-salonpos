@extends('layouts.app')
@section('title', 'Staff Attendance')

@section('content')
<style>
/* Accordion Styles */
.date-group { background: #fff; border: 1.5px solid #f0e8b0; border-radius: 16px; margin-bottom: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(199,168,0,0.05); }
.date-header { padding: 16px 24px; background: #fffdf0; cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: 0.2s; user-select: none; }
.date-header:hover { background: #fff9db; }
.date-info { display: flex; align-items: center; gap: 16px; }
.date-title { font-size: 1rem; font-weight: 800; color: #1e293b; }
.date-summary { font-size: 0.75rem; color: #94a3b8; font-weight: 600; display: flex; gap: 12px; }
.drop-arrow { transition: 0.3s; color: #c9a800; }
.date-group.active .drop-arrow { transform: rotate(180deg); }
.date-content { display: none; padding: 0 24px 24px; border-top: 1.5px solid #f0e8b0; }
.date-group.active .date-content { display: block; }

.attendance-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f1f5f9; }
.attendance-row:last-child { border-bottom: none; }
.staff-meta { display: flex; align-items: center; gap: 12px; }
.staff-info-box { line-height: 1.3; }
.staff-phone { font-size: 0.7rem; color: #94a3b8; }
.time-box { text-align: right; font-size: 0.8rem; color: #64748b; font-weight: 600; }

.hrms-search-box { background: #fff; border: 1.5px solid #f0e8a0; border-radius: 16px; padding: 6px 6px 6px 24px; margin-bottom: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 12px; }
.hrms-search-input { flex: 1; border: none; font-size: 0.95rem; font-family: inherit; color: #1e293b; outline: none; background: transparent; height: 48px; }
.hrms-search-icon { color: #c9a800; }
.btn-search-trigger { background: #c9a800; color: #fff; border: none; padding: 0 24px; height: 44px; border-radius: 12px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 8px; }

.date-filter-group { display: flex; align-items: center; gap: 8px; border-left: 1px solid #e2e8f0; padding-left: 16px; }
.date-label { font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
.f-date-input { border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 8px 12px; font-size: 0.85rem; font-family: inherit; color: #1e293b; outline: none; transition: 0.2s; }
.f-date-input:focus { border-color: #c9a800; box-shadow: 0 0 0 3px rgba(199,168,0,0.1); }
.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
.page-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0 0 3px; }
.page-sub { font-size: .85rem; color: #64748b; margin: 0; }
.back-btn { width: 38px; height: 38px; border-radius: 10px; background: #f4f4f5; border: 1.5px solid #e4e4e7; display: flex; align-items: center; justify-content: center; color: #52525b; text-decoration: none; transition: .2s; flex-shrink: 0; }
.back-btn:hover { background: #e4e4e7; color: #18181b; }
</style>

<div class="page-header">
    <a href="{{ route('staff.hrms') }}" class="back-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
    <div>
        <div class="page-title">Attendance History</div>
        <div class="page-sub">Review daily attendance logs and staff participation</div>
    </div>
</div>

<form action="{{ route('staff.attendance-all') }}" method="GET" class="hrms-search-box">
    <div class="hrms-search-icon">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    </div>
    <input type="text" id="attendance-search" class="hrms-search-input" placeholder="Search by staff name or phone number…">
    
    <div class="date-filter-group">
        <div style="display:flex; flex-direction:column; gap:2px;">
            <span class="date-label">From</span>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="f-date-input">
        </div>
        <div style="display:flex; flex-direction:column; gap:2px;">
            <span class="date-label">To</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="f-date-input">
        </div>
        <button type="submit" class="btn-search-trigger" style="height:44px; margin-top:14px;">
            Filter Dates
        </button>
        @if(request()->hasAny(['date_from', 'date_to']))
        <a href="{{ route('staff.attendance-all') }}" style="margin-top:14px; color:#94a3b8; font-size:0.75rem; font-weight:600; text-decoration:none;">Clear</a>
        @endif
    </div>
</form>

@if($records->count())
    @foreach($records->groupBy(function($r){ return $r->attendance_date->format('Y-m-d'); }) as $date => $dailyRecords)
    <div class="date-group" data-date="{{ $date }}">
        <div class="date-header" onclick="toggleDate(this)">
            <div class="date-info">
                <div class="date-title">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</div>
                <div class="date-summary">
                    <span style="color:#16a34a;">Present: {{ $dailyRecords->where('status','present')->count() }}</span>
                    <span style="color:#ef4444;">Absent: {{ $dailyRecords->where('status','absent')->count() }}</span>
                </div>
            </div>
            <div class="drop-arrow">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </div>
        </div>
        <div class="date-content">
            @foreach($dailyRecords as $record)
            <div class="attendance-row" 
                 data-name="{{ strtolower($record->staff->name) }}" 
                 data-phone="{{ $record->staff->phone }}">
                <div class="staff-meta">
                    <div class="staff-avatar-sm" style="width:34px; height:34px; border-radius:10px; background:#fffdf0; border:1px solid #f0e8b0; color:#c9a800; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.8rem;">
                        {{ strtoupper(substr($record->staff->name, 0, 1)) }}
                    </div>
                    <div class="staff-info-box">
                        <div style="font-weight:700; color:#1e293b; font-size:0.9rem;">{{ $record->staff->name }}</div>
                        <div class="staff-phone">{{ $record->staff->phone ?? 'No phone' }}</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:24px;">
                    <div class="time-box">
                        <div>IN: {{ $record->check_in_time?->format('H:i') ?? '—' }}</div>
                        <div style="color:#94a3b8; font-size:0.65rem;">OUT: {{ $record->check_out_time?->format('H:i') ?? '—' }}</div>
                    </div>
                    <span class="badge" style="background:{{ $record->status === 'present' ? '#dcfce7' : '#fee2e2' }}; color:{{ $record->status === 'present' ? '#166534' : '#991b1b' }};">
                        {{ ucfirst($record->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
@else
    <div class="date-group" style="padding:40px; text-align:center; color:#94a3b8;">
        No attendance records found
    </div>
@endif

<script>
function toggleDate(header) {
    header.parentElement.classList.toggle('active');
}

function triggerSearch() {
    const term = document.getElementById('attendance-search').value.toLowerCase();
    const rows = document.querySelectorAll('.attendance-row');
    const groups = document.querySelectorAll('.date-group');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        const phone = row.dataset.phone;
        if (name.includes(term) || phone.includes(term)) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
    });

    // Hide date groups that have no visible rows
    groups.forEach(group => {
        const visibleRows = group.querySelectorAll('.attendance-row[style="display: flex;"]');
        if (visibleRows.length === 0 && term !== "") {
            group.style.display = 'none';
        } else {
            group.style.display = 'block';
            // Auto expand if searching
            if (term !== "") {
                group.classList.add('active');
            }
        }
    });
}

document.getElementById('attendance-search').addEventListener('input', triggerSearch);
</script>
@endsection