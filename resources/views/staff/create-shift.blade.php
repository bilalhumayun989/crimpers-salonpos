@extends('layouts.app')
@section('title', 'Schedule Shift for ' . $staff->name)

@section('content')
<div style="max-width:600px;margin:0 auto;padding:24px 0;">
    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.5rem;font-weight:800;color:#0f172a;margin:0 0 4px;">Schedule Shift</h1>
        <p style="font-size:.9rem;color:#64748b;margin:0;">{{ $staff->name }} - {{ $staff->position }}</p>
    </div>

    <form action="{{ route('staff.store-shift', $staff) }}" method="POST" style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);">
        @csrf

        <div style="margin-bottom:16px;">
            <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Shift Date *</label>
            <input type="date" name="shift_date" value="{{ old('shift_date') }}" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Start Time *</label>
                <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
            </div>
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">End Time *</label>
                <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Shift Type *</label>
                <select name="shift_type" required style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;">
                    <option value="morning" selected>Morning (8am - 12pm)</option>
                    <option value="afternoon">Afternoon (12pm - 5pm)</option>
                    <option value="evening">Evening (5pm - 9pm)</option>
                    <option value="full_day">Full Day (8am - 5pm)</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Break Duration (mins)</label>
                <input type="number" name="break_duration" value="{{ old('break_duration', 30) }}" min="0" style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;" />
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:.9rem;font-weight:600;color:#334155;margin-bottom:6px;">Notes</label>
            <textarea name="notes" rows="3" style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:10px;font-family:'Outfit',sans-serif;font-size:.9rem;box-sizing:border-box;resize:none;">{{ old('notes') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;">
            <a href="{{ route('staff.shifts', $staff) }}" style="flex:1;padding:10px;border:1px solid #e2e8f0;border-radius:10px;text-align:center;color:#64748b;font-weight:600;text-decoration:none;font-family:'Outfit',sans-serif;font-size:.9rem;transition:.2s;">Cancel</a>
            <button type="submit" style="flex:1;padding:10px;background:linear-gradient(135deg,#22c55e,#16a34a);border:none;border-radius:10px;color:#fff;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;font-size:.9rem;box-shadow:0 3px 10px rgba(34,197,94,.25);transition:.2s;">Schedule Shift</button>
        </div>
    </form>
</div>
@endsection
