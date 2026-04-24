@extends('layouts.app')
@section('title', $staff->name . ' - Attendance')

@section('content')
<style>
.staff-att-header{display:flex;align-items:center;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.staff-avatar{width:48px;height:48px;border-radius:10px;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;}
.staff-info h2{font-size:1.1rem;font-weight:700;color:#1e293b;margin:0;}
.staff-info p{font-size:.85rem;color:#94a3b8;margin:3px 0 0;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:repeat(5,1fr);gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:repeat(5,1fr);gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.status-badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;}
.status-present{background:#dcfce7;color:#166534;}
.status-absent{background:#fecaca;color:#7f1d1d;}
.status-late{background:#fef3c7;color:#92400e;}
.status-halfday{background:#dbeafe;color:#0c4a6e;}
.status-leave{background:#f3e8ff;color:#5b21b6;}

.empty-msg{text-align:center;padding:40px 20px;color:#94a3b8;font-size:.9rem;}

.form-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:24px;}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin-bottom:12px;}
.form-group{display:flex;flex-direction:column;}
.form-group label{font-size:.8rem;font-weight:600;color:#334155;margin-bottom:4px;}
.form-group input, .form-group select{padding:8px;border:1px solid #e2e8f0;border-radius:8px;font-family:'Outfit',sans-serif;font-size:.9rem;}
.btn-submit{padding:8px 16px;background:#22c55e;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;}
</style>

<div class="staff-att-header">
    <div class="staff-avatar">{{ strtoupper(substr($staff->name, 0, 1)) }}</div>
    <div class="staff-info">
        <h2>{{ $staff->name }}</h2>
        <p>{{ $staff->position }}</p>
    </div>
</div>

<div class="form-wrap">
    <h3 style="margin:0 0 12px;font-size:1rem;font-weight:700;color:#1e293b;">Record Attendance</h3>
    <form action="{{ route('staff.record-attendance') }}" method="POST">
        @csrf
        <input type="hidden" name="staff_id" value="{{ $staff->id }}">
        <div class="form-grid">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="attendance_date" value="{{ now()->format('Y-m-d') }}" required />
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                    <option value="half_day">Half Day</option>
                    {{-- <option value="leave">Leave</option> --}}
                </select>
            </div>
            <div class="form-group">
                <label>Check In</label>
                <input type="datetime-local" name="check_in_time" />
            </div>
            <div class="form-group">
                <label>Check Out</label>
                <input type="datetime-local" name="check_out_time" />
            </div>
        </div>
        <div style="margin-bottom:12px;">
            <label style="display:block;font-size:.8rem;font-weight:600;color:#334155;margin-bottom:4px;">Notes</label>
            <textarea name="notes" rows="2" style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:8px;font-family:'Outfit',sans-serif;resize:none;"></textarea>
        </div>
        <button type="submit" class="btn-submit">Save Attendance</button>
    </form>
</div>

@if($records->count())
<div class="table-wrap">
    <div class="table-head">
        <span>Date</span>
        <span>Check In</span>
        <span>Check Out</span>
        <span>Status</span>
        <span>Notes</span>
    </div>
    @foreach($records as $record)
    <div class="table-row">
        <span>{{ $record->attendance_date->format('M d, Y') }}</span>
        <span style="font-size:.85rem;color:#64748b;">{{ $record->check_in_time?->format('H:i') ?? '—' }}</span>
        <span style="font-size:.85rem;color:#64748b;">{{ $record->check_out_time?->format('H:i') ?? '—' }}</span>
        <span>
            <span class="status-badge status-{{ str_replace('_', '', $record->status) }}">
                {{ ucfirst(str_replace('_', ' ', $record->status)) }}
            </span>
        </span>
        <span style="font-size:.8rem;color:#94a3b8;">{{ $record->notes ?? '—' }}</span>
    </div>
    @endforeach
</div>

{{ $records->links() }}
@else
<div class="empty-msg">No attendance records yet</div>
@endif
@endsection
