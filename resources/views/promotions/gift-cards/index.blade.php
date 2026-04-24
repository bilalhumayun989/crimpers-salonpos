@extends('layouts.app')
@section('title', 'Gift Cards')
@section('content')
<style>
.promo-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
.promo-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.promo-sub{font-size:.85rem;color:#64748b;}
.btn-solid{padding:9px 18px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:10px;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(34,197,94,.25);text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-solid:hover{transform:translateY(-1px);}
.table-wrap{background:#fff;border:1px solid #e8f5e9;border-radius:16px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,.04);}
.promo-table{width:100%;border-collapse:collapse;}
.promo-table thead tr{background:#f8fafc;}
.promo-table thead th{padding:12px 18px;font-size:.7rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;text-align:left;border-bottom:1px solid #f1f5f9;}
.promo-table tbody tr{border-bottom:1px solid #f8fafc;transition:background .15s;}
.promo-table tbody tr:hover{background:#fafffe;}
.promo-table tbody tr:last-child{border-bottom:none;}
.promo-table td{padding:13px 18px;font-size:.875rem;color:#374151;vertical-align:middle;}
.code-chip{display:inline-block;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;font-family:monospace;font-size:.82rem;font-weight:700;padding:3px 10px;border-radius:7px;letter-spacing:.04em;}
.pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700;}
.pill-green{background:#dcfce7;color:#15803d;}
.pill-red{background:#fee2e2;color:#b91c1c;}
.pill-amber{background:#fef3c7;color:#92400e;}
.pill-gray{background:#f1f5f9;color:#64748b;}
.pill-blue{background:#dbeafe;color:#1d4ed8;}
.cust-cell{display:flex;align-items:center;gap:9px;}
.cust-av{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.action-link{color:#22c55e;font-size:.8rem;font-weight:600;text-decoration:none;padding:5px 9px;border-radius:7px;transition:.15s;}
.action-link:hover{background:#f0fdf4;}
.action-del{color:#ef4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 9px;border-radius:7px;font-family:'Outfit',sans-serif;transition:.15s;}
.action-del:hover{background:#fef2f2;}
.empty-state{padding:60px 20px;text-align:center;color:#cbd5e1;}
.empty-state svg{margin:0 auto 14px;display:block;opacity:.3;}
.empty-state p{font-size:.9rem;font-weight:500;margin-bottom:16px;}
.pagination-wrap{padding:14px 18px;border-top:1px solid #f1f5f9;}
</style>

<div class="promo-header">
    <div>
        <div class="promo-title">Gift Cards</div>
        <div class="promo-sub">Manage prepaid gift cards for customers</div>
    </div>
    <a href="{{ route('promotions.gift-cards.create') }}" class="btn-solid">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Gift Card
    </a>
</div>

<div class="table-wrap">
    @if($giftCards->count())
    <table class="promo-table">
        <thead><tr>
            <th>Card Number</th><th>Customer</th><th>Balance</th><th>Status</th><th>Expiry</th><th>Issued</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @foreach($giftCards as $gc)
        <tr>
            <td>
                <span class="code-chip">{{ $gc->card_number }}</span>
                @if($gc->pin)<div style="font-size:.7rem;color:#94a3b8;margin-top:3px;">PIN: {{ $gc->pin }}</div>@endif
            </td>
            <td>
                @if($gc->customer)
                <div class="cust-cell">
                    <div class="cust-av">{{ strtoupper(substr($gc->customer->name,0,1)) }}</div>
                    <div>
                        <div style="font-weight:600;color:#1e293b;">{{ $gc->customer->name }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">{{ $gc->customer->phone??'No phone' }}</div>
                    </div>
                </div>
                @else<span style="color:#94a3b8;font-size:.82rem;">Unassigned</span>@endif
            </td>
            <td>
                <div style="font-weight:700;color:#16a34a;">PKR {{ number_format($gc->current_balance,2) }}</div>
                @if($gc->initial_balance!=$gc->current_balance)<div style="font-size:.72rem;color:#94a3b8;">Initial PKR {{ number_format($gc->initial_balance,2) }}</div>@endif
            </td>
            <td>
                @if(!$gc->is_active)<span class="pill pill-red">Inactive</span>
                @elseif($gc->expiry_date && \Carbon\Carbon::parse($gc->expiry_date)->isPast())<span class="pill pill-amber">Expired</span>
                @elseif($gc->current_balance<=0)<span class="pill pill-gray">Used</span>
                @else<span class="pill pill-green">Active</span>@endif
            </td>
            <td style="font-size:.82rem;color:#64748b;">{{ $gc->expiry_date ? \Carbon\Carbon::parse($gc->expiry_date)->format('M d, Y') : 'No expiry' }}</td>
            <td style="font-size:.82rem;color:#64748b;">
                {{ \Carbon\Carbon::parse($gc->issued_date)->format('M d, Y') }}
                @if($gc->issuer)<div style="font-size:.7rem;color:#94a3b8;">By {{ $gc->issuer->name }}</div>@endif
            </td>
            <td>
                <a href="{{ route('promotions.gift-cards.show',$gc) }}" class="action-link">View</a>
                <a href="{{ route('promotions.gift-cards.edit',$gc) }}" class="action-link">Edit</a>
                <form method="POST" action="{{ route('promotions.gift-cards.destroy',$gc) }}" style="display:inline;" onsubmit="return confirm('Delete this gift card?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-del">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if($giftCards->hasPages())<div class="pagination-wrap">{{ $giftCards->links() }}</div>@endif
    @else
    <div class="empty-state">
        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
        <p>No gift cards yet</p>
        <a href="{{ route('promotions.gift-cards.create') }}" class="btn-solid">Create First Gift Card</a>
    </div>
    @endif
</div>
@endsection
