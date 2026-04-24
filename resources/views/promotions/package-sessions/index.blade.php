@extends("layouts.app")
@section("title", "Package Sessions")
@section("content")
<style>
.promo-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
.promo-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.promo-sub{font-size:.85rem;color:#64748b;}
.btn-solid{padding:9px 18px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:10px;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;font-family:"Outfit",sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(34,197,94,.25);text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-solid:hover{transform:translateY(-1px);}
.table-wrap{background:#fff;border:1px solid #e8f5e9;border-radius:16px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,.04);}
.promo-table{width:100%;border-collapse:collapse;}
.promo-table thead tr{background:#f8fafc;}
.promo-table thead th{padding:12px 18px;font-size:.7rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;text-align:left;border-bottom:1px solid #f1f5f9;}
.promo-table tbody tr{border-bottom:1px solid #f8fafc;transition:background .15s;}
.promo-table tbody tr:hover{background:#fafffe;}
.promo-table tbody tr:last-child{border-bottom:none;}
.promo-table td{padding:13px 18px;font-size:.875rem;color:#374151;vertical-align:middle;}
.pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700;}
.pill-green{background:#dcfce7;color:#15803d;}
.pill-amber{background:#fef3c7;color:#92400e;}
.pill-blue{background:#dbeafe;color:#1d4ed8;}
.pill-gray{background:#f1f5f9;color:#64748b;}
.pill-purple{background:#f3e8ff;color:#7c3aed;}
.cust-cell{display:flex;align-items:center;gap:9px;}
.cust-av{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.prog-track{width:90px;height:7px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:3px;}
.prog-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#22c55e,#16a34a);}
.action-link{color:#22c55e;font-size:.8rem;font-weight:600;text-decoration:none;padding:5px 9px;border-radius:7px;transition:.15s;}
.action-link:hover{background:#f0fdf4;}
.action-del{color:#ef4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 9px;border-radius:7px;font-family:"Outfit",sans-serif;transition:.15s;}
.action-del:hover{background:#fef2f2;}
.empty-state{padding:60px 20px;text-align:center;color:#cbd5e1;}
.empty-state p{font-size:.9rem;font-weight:500;margin-bottom:16px;}
.pagination-wrap{padding:14px 18px;border-top:1px solid #f1f5f9;}
</style>
<div class="promo-header">
  <div><div class="promo-title">Package Sessions</div><div class="promo-sub">Track customer service package usage and remaining sessions</div></div>
  <a href="{{ route("promotions.package-sessions.create") }}" class="btn-solid">+ Add Session</a>
</div>
<div class="table-wrap">
  @if($packageSessions->count())
  <table class="promo-table">
    <thead><tr><th>Customer</th><th>Package</th><th>Sessions</th><th>Progress</th><th>Status</th><th>Expiry</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($packageSessions as $session)
    @php $pct = $session->total_sessions > 0 ? round(($session->used_sessions/$session->total_sessions)*100) : 0; @endphp
    <tr>
      <td><div class="cust-cell"><div class="cust-av">{{ strtoupper(substr($session->customer->name,0,1)) }}</div><div><div style="font-weight:600;color:#1e293b;">{{ $session->customer->name }}</div><div style="font-size:.72rem;color:#94a3b8;">{{ $session->customer->phone??"-" }}</div></div></div></td>
      <td>@if($session->package)<div style="font-weight:600;color:#1e293b;">{{ $session->package->name }}</div><div style="font-size:.72rem;color:#94a3b8;">PKR {{ number_format($session->package->price,2) }}</div>@else<span style="color:#94a3b8;">N/A</span>@endif</td>
      <td><div style="font-weight:700;color:#1e293b;">{{ $session->used_sessions }} / {{ $session->total_sessions }}</div><div style="font-size:.72rem;color:#94a3b8;">{{ $session->remaining_sessions }} remaining</div></td>
      <td><div class="prog-track"><div class="prog-fill" style="width:{{ $pct }}%"></div></div><div style="font-size:.7rem;color:#16a34a;font-weight:600;">{{ $pct }}%</div></td>
      <td>@if(!$session->is_active)<span class="pill pill-gray">Inactive</span>@elseif($session->expiry_date && \Carbon\Carbon::parse($session->expiry_date)->isPast())<span class="pill pill-amber">Expired</span>@elseif($session->remaining_sessions<=0)<span class="pill pill-purple">Completed</span>@else<span class="pill pill-green">Active</span>@endif</td>
      <td style="font-size:.82rem;color:#64748b;">{{ $session->expiry_date ? \Carbon\Carbon::parse($session->expiry_date)->format("M d, Y") : "No expiry" }}</td>
      <td>
        <a href="{{ route("promotions.package-sessions.show",$session) }}" class="action-link">View</a>
        <a href="{{ route("promotions.package-sessions.edit",$session) }}" class="action-link">Edit</a>
        <form method="POST" action="{{ route("promotions.package-sessions.destroy",$session) }}" style="display:inline;" onsubmit="return confirm("Delete?")">@csrf @method("DELETE")<button type="submit" class="action-del">Delete</button></form>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @if($packageSessions->hasPages())<div class="pagination-wrap">{{ $packageSessions->links() }}</div>@endif
  @else
  <div class="empty-state"><p>No package sessions yet</p><a href="{{ route("promotions.package-sessions.create") }}" class="btn-solid">Create First Session</a></div>
  @endif
</div>
@endsection
