@extends('layouts.app')
@section('title', 'Coupons')
@section('content')
<style>
.promo-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
.promo-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.promo-sub{font-size:.85rem;color:#64748b;}
.btn-solid{padding:9px 18px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:10px;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(34,197,94,.25);text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-solid:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(34,197,94,.35);}
.table-wrap{background:#fff;border:1px solid #e8f5e9;border-radius:16px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,.04);}
.promo-table{width:100%;border-collapse:collapse;}
.promo-table thead tr{background:#f8fafc;}
.promo-table thead th{padding:12px 18px;font-size:.7rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;text-align:left;border-bottom:1px solid #f1f5f9;}
.promo-table tbody tr{border-bottom:1px solid #f8fafc;transition:background .15s;}
.promo-table tbody tr:hover{background:#fafffe;}
.promo-table tbody tr:last-child{border-bottom:none;}
.promo-table td{padding:13px 18px;font-size:.875rem;color:#374151;vertical-align:middle;}
.code-chip{display:inline-block;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;font-family:monospace;font-size:.82rem;font-weight:700;padding:4px 12px;border-radius:8px;letter-spacing:.06em;}
.pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700;}
.pill-green{background:#dcfce7;color:#15803d;}
.pill-amber{background:#fef3c7;color:#92400e;}
.pill-gray{background:#f1f5f9;color:#64748b;}
.pill-blue{background:#dbeafe;color:#1d4ed8;}
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
        <div class="promo-title">Coupons</div>
        <div class="promo-sub">Manage discount coupons for customers</div>
    </div>
    <a href="{{ route('promotions.coupons.create') }}" class="btn-solid">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Coupon
    </a>
</div>

<div class="table-wrap">
    @if($coupons->count())
    <table class="promo-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Usage</th>
                <th>Status</th>
                <th>Valid Until</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <td><span class="code-chip">{{ $coupon->code }}</span></td>
            <td>
                <div style="font-weight:600;color:#1e293b;">{{ $coupon->name }}</div>
                @if($coupon->description)
                    <div style="font-size:.72rem;color:#94a3b8;">{{ Str::limit($coupon->description, 40) }}</div>
                @endif
            </td>
            <td><span class="pill pill-blue">{{ ucwords(str_replace('_', ' ', $coupon->type)) }}</span></td>
            <td>
                <div style="font-weight:700;color:#1e293b;">
                    @if($coupon->type === 'percentage')
                        {{ $coupon->value }}%
                    @else
                        PKR {{ number_format($coupon->value, 2) }}
                    @endif
                </div>
                @if($coupon->minimum_purchase)
                    <div style="font-size:.72rem;color:#94a3b8;">Min PKR {{ number_format($coupon->minimum_purchase, 2) }}</div>
                @endif
            </td>
            <td>
                @if($coupon->usage_limit)
                    <div style="font-weight:600;">{{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit }}</div>
                    @if($coupon->usage_limit_per_customer)
                        <div style="font-size:.72rem;color:#94a3b8;">{{ $coupon->usage_limit_per_customer }}/customer</div>
                    @endif
                @else
                    <span style="color:#94a3b8;font-size:.82rem;">Unlimited</span>
                @endif
            </td>
            <td>
                @if(!$coupon->is_active)
                    <span class="pill pill-gray">Inactive</span>
                @elseif($coupon->valid_until && \Carbon\Carbon::parse($coupon->valid_until)->isPast())
                    <span class="pill pill-amber">Expired</span>
                @else
                    <span class="pill pill-green">Active</span>
                @endif
            </td>
            <td style="font-size:.82rem;color:#64748b;">
                {{ $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('M d, Y') : 'No limit' }}
            </td>
            <td>
                <a href="{{ route('promotions.coupons.edit', $coupon) }}" class="action-link">Edit</a>
                <form method="POST" action="{{ route('promotions.coupons.destroy', $coupon) }}" style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-del">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if($coupons->hasPages())
        <div class="pagination-wrap">{{ $coupons->links() }}</div>
    @endif
    @else
    <div class="empty-state">
        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/>
            <path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
        </svg>
        <p>No coupons yet</p>
        <a href="{{ route('promotions.coupons.create') }}" class="btn-solid">Create First Coupon</a>
    </div>
    @endif
</div>
@endsection
