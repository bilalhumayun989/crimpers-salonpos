@extends('layouts.app')
@section('title', 'Create Purchase Order')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}
.btn-back,.btn-submit{padding:8px 16px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;display:inline-block;}
.btn-submit{background:#22c55e;color:#fff;border-color:#22c55e;}
.btn-submit:hover{background:#16a34a;}

.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:24px;margin-bottom:24px;}
.form-section{margin-bottom:24px;}
.form-section h3{font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 16px 0;}

.form-row{display:flex;gap:16px;margin-bottom:16px;flex-wrap:wrap;}
.form-group{flex:1;min-width:200px;}
.form-label{display:block;font-size:.85rem;font-weight:600;color:#374151;margin-bottom:4px;}
.form-input,.form-select,.form-textarea{padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:.9rem;font-family:'Outfit',sans-serif;width:100%;box-sizing:border-box;}
.form-input:focus,.form-select:focus,.form-textarea:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1);}

.items-section{background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;}
.items-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.items-header h4{font-size:1rem;font-weight:700;color:#1e293b;margin:0;}
.btn-add-item{padding:6px 12px;background:#3b82f6;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;}

.item-row{display:grid;grid-template-columns:3fr 1fr 1fr 1fr auto;gap:12px;margin-bottom:12px;align-items:end;}
.item-input,.item-select{padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:.85rem;font-family:'Outfit',sans-serif;}
.btn-remove-item{padding:8px 12px;background:#ef4444;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;}

.total-section{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-top:20px;text-align:right;}
.total-amount{font-size:1.25rem;font-weight:700;color:#16a34a;}
</style>

<div class="page-header">
    <h2>Create Purchase Order</h2>
    <a href="{{ route('purchases.index') }}" class="btn-back">← Back to Orders</a>
</div>

<form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
    @csrf

    <div class="form-card">
        <div class="form-section">
            <h3>Order Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Supplier *</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Select a supplier...</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Order Date *</label>
                    <input type="date" name="order_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Expected Delivery Date</label>
                    <input type="date" name="expected_delivery_date" class="form-input">
                </div>
            </div>
        </div>

        <div class="items-section">
            <div class="items-header">
                <h4>Order Items</h4>
                <button type="button" class="btn-add-item" onclick="addItem()">+ Add Item</button>
            </div>

            <div id="itemsContainer">
                <div class="item-row" data-item="1">
                    <div>
                        <label class="form-label">Product *</label>
                        <select name="items[1][product_id]" class="item-select" onchange="updateItemPrice(1)" required>
                            <option value="">Select product...</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="items[1][quantity_ordered]" class="item-input" min="1" step="1" onchange="calculateTotal()" required>
                    </div>
                    <div>
                        <label class="form-label">Unit Cost *</label>
                        <input type="number" name="items[1][unit_cost]" class="item-input" min="0" step="0.01" onchange="calculateTotal()" required>
                    </div>
                    <div>
                        <label class="form-label">Line Total</label>
                        <input type="number" name="items[1][line_total]" class="item-input" readonly>
                    </div>
                    <button type="button" class="btn-remove-item" onclick="removeItem(1)">Remove</button>
                </div>
            </div>
        </div>

        <div class="total-section">
            <div class="total-amount">Total: $<span id="totalAmount">0.00</span></div>
        </div>
    </div>

    <div style="text-align:right;">
        <button type="submit" class="btn-submit">Create Purchase Order</button>
    </div>
</form>

<script>
let itemCount = 1;

function addItem() {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.setAttribute('data-item', itemCount);
    newItem.innerHTML = `
        <div>
            <label class="form-label">Product *</label>
            <select name="items[${itemCount}][product_id]" class="item-select" onchange="updateItemPrice(${itemCount})" required>
                <option value="">Select product...</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Quantity *</label>
            <input type="number" name="items[${itemCount}][quantity_ordered]" class="item-input" min="1" step="1" onchange="calculateTotal()" required>
        </div>
        <div>
            <label class="form-label">Unit Cost *</label>
            <input type="number" name="items[${itemCount}][unit_cost]" class="item-input" min="0" step="0.01" onchange="calculateTotal()" required>
        </div>
        <div>
            <label class="form-label">Line Total</label>
            <input type="number" name="items[${itemCount}][line_total]" class="item-input" readonly>
        </div>
        <button type="button" class="btn-remove-item" onclick="removeItem(${itemCount})">Remove</button>
    `;
    container.appendChild(newItem);
}

function removeItem(itemId) {
    const item = document.querySelector(`[data-item="${itemId}"]`);
    if (item) {
        item.remove();
        calculateTotal();
    }
}

function updateItemPrice(itemId) {
    const select = document.querySelector(`[data-item="${itemId}"] select`);
    const selectedOption = select.options[select.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0;
    const costInput = document.querySelector(`[data-item="${itemId}"] input[name*="[unit_cost]"]`);
    if (costInput && price > 0) {
        costInput.value = price;
        calculateTotal();
    }
}

function calculateTotal() {
    let total = 0;
    const items = document.querySelectorAll('.item-row');
    items.forEach(item => {
        const quantity = parseFloat(item.querySelector('input[name*="[quantity_ordered]"]').value) || 0;
        const unitCost = parseFloat(item.querySelector('input[name*="[unit_cost]"]').value) || 0;
        const lineTotal = quantity * unitCost;
        item.querySelector('input[name*="[line_total]"]').value = lineTotal.toFixed(2);
        total += lineTotal;
    });
    document.getElementById('totalAmount').textContent = total.toFixed(2);
}
</script>
@endsection