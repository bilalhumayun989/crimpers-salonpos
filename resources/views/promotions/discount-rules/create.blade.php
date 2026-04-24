@extends('layouts.app')
@section('title', 'New Discount Rule')
@section('content')
<style>
.form-wrap{max-width:700px;margin:0 auto;}
.form-header{display:flex;align-items:center;gap:12px;margin-bottom:24px;}
.back-btn{width:36px;height:36px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:.2s;flex-shrink:0;}
.back-btn:hover{border-color:#86efac;color:#16a34a;background:#f0fdf4;}
.form-title{font-size:1.4rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:3px;}
.form-sub{font-size:.85rem;color:#64748b;}
.form-card{background:#fff;border:1px solid #e8f5e9;border-radius:18px;box-shadow:0 2px 12px rgba(0,0,0,.05);overflow:hidden;}
.form-section{padding:22px 26px;border-bottom:1px solid #f1f5f9;}
.section-title{font-size:.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.section-icon{width:22px;height:22px;border-radius:6px;display:flex;align-items:center;justify-content:center;}
.f-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.f-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.f-label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:7px;}
.f-hint{font-size:.72rem;color:#94a3b8;margin-top:5px;}
.f-input{width:100%;padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:.875rem;font-family:'Outfit',sans-serif;color:#1e293b;background:#fafafa;outline:none;transition:.2s;}
.f-input:focus{border-color:#22c55e;background:#fff;box-shadow:0 0 0 3px rgba(34,197,94,.1);}
.f-input::placeholder{color:#9ca3af;}
textarea.f-input{resize:vertical;min-height:80px;}
.f-prefix-wrap{position:relative;}
.f-prefix{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:.82rem;font-weight:600;color:#94a3b8;pointer-events:none;white-space:nowrap;}
.f-input.has-prefix{padding-left:46px;}
.error-msg{font-size:.75rem;color:#dc2626;margin-top:4px;}
.check-row{display:flex;align-items:center;gap:8px;cursor:pointer;}
.check-row input[type=checkbox]{width:15px;height:15px;accent-color:#16a34a;cursor:pointer;}
.check-label{font-size:.875rem;font-weight:600;color:#374151;}

/* Type-specific panels */
.type-panel{display:none;margin-top:14px;}
.type-panel.show{display:block;}
.bxgy-panel{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px 16px;}
.bxgy-title{font-size:.72rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px;}

.form-footer{padding:18px 26px;border-top:1px solid #f1f5f9;display:flex;gap:10px;justify-content:flex-end;}
.btn-cancel{padding:10px 22px;border:1.5px solid #e2e8f0;background:#fff;border-radius:10px;color:#64748b;font-size:.875rem;font-weight:600;cursor:pointer;text-decoration:none;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-cancel:hover{border-color:#fca5a5;color:#dc2626;background:#fef2f2;}
.btn-save{padding:10px 22px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:10px;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(34,197,94,.25);}
.btn-save:hover{transform:translateY(-1px);}
</style>

<div class="form-wrap">
    <div class="form-header">
        <a href="{{ route('promotions.discount-rules') }}" class="back-btn">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <div>
            <div class="form-title">New Discount Rule</div>
            <div class="form-sub">Create an automated discount rule applied at checkout</div>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('promotions.discount-rules.store') }}" method="POST">
            @csrf

            {{-- Basic info --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon" style="background:#f5f3ff;color:#8b5cf6;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    </div>
                    Rule Details
                </div>
                <div class="f-grid-2" style="margin-bottom:14px;">
                    <div>
                        <label class="f-label">Rule Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="f-input" placeholder="e.g. Weekend 10% Off">
                        @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="f-label">Discount Type <span style="color:#ef4444;">*</span></label>
                        <select name="type" id="type" required class="f-input">
                            <option value="">Select type…</option>
                            <option value="percentage"          {{ old('type')==='percentage'?'selected':'' }}>Percentage Discount</option>
                            <option value="fixed_amount"        {{ old('type')==='fixed_amount'?'selected':'' }}>Fixed Amount</option>
                            <option value="buy_x_get_y"         {{ old('type')==='buy_x_get_y'?'selected':'' }}>Buy X Get Y</option>
                            <option value="first_time_customer" {{ old('type')==='first_time_customer'?'selected':'' }}>First Time Customer</option>
                            <option value="loyalty_points"      {{ old('type')==='loyalty_points'?'selected':'' }}>Loyalty Points</option>
                        </select>
                        @error('type')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="f-label">Description <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                    <textarea name="description" class="f-input" placeholder="Describe when this rule applies…">{{ old('description') }}</textarea>
                    @error('description')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Discount value --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon" style="background:#f0fdf4;color:#22c55e;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    </div>
                    Discount Value
                </div>

                {{-- Percentage / Fixed amount --}}
                <div id="value-field" style="display:none;">
                    <label class="f-label">Discount Value <span style="color:#ef4444;">*</span></label>
                    <div class="f-prefix-wrap" style="max-width:220px;">
                        <span class="f-prefix" id="value-prefix">%</span>
                        <input type="number" name="value" id="value" step="0.01" min="0" value="{{ old('value') }}" class="f-input has-prefix" placeholder="0">
                    </div>
                    @error('value')<div class="error-msg">{{ $message }}</div>@enderror
                    <div class="f-hint" id="value-hint">Enter percentage (e.g. 10 for 10% off)</div>
                </div>

                {{-- Buy X Get Y --}}
                <div id="buy-quantity-field" style="display:none;">
                    <div class="bxgy-panel">
                        <div class="bxgy-title">Buy X Get Y Settings</div>
                        <div class="f-grid-2">
                            <div>
                                <label class="f-label">Buy Quantity <span style="color:#ef4444;">*</span></label>
                                <input type="number" name="buy_quantity" id="buy_quantity" min="1" value="{{ old('buy_quantity') }}" class="f-input" placeholder="e.g. 2">
                                @error('buy_quantity')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="f-label">Get Quantity <span style="color:#ef4444;">*</span></label>
                                <input type="number" name="get_quantity" id="get_quantity" min="1" value="{{ old('get_quantity') }}" class="f-input" placeholder="e.g. 1">
                                @error('get_quantity')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- No extra fields needed --}}
                <div id="no-value-field" style="display:none;">
                    <div style="padding:12px 14px;background:#f8fafc;border:1px solid #f1f5f9;border-radius:10px;font-size:.82rem;color:#64748b;">
                        No additional value configuration needed for this rule type.
                    </div>
                </div>
            </div>

            {{-- Validity --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon" style="background:#fffbeb;color:#f59e0b;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    Validity Period
                </div>
                <div class="f-grid-2" style="margin-bottom:14px;">
                    <div>
                        <label class="f-label">Valid From <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <input type="date" name="valid_from" value="{{ old('valid_from') }}" class="f-input">
                        @error('valid_from')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="f-label">Valid Until <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <input type="date" name="valid_until" value="{{ old('valid_until') }}" class="f-input">
                        @error('valid_until')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                <label class="check-row">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="check-label">Active — rule applies at checkout immediately</span>
                </label>
            </div>

            <div class="form-footer">
                <a href="{{ route('promotions.discount-rules') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">Create Rule</button>
            </div>
        </form>
    </div>
</div>

<script>
const typeEl = document.getElementById('type');
const valueField = document.getElementById('value-field');
const buyField   = document.getElementById('buy-quantity-field');
const noField    = document.getElementById('no-value-field');
const valueInput = document.getElementById('value');
const buyInput   = document.getElementById('buy_quantity');
const getInput   = document.getElementById('get_quantity');
const prefixEl   = document.getElementById('value-prefix');
const hintEl     = document.getElementById('value-hint');

function updateFields() {
    const type = typeEl.value;
    valueField.style.display = 'none';
    buyField.style.display   = 'none';
    noField.style.display    = 'none';
    valueInput.required = false;
    buyInput.required   = false;
    getInput.required   = false;

    if (type === 'percentage' || type === 'fixed_amount') {
        valueField.style.display = 'block';
        valueInput.required = true;
        prefixEl.textContent = type === 'percentage' ? '%' : '$';
        hintEl.textContent   = type === 'percentage' ? 'Enter percentage (e.g. 10 for 10% off)' : 'Enter amount (e.g. 5.00 for $5 off)';
    } else if (type === 'buy_x_get_y') {
        buyField.style.display = 'block';
        buyInput.required = true;
        getInput.required = true;
    } else if (type === 'first_time_customer' || type === 'loyalty_points') {
        noField.style.display = 'block';
    }
}

typeEl.addEventListener('change', updateFields);
document.addEventListener('DOMContentLoaded', updateFields);
</script>
@endsection
