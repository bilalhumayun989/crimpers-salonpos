@extends("layouts.app")
@section("title", "Membership Alerts")
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
.cust-cell{display:flex;align-items:center;gap:9px;}
.cust-av{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.action-link{color:#22c55e;font-size:.8rem;font-weight:600;text-decoration:none;padding:5px 9px;border-radius:7px;transition:.15s;}
.action-link:hover{background:#f0fdf4;}
.action-send{color:#3b82f6;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 9px;border-radius:7px;font-family:"Outfit",sans-serif;transition:.15s;}
.action-send:hover{background:#eff6ff;}
.action-del{color:#ef4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 9px;border-radius:7px;font-family:"Outfit",sans-serif;transition:.15s;}
.action-del:hover{background:#fef2f2;}
.empty-state{padding:60px 20px;text-align:center;color:#cbd5e1;}
.empty-state p{font-size:.9rem;font-weight:500;margin-bottom:16px;}
.pagination-wrap{padding:14px 18px;border-top:1px solid #f1f5f9;}
</style>
<div class="promo-header">
  <div><div class="promo-title">Membership Alerts</div><div class="promo-sub">Notify customers about membership expiry and renewals</div></div>
  <a href="{{ route("promotions.membership-alerts.create") }}" class="btn-solid">+ Add Alert</a>
</div>
<div class="table-wrap">
  @if($alerts->count())
  <table class="promo-table">
    <thead><tr><th>Customer</th><th>Alert Type</th><th>Alert Date</th><th>Expiry</th><th>Status</th><th>Message</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($alerts as $alert)
    <tr>
      <td><div class="cust-cell"><div class="cust-av">{{ strtoupper(substr($alert->customer->name,0,1)) }}</div><div><div style="font-weight:600;color:#1e293b;">{{ $alert->customer->name }}</div><div style="font-size:.72rem;color:#94a3b8;">{{ $alert->customer->phone??"-" }}</div></div></div></td>
      <td><span class="pill pill-blue">{{ ucwords(str_replace("_"," ",$alert->alert_type)) }}</span></td>
      <td><div style="font-size:.82rem;">{{ \Carbon\Carbon::parse($alert->alert_date)->format("M d, Y") }}</div>@if(\Carbon\Carbon::parse($alert->alert_date)->isPast() && !$alert->is_sent)<div style="font-size:.7rem;color:#ef4444;font-weight:600;">Overdue</div>@endif</td>
      <td><div style="font-size:.82rem;">{{ \Carbon\Carbon::parse($alert->membership_expiry_date)->format("M d, Y") }}</div>@if(\Carbon\Carbon::parse($alert->membership_expiry_date)->isPast())<div style="font-size:.7rem;color:#ef4444;font-weight:600;">Expired</div>@endif</td>
      <td>@if($alert->is_sent)<span class="pill pill-green">Sent</span>@else<span class="pill pill-amber">Pending</span>@endif</td>
      <td style="font-size:.82rem;color:#64748b;max-width:160px;">{{ $alert->message ? Str::limit($alert->message,35) : "-" }}</td>
      <td>
        <a href="{{ route("promotions.membership-alerts.show",$alert) }}" class="action-link">View</a>
        <a href="{{ route("promotions.membership-alerts.edit",$alert) }}" class="action-link">Edit</a>
        @if(!$alert->is_sent)<button class="action-send" onclick="sendAlert({{ $alert->id }})">Send</button>@endif
        <form method="POST" action="{{ route("promotions.membership-alerts.destroy",$alert) }}" style="display:inline;" onsubmit="return confirm("Delete?")">@csrf @method("DELETE")<button type="submit" class="action-del">Delete</button></form>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @if($alerts->hasPages())<div class="pagination-wrap">{{ $alerts->links() }}</div>@endif
  @else
  <div class="empty-state"><p>No membership alerts yet</p><a href="{{ route("promotions.membership-alerts.create") }}" class="btn-solid">Create First Alert</a></div>
  @endif
</div>
<script>
function sendAlert(id){if(!confirm("Send this alert?"))return;fetch("/promotions/membership-alerts/"+id+"/send",{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector("meta[name=csrf-token]").content,"Content-Type":"application/json"}}).then(r=>r.json()).then(d=>{if(d.success){alert("Sent!");location.reload();}else alert("Failed: "+d.message);}).catch(()=>alert("Error"));}
</script>
@endsection
