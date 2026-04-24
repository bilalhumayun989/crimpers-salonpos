@extends('layouts.app')
@section('title', 'Leave Requests Management')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}
.filter-tabs{display:flex;gap:8px;margin-left:auto;}
.filter-btn{padding:6px 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:8px;cursor:pointer;font-weight:600;font-size:.85rem;font-family:'Outfit',sans-serif;transition:all .2s;}
.filter-btn.active{background:#22c55e;color:#fff;border-color:#22c55e;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr 1fr 1.2fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr 1fr 1.2fr;gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.staff-name{font-weight:600;color:#1e293b;}
.badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;}
.badge-pending{background:#fef3c7;color:#b45309;}
.badge-approved{background:#d1fae5;color:#065f46;}
.badge-rejected{background:#fee2e2;color:#991b1b;}

.action-btns{display:flex;gap:6px;}
.btn-approve, .btn-reject{padding:5px 10px;border:none;border-radius:6px;cursor:pointer;font-weight:600;font-size:.75rem;font-family:'Outfit',sans-serif;}
.btn-approve{background:#22c55e;color:#fff;}
.btn-reject{background:#ef4444;color:#fff;}

.empty-msg{text-align:center;padding:40px 20px;color:#94a3b8;font-size:.9rem;}
</style>

<div class="page-header">
    <h2>Leave Requests Management</h2>
</div>

@if($requests->count())
<div class="table-wrap">
    <div class="table-head">
        <span>Staff</span>
        <span>Type</span>
        <span>From - To</span>
        <span>Days</span>
        <span>Status</span>
        <span>Actions</span>
    </div>
    @foreach($requests as $leave)
    <div class="table-row">
        <span class="staff-name">{{ $leave->staff->name }}</span>
        <span>{{ ucfirst(str_replace('_', ' ', $leave->leave_type)) }}</span>
        <span style="font-size:.85rem;color:#64748b;">{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}</span>
        <span style="font-weight:600;">{{ $leave->days }}</span>
        <span>
            <span class="badge {{ $leave->status === 'pending' ? 'badge-pending' : ($leave->status === 'approved' ? 'badge-approved' : 'badge-rejected') }}">
                {{ ucfirst($leave->status) }}
            </span>
        </span>
        <span style="display:flex;gap:6px;">
            @if($leave->status === 'pending')
                <form action="{{ route('staff.approve-leave', $leave) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-approve">Approve</button>
                </form>
                <form action="{{ route('staff.reject-leave', $leave) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-reject">Reject</button>
                </form>
            @else
                <span style="font-size:.8rem;color:#94a3b8;padding:5px 10px;">{{ ucfirst($leave->status) }}</span>
            @endif
        </span>
    </div>
    @endforeach
</div>

{{ $requests->links() }}
@else
<div class="empty-msg">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;opacity:.3;"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
    No pending leave requests
</div>
@endif
@endsection
