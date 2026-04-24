@extends('layouts.app')
@section('title', 'Adjust Stock — ' . $product->name)
@section('content')
<style>
.adj-wrap{max-width:560px;margin:0 auto;}
.adj-header{display:flex;align-items:center;gap:16px;margin-bottom:24px;padding:16px 20px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;}
.adj-header h2{font-size:1.15rem;font-weight:800;color:#1e293b;margin:0;}
.adj-header .sub{font-size:.82rem;color:#64748b;margin-top:2px;}
.btn-back{padding:8px 16px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;font-weight:600;font-size:.85rem;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;}
.btn-back:hover{background:#e2e8f0;color:#1e293b;}

.stock-badge{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:16px;}
.stock-num{font-size:2rem;font-weight:800;color:#16a34a;line-height:1;}
.stock-lbl{font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-top:3px;}

.adj-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;}
.field-group{margin-bottom:18px;}
.field-label{display:block;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:8px;}
.field-input{width:100%;padding:11px 14px;border-radius:10px;border:1.5px solid #e2e8f0;font-size:.95rem;font-family:inherit;color:#1e293b;background:#f8fafc;outline:none;transition:.2s;}
.field-input:focus{border-color:#f59e0b;background:#fff;box-shadow:0 0 0 3px rgba(245,158,11,.1);}

.type-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:18px;}
.type-btn{padding:11px 8px;border-radius:11px;border:1.5px solid #e2e8f0;background:#f8fafc;font-size:.82rem;font-weight:700;cursor:pointer;font-family:inherit;color:#64748b;transition:.2s;display:flex;flex-direction:column;align-items:center;gap:5px;}
.type-btn:hover{border-color:#fcd34d;color:#92400e;background:#fffbeb;}
.type-btn.active{background:#fef3c7;border-color:#f59e0b;color:#92400e;}
.type-btn svg{width:20px;height:20px;}

.preview-box{background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:11px;padding:14px 18px;margin-bottom:18px;display:none;}
.preview-box.show{display:flex;align-items:center;justify-content:space-between;}
.preview-old{font-size:.85rem;color:#64748b;}
.preview-arrow{color:#94a3b8;}
.preview-new{font-size:1.2rem;font-weight:800;color:#1e293b;}

.btn-submit{width:100%;padding:13px;border-radius:11px;border:none;cursor:pointer;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:.95rem;font-weight:800;font-family:inherit;transition:.22s;box-shadow:0 4px 14px rgba(245,158,11,.25);}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(245,158,11,.35);}

.alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;font-size:.88rem;}
.alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;font-size:.88rem;}
</style>

<div class="adj-wrap">

  {{-- Header --}}
  <div class="adj-header">
    <a href="{{ route('products.show', $product) }}" class="btn-back">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
      Back
    </a>
    <div>
      <h2>Adjust Stock</h2>
      <div class="sub">{{ $product->name }} &bull; SKU: {{ $product->sku ?: 'N/A' }}</div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
  @endif

  {{-- Current stock badge --}}
  <div class="stock-badge">
    <div>
      <div class="stock-num">{{ $product->current_stock }}</div>
      <div class="stock-lbl">Current Stock</div>
    </div>
    @if($product->min_stock_level)
    <div style="border-left:1px solid #bbf7d0; padding-left:16px;">
      <div class="stock-num" style="color:#94a3b8;">{{ $product->min_stock_level }}</div>
      <div class="stock-lbl">Min Level</div>
    </div>
    @endif
  </div>

  {{-- Form --}}
  <div class="adj-card">
    <form method="POST" action="{{ route('products.adjust-stock', $product) }}" id="adj-form">
      @csrf

      {{-- Type selector --}}
      <div class="field-group">
        <span class="field-label">Adjustment Type</span>
        <div class="type-grid">
          <button type="button" class="type-btn active" data-type="add" onclick="selectType(this)">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Add Stock
          </button>
          <button type="button" class="type-btn" data-type="subtract" onclick="selectType(this)">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Remove
          </button>
          <button type="button" class="type-btn" data-type="set" onclick="selectType(this)">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Set to Value
          </button>
        </div>
        <input type="hidden" name="adjustment_type" id="adjustment_type" value="add">
      </div>

      {{-- Quantity --}}
      <div class="field-group">
        <label class="field-label" for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="field-input" min="0" value="{{ old('quantity', 0) }}" required placeholder="Enter quantity">
      </div>

      {{-- Live preview --}}
      <div class="preview-box" id="preview-box">
        <div>
          <div class="preview-old">Current: <strong>{{ $product->current_stock }}</strong></div>
        </div>
        <span class="preview-arrow">→</span>
        <div>
          <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;">New Stock</div>
          <div class="preview-new" id="preview-new">{{ $product->current_stock }}</div>
        </div>
      </div>

      {{-- Reason --}}
      <div class="field-group">
        <label class="field-label" for="reason">Reason / Notes</label>
        <input type="text" name="reason" id="reason" class="field-input" value="{{ old('reason') }}" required placeholder="e.g. New delivery, Damaged goods, Manual correction...">
      </div>

      <button type="submit" class="btn-submit">Apply Stock Adjustment</button>
    </form>
  </div>

</div>

@endsection

@push('scripts')
<script>
var currentStock = {{ $product->current_stock }};
var selectedType = 'add';

function selectType(btn) {
  document.querySelectorAll('.type-btn').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active');
  selectedType = btn.getAttribute('data-type');
  document.getElementById('adjustment_type').value = selectedType;
  updatePreview();
}

function updatePreview() {
  var qty = parseInt(document.getElementById('quantity').value) || 0;
  var newVal = currentStock;
  if (selectedType === 'add')      newVal = currentStock + qty;
  if (selectedType === 'subtract') newVal = Math.max(0, currentStock - qty);
  if (selectedType === 'set')      newVal = qty;

  var box = document.getElementById('preview-box');
  var numEl = document.getElementById('preview-new');

  if (qty > 0 || selectedType === 'set') {
    box.classList.add('show');
    numEl.textContent = newVal;
    numEl.style.color = newVal > currentStock ? '#16a34a' : newVal < currentStock ? '#ef4444' : '#1e293b';
  } else {
    box.classList.remove('show');
  }
}

document.getElementById('quantity').addEventListener('input', updatePreview);
</script>
@endpush