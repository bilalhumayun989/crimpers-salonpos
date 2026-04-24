@extends("layouts.app")
@section("title", "Edit Coupon")
@section("content")
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
.f-input{width:100%;padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:.875rem;font-family:"Outfit",sans-serif;color:#1e293b;background:#fafafa;outline:none;transition:.2s;}
.f-input:focus{border-color:#22c55e;background:#fff;box-shadow:0 0 0 3px rgba(34,197,94,.1);}
textarea.f-input{resize:vertical;min-height:80px;}
.f-prefix-wrap{position:relative;}
.f-prefix{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:.82rem;font-weight:600;color:#94a3b8;pointer-events:none;white-space:nowrap;}
.f-input.has-prefix{padding-left:46px;}
.check-row{display:flex;align-items:center;gap:8px;cursor:pointer;}
.check-row input[type=checkbox]{width:15px;height:15px;accent-color:#16a34a;cursor:pointer;}
.check-label{font-size:.875rem;font-weight:600;color:#374151;}
.form-footer{padding:18px 26px;border-top:1px solid #f1f5f9;display:flex;gap:10px;justify-content:flex-end;}
.btn-cancel{padding:10px 22px;border:1.5px solid #e2e8f0;background:#fff;border-radius:10px;color:#64748b;font-size:.875rem;font-weight:600;cursor:pointer;text-decoration:none;font-family:"Outfit",sans-serif;transition:.2s;}
.btn-cancel:hover{border-color:#fca5a5;color:#dc2626;background:#fef2f2;}
.btn-save{padding:10px 22px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:10px;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:"Outfit",sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(34,197,94,.25);}
.btn-save:hover{transform:translateY(-1px);}
.error-msg{font-size:.75rem;color:#dc2626;margin-top:4px;}
.danger-zone{margin-top:20px;background:#fff;border:1px solid #fecaca;border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;}
.danger-title{font-size:.875rem;font-weight:700;color:#b91c1c;margin-bottom:2px;}
.danger-sub{font-size:.75rem;color:#94a3b8;}
.btn-danger{padding:8px 16px;border:1.5px solid #fca5a5;background:#fef2f2;border-radius:9px;color:#dc2626;font-size:.8rem;font-weight:700;cursor:pointer;font-family:"Outfit",sans-serif;transition:.2s;}
.btn-danger:hover{background:#fee2e2;}
</style>
<div class="form-wrap">
  <div class="form-header">
    <a href="{{ route("promotions.coupons") }}" class="back-btn"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
    <div><div class="form-title">Edit Coupon</div><div class="form-sub">{{ $coupon->code }} - {{ $coupon->name }}</div></div>
  </div>
  <div class="form-card">
    <form action="{{ route("promotions.coupons.update", $coupon) }}" method="POST">
      @csrf @method("PUT")
      <div class="form-section">
        <div class="section-title"><div class="section-icon" style="background:#f0fdf4;color:#22c55e;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/></svg></div>Coupon Details</div>
        <div class="f-grid-2" style="margin-bottom:14px;">
          <div><label class="f-label">Coupon Code</label><input type="text" name="code" value="{{ old("code",$coupon->code) }}" required class="f-input" style="text-transform:uppercase;">@error("code")<div class="error-msg">{{ $message }}</div>@enderror</div>
          <div><label class="f-label">Coupon Name</label><input type="text" name="name" value="{{ old("name",$coupon->name) }}" required class="f-input">@error("name")<div class="error-msg">{{ $message }}</div>@enderror</div>
        </div>
        <div><label class="f-label">Description</label><textarea name="description" class="f-input">{{ old("description",$coupon->description) }}</textarea>@error("description")<div class="error-msg">{{ $message }}</div>@enderror</div>
      </div>
      <div class="form-section">
        <div class="section-title"><div class="section-icon" style="background:#eff6ff;color:#3b82f6;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></div>Discount Settings</div>
        <div class="f-grid-2" style="margin-bottom:14px;">
          <div><label class="f-label">Discount Type</label><select name="type" id="type" required class="f-input"><option value="percentage" {{ old("type",$coupon->type)==="percentage"?"selected":"" }}>Percentage (%)</option><option value="fixed_amount" {{ old("type",$coupon->type)==="fixed_amount"?"selected":"" }}>Fixed Amount ($)</option></select>@error("type")<div class="error-msg">{{ $message }}</div>@enderror</div>
          <div><label class="f-label">Discount Value</label><div class="f-prefix-wrap"><span class="f-prefix" id="value-prefix">{{ $coupon->type==="percentage"?"%":"$" }}</span><input type="number" name="value" step="0.01" min="0" value="{{ old("value",$coupon->value) }}" required class="f-input has-prefix"></div>@error("value")<div class="error-msg">{{ $message }}</div>@enderror<div class="f-hint" id="value-hint">{{ $coupon->type==="percentage"?"Percentage off":"Fixed amount off" }}</div></div>
        </div>
        <div><label class="f-label">Minimum Purchase</label><div class="f-prefix-wrap" style="max-width:220px;"><span class="f-prefix">PKR</span><input type="number" name="minimum_purchase" step="0.01" min="0" value="{{ old("minimum_purchase",$coupon->minimum_purchase) }}" class="f-input has-prefix" placeholder="0.00"></div>@error("minimum_purchase")<div class="error-msg">{{ $message }}</div>@enderror</div>
      </div>
      <div class="form-section">
        <div class="section-title"><div class="section-icon" style="background:#fffbeb;color:#f59e0b;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>Limits &amp; Expiry</div>
        <div class="f-grid-3" style="margin-bottom:14px;">
          <div><label class="f-label">Total Usage Limit</label><input type="number" name="usage_limit" min="1" value="{{ old("usage_limit",$coupon->usage_limit) }}" class="f-input" placeholder="Unlimited">@error("usage_limit")<div class="error-msg">{{ $message }}</div>@enderror</div>
          <div><label class="f-label">Per Customer Limit</label><input type="number" name="usage_limit_per_customer" min="1" value="{{ old("usage_limit_per_customer",$coupon->usage_limit_per_customer) }}" class="f-input" placeholder="Unlimited">@error("usage_limit_per_customer")<div class="error-msg">{{ $message }}</div>@enderror</div>
          <div><label class="f-label">Valid Until</label><input type="date" name="valid_until" value="{{ old("valid_until",$coupon->valid_until) }}" class="f-input">@error("valid_until")<div class="error-msg">{{ $message }}</div>@enderror</div>
        </div>
        <label class="check-row"><input type="checkbox" name="is_active" value="1" {{ old("is_active",$coupon->is_active)?"checked":"" }}><span class="check-label">Active - coupon can be used</span></label>
      </div>
      <div class="form-footer">
        <a href="{{ route("promotions.coupons") }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn-save">Save Changes</button>
      </div>
    </form>
  </div>
  <div class="danger-zone">
    <div><div class="danger-title">Delete Coupon</div><div class="danger-sub">This action cannot be undone</div></div>
    <form method="POST" action="{{ route("promotions.coupons.destroy",$coupon) }}" onsubmit="return confirm("Delete this coupon?")">@csrf @method("DELETE")<button type="submit" class="btn-danger">Delete Coupon</button></form>
  </div>
</div>
<script>
const t=document.getElementById("type"),p=document.getElementById("value-prefix"),h=document.getElementById("value-hint");
t.addEventListener("change",function(){if(this.value==="percentage"){p.textContent="%";h.textContent="Percentage off";}else{p.textContent="$";h.textContent="Fixed amount off";}});
</script>
@endsection
