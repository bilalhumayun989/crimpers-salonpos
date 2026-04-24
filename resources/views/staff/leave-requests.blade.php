@extends('layouts.app')
@section('title', $staff->name . ' - Leave Requests')

@section('content')
<style>
.leave-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.staff-info h2{font-size:1.1rem;font-weight:700;color:#1e293b;margin:0;}
.staff-info p{font-size:.85rem;color:#94a3b8;margin:3px 0 0;}
.btn-request{padding:8px 16px;background:#22c55e;color:#fff;border:none;border-radius:10px;text-decoration:none;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;display:inline-block;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;}
.badge-pending{background:#fef3c7;color:#b45309;}
.badge-approved{background:#d1fae5;color:#065f46;}
.badge-rejected{background:#fee2e2;color:#991b1b;}

.empty-msg{text-align:center;padding:40px 20px;color:#94a3b8;font-size:.9rem;}
</style>

{{-- <div class="leave-header">
    <div class="staff-info">
        <h2>{{ $staff->name }} - Leave Requests</h2>
        <p>{{ $staff->position }}</p>
    </div>
    <a href="{{ route('staff.request-leave', $staff) }}" class="btn-request">+ Request Leave</a>
</div> --}}

@if($requests->count())
<div class="table-wrap">
    <div class="table-head">
        <span>Type</span>
        <span>From - To</span>
        <span>Days</span>
        <span>Status</span>
        <span>Approved By</span>
    </div>
    @foreach($requests as $leave)
    <div class="table-row">
        <span>{{ ucfirst(str_replace('_', ' ', $leave->leave_type)) }}</span>
        <span style="font-size:.85rem;color:#64748b;">{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}</span>
        <span style="font-weight:600;">{{ $leave->days }}</span>
        <span>
            <span class="badge {{ $leave->status === 'pending' ? 'badge-pending' : ($leave->status === 'approved' ? 'badge-approved' : 'badge-rejected') }}">
                {{ ucfirst($leave->status) }}
            </span>
        </span>
        <span style="font-size:.85rem;color:#64748b;">{{ optional($leave->approver)->name ?? '—' }}</span>
    </div>
    @endforeach
</div>

{{ $requests->links() }}
@else
<div class="empty-msg">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;opacity:.3;"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    No leave requests yet
</div>
@endif
@endsection
