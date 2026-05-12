@extends('layouts.app')
@section('title', 'Payment')
@section('content')
<style>
/* ─── Flexible layout — expands downward as needed ─── */
.pay-wrap{display:flex;gap:18px;min-height:calc(85vh - 100px);margin-top:0;padding-bottom:40px;}

/* LEFT */
.pay-left{flex:1;display:flex;flex-direction:column;background:#fff;border-radius:18px;border:1.5px solid #f0e8a0;box-shadow:0 4px 20px rgba(0,0,0,.04);min-height:680px;}
.pay-left-hd{padding:11px 16px;border-bottom:1px solid #f4f4f5;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
.pay-left-title{font-size:.85rem;font-weight:800;color:#18181b;display:flex;align-items:center;gap:7px;}
.cust-pill{background:#fffdf0;color:#a07800;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;border:1px solid #F7DF79;}

.items-list{flex:1;overflow-y:auto;padding:15px 20px;min-height:0;}
.pay-item{display:flex;align-items:center;gap:15px;padding:15px 20px;border-radius:18px;border:1.5px solid #f1f5f9;background:#fff;margin-bottom:12px;transition:.2s;box-shadow:0 2px 5px rgba(0,0,0,.02);}
.pay-item:hover{border-color:#F7DF79;background:#fffdf0;transform:scale(1.01);}
.pay-iicon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.pay-iicon.svc{background:#fffdf0;color:#c9a800;}
.pay-iicon.pkg{background:#eef2ff;color:#6366f1;}
.pay-iicon.prd{background:#fefce8;color:#ca8a04;}
.pay-iinfo{flex:1;min-width:0;}
.pay-iname{font-size:.95rem;font-weight:800;color:#18181b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.pay-imeta{font-size:.78rem;color:#94a3b8;margin-top:3px;}
.qty-ctrl{display:flex;align-items:center;border:2px solid #e2e8f0;border-radius:12px;overflow:hidden;flex-shrink:0;background:#f8fafc;}
.qty-btn{width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:none;border:none;cursor:pointer;font-size:1.2rem;color:#64748b;transition:.2s;font-weight:700;}
.qty-btn:hover{background:#F7DF79;color:#18181b;}
.qty-num{width:36px;text-align:center;font-size:.95rem;font-weight:800;color:#18181b;}
.pay-iprice{font-size:1.1rem;font-weight:900;color:#c9a800;min-width:100px;text-align:right;flex-shrink:0;}
.pay-item.pkg-item .pay-iprice{color:#6366f1;}

.totals-strip{border-top:1px solid #f4f4f5;padding:10px 16px;background:#fff;flex-shrink:0;}
.t-row{display:flex;justify-content:space-between;font-size:.75rem;color:#71717a;margin-bottom:4px;}
.t-row .v{font-weight:600;color:#3f3f46;}
.t-total{display:flex;justify-content:space-between;align-items:center;background:#fffdf0;border:1.5px solid #F7DF79;border-radius:10px;padding:9px 13px;margin-top:6px;}
.t-total-lbl{font-size:.82rem;font-weight:700;color:#18181b;}
.t-total-val{font-size:1.3rem;font-weight:800;color:#c9a800;}

/* RIGHT */
.pay-right{width:420px;min-width:420px;background:#fff;border-radius:18px;border:1.5px solid #f0e8a0;box-shadow:0 4px 20px rgba(0,0,0,.04);display:flex;flex-direction:column;min-height:680px;}
.pay-right-hd{padding:11px 16px;border-bottom:1px solid #f4f4f5;flex-shrink:0;}
.pay-right-title{font-size:.85rem;font-weight:800;color:#18181b;display:flex;align-items:center;gap:7px;}
.pay-right-body{flex:1;overflow-y:auto;padding:12px;min-height:0;}

.f-lbl{font-size:.7rem;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px;display:block;}
.f-grp{margin-bottom:18px;}
.f-prewrap{position:relative;}
.f-pre{position:absolute;left:10px;top:50%;transform:translateY(-50%);font-weight:700;color:#a1a1aa;font-size:.82rem;pointer-events:none;white-space:nowrap;}
.f-input{width:100%;padding:12px 16px;border-radius:12px;border:1.5px solid #e2e8f0;font-size:.95rem;font-weight:600;font-family:inherit;color:#18181b;background:#fafafa;outline:none;transition:.2s;}
.f-input:focus{border-color:#F7DF79;background:#fff;box-shadow:0 0 0 4px rgba(247,223,121,.15);}
.f-input.pl{padding-left:54px;}

/* Method grid — single row, 3 buttons */
.method-grid{display:flex;gap:8px;margin-bottom:15px;}
.method-btn{flex:1;padding:12px 6px;border-radius:14px;border:1.5px solid #e2e8f0;background:#fff;font-size:.75rem;font-weight:800;cursor:pointer;font-family:inherit;color:#64748b;transition:.25s;display:flex;flex-direction:column;align-items:center;gap:6px;box-shadow:0 2px 4px rgba(0,0,0,.02);}
.method-btn svg{width:18px;height:18px;opacity:.6;}
.method-btn:hover{border-color:#F7DF79;background:#fffdf0;color:#c9a800;transform:translateY(-2px);}
.method-btn:hover svg{opacity:1;}
.method-btn.active{background:#FBEFBC;border-color:#c9a800;color:#7a5c00;box-shadow:0 4px 12px rgba(201,168,0,.15);}
.method-btn.active svg{opacity:1;}
.method-btn.split-btn.active{background:#eef2ff;border-color:#6366f1;color:#4338ca;box-shadow:0 4px 12px rgba(99,102,241,.15);}

/* Split panel */
.split-panel{background:#f5f3ff;border:1.5px solid #e0e7ff;border-radius:10px;padding:10px;margin-bottom:10px;display:none;}
.split-panel.show{display:block;}
.split-row{display:flex;align-items:center;gap:7px;margin-bottom:7px;}
.split-lbl{width:38px;font-size:.72rem;font-weight:700;color:#374151;flex-shrink:0;}
.split-inp{flex:1;padding:7px 10px;border:1.5px solid #e0e7ff;border-radius:7px;font-size:.82rem;font-family:inherit;color:#18181b;background:#fff;outline:none;transition:.2s;}
.split-inp:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.1);}
.split-rem{font-size:.7rem;font-weight:700;text-align:right;margin-top:3px;}
.split-rem.ok{color:#c9a800;}
.split-rem.warn{color:#ef4444;}

/* Change box */
.chg-box{margin-top:7px;padding:9px 12px;background:#fffdf0;border:1.5px dashed #F7DF79;border-radius:9px;display:none;align-items:center;justify-content:space-between;}
.chg-box.show{display:flex;}
.chg-lbl{font-size:.65rem;font-weight:700;color:#c9a800;text-transform:uppercase;letter-spacing:.06em;}
.chg-val{font-size:1rem;font-weight:800;color:#a07800;}

/* Footer */
.pay-foot{padding:10px 12px;border-top:1px solid #f4f4f5;flex-shrink:0;display:flex;gap:8px;}
.btn-back{background:#f4f4f5;color:#52525b;padding:9px 14px;border-radius:9px;text-decoration:none;font-weight:700;border:none;cursor:pointer;transition:.2s;font-family:inherit;font-size:.8rem;display:flex;align-items:center;gap:5px;white-space:nowrap;}
.btn-back:hover{background:#e4e4e7;color:#18181b;}
.btn-confirm{flex:1;background:linear-gradient(135deg,#F7DF79,#c9a800);color:#18181b;padding:12px;border-radius:12px;font-weight:900;font-size:.95rem;border:none;cursor:pointer;transition:.25s;font-family:inherit;box-shadow:0 6px 20px rgba(201,168,0,.3);text-transform:uppercase;letter-spacing:.02em;}
.btn-confirm:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(201,168,0,.45);}
.btn-confirm:active{transform:translateY(0);}
.btn-confirm:disabled{opacity:.5;cursor:not-allowed;transform:none;box-shadow:none;}

/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);backdrop-filter:blur(4px);z-index:300;display:none;align-items:center;justify-content:center;padding:20px;}
.modal-box{background:#fff;border-radius:18px;padding:28px 24px;max-width:380px;width:100%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.15);}
.modal-icon{width:56px;height:56px;border-radius:50%;background:#FBEFBC;color:#c9a800;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.modal-title{font-size:1.2rem;font-weight:800;color:#18181b;margin-bottom:4px;}
.modal-sub{font-size:.82rem;color:#71717a;margin-bottom:18px;}
.modal-btn{display:flex;align-items:center;justify-content:center;gap:7px;padding:11px 16px;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;border:none;font-family:inherit;transition:.2s;width:100%;margin-bottom:7px;}
.modal-btn-print{background:#fffdf0;color:#c9a800;border:1.5px solid #F7DF79 !important;}
.modal-btn-print:hover{background:#FBEFBC;}
.modal-done{background:none;border:none;font-size:.68rem;font-weight:700;color:#a1a1aa;text-transform:uppercase;letter-spacing:.08em;cursor:pointer;font-family:inherit;}
.modal-done:hover{color:#71717a;}
</style>

<div class="pay-wrap">

  {{-- LEFT: Items --}}
  <div class="pay-left">
    <div class="pay-left-hd">
      <div class="pay-left-title">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
        Order Summary
      </div>
      <span class="cust-pill" id="cust-pill">Walk-in Customer</span>
    </div>

    <div class="items-list" id="items-list">
      <p style="text-align:center;color:#94a3b8;padding:30px 0;font-size:.85rem;">Loading order...</p>
    </div>

    <div class="totals-strip">
      <div class="t-row"><span>Subtotal</span><span class="v" id="t-sub">PKR 0.00</span></div>
      <div class="t-row"><span>Tax (5%)</span><span class="v" id="t-tax">PKR 0.00</span></div>
      <div class="t-row" id="t-disc-row" style="display:none;"><span>Discount</span><span class="v" style="color:#ef4444;" id="t-disc">-PKR 0.00</span></div>
      <div class="t-total">
        <span class="t-total-lbl">Total Payable</span>
        <span class="t-total-val" id="t-total">PKR 0.00</span>
      </div>
    </div>
  </div>

  {{-- RIGHT: Payment --}}
  <div class="pay-right">
    <div class="pay-right-hd">
      <div class="pay-right-title">Payment Details</div>
    </div>

    <div class="pay-right-body">
      <div id="pos-error-alert" style="display:none; background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 12px; margin-bottom: 15px; font-weight: 600; font-size: 0.85rem; align-items: center; gap: 10px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span id="pos-error-text"></span>
      </div>

      <div class="f-grp">
        <span class="f-lbl">Performed By (Staff)</span>
        <select id="pay-staff" class="f-input">
            <option value="">Select Employee</option>
            @foreach($staff as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
      </div>

      <div class="f-grp">
        <span class="f-lbl">Customer Rating</span>
        <div style="display:flex; gap:10px; padding:10px; background:#fffdf8; border:1.5px solid #F7DF79; border-radius:10px; justify-content:center;">
            @for($i=1; $i<=5; $i++)
            <label style="cursor:pointer; display:flex; flex-direction:column; align-items:center;">
                <input type="radio" name="pay-rating" value="{{ $i }}" {{ $i==5 ? 'checked' : '' }} style="margin-bottom:4px;">
                <span style="font-size:0.8rem; font-weight:700; color:#c9a800;">{{ $i }}★</span>
            </label>
            @endfor
        </div>
      </div>

      <div class="f-grp">
        <span class="f-lbl">Discount Amount (PKR)</span>
        <div class="f-prewrap">
          <span class="f-pre">PKR</span>
          <input type="number" id="pay-disc" class="f-input pl" placeholder="0.00" min="0" step="1">
        </div>
      </div>

      <div class="f-grp">
        <span class="f-lbl">Payment Method</span>
        <div class="method-grid">
          <button class="method-btn active" data-method="cash">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Cash
          </button>
          <button class="method-btn" data-method="card">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Card
          </button>
          <button class="method-btn split-btn" data-method="split">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 3h5v5M4 20L21 3M21 16v5h-5"/></svg>
            Split
          </button>
        </div>
      </div>

      {{-- Cash group --}}
      <div class="f-grp" id="cash-group">
        <span class="f-lbl">Cash Given by Customer</span>
        <div class="f-prewrap">
          <span class="f-pre">PKR</span>
          <input type="number" id="pay-cash" class="f-input pl" placeholder="0.00" step="0.01">
        </div>
        <div class="chg-box" id="chg-box">
          <span class="chg-lbl">Change to Return</span>
          <span class="chg-val" id="chg-val">PKR 0.00</span>
        </div>
      </div>

      {{-- Card group --}}
      <div class="f-grp" id="card-group" style="display:none;">
        <span class="f-lbl">Amount Received via Card</span>
        <div class="f-prewrap">
          <span class="f-pre">PKR</span>
          <input type="number" id="pay-card-amount" class="f-input pl" placeholder="0.00" step="0.01">
        </div>
        <div class="chg-box" id="card-chg-box">
          <span class="chg-lbl">Change to Return</span>
          <span class="chg-val" id="card-chg-val">PKR 0.00</span>
        </div>
      </div>

      {{-- Split group --}}
      <div class="split-panel" id="split-panel">
        <div style="font-size:.7rem;font-weight:700;color:#6366f1;text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px;">Split Payment</div>
        <div class="split-row">
          <span class="split-lbl">Cash</span>
          <input type="number" id="split-cash" class="split-inp" placeholder="0.00" min="0" step="0.01">
        </div>
        <div class="split-row">
          <span class="split-lbl">Card</span>
          <input type="number" id="split-card" class="split-inp" placeholder="0.00" min="0" step="0.01">
        </div>
        <div class="split-rem" id="split-rem"></div>
        <div class="chg-box" id="split-chg-box" style="margin-top:7px;">
          <span class="chg-lbl">Change to Return</span>
          <span class="chg-val" id="split-chg-val">PKR 0.00</span>
        </div>
      </div>

    </div>

    <div class="pay-foot">
      <a href="{{ route('pos.index') }}" class="btn-back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Back
      </a>
      <button class="btn-confirm" id="btn-confirm">Complete Payment</button>
    </div>
  </div>

</div>

{{-- Success Modal --}}
<div class="modal-overlay" id="invoice-modal">
  <div class="modal-box">
    <div class="modal-icon">
      <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <div class="modal-title">Payment Complete!</div>
    <div class="modal-sub" id="modal-inv-no">Invoice #-</div>
    {{-- USER DEMAND: "no recept" - Removing print receipt trigger --}}
    <button class="modal-done" id="close-modal" style="margin-top:20px;">Done &amp; New Order</button>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  var raw = localStorage.getItem('pos_checkout_session');
  if (!raw) {
    alert('No active order session. Returning to POS...');
    window.location.href = "{{ route('pos.index') }}";
    return;
  }

  var session = JSON.parse(raw);
  var cart    = session.cart || [];
  var currentDiscount = session.discount || 0;
  var currentMethod   = 'cash';

  // Customer
  document.getElementById('cust-pill').textContent = session.customerName || 'Walk-in Customer';
  if (currentDiscount > 0) document.getElementById('pay-disc').value = currentDiscount;

  // ─── Helpers ───────────────────────────────────────────
  function getSubtotal() {
    return cart.reduce(function(s, i){ return s + i.sub; }, 0);
  }

  function getPayable() {
    var sub  = getSubtotal();
    var tax  = sub * 0.05;
    var pay  = sub + tax - currentDiscount;
    if (pay < 0) pay = 0;
    return { sub: sub, tax: tax, pay: pay };
  }

  function updateTotals() {
    var r = getPayable();
    document.getElementById('t-sub').textContent   = 'PKR ' + r.sub.toFixed(2);
    document.getElementById('t-tax').textContent   = 'PKR ' + r.tax.toFixed(2);
    document.getElementById('t-total').textContent = 'PKR ' + r.pay.toFixed(2);

    if (currentDiscount > 0) {
      document.getElementById('t-disc-row').style.display = 'flex';
      document.getElementById('t-disc').textContent = '-PKR ' + currentDiscount.toFixed(2);
    } else {
      document.getElementById('t-disc-row').style.display = 'none';
    }

    if (currentMethod === 'cash') {
      var given = parseFloat(document.getElementById('pay-cash').value) || 0;
      var box   = document.getElementById('chg-box');
      if (given >= r.pay && given > 0) {
        box.classList.add('show');
        document.getElementById('chg-val').textContent = 'PKR ' + (given - r.pay).toFixed(2);
      } else {
        box.classList.remove('show');
      }
    }

    if (currentMethod === 'card') {
      var given = parseFloat(document.getElementById('pay-card-amount').value) || 0;
      var box   = document.getElementById('card-chg-box');
      if (given >= r.pay && given > 0) {
        box.classList.add('show');
        document.getElementById('card-chg-val').textContent = 'PKR ' + (given - r.pay).toFixed(2);
      } else {
        box.classList.remove('show');
      }
    }

    if (currentMethod === 'split') {
      var cash2 = parseFloat(document.getElementById('split-cash').value) || 0;
      var card2 = parseFloat(document.getElementById('split-card').value) || 0;
      var rem   = r.pay - cash2 - card2;
      var remEl = document.getElementById('split-rem');
      var sBox  = document.getElementById('split-chg-box');
      if (rem <= 0.001) {
        remEl.textContent = 'Fully covered!';
        remEl.className = 'split-rem ok';
        if (rem < -0.001) {
            sBox.classList.add('show');
            document.getElementById('split-chg-val').textContent = 'PKR ' + Math.abs(rem).toFixed(2);
        } else {
            sBox.classList.remove('show');
        }
      } else {
        remEl.textContent = 'Remaining: PKR ' + rem.toFixed(2);
        remEl.className = 'split-rem warn';
        sBox.classList.remove('show');
      }
    }
  }

  // ─── Render items ───────────────────────────────────────
  function svgFor(type) {
    if (type === 'package') return '<svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>';
    if (type === 'service') return '<svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>';
    return '<svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2"/><path d="M16 7V5a2 2 0 00-4 0v2M8 7V5a2 2 0 00-4 0v2"/></svg>';
  }

  function renderItems() {
    var list = document.getElementById('items-list');
    list.innerHTML = '';
    if (!cart.length) {
      list.innerHTML = '<p style="text-align:center;color:#94a3b8;padding:30px 0;font-size:.85rem;">No items in order.</p>';
      updateTotals(); return;
    }

    cart.forEach(function(item, idx) {
      var typeLabel = item.type === 'package' ? 'Package' : item.type === 'service' ? 'Service' : 'Product';
      var iconCls   = item.type === 'package' ? 'pkg' : item.type === 'service' ? 'svc' : 'prd';
      var row = document.createElement('div');
      row.className = 'pay-item' + (item.type === 'package' ? ' pkg-item' : '');
      row.innerHTML =
        '<div class="pay-iicon ' + iconCls + '">' + svgFor(item.type) + '</div>' +
        '<div class="pay-iinfo">' +
          '<div class="pay-iname">' + item.name + '</div>' +
          '<div class="pay-imeta">' + typeLabel + ' &bull; PKR ' + item.price.toFixed(2) + ' each</div>' +
        '</div>' +
        '<div class="qty-ctrl">' +
          '<button class="qty-btn" data-action="dec" data-idx="' + idx + '">&#8722;</button>' +
          '<span class="qty-num" id="q-' + idx + '">' + item.qty + '</span>' +
          '<button class="qty-btn" data-action="inc" data-idx="' + idx + '">&#43;</button>' +
        '</div>' +
        '<div class="pay-iprice" id="p-' + idx + '">PKR ' + item.sub.toFixed(2) + '</div>';
      list.appendChild(row);
    });

    list.querySelectorAll('.qty-btn').forEach(function(btn) {
      btn.onclick = function() {
        var idx    = parseInt(btn.getAttribute('data-idx'));
        var action = btn.getAttribute('data-action');
        if (action === 'inc') {
          cart[idx].qty++;
        } else {
          if (cart[idx].qty > 1) { cart[idx].qty--; }
          else { cart.splice(idx, 1); renderItems(); return; }
        }
        cart[idx].sub = cart[idx].qty * cart[idx].price;
        document.getElementById('q-' + idx).textContent = cart[idx].qty;
        document.getElementById('p-' + idx).textContent = 'PKR ' + cart[idx].sub.toFixed(2);
        updateTotals();
      };
    });

    updateTotals();
  }

  renderItems();

  // ─── Discount ───────────────────────────────────────────
  document.getElementById('pay-disc').addEventListener('input', function(e) {
    currentDiscount = parseFloat(e.target.value) || 0;
    updateTotals();
  });

  // ─── Payment method ─────────────────────────────────────
  document.querySelectorAll('.method-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.method-btn').forEach(function(b){ b.classList.remove('active'); });
      btn.classList.add('active');
      currentMethod = btn.getAttribute('data-method');
      document.getElementById('cash-group').style.display  = (currentMethod === 'cash')  ? 'block' : 'none';
      document.getElementById('card-group').style.display  = (currentMethod === 'card')  ? 'block' : 'none';
      document.getElementById('split-panel').classList.toggle('show', currentMethod === 'split');
      
      if (currentMethod !== 'cash') document.getElementById('chg-box').classList.remove('show');
      if (currentMethod !== 'card') document.getElementById('card-chg-box').classList.remove('show');
      if (currentMethod !== 'cash') document.getElementById('chg-box').classList.remove('show');
      updateTotals();
    });
  });

  document.getElementById('pay-cash').addEventListener('input', updateTotals);
  document.getElementById('pay-card-amount').addEventListener('input', updateTotals);
  document.getElementById('split-cash').addEventListener('input', updateTotals);
  document.getElementById('split-card').addEventListener('input', updateTotals);

  // ─── Confirm ────────────────────────────────────────────
  document.getElementById('btn-confirm').addEventListener('click', async function() {
    var r = getPayable();

    if (currentMethod === 'cash') {
      var given = parseFloat(document.getElementById('pay-cash').value) || 0;
      if (given < r.pay) {
        alert('Insufficient cash! Please enter the correct amount.'); return;
      }
    }
    if (currentMethod === 'card') {
      var cardAmt = parseFloat(document.getElementById('pay-card-amount').value) || 0;
      if (cardAmt < r.pay - 0.01) {
        alert('Card amount does not cover the full total!'); return;
      }
    }
    if (currentMethod === 'split') {
      var sc = parseFloat(document.getElementById('split-cash').value) || 0;
      var sk = parseFloat(document.getElementById('split-card').value) || 0;
      if (sc + sk < r.pay - 0.01) {
        alert('Split amounts do not cover the full total!'); return;
      }
    }

    var btn = document.getElementById('btn-confirm');
    btn.disabled = true; btn.textContent = 'Processing...';

    var payload = {
      items: cart.map(function(i){ return { id: i.id, type: i.type, name: i.name, price: i.price, quantity: i.qty, subtotal: i.sub }; }),
      payment_method: currentMethod,
      total_amount  : r.sub,
      tax           : r.tax,
      discount      : currentDiscount,
      payable_amount: r.pay,
      customer_name : session.customerName || 'Walk-in Customer',
      customer_phone: session.customerPhone || '',
      staff_id      : document.getElementById('pay-staff').value,
      rating        : (document.querySelector('input[name="pay-rating"]:checked') || {value: 5}).value
    };
    if (session.customer_id) payload.customer_id = session.customer_id;
    if (currentMethod === 'cash') {
      payload.cash_received = parseFloat(document.getElementById('pay-cash').value) || 0;
      payload.change_returned = payload.cash_received - r.pay;
    } else if (currentMethod === 'card') {
      payload.cash_received = parseFloat(document.getElementById('pay-card-amount').value) || 0;
      payload.change_returned = payload.cash_received - r.pay;
    } else if (currentMethod === 'split') {
      payload.split_cash = parseFloat(document.getElementById('split-cash').value) || 0;
      payload.split_card = parseFloat(document.getElementById('split-card').value) || 0;
      payload.cash_received = payload.split_cash + payload.split_card;
      payload.change_returned = payload.cash_received - r.pay;
    }

    if (payload.change_returned < 0) payload.change_returned = 0;

    try {
      // Hide error alert before starting
      document.getElementById('pos-error-alert').style.display = 'none';

      var res  = await fetch("{{ route('pos.store') }}", {
        method : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body   : JSON.stringify(payload)
      });
      var data = await res.json();
      if (data.success) {
        document.getElementById('modal-inv-no').textContent = 'Invoice #' + data.invoice.invoice_no;
        document.getElementById('invoice-modal').style.display = 'flex';
      } else {
        showPosError(data.message || 'Payment failed. Please check the amounts.');
        btn.disabled = false; btn.textContent = 'Complete Payment';
      }
    } catch(e) {
        console.error('Network/Logic Error:', e);
        showPosError('An unexpected error occurred. If you entered an extremely large number, please try a smaller one.');
        btn.disabled = false; btn.textContent = 'Complete Payment';
    }
  });

  function showPosError(msg) {
    const errDiv = document.getElementById('pos-error-alert');
    const errText = document.getElementById('pos-error-text');
    errText.textContent = msg;
    errDiv.style.display = 'flex';
    errDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  document.getElementById('close-modal').onclick = function() {
    localStorage.removeItem('pos_checkout_session');
    window.location.href = "{{ route('pos.index') }}";
  };

});
</script>
@endpush
