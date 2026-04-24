@extends('layouts.app')
@section('title', 'Staff Salary & Performance')
@section('content')
<style>
.dash-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
.dash-title { font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.salary-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
.salary-table th { text-align: left; padding: 12px 16px; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
.salary-row { background: #f8fafc; transition: 0.2s; }
.salary-row:hover { background: #f1f5f9; transform: translateY(-1px); }
.salary-row td { padding: 16px; font-size: 0.875rem; border-top: 1px solid transparent; border-bottom: 1px solid transparent; }
.salary-row td:first-child { border-left: 1px solid transparent; border-radius: 12px 0 0 12px; }
.salary-row td:last-child { border-right: 1px solid transparent; border-radius: 0 12px 12px 0; }

.amt-badge { background: #fffdf0; border: 1px solid #F7DF79; color: #a07800; padding: 4px 10px; border-radius: 99px; font-weight: 700; font-size: 0.8rem; }
.perf-badge { background: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; padding: 4px 10px; border-radius: 99px; font-weight: 700; font-size: 0.8rem; }
.rating-stars { color: #fbbf24; }
</style>

<div class="dash-card">
    <div class="dash-title">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        Staff Salary & Performance Tracking
    </div>

    <table class="salary-table">
        <thead>
            <tr>
                <th>Staff Member</th>
                <th>Performance</th>
                <th>Base Salary</th>
                <th>Earned Commission</th>
                <th>Total Payable</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr class="salary-row">
                <td>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:36px; height:36px; border-radius:10px; background:#1e293b; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.8rem;">
                            {{ strtoupper(substr($s->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700; color:#1e293b;">{{ $s->name }}</div>
                            <div style="font-size:0.7rem; color:#64748b;">{{ $s->position }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="rating-stars">
                        @for($i=1; $i<=5; $i++)
                            <span style="{{ $i <= $s->average_rating ? 'color:#fbbf24' : 'color:#e2e8f0' }}">★</span>
                        @endfor
                        <span style="font-size:0.75rem; color:#64748b; margin-left:4px;">({{ $s->average_rating }})</span>
                    </div>
                    <div style="font-size:0.65rem; color:#94a3b8; margin-top:2px;">{{ $s->rating_count }} reviews</div>
                </td>
                <td><span style="font-weight:600;">PKR {{ number_format($s->base_salary, 2) }}</span></td>
                <td><span class="amt-badge">+ PKR {{ number_format($s->total_earned_commission, 2) }}</span></td>
                <td><span style="font-weight:800; color:#16a34a; font-size:1rem;">PKR {{ number_format($s->base_salary + $s->total_earned_commission, 2) }}</span></td>
                <td>
                    <a href="{{ route('staff.show', $s) }}" class="perf-badge" style="text-decoration:none;">View Full Stats</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
