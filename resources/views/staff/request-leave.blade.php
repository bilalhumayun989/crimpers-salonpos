@extends('layouts.app')
@section('title', 'Request Leave - ' . $staff->name)

@section('content')
<div style="max-width:600px;margin:0 auto;padding:24px 0;">
    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.5rem;font-weight:800;color:#0f172a;margin:0 0 4px;">Request Leave</h1>
        <p style="font-size:.9rem;color:#64748b;margin:0;">{{ $staff->name }} - {{ $staff->position }}</p>
    </div>

    <form action="{{ route('staff.store-leave-request', $staff) }}" method="POST" style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);">
        @csrf

        <div style="margin-bottom:16px;">
            <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Leave Type *</label>
            <select name="leave_type" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;">
                <option value="">Select leave type</option>
                <option value="sick">Sick Leave</option>
                <option value="vacation">Vacation</option>
                <option value="personal">Personal Leave</option>
                <option value="unpaid">Unpaid Leave</option>
            </select>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
            </div>
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Reason</label>
            <textarea name="reason" rows="4" style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;resize:none;" placeholder="Provide details for your leave request...">{{ old('reason') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;">
            <a href="{{ route('staff.leave-requests', $staff) }}" style="flex:1;padding:10px;border:1px solid #e2e8f0;border-radius:10px;text-align:center;color:#64748b;font-weight:600;text-decoration:none;font-family:'Outfit',sans-serif;font-size:.9rem;transition:.2s;">Cancel</a>
            <button type="submit" style="flex:1;padding:10px;background:linear-gradient(135deg,#22c55e,#16a34a);border:none;border-radius:10px;color:#fff;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;font-size:.9rem;box-shadow:0 3px 10px rgba(34,197,94,.25);transition:.2s;">Submit Request</button>
        </div>
    </form>
</div>
@endsection
