@extends('layouts.app')
@section('title', 'Supplier Details')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}
.page-header .supplier-name{color:#2563eb;font-weight:600;}
.btn-back,.btn-edit,.btn-delete{padding:8px 16px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;display:inline-block;}
.btn-edit{background:#3b82f6;color:#fff;border-color:#3b82f6;}
.btn-edit:hover{background:#2563eb;}
.btn-delete{background:#ef4444;color:#fff;border-color:#ef4444;}
.btn-delete:hover{background:#dc2626;}

.details-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-bottom:24px;}
.detail-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;}
.detail-card h3{font-size:1rem;font-weight:700;color:#1e293b;margin:0 0 12px 0;}
.detail-row{display:flex;justify-content:space-between;margin-bottom:8px;}
.detail-label{color:#64748b;font-size:.85rem;}
.detail-value{color:#1e293b;font-weight:500;}

.status-badge{display:inline-block;padding:4px 10px;border-radius:99px;font-size:.75rem;font-weight:600;margin-bottom:16px;}
.status-active{background:#dcfce7;color:#166534;}
.status-inactive{background:#fee2e2;color:#991b1b;}

.stats-section{background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:24px;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;}
.stat-card{text-align:center;padding:16px;background:#fff;border-radius:8px;border:1px solid #e2e8f0;}
.stat-value{font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:4px;}
.stat-label{font-size:.8rem;color:#64748b;text-transform:uppercase;}

.products-section{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.products-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.products-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:12px;align-items:center;}
.products-row:last-child{border-bottom:none;}

.product-name{font-weight:500;color:#1e293b;}
.product-price{color:#16a34a;font-weight:600;}
.product-stock{font-size:.85rem;color:#64748b;}

.purchases-section{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.purchases-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.purchases-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;align-items:center;}
.purchases-row:last-child{border-bottom:none;}

.po-number{font-weight:600;color:#2563eb;}
.purchase-date{font-size:.85rem;color:#64748b;}
.purchase-amount{font-weight:600;color:#16a34a;}
.status-badge-small{display:inline-block;padding:2px 6px;border-radius:4px;font-size:.7rem;font-weight:600;}
.status-ordered{background:#dbeafe;color:#1e40af;}
.status-partially{background:#fef3c7;color:#92400e;}
.status-received{background:#dcfce7;color:#166534;}
.status-cancelled{background:#fee2e2;color:#991b1b;}
</style>

<div class="page-header">
    <div>
        <h2>Supplier Details</h2>
        <div class="supplier-name">{{ $supplier->name }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('suppliers.index') }}" class="btn-back">← Back to Suppliers</a>
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn-edit">Edit Supplier</a>
        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">Delete Supplier</button>
        </form>
    </div>
</div>

<span class="status-badge status-{{ $supplier->is_active ? 'active' : 'inactive' }}">
    {{ $supplier->is_active ? 'Active' : 'Inactive' }}
</span>

<div class="details-grid">
    <div class="detail-card">
        <h3>Contact Information</h3>
        <div class="detail-row">
            <span class="detail-label">Contact Person:</span>
            <span class="detail-value">{{ $supplier->contact_person ?: 'Not specified' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value">{{ $supplier->email ?: 'Not specified' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Phone:</span>
            <span class="detail-value">{{ $supplier->phone ?: 'Not specified' }}</span>
        </div>
    </div>

    <div class="detail-card">
        <h3>Business Details</h3>
        <div class="detail-row">
            <span class="detail-label">Address:</span>
            <span class="detail-value">{{ $supplier->address ?: 'Not specified' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Payment Terms:</span>
            <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $supplier->payment_terms)) }}</span>
        </div>
    </div>
</div>

<div class="stats-section">
    <h3 style="margin:0 0 16px 0;font-size:1.1rem;font-weight:700;color:#1e293b;">Supplier Statistics</h3>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $supplier->products->count() }}</div>
            <div class="stat-label">Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $supplier->purchases->count() }}</div>
            <div class="stat-label">Purchase Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">PKR {{ number_format($supplier->purchases->sum('total_amount'), 2) }}</div>
            <div class="stat-label">Total Purchased</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $supplier->products->where('current_stock', '<=', \DB::raw('min_stock_level'))->count() }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>
    </div>
</div>

@if($supplier->products->count())
<div class="products-section">
    <div class="products-head">
        <span>Product</span>
        <span>Current Stock</span>
        <span>Selling Price</span>
        <span>Status</span>
    </div>
    @foreach($supplier->products as $product)
    <div class="products-row">
        <span class="product-name">{{ $product->name }}</span>
        <span class="product-stock">{{ $product->current_stock }}</span>
        <span class="product-price">PKR {{ number_format($product->selling_price, 2) }}</span>
        <span>
            @if($product->isLowStock())
                <span class="status-badge-small status-ordered">Low Stock</span>
            @else
                <span class="status-badge-small status-received">In Stock</span>
            @endif
        </span>
    </div>
    @endforeach
</div>
@endif

@if($supplier->purchases->count())
<div class="purchases-section">
    <div class="purchases-head">
        <span>PO Number</span>
        <span>Order Date</span>
        <span>Status</span>
        <span>Amount</span>
        <span>Delivery</span>
    </div>
    @foreach($supplier->purchases()->latest()->limit(10)->get() as $purchase)
    <div class="purchases-row">
        <span class="po-number">{{ $purchase->purchase_order_number }}</span>
        <span class="purchase-date">{{ $purchase->order_date->format('M d, Y') }}</span>
        <span>
            <span class="status-badge-small status-{{ $purchase->status }}">{{ ucfirst(str_replace('_', ' ', $purchase->status)) }}</span>
        </span>
        <span class="purchase-amount">PKR {{ number_format($purchase->total_amount, 2) }}</span>
        <span class="purchase-date">{{ $purchase->actual_delivery_date ? $purchase->actual_delivery_date->format('M d, Y') : 'Pending' }}</span>
    </div>
    @endforeach
</div>
@endif
@endsection