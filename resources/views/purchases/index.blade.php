@extends('layouts.app')
@section('title', 'Purchase Orders')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}
.btn-add{padding:8px 16px;background:#22c55e;color:#fff;border:none;border-radius:10px;text-decoration:none;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;display:inline-block;}

.filters{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;}
.filter-group{display:flex;flex-direction:column;gap:4px;}
.filter-label{font-size:.8rem;font-weight:600;color:#64748b;text-transform:uppercase;}
.filter-select,.filter-input{padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.9rem;font-family:'Outfit',sans-serif;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:1fr 1.5fr 1fr 1fr 1fr 1fr 1fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:1fr 1.5fr 1fr 1fr 1fr 1fr 1fr;gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.po-number{font-weight:600;color:#2563eb;}
.supplier-name{font-weight:500;color:#1e293b;}
.status-badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;}
.status-ordered{background:#dbeafe;color:#1e40af;}
.status-partially{background:#fef3c7;color:#92400e;}
.status-received{background:#dcfce7;color:#166534;}
.status-cancelled{background:#fee2e2;color:#991b1b;}

.date{font-size:.85rem;color:#64748b;}
.amount{font-weight:600;color:#16a34a;}

.action-btns{display:flex;gap:6px;}
.btn-view,.btn-edit,.btn-receive{padding:5px 10px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;font-weight:600;font-size:.75rem;font-family:'Outfit',sans-serif;}
.btn-view:hover,.btn-edit:hover,.btn-receive:hover{background:#e2e8f0;}
.btn-receive{background:#22c55e;color:#fff;border-color:#22c55e;}
.btn-receive:hover{background:#16a34a;}

.empty-msg{text-align:center;padding:40px 20px;color:#94a3b8;font-size:.9rem;}
</style>

<div class="page-header">
    <h2>Purchase Orders</h2>
    <a href="{{ route('purchases.create') }}" class="btn-add">+ New Purchase Order</a>
</div>

<form method="GET" class="filters">
    <div class="filter-group">
        <label class="filter-label">Status</label>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Orders</option>
            <option value="ordered" {{ request('status') === 'ordered' ? 'selected' : '' }}>Ordered</option>
            <option value="partially_received" {{ request('status') === 'partially_received' ? 'selected' : '' }}>Partially Received</option>
            <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Received</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <div class="filter-group">
        <label class="filter-label">Supplier</label>
        <select name="supplier_id" class="filter-select" onchange="this.form.submit()">
            <option value="">All Suppliers</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label class="filter-label">Search PO #</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Purchase order number..." class="filter-input" onkeypress="if(event.key === 'Enter') this.form.submit()">
    </div>
</form>

@if($purchases->count())
<div class="table-wrap">
    <div class="table-head">
        <span>PO Number</span>
        <span>Supplier</span>
        <span>Order Date</span>
        <span>Expected</span>
        <span>Status</span>
        <span>Amount</span>
        <span>Actions</span>
    </div>
    @foreach($purchases as $purchase)
    <div class="table-row">
        <span class="po-number">{{ $purchase->purchase_order_number }}</span>
        <span class="supplier-name">{{ $purchase->supplier->name }}</span>
        <span class="date">{{ $purchase->order_date->format('M d, Y') }}</span>
        <span class="date">{{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('M d, Y') : '—' }}</span>
        <span>
            <span class="status-badge status-{{ $purchase->status }}">
                {{ ucfirst(str_replace('_', ' ', $purchase->status)) }}
            </span>
        </span>
        <span class="amount">PKR {{ number_format($purchase->total_amount, 2) }}</span>
        <span class="action-btns">
            <a href="{{ route('purchases.show', $purchase) }}" class="btn-view">View</a>
            @if($purchase->status === 'ordered')
                <a href="{{ route('purchases.edit', $purchase) }}" class="btn-edit">Edit</a>
                <a href="{{ route('purchases.receive', $purchase) }}" class="btn-receive">Receive</a>
            @elseif($purchase->status === 'partially_received')
                <a href="{{ route('purchases.receive', $purchase) }}" class="btn-receive">Complete</a>
            @endif
        </span>
    </div>
    @endforeach
</div>

{{ $purchases->links() }}
@else
<div class="empty-msg">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;opacity:.3;"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
    No purchase orders found matching your criteria
</div>
@endif
@endsection