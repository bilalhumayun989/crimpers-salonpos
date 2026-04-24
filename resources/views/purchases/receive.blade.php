@extends('layouts.app')
@section('title', 'Receive Purchase Order')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;padding:16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;}
.page-header h2{font-size:1.25rem;font-weight:700;color:#1e293b;margin:0;}
.page-header .po-number{color:#2563eb;font-weight:600;}
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

.receive-row{display:grid;grid-template-columns:3fr 1fr 1fr 1fr 1fr;gap:12px;margin-bottom:12px;align-items:center;padding:12px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;}
.receive-input{padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:.85rem;font-family:'Outfit',sans-serif;width:100%;}

.product-name{font-weight:500;color:#1e293b;}
.quantity{font-size:.85rem;color:#64748b;}
.received-badge{display:inline-block;padding:2px 6px;border-radius:4px;font-size:.7rem;font-weight:600;background:#dcfce7;color:#166534;}
.pending-badge{background:#fee2e2;color:#991b1b;}

.status-summary{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-top:20px;}
.status-summary h4{font-size:1rem;font-weight:700;color:#1e293b;margin:0 0 12px 0;}
.status-item{display:flex;justify-content:space-between;margin-bottom:4px;}
.status-label{color:#64748b;font-size:.85rem;}
.status-value{color:#1e293b;font-weight:500;}
</style>

<div class="page-header">
    <div>
        <h2>Receive Purchase Order</h2>
        <div class="po-number">PO #{{ $purchase->purchase_order_number }}</div>
    </div>
    <a href="{{ route('purchases.show', $purchase) }}" class="btn-back">← Back to Order</a>
</div>

<form method="POST" action="{{ route('purchases.receive', $purchase) }}" id="receiveForm">
    @csrf

    <div class="form-card">
        <div class="form-section">
            <h3>Receipt Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Actual Delivery Date *</label>
                    <input type="date" name="actual_delivery_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea" rows="3" placeholder="Optional notes about this receipt..."></textarea>
                </div>
            </div>
        </div>

        <div class="items-section">
            <div class="items-header">
                <h4>Receive Items</h4>
            </div>

            @foreach($purchase->purchaseItems as $item)
            <div class="receive-row">
                <div class="product-name">{{ $item->product->name }}</div>
                <div>
                    <div class="quantity">Ordered: {{ $item->quantity_ordered }}</div>
                    <div class="quantity">Received: {{ $item->quantity_received ?: 0 }}</div>
                </div>
                <div>
                    <label class="form-label">Receiving Now *</label>
                    <input type="number" name="items[{{ $item->id }}][quantity_receiving]" class="receive-input" min="0" max="{{ $item->quantity_ordered - $item->quantity_received }}" step="1" value="0" required>
                </div>
                <div>
                    <label class="form-label">New Total Received</label>
                    <input type="number" name="items[{{ $item->id }}][new_total_received]" class="receive-input" value="{{ $item->quantity_received ?: 0 }}" readonly>
                </div>
                <div>
                    @if($item->quantity_received >= $item->quantity_ordered)
                        <span class="received-badge">Complete</span>
                    @elseif($item->quantity_received > 0)
                        <span class="received-badge">Partial</span>
                    @else
                        <span class="pending-badge">Pending</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="status-summary">
            <h4>Receipt Summary</h4>
            <div class="status-item">
                <span class="status-label">Items to Receive:</span>
                <span class="status-value" id="itemsReceiving">0</span>
            </div>
            <div class="status-item">
                <span class="status-label">Items Completing:</span>
                <span class="status-value" id="itemsCompleting">0</span>
            </div>
            <div class="status-item">
                <span class="status-label">Order Status After Receipt:</span>
                <span class="status-value" id="finalStatus">{{ ucfirst(str_replace('_', ' ', $purchase->status)) }}</span>
            </div>
        </div>
    </div>

    <div style="text-align:right;">
        <button type="submit" class="btn-submit">Receive Goods</button>
    </div>
</form>

<script>
function updateSummary() {
    let itemsReceiving = 0;
    let itemsCompleting = 0;
    let allComplete = true;

    const rows = document.querySelectorAll('.receive-row');
    rows.forEach(row => {
        const receivingInput = row.querySelector('input[name*="[quantity_receiving]"]');
        const newTotalInput = row.querySelector('input[name*="[new_total_received]"]');
        const ordered = parseInt(row.querySelector('.quantity').textContent.split(': ')[1]);
        const previouslyReceived = parseInt(row.querySelectorAll('.quantity')[1].textContent.split(': ')[1]);
        const receiving = parseInt(receivingInput.value) || 0;
        const newTotal = previouslyReceived + receiving;

        newTotalInput.value = newTotal;

        if (receiving > 0) {
            itemsReceiving++;
        }

        if (newTotal >= ordered) {
            itemsCompleting++;
        } else {
            allComplete = false;
        }
    });

    document.getElementById('itemsReceiving').textContent = itemsReceiving;
    document.getElementById('itemsCompleting').textContent = itemsCompleting;

    let finalStatus = 'Partially Received';
    if (allComplete) {
        finalStatus = 'Received';
    } else if (itemsReceiving === 0) {
        finalStatus = '{{ ucfirst(str_replace("_", " ", $purchase->status)) }}';
    }

    document.getElementById('finalStatus').textContent = finalStatus;
}

// Add event listeners to quantity inputs
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[name*="[quantity_receiving]"]');
    inputs.forEach(input => {
        input.addEventListener('input', updateSummary);
    });
    updateSummary(); // Initial calculation
});
</script>
@endsection