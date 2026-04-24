@extends('layouts.app')
@section('title', 'Inventory Stock Report')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}

.filters{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;}
.filter-group{display:flex;flex-direction:column;gap:4px;}
.filter-label{font-size:.8rem;font-weight:600;color:#64748b;text-transform:uppercase;}
.filter-select{padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.9rem;font-family:'Outfit',sans-serif;}

.summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px;}
.summary-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;text-align:center;}
.summary-val{font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:4px;}
.summary-lbl{font-size:.8rem;color:#64748b;text-transform:uppercase;}

.table-wrap{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:24px;}
.table-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0;display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr;gap:12px;font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;}
.table-row{padding:12px 16px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr;gap:12px;align-items:center;}
.table-row:last-child{border-bottom:none;}

.product-name{font-weight:600;color:#1e293b;}
.sku{font-size:.75rem;color:#94a3b8;}
.price{font-weight:600;color:#16a34a;}
</style>

<div class="page-header">
    <h2>Inventory Stock Report</h2>
    <div style="display:flex;gap:8px;">
        <button onclick="window.print()" class="btn-view" style="padding:8px 16px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:10px; cursor:pointer; font-weight:600;">Print Report</button>
    </div>
</div>

<div class="summary-grid">
    <div class="summary-card">
        <div class="summary-val">{{ number_format($totalItems) }}</div>
        <div class="summary-lbl">Total Units in Stock</div>
    </div>
    <div class="summary-card">
        <div class="summary-val">PKR {{ number_format($totalValue, 2) }}</div>
        <div class="summary-lbl">Total Inventory Value (Cost)</div>
    </div>
</div>

<form method="GET" class="filters">
    <div class="filter-group">
        <label class="filter-label">Product Type</label>
        <select name="type" class="filter-select" onchange="this.form.submit()">
            <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>All Types</option>
            <option value="retail" {{ request('type') === 'retail' ? 'selected' : '' }}>Retail</option>
            <option value="service_supply" {{ request('type') === 'service_supply' ? 'selected' : '' }}>Service Supply</option>
        </select>
    </div>
    <div class="filter-group">
        <label class="filter-label">Stock Status</label>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Statuses</option>
            <option value="in_stock" {{ request('status') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
            <option value="low_stock" {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
            <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
    </div>
</form>

@if($products->count())
<div class="table-wrap">
    <div class="table-head">
        <span>Product</span>
        <span>Type</span>
        <span>Current Stock</span>
        <span>Cost Price</span>
        <span>Selling Price</span>
        <span>Value (Cost)</span>
    </div>
    @foreach($products as $product)
    <div class="table-row">
        <div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="sku">{{ $product->sku ?: 'No SKU' }}</div>
        </div>
        <span>{{ ucfirst(str_replace('_', ' ', $product->product_type)) }}</span>
        <span style="font-weight:600;{{ $product->current_stock <= $product->min_stock_level ? 'color:#dc2626;' : '' }}">
            {{ $product->current_stock }}
        </span>
        <span>PKR {{ number_format($product->cost_price, 2) }}</span>
        <span class="price">PKR {{ number_format($product->selling_price, 2) }}</span>
        <span style="font-weight:600;">PKR {{ number_format($product->current_stock * $product->cost_price, 2) }}</span>
    </div>
    @endforeach
</div>

{{ $products->links() }}
@else
<div style="text-align:center;padding:40px;color:#94a3b8;background:#fff;border-radius:12px;border:1px solid #e2e8f0;">
    No products found for this report.
</div>
@endif

@endsection
