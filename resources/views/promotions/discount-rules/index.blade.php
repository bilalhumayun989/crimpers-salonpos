@extends('layouts.app')
@section('title', 'Discount Rules')
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
.pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700;}
.pill-green{background:#dcfce7;color:#15803d;}
.pill-gray{background:#f1f5f9;color:#64748b;}
.pill-blue{background:#dbeafe;color:#1d4ed8;}
.pill-purple{background:#f3e8ff;color:#7c3aed;}
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
        <div class="promo-title">Discount Rules</div>
        <div class="promo-sub">Automated discount rules applied at checkout</div>
    </div>
    <a href="{{ route('promotions.discount-rules.create') }}" class="btn-solid">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Rule
    </a>
</div>

<div class="table-wrap">
    @if($discountRules->count())
    <table class="promo-table">
        <thead><tr>
            <th>Name</th><th>Type</th><th>Value</th><th>Status</th><th>Valid Period</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @foreach($discountRules as $rule)
        <tr>
            <td>
                <div style="font-weight:600;color:#1e293b;">{{ $rule->name }}</div>
                @if($rule->description)
                    <div style="font-size:.72rem;color:#94a3b8;">{{ Str::limit($rule->description, 50) }}</div>
                @endif
            </td>
            <td>
                <span class="pill pill-purple">{{ ucwords(str_replace('_', ' ', $rule->type)) }}</span>
            </td>
            <td style="font-weight:700;color:#1e293b;">
                @if($rule->type === 'percentage')
                    {{ $rule->value }}%
                @elseif($rule->type === 'fixed_amount')
                    PKR {{ number_format($rule->value, 2) }}
                @elseif($rule->type === 'buy_x_get_y')
                    Buy {{ $rule->buy_quantity }}, Get {{ $rule->get_quantity }}
                @else
                    —
                @endif
            </td>
            <td>
                @if($rule->is_active)
                    <span class="pill pill-green">Active</span>
                @else
                    <span class="pill pill-gray">Inactive</span>
                @endif
            </td>
            <td style="font-size:.82rem;color:#64748b;">
                @if($rule->valid_from && $rule->valid_until)
                    {{ \Carbon\Carbon::parse($rule->valid_from)->format('M d') }} – {{ \Carbon\Carbon::parse($rule->valid_until)->format('M d, Y') }}
                @elseif($rule->valid_from)
                    From {{ \Carbon\Carbon::parse($rule->valid_from)->format('M d, Y') }}
                @elseif($rule->valid_until)
                    Until {{ \Carbon\Carbon::parse($rule->valid_until)->format('M d, Y') }}
                @else
                    Always active
                @endif
            </td>
            <td>
                <a href="{{ route('promotions.discount-rules.edit', $rule) }}" class="action-link">Edit</a>
                <form method="POST" action="{{ route('promotions.discount-rules.destroy', $rule) }}" style="display:inline;" onsubmit="return confirm('Delete this rule?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-del">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if($discountRules->hasPages())<div class="pagination-wrap">{{ $discountRules->links() }}</div>@endif
    @else
    <div class="empty-state">
        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        <p>No discount rules yet</p>
        <a href="{{ route('promotions.discount-rules.create') }}" class="btn-solid">Create First Rule</a>
    </div>
    @endif
</div>
@endsection
